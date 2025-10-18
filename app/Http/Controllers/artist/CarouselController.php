<?php

namespace App\Http\Controllers\artist;

use App\core\artist\ArtistInterface;
use App\core\carousel\CarouselInterface as BannerInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CarouselController extends Controller
{
    private $bannerInterface, $artistInterface;

    public function __construct(BannerInterface $bannerInterface, ArtistInterface $artistInterface)
    {
        $this->bannerInterface = $bannerInterface;
        $this->artistInterface = $artistInterface;
    }

    public function index(Request $request)
    {
        return $this->getArtistWiseBanner($request);
    }

    public function create()
    {
        return $this->getForm();
    }

    public function store(Request $request)
    {
        return $this->uploadArtistWiseBanner($request);
    }
    

    // public function edit($id)
    // {
    //     return $this->editArtistWiseBanner($id);
    // }

    // public function update(Request $request, $id)
    // {
    //     return $this->updateArtistWiseBanner($request, $id);
    // }

    public function destroy($id)
    {
        return $this->deleteArtistWiseBanner($id);
    }

    public function getArtistWiseBanner(Request $request)
    {
        $data['banners'] = $this->bannerInterface->getAllBanners($request);
        return view('admin.carousel.index', $data);
    }

    public function getForm()
    {
        $data = [];
        if (!auth()->guard('artists')->check()) {
            $data['artists'] = $this->artistInterface->getAllArtistss(); // fetch all artists
        }

        return view('admin.carousel.create', $data);
    }


    public function uploadArtistWiseBanner(Request $request)
    {
        $request->validate([
            'user_id' => 'required|numeric|exists:users,id',
            'carousel' => 'required|image|mimes:jpeg,png,jpg,gif',
            'description' => 'nullable',
            'from_date' => 'date',
            'to_date' => 'date'
        ]);
        $data = $request->only('user_id', 'carousel', 'description', 'from_date', 'to_date');
        $store = $this->bannerInterface->storeBannerImage($data);
        if ($store) {
            return redirect()->route('artists.getArtistWiseCarousel')->with('msg', 'New carousel image uploded successfully.');
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
            return redirect()->route('artists.getArtistWiseCarousel')->with('msg', 'Carousel not found.');
        }

        // Return the view with the banner data
        return view('admin.carousel.edit', $data);
    }

    public function updateArtistWiseBanner(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|numeric|exists:users,id',
            'carousel' => 'image|mimes:jpeg,png,jpg,gif',
            'description' => 'nullable',
            'from_date' => 'date',
            'to_date' => 'date'
        ]);

        $id = $id; // Decrypt ID if needed
        $data = $request->only('user_id', 'description', 'from_date', 'to_date');

        // Check if a new image is uploaded
        if ($request->hasFile('carousel')) {
            $data['carousel'] = $request->file('carousel');
        }

        // Debugging: check what is being passed to the update function


        $update = $this->bannerInterface->updateBannerImage($id, $data);

        if ($update) {
            return redirect()->route('artists.getArtistWiseCarousel')->with('msg', 'Carousel image updated successfully.');
        } else {
            return back()->with('msg', 'Some error occurred while updating.');
        }
    }


    public function destroyBanner(string $id)
    {
        try {
            $delete = $this->bannerInterface->deleteBannerImage(decrypt($id));
            if ($delete) {
                return back()->with('msg', 'Carousel Image has been deleted successfully.');
            } elseif ($delete == 'No data') {
                return back()->with('msg', 'No Carousel found.');
            }
        } catch (\Throwable $th) {
            return back()->with('msg', $th->getMessage());
        }
    }
}
