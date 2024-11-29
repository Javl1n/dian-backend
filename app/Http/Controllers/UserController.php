<?php

namespace App\Http\Controllers;

use App\Models\Interest;
use App\Models\Room;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;
use Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(User::whereNot('id', $request->user()->id)->get(), 200);
    }

    public function update(Request $request)
    {   
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'bio' => 'string',
            'password' => 'same:password_confirmation',
            'password_confirmation' => 'required_with:password',
            'gender' => 'required|boolean',
            'interests' => 'array',
            'interests.*' => 'string',
            // 'birthdate' => 'string',
        ]);

        
        // return error if validation fails
        if ($validator->fails()) {
            // return response($validator->errors(), 500);
            return response()->json([
                "errors" => $validator->messages()
            ], 422);
        }

        $user = $request->user();
            
        if (isset($request->password)) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }
            
        
        $user->update([
            'name' => $request->name,
            'bio' => $request->bio,
            'gender' => $request->gender,
        ]);

        if(isset($request->birthdate)) {
            $birthdate = Carbon::createFromFormat('Y-m-d', $request->birthdate);
            $user->update([
                'birthdate' => $birthdate,
            ]);
        }

        $user->interests()->detach();

        foreach($request->interests as $interest) {
            if ($interestObject = Interest::where('name', $interest)->first()) {
                $interestObject->users()->attach($user->id);
            } else {
                $interestNewObject = Interest::create([
                    'name' => $interest,
                ]);

                $interestNewObject->users()->attach($user->id);
            }
        }

        return response()->noContent(200);
    }

    public function pair(Request $request)
    {   
        $request->validate([
            'follow' => [
                'string',
                Rule::in(['follow', 'unfollow'])
            ],
            'person' => ['integer']
        ]);

        $status = $request->follow === 'follow' ? true : false;

        $user = $request->user();

        $person = User::findOrFail($request->person);
        
        $pair = $user->following()->where('following_id', $person->id)->first();

        if (!$pair) {
            $pair = $user->following()->create([
                'following_id' => $person->id,
                'status' => $status
            ]);

            $createRoom = $status;
        } else {
            if ($pair->status == $status) {
                $pair->delete();

                $createRoom = false;
            } else {
                $pair->update([
                    'status' => $status
                ]);

                $createRoom = $status;
            }
        }

        // after following the user, check if the user is following you, then create a room,
        // check if a room already exists
        $otherPair = $person->following->where('following_id', $user->id)->first();

        if ($otherPair && $otherPair->status && $createRoom) {
            $code = collect([$user->id, $person->id])->sort()->implode('.');
            $room = Room::where('code', $code)->first();
            if (!$room) {
                Room::create([
                    'code' => $code
                ])->participants()->createMany([
                    [
                        'user_id' => $user->id
                    ],
                    [
                        'user_id' => $person->id
                    ]
                ]);
            }
        }
        
        return response()->noContent(200);
    }
}
