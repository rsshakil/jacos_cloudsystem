<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        $this->app['request']->server->set('HTTPS', $this->app->environment() != 'local');
        \Log::info(\App::environment());
        // // \Log::info(env('APP_URL', null));
        // \Log::info("Config ".\Config::get('app.env'));
        // // env('MY_VALUE', 'default_value');
        // if(\App::environment() !== 'local') {
        //     URL::forceScheme('https');
        //     \Log::info('https');
        //     \Log::info(\App::environment());
        // }else{
        //     \Log::info('http');
        //     \Log::info(\App::environment());
        // }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        // SQL Log
        \DB::listen(function ($query) {
            $sql = $query->sql;
            for ($i = 0; $i < count($query->bindings); $i++) {
                $sql = preg_replace("/\?/", $query->bindings[$i], $sql, 1);
            }

            \Log::debug("SQL", ["time" => sprintf("%.2f ms", $query->time), "sql" => $sql]);
        });
    }
}
