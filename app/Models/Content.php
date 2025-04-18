<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    //
    protected $primaryKey = 'content_id';
    protected $table = 'contents';

    protected $fillable = [
        'content_text',
        'url',
        'img_dir',
        'user_id', // optional if you're using this
    ];

    public function Comments(){
        return $this ->hasMany(Comment::class);
    }

    public function likes() {
        return $this->hasMany(Like::class, 'content_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
