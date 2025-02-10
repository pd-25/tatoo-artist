<?php

namespace App\Http\Controllers\artist;

use App\Models\Quote;
use App\Models\Appointment;
use App\core\artist\ArtistInterface;
use App\core\artwork\ArtworkInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Style;
use App\Models\Artwork;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private $artistInterface, $artworkInterface;

    public function __construct(ArtistInterface $artistInterface, ArtworkInterface $artworkInterface)
    {
        $this->artistInterface = $artistInterface;
        $this->artworkInterface = $artworkInterface;
    }
//    public function index(Request $request) {
//      //Total Art works
//      $totalArtworks = Artwork::where('user_id',auth()->guard('artists')->id())->count();

//      //Total Appointments
//      $totalAppointments = Appointment::where('artist_id',auth()->guard('artists')->id())->count();

//      //Total Appointments
//      $totalQuotes = Quote::where('artist_id',auth()->guard('artists')->id())->count();
//      if ($request->selected_year == '') {
//         $selectedyear =  date('Y');
//     } else {
//         $selectedyear = $request->selected_year;
//     }
//     $artistId = auth()->guard('artists')->id();
//     $totalArtwork = $this->artworkInterface->getArtistWiseArtwork($artistId)->count();

//     $sid = Subscription::where('user_id', $artistId)->first();
//     $havesubscription = $sid->subscription_plan ?? '0';

//     $totalAppointment = Appointment::where('artist_id', $artistId)->count();
//      $months = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
//             foreach ($months as $month) {

//                 $first_date_this_month = date($selectedyear . '-' . $month . '-01 00:00:00');
//                 $last_date_this_month  = date("Y-m-t 23:59:59", strtotime($first_date_this_month));

//                 // WALK IN 
//                 $WALKInDataCount = DB::table('quotes')
//                     ->select('quotes.*')
//                     ->join('subscriptions', 'quotes.artist_id', '=', 'subscriptions.user_id')
//                     ->where('quotes.artist_id', Auth::guard('artists')->user()->id)
//                     ->where('quotes.quote_type', '0')
//                     ->where('quotes.created_at', '>=', $first_date_this_month)
//                     ->where('quotes.created_at', '<=', $last_date_this_month)
//                     ->count();
//                 $WALKInData[] = array('label' => date('F', strtotime($first_date_this_month)), 'y' => $WALKInDataCount);

//                 //Quotes
//                 $QuotesDataCount = DB::table('quotes')
//                     ->select('quotes.*')
//                     ->join('subscriptions', 'quotes.artist_id', '=', 'subscriptions.user_id')
//                     ->where('quotes.artist_id', Auth::guard('artists')->user()->id)
//                     ->where('quotes.quote_type', '1')
//                     ->where('quotes.created_at', '>=', $first_date_this_month)
//                     ->where('quotes.created_at', '<=', $last_date_this_month)
//                     ->count();

//                 $QuotesData[] = array('label' => date('F', strtotime($first_date_this_month)), 'y' => $QuotesDataCount);

//                 // Sales Amount
//                 $totalSalesDeposit = DB::table('payments')
//                     ->join('subscriptions', 'payments.user_id', '=', 'subscriptions.user_id')
//                     ->where('payments.artist_id', Auth::guard('artists')->user()->id)
//                     ->where('payments.date', '>=', $first_date_this_month)
//                     ->where('payments.date', '<=', $last_date_this_month)
//                     ->sum('payments.deposit');
//                 $totalSalesDepositAmount[] = array('label' => date('F', strtotime($first_date_this_month)), 'y' => $totalSalesDeposit);

//                 // Expenses Amount
//                 $totalExpensesAmount = DB::table('expense')
//                     ->where('expense.user_id', Auth::guard('artists')->user()->id)
//                     ->where('expense.transaction_date', '>=', $first_date_this_month)
//                     ->where('expense.transaction_date', '<=', $last_date_this_month)
//                     ->sum('expense.amount');
//                 $totalExpensesAmountData[] = array('label' => date('F', strtotime($first_date_this_month)), 'y' => $totalExpensesAmount);
//             }

//      return view('admin.dashboard.dashboard',compact('totalArtworks','totalAppointments','totalQuotes', 'WALKInData','QuotesData','totalSalesDepositAmount','totalExpensesAmountData', 'havesubscription', 'totalArtwork', 'totalAppointment'));
//    }
public function index(Request $request) {
    $selectedyear = $request->input('selected_year', date('Y')); // Default to current year if empty

    $artistId = auth()->guard('artists')->id();
    $totalArtworks = Artwork::where('user_id',auth()->guard('artists')->id())->count();
    $totalAppointments = Appointment::where('artist_id',auth()->guard('artists')->id())->count();

    //      //Total Appointments
         $totalQuotes = Quote::where('artist_id',auth()->guard('artists')->id())->count();
         $artistId = auth()->guard('artists')->id();
             $totalArtwork = $this->artworkInterface->getArtistWiseArtwork($artistId)->count();
         
             $sid = Subscription::where('user_id', $artistId)->first();
             $havesubscription = $sid->subscription_plan ?? '0';
    // Initialize data arrays
    $WALKInData = [];
    $QuotesData = [];
    $totalSalesDepositAmount = [];
    $totalExpensesAmountData = [];
    $totalAppointment = Appointment::where('artist_id', $artistId)->count();
    $months = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
    foreach ($months as $month) {
        $first_date_this_month = date("$selectedyear-$month-01 00:00:00");
        $last_date_this_month  = date("Y-m-t 23:59:59", strtotime($first_date_this_month));

        // Walk-In Data
        $WALKInData[] = [
            'label' => date('F', strtotime($first_date_this_month)),
            'y' => DB::table('quotes')
                ->where('artist_id', $artistId)
                ->where('quote_type', '0')
                ->whereBetween('created_at', [$first_date_this_month, $last_date_this_month])
                ->count()
        ];

        // Quotes Data
        $QuotesData[] = [
            'label' => date('F', strtotime($first_date_this_month)),
            'y' => DB::table('quotes')
                ->where('artist_id', $artistId)
                ->where('quote_type', '1')
                ->whereBetween('created_at', [$first_date_this_month, $last_date_this_month])
                ->count()
        ];

        // Sales Deposit
        $totalSalesDepositAmount[] = [
            'label' => date('F', strtotime($first_date_this_month)),
            'y' => DB::table('payments')
                ->where('artist_id', $artistId)
                ->whereBetween('date', [$first_date_this_month, $last_date_this_month])
                ->sum('deposit')
        ];

        // Expenses Amount
        $totalExpensesAmountData[] = [
            'label' => date('F', strtotime($first_date_this_month)),
            'y' => DB::table('expense')
                ->where('user_id', $artistId)
                ->whereBetween('transaction_date', [$first_date_this_month, $last_date_this_month])
                ->sum('amount')
        ];
    }

    return view('admin.dashboard.dashboard', compact('totalArtworks','totalAppointments','totalQuotes', 'WALKInData','QuotesData','totalSalesDepositAmount','totalExpensesAmountData', 'havesubscription', 'totalArtwork', 'totalAppointment'));
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
