<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Throwable;

class CatchExceptions
{
    public function handle(Request $request, Closure $next)
    {
        try {
            return $next($request);
        } catch (QueryException $e) {
            \Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Database error occurred. Please try again or contact support.');
        } catch (Throwable $e) {
            \Log::error($e->getMessage());
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }
}
