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
        $this->app->bind('translate', function() {
            return new Translate();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            dirname(__DIR__).'/config/youdao.php' => config_path('youdao.php'),
        ]);
    }
}
