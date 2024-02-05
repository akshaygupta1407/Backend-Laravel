<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function index()
    {
        return User::all();
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:3|max:20',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $userExists = User::where('email',$data['email'])->exists();

        if($userExists)
        {
            return response()->json(['message' => 'User already Exists! Try Login.'], 402);
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        return response()->json(['message' => 'User created successfully'], 201);
    }
}
