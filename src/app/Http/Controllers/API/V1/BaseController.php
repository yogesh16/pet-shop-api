<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

/**
 * @OA\Info(
 *     description="This is API Documentation for Pet Shop.
You can explore more about API and try out to learn more.",
 *     version="1.0.0",
 *     title="Pet Shop API - Swagger Documentation",
 *     @OA\Contact(
 *         email="yogesh.patel@outlook.in"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 * @OA\Tag(
 *     name="Admin",
 *     description="Admin API endpoint"
 * )
 */
class BaseController extends Controller
{

}
