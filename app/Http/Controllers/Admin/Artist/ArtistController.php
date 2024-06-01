<?php

namespace App\Http\Controllers\Admin\Artist;

use App\core\artist\ArtistInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Style;

class ArtistController extends Controller
{
    private $artistInterface;

    public function __construct(ArtistInterface $artistInterface)
    {
        $this->artistInterface = $artistInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['artists'] = $this->artistInterface->getAllArtist();
        return view('admin.artist.index', $data);
    }

     /**
     * Display a listing of the customers.
     */
    public function customers()
    {
        $data['customers'] = User::where('type','=','Customer')->where('status',1)->get();
        return view('admin.customers.index', $data);
    }

    public function editCustomer($id)
    {
        $data['customer'] = User::where('id', $id)->first();
        return view('admin.customers.edit', $data);
    }

    public function updateCustomer(Request $request, $id) {
        $request->validate([
            'name' => 'required',
            // 'username' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'address' => 'required'
        ]);
        $data = $request->only('name', 'username','phone','email','address');
        User::where('id', $id)->update($data);
        return redirect()->route('admin.customers')->with('msg','Data updated successfully');

    }

    public function destroyCustomer($id) {
        User::where('id', $id)->update(['status'=> 0]);
        return redirect()->route('admin.customers')->with('msg','Data blocked successfully');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['styles'] = Style::orderBy('id', 'asc')->get();
        return view('admin.artist.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'zipcode' => 'required|numeric|min:6',
            'phone' => 'numeric',
            'address' => 'nullable|string',
        ]);
        $data = $request->only('name', 'username', 'email', 'phone', 'address', 'password', 'zipcode', 'profile_image', 'banner_image');
        $timeData = $request->only('sunday_from','sunday_to','monday_from','monday_to','tuesday_from','tuesday_to','wednesday_from','wednesday_to','thrusday_from','thrusday_to','friday_from','friday_to','saterday_from','saterday_to');
        
        $artistData = $request->only('hourly_rate','specialty',"years_in_trade","walk_in_welcome","certified_professionals","consultation_available",
            "language_spoken","parking","payment_method","air_conditioned","water_available","coffee_available","mask_worn","vaccinated_staff","wheel_chair_accessible","bike_parking",
            "wifi_available","artist_of_the_year","insta_handle","facebook_handle","youtube_handle","twitter_handle","google_map_api","yelp_api",
            "shop_logo","shop_percentage","shop_email","shop_name","shop_address"
        );
       
        $store = $this->artistInterface->storeArtistData($data, $timeData,$artistData);
        if ($store) {
            return redirect()->route('artists.index')->with('msg', 'New artist added successfully.');
        } else {
            return back()->with('msg', 'Some error occur.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['artist'] = $this->artistInterface->getSingleArtist(decrypt($id));
        if ($data['artist'] == 'Not Found') {
            return back()->with('msg', 'No artist found!');
        }
        return view('admin.artist.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['artist'] = $this->artistInterface->getSingleArtist(decrypt($id));
        $data['artistData'] = @$data['artist']->artistData;
        $data['languageSpoken'] = explode(',', @$data['artistData']->language_spoken);
        $data['PaymentMethod'] = explode(',', @$data['artistData']->payment_method);
        $data['styles'] = Style::orderBy('id', 'asc')->get();
        // dd($data);
        if ($data['artist'] == 'Not Found') {
            return back()->with('msg', 'No artist found!');
        }
        return view('admin.artist.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string',
            'zipcode' => 'required|numeric|min:6',
            'phone' => 'numeric',
            'address' => 'nullable|string',
        ]);

        $data = $request->only('name', 'username', 'email', 'phone', 'address', 'address2', 'country', 'state', 'city', 'password', 'zipcode', 'latitude','longitude', 'profile_image', 'banner_image');
        $timeData = $request->only('sunday_from','sunday_to','monday_from','monday_to','tuesday_from','tuesday_to','wednesday_from','wednesday_to','thrusday_from','thrusday_to','friday_from','friday_to','saterday_from','saterday_to');
       
        $artistData = $request->only('hourly_rate','specialty',"years_in_trade","walk_in_welcome","certified_professionals","consultation_available",
            "language_spoken","parking","payment_method","air_conditioned","water_available","coffee_available","mask_worn","vaccinated_staff","wheel_chair_accessible","bike_parking",
            "wifi_available","artist_of_the_year","insta_handle","facebook_handle","youtube_handle","twitter_handle","google_map_api","yelp_api",
            "shop_logo","shop_percentage","shop_email","shop_name","shop_address"
        );

        $close = $request->only( 'sunday_close','monday_close', 'tuesday_close', 'wednesday_close', 'thrusday_close','friday_close', 'saterday_close');

        $update = $this->artistInterface->updateArtist($data, decrypt($id), $timeData, $artistData, $close);
       
        if ($update) {
            return back()->with('msg', 'Artist information updated successfully.');
        } elseif ($update == 'No data') {
            return back()->with('msg', 'No artist found.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = $this->artistInterface->deleteArtist(decrypt($id));
        if ($delete) {
            return back()->with('msg', 'Artist has been deleted successfully with his all artworks .');
        } elseif ($delete == 'No data') {
            return back()->with('msg', 'No artwork found.');
        }
    }
}
