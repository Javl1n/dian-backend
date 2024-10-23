<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(User::whereNot('id', $request->user()->id)->get(), 200);
    }
}
