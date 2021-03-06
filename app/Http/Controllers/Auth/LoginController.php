<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
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
    }
    
    public function logout(Request $request) {
      Auth::logout();
      return redirect('/home');
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }
    public function redirectToProvider2()
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function redirectToProvider3()
    {
        return Socialite::driver('google')->redirect();
    }


    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $githubUser = Socialite::driver('github')->user();

        $user = User::where('provider_id', $githubUser->getId())->first();

        if (!$user) {
            // add user to database
            $user = User::create([
                'email' => $githubUser->getEmail(),
                'name' => $githubUser->getName(),
                'provider_id' => $githubUser->getId(),
            ]);
        }

        // login the user
        Auth::login($user, true);

        return redirect($this->redirectTo);
    }

    public function handleProviderCallback2()
    {
        $facebookUser = Socialite::driver('facebook')->user();

        $user = User::where('provider_id', $facebookUser->getId())->first();

        if (!$user) {
            // add user to database
            $user = User::create([
                'email' => $facebookUser->getEmail(),
                'name' => $facebookUser->getName(),
                'provider_id' => $facebookUser->getId(),
            ]);
        }

        // login the user
        Auth::login($user, true);

        return redirect($this->redirectTo);
    }

    public function handleProviderCallback3()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('provider_id', $googleUser->getId())->first();

        if (!$user) {
            // add user to database
            $user = User::create([
                'email' => $googleUser->getEmail(),
                'name' => $googleUser->getName(),
                'provider_id' => $googleUser->getId(),
            ]);
        }

        // login the user
        Auth::login($user, true);

        return redirect($this->redirectTo);
    }
}
