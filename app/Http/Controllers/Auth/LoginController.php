<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware(['guest'])->except('logout');
    }

    public function field()
    {
        if(filter_var(request()->username, FILTER_VALIDATE_EMAIL))
            return 'email';

        if(is_numeric(request()->username))
            return 'phone';

        return 'name';
    }

    public function login()
    {
        $url = app('router')->getRoutes()->match(app('request')->create(url()->previous()))->uri();
        switch($url) {
            case 'admin/login' :
                $info = ['admin', 'dashboard.home'];
                break;
            default :
                $info = ['web', '/'];
        }

        if(Auth::guard($info[0])->attempt([$this->field() => request()->username, 'password' => request()->password])) {
            return redirect()->intended(route($info[1]));
        } else {
        return redirect()->back()->withInput(request()->only('username', 'remember_me'))->with(['error' => __('auth.failed')]);
        }
    }

}
