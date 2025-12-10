<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtistData extends Model
{
    use HasFactory;
    protected $table = 'artist_data';

    protected $fillable = [
        "artist_id",
        "hourly_rate",
        'deposit_amount',
        "specialty",
        "specialty2",
        "specialty3",
        "specialty4",
        "specialty5",
        "years_in_trade",
        "walk_in_welcome",
        "certified_professionals",
        "consultation_available",
        "language_spoken",
        "parking",
        "payment_method",
        "air_conditioned",
        "water_available",
        "coffee_available",
        "mask_worn",
        "vaccinated_staff",
        "wheel_chair_accessible",
        "bike_parking",
        "wifi_available",
        "artist_of_the_year",
        "insta_handle",
        "facebook_handle",
        "youtube_handle",
        "twitter_handle",
        "google_map_api",
        "yelp_api",
        "shop_logo",
        "shop_percentage",
        "blood_borne",
        "shop_email",
        "shop_name",
        "shop_address",
        "wont_do",
        "unique_offerings",
        "cc_fees",
        "cc_fees_percentage",
        "gmail",
        "gmail_api_password",
        "zelle_email",
        "zelle_phone",
        "zelle_qr_code",
        "referred_by_email",
    ];
}
