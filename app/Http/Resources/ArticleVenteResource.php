<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleVenteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public $collection;
    public function __construct($collection){
        $this->collection=$collection;
    }

    public function toArray(Request $request): array
    {
        return [
            // "data"=>parent::toArray($request)["data"],
            "message"=>"Listes des Articles",
            "data"=>$this->collection->toArray($request)["data"],
            "links"=>$this->collection->toArray($request)["links"],
            "succes"=>true
        ];
    }
}
