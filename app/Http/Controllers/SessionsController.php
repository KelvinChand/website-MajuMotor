<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class SessionsController extends Controller
{
    public function create()
    {
        return view('session.login-session');
    }

    public function store()
    {
        $attributes = request()->validate(rules: [
            'username'=>'required|string',
            'password'=>'required'
        ]);
        Log::info("Berhasil");

        if(Auth::attempt(credentials: $attributes))
        {
            Log::info("Masuk");
            session()->regenerate();
            return redirect(to: 'dashboard')->with(key: ['success'=>'You are logged in.']);
        }
        else{
            Log::info("Gagal");
            return back()->withErrors(provider: ['username'=>'Username or password invalid.']);
        }
    }

    public function destroy()
    {

        Auth::logout();

        return redirect(to: '/login');
    }
}
