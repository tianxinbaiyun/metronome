<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

    protected $table = 'users';

    protected $hidden = ['password', 'remember_token'];

    protected $fillable = ['email', 'username', 'downcase'];

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    public function getReminderEmail()
    {
        return $this->email;
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    public function setDowncaseAttribute($value)
    {
        $this->attributes['downcase'] = strtolower($value);
    }

    public function normalUser()
    {
        return ! $this->backendable;
    }

    public function profile()
    {
        return $this->hasOne('Profile');
    }

    public function stat()
    {
        return $this->hasOne('Stat');
    }

    public function topics()
    {
        return $this->hasMany('Topic');
    }

    public function followers()
    {
        return $this->belongsToMany('User', 'relationships', 'followed_id', 'follower_id');
    }

    public function following()
    {
        return $this->belongsToMany('User', 'relationships', 'follower_id', 'followed_id');
    }

    public function replies()
    {
        return $this->hasMany('Reply');
    }

    public function events()
    {
        return $this->hasMany('Metronome\Models\Event');
    }

    public function photos()
    {
        return $this->morphMany('Photo', 'imageable');
    }

    public function notifications()
    {
        return $this->hasMany('Notification');
    }

    public function scopeNormal($query)
    {
        return $query->whereBackendable(false)->orderBy('id', 'desc');
    }
}
