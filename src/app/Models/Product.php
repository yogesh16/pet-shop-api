<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

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

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_uuid',
        'title',
        'uuid',
        'price',
        'description',
        'metadata',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'deleted_at' => 'datetime',
        'metadata' => 'json',
    ];

    /**
     * @param Request $request
     *
     * @return Builder
     */
    public static function filter(Request $request): Builder
    {
        $query = Product::query();

        $keys = [
            'price',
            'title'
        ];

        $data = Collection::make($request->all())->only($keys);

        foreach ($data as $key => $value) {
            $query->orWhere($key, 'LIKE', $value);
        }

        if($request->has('category')) {
            $query->orWhere('category_uuid', $request->input('category'));
        }

        if($request->has('brand')) {
            $query->orWhere('metadata->brand', $request->input('brand'));
        }

        if ($request->has('sortBy')) {
            $isDesc = $request->has('desc') ? $request->input('desc') : false;

            $query->orderBy($request->input('sortBy'), $isDesc === true ? 'DESC' : 'ASC');
        }

        return $query;
    }
}