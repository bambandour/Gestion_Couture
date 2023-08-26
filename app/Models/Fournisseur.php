<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    use HasFactory;
    public $guarded=['id'];

    public function articles()
    {
        return $this->hasMany(Article::class,'article_id');
    }
}
