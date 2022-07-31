<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class Category.
 *
 * @OA\Schema(
 *     title="Category model",
 *     description="Category model",
 *     required={"title"},
 * )
 */
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
     * Set slug
     *
     * @param string $value
     */
    public function setTitleAttribute(string $value)
    {
        $this->attributes['title'] = $value;

        $this->attributes['slug'] = Str::slug($value);
    }
}
