<?php namespace Metronome\Models;

use Eloquent;

class Subscriber extends Eloquent {

    protected $table = 'users';

    protected $hidden = ['password'];

    public function topics()
    {
        return $this->morphedByMany('Topic', 'subscribable');
    }
}
