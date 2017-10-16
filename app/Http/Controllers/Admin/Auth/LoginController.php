<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // 登录界面
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }


    public function logout()
    {
        $this->guard('admin')->logout();

        return redirect()->route('admin.login');
    }


    /**
     * 自定义认证驱动
     * @author smallnews
     */
    protected function guard()
    {
        return auth()->guard('admin');
    }
}
