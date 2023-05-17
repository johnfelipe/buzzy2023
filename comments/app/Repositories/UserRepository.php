<?php

namespace App\Repositories;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Managers\UploadManager;
use App\Traits\RepositoryResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserRepository
{
    use RepositoryResponse;

    /**
     * Get an user.
     *
     * @param int $id User ID
     *
     * @return $this
     */
    public function show($id)
    {
        if ($user = User::find($id)) {
            $response = $this->success($user);
        } else {
            $response = $this->fail();
        }

        return $response;
    }

    /**
     * Get an user by username.
     *
     * @param string $username User name
     *
     * @return $this
     */
    public function findByUsername($username)
    {
        if ($user = User::where('username_slug', $username)->first()) {
            $response = $this->success($user);
        } else {
            $response = $this->fail();
        }

        return $response;
    }

    /**
     * Update an user.
     *
     * @param int|object $user User or ID
     * @param array $data User data
     *
     * @return $this
     */
    public function update($user, $data)
    {
        if (is_numeric($user)) {
            $user = User::find($user);
        }

        if (!$user || !($user->id === Auth::user()->id || Auth::user()->user_type === 'admin')) {
            return $this->fail(__('You are not allowed to update'));
        }

        $validator = $this->authValidator($data, [
            'username' => 'required|between:2,30|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'between:5,20',
        ]);

        if ($validator->fails()) {
            return $this->fail($validator->errors()->first());
        }

        if (request()->hasFile('icon')) {
            try {
                $image = new UploadManager();
                $image->path('upload/avatars')
                    ->file('icon')
                    ->name($user->username_slug . '-' . time())
                    ->make()
                    ->mime('jpg')
                    ->save([
                        'fit_width' => 150,
                        'fit_height' => 150,
                        'image_size' => 'm',
                    ])
                    ->save([
                        'fit_width' => 60,
                        'fit_height' => 60,
                        'image_size' => 's',
                    ])
                    // delete previous image
                    ->delete(image_url_create($user->icon, 'm', 'avatars', false))
                    ->delete(image_url_create($user->icon, 's', 'avatars', false));

                $data["icon"] = $image->getPathforSave();
            } catch (\Exception $e) {
                return $this->fail($e->getMessage());
            }
        }

        if ($password = Arr::get($data, 'password')) {
            $data["password"] = bcrypt($password);
        } else {
            unset($data["password"]);
        }

        $user_type = Arr::get($data, 'user_type');
        if ($user_type === 'banned') {
            $data["api_token"] = null; //logout also
        }

        unset($data["g-recaptcha-response"]);

        $newData = $user->update($data);
        return $this->success($newData, __('User updated successfully'));
    }

    /**
     * Force Update an user.
     *
     * @param int|object $user User or ID
     * @param array $data User data
     *
     * @return $this
     */
    public function forceUpdate($user, $data)
    {
        if (is_numeric($user)) {
            $user = User::find($user);
        }

        $newData = $user->update($data);
        return $this->success($newData, __('User updated successfully'));
    }

    /**
     * Destroy a comment.
     *
     * @param integer $id Comment Id
     *
     * @return $this
     */
    public function destroy($id)
    {
        try {
            User::destroy($id);
            $response = $this->success(true, __('User Deleted'));
        } catch (\Exception $e) {
            $response = $this->fail($e->getMessage());
        }

        return $response;
    }

    /**
     * Create a user
     *
     * @return $this
     */
    public function store($data)
    {
        $validator = $this->authValidator($data, [
            'username' => 'required|between:2,30|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|between:5,20',
        ]);

        if ($validator->fails()) {
            return $this->fail($validator->errors()->first());
        }

        if ($password = Arr::get($data, 'password')) {
            $data['password'] = bcrypt($password);
        }

        try {
            $user = User::create(Arr::only($data, ['username', 'email', 'password']));

            return $this->success($user, __('Successfully registered!.'));
        } catch (\Exception $e) {
            return $this->fail($e->getMessage());
        }
    }

    /**
     * Login a user
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function authValidator($data, $rules = [])
    {
        $rules = array_merge($rules, [
            'icon' => 'nullable|mimes:jpg,jpeg,gif,png',
            'name' => 'nullable|between:2,30',
            'town' => 'nullable|between:2,30',
            'about' => 'nullable|between:3,500',
            'url' => 'nullable|url',
        ]);

        if (env('GOOGLE_RECAPTCHA_SECRET')) {
            $rules = array_merge($rules, [
                'g-recaptcha-response' => 'required|recaptcha'
            ]);
        }

        $messages = [
            'username.unique' => __('Username is already exists.'),
            'email.unique' => __('Email is already exists.'),
            'email.required' => __('We need to know your e-mail address!'),
            'email' => __('This is not a valid email address'),
            'required' => __('The :attribute field is required.'),
            'between' => __('The :attribute value :input is not between :min - :max.'),
            'url' => __('Not a valid URL.'),
            'mimes' => __('Not a valid image.'),
            'recaptcha' => __('reCaptcha failed. You may need to refresh the page.'),
        ];

        return Validator::make($data, $rules, $messages);
    }

    /**
     * Login a user
     *
     * @return $this
     */
    public function authenticate($user)
    {
        if (is_numeric($user)) {
            $user = User::find($user);
        }

        if ($user) {
            if ($user->user_type === 'banned') {
                return $this->fail(__('You are banned from this site'));
            }

            $api_token = base64_encode(Str::random(40));

            $user->update([
                'api_token' => "$api_token"
            ]);

            if ($api_token) {
                setcookie("easy_api_token", $api_token, time() + 30 * 24 * 60 * 60, '/');
            }

            return $this->success($user, __('Successfully Signin!.'))->add_extra([
                'api_token' => $api_token,
                'redirectTo' => $user->user_type === 'admin' ? url('admin') : url('/'),
            ]);
        } else {
            return $this->fail(__('Unable to connect with this info.'));
        }
    }

    /**
     * Create a user
     *
     * @return $this
     */
    public function storeAndAuthenticate($data)
    {
        $response = $this->store($data);

        if ($response->succeeded()) {
            return $this->authenticate($this->data()->id);
        }

        return $response;
    }

    /**
     * Login a user
     *
     * @return $this
     */
    public function login($data)
    {
        $validator = $this->authValidator($data, [
            'email' => 'required|email',
            'password' => 'required|between:5,20',
        ]);

        if ($validator->fails()) {
            return $this->fail($validator->errors()->first());
        }

        $user = User::where('email', Arr::get($data, 'email'))->first();

        if ($user && Hash::check(Arr::get($data, 'password'), $user->password)) {
            return $this->authenticate($user);
        } else {
            return $this->fail(__('Unable to connect with this info.'));
        }
    }

    /**
     * Logout a user
     *
     * @return $this
     */
    public function logout($user)
    {
        if (is_numeric($user)) {
            $user = User::find($user);
        }

        if ($user) {
            $user->update([
                'api_token' => ""
            ]);

            return $this->success(true);
        } else {
            return $this->fail();
        }
    }
}
