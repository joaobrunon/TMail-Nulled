<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class HttpsProtocol {
    public function handle($request, Closure $next) {
        if (!$request->secure() && App::environment() === 'production' && env('APP_FORCE_HTTPS')) {
            return redirect()->secure($request->getRequestUri(), 301);
        }
        return $next($request); 
    }
}