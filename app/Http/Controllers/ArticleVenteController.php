<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleVenteCollection;
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
        return new ArticleVenteCollection($article,'Liste des articles de ventes et la pagination');
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
        $tabId=$request->article;
        // $quantites = $request->quantite;
        $article->article_ventes()->attach($tabId);
        foreach ($tabId as $key=>$id) {
            $quantite=$request->quantite[$key];
            $article->article_ventes()->updateExistingPivot($id, ['quantite' => $quantite]);
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

            dd($id);
            // $article->prix_vente=28000;
            // $article->cout_fabrication=23000;
            // $article->marge=5000;
            // $article->promo=false;
            $article->libelle = $request->libelle;
            $article->stock = $request->stock;
            $article->categorie_id = $request->catego->id;
            $article->photo = $request->photo;
            $article->reference = $reference;            
            $article->save();
            dd($article);

            

            $tabId = $request->input('article');
            foreach ($tabId as $key => $articleId) {
                $quantite = $request->input('quantite.' . $key); 
                $article->article_ventes()->updateExistingPivot($articleId, ['quantite' => $quantite]);
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
