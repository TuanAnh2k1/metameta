<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AddSanctumTokenToHeaders
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $all = $request->all();
        if (isset($all['_token'])) {
            Log::debug('token from http param', [$all['_token']]);
            $request->headers->set('Authorization', sprintf('%s %s', 'Bearer', $all['_token']));
        }
        return $next($request);
    }
}