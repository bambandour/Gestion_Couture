<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleVente extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    public function article_ventes(){
        return $this->belongsToMany(Article::class,'article_associations','article_vente_id','article_id')
                        ->withPivot('quantite');
                        // ->withTimestamps();
    }
    public function categorie()
    {
        return $this->belongsTo(CategorieConfection::class, 'categorie_id');
    }
}
