<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLogin()
    {
        return view("admin.authentication.login");
    }

    public function login(LoginRequest $request)
    {
        try
        {
            $remember_me  = ( !empty( $request->remember_me ) ) ? TRUE : FALSE;
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember_me))
            {
                return redirect()->route('admin.home')->with(['success_msg' => __('admin.login_success')]);
            }
            return redirect()->route('admin.login')->with(['err_msg' => __('admin.login_error')]);
        }
        catch (Exception $ex)
        {
            return redirect()->route('admin.login')->with(['err_msg' => __('admin.login_error')]);   
        }
    }

    public function logout(Request $request)
    {
        try
        {
            Auth::logout();
            $request->session()->invalidate();
            return redirect()->route('admin.login');
        }
        catch(Exception $ex)
        {
            return redirect()->route('admin.home')->with(['err_msg' => __('admin.logout_err')]);
        }
    }

    public function forgotPassword()
    {
        return view('admin.authentication.forgot-password');
    }

    public function sendResetPassword(LoginRequest $request)
    {
        try
        {
            $status = Password::broker('users')->sendResetLink(
                $request->only('email')
            );
    
            return $status === Password::RESET_LINK_SENT
                ? redirect()->route('login.forgot-password')->with(['success_msg' => __('admin.email_sent')])
                : redirect()->route('login.forgot-password')->withErrors(['err_msg' => __('admin.email_not_sent')]);
        }
        catch (Exception $ex)
        {
            return redirect()->route('login.forgot-password')->withErrors(['err_msg' => __('admin.email_not_sent')]);
        }
    }

    public function resetPassword(Request $request)
    {
        if (isset($request->token))
        {
            return view('admin.authentication.reset-password', ['token' => $request->token]);
        }
        return redirect()->route('admin.login');
    }

    public function doResetPassword(LoginRequest $request)
    {
        try 
        {
            $status = Password::broker('users')->reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) use ($request) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ]);
                    $user->save();
                }
            );
            return $status == Password::PASSWORD_RESET
                ? redirect()->route('admin.login')->with('success_msg', __('admin.password_resetted'))
                : back()->withErrors(['err_msg' => [__('admin.password_not_reset')]]);
        }
        catch (Exception $ex)
        {
            return back()->withErrors(['err_msg' => [__('admin.password_not_reset')]]);
        }
    }
}
