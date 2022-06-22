<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(title="YEAH API", version="1.0")
 */
class ApiController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
