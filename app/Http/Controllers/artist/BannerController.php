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
    public function getArtistWiseBanner()
    {
        $data['banners'] = $this->bannerInterface->getAllBanners();
        return view('admin.banner.index', $data);
    }

    public function getForm(){
        return view('admin.banner.create');
    }

    public function uploadArtistWiseBanner(Request $request){
        $request->validate([
            'user_id' => 'required|numeric|exists:users,id',
            'banner_image' => 'required|image|mimes:jpeg,png,jpg,gif'
        ]);
        $data = $request->only('user_id', 'banner_image');
        $store = $this->bannerInterface->storeBannerImage($data);
        if ($store) {
            return redirect()->route('artists.getArtistWiseBanner')->with('msg', 'New banner image uploded successfully.');
        } else {
            return back()->with('msg', 'Some error occured.');
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
