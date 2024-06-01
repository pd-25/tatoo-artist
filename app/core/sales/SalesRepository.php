<?php

namespace App\core\sales;

use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class SalesRepository implements SalesInterface
{
    public function getAllSales()
    {
        return User::whereNotIn('id', [1])->where('type', 'sales')->orderBy('id', 'DESC')->get();
    }

    public function storeSalesData(array $data)
    {
        if (isset($data['profile_image']) && $data['profile_image'] != null) {
            $content_db = time() . rand(0000, 9999) . "." . $data['profile_image']->getClientOriginalExtension();
            $data['profile_image']->storeAs("public/ProfileImage", $content_db);
            $data['profile_image'] = $content_db;
        }

        $data['password'] = Hash::make($data['password']);
        $data['type'] = "sales";

        //dd($data);

        return User::create($data);
    }

    public function getSingleSales($id)
    {
        $find =  User::with('artworks', 'artworks.views', 'artworks.likes',  'artworks.comments', 'timeData', 'bannerImages')->where('id', $id)->first();
        if ($find) {
            return $find;
        } else {
            return 'Not Found';
        }
    }

    public function updateSales($data, $id)
    {
        //dd($data);
        $find =  User::where('id', $id)->first();
        if ($find) {
                
            if (isset($data['profile_image']) && $data['profile_image'] != null) {
                File::delete(public_path("storage/ProfileImage/" . $find->profile_image));
                $content_db = time() . rand(0000, 9999) . "." . $data['profile_image']->getClientOriginalExtension();
                $data['profile_image']->storeAs("public/ProfileImage", $content_db);
                $data['profile_image'] = $content_db;
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


    public function deleteSales($id){
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
