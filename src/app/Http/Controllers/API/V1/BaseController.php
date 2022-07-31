<?php

namespace App\Http\Controllers\API\V1;

use App\Traits\ApiResponse;
use Illuminate\Routing\Controller;

/**
 * @OA\Info(
 *     description="This is API Documentation for Pet Shop.
 *     You can explore more about API and try out to learn more.",
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
 *
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      in="header",
 *      name="bearerAuth",
 *      type="http",
 *      scheme="bearer",
 *      bearerFormat="JWT",
 * )
 *
 * @OA\Tag(
 *     name="Admin",
 *     description="Admin API endpoint"
 * )
 *
 * @OA\Tag(
 *     name="User",
 *     description="User API endpoint"
 * )
 *
 * @OA\Tag(
 *     name="Category",
 *     description="Categories API endpoint"
 * )
 *
 * @OA\Tag(
 *     name="Brand",
 *     description="Brands API endpoint"
 * )
 *
 * @OA\Tag(
 *     name="Product",
 *     description="Products API endpoint"
 * )
 *
 * @OA\Tag(
 *     name="File",
 *     description="File API endpoint"
 * )
 */
class BaseController extends Controller
{
    use ApiResponse;
}
