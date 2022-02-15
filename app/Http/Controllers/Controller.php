<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Laravel OpenApi",
 *      description="Laravel OpenApi description",
 *      @OA\Contact(name="Harun Doğdu",email="info@harundogdu.com", url="https://harundogdu.com"),
 *     @OA\License(name="Apache 2.0",url="https://www.apache.org/licenses/LICENSE-2.0.html")
 * )
 * @OA\Server (
 *     description="Laravel OpenApi Server",
 *     url="http://laravel-api.test/api"
 *     )
 */


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
