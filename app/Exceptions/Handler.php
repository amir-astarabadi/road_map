<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof ModelNotFoundException) {
            preg_match('/\[.+\]/', $e->getMessage(), $matches);
            if (empty($matches)) {
                return response()->json(['message' => "your requested resource not found!"]);
            }

            $target = $matches[0];

            $target = str_replace('[', '', $target);
            $target = str_replace(']', '', $target);

            $modelNamespace = explode('\\', $target); 
            
            $model = end($modelNamespace);

            return response()->json(['message' => "your requested $model not found!"]);
        }

        return parent::render($request, $e);
    }
}
