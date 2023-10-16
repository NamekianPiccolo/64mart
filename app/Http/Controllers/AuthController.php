<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    function index()
    {
        return view('auth.index');
    }
    function login(Request $request)
    {
        $request->validate(
            [
                'username' => 'required',
                'password' => 'required',
            ],
            [
                'username.required' => 'Username harus diisi',
                'password.required' => 'Password harus diisi',
            ]
        );

        $infologin = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($infologin)) {
            if (Auth::user()->role == "admin") {
                return redirect('admin');
            } else if (Auth::user()->role == "owner") {
                return redirect('owner');
            } else if (Auth::user()->role == "kasir") {
                return redirect('kasir');
            }
        } else {
            return redirect(route('login'))->withErrors('Username dan password yang dimasukkan tidak sesuai')->withInput();
        }
    }

    function regist()
    {
        return view('auth.regist');
    }

    function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|min:5|max:255',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:5|max:255',
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);
        // $validatedData['password'] = Hash::make($validatedData['password']);

        User::create($validatedData);

        return redirect(route('login'))->with('success', 'Registration successfull! Please login');
    }

    function logout()
    {
        Auth::logout();
        return redirect('');
    }
}
