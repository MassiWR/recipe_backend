<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $table = 'recipe';
    protected $fillable = ['recipe_id', 'title', 'photo', 'user_list_id'];

    public function user_list()
    {
        return $this->belongsToMany(User_list::class);
    }
}
