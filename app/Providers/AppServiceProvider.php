<?php

namespace App\Providers;

use App;
use Illuminate\Support\ServiceProvider;
use URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('IS_HTTPS') === '1') {
            /**
             * Добавляет https к ссылкам
             */
            \URL::forceScheme('https');
            /**
             * Устанавливает параметр https в глобальный массив
             */
            $this->app['request']->server->set('HTTPS', true);
        }

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
