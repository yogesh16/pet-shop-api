<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Petshop\CurrencyExchangeRate\Currency;

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
        'updated_at',
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
     * Get category
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_uuid', 'uuid');
    }

    /**
     * Get Brand
     *
     * @return Brand|null
     */
    public function getBrandAttribute(): ?Brand
    {
        return Brand::uuid($this->metadata['brand'] ?? '')->first();
    }

    /**
     * Get Image File
     *
     * @return File|null
     */
    public function getFileAttribute(): ?File
    {
        return File::uuid($this->metadata['image'] ?? '')->first();
    }

    /**
     * Convert product price to given currency
     * IF Illuminate\Http\Request contain the 'currency' key
     *
     * @return string
     */
    public function getPriceAttribute(): string
    {
        if (request()->has('currency')) {
            return Currency::convert(request()->input('currency'), $this->attributes['price']);
        }
        return $this->attributes['price'];
    }

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
            'title',
        ];

        $data = Collection::make($request->all())->only($keys);

        foreach ($data as $key => $value) {
            $query->orWhere($key, 'LIKE', $value);
        }

        if ($request->has('category')) {
            $query->orWhere('category_uuid', $request->input('category'));
        }

        if ($request->has('brand')) {
            $query->orWhere('metadata->brand', $request->input('brand'));
        }

        if ($request->has('sortBy')) {
            $isDesc = $request->has('desc') ? $request->input('desc') : false;

            $query->orderBy($request->input('sortBy'), $isDesc === true ? 'DESC' : 'ASC');
        }

        return $query;
    }
}
