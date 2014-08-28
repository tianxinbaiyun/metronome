<?php namespace Metronome\Providers;

use Illuminate\Support\ServiceProvider;

class TurboServiceProvider extends ServiceProvider {

    protected $defer = true;

    public function register()
    {
        $this->app->bindShared('turbo', function()
        {
            return new \Metronome\Utils\Turbo;
        });
    }

    public function provides()
    {
        return ['turbo'];
    }
}
