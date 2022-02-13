<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ApiLogger
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }

    public function terminate(Request $request, $response)
    {
        if (env('API_LOGGER_ENABLED', true)) {
            $startTime = LARAVEL_START;
            $endTime = microtime(true);

            $log = '[METHOD: ' . $request->method() . ']';
            $log .= '[URL: ' . $request->fullUrl() . ']';
            $log .= '[TIME: ' . (microtime(true) - LARAVEL_START) . ']';
            $log .= '[IP: ' . $request->ip() . ']';
            $log .= '[USER-AGENT: ' . $request->userAgent() . ']';
            $log .= '[REQUEST: ' . json_encode($request->all()) . ']';
            $log .= '[RESPONSE: ' . json_encode($response->getData()) . ']';
            $log .= '[RESPONSE-TIME: ' . ($endTime - $startTime) . ']';

            // Log::info($log); // standart log dosyası storage altına oluşturur.

            /* Custom Logger */
            $fileName = 'api-log-' . date('Y-m-d') . '.log';
            File::append(storage_path('logs' . DIRECTORY_SEPARATOR . $fileName), $log . PHP_EOL);
        }
    }
}
