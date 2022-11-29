<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
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
    // protected $redirectTo = RouteServiceProvider::HOME;
    public function username()
    {
        return 'username';
    }

    protected function redirectTo(){
        // if (\Auth::user()->roles->nama == 'Admin') {
        //     return 'admin';
        // }elseif (\Auth::user()->roles->nama == 'Kepala Cabang') {
        //     return 'kepala_cabang';
        // }elseif (\Auth::user()->roles->nama == 'Kaptain Dapur') {
        //     return 'kaptain_dapur';
        // }elseif (\Auth::user()->roles->nama == 'CS') {
        //     return 'cs';
        // }elseif (\Auth::user()->roles->nama == 'Crew') {
        //     return 'crew';
        // }elseif (\Auth::user()->roles->nama == 'Direktur') {
        //     return 'direktur';
        // }elseif (\Auth::user()->roles->nama == 'Manager') {
        //     return 'manager';
        // }elseif (\Auth::user()->roles->nama == 'PPIC') {
        //     return 'ppic';
        // }else{
        //     abort(404);
        // }
        return 'dashboard';
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
