<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            "App\src\Auths\Interfaces\AuthInterface",
            "App\src\Auths\Interfaces\AuthInterfaceRepository"
        );
        $this->app->bind(
            "App\src\Users\Interfaces\UserInterface",
            "App\src\Users\Interfaces\UserInterfaceRepository"
        );
        $this->app->bind(
            "App\src\Roles\Interfaces\RoleInterface",
            "App\src\Roles\Interfaces\RoleInterfaceRepository"
        );
    }

}
