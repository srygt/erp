<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function LoginPost(Request $request)
    {
       if( Auth::attempt(['username'=>$request->username,'password'=>$request->password])){
           return redirect()->route('home');
       }

       return redirect()->route('Login')->withErrors('Giriş Bilgileriniz Hatalı');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('Login');
    }

    public function redirectToLogin()
    {
        return redirect()->route('Login');
    }
}
