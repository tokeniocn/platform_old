<?php

namespace App\Providers;

use Schema;
use App\Captcha\Captcha;
use Illuminate\Validation\Factory as ValidationFactory;
use Illuminate\Support\ServiceProvider;

/**
 * Class AppServiceProvider.
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        // Sets third party service providers that are only needed on local/testing environments
        if ($this->app->environment() !== 'production') {
            /**
             * Loader for registering facades.
             */
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();

            // Load third party local aliases
            $loader->alias('Debugbar', \Barryvdh\Debugbar\Facade::class);
        }

        // Bind captcha
        $this->app->bind('captcha', function ($app) {
            return new Captcha(
                $app['Illuminate\Filesystem\Filesystem'],
                $app['Illuminate\Contracts\Config\Repository'],
                $app['Intervention\Image\ImageManager'],
                $app['Illuminate\Session\Store'],
                $app['Illuminate\Hashing\BcryptHasher'],
                $app['Illuminate\Support\Str']
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        // Force SSL in production
        /*if ($this->app->environment() === 'production') {
            URL::forceScheme('https');
        }*/

        $this->extendValidator($this->app['validator']);
    }

    protected function extendValidator(ValidationFactory $validator)
    {
        $validator->extend('captcha', function ($attribute, $value, $parameters) {
            return \Captcha::check($value);
        });

        $validator->extend('captcha_api', function ($attribute, $value, $parameters) {
            return \Captcha::check_api($value, $parameters[0]);
        });
    }
}
