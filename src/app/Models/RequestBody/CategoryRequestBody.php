<?php

namespace App\Models\RequestBody;

/**
 * @OA\RequestBody(
 *     request="Category",
 *     description="Create category object",
 *     required=true,
 *     @OA\JsonContent(ref="#/components/schemas/Category"),
 *     @OA\MediaType(
 *         mediaType="application/x-www-form-urlencoded",
 *         @OA\Schema(ref="#/components/schemas/Category")
 *     )
 * )
 */
class CategoryRequestBody
{
}
