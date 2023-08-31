<?php

namespace App\Http\Middleware;

use Closure;
use App\AccessKey;
use Illuminate\Support\Facades\Hash;

class CheckAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $accessKey = AccessKey::select('public')->where('facility_id',$request->facility_id)->firstOrFail();

        if(Hash::check($request->route('key'),$accessKey->public))
            return $next($request);

        return 'asdasd';
    }
}
