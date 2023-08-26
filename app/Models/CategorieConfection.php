<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategorieConfection extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $guarded=['id'];
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
