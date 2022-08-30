<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;
 use App\Models\User;
use Laravel\Socialite\SocialiteServiceProvider;
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
    protected function redirectTo(){
        if(Auth()->user()->role==1){
            return route('admin.dashboard');
        }
        elseif(Auth()->user()->role==2){
            return route('user.dashboard');
        
        }
        elseif(Auth()->user()->role==3){
            return route('designer.dashboard');
        }
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

    //Google Login
    public function redirectToGoogle(){
        return Socialite::driver(driver:'google')->redirect();
    }

    //Google Callback
    public function handleGoogleCallback(){
        $user=Socialite::driver(driver:'google')->user();
        $this->_registerOrLoginUser($user);
        return redirect()->route('user.dashboard');
    }

    //Google Facebook
    public function redirectToFacebook(){
        return Socialite::driver(driver:'facebook')->redirect();
    }

    //Google Callback
    public function handleFacebookCallback(){
        $user=Socialite::driver(driver:'facebook')->user();
    }



    public function login(Request $request){
        $input=$request->all();
        $this->validate($request,[
            'role'=>'required',
            'email'=>'required|email',
            'password'=>'required'

        ]);

        if(auth()->attempt(array('role'=>$input['role'],'email'=>$input['email'],'password'=>$input['password']))){
            if(auth()->user()->role==1){
               return redirect()->route('admin.dashboard');
            }
            elseif(auth()->user()->role==2){
                return redirect()->route('user.dashboard');
            
            }
            elseif(auth()->user()->role==3){
                return redirect()->route('designer.dashboard');
            }
        }
        else{
            return redirect()->route('login')->with('error','Invalid Credentials');
        }
    }

protected function _registerOrLoginUser($data){

    $user=User::where('email','=',$data->email)->first();

    if(!$user){
        $user=new User();
        $user->name=$data->name;
        $user->email=$data->email;
        $user->provider_id=$data->id;
        $user->avatar=$data->avatar;
        $user->save();
    }

    Auth::login($user);
}


}
