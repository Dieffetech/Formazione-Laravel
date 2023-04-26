<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait PaginationTrait
{
    public static function paginate($forPage = null, $search = [], $page = null)
    {
        $query = self::getQueryForApi($search);

        if (!empty($forPage) && $forPage != 1) {
            $models = $query->paginate($forPage, ["*"], "page", $page);
        } else {
            $models = $query->get();
        }

        if ($forPage == 1) {
            return $models[0] ?? null;
        }

        return $models;
    }

    public static function paginateSorted($ids, $forPage = null, $search = [], $page = null)
    {
        return self::paginate($forPage, $search, $page)->sortBy(function ($item, $key) use ($ids) {
            return array_search($item->id, $ids);
        });
    }

}
