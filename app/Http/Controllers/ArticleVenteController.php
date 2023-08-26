<?php

namespace App\Http\Controllers;

use App\Models\articleAssociation;
use App\Models\ArticleVente;
use App\Models\CategorieConfection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ArticleVenteController extends Controller
{
    public function index(){
        $article=ArticleVente::paginate(5);
        return $article;
    }

    public function store(Request $request){
        DB::beginTransaction();
        try{
        $catego=CategorieConfection::where('libelle',$request->categorie)->first();
        $numero=CategorieConfection::where('libelle',$request->categorie)
        ->where('type','categorie_confection')
        ->count()+1;
        $reference='REF-'.strtoupper(substr($request->libelle,0,3)).'-'.strtoupper($catego->libelle).'-'.$numero;
        
        $article=ArticleVente::create([
            "libelle"=>$request->libelle,
            "prix_vente"=>28000,
            "cout_fabrication"=>23000,
            "marge"=>5000,
            "promo"=>false,
            "stock"=>$request->stock,
            "categorie_id"=>$catego->id,
            "photo"=>$request->photo,
            "reference"=>$reference
        ]);
        $article->article_ventes()->attach($request->article->id);
        // $artConf=articles()->patch($request->articles->id);
        
        // $assos=new articleAssociation;
        // $tabId=$request->article;
        // $quantites=$request->quantite;
        // foreach ($tabId as  $artId) {
        //     $assos->article_vente_id = $article->id;
        //     $assos->article_id =$artId;
        //     $assos->quantite=$request->
        //     $assos->save();
        // }
        DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        
        return [
            "message"=>'l\'article a été ajouté avec success',
            "data"=>[$article],
            "success"=>Response::HTTP_OK
        ];
    }
}
