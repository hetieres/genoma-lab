<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(190);

        ini_set('intl.default_locale', config('app.locale'));
        setlocale(LC_TIME, config('app.locale'), config('app.locale').'.utf-8', config('app.locale').'.UTF-8');
        date_default_timezone_set(config('app.timezone'));

        \Carbon\Carbon::setLocale(config('app.locale'));
        \Carbon\Carbon::setUtf8(env('CARBON_UTF8', false));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $public_path = '';

        if (env('PUBLIC_PATH') !== null && $this->app->environment() === 'production') {
            $public_path = DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'html' . DIRECTORY_SEPARATOR . env('PUBLIC_PATH');
        } else if (env('PUBLIC_PATH') !== null && $this->app->environment() === 'development') {
            $public_path = DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'html' . DIRECTORY_SEPARATOR . env('PUBLIC_PATH');
        } else if (env('PUBLIC_PATH') !== null && $this->app->environment() === 'local') {
            $public_path = DIRECTORY_SEPARATOR . env('PUBLIC_PATH');
        } else if (env('PUBLIC_PATH') !== null) {
            $public_path = DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . env('PUBLIC_PATH');
        }

        if ($public_path!=='') {
            $this->app['path.public'] = base_path() . $public_path;
        }
    }
}
