<?php

namespace Drzl\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Process\Exceptions\ProcessTimedOutException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        // \Illuminate\Database\Eloquent\ModelNotFoundException::class,
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
       //
    }

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $e
     * @return void
     *
     * @throws \Throwable
     */
    public function report (\Throwable $exception)
    {
        if ($exception instanceof ProcessTimedOutException) {
            with($exception->getMessage(), function ($message) {
                app('output')->writeln("<error>{$message}</error>");
                exit(1);
            });
        }
    }
}