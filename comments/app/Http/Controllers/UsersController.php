<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * @var \App\Repositories\UserRepository
     */
    private $userRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('auth', ['except' => [
            'show',
            'info',
        ]]);

        $this->middleware('demo_admin', ['only' => [
            'update',
        ]]);

        $this->userRepository = $userRepository;
    }

    /**
     * Find an user by username.
     *
     * @param string $username
     * @return \Illuminate\View\View
     */
    public function show($username)
    {
        $response = $this->userRepository->findByUsername($username);

        $user = $response->data();

        return view('auth.pages.user', compact('user'));
    }

    /**
     * Get user public data.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function info($id)
    {
        $response = $this->userRepository->show($id);

        if ($response->failed()) {
            return $response->json();
        }

        $user = $response->data();

        return $response->json(['html' => view(
            'comments.pages._user_info_widget',
            compact(
                'user',
            )
        )->render()]);
    }

    /**
     * Show account form.
     *
     * @return \Illuminate\View\View
     */
    public function account()
    {
        $user = Auth::user();

        return view('auth.pages.account', compact('user'));
    }

    /**
     * Update user account
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $response = $this->userRepository->update(
            Auth::user(),
            $request->all()
        );

        return $response->json();
    }
}
