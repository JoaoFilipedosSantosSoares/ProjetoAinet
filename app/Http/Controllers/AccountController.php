<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        return view('account.index');
    }

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
