<?php

namespace App\Http\Controllers\artist;

use App\core\artist\ArtistInterface;
use App\core\banner\BannerInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    private $bannerInterface, $artistInterface;

    public function __construct(BannerInterface $bannerInterface, ArtistInterface $artistInterface)
    {
        $this->bannerInterface = $bannerInterface;
        $this->artistInterface = $artistInterface;
    }
    public function getArtistWiseBanner(Request $request)
    {
        $data['banners'] = $this->bannerInterface->getAllBanners($request);
        return view('admin.banner.index', $data);
    }

    public function getForm(){
        return view('admin.banner.create');
    }

    public function uploadArtistWiseBanner(Request $request){
        $request->validate([
            'user_id' => 'required|numeric|exists:users,id',
            'banner_image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'description' => 'nullable',
            'from_date' => 'date',
            'to_date' => 'date'
        ]);
        $data = $request->only('user_id', 'banner_image' ,'description', 'from_date', 'to_date');
        $store = $this->bannerInterface->storeBannerImage($data);
        if ($store) {
            return redirect()->route('artists.getArtistWiseBanner')->with('msg', 'New banner image uploded successfully.');
        } else {
            return back()->with('msg', 'Some error occured.');
        }
    }
    public function editArtistWiseBanner($id)
    {
        // Fetch the banner data by ID
        $data['banner'] = $this->bannerInterface->getBannerById(decrypt($id));;
        $data['artists'] = $this->artistInterface->getAllArtistss();
        if (!$data['banner']) {
            return redirect()->route('artists.getArtistWiseBanner')->with('msg', 'Banner not found.');
        }
     
        // Return the view with the banner data
        return view('admin.banner.edit', $data);
    }
    
    public function updateArtistWiseBanner(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|numeric|exists:users,id',
            'banner_image' => 'image|mimes:jpeg,png,jpg,gif',
            'description' => 'nullable',
            'from_date' => 'date',
            'to_date' => 'date'
        ]);
    
        $id = $id; // Decrypt ID if needed
        $data = $request->only('user_id','description', 'from_date', 'to_date');
    
        // Check if a new image is uploaded
        if ($request->hasFile('banner_image')) {
            $data['banner_image'] = $request->file('banner_image');
        }
    
        // Debugging: check what is being passed to the update function
       
    
        $update = $this->bannerInterface->updateBannerImage($id, $data);
    
        if ($update) {
            return redirect()->route('artists.getArtistWiseBanner')->with('msg', 'Banner image updated successfully.');
        } else {
            return back()->with('msg', 'Some error occurred while updating.');
        }
    }
    
    
    public function destroyBanner(string $id)
    {
        try {
            $delete = $this->bannerInterface->deleteBannerImage(decrypt($id));
            if ($delete) {
                return back()->with('msg', 'Banner Image has been deleted successfully.');
            } elseif ($delete == 'No data') {
                return back()->with('msg', 'No Banner found.');
            }
        } catch (\Throwable $th) {
            return back()->with('msg', $th->getMessage());
        }
    }
}
