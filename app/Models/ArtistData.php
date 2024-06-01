<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtistData extends Model
{
    use HasFactory;
    protected $table = 'artist_data';

    protected $fillable = ["artist_id","hourly_rate","specialty","years_in_trade","walk_in_welcome","certified_professionals","consultation_available",
        "language_spoken","parking","payment_method","air_conditioned","water_available","coffee_available","mask_worn","vaccinated_staff","wheel_chair_accessible","bike_parking",
        "wifi_available","artist_of_the_year","insta_handle","facebook_handle","youtube_handle","twitter_handle","google_map_api","yelp_api",
        "shop_logo","shop_percentage","shop_email","shop_name","shop_address"
    ];
}
