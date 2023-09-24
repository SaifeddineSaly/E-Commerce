<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = ['ref_session', 'date_panier', 'id_article', 'quantite'];
    //public $table = "carts";
}
