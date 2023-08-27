<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticleVenteController;
use App\Http\Controllers\CategorieConfectionController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\ImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::put('/categorie/{id}',[CategorieConfectionController::class,'update'])->name('updateCategorie');

Route::post('/categorie',[CategorieConfectionController::class,'store'])->name('addCategorie');

Route::get('/all',[CategorieConfectionController::class,'index'])->name('ListCategorie');

Route::get('/categories/{page?}',[CategorieConfectionController::class,'listerCategories'])->name('ListCategorie');


Route::delete('/categories/{id?}',[CategorieConfectionController::class,'delete'])->name('deleteCategorie');

Route::get('/search/{libelle}',[CategorieConfectionController::class,'searchCategorie'])->name('searchCategorie');


Route::post('/articles',[ArticleController::class,'store'])->name('ajouter.Article');

Route::get('/articles',[ArticleController::class,'index'])->name('Lister.Article');

Route::put('/articles/{id}',[ArticleController::class,'update'])->name('update.Article');

Route::delete('/articles/{id}',[ArticleController::class,'destroy'])->name('delete.Article');

Route::get('/allArticle',[ArticleController::class,'all'])->name('ListerArticle');


Route::post('/fournisseur',[FournisseurController::class,'store'])->name('ajouterFournisseur');

Route::post('/images',[ImageController::class,'uploadImage'])->name('insererImage');


// Route::get('/article-vente',[ArticleVenteController::class,'index'])->name('All.articleVente');

// Route::post('/article-vente',[ArticleVenteController::class,'store'])->name('add.articleVente');

Route::group(['prefix' => 'article-vente'], function () {
    Route::get('/', [ArticleVenteController::class, 'index'])->name('articles-vente.index');

    Route::post('/', [ArticleVenteController::class, 'store'])->name('articles-vente.store');
    
    Route::put('/{article_vente}', [ArticleVenteController::class, 'update'])->name('articles-vente.update');

    Route::delete('/{article_vente}', [ArticleVenteController::class, 'destroy'])->name('articles-vente.destroy');
});
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
