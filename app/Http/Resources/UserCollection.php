<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    public function __construct($resource,$paginate = true)
    {
        parent::__construct($resource);
    }

    public function toArray($request)
    {

        return [
            "data" => $this->collection->map(function(User $resource) use($request){
                return $resource->toArray($request);
            })->all()
        ];
    }
}
