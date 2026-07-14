<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;


    protected $redirectTo = '/home';


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function username()
    {
        return 'email';
    }


    protected function authenticated(Request $request, $user)
    {
        if ($user->role == 'admin') {
            return redirect('/data-pengaduan');
        }

        return redirect('/dashboard');
    }
}