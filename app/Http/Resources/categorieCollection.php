<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class categorieCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     * 
     */
    public function __construct($collection){
        $this->collection=$collection;
    }

    public function toArray($request)
    {
        return [
            // "data"=>parent::toArray($request)["data"],
            "message"=>"",
            "data"=>$this->collection->toArray($request)["data"],
            "links"=>$this->collection->toArray($request)["links"],
            "succes"=>true

        ];
    }
}
