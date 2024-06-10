<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckStatus
{
  /**
   * Handle an incoming request.
   *
   * @param \Illuminate\Http\Request $request
   * @param \Closure $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
    if (Auth::check()) {

      if (auth()->user()->is_active == '1') {
        return $next($request);
      }
      $role = Auth::user()->role;
      if ($role == 'admin') {
        $routeName = 'auth-login-basic';
      } else {
        $routeName = 'auth-login-cover';
      }
      return redirect()->route($routeName)->withErrors('You are Inactive,contact to admin');
    } else {

      return redirect()->route('auth-login-basic')->withErrors('You are not login?');
    }
  }
}
