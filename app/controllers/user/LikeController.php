<?php namespace User;

use URL;
use Auth;
use Topic;
use Response;
use BaseController;
use Metronome\Models\Likeable;

class LikeController extends BaseController {

    public function __construct()
    {
        $this->beforeFilter('csrf', ['on'=>['post', 'delete']]);
        $this->beforeFilter('auth.turbo', ['only'=>['store', 'destroy']]);
    }

    public function store($id)
    {
        $topic = Topic::findOrFail($id);

        if (! $topic) App::abort(404);

        $likeable = Likeable::firstOrCreate([
            'likeable_type' => 'Topic',
            'likeable_id'   => $topic->id,
            'liker_id'      => Auth::user()->id,
        ]);

        $url = URL::to(join('/', ['topic', $topic->id, 'unlike']));
        $script = "$('.topic-opt>a:first').addClass('heart').data('method', 'delete').attr('href', '{$url}');";

        return Response::turbo($script);
    }

    public function destroy($id)
    {
        $topic = Topic::findOrFail($id);

        if (! $topic) App::abort(404);

        $likeable = Likeable::whereLikerId(Auth::user()->id)
            ->whereLikeableId($topic->id)
            ->whereLikeableType('Topic')
            ->first();

        if ($likeable)
        {
            $likeable->delete();
        }

        $url = URL::to(join('/', ['topic', $topic->id, 'like']));
        $script = "$('.topic-opt>a:first').removeClass('heart').data('method', 'post').attr('href', '{$url}');";

        return Response::turbo($script);
    }
}
