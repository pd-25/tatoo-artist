<?php
namespace App\core\banner;

use App\Models\BannerImage;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BannerRepository implements BannerInterface {
    public function getAllBanners(){
        if(auth()->guard('artists')->check()){
            return BannerImage::where('user_id', auth()->guard('artists')->id())->with('artist')->orderBy('id', 'DESC')->get();
        }
        return BannerImage::with('artist')->orderBy('id', 'DESC')->get();
    }

    public function getArtistBanners(){
        $salespersonId = Auth::guard('sales')->id(); // Get the logged-in salesperson's ID

        $artists = User::where('created_by', $salespersonId)->get(); // Get all artists created by this salesperson

        $artworks = BannerImage::whereIn('user_id', $artists->pluck('id'))->paginate(5); 

        return $artworks;
    }

    public function storeBannerImage($data) {
      //  echo "<pre>"; print_r($data); die;
        if (isset($data['banner_image']) && $data['banner_image'] != null) {
            //dd($data);
            // Retrieve the image from request
            $imageFile = $data['banner_image'];
            
            if(!empty($imageFile)){
                // create image manager with desired driver
                $manager = new ImageManager(new Driver()); 

                // read image from file system
                $image = $manager->read($imageFile); 

                // Create a unique filename
                $filename = time().rand(0000, 9999) . "." . $imageFile->getClientOriginalExtension();

                //Resize the image before save
                $image  = $image->resize(370, 246);

                //dd(public_path());

                // Compress and save the image in public directory
                $path = public_path('storage/BannerImage/' . $filename);
                $image->save($path, 60); // 60 is the quality
            }

            $data['banner_image'] = $filename;
        }
        return BannerImage::create($data);
    }

    public function deleteBannerImage($id) {
        $find =  BannerImage::where('id', $id)->first();
        if($find) {
            return $find->delete();
        }
        return 'not found';
    }
}