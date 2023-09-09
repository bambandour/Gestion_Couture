<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleVenteCollection;
use App\Http\Resources\ArtVenteResource;
use App\Models\Article;
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
        $categorie=CategorieConfection::where('type','categorie_vente')->get();
        $articleConfection=Article::all();
        return [
                // "articleVente"=> new ArticleVenteCollection($article,'Articles de ventes && pagination'),
                "article_vente"=>ArtVenteResource::collection($article),
                "categories"=>$categorie,
                "articleConfection"=>$articleConfection,
        ];
    }

    public function store(Request $request){
        DB::beginTransaction();
        try{
        $catego=CategorieConfection::where('libelle',$request->categorie)->first();
        $numero=CategorieConfection::where('libelle',$request->categorie)
                                        ->where('type','categorie_confection')
                                        ->count()+1;
        $reference='REF-'.strtoupper(substr($request->libelle,0,3)).'-'.strtoupper($catego->libelle).'-'.$numero;

        // $cout=explode('',$request->confections);
        // dd($cout);
        $article=ArticleVente::create([
            "libelle"=>$request->libelle,
            "prix_vente"=>$request->marge+15000,
            "cout_fabrication"=>15000,
            "marge"=>$request->marge,
            "promo"=>false,
            "stock"=>2,
            "categorie_id"=>$catego->id,
            "photo"=>$request->photo,
            "reference"=>$reference
        ]);
        
        $confections=$request->confections;
        foreach ($confections as $key=>$value) {
            $article->article_ventes()->attach([$value['id']=>['quantite' => $value["quantite"]]]);
        }
        
        DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            return [

                "message" => 'Une erreur est survenue lors de l\'ajout de l\'article.',
                "error" => $e->getMessage(),
                "success" => false
            ];
        }
        
        return [
            "message"=>'l\'article a été ajouté avec success',
            "data"=>[$article],
            "success"=>Response::HTTP_OK
        ];
    }

    public function update(Request $request,$id){
        DB::beginTransaction();
        try {
            $catego=CategorieConfection::where('libelle',$request->categorie)->first();
            $numero=CategorieConfection::where('libelle',$request->categorie)
                                        ->where('type','categorie_confection')
                                        ->count()+1;
            $reference='REF-'.strtoupper(substr($request->libelle,0,3)).'-'.strtoupper($catego->libelle).'-'.$numero;
            $article = ArticleVente::findOrFail($id);
            $article->prix_vente=$request->marge+5000;
            $article->cout_fabrication=25000;
            $article->marge=$request->marge;
            $article->promo=false;
            $article->libelle = $request->libelle;
            $article->stock = $request->stock;
            $article->categorie_id = $request->catego->id;
            $article->photo = $request->photo;
            $article->reference = $reference;            
            dd($article);
            // $article->update();
           
                        
            $confections=$request->confections;
            foreach ($confections as $key=>$value) {
                $article->article_ventes()->sync([$value['id']=>['quantite' => $value["quantite"]]]);
            }
            

        DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return [
                "message" => 'Une erreur est survenue lors de la mise à jour de l\'article.',
                "error" => $e->getMessage(),
                "success" => false
            ];
        }

        return [
            "message" => 'L\'article a été mis à jour avec succès.',
            "data" => [$article],
            "success" => true
        ];
    }

    public function destroy(Request $request, $id){
        $article = ArticleVente::findOrFail($id);
        $article->article_ventes()->detach();
        $article->delete();
        return [
            "message" => 'L\'article a été supprimé avec succès.',
            "success" => true
        ];
    }
}
