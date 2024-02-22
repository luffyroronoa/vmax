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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
 
     public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Hapus metode redirectTo yang ada di sini

    // Tambahan: Tambahkan metode authenticated
   protected function authenticated($request, $user)
    {
        if ($user->role == 'admin') {
            return redirect()->route('register.data'); 
        }

        return redirect()->route('register.index'); // Ubah 'register.index' sesuai dengan nama rute yang benar
    }

}