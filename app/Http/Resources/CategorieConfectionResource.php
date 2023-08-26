<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategorieConfectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public $mes;

    public function __construct($resource, $mes){
        $this->resource=$resource;
        $this->mes=$mes;
    }
    public function toArray(Request $request): array
    {
        return [
            "message"=>$this->mes,
            "data"=>$this->resource,
            "succes"=>true,
        ];
    }
    public function categorieResource(Request $request): array
    {
        return [
            "id"=>$this->id,
            "libelle"=>$this->libelle,
        ];
    }
}
