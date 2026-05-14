<?php

namespace App\Providers;

use Illuminate\Support\Str;
use Dedoc\Scramble\Scramble;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::define('export-product', function (User $user) {
            return $user->role === 'admin';
        });

        Gate::define('manage-category', function (User $user) {
            return $user->role === 'admin';
            // hanya admin yang boleh mengakses atau mengelola category
        });
        
        Gate::define('manage-category', function (User $user) {
            return $user->role === 'admin';
            // hanya user dengan role admin yang boleh mengelola category
        });

        Scramble::configure()
        ->routes(function (Route $route) {
            return Str::startsWith($route->uri, 'api/');
        });

        Gate::define('viewApiDocs', function () {
            return true;
        });
    }
}