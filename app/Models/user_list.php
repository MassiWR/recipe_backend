<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_list extends Model
{
    use HasFactory;

    protected $table = 'user_list';
    protected $fillable = ['user_id', 'title'];

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }
}
