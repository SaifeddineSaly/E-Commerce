<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $fillable=['nom_article', 'description', 'prix_unitaire', 'stock', 'photo', 'id_cat'];
}
