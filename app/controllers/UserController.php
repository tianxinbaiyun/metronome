<?php

class UserController extends BaseController {

    public function __construct()
    {
        $this->beforeFilter('csrf', ['on'=>['post', 'put', 'patch', 'delete']]);
        $this->beforeFilter('auth', ['only'=>['profileEdit', 'profileUpdate', 'avatarUpdate', 'edit', 'update']]);
    }

    public function index()
    {
        return View::make('user.index')
            ->withUsers(User::with('profile')->take(30))
            ->withTitle(Lang::get('locale.top_30'));
    }

    public function create()
    {
        if (Auth::check()) return Redirect::home();

        return View::make('user.new')
            ->withTitle(Lang::get('locale.signup'));
    }

    public function store()
    {
        $params = array_merge(Input::all(), ['email'=>Input::get('email')]);

        $validator = new Metronome\Validators\UserValidator($params);

        if ($validator->fails())
        {
            Session::flash('message', $validator->messages()->first());

            return Redirect::to('signup')
                ->withInput();
        }

        $user = new User([
            'email'    => $params['email'],
            'username' => $params['username'],
            'downcase' => $params['username']
        ]);

        $user->avatar_url = Str::gravatarUrl($user->email);
        $user->password = Hash::make($params['password']);

        if (in_array($user->email, Config::get('website.owners')))
        {
            $user->backendable = true;
        }

        if (! $user->save()) return Redirect::to('signup');

        $user->profile()->save(new Profile);

        Event::fire('user.stat', [$user]);

        Auth::login($user);

        return Redirect::home();
    }

    public function profileShow($username)
    {
        $user = User::whereUsername($username)->first() ?: User::whereDowncase(strtolower($username))->first();

        if (! $user) {
            App::abort();
        }

        if (Input::get('tab') == 'activity') {
            $user->events = $user->events()->orderBy('created_at', 'desc')->limit(20)->get();

            return View::make('user.profile.activity')
                ->withUser($user)
                ->withTitle(Lang::get('locale.activity'));
        }

        if (Input::get('tab') == 'topic') {
            $user->load('topics');
            return View::make('user.profile.topics')
                ->withUser($user)
                ->withTitle(Lang::get('locale.topic'));
        }

        $user->load('profile');

        return View::make('user.profile.show')
            ->withUser($user)
            ->withTitle($user->username);
    }

    public function profileEdit()
    {
        return View::make('user.profile.edit')
            ->withUser(Auth::user()->load('profile'))
            ->withTitle(Lang::get('locale.edit_profile'));
    }

    public function profileUpdate()
    {
        Auth::user()->profile->update([
            'nickname'      => Input::get('nickname'),
            'location'      => Input::get('location'),
            'school'        => Input::get('school'),
            'website_url'   => Input::get('website_url'),
            'contact_email' => Input::get('contact_email'),
            'biography'     => Input::get('biography')
        ]);

        Session::flash('message', Lang::get('locale.profile_updated'));

        return Redirect::to('settings/profile');
    }

    public function avatarUpdate()
    {
        $validator = Validator::make(Input::all(), ['avatar'=>'mimes:jpeg,jpg,png,gif']);

        if ($validator->fails()) {
            return Redirect::to('settings/profile');
        }

        $user = Auth::user();

        $avatar = new Metronome\Utils\Avatar(Input::file('avatar'));
        $avatar->touch($user->email)->save();

        $user->avatar_url = URL::to(join('/', ['avatars', md5($user->email).'s92.jpg']));
        $user->save();

        return Redirect::back();
    }

    public function edit()
    {
        return View::make('user.password.edit')
            ->withTitle(Lang::get('locale.change_password'));
    }

    public function update()
    {
        $user = Auth::user();

        if (! Hash::check(Input::get('current_password'), $user->password)) {
            Session::flash('message', Lang::get('locale.old_pw_incorrect'));
            return Redirect::to('settings/password');
        }

        $validator = Validator::make(Input::all(), [
            'password'              => 'required|alpha_dash|between:6,16|confirmed',
            'password_confirmation' => 'required|alpha_dash|between:6,16'
        ]);

        if ($validator->fails()) {
            Session::flash('message', $validator->messages()->first('password'));
            return Redirect::to('settings/password');
        }

        $user->password = Hash::make(Input::get('password'));
        $user->save();

        Session::flash('message', Lang::get('locale.password_updated'));

        return Redirect::to('settings/password');
    }

    public function verify($token)
    {
        $profile = Profile::whereVerifyToken($token)->first();

        if (is_null($profile)) App::abort(404);

        $user = $profile->user;

        if ($user->verify) App::abort(400);

        $user->verify = true;
        $user->save();

        return Redirect::to('/');
    }

    public function likes($username)
    {
        $user = Auth::user();
        $liker = Metronome\Models\Liker::find($user->id);
        $user->topics = $liker->topics;

        return View::make('user.likes')
            ->withUser($user)
            ->withTitle(Lang::get('locale.likes'));
    }

    public function topics($username)
    {
        $user = Auth::user();

        $user->load('topics');

        return View::make('user.topics')
            ->withUser($user)
            ->withTitle(Lang::get('locale.topic'));
    }

    public function replies($username)
    {
        return View::make('user.replies')
            ->withUser(Auth::user())
            ->withTitle(Lang::get('locale.reply'));
    }

    public function following($username)
    {
        if (! $user = User::with('following')->whereUsername($username)->first()) {
            App::abort();
        }

        return View::make('user.following')
                ->withUser($user)
                ->withTitle(Lang::get('locale.following'));
    }

    public function followers($username)
    {
        if (! $user = User::with('followers')->whereUsername($username)->first()) {
            App::abort();
        }

        return View::make('user.followers')
                ->withUser($user)
                ->withTitle(Lang::get('locale.followers'));
    }

    public function watching($username)
    {
        return View::make('user.watching')
            ->withUser(Auth::user())
            ->withTitle(Lang::get('locale.watching'));
    }

    public function photos($username)
    {
        return View::make('user.photos')
            ->withUser(Auth::user())
            ->withTitle(Lang::get('locale.photos'));
    }
}
