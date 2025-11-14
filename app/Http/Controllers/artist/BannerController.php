<?php

namespace App\Http\Controllers\artist;

use App\core\artist\ArtistInterface;
use App\core\banner\BannerInterface;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
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

    public function getForm()
    {
        return view('admin.banner.create');
    }

    public function uploadArtistWiseBanner(Request $request)
    {
        $request->validate([
            'user_id' => 'required|numeric|exists:users,id',
            'banner_image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'description' => 'nullable',
            'from_date' => 'required|date_format:m-d-Y',
            'to_date' => 'required|date_format:m-d-Y|after_or_equal:from_date',
        ], [
            'to_date.after_or_equal' => 'The end date must be the same or later than the start date.',
        ]);

        $from_date = Carbon::createFromFormat('m-d-Y', $request->from_date)->format('Y-m-d');
        $to_date   = Carbon::createFromFormat('m-d-Y', $request->to_date)->format('Y-m-d');

         // Build data
        $data = [
            'user_id'     => $request->user_id,
            'description' => $request->description,
            'from_date'   => $from_date,
            'to_date'     => $to_date,
            'banner_image'    => $request->file('banner_image'), // attach file object
        ];

        $store = $this->bannerInterface->storeBannerImage($data);

        if ($store) {
            return redirect()->route('artists.getArtistWiseBanner')->with('msg', 'New banner image uploaded successfully.');
        } else {
            return back()->with('msg', 'Some error occurred.');
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

        // Convert mm-dd-yyyy → yyyy-mm-dd
        if ($request->from_date) {
            $request->merge([
                'from_date' => \Carbon\Carbon::createFromFormat('m-d-Y', $request->from_date)->format('Y-m-d')
            ]);
        }

        if ($request->to_date) {
            $request->merge([
                'to_date' => \Carbon\Carbon::createFromFormat('m-d-Y', $request->to_date)->format('Y-m-d')
            ]);
        }

        $data = $request->only('user_id', 'description', 'from_date', 'to_date');

        if ($request->hasFile('banner_image')) {
            $data['banner_image'] = $request->file('banner_image');
        }

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
