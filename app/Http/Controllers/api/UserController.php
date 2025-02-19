<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'nom' =>'required|max:255',
            'prenom' =>'required|max:255',
            'tel' =>'numeric',
            'email' =>'required|email|max:255|unique:users',
            'password' =>'required',
        ]);

        $user = User::create([
            "nom" => $request->nom,
            "prenom" => $request->prenom,
            "tel" => $request->tel,
            "email" => $request->email,
            "password" => bcrypt($request->password),
        ]);

        return response()->json([
            "message" => "User Created",
            "user"    => $user,
        ]);
    }

    public function login(Request $request) {
        $request->validate([
            'email' =>'required|email',
            'password' =>'required',
        ]);


        $user = User::where("email", $request->email)
            ->where("password", bcrypt($request->password))
            ->first();

        return response()->json([
            "message" => "You are logged in",
            "user" => $user,
        ]);
    }
}
