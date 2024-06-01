<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerImage extends Model
{
    use HasFactory;
    protected $fillable = ['banner_image', 'user_id', 'description', 'from_date','to_date'];

    public function artist()
    {
        return  $this->belongsTo(User::class, 'user_id', 'id');
    }
}
