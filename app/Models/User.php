<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
/**
 * @OA\Schema(
 *     description="User model",
 *     title="User",
 *     type="object",
 *     schema="User",
 *     properties={
 *           @OA\Property(type="integer", property="id"),
 *           @OA\Property(type="string", property="name"),
 *           @OA\Property(type="string", property="email"),
 *           @OA\Property(type="datetime", property="email_verified_at"),
 *           @OA\Property(type="string", property="api_token"),
 *           @OA\Property(type="string", property="first_name"),
 *           @OA\Property(type="string", property="last_name"),
 *           @OA\Property(type="integer", property="rate_limit"),
 *           @OA\Property(type="datetime", property="created_at"),
 *           @OA\Property(type="datetime", property="updated_at"),
 *           @OA\Property(type="string", property="full_name"),
 *     },
 * )
 */


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'date:Y-m-d H:i:s',
        'updated_at' => 'date:Y-m-d H:i:s'
    ];

    //protected $appends = ['full_name'];

    public function getFullNameAttribute()
    {
        if ($this->name !== null && $this->last_name !== null) {
            return $this->name . ' ' . $this->last_name;
        } else {
            return null;
        }
    }
}
