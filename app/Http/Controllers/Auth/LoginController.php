<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
    /**
     * proses pemisahan akses halaman berdasarkan role
     *
     * @param  \Illuminate\Http\Request  $request
     * @param model $user
     * @return void
     */
    public function authenticated(Request $request, $user)
    {
        if (
            $user->hasRole('user')
        ) {
            $this->logout($request);
            toast('you don\'t have acces this page', 'error');
            return back();
        }
        return redirect()->intended();
        // return redirect()->route('home');
    }
}
