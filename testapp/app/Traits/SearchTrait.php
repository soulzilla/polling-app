<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait SearchTrait
{
    public function search(Request $request): Builder
    {
        /** @var Builder $query */
        $query = $this->modelClass::query();
        $sort = $request->get('sort', 'id');
        $direction = str_starts_with($sort, '-') ? 'desc' : 'asc';
        $column = str_starts_with($sort, '-') ? ltrim($sort, '-') : $sort;

        $query->orderBy($column, $direction);

        return $this->prepareQuery($query, $request);
    }

    public function prepareQuery(Builder $query, Request $request): Builder
    {
        return $query;
    }
}
