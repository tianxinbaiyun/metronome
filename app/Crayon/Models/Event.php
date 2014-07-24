<?php namespace Crayon\Models;

use Eloquent;

class Event extends Eloquent {

    public function user()
    {
        return $this->belongsTo('User');
    }
}
