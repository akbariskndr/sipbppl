<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('content.login');
    }

    public function login(Request $request)
    {
        $userData = $request->all();

        if (Auth::attempt(['username' => $userData['username'], 'password' => $userData['password'], 'status' => 1])) {
            return redirect('/dashboard');
        }

        return back()->with('alert', 'Anda memasukkan Username atau Password yang salah!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('login');
    }
}
