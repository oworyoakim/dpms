<?php

namespace App\Providers;

use App\Repositories\GenericRepository;
use App\Repositories\IGenericRepository;
use App\Repositories\ISettingRepository;
use App\Repositories\SettingRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(IGenericRepository::class,GenericRepository::class);
        $this->app->singleton(ISettingRepository::class,SettingRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
