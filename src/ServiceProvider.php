<?php

declare(strict_types=1);

namespace Auth0\Laravel;

final class ServiceProvider extends \Spatie\LaravelPackageTools\PackageServiceProvider
{
    public function configurePackage(
        \Spatie\LaravelPackageTools\Package $package
    ): void {
        $package
            ->name('auth0')
            ->hasConfigFile();
    }

    /**
    * Register application services.
    *
    * @return void
    */
    public function registeringPackage(): void
    {
        app()->singleton(Auth0::class, static function () {
            return new Auth0(fn() => app());
        });

        app()->singleton('auth0', function () {
            return app()->make(Auth0::class);
        });

        app()->singleton(StateInstance::class, static function () {
            return new StateInstance();
        });

        app()->singleton(\Auth0\Laravel\Auth\User\Repository::class, static function () {
            return new \Auth0\Laravel\Auth\User\Repository(fn() => app());
        });
    }

    /**
    * Register middleware and guard.
    *
    * @return void
    */
    public function bootingPackage(): void
    {
        auth()->provider('auth0', function ($app, array $config) {
            return new \Auth0\Laravel\Auth\User\Provider(app()->make($config['repository']), app('auth0'));
        });

        auth()->extend('auth0', function ($app, $name, array $config) {
            return new \Auth0\Laravel\Auth\Guard(auth()->createUserProvider($config['provider']), $app->make('request'));
        });
    }
}
