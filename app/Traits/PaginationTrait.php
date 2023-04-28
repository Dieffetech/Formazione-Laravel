<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

trait PaginationTrait
{
    public static function paginate()
    {
        return QueryBuilder::for(self::class)
            ->defaultSort(self::paginatorSorts())
            ->allowedSorts(self::paginatorSortable())
            ->allowedFilters(self::paginatorFilterable());
    }

}
