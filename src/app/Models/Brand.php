<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Class Brand.
 *
 * @OA\Schema(
 *     title="Brand model",
 *     description="Brand model",
 *     required={"title"},
 * )
 */
class Brand extends Model
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

    /**
     * @param Request $request
     *
     * @return Builder
     */
    public static function filter(Request $request): Builder
    {
        $query = Brand::query();

        if ($request->has('sortBy')) {
            $isDesc = $request->has('desc') ? $request->input('desc') : false;

            $query->orderBy($request->input('sortBy'), $isDesc === true ? 'DESC' : 'ASC');
        }

        return $query;
    }
}
