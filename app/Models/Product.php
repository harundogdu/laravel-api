<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    //protected $hidden = ['created_at', 'updated_at']; // Tüm İsteklerde Bu Alanları Gizler

    public function category()
    {
        return $this->hasMany(Category::class, 'id', 'category_id');
    }
}
