<?php

class NotificationController extends BaseController {

    public function index()
    {
        return View::make('notify.index');
    }
}