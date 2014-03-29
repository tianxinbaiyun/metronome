<?php

class TopicController extends BaseController {

    public function __construct()
    {

    }

    public function create()
    {
        return View::make('topics.new');
    }

    public function store()
    {
        $topic = new Topic;
        $topic->category_id = 1;
        $topic->user_id = Auth::user()->id;
        $topic->title = Input::get('title');
        $topic->body = Input::get('body');
        $topic->save();
        return Redirect::to('/');
    }

    public function index()
    {
        return View::make('topics.index')
            ->withTopics(Topic::all());
    }
}
