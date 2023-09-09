<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArtVenteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "libelle"=>$this->libelle,
            "prix_vente"=>$this->prix_vente,
            "cout_fabrication"=>$this->cout_fabrication,
            "marge"=>$this->marge,
            "promo"=>$this->promo,
            "stock"=>$this->stock,
            "categorie"=>$this->categorie->libelle,
            "photo"=>$this->photo,
            "reference"=>$this->reference,
            "confections"=>ArticleAssociationResource::collection($this->article_ventes),
        ];
    }
}
