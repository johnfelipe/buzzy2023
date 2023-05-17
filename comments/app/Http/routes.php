<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(
    ['middleware' => 'admin', 'prefix' => '/admin'],
    function () use ($router) {
        $router->get(
            '/',
            function () {
                return view('admin.pages.dashboard');
            }
        );

        $router->post('comments/{id}/approve', 'Admin\CommentsController@approve');
        $router->post('comments/{id}/destroy', 'Admin\CommentsController@destroy');
        $router->get('comments/data', 'Admin\CommentsController@getTableData');
        $router->post('comments/{id}', 'Admin\CommentsController@update');
        $router->get('comments/{id}/', 'Admin\CommentsController@show');
        $router->get('comments', 'Admin\CommentsController@index');


        $router->post('reports/{id}/destroy', 'Admin\ReportsController@destroy');
        $router->get('reports/data', 'Admin\ReportsController@getTableData');
        $router->get('reports', 'Admin\ReportsController@index');

        $router->post('users/{id}/action', 'Admin\UsersController@action');
        $router->post('users/{id}/destroy', 'Admin\UsersController@destroy');
        $router->get('users/data', 'Admin\UsersController@getTableData');
        $router->post('users/{id}', 'Admin\UsersController@update');
        $router->get('users/{id}', 'Admin\UsersController@show');
        $router->get('users', 'Admin\UsersController@index');

        $router->post('translations[/{locale}]', 'Admin\TranslationsController@update');
        $router->get('translations[/{locale}]', 'Admin\TranslationsController@index');

        $router->post('settings', 'Admin\SettingsController@update');
        $router->get('settings', 'Admin\SettingsController@index');

        $router->post('themes/{theme}', 'Admin\ThemesController@selectTheme');
        $router->get('themes', 'Admin\ThemesController@index');

        $router->post('pages/create', 'Admin\PagesController@store');
        $router->get('pages/create', 'Admin\PagesController@create');
        $router->post('pages/{id}/destroy', 'Admin\PagesController@destroy');
        $router->get('pages/data', 'Admin\PagesController@getTableData');
        $router->post('pages/{id}', 'Admin\PagesController@update');
        $router->get('pages/{id}', 'Admin\PagesController@edit');
        $router->get('pages', 'Admin\PagesController@index');
    }
);

$router->group(
    ['prefix' => 'api'],
    function ($app) {
        $app->get('login/{provider}/callback', 'AuthController@handleProviderCallback');
        $app->get('login/{provider}', 'AuthController@redirectToProvider');
        $app->get('logout/force', 'AuthController@logout');
        $app->post('logout', 'AuthController@logout');
        $app->post('login', 'AuthController@login');
        $app->get('login', 'AuthController@loginForm');
        $app->post('register', 'AuthController@register');
        $app->get('register', 'AuthController@registerForm');

        $app->post('account/update', 'UsersController@update');
        $app->get('account', 'UsersController@account');

        $app->post('comments/{id}/report', 'CommentsController@report');
        $app->get('comments/{id}/report', 'CommentsController@reportForm');

        $app->post('comments_vote', 'CommentsController@vote');
        // $app->delete('comments/{id}/', 'CommentsController@destroy');
        $app->get('comments/{id}/replies', 'CommentsController@replies');
        $app->put('comments/{id}/', 'CommentsController@update');
        $app->get('comments/{id}/', 'CommentsController@show');
        $app->post('comments', 'CommentsController@store');
        $app->get('comments', 'CommentsController@index');
    }
);

$router->post('users/{id}', 'UsersController@info');
$router->get('users/{username}', 'UsersController@show');
$router->get('pages/{id}', 'PagesController@show');
$router->get('/app', 'CommentsController@index');
$router->get(
    '/',
    function () {
        return view('welcome');
    }
);
