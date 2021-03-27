<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    } // End Construct Method

    public function viewLogin()
    {
        return view('dashboard.auth.login');
    } // End View Login Form

    public function field()
    {
        if (filter_var(request()->username, FILTER_VALIDATE_EMAIL))
            return 'email';

        if (is_numeric(request()->username))
            return 'phone';

        return 'name';
    } // End Check Field [ User Name || Phone || Email ]

    public function login()
    {
        if (app('router')->getRoutes()->match(app('request'))->uri() == 'admin/login')
            $info = ['admin', RouteServiceProvider::DASHBOARD];
        else
            $info = ['user', RouteServiceProvider::HOME];

        if (Auth::guard($info[0])->attempt([$this->field() => request()->username, 'password' => request()->password])) {
            return redirect()->intended(route($info[1]));
        } else {
            return redirect()->back()->withInput(request()->only('username', 'remember_me'))->with(['error' => __('auth.failed')]);
        }
    } // End Login User

    public function logout()
    {
        if (app('router')->getRoutes()->match(app('request'))->uri == 'admin/logout')
            $info = ['admin', 'admin.login'];
        else
            $info = ['user', 'login'];

        $username = __('alerts.bye_bye', ['username' => Auth::guard($info[0])->user()->username]);
        Auth::guard($info[0])->logout();
        return redirect()->route($info[1])->with(['username' => $username]);
    } // End Logout Auth

} // End Login Controller
