<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     description="Category model",
 *     title="Category",
 *     type="object",
 *     schema="Category",
 *     properties={
 *           @OA\Property(type="integer", property="id"),
 *           @OA\Property(type="string", property="name"),
 *           @OA\Property(type="string", property="slug"),
 *           @OA\Property(type="integer", property="product_id"),
 *     },
 * )
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }
}
