<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class File.
 *
 * @OA\Schema(
 *     title="File model",
 *     description="File model",
 *     required={"file"},
 * )
 */
class File extends Model
{
    use HasFactory;
    use Uuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'name',
        'path',
        'size',
        'type',
    ];
}
