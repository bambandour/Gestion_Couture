<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticleVenteCollection extends ResourceCollection
{
    public $mes;
    public function __construct($collection , $mes){
        $this->collection=$collection;
        $this->mes=$mes;
    }
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "message"=>$this->mes,
            "data"=>$this->articleVenteCollection($this->collection),
            "links"=>$this->collection->toArray()["links"],
            "succes"=>true,
        ];
    }

    public function articleVenteCollection($collection)
    {
      return $collection->map (function($article){
             
        return[
                "id"=>$article->id,
                "libelle"=>$article->libelle,
                "prix_vente"=>$article->prix_vente,
                "cout_fabrication"=>$article->cout_fabrication,
                "marge"=>$article->marge,
                "promo"=>$article->promo,
                "stock"=>$article->stock,
                "categorie"=>$article->categorie->libelle,
                "photo"=>$article->photo,
                "reference"=>$article->reference,
                ];
        }
        )->toArray();
    }
}
