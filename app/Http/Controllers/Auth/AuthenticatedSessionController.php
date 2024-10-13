<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;



class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        // return response()->json(['data' => 1], 500);
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'device' => 'required'
        ]); 

        if ($validator->fails()) {
            return response()->json(
                [
                    "errors" => $validator->messages()
                ], 422
            );
        }
        
        // $request->validate([
        //     'email' => 'required|email',
        //     'password' => 'required',
        //     'device' => 'required'
        // ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            // throw ValidationException::withMessages([
            //     'email' => ['The provided credentials are incorrect.'],
            // ]);
            return response()->json([
                "errors" => [
                    'email' => 'The provided credentials are incorrect.',
                ]
            ], 422);
        }

        return response()->json([
            "token" => $user->createToken($request->device)->plainTextToken
        ], 200);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {

        $request->user()->currentAccessToken()->delete();
        return response()->noContent();
    }
}
