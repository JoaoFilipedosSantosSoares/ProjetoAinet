<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function login()
    {
        return view('account.login.index');
    }

    public function register()
    {
        return view('account.register.index');
    }

    public function forgotPassword()
    {
        return view('account.login.forgot-password');
    }
}