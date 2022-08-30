<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\VerficationCode;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AuthOtpController extends Controller
{
    public function login()
    {
        return view('auth.otp-login');
    }

    //Generate OTP
    public function generate(Request $request)
    {
        #validate Data
        $request->validate([
            'mobile' => 'required|exists:users,mobile'

        ]);
        # Generate An OTP
        $verificationCode=$this->generateOtp($request->mobile);
        # Return With OTP
        $message="Your OTP To Login is - ".$verificationCode->otp;

        return redirect()->route('otp.verification')->with('success',$message);
    }


    public function generateOtp($mobile)
    {

        #user Does not Have Any Existing OTP
        $user = User::where('mobile', $mobile)->first();
        $verificationCode =VerficationCode::where('user_id', $user->id)->latest()->first();

        $now=Carbon::now();
        if($verificationCode && $now->isBefore($verificationCode->expire_at)){
            return $verificationCode;
        }

        //Create a New OTP
        return VerficationCode::create([
            'user_id'=>$user->id,
            'otp'=>rand(123456,999999),
            'expire_at'=>Carbon::now()->addMinutes(10)
        ]);
    }

    public function verification()
    {
        return view('auth.otp-verification');
       
    }

    public function loginWithOtp(Request $request)
    {
        #Validation
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'otp' => 'required'
        ]);

        #Validation Logic
        $verificationCode   = VerficationCode::where('user_id', $request->user_id)->where('otp', $request->otp)->first();

        $now = Carbon::now();
        if (!$verificationCode) {
            return redirect()->back()->with('error', 'Your OTP is not correct');
        }elseif($verificationCode && $now->isAfter($verificationCode->expire_at)){
            return redirect()->route('otp.login')->with('error', 'Your OTP has been expired');
        }

        $user = User::whereId($request->user_id)->first();

        if($user){
            // Expire The OTP
            $verificationCode->update([
                'expire_at' => Carbon::now()
            ]);

            Auth::login($user);

            return redirect('/home');
        }

        return redirect()->route('otp.login')->with('error', 'Your Otp is not correct');
    }
}
