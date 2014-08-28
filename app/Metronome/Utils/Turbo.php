<?php namespace Metronome\Utils;

use Cookie;
use Request;
use Session;
use Illuminate\Http\RedirectResponse;

class Turbo {

    private $request;

    public function __construct() {}

    public function setUp($request = null)
    {
        $request = $request ?: Request::instance();
        $this->setRequestMethodCookie($request->getMethod());
    }

    public function handle($request, $response)
    {
        $this->request = $request;

        $this->setXhrRedirectedTo($response);

        if ($response instanceof RedirectResponse)
        {
            $this->storeForTurbolinks($response->getTargetUrl());
            $this->abortXdomainRedirect($response);
        }
    }

    public function redirectViaTurbolinksTo($url, $status = 200)
    {
        return Response::make(join($url, ["Turbolinks.visit('", "');"]), $status)->header('Content-Type', 'application/x-javascript');
    }

    private function setRequestMethodCookie($method)
    {
        Cookie::queue('request_method', $method);
    }

    private function setXhrRedirectedTo($response)
    {
        if (Session::has('_turbolinks_redirect_to'))
        {
            $response->header('X-XHR-Redirected-To', Session::pull('_turbolinks_redirect_to'));
        }
    }

    private function storeForTurbolinks($url)
    {
        if ($this->referer()) Session::put('_turbolinks_redirect_to', $url);
    }

    private function abortXdomainRedirect($response)
    {
        $current = $this->request->headers->get('X-XHR-Referer') ?: null;
        $next = $response->headers->get('Location') ?: null;

        if (! (is_null($current) or is_null($next) or $this->sameOrigin($current, $next)))
        {
            $response->setStatusCode(403);
        }
    }

    private function sameOrigin($current, $next) {
        return $this->getArray($current) == $this->getArray($next);
    }

    private function getArray($url)
    {
        return array_only(parse_url($url), ['scheme', 'host', 'port']);
    }

    private function referer()
    {
        return $this->request->headers->get('X-XHR-Referer') ?: $this->request->headers->get('Referer');
    }
}
