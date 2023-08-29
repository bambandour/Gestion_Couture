<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\ArticleFournisseur;
use App\Models\CategorieConfection;
use App\Models\Fournisseur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Array_;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
    public function index(){
        $article = Article::paginate(3);
        return  new ArticleCollection($article,'Liste des articles');
    }


    public function all(){
        $four=Fournisseur::all();
        $categorie=CategorieConfection::all();
        $article=Article::paginate(3);
        return [
            "message"=>'',
            "data"=>[
                "categories"=>$categorie,
                "fournisseurs"=>$four,
                "articles"=>new ArticleResource($article)],
            "success"=>Response::HTTP_OK
        ];
    }

    public function listerArticles($page=null) {
        if (!empty($page)) {
            $categories=Article::orderBy('id','desc')->paginate($page);
            return ArticleResource::collection($categories);
        }
        $categories=CategorieConfection::orderBy('id','desc')->paginate(3);
        return new ArticleCollection($categories,'');
    }
    public function store(Request $request){    
        DB::beginTransaction();
        try{
        $catego=CategorieConfection::where('libelle',$request->categorie)->first();
        $numero=CategorieConfection::where('libelle',$request->categorie)->count()+1;
        $reference='REF-'.strtoupper(substr($request->libelle,0,3)).'-'.strtoupper($catego->libelle).'-'.$numero;
        $article=Article::create([
            "libelle"=>$request->libelle,
            "prix"=>$request->prix,
            "stock"=>$request->stock,
            "categorie_id"=>$catego->id,
            "photo"=>$request->photo,
            "reference"=>$reference
        ]);
        // dd($article);
        $fournisseurs=[$request->fournisseurs];
        foreach ($fournisseurs as $fournisseurName) {
            $fournisseur = Fournisseur::where('libelle', $fournisseurName)->first();
            if ($fournisseur) {
                $articleFournisseur = new ArticleFournisseur();
                $articleFournisseur->article_id = $article->id;
                $articleFournisseur->fournisseur_id = $fournisseur->id;
                $articleFournisseur->save();
            } else {
                return response()->json(['message' => 'Fournisseur non existant'], 400);
            }
        }
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

    public function update(Request $request, Article $id){

        if (empty($id)) {
            return response()->json(['message' => 'Catégorie introuvable.'], 404);
        }

        $catego=CategorieConfection::where('libelle',$request->categorie)->first();

        $numero=CategorieConfection::where('libelle',$request->categorie)
                                        ->where('type','article_confections')
                                        ->count()+1;

        $reference='REF-'.strtoupper(substr($request->libelle,0,3)).'-'.strtoupper($catego->libelle).'-'.$numero;

        $id->update(
            // $request->only('libelle','prix','stock','categorie_id','photo','reference')
            [
                "libelle"=>$request->libelle,
                "prix"=>$request->prix,
                "stock"=>$request->stock,
                "categorie_id"=>$catego->id,
                "photo"=>$request->photo,
                "reference"=>$reference
            ]
        );
        
        return new ArticleCollection($id,"Mise à jour reussi");
    }

    public function destroy(Request $request,Article $id){
        $id->delete();
        return response([
            "message"=>'suppression effectué avec succes',
            "data"=>"",
            'succes'=> Response::HTTP_NO_CONTENT]);
    }
}
