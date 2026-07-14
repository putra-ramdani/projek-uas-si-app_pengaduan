<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }


    protected function authenticated($request, $user)
    {

        if ($user->role == 'admin') {

            return redirect()->route('admin.dashboard');

        } elseif ($user->role == 'teknisi') {

            return redirect()->route('teknisi.dashboard');

        } else {

            return redirect()->route('user.dashboard');

        }

    }
}