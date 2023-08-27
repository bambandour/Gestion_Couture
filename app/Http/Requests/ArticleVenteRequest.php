<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleVenteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "libelle"=>"required|unique:categorie_confections|min:3",
            "prix_vente"=>"numeric",
            "marge"=>"numeric",
            "cout_fabrication"=>"numeric",
            "stock"=>"required|integer|min:1",
            'categorie' => 'required|string|in:tissu,bouton,fil',

            //     'libelle' => 'required|string|max:255',
            // 'stock' => 'required|integer|min:1',
            // 'categorie' => 'required|string|in:tissu, bouton, fil',
            'photo' => 'nullable|string|mimes:jpeg,jpg,png,|max:1048', 
            'article' => 'required|array|min:3',
            'article.*' => 'required|integer|distinct', 
            'quantite' => 'required|array|min:3',
            'quantite.*' => 'required|integer',
        ];

        
    }
}
