<?php

namespace Zen\Form;

use Illuminate\Support\ServiceProvider;

class ZenFormServiceProvider extends ServiceProvider {
    public function boot() {
        $this->publishes([
            __DIR__ . '/config/zen/form.php' => config_path('zen/form.php')
        ], 'config');
        $this->publishes([
            __DIR__ . '/resources/views' => resource_path('views/vendor/zenform')
        ]);

        $this->mergeConfigFrom(__DIR__ . '/config/zen/form.php', 'zen.form');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'zenform');
    }
}