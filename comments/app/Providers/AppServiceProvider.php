<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Validator::extend('recaptcha', 'App\\Validators\\ReCaptcha@validate');
        Schema::defaultStringLength(191);
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        $locale = request()->cookie('easy_locale');

        if (request()->has('language')) {
            $locale = request()->query('language');
        }

        if (empty($locale) || !in_array($locale, get_available_languages())) {
            $locale = env('APP_LOCALE', 'en');
        }

        $this->app->setLocale($locale);
        Carbon::setLocale($locale);

        Paginator::useBootstrap();
    }
}
