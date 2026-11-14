<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Session\Middleware\StartSession;
use Symfony\Component\HttpFoundation\Response;

class StartAdminSession extends StartSession
{
    public function __construct()
    {
        parent::__construct(app('session'));
    }

    public function handle($request, Closure $next)
    {
        $auth = app('auth');

        try {
            return parent::handle($request, $next);
        } finally {
            $auth->shouldUse('web');
        }
    }
}
