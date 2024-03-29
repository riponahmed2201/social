<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

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
//        $user = User::find(1);
//        Auth::login($user);
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();

        $socialUser = User::where('provider_id',$user->getId())->first();
        $email_check = User::where('email',$user->getEmail())->first();
        if (!$socialUser) {
           if (!$email_check){
                $socialUser =  User::create([
                    'email' => $user->getEmail(),
                    'name' => $user->getName(),
                    'provider_id' => $user->getId(),
                    'provider' => $provider,

                ]);
            }
        }
      if (!$socialUser){
        Auth::login($email_check,true);
        }
       else{
        Auth::login($socialUser,true);
    }

        return redirect($this->redirectTo);
    }
}
