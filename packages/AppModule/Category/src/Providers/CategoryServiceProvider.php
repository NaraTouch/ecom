<?php

namespace AppModule\Category\Providers;

use Illuminate\Support\ServiceProvider;
use AppModule\Category\Models\CategoryProxy;
use AppModule\Category\Observers\CategoryObserver;

class CategoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->app->register(EventServiceProvider::class);

        CategoryProxy::observe(CategoryObserver::class);
    }
}
