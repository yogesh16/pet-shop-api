<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product.
 *
 * @OA\Schema(
 *     title="Product model",
 *     description="Product model",
 *     required={"title"},
 * )
 */
class Product extends Model
{
    use HasFactory;
    use Uuids;
}
