<?php namespace User;

use BaseController;

class SubscribeController extends BaseController {

    public function __construct()
    {
        $this->beforeFilter('csrf', ['on'=>['post', 'delete']]);
        $this->beforeFilter('auth.turbo', ['only'=>['store', 'destroy']]);
    }
}
