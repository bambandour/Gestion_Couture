<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Article extends Model
{
    use HasFactory;
    public $guarded=['id'];
    // public $fillable=[
    //     'id',
    //     'libelle',
    //     'prix',
    //     'stock',
    //     'catégorie_id',
    //     'photo',
    //     'reference',
    // ];
    public function fournisseurs()
    {
        return $this->hasMany(Fournisseur::class);
    }
    public function categorie()
    {
        return $this->belongsTo(CategorieConfection::class, 'categorie_id');
    }

    public function articleFournisseur() :HasMany
    {
        return $this->hasMany(ArticleFournisseur::class);
    }
    public function imageUrl():string
    {
        return Storage::url($this->photo);
    }

    public function articles(){
        return $this->belongsToMany(Article::class,'articles');
    }
    
}
