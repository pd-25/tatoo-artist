<?php

namespace App\Http\Controllers\artist;

use App\Models\Quote;
use App\Models\Appointment;
use App\core\artist\ArtistInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Style;
use App\Models\Artwork;

class DashboardController extends Controller
{
    private $artistInterface;

    public function __construct(ArtistInterface $artistInterface)
    {
        $this->artistInterface = $artistInterface;
    }
   public function index() {
     //Total Art works
     $totalArtworks = Artwork::where('user_id',auth()->guard('artists')->id())->count();

     //Total Appointments
     $totalAppointments = Appointment::where('artist_id',auth()->guard('artists')->id())->count();

     //Total Appointments
     $totalQuotes = Quote::where('artist_id',auth()->guard('artists')->id())->count();

     return view('admin.dashboard.dashboard',compact('totalArtworks','totalAppointments','totalQuotes'));
   }

   public function profile() {
    $data['artist'] = $this->artistInterface->getSingleArtist(auth()->guard('artists')->id());
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
}
