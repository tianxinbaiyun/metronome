<?php namespace User;

use BaseController;

class SubscribeController extends BaseController {

    public function destroy($id)
    {
        var_dump(\Request::ajax());
    }
}
