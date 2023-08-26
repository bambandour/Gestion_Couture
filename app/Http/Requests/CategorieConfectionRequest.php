<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategorieConfectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
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
        ];
    }
    public function messages(){
        return [
            "libelle.required"=>"le libelle du categorie est requis",
            "libelle.unique"=>"le libelle du categorie doit est unique",
            "libelle.min"=>"le libelle du categorie doit avoir au moins 3 caracteres",
        ];
    }
}
