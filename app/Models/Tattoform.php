<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tattoform extends Model
{

    protected $table = 'tatto_form';

    // protected $primaryKey = 'id';

    // protected $fillable = [
    //     'COMMENT', 'ROLE_ID', 'GROUP_ID'
    // ];

    public $timestamps = false;

    use HasFactory;
}
