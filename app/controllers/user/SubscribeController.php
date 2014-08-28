<?php namespace User;

use BaseController;
use Response;

class SubscribeController extends BaseController {

    public function __construct()
    {
        $this->beforeFilter('csrf', ['on'=>['post', 'delete']]);
        $this->beforeFilter('auth.turbo', ['only'=>['store', 'destroy']]);
    }

    public function store()
    {

    }

    public function destroy()
    {
        $script = "$('.topic-opt>a:last').addClass('checked').data('method', 'delete').attr('href', '');";

        return Response::turbo($script);
    }
}
