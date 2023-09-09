<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticleCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public $mes;
    
    
    public function __construct($collection, $mes){
        $this->collection=$collection;
        $this->mes=$mes;
    }

    public function toArray(Request $request): array
    {
        return [
            "message"=>$this->mes,
            "data"=>$this->articleCollection($this->collection),
            "links"=>$this->collection->toArray()["links"],
            // "data"=>$this->collection,
            "succes"=>true,
        ];
    }

    public function articleCollection($collection)
    {
      return $collection->map (function($article){
             
        return[
                "id"=>$article->id,
                "libelle"=>$article->libelle,
                "prix"=>$article->prix,
                "stock"=>$article->stock,
                "categorie"=>$article->categorie->libelle,
                "fournisseurs"=> ArticleFournisseurResoource::collection($article->articleFournisseur),
                "photo"=>$article->photo,
                "reference"=>$article->reference,
                ];
        })->toArray();
    }
}
