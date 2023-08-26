<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class articleAssociation extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    public function article_association(){
        return $this->hasMany(articleAssociation::class);
    }
}
