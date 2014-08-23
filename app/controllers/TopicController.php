<?php

class TopicController extends BaseController {

    public function __construct()
    {
        $this->beforeFilter('csrf', ['on'=>'post']);
        $this->beforeFilter('auth', [
            'except'=>['index', 'show', 'byCategory', 'newest']
        ]);
    }

    public function index()
    {
        return View::make('topic.index')
            ->withTitle(Lang::get('locale.popular_topic'))
            ->withCategories(Category::all())
            ->withTopics(Topic::with('user', 'category')->popular()->paginate(16));
    }

    public function create()
    {
        return View::make('topic.new')
            ->withTitle(Lang::get('locale.new_topic'))
            ->withCategories(Category::all());
    }

    public function show($id)
    {
        $topic = Topic::findOrFail($id);

        $replies = $topic->replies;
        $replies->load('user', 'text');

        $topic->load('user', 'category');

        $following_count = Relationship::whereFollowerId($topic->user->id)->count();
        $followers_count = Relationship::whereFollowedId($topic->user->id)->count();

        $likers = $topic->likers()->lists('liker_id');
        $liker_right = Auth::check() ? in_array(Auth::user()->id, $likers) : false;

        $likers_count = count($likers);
        $topics_count = $topic->user->topics()->count();

        $topic->body = $topic->text->markup;

        return View::make('topic.show')
            ->withTitle($topic->title)
            ->withTopic($topic)
            ->withReplies($replies)
            ->withFollowingCount($following_count)
            ->withFollowersCount($followers_count)
            ->withTopicsCount($topics_count)
            ->withLikersCount($likers_count)
            ->withLikerRight($liker_right);
    }

    public function store()
    {
        $validator = new Metronome\Validators\TopicValidator;

        if ($validator->fails())
        {
            Session::flash('message', $validator->messages()->first());
            return Redirect::to('topic/new')
                ->withInput();
        }

        $category_id = Input::get('category_id');

        $topic = new Topic([
            'category_id' => $category_id,
            'title'       => Input::get('title'),
            'body'        => ''
        ]);

        $text = new Text([
            'markup'   => Sanitization::make(Markdown::make(Input::get('body'))),
            'markdown' => Input::get('body')
        ]);

        Auth::user()->topics()->save($topic);
        $topic->text()->save($text);

        Category::findOrFail($category_id)->increment('topics_count');

        $activity = new Metronome\Repositories\ActivityRepository;
        $activity->touch($topic)->newTopicEvent();

        return Redirect::to('/');
    }

    public function edit($id)
    {
        $topic = Topic::with('category')->findOrFail($id);
        $topic->body = $topic->text->markdown;

        return View::make('topic.edit')
            ->withTitle(Lang::get('locale.edit_topic'))
            ->withCategories(Category::all())
            ->withTopic($topic);
    }

    public function update($id)
    {
        $topic = Topic::findOrFail($id);

        $validator = new Metronome\Validators\TopicValidator;

        if ($validator->fails()) {
            Session::flash('message', $validator->messages()->first());
            return Redirect::back();
        }

        if ($topic->user_id == Auth::user()->id) {
            $topic->update([
                'category_id' => Input::get('category_id'),
                'title'       => Input::get('title'),
                'body'        => Input::get('body')
            ]);

            $topic->text()->update([
                'markup'   => Sanitization::make(Markdown::make($body = Input::get('body'))),
                'markdown' => $body
            ]);
        }

        Session::flash('message', Lang::get('locale.topic_updated'));

        return Redirect::back();
    }

    public function destroy($id)
    {

    }

    public function newest()
    {
        $topics = Topic::with('user', 'category')->orderBy('created_at', 'desc')->paginate(16);

        return View::make('topic.index')
            ->withTitle(Lang::get('locale.newest_topic'))
            ->withCategories(Category::all())
            ->withTopics($topics);
    }

    public function byCategory($id)
    {
        $category = Category::findOrFail($id);

        $topics = Topic::with('user', 'category')->whereCategoryId($category->id)->popular()->paginate(16);

        return View::make('topic.index')
            ->withTitle($category->name)
            ->withCategories(Category::all())
            ->withTopics($topics);
    }
}
