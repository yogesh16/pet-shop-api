<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

trait Filters
{
    /**
     * Sort by filter
     *
     * @param Builder $query
     *
     * @param Request $request
     *
     * @return Builder
     */
    public static function sortByFilter(Builder $query, Request $request): Builder
    {
        if ($request->has('sortBy')) {
            $isDesc = $request->input('desc', false);
            $direction = $isDesc === 'true' ? 'DESC' : 'ASC';

            $query->orderBy($request->input('sortBy'), $direction);
        }

        return $query;
    }

    public static function commonFilter(Builder $query, Request $request, array $keys): Builder
    {
        $data = Collection::make($request->all())->only($keys);

        foreach ($data as $key => $value) {
            $query->orWhere($key, 'LIKE', $value);
        }

        return $query;
    }
}
