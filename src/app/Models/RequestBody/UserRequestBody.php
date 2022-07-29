<?php


namespace App\Models\RequestBody;

/**
 * @OA\RequestBody(
 *     request="User",
 *     description="Create user object",
 *     required=true,
 *     @OA\JsonContent(ref="#/components/schemas/User"),
 *     @OA\MediaType(
 *         mediaType="application/x-www-form-urlencoded",
 *         @OA\Schema(ref="#/components/schemas/User")
 *     )
 * )
 */
class UserRequestBody
{

}
