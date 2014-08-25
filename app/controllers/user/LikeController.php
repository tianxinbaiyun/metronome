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
        // $this->beforeFilter('csrf', ['on'=>'post']);
        // $this->beforeFilter('auth', ['only'=>['store', 'destroy']]);
        $this->beforeFilter(function(){
            if (Auth::guest()) {
                $script = join(URL::to('login'), ['Turbolinks.visit(\'', '\');']);
                return Response::make($script, 200)->header('Content-Type', 'application/javascript');
            }
        });
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
        $script = "$('.topic-opt>a').addClass('heart').data('method', 'delete').attr('href', '{$url}');";

        return Response::make($script, 200)->header('Content-Type', 'application/javascript');
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
        $script = "$('.topic-opt>a').removeClass('heart').data('method', 'post').attr('href', '{$url}');";

        return Response::make($script, 200)->header('Content-Type', 'application/javascript');
    }
}
