<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @mixin IdeHelperCustomer
 */
class Customer extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $fillable = ['id', 'email', 'email_verified_at', 'name', 'password', 'created_at', 'updated_at'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime'];
}
