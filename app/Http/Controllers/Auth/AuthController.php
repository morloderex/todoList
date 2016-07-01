<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Redirects to GitHub for Authentication
     * 
     * @return mixed
     */
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Redirects to Facebook for Authentication
     * 
     * @return mixed
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Redirects to Google for Authentication
     * 
     * @return mixed
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handles the authenticated callback from GitHub
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGithubCallback()
    {
        $user = $this->createUserFromOAuth(Socialite::driver('github')->user());
        
        Auth::guard($this->getGuard())->login($user);
        return redirect()->intended($this->redirectPath());
    }

    /**
     * Handles the authenticated callback from Facebook
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleFacebookCallback()
    {
        $user = $this->createUserFromOAuth(Socialite::driver('facebook')->user());

        Auth::guard($this->getGuard())->login($user);
        return redirect()->intended($this->redirectPath());
    }

    /**
     * Handles the authenticated callback from Google
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback()
    {
        $user = $this->createUserFromOAuth(Socialite::driver('google')->user());

        Auth::guard($this->getGuard())->login($user);
        return redirect()->intended($this->redirectPath());
    }

    /**
     * Creates a new User from OAuth
     * 
     * @param SocialiteUser $user
     * @return User
     */
    protected function createUserFromOAuth(SocialiteUser $user) : User
    {
        $data['id']         = $user->getId();
        $data['name']       = $user->getName();
        $data['email']      = $user->getEmail();
        $data['avatar_url'] = $user->getAvatar();

        if(!is_null($user->token))
        {
           $data['oauth_token'] = $user->token; 
        }
        
        return User::create($data);
    }
}
