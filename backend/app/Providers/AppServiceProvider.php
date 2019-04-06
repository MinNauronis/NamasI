<?php

namespace App\Providers;

use App\Curtain;
use App\Leds;
use App\Observers\CurtainObserver;
use App\Observers\LedsObserver;
use App\Observers\ScheduleObserver;
use App\Schedule;
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
        Schema::defaultStringLength(144);

        Schedule::observe(ScheduleObserver::class);
        Leds::observe(LedsObserver::class);
        Curtain::observe(CurtainObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
