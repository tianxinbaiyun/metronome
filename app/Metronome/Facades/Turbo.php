<?php namespace Metronome\Facades;

use Illuminate\Support\Facades\Facade;

class Turbo extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'turbo';
    }
}
