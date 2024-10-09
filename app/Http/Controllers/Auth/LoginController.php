<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
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
    protected $redirectTo = '/home';

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

    public function showLoginForm()
    {
        return view('auth.login')->with('title', 'Login');
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [];

        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            // User tidak ditemukan, berikan pesan bahwa email tidak terdaftar
            $errors['email'] = ['Akun Tidak Terdaftar'];
        } elseif (!Hash::check($request->password, $user->password)) {
            // Jika user ditemukan tapi password salah
            $errors['password'] = ['Password anda salah'];
        }

        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }

        throw ValidationException::withMessages($errors);
    }
}
