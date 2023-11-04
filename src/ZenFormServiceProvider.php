<?php

namespace Zen\Form;

use Illuminate\Support\ServiceProvider;

class ZenFormServiceProvider extends ServiceProvider {
    public function boot() {
        $this->publishes([
            __DIR__ . '/config/zen/form.php' => config_path('zen/form.php')
        ], 'config');

        $this->loadViewsFrom(__DIR__ . '/resources/views', 'zenform');
    }
}