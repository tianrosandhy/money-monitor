<?php
namespace App\Core\Http\Middleware;

use Closure;
use Language;
use App;

class SetLocale {

    public function handle($request, Closure $next)
    {
        $lang = session('lang', Language::default());
        App::setLocale($lang);
        session(['lang' => $lang]);

        return $next($request); 
    }
}