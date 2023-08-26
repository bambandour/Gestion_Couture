<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategorieConfectionRequest;
use App\Http\Requests\CategorieConfectionRequestPut;
use App\Http\Resources\categorieCollection;
use App\Http\Resources\CategorieConfectionResource;
use App\Models\CategorieConfection;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategorieConfectionController extends Controller
{
    public function index(){
        $categories=CategorieConfection::all('id','libelle');
        return CategorieConfectionResource::collection($categories);
    }

    public function listerCategories($page=null) {
        if (!empty($page)) {
            $categories=CategorieConfection::orderBy('id','desc')->paginate($page);
            return CategorieConfectionResource::collection($categories);
        }
        $categories=CategorieConfection::orderBy('id','desc')->paginate(3);
        // return CategorieConfectionResource::collection($categories);
        return new categorieCollection($categories);
    }

    public function store(CategorieConfectionRequest $request){
        $categorie=CategorieConfection::create([
            'libelle'=>$request->libelle
        ]);
        return new CategorieConfectionResource($categorie,"le categorie a été ajouté avec succés");
        // return [
        //     "codeStatut"=>Response::HTTP_OK,
        //     "message"=>"l'article a été ajouté avec succés",
        //     "data"=>$categorie
        // ];
    }

    public function update(CategorieConfectionRequestPut $request,CategorieConfection $id){
        if (empty($id)) {
            return response()->json(['message' => 'Catégorie introuvable.'], 404);
        }
        $id->update(['libelle'=>
            $request->libelle
        ]);
        
        return new CategorieConfectionResource($id,"Mise à jour reussi");
        // return [
        //     'codeStatut' => Response::HTTP_ACCEPTED,
        //     'message' => 'Mise à jour reussi',
        //     'data'   => $id
        // ];
    }

    public function delete(Request $request, CategorieConfection $id=null){

        if (!empty($id)) {
            $id->delete();
            return response(["message"=>'suppression effectué avec succes', Response::HTTP_NO_CONTENT]);   
        }

        $ids = $request->ids;
        if (!empty($ids)) {
            CategorieConfection::whereIn('id', $ids)->delete();
            return response()->json(['message' => 'les categories ont été supprimés avec succès.'],Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'Aucun categorie à supprimer.'], 400);
        }
    }


    public function searchCategorie($libelle){
        $lib=CategorieConfection::withTrashed()->where('libelle',$libelle)->first();
        $length=\Illuminate\Support\Str::length($libelle);
        if ($length<3) {
            return response()->json([
                "data"=>[null]
            ]);
        }
        if (!$lib) {
            return response()->json([
                "data"=>[]
            ]);
        }
        return response()->json([
            "data"=>[$lib]
        ]);
    }
}
