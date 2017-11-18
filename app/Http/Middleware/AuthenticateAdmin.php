<?php
/**
 * Created by PhpStorm.
 * User: howard
 * Date: 16/5/31
 * Time: 19:25
 */

namespace App\Http\Middleware;

use Closure;
use Route;
use URL;
use Auth;

class AuthenticateAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        $previousUrl = URL::previous();
        $currentRouteName = Route::currentRouteName();
        if ($si = stripos($currentRouteName, '@')) {
            $currentRouteName = substr($currentRouteName, 0, $si);
        }
        if (!Auth::user()->can($currentRouteName)) {
            if ($request->ajax() && ($request->getMethod() != 'GET')) {
                return response()->json([
                    'status' => -1,
                    'code' => 403,
                    'msg' => '您没有权限执行此操作'
                ]);
            } else {
                $user = Auth::user();
                return view('errors.403', compact('previousUrl', 'user'));
            }
        }

        return $next($request);
    }
}