<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|array  $roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        // التحقق من وجود المستخدم
        if (!$user) {
            return redirect()->route('login')->with('error', 'يرجى تسجيل الدخول للوصول إلى هذه الصفحة.');
        }

        if (!in_array($user->role, $roles)) {
            return redirect()->back()->with('error', 'ليس لديك صلاحية الدخول لهذه الصفحة.');
        }

        return $next($request);
    }
}
