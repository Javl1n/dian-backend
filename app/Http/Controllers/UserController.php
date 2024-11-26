<?php

namespace App\Http\Controllers;

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
            'password' => 'same:password_confirmation',
            'password_confirmation' => 'required_with:password',
        ]);

        $birthdate = Carbon::createFromFormat('Y-m-d', $request->birth_date);

        // return error if validation fails
        if ($validator->fails()) {
            return response()->json(
                [
                    "errors" => $validator->messages()
                ], 422);
        }

        if (isset($request->password)) {
            $request->user()->update([
                'password' => Hash::make($request->password)
            ]);
        }

        $request->user()->update([
            'name' => $request->name
        ]);
        
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
