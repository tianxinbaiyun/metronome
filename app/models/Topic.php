<?php

class Topic extends Eloquent {

    protected $fillable = ['category_id', 'title', 'body'];

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function category()
    {
        return $this->belongsTo('Category');
    }

    public function replies()
    {
        return $this->hasMany('Reply');
    }

    public function text()
    {
        return $this->morphOne('Text', 'textable');
    }

    public function likers()
    {
        return $this->morphToMany('Metronome\Models\Liker', 'likeable');
    }

    public function tags()
    {
        return $this->morphToMany('Tag', 'taggable');
    }

    public function watchers()
    {
        return $this->likers();
    }

    public function scopePopular($query)
    {
        return $query->orderBy('ranking', 'desc')->orderBy('created_at', 'desc');
    }

    public function scopeSearch($query, $keyword)
    {
        return $query->where('title', 'LIKE', Str::matching($keyword))->popular()->paginate(16);
    }

    public function createdAt()
    {
        $datetime = new Metronome\Utils\DateTime($this->created_at);
        return $datetime->pretty();
    }
}
