<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class articleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            "id"=>$this->id,
            "libelle"=>$this->libelle,
            "prix"=>$this->prix,
            "stock"=>$this->libelle,
            "categorie"=>$this->categorie->libelle,
            "fournisseurs"=> ArticleFournisseurResoource::collection($this->articleFournisseur),
            "photo"=>$this->photo,
            "reference"=>$this->reference,
            ]; 
    }
}
