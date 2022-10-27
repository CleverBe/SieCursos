<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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

    //  SE COMENTÓ ESTA LINEA PARA HACER EL METODO redirectTo y enviar a una vista segun el rol.
    // protected $redirectTo = RouteServiceProvider::HOME;

    public function redirectTo()
    {
        $user_id = Auth()->user()->id;
        $user = User::where('profile', 'ADMIN')
            ->where('id', $user_id)->get()->first();

        $this->redirectTo = $user ? route('horarios') : route('inicioAulas');

        return $this->redirectTo;
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
