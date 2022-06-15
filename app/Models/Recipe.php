<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipe',
        'recipe_id',
        'img',
        'recipe_list_id',

    ];


    public function user_lists()
    {
        return $this->belongsTo(Recipelist::class , 'id');
    }
}
