<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageRequest extends FormRequest
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
            'image'=>'required|image|mimes:jpeg,jpg,png,|max:1048'
        ];
    }
    public function messages(){
        return [
            'image.required'=>"l'image est requis ",
            'image.mimes'=>"le format de l'image doit etre jpeg, jpg ou png  ",
            'image.max'=>"la taille max de l'image est 1048 ",
        ];
    }
}
