<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

trait Uuids
{
    /**
     * @param Builder $query
     *
     * @param string $uuid
     *
     * @return Builder
     */
    public function scopeUuid(Builder $query, string $uuid): Builder
    {
        return $query->where('uuid', $uuid);
    }
    /**
     * Boot function from Laravel.
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(
            function ($model) {
                $model->uuid = Str::uuid()->toString();
            }
        );
    }
}
