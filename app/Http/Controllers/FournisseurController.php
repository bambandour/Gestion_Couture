<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FournisseurController extends Controller
{
    public function store(Request $request){
        $fournisseur=Fournisseur::create([
            "libelle"=>$request->libelle
        ]);
        return [
            'codeStatut' => Response::HTTP_OK,
            'message' => 'le fournisseur a été ajouté avec succés',
            'data'   => $fournisseur
        ];
    }
}
