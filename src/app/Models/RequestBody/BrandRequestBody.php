<?php

namespace App\Models\RequestBody;

/**
 * @OA\RequestBody(
 *     request="Brand",
 *     description="Brand category object",
 *     required=true,
 *     @OA\JsonContent(ref="#/components/schemas/Brand"),
 *     @OA\MediaType(
 *         mediaType="application/x-www-form-urlencoded",
 *         @OA\Schema(ref="#/components/schemas/Brand")
 *     )
 * )
 */
class BrandRequestBody
{
}
