<?php

namespace Youdao\Translate;

use Illuminate\Support\ServiceProvider;

class TranslateServiceProvider extends ServiceProvider
{

    /**
     * @return Translate
     */
    public function register()
    {
        $this->app->bind('translate');

        return new Translate();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
