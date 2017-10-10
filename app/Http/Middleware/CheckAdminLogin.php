<?php
/**
 * Created by IntelliJ IDEA.
 * User: caizhuojie
 * Date: 2017/8/15
 * Time: 12:23
 */

namespace App\Http\Middleware;

use Closure;
class CheckAdminLogin
{
    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $admin = $request->session()->get('admin', '');
        if($admin == '') {
            return redirect('/as/login');
        }

        return $next($request);
    }
}