<?php
define('MINIMUM_VERSION', '7.3.0');
if (version_compare(PHP_VERSION, MINIMUM_VERSION, '<')) exit('<font size="20">You need at least <font color="red">PHP ' . MINIMUM_VERSION . '</font> to install this application.</font>');

require_once __DIR__ . '/../vendor/autoload.php';

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();

date_default_timezone_set(env('APP_TIMEZONE', 'UTC'));

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

$app->withFacades();
$app->withEloquent();

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Config Files
|--------------------------------------------------------------------------
|
| Now we will register the "app" configuration file. If the file exists in
| your configuration directory it will be loaded; otherwise, we'll load
| the default version. You may register other files below as needed.
|
*/

$app->configure('app');

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

// $app->middleware([
//     App\Http\Middleware\ExampleMiddleware::class
// ]);

$app->middleware([
    Fruitcake\Cors\HandleCors::class,
]);

$app->routeMiddleware(
    [
        'auth' => App\Http\Middleware\Authenticate::class,
        'guest' => App\Http\Middleware\RedirectIfAuthenticated::class,
        'admin' => App\Http\Middleware\Admin::class,
        'demo_admin' => App\Http\Middleware\DemoAdmin::class,
        'installer' => App\Installer\Middleware\Installer::class,
    ]
);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

$app->register('App\Providers\AppServiceProvider');
$app->register('App\Providers\AuthServiceProvider');
$app->register('Fruitcake\Cors\CorsServiceProvider');
// $app->register(App\Providers\EventServiceProvider::class);
$app->register('Yajra\DataTables\DataTablesServiceProvider');

$app->register('Jackiedo\DotenvEditor\DotenvEditorServiceProvider');
$app->register('Intervention\Image\ImageServiceProvider');
$app->register('Laravel\Socialite\SocialiteServiceProvider');

$app->configure('cors');
$app->configure('datatables');
$app->configure('services');

if (!$app->environment('production') && class_exists('Tanmuhittin\LaravelGoogleTranslate\LaravelGoogleTranslateServiceProvider')) {
    $app->register('Tanmuhittin\LaravelGoogleTranslate\LaravelGoogleTranslateServiceProvider');
}

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->router->group(
    [
        'middleware' => 'installer',
        'namespace' => 'App\Http\Controllers',
    ],
    function ($router) {
        include __DIR__ . '/../app/Http/routes.php';
    }
);

$app->router->group(
    [
        'middleware' => 'installer',
        'namespace' => 'App\Installer\Controllers',
    ],
    function ($router) {
        include __DIR__ . '/../app/Installer/routes.php';
    }
);

return $app;
