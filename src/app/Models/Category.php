<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
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
        'title',
        'slug',
    ];

    /**
     * @OA\Property(
     *     description="Title",
     *     title="Title",
     * )
     *
     * @var string
     */
    private $title;

    /**
     * @OA\Property(
     *     description="Slug",
     *     title="Slug",
     * )
     *
     * @var string
     */
    private $slug;
}
