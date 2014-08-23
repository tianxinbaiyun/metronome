<?php

class NotificationController extends BaseController {

    public function __construct()
    {
        $this->beforeFilter('csrf', ['on'=>['post', 'put', 'patch', 'delete']]);
        $this->beforeFilter('auth', []);
    }

    public function index()
    {
        return View::make('notify.index')
            ->withTitle(Lang::get('locale.notify'))
            ->withNotifications(Auth::user()->notifications);
    }
}
