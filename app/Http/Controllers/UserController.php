<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use APP\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    function index(){
       return view('dashboards.users.index'); 
    }
    public function sendOtp(Request $request){

        $otp = rand(1000,9999);
        Log::info("otp = ".$otp);
        $user = User::where('mobile','=',$request->mobile)->update(['otp' => $otp]);
        // send otp to mobile no using sms api
        return response()->json([$user],200);
    }

    public function loginWithOtp(Request $request){
        Log::info($request);
        $user  = User::where([['mobile','=',request('mobile')],['otp','=',request('otp')]])->first();
        if( $user){
            Auth::login($user, true);
            User::where('mobile','=',$request->mobile)->update(['otp' => null]);
            return view('dashboards.users.index');
        }
        else{
            return Redirect::back ();
        }
    }
}

