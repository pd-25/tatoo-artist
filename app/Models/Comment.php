<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'artwork_id', 'comment'];
    
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function artwork() {
        return $this->belongsTo(Artwork::class, 'artwork_id', 'id');
    }

}
