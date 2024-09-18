<?php

namespace App\Http\Controllers\Admin\Artist;
use Illuminate\Support\Facades\Auth;
use App\core\artist\ArtistInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Style;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

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
public function index(Request $re)
{
    // Get the list of artists using the repository method
    $artists = $this->artistInterface->getAllArtistss($re);
    
    // Calculate the total number of artists
    $totalArtists = $artists->count();
    
    // Prepare the data to be passed to the view
    $data['artists'] = $artists;
    $data['totalArtists'] = $totalArtists;
    
    // Return the view with the data
    return view('admin.artist.index', $data);
}

    /**
     * Display a listing of the customers.
     */
    public function customers(Request $re)
    {
        $searchCustomer = trim($re->search_customer);
    
        if (Auth::guard('admins')->check()) {
            // Admin can view all customers
            $customerQuery = User::select('users.*', 'creator.name as creator_name')
                ->leftJoin('users as creator', 'users.created_by', '=', 'creator.id')
                ->where('users.type', 'Customer')
                ->orderBy('users.id', 'DESC');
    
            if (!empty($searchCustomer)) {
                $customerQuery->where(function ($query) use ($searchCustomer) {
                    $query->where('users.username', 'LIKE', "%{$searchCustomer}%")
                        ->orWhere('users.name', 'LIKE', "%{$searchCustomer}%")
                        ->orWhere('users.email', 'LIKE', "%{$searchCustomer}%");
                });
            }
    
            $data['customers'] = $customerQuery->get();
        } elseif (Auth::guard('sales')->check()) {
            $salesUserId = Auth::guard('sales')->id();
    
            // Get customers created by this sales user
            $customerQuery = User::select('users.*', 'creator.name as creator_name')
                ->leftJoin('users as creator', 'users.created_by', '=', 'creator.id')
                ->where('users.type', 'Customer')
                ->where(function ($query) use ($salesUserId) {
                    $query->where('users.created_by', $salesUserId)
                        ->orWhereIn('users.created_by', function ($subQuery) use ($salesUserId) {
                            $subQuery->select('id')
                                ->from('users')
                                ->where('created_by', $salesUserId);
                        });
                })
                ->orderBy('users.id', 'DESC');
    
            if (!empty($searchCustomer)) {
                $customerQuery->where(function ($query) use ($searchCustomer) {
                    $query->where('users.username', 'LIKE', "%{$searchCustomer}%")
                        ->orWhere('users.name', 'LIKE', "%{$searchCustomer}%")
                        ->orWhere('users.email', 'LIKE', "%{$searchCustomer}%");
                });
            }
    
            $data['customers'] = $customerQuery->get();
        } else {
            // For other users (like artists), just fetch their own created customers
            $data['customers'] = User::where('type', 'Customer')
                ->where('created_by', Auth::guard('artists')->id())
                ->orderBy('id', 'DESC')
                ->get();
        }
    
        return view('admin.customers.index', $data);
    }
    
    
    
    
    
    public function addCustomer()
    {
       
        return view('admin.customers.add');
    }
    public function storeCustomer(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'phone' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'min:6',
           
        ]);
    
        $data = $request->only('name', 'username', 'phone', 'email');
        $this->createCus($data);
    
        return redirect()->route('admin.customers')->with('msg', 'Customer added successfully');
    }
    public function createCus($data){
        $data['password'] = Hash::make($data["email"]);
        $data['type'] = 'customer';
        $data['walkin'] = '1';
        if (Auth::guard('admins')->check()) {
            $data['created_by'] = 0;
        } elseif(Auth::guard('sales')->check()) {
            $data['created_by'] = Auth::guard('sales')->id();
        }else{
            $data['created_by'] = Auth::guard('artists')->id();
        }

        User::create($data);
    }
    
    public function editCustomer($id)
    {
        $data['customer'] = User::where('id', $id)->first();
        return view('admin.customers.edit', $data);
    }

    public function updateCustomer(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // 'username' => 'required|string|max:255', // Username might be unique and not changeable
            'phone' => 'string', // Assuming a max length for phone numbers
            'email' => 'required|string|email|max:255', // Make sure to add a unique rule if email should be unique
            'address' => 'required|string|max:255',
            'password' => 'nullable|string|min:6|confirmed' // Password field is optional
        ]);
    
        $data = $request->only('name', 'username', 'phone', 'email', 'address');
    
        // Check if password is provided and update it
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
    
        User::where('id', $id)->update($data);
    
        return redirect()->route('admin.customers')->with('msg', 'Data updated successfully');
    }
    

    // public function destroyCustomer($id)
    // {
    //     User::where('id', $id)->update(['status' => 0]);
    //     return redirect()->route('admin.customers')->with('msg', 'Data blocked successfully');
    // }

    public function destroyCustomer($id)
    {
        // Find the user by id and delete
        User::where('id', $id)->delete();
        
        // Redirect to the customers route with a success message
        return redirect()->route('admin.customers')->with('msg', 'Data deleted successfully');
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['styles'] = Style::orderBy('id', 'asc')->get();
        return view('admin.artist.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'zipcode' => 'required|numeric|min:6',
            'phone' => 'numeric',
            'address' => 'nullable|string',
        ]);
        $data = $request->only('name', 'username', 'email', 'phone', 'address', 'password', 'zipcode', 'profile_image', 'banner_image',"latitude", "longitude", "address2", "country", "state", "city");
        $timeData = $request->only('sunday_from', 'sunday_to', 'monday_from', 'monday_to', 'tuesday_from', 'tuesday_to', 'wednesday_from', 'wednesday_to', 'thrusday_from', 'thrusday_to', 'friday_from', 'friday_to', 'saterday_from', 'saterday_to');

        $artistData = $request->only(
            'hourly_rate',
            'specialty',
            "years_in_trade",
            "walk_in_welcome",
            "certified_professionals",
            "consultation_available",
            "language_spoken",
            "parking",
            "payment_method",
            "air_conditioned",
            "water_available",
            "coffee_available",
            "mask_worn",
            "vaccinated_staff",
            "wheel_chair_accessible",
            "bike_parking",
            "wifi_available",
            "artist_of_the_year",
            "insta_handle",
            "facebook_handle",
            "youtube_handle",
            "twitter_handle",
            "google_map_api",
            "yelp_api",
            "shop_logo",
            "shop_percentage",
            "shop_email",
            "shop_name",
            "shop_address"
        );

        $store = $this->artistInterface->storeArtistData($data, $timeData, $artistData);
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
        $data['artistData'] = @$data['artist']->artistData;
        $data['languageSpoken'] = explode(',', @$data['artistData']->language_spoken);
        $data['PaymentMethod'] = explode(',', @$data['artistData']->payment_method);
        $data['styles'] = Style::orderBy('id', 'asc')->get();
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
    // Validation rules
    $request->validate([
        'name' => 'required|string',
        'zipcode' => 'required|numeric|min:6',
        'phone' => 'numeric',
        'address' => 'nullable|string',
        'email' => 'email|unique:users,email,' . decrypt($id),
        'username' => 'string|unique:users,username,' . decrypt($id),
    ]);

    // Data to be updated
    $data = $request->only('name', 'username', 'email', 'phone', 'address', 'address2', 'country', 'state', 'city', 'password', 'zipcode', 'latitude', 'longitude', 'profile_image', 'banner_image');
    $timeData = $request->only('sunday_from', 'sunday_to', 'monday_from', 'monday_to', 'tuesday_from', 'tuesday_to', 'wednesday_from', 'wednesday_to', 'thrusday_from', 'thrusday_to', 'friday_from', 'friday_to', 'saterday_from', 'saterday_to');
    $artistData = $request->only('hourly_rate', 'specialty', 'years_in_trade', 'walk_in_welcome', 'certified_professionals', 'consultation_available', 'language_spoken', 'parking', 'payment_method', 'air_conditioned', 'water_available', 'coffee_available', 'mask_worn', 'vaccinated_staff', 'wheel_chair_accessible', 'bike_parking', 'wifi_available', 'artist_of_the_year', 'insta_handle', 'facebook_handle', 'youtube_handle', 'twitter_handle', 'google_map_api', 'yelp_api', 'shop_logo', 'shop_percentage', 'shop_email', 'shop_name', 'shop_address');
    $close = $request->only('sunday_close', 'monday_close', 'tuesday_close', 'wednesday_close', 'thrusday_close', 'friday_close', 'saterday_close');

    try {
        // Attempt to update the artist
        $update = $this->artistInterface->updateArtist($data, decrypt($id), $timeData, $artistData, $close);

        // Check the result and return appropriate message
        if ($update) {
            return back()->with('msg', 'Artist information updated successfully.');
        } elseif ($update == 'No data') {
            return back()->with('msg', 'No artist found.');
        }
    } catch (QueryException $e) {
        // Catching unique constraint violation exception
        if ($e->errorInfo[1] == 1062) {
            // Determine which unique constraint was violated and set the error message
            if (str_contains($e->getMessage(), 'users_email_unique')) {
                $errorMessage = 'The email address is already in use. Please use a different email address.';
            } elseif (str_contains($e->getMessage(), 'users_username_unique')) {
                $errorMessage = 'The username is already in use. Please use a different username.';
            } else {
                $errorMessage = 'A unique constraint violation occurred.';
            }
            // Return with error message
            return back()->withErrors(['msg' => $errorMessage])->withInput();
        }

        // Other SQL related errors
        return back()->withErrors(['msg' => 'An error occurred while updating the artist information. Please try again later.'])->withInput();
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
