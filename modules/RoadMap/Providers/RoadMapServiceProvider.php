<?php

namespace Modules\RoadMap\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\RoadMap\Models\PersonalPreference;
use Modules\RoadMap\Observers\PersonalPreferenceObserver;

class RoadMapServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        PersonalPreference::observe(PersonalPreferenceObserver::class);
    }
}
