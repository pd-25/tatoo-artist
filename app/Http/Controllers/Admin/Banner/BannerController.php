<?php

namespace App\Http\Controllers\Admin\Banner;

use App\core\artist\ArtistInterface;
use App\core\banner\BannerInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BannerController extends Controller
{

    private $bannerInterface, $artistInterface;
   
    public function __construct(BannerInterface $bannerInterface, ArtistInterface $artistInterface)
    {
        $this->bannerInterface = $bannerInterface;
        $this->artistInterface = $artistInterface;
    }

    public function index() {
        if(Auth::guard('admins')->check()){
            $data['banners'] = $this->bannerInterface->getAllBanners();
        }else{
            $data['banners'] = $this->bannerInterface->getArtistBanners();
        }    
        return view('admin.banner.index', $data);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['artists'] = $this->artistInterface->getAllArtist();
        return view('admin.banner.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       // echo "<pre>"; print_r($_POST); die;
        $request->validate([
            'user_id' => 'required|numeric|exists:users,id',
            'banner_image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'description' => 'nullable',
            'from_date' => 'date',
            'to_date' => 'date'
        ]);
        $data = $request->only('user_id', 'banner_image', 'description', 'from_date', 'to_date');
        $store = $this->bannerInterface->storeBannerImage($data);
        if ($store) {
            return redirect()->route('banners.index')->with('msg', 'New banner image uploded successfully.');
        } else {
            return back()->with('msg', 'Some error occured.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
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
