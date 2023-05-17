<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => [
            'logout',
        ]]);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function loginForm()
    {
        return view('auth.pages.login');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function registerForm()
    {
        return view('auth.pages.register');
    }

    /**
     * Login a User
     *
     * @return void
     */
    public function login(Request $request, UserRepository $userRepository)
    {
        $response = $userRepository->login($request->only(['email', 'password', 'g-recaptcha-response']));

        return $response->json();
    }

    /**
     * Create a user
     *
     * @return void
     */
    public function register(Request $request, UserRepository $userRepository)
    {
        $response = $userRepository->storeAndAuthenticate($request->only(['username', 'email', 'password', 'g-recaptcha-response']));

        return $response->json();
    }

    /**
     * Logout a user
     *
     * @return void
     */
    public function logout(UserRepository $userRepository)
    {
        return $userRepository->logout(Auth::user())->json();
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->stateless()->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider, UserRepository $userRepository)
    {
        $service = Socialite::driver($provider)->stateless()->user();

        // All Providers
        $id = $service->getId();
        $username = $service->getNickname();
        $name = $service->getName();
        $email = $service->getEmail();
        $avatar = $service->getAvatar();

        if ($id) {
            $user = User::firstOrCreate([
                $provider . '_id' => $id,
            ], [
                'username' => $username ?? Str::slug($name),
                'name' => $name,
                'icon' => $avatar,
                'email' => $email,
                'password' => bcrypt(Str::random(10)), // to pass validation - user can change password later
            ]);

            $response = $userRepository->authenticate($user);
        }

        // @TODO wtf?
        // just close the window system will reload main window.
        return "<script type='text/javascript'>setTimeout(function(){window.close();}, 500)</script>";
    }
}
