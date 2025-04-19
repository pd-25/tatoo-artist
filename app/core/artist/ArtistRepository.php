<?php

namespace App\core\artist;

use Illuminate\Support\Facades\Auth;
use App\Models\TimeTable;
use App\Models\ArtistData;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class ArtistRepository implements ArtistInterface
{
    public function getAllArtist($re = null)
    {
       
        if(Auth::guard('admins')->check()){
            $searchCustomer = trim($re->search_customer);
            $artistQuery =  User::whereNotIn('id', [1])->where('type', 'artist')->orderBy('id', 'DESC');
            if (!empty($searchCustomer)) {
                $artistQuery->where(function ($query) use ($searchCustomer) {
                    $query->where('username', 'LIKE', "%{$searchCustomer}%")
                        ->orWhere('name', 'LIKE', "%{$searchCustomer}%")
                        ->orWhere('email', 'LIKE', "%{$searchCustomer}%");
                });
            }
            return $artistQuery->get();
        }else{
            // return User::whereNotIn('id', [1])->where('type', 'artist')->where('created_by', Auth::guard('sales')->id())->orderBy('id', 'DESC')->get();
            return User::whereNotIn('id', [1])->where('type', 'artist')->orderBy('id', 'DESC')->get();
        }
        
    }
    public function getAllArtistss($re = null)
    {
        if (Auth::guard('admins')->check()) {
            $searchCustomer = $re ? trim($re->search_customer) : '';
            $artistQuery =  User::whereNotIn('id', [1])->where('type', 'artist')->orderBy('id', 'DESC');
            if (!empty($searchCustomer)) {
                $artistQuery->where(function ($query) use ($searchCustomer) {
                    $query->where('username', 'LIKE', "%{$searchCustomer}%")
                        ->orWhere('name', 'LIKE', "%{$searchCustomer}%")
                        ->orWhere('email', 'LIKE', "%{$searchCustomer}%");
                });
            }
            return $artistQuery->get();
        } else {
            return User::whereNotIn('id', [1])
                ->where('type', 'artist')
                ->where('created_by', Auth::guard('sales')->id())
                ->orderBy('id', 'DESC')
                ->get();
        }
    }

    public function storeArtistData(array $data, $timeData,$artistData)
    {
        //dd($artistData);

        if (isset($data['profile_image']) && $data['profile_image'] != null) {
            $content_db = time() . rand(0000, 9999) . "." . $data['profile_image']->getClientOriginalExtension();
            $data['profile_image']->storeAs("public/ProfileImage", $content_db);
            $data['profile_image'] = $content_db;
        }

        if (isset($data['banner_image']) && $data['banner_image'] != null) {
            $content_ban = time() . rand(0000, 9999) . "." . $data['banner_image']->getClientOriginalExtension();
            $data['banner_image']->storeAs("public/BannerImage", $content_ban);
            $data['banner_image'] = $content_ban;
        }
        $data['password'] = Hash::make($data['password']);
        
        if(Auth::guard('admins')->check()){
            $data['created_by'] = 0;
        }else{
            $data['created_by'] = Auth::guard('sales')->id();
        }
        // dd($data);

        $user = User::create($data);

        //Create default timeslots data in time slot table
        $timeData['user_id'] = $user->id;

        $timeData['sunday_from'] = isset($timeData['sunday_from']) ? $timeData['sunday_from'] : "09:00";
        $timeData['sunday_to'] = isset($timeData['sunday_to']) ? $timeData['sunday_to'] : "17:00";

        $timeData['monday_from'] = isset($timeData['monday_from']) ? $timeData['monday_from'] : "09:00";
        $timeData['monday_to'] = isset($timeData['monday_to']) ? $timeData['monday_to'] : "17:00";

        $timeData['tuesday_from'] = isset($timeData['tuesday_from']) ? $timeData['tuesday_from'] : "09:00";
        $timeData['tuesday_to'] = isset($timeData['tuesday_to']) ? $timeData['tuesday_to'] : "17:00";
        
        $timeData['wednesday_from'] = isset($timeData['wednesday_from']) ? $timeData['wednesday_from'] : "09:00";
        $timeData['wednesday_to'] = isset($timeData['wednesday_to']) ? $timeData['wednesday_to'] : "17:00";

        $timeData['thrusday_from'] = isset($timeData['thrusday_from']) ? $timeData['thrusday_from'] : "09:00";
        $timeData['thrusday_to'] = isset($timeData['thrusday_to']) ? $timeData['thrusday_to'] : "17:00";

        $timeData['friday_from'] = isset($timeData['friday_from']) ? $timeData['friday_from'] : "09:00";
        $timeData['friday_to'] = isset($timeData['friday_to']) ? $timeData['friday_to'] : "17:00";

        $timeData['saterday_from'] = isset($timeData['saterday_from']) ? $timeData['saterday_from'] : "09:00";
        $timeData['saterday_to'] = isset($timeData['saterday_to']) ? $timeData['saterday_to'] : "17:00";
        
        //Create artist data record in artist_data table
        if (isset($artistData['shop_logo']) && $artistData['shop_logo'] != null) {
            $content_logo = time() . rand(0000, 9999) . "." . $artistData['shop_logo']->getClientOriginalExtension();
            $artistData['shop_logo']->storeAs("public/ShopImage", $content_logo);
        }else{
            $content_logo = null;
        }

        $artistData = [
            "artist_id" => $user->id,
            "hourly_rate" => $artistData["hourly_rate"],
            "specialty" => $artistData["specialty"],
            "years_in_trade" => $artistData["years_in_trade"],
            "walk_in_welcome" => $artistData["walk_in_welcome"],
            "certified_professionals" => $artistData["certified_professionals"],
            "consultation_available" => $artistData["consultation_available"],
            "language_spoken" => implode(',', $artistData["language_spoken"]),
            "parking" => $artistData["parking"],
            "payment_method" => implode(',', $artistData["payment_method"]),
            "air_conditioned" => $artistData["air_conditioned"],
            "water_available" => $artistData["water_available"],
            "coffee_available" => $artistData["coffee_available"],
            "mask_worn" => $artistData["mask_worn"],
            "vaccinated_staff" => $artistData["vaccinated_staff"],
            "wheel_chair_accessible" => $artistData["wheel_chair_accessible"],
            "bike_parking" => $artistData["bike_parking"],
            "wifi_available" => $artistData["wifi_available"],
            "artist_of_the_year" => $artistData["artist_of_the_year"],
            "insta_handle" => $artistData["insta_handle"],
            "facebook_handle" => $artistData["facebook_handle"],
            "youtube_handle" => $artistData["youtube_handle"],
            "twitter_handle" => $artistData["twitter_handle"],
            "google_map_api" => $artistData["google_map_api"],
            "yelp_api" => $artistData["yelp_api"],
            "shop_percentage" => $artistData["shop_percentage"],
            "shop_email" => $artistData["shop_email"],
            "shop_logo" => $content_logo,
            "shop_name" => $artistData["shop_name"],
            "shop_address" => $artistData["shop_address"],
            "wont_do" => implode(',', $artistData["wont_do"]),
            "unique_offerings" => implode(',', $artistData["unique_offerings"]),
           
        ];

        ArtistData::create($artistData);

        return TimeTable::create($timeData);
    }

    public function getSingleArtist($id)
    {
        $find =  User::with('artworks', 'artworks.views', 'artworks.likes',  'artworks.comments', 'timeData', 'bannerImages')->where('id', $id)->first();
        if ($find) {
            return $find;
        } else {
            return 'Not Found';
        }
    }

    public function updateArtist($data, $id, $timeData, $artistData, $close)
    {
        // dd($data,$artistData);
        $find =  User::where('id', $id)->first();
        if ($find) {
          
                $check_if_time =  TimeTable::where('user_id', $id)->first();
                if($check_if_time) {
                if(isset($close['tuesday_close']) && $close['tuesday_close'] == "on"){
                    $timeData['tuesday_from'] ="00:00";
                    $timeData['tuesday_to'] ="00:00";
                }

                if(isset($close['friday_close']) && $close['friday_close'] == "on"){
                    $timeData['friday_from'] ="00:00";
                    $timeData['friday_to'] ="00:00";
                }
                if(isset($close['saterday_close']) && $close['saterday_close'] == "on"){
                    $timeData['saterday_from'] ="00:00";
                    $timeData['saterday_to'] ="00:00";
                }
                
                if(isset($close['sunday_close']) && $close['sunday_close'] == "on"){
                    $timeData['sunday_from'] ="00:00";
                    $timeData['sunday_to'] ="00:00";
                }

                if(isset($close['monday_close']) && $close['monday_close'] == "on"){
                    $timeData['monday_from'] ="00:00";
                    $timeData['monday_to'] ="00:00";
                }

                if(isset($close['wednesday_close']) && $close['wednesday_close'] == "on"){
                    $timeData['wednesday_from'] ="00:00";
                    $timeData['wednesday_to'] ="00:00";
                }
                
                if(isset($close['thrusday_close']) && $close['thrusday_close'] == "on"){
                    $timeData['thrusday_from'] ="00:00";
                    $timeData['thrusday_to'] ="00:00";
                }

                //dd($timeData);
                
                $check_if_time->update($timeData);
                }else{
                $timeData['user_id']= $id;
                TimeTable::create($timeData);

                }

                $check_if_artist_data =  ArtistData::where('artist_id', $id)->first();
                if($check_if_artist_data) {

                    //Create artist data record in artist_data table
                    if (isset($artistData['shop_logo']) && $artistData['shop_logo'] != null) {
                        File::delete(public_path("storage/ShopImage/" . $find->artistData->shop_logo));
                        $content_logo = time() . rand(0000, 9999) . "." . $artistData['shop_logo']->getClientOriginalExtension();
                        $artistData['shop_logo']->storeAs("public/ShopImage", $content_logo);
                        $artistData['shop_logo'] = $content_logo;
                    }
                     if(isset($artistData["language_spoken"])){
                        $artistData["language_spoken"] = implode(',', $artistData["language_spoken"]);
                     }

                     if(isset($artistData["payment_method"])){
                        $artistData["payment_method"] = implode(',', $artistData["payment_method"]);
                     }
                     if(isset($artistData["wont_do"])){
                        $artistData["wont_do"] = implode(',', $artistData["wont_do"]);
                     }
                     if(isset($artistData["unique_offerings"])){
                        $artistData["unique_offerings"] = implode(',', $artistData["unique_offerings"]);
                     }
                    
                    
                    $check_if_artist_data->update($artistData);
                }

            if (isset($data['profile_image']) && $data['profile_image'] != null) {
                File::delete(public_path("storage/ProfileImage/" . $find->profile_image));
                $content_db = time() . rand(0000, 9999) . "." . $data['profile_image']->getClientOriginalExtension();
                $data['profile_image']->storeAs("public/ProfileImage", $content_db);
                $data['profile_image'] = $content_db;
            }

            if (isset($data['banner_image']) && $data['banner_image'] != null) {
                File::delete(public_path("storage/ProfileImage/" . $find->banner_image));
                $content_ban = time() . rand(0000, 9999) . "." . $data['banner_image']->getClientOriginalExtension();
                $data['banner_image']->storeAs("public/BannerImage", $content_ban);
                $data['banner_image'] = $content_ban;
            }
            if (isset($data['password']) && $data['password'] != null) {
                $data['password'] = Hash::make($data['password']);
            }else{
                $data['password'] = $find->password;
            }
            return $find->update($data);
        }else{
            return 'No data';
        }
    }


    public function deleteArtist($id){
        $find =  User::where('id', $id)->first();
        if($find) {
            foreach($find->artworks as $art){
                $art->delete();
            }

            foreach($find->bannerImages as $bannerImage){
                $bannerImage->delete();
            }
            
            return $find->delete();
        }
        return 'not found';
    }
}
