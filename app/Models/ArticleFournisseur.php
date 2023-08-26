<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleFournisseur extends Model
{
    use HasFactory;
    public $guarded=['id'];

    // public static function boot(){
    //     parent::boot();

    //     static::created(function ($article) {
    //         $fournisseur_id = 1; 
    //         $article->fournisseurs()->attach($fournisseur_id);
    //     });
    // }     
    public function fournisseurs()
    {
        return $this->belongsTo(Fournisseur::class,'fournisseur_id');
    }

    public function articles()
    {
        return $this->belongsTo(Article::class,'article_id');
    }
}
