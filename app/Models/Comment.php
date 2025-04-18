<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable =[
        'comment_text',
        'user_id',
        'content_id'
    ];

    protected $primaryKey = 'comment_id';

    public function content() {
        return $this->belongsTo(Content::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    
}
