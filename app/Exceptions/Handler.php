<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            if ($e instanceof \Illuminate\Http\Exceptions\ThrottleRequestsException) {
                auth()->logout();
    
                if (request()->routeIs('login')) {
                    return back()->with('error', 'Too many login attempts. Please try again in :seconds seconds.');
                }
    
                return redirect()->route('login')->with('error', 'Too many login attempts. Please try again in :seconds seconds.');
            }

            if ($e instanceof \Illuminate\Session\TokenMismatchException) {
                auth()->logout();
    
                if (request()->routeIs('login')) {
                    return back()->with('error', 'Token Mismatch. Please try again.');
                }
    
                return redirect()->route('login')->with('error', 'Token Mismatch. Please try again.');
            }

            // solved error Attempt to read property "role" on null
            // if ($e instanceof \ErrorException) {
            //     auth()->logout();
    
            //     if (request()->routeIs('login')) {
            //         return back()->with('error', 'Error. Please try again.');
            //     }
    
            //     return redirect()->route('login')->with('error', 'Error. Please try again.');
            // }
        });
    }
}
