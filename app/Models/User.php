<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username','phone','address', 'address2', 'country','state','city','zipcode','latitude','longitude','profile_image','banner_image', 'type', 'created_by'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function artworks() {
        return  $this->hasMany(Artwork::class, 'user_id', 'id'); 
    }

    public function timeData() {
        return  $this->hasOne(TimeTable::class, 'user_id', 'id'); 
    }

    public function artistData() {
        return  $this->hasOne(ArtistData::class, 'artist_id', 'id'); 
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function bannerImages() {
        return  $this->hasMany(BannerImage::class, 'user_id', 'id'); 
    }

    public function quotesMade()
    {
        return $this->hasMany(Quote::class, 'user_id');
    }
    
    public function quotesReceived()
    {
        return $this->hasMany(Quote::class, 'artist_id');
    }

    public function payments()
    {
        return $this->hasMany(PaymentModel::class, 'user_id');
    }

    public function expenses()
    {
        return $this->hasMany(ExpenseModel::class, 'user_id');
    }
}
