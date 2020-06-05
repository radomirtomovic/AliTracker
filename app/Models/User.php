<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'email_verified_at',
    ];
    protected $hidden = [
        'password',
        'email_verified_at',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}