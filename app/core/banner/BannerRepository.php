<?php
namespace App\core\banner;

use App\Models\BannerImage;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BannerRepository implements BannerInterface {
    public function getAllBanners($request){
        if(auth()->guard('artists')->check()){
            return BannerImage::where('user_id', auth()->guard('artists')->id())->with('artist')->orderBy('id', 'DESC')->get();
        }
        $searchCustomer = trim($request->search_customer);
        $artistQuery = BannerImage::with('artist')->orderBy('id', 'DESC');
        if (!empty($searchCustomer)) {
            $artistQuery->whereHas('artist', function ($query) use ($searchCustomer) {
                $query->where('username', 'LIKE', "%{$searchCustomer}%")
                      ->orWhere('name', 'LIKE', "%{$searchCustomer}%")
                      ->orWhere('email', 'LIKE', "%{$searchCustomer}%");
            });
        }
        return $artistQuery->get();
        
        // return BannerImage::with('artist')->orderBy('id', 'DESC')->get();
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
    public function getBannerById($id)
{
    $find =  BannerImage::where('id', $id)->first();
    if ($find) {
        return $find;
    } else {
        return 'Not Found';
    }
}
public function updateBannerImage($id, $data)
{
    // Find the existing banner by ID
    $banner = BannerImage::find($id);

    if (!$banner) {
        return false; // Banner not found, return false
    }

    // Handle the new image upload if available
    if (isset($data['banner_image']) && $data['banner_image'] != null) {
        $imageFile = $data['banner_image'];

        if (!empty($imageFile)) {
            $manager = new ImageManager(new Driver());

            // Read and resize the image
            $image = $manager->read($imageFile)->resize(370, 246);

            // Create a unique filename
            $filename = time() . rand(0000, 9999) . "." . $imageFile->getClientOriginalExtension();

            // Save the image to the public directory
            $path = public_path('storage/BannerImage/' . $filename);
            $image->save($path, 60); // Save image with 60% quality

            // Remove old image if it exists
            if ($banner->banner_image && file_exists(public_path('storage/BannerImage/' . $banner->banner_image))) {
                unlink(public_path('storage/BannerImage/' . $banner->banner_image));
            }

            // Update data array with new image filename
            $data['banner_image'] = $filename;
        }
    }

    // Update the banner in the database
    $banner->update($data);

    return true;
}

}

