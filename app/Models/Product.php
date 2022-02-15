<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     description="Product model",
 *     title="Product",
 *     type="object",
 *     schema="Product",
 *     properties={
 *           @OA\Property(type="integer", property="id"),
 *           @OA\Property(type="string", property="name"),
 *           @OA\Property(type="string", property="email"),
 *           @OA\Property(type="string", property="api_token"),
 *           @OA\Property(type="string", property="first_name"),
 *           @OA\Property(type="string", property="last_name"),
 *           @OA\Property(type="integer", property="rate_limit"),
 *     },
 *     required={"id", "name", "email" , "api_token"}
 * )
 */
class Product extends Model
{
    use HasFactory;

    //protected $hidden = ['created_at', 'updated_at']; // Tüm İsteklerde Bu Alanları Gizler

    public function category()
    {
        return $this->hasMany(Category::class, 'id', 'category_id');
    }
}
