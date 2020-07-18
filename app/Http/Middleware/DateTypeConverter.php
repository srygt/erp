<?php

namespace App\Http\Middleware;

use Closure;

class DateTypeConverter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)

    {    $replaceddate=str_replace("/","-",$request->sonOdemeTarihi);
         $converteddate=date('Y-m-d',strtotime($replaceddate));
        $request->merge([
            'sonOdemeTarihi'=>$converteddate
        ]);
        return $next($request);
    }
}
