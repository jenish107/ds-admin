<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Jobs\SendEmailJob;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegistrationRequest;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('login');
    }
    public function otpPage()
    {
        return view('otp');
    }

    public function registrationPage()
    {
        return view('registration');
    }

    public function dashboardPage()
    {
        return view('dashboard');
    }

    public function login(Request $request)
    {
        $validate = $request->validate([
            'userName' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('userName', $request->input('userName'))->first();

        if (!$user || $request->password !== $user->password) {
            return back()->with('error', 'Invalid user name or password');
        }

        $otp = Str::random(4);

        session(['userData' => $user->toArray()]);
        session(['otp' => $otp]);

        dispatch(new SendEmailJob($user->toArray(), $otp));

        return redirect()->route('otpPage');
    }

    public function registration(RegistrationRequest $request)
    {
        $data = $request->validated();
        $otp = Str::random(4);

        $user = User::where('userName', $data['userName'])->first();

        if ($user) {
            return back()->with('error', 'user is already exist');
        }

        session(['userData' => $data]);
        session(['otp' => $otp]);

        dispatch(new SendEmailJob($data, $otp));

        return redirect()->route('otpPage');
    }

    public function confirmOtp(Request $request)
    {
        $userData = session('userData');
        $otp = $request->input('otp');

        $user = User::where('userName', $userData["userName"])->first();

        if ($otp == session('otp')) {
            if (!$user) {
                $user = User::create([
                    'userName' => $userData['userName'],
                    'email' => $userData['email'],
                    'password' => $userData['password'],
                ]);
            }

            Auth::login($user);

            session()->forget(['otp', 'userData']);
            return redirect()->route('dashboardPage');
        } else {
            // this is for test only delete after test
            Auth::login($user);
            return redirect()->route('dashboardPage');

            return redirect()->route('otpPage')->with('error', 'OTP is not match');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('registrationPage');
    }
}
