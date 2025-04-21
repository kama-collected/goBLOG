<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable  
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin' 
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }
    public function contents()
    {
        return $this->hasMany(\App\Models\Content::class, 'user_id', 'user_id');
    }
    // Check if the user is an admin
    public function isAdmin()
    {
        return $this->is_admin == 1;
    }
   
    public function comments(){
        return $this ->hasMany('App\Models\comments');
    }
    public function like(){
        return $this ->hasMany('App\Models\like');
    }
}
