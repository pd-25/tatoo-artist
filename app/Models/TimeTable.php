<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeTable extends Model
{
    use HasFactory;

    protected $fillable = ['sunday_from','sunday_to','monday_from','monday_to','tuesday_from','tuesday_to','wednesday_from','wednesday_to','thrusday_from','thrusday_to','friday_from','friday_to','saterday_from','saterday_to', 'user_id'];
}
