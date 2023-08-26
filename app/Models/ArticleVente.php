<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleVente extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    public function article_ventes(){
        return $this->belongsToMany(ArticleVente::class,'article_ventes');
    }
}
