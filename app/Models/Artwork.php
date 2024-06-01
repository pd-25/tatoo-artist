<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artwork extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','style_id','placement_id','subject_id','image','title', 'zipcode', 'country'];

    public function user () {
        return  $this->belongsTo(User::class, 'user_id', 'id'); 
    }

    public function views () {
        return  $this->hasMany(TotalView::class, 'artwork_id', 'id'); 
    }

    public function likes () {
        return  $this->hasMany(Like::class, 'artwork_id', 'id'); 
    }

    public function comments () {
        return  $this->hasMany(Comment::class, 'artwork_id', 'id'); 
    }
}
