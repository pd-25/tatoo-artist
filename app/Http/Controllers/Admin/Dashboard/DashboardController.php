<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\core\artist\ArtistInterface;
use App\core\artwork\ArtworkInterface;
use App\Http\Controllers\Admin\Artist\ArtistController;
use App\Http\Controllers\Controller;
use App\Models\Quote;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Artwork;
use App\Models\Tattoform;
use Illuminate\Support\Facades\Log;
use App\Models\PaymentModel;
use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Support\Facades\Storage;
use App\Models\Subscription;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{

    private $artworkInterface, $artistInterface, $artistController;

    public function __construct(ArtistInterface $artistInterface, ArtistController $artistController, ArtworkInterface $artworkInterface)
    {
        $this->artistInterface = $artistInterface;
        $this->artistController = $artistController;
        $this->artworkInterface = $artworkInterface;
    }
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index(Request $request)
    {
        //Total user count
        $totalUsers = User::where('type', 'customer')->count();

        // Count the total number of artists
        $totalArtists = $this->artistInterface->getAllArtistss($request)->count();


        //Total artwork count
        $totalSalesPerson = User::where('type', 'sales')->count();

        //artist
        $totalSubscriber = '';
        $totalAppointment = '';
        $havesubscription = '';
        $totalArtwork = '';

        if (Auth::guard('artists')->check()) {
            $artistId = auth()->guard('artists')->id();
            $totalArtwork = $this->artworkInterface->getArtistWiseArtwork($artistId)->count();

            $sid = Subscription::where('user_id', $artistId)->first();
            $havesubscription = $sid->subscription_plan ?? '0';

            $totalAppointment = Appointment::where('artist_id', $artistId)->count();
        } elseif (Auth::guard('admins')->check()) {
            $totalSubscriber = Subscription::count();
            $totalAppointment = Appointment::count();
        } else {
            $salespersonId = Auth::guard('sales')->id();
            $artists = User::where('created_by', $salespersonId)->pluck('id');

            $totalSubscriber = Subscription::whereIn('user_id', $artists)->count();
            $totalAppointment = Appointment::whereIn('artist_id', $artists)->count();
        }






        // Total Artists1 count
        $totalArtist1 = Subscription::where('subscription_plan', '50')->count();

        $totalsalesprice1 = DB::table('payments')
            ->join('subscriptions', 'payments.user_id', '=', 'subscriptions.user_id')
            ->where('subscriptions.subscription_plan', '50')->sum('payments.price');

        $totalQuotes1 = DB::table('quotes')
            ->join('subscriptions', 'quotes.artist_id', '=', 'subscriptions.user_id')
            ->where('subscriptions.subscription_plan', '50')
            ->where('quotes.quote_type', '0')
            ->count();

        // Total Artists2 count
        // $totalArtist2 = Subscription::where('subscription_plan', '100')->count();

        // $totalsalesprice2 = DB::table('payments')
        //     ->join('subscriptions', 'payments.user_id', '=', 'subscriptions.user_id')
        //     ->where('subscriptions.subscription_plan', '100')->sum('payments.price');

        // $totalQuotes2 = DB::table('quotes')
        //     ->join('subscriptions', 'quotes.artist_id', '=', 'subscriptions.user_id')
        //     ->where('subscriptions.subscription_plan', '100')
        //     ->where('quotes.quote_type', '0')
        //     ->count();

        // // Total Artists3 count
        // $totalArtist3 = Subscription::where('subscription_plan', '300')->count();

        // $totalsalesprice3 = DB::table('payments')
        //     ->join('subscriptions', 'payments.user_id', '=', 'subscriptions.user_id')
        //     ->where('subscriptions.subscription_plan', '300')->sum('payments.price');

        // $totalQuotes3 = DB::table('quotes')
        //     ->join('subscriptions', 'quotes.artist_id', '=', 'subscriptions.user_id')
        //     ->where('subscriptions.subscription_plan', '300')
        //     ->where('quotes.quote_type', '0')
        //     ->count();
        $totalArtist1 = $totalArtist2 = $totalArtist3 = 0;
        $totalsalesprice1 = $totalsalesprice2 = $totalsalesprice3 = 0;
        $totalQuotes1 = $totalQuotes2 = $totalQuotes3 = 0;
        if (Auth::guard('artists')->check()) {
        } elseif (Auth::guard('admins')->check()) {
            // Admin: Fetch all data
            $totalArtist1 = Subscription::where('subscription_plan', '50')->count();
            $totalsalesprice1 = DB::table('payments')
                ->join('subscriptions', 'payments.user_id', '=', 'subscriptions.user_id')
                ->where('subscriptions.subscription_plan', '50')->sum('payments.price');
            $totalQuotes1 = DB::table('quotes')
                ->join('subscriptions', 'quotes.artist_id', '=', 'subscriptions.user_id')
                ->where('subscriptions.subscription_plan', '50')
                ->where('quotes.quote_type', '0')
                ->count();

            $totalArtist2 = Subscription::where('subscription_plan', '100')->count();
            $totalsalesprice2 = DB::table('payments')
                ->join('subscriptions', 'payments.user_id', '=', 'subscriptions.user_id')
                ->where('subscriptions.subscription_plan', '100')->sum('payments.price');
            $totalQuotes2 = DB::table('quotes')
                ->join('subscriptions', 'quotes.artist_id', '=', 'subscriptions.user_id')
                ->where('subscriptions.subscription_plan', '100')
                ->where('quotes.quote_type', '0')
                ->count();

            $totalArtist3 = Subscription::where('subscription_plan', '300')->count();
            $totalsalesprice3 = DB::table('payments')
                ->join('subscriptions', 'payments.user_id', '=', 'subscriptions.user_id')
                ->where('subscriptions.subscription_plan', '300')->sum('payments.price');
            $totalQuotes3 = DB::table('quotes')
                ->join('subscriptions', 'quotes.artist_id', '=', 'subscriptions.user_id')
                ->where('subscriptions.subscription_plan', '300')
                ->where('quotes.quote_type', '0')
                ->count();
        } else {
            // Salesperson: Fetch data for artists they created
            $salespersonId = Auth::guard('sales')->id();
            $artists = User::where('created_by', $salespersonId)->pluck('id');

            $totalArtist1 = Subscription::whereIn('user_id', $artists)->where('subscription_plan', '50')->count();
            $totalsalesprice1 = DB::table('payments')
                ->join('subscriptions', 'payments.user_id', '=', 'subscriptions.user_id')
                ->whereIn('subscriptions.user_id', $artists)
                ->where('subscriptions.subscription_plan', '50')->sum('payments.price');
            $totalQuotes1 = DB::table('quotes')
                ->join('subscriptions', 'quotes.artist_id', '=', 'subscriptions.user_id')
                ->whereIn('subscriptions.user_id', $artists)
                ->where('subscriptions.subscription_plan', '50')
                ->where('quotes.quote_type', '0')
                ->count();

            $totalArtist2 = Subscription::whereIn('user_id', $artists)->where('subscription_plan', '100')->count();
            $totalsalesprice2 = DB::table('payments')
                ->join('subscriptions', 'payments.user_id', '=', 'subscriptions.user_id')
                ->whereIn('subscriptions.user_id', $artists)
                ->where('subscriptions.subscription_plan', '100')->sum('payments.price');
            $totalQuotes2 = DB::table('quotes')
                ->join('subscriptions', 'quotes.artist_id', '=', 'subscriptions.user_id')
                ->whereIn('subscriptions.user_id', $artists)
                ->where('subscriptions.subscription_plan', '100')
                ->where('quotes.quote_type', '0')
                ->count();

            $totalArtist3 = Subscription::whereIn('user_id', $artists)->where('subscription_plan', '300')->count();
            $totalsalesprice3 = DB::table('payments')
                ->join('subscriptions', 'payments.user_id', '=', 'subscriptions.user_id')
                ->whereIn('subscriptions.user_id', $artists)
                ->where('subscriptions.subscription_plan', '300')->sum('payments.price');
            $totalQuotes3 = DB::table('quotes')
                ->join('subscriptions', 'quotes.artist_id', '=', 'subscriptions.user_id')
                ->whereIn('subscriptions.user_id', $artists)
                ->where('subscriptions.subscription_plan', '300')
                ->where('quotes.quote_type', '0')
                ->count();
        }


        $selectedyear =  date('Y');
        // FOR CHART LINK https://canvasjs.com/javascript-charts/multiple-axis-column-chart/
        if (!empty(Auth::guard('sales')->user()->id)) {
            if ($request->selected_year == '') {
                $selectedyear =  date('Y');
            } else {
                $selectedyear = $request->selected_year;
            }

            $months = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
            foreach ($months as $month) {

                $first_date_this_month = date($selectedyear . '-' . $month . '-01 00:00:00');
                $last_date_this_month  = date("Y-m-t 23:59:59", strtotime($first_date_this_month));

                // WALK IN 
                $WALKInDataCount = DB::table('quotes')
                    ->select('quotes.*')
                    ->join('subscriptions', 'quotes.artist_id', '=', 'subscriptions.user_id')
                    ->where('quotes.artist_id', Auth::guard('sales')->user()->id)
                    ->where('quotes.quote_type', '0')
                    ->where('quotes.created_at', '>=', $first_date_this_month)
                    ->where('quotes.created_at', '<=', $last_date_this_month)
                    ->count();
                $WALKInData[] = array('label' => date('F', strtotime($first_date_this_month)), 'y' => $WALKInDataCount);

                //Quotes
                $QuotesDataCount = DB::table('quotes')
                    ->select('quotes.*')
                    ->join('subscriptions', 'quotes.artist_id', '=', 'subscriptions.user_id')
                    ->where('quotes.artist_id', Auth::guard('sales')->user()->id)
                    ->where('quotes.quote_type', '1')
                    ->where('quotes.created_at', '>=', $first_date_this_month)
                    ->where('quotes.created_at', '<=', $last_date_this_month)
                    ->count();

                $QuotesData[] = array('label' => date('F', strtotime($first_date_this_month)), 'y' => $QuotesDataCount);

                // Sales Amount
                $totalSalesDeposit = DB::table('payments')
                    ->join('subscriptions', 'payments.user_id', '=', 'subscriptions.user_id')
                    ->where('payments.artist_id', Auth::guard('sales')->user()->id)
                    ->where('payments.date', '>=', $first_date_this_month)
                    ->where('payments.date', '<=', $last_date_this_month)
                    ->sum('payments.deposit');
                $totalSalesDepositAmount[] = array('label' => date('F', strtotime($first_date_this_month)), 'y' => $totalSalesDeposit);

                // Expenses Amount
                $totalExpensesAmount = DB::table('expense')
                    ->where('expense.user_id', Auth::guard('sales')->user()->id)
                    ->where('expense.transaction_date', '>=', $first_date_this_month)
                    ->where('expense.transaction_date', '<=', $last_date_this_month)
                    ->sum('expense.amount');
                $totalExpensesAmountData[] = array('label' => date('F', strtotime($first_date_this_month)), 'y' => $totalExpensesAmount);
            }





            return view(
                'admin.dashboard.dashboard',
                compact(
                    'totalUsers',
                    'totalArtists',
                    'totalArtists',
                    'totalSubscriber',
                    'totalSalesPerson',
                    'totalArtist1',
                    'totalArtist2',
                    'totalArtist3',
                    'totalsalesprice1',
                    'totalsalesprice2',
                    'totalsalesprice3',
                    'totalQuotes1',
                    'totalQuotes2',
                    'totalQuotes3',
                    'WALKInData',
                    'QuotesData',
                    'totalSalesDepositAmount',
                    'totalExpensesAmountData',
                    'totalArtwork',
                    'havesubscription',
                    'totalAppointment'
                )
            );
        } else {
            $WALKInData = array('label' => 0, 'y' => 0);
            $QuotesData = array('label' => 0, 'y' => 0);
            $totalSalesDepositAmount = array('label' => 0, 'y' => 0);
            $totalExpensesAmountData = array('label' => 0, 'y' => 0);

            return view(
                'admin.dashboard.dashboard',
                compact(
                    'totalUsers',
                    'totalArtists',
                    'totalSalesPerson',
                    'totalArtist1',
                    'totalArtist2',
                    'totalArtist3',
                    'totalsalesprice1',
                    'totalsalesprice2',
                    'totalsalesprice3',
                    'totalQuotes1',
                    'totalQuotes2',
                    'totalQuotes3',
                    'WALKInData',
                    'QuotesData',
                    'totalSalesDepositAmount',
                    'totalExpensesAmountData',
                    'totalSubscriber',




                )
            );
        }
    }
    //for sales
    public function impersonate($salesExeID)
    {
        // Save the current admin's ID in the session for later revert
        if (Auth::guard('admins')->check()) {
            session(['admin_id' => Auth::guard('admins')->id()]);
            session()->forget('sales_id');
        }
        if (Auth::guard('admins')->check()) {
            Auth::guard('admins')->logout();
        }

        // Perform impersonation
        Auth::guard('sales')->loginUsingId($salesExeID);

        // Redirect to the manager's dashboard
        return redirect()->route('admin.dashboard');
    }


    //for artist

    public function impersonateartist($salesExeID)
    {
        // Save the current admin's ID in the session for later revert
        if (Auth::guard('admins')->check()) {
            session(['admin_id' => Auth::guard('admins')->id()]);
            session()->forget('sales_id');
        } elseif (Auth::guard('sales')->check()) {

            session(['sales_id' => Auth::guard('sales')->id()]);
        }
        if (Auth::guard('admins')->check()) {
            Auth::guard('admins')->logout();
        }

        // Perform impersonation
        Auth::guard('sales')->loginUsingId($salesExeID);
        Auth::guard('artists')->loginUsingId($salesExeID);


        // Redirect to the manager's dashboard
        return redirect()->route('admin.dashboard');
    }

    public function revertImpersonate()
    {
        // Check if the session has the original admin's ID
        if (session('admin_id')) {
            //Destroying sales guard before login with admin
            if (Auth::guard('sales')->check()) {
                Auth::guard('sales')->logout();
            }
            if (Auth::guard('artists')->check()) {
                Auth::guard('artists')->logout();
            }
            // Re-login as the admin
            Auth::guard('admins')->loginUsingId(session('admin_id'));
            session()->forget('admin_id'); // Remove the admin_id from session


        }

        // Redirect back to the admin panel
        return redirect()->route('admin.dashboard');
    }

    public function revertImpersonateforsales()
    {
        // Check if the session has the original admin's ID
        if (session('admin_id')) {

            if (Auth::guard('artists')->check()) {
                Auth::guard('artists')->logout();
            }
            // Re-login as the admin
            Auth::guard('sales')->loginUsingId(session('sales_id'));
            session()->forget('sales_id');
        }

        // Redirect back to the admin panel
        return redirect()->route('sales.index');
    }

    public function qouteArchiveMove(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json(['error' => 'No quotes selected.'], 400);
        }

        // Update the `isarchive` field to 1 for the given IDs
        Quote::whereIn('id', $ids)->update(['isarchive' => 1]);

        return response()->json(['success' => 'Quotes moved to archives!']);
    }

    public function getWalkIn(Request $request)
    {
        // Format the start and end dates from the request
        $startDate = $request->has('start_date') ? Carbon::createFromFormat('m/d/Y', $request->start_date)->format('Y-m-d') : null;
        $endDate = $request->has('end_date') ? Carbon::createFromFormat('m/d/Y', $request->end_date)->format('Y-m-d') : null;
    
        // Fetch quotes based on the authenticated user's role
        $quotesQuery = Quote::with('user', 'artist')->where('isarchive', 0)->where('quote_type', 1);
    
        if (Auth::guard('artists')->check()) {
            $quotesQuery->where('artist_id', auth()->guard('artists')->id());
        } elseif (Auth::guard('sales')->check()) {
            $salespersonId = Auth::guard('sales')->id();
            $artistIds = User::where('created_by', $salespersonId)->pluck('id');
            $quotesQuery->whereIn('artist_id', $artistIds);
        }
    
        // Apply search filters
       
    
        if ($startDate && $endDate) {
            $quotesQuery->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        } elseif ($startDate) {
            $quotesQuery->whereDate('created_at', '>=', $startDate);
        } elseif ($endDate) {
            $quotesQuery->whereDate('created_at', '<=', $endDate);
        }
    
        $data['quotes'] = $quotesQuery->paginate(10);
    
        // Fetch customers based on role
        $customerQuery = User::select('users.*', 'creator.name as creator_name')
            ->leftJoin('users as creator', 'users.created_by', '=', 'creator.id')
            ->where('users.type', 'Customer')
            ->orderBy('users.id', 'DESC');
    
        if (Auth::guard('sales')->check()) {
            $salesUserId = Auth::guard('sales')->id();
            $customerQuery->where(function ($query) use ($salesUserId) {
                $query->where('users.created_by', $salesUserId)
                    ->orWhereIn('users.created_by', function ($subQuery) use ($salesUserId) {
                        $subQuery->select('id')->from('users')->where('created_by', $salesUserId);
                    });
            });
        } elseif (Auth::guard('artists')->check()) {
            $customerQuery->where('users.created_by', Auth::guard('artists')->id());
        }
    
        if ($request->filled('customer_name')) {
            $customerQuery->where('users.name', 'LIKE', '%' . $request->customer_name . '%');
        }
    
        $data['customers'] = $customerQuery->get();
        
        // Get all artists for the dropdown
        $data['artists'] = $this->artistInterface->getAllArtistss($re = null);
    
        return view("admin.walkin", $data);
    }
    
    public function getWalkinArchives()
    { {

            if (Auth::guard('artists')->check()) {
                $data['quotes'] = Quote::where('artist_id', auth()->guard('artists')->id())->with('user', 'artist')->where('isarchive', 1)
                    ->where('quote_type', 1)->paginate('10');
            } elseif (Auth::guard('admins')->check()) {
                $data['quotes'] = Quote::with('user', 'artist')->where('isarchive', 1)
                    ->where('quote_type', 1)->paginate('10');
            } else {
                $salespersonId = Auth::guard('sales')->id();
                $artists = User::where('created_by', $salespersonId)->get();

                $data['quotes'] = Quote::with('user', 'artist')->whereIn('artist_id', $artists->pluck('id'))->where('isarchive', 1)
                    ->where('quote_type', 1)->paginate('10');
            }

            //get customer id
            if (Auth::guard('admins')->check()) {
                // Admin can view all customers
                $customerQuery = User::select('users.*', 'creator.name as creator_name')
                    ->leftJoin('users as creator', 'users.created_by', '=', 'creator.id')
                    ->where('users.type', 'Customer')
                    ->orderBy('users.id', 'DESC');

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

                $data['customers'] = $customerQuery->get();
            } else {
                // For other users (like artists), just fetch their own created customers
                $data['customers'] = User::where('type', 'Customer')
                    ->where('created_by', Auth::guard('artists')->id())
                    ->orderBy('id', 'DESC')
                    ->get();
            }

            // Get all artist for the select dropdown

            $data['artists'] = $this->artistInterface->getAllArtistss();
            return view("admin.walkinArchive", $data);
        }
    }

    public function getQuote(Request $request)
    {
        if (Auth::guard('artists')->check()) {
            $data['quotes'] = Quote::where('artist_id', auth()->guard('artists')->id())->with('user', 'artist')->where('isarchive', 0)
                ->where('quote_type', 0)->paginate('10');
        } elseif (Auth::guard('admins')->check()) {
            $data['quotes'] = Quote::with('user', 'artist')->where('isarchive', 0)
                ->where('quote_type', 0)->paginate('10');
        } else {
            $salespersonId = Auth::guard('sales')->id();
            $artists = User::where('created_by', $salespersonId)->get();

            $data['quotes'] = Quote::with('user', 'artist')->whereIn('artist_id', $artists->pluck('id'))->where('isarchive', 0)
                ->where('quote_type', 0)->paginate('10');
        }

        //get customer id
        if (Auth::guard('admins')->check()) {
            // Admin can view all customers
            $customerQuery = User::select('users.*', 'creator.name as creator_name')
                ->leftJoin('users as creator', 'users.created_by', '=', 'creator.id')
                ->where('users.type', 'Customer')
                ->orderBy('users.id', 'DESC');

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

            $data['customers'] = $customerQuery->get();
        } else {
            // For other users (like artists), just fetch their own created customers
            $data['customers'] = User::where('type', 'Customer')
                ->where('created_by', Auth::guard('artists')->id())
                ->orderBy('id', 'DESC')
                ->get();
        }

        // Get all artist for the select dropdown

        $data['artists'] = $this->artistInterface->getAllArtistss();
        return view('admin.quote', $data);
    }
    public function getQuoteArchives()
    { {

            if (Auth::guard('artists')->check()) {
                $data['quotes'] = Quote::where('artist_id', auth()->guard('artists')->id())->with('user', 'artist')->where('isarchive', 1)
                    ->where('quote_type', 0)->paginate('10');
            } elseif (Auth::guard('admins')->check()) {
                $data['quotes'] = Quote::with('user', 'artist')->where('isarchive', 1)
                    ->where('quote_type', 0)->paginate('10');
            } else {
                $salespersonId = Auth::guard('sales')->id();
                $artists = User::where('created_by', $salespersonId)->get();

                $data['quotes'] = Quote::with('user', 'artist')->whereIn('artist_id', $artists->pluck('id'))->where('isarchive', 1)
                    ->where('quote_type', 0)->paginate('10');
            }

            //get customer id
            if (Auth::guard('admins')->check()) {
                // Admin can view all customers
                $customerQuery = User::select('users.*', 'creator.name as creator_name')
                    ->leftJoin('users as creator', 'users.created_by', '=', 'creator.id')
                    ->where('users.type', 'Customer')
                    ->orderBy('users.id', 'DESC');

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

                $data['customers'] = $customerQuery->get();
            } else {
                // For other users (like artists), just fetch their own created customers
                $data['customers'] = User::where('type', 'Customer')
                    ->where('created_by', Auth::guard('artists')->id())
                    ->orderBy('id', 'DESC')
                    ->get();
            }

            // Get all artist for the select dropdown

            $data['artists'] = $this->artistInterface->getAllArtistss();
            return view("admin.quoteArchive", $data);
        }
    }
    public function storeQuote(Request $request)
    {
        $request->validate([
            'artist_id' => 'required|exists:users,id',
            'user_id' => 'required|exists:users,id',
        ]);

        Quote::create([
            'artist_id' => $request->artist_id,
            'user_id' => $request->user_id,
        ]);
        return back()->with('success', 'Quote created successfully.');
    }
    public function getAppointment()
    {
        if (Auth::guard('artists')->check()) {
            $data['appointments'] = Appointment::where('artist_id', auth()->guard('artists')->id())->with('user', 'artist')->where('isarchive', 0)->paginate('10');
        } elseif (Auth::guard('admins')->check()) {
            $data['appointments'] = Appointment::with('user', 'artist')->where('isarchive', 0)->paginate('10');
        } else {

            $salespersonId = Auth::guard('sales')->id();
            $artists = User::where('created_by', $salespersonId)->get();

            $data['appointments'] = Appointment::with('user', 'artist')->whereIn('artist_id', $artists->pluck('id'))->where('isarchive', 0)->paginate('10');
        }

        //dd($data['quotes']);

        return view('admin.appointment', $data);
    }
    public function appointmentArchiveMove(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json(['error' => 'No quotes selected.'], 400);
        }

        // Update the `isarchive` field to 1 for the given IDs
        Appointment::whereIn('id', $ids)->update(['isarchive' => 1]);

        return response()->json(['success' => 'Quotes moved to archives!']);
    }
    public function getAppointmentArchives()
    {
        if (Auth::guard('artists')->check()) {
            $data['appointments'] = Appointment::where('artist_id', auth()->guard('artists')->id())->with('user', 'artist')->where('isarchive', 1)->paginate('10');
        } elseif (Auth::guard('admins')->check()) {
            $data['appointments'] = Appointment::with('user', 'artist')->where('isarchive', 1)->paginate('10');
        } else {

            $salespersonId = Auth::guard('sales')->id();
            $artists = User::where('created_by', $salespersonId)->get();

            $data['appointments'] = Appointment::with('user', 'artist')->whereIn('artist_id', $artists->pluck('id'))->where('isarchive',  1)->paginate('10');
        }

        //dd($data['quotes']);

        return view('admin.appointmentArchive', $data);
    }

    function SendLink(Request $request)
    {
        if ($request->has('type') && $request->input('type') === 'walkin') {
            $findCustomer = User::where("email", $request->email)->first();
            if ($findCustomer) {
                $customeId = $findCustomer->id;
            } else {
                $data = [
                    "password" => $request->email,
                    "type" => "Walk-In",
                    "email" => $request->email,
                    "name" => $request->email,
                    "username" => $request->email,
                ];
                $this->artistController->createCus($data);
                $getCustomerId = User::where("email", $request->email)->select("id")->first();
                $customeId = $getCustomerId->id;
            }
            $newQuote = Quote::create([
                'artist_id' => $request->artistid,
                'user_id' => $customeId,
                'quote_type' => 1
            ]);

            try {
                Mail::send('admin.email.sendlink', ["useremail" => $request->email, "user_id" => $customeId, "artist_id" => $request->artistid, "dbid" => $newQuote->id], function ($message) use ($request) {
                    $message->to($request->email);
                    $message->subject('TATTOO INFORMED CONSENT & MEDICAL HISTORY');
                });
                Quote::where('id', $newQuote->id)
                    ->update([
                        'link_send_status' => '1'
                    ]);
            } catch (\Throwable $th) {
                Log::debug($th->getMessage());
            }
            echo "emailsend";
        } else {
            $user = User::where('id', $request->userid)->first();
            $toemail = $user->email;
            try {
                Mail::send('admin.email.sendlink', ["useremail" => $user->email, "user_id" => $user->id, "artist_id" => $request->artistid, "dbid" => $request->dbid], function ($message) use ($toemail) {
                    $message->to($toemail);
                    $message->subject('TATTOO INFORMED CONSENT & MEDICAL HISTORY');
                });
            } catch (\Throwable $th) {
                Log::debug($th->getMessage());
            }

            Quote::where('id', $request->dbid)
                ->update([
                    'link_send_status' => '1'
                ]);

            echo "emailsend";
        }
    }

    // public function formlinkurl(Request $request){
    //     $data['user_id'] = request()->segment(2);
    //     $data['artist_id'] = request()->segment(3);
    //     $data['dbid'] = request()->segment(4);

    //     //check if this form is belongs to this user and the form is already submitted
    //     $quote = Quote::where('user_id', request()->segment(2))
    //           ->where('artist_id', request()->segment(3))
    //           ->where('id', request()->segment(4))
    //           ->first();

    //     if($quote):
    //        if(!is_null($quote->pdf_path)):
    //            $error_msg1 = "We have already received your submitted data.";
    //            $error_msg2 = "We'll be in touch shortly!";
    //            return view('admin.sendlink.error',compact('error_msg1','error_msg2'));
    //        else:
    //            return view('admin.sendlink.index',$data);
    //        endif;    
    //     else:
    //        $error_msg1 = "Something went wrong.";
    //        $error_msg2 = "Please get in touch us.";
    //        return view('admin.sendlink.error',compact('error_msg1','error_msg2'));
    //     endif;         
    // }



    public function formlinkurl(Request $request)
    {
        // Extract parameters from URL segments
        $userId = $request->segment(2);
        $artistId = $request->segment(3);
        $dbId = $request->segment(4);

        // Retrieve artist information
        $artistInfo = User::find($artistId);

        // Check if artist exists
        if (!$artistInfo) {
            $errorMsg1 = "Artist not found.";
            $errorMsg2 = "Please contact support.";
            return view('admin.sendlink.error', compact('errorMsg1', 'errorMsg2'));
        }

        // Check if the form belongs to the user and if it has been submitted
        $quote = Quote::where('user_id', $userId)
            ->where('artist_id', $artistId)
            ->where('id', $dbId)
            ->first();

        if ($quote) {
            if (!is_null($quote->pdf_path)) {
                $errorMsg1 = "We have already received your submitted data.";
                $errorMsg2 = "We'll be in touch shortly!";
                return view('admin.sendlink.error', compact('errorMsg1', 'errorMsg2'));
            } else {
                $data = [
                    'user_id' => $userId,
                    'artist_id' => $artistId,
                    'dbid' => $dbId,
                    'artistinfo' => $artistInfo
                ];
                return view('admin.sendlink.index', $data);
            }
        } else {
            $errorMsg1 = "Something went wrong.";
            $errorMsg2 = "Please get in touch with us.";
            return view('admin.sendlink.error', compact('errorMsg1', 'errorMsg2'));
        }
    }
    public function formatDate($requestDate)
    {
        $date = explode('/', $requestDate);
        $formattedDate = $date[2] . '-' . $date[0] . '-' . $date[1];
        return $formattedDate;
    }
    public function userformsubmit(Request $request)
    {
        /*
        $this->validate($request, [
            'any_history_of_or_current_conditions_of' => 'required',
            'signature' => 'required|image|mimes:jpeg,png,jpg,gif',
            'driving_licence_front' => 'required|image|mimes:jpeg,png,jpg,gif',
            'driving_licence_back' => 'required|image|mimes:jpeg,png,jpg,gif'
        ],[
            'banner_order.required' => 'Please enter banner order',
            'banner_text_top.required' => 'Please enter banner top text',
            'banner_text_middle.required' => 'Please enter banner middle text',
            'banner_text_buttom.required' => 'Please enter banner buttom text',
            'banner_url.required' => 'Please enter banner url',
            'image.required' => 'Please enter banner image',
        ]);
        */

        $signature_path = '';

        if ($request->file('signature')) {
            $file = $request->file('signature');
            $name = $file->getClientOriginalName();
            $signature_path = $file->storeAs('tattoform', $name, 'public');
        } elseif ($request->has('digital_signature')) {
            $digitalSignature = $request->input('digital_signature');
            $digitalSignature = str_replace('data:image/png;base64,', '', $digitalSignature);
            $digitalSignature = str_replace(' ', '+', $digitalSignature);
            $image = base64_decode($digitalSignature);
            $imageName = 'digital_signature_' . time() . '.png';
            $filePath = public_path('storage/tattoform/' . $imageName);
            file_put_contents($filePath, $image);
            $signature_path = 'tattoform/' . $imageName;
        }

        if ($request->file('driving_licence_front')) {
            $fileds       = $request->file('driving_licence_front');
            $nameds       = $fileds->getClientOriginalName();
            $driving_licence_front_path = $fileds->store('tattoform', 'public', $nameds);
        } else {
            $driving_licence_front_path = '';
        }

        if ($request->file('driving_licence_back')) {
            $filedsb       = $request->file('driving_licence_back');
            $namedsb       = $filedsb->getClientOriginalName();
            $driving_licence_back_path = $filedsb->store('tattoform', 'public', $namedsb);
        } else {
            $driving_licence_back_path = '';
        }

        $tatto = new Tattoform();
        $tatto->user_id                                       = $request['user_id'];
        $tatto->artist_id                                     = $request['artist_id'];
        $tatto->general_good_health                           = $request['general_good_health'];
        $tatto->you_under_any_medical_treatment               = $request['you_under_any_medical_treatment'];
        $tatto->you_currently_taking_any_drugs                = $request['you_currently_taking_any_drugs'];
        $tatto->you_have_a_history_of_medication              = $request['you_have_a_history_of_medication'];
        $tatto->you_have_a_history_of_fainting                = $request['you_have_a_history_of_fainting'];
        $tatto->are_you_allergic_to_latex                     = $request['are_you_allergic_to_latex'];
        $tatto->have_any_wounds_healed_slowly                 = $request['have_any_wounds_healed_slowly'];
        $tatto->are_you_allergic_to_any_know_materials        = $request['are_you_allergic_to_any_know_materials'];
        $tatto->any_risk_factors_from_work_or_lifestyle       = $request['any_risk_factors_from_work_or_lifestyle'];
        $tatto->are_you_pregnant_or_nursing                   = $request['are_you_pregnant_or_nursing'];
        $tatto->cardiac_valve_disease                         = $request['cardiac_valve_disease'];
        $tatto->high_blood_pressure                           = $request['high_blood_pressure'];
        $tatto->respiratory_disease                           = $request['respiratory_disease'];
        $tatto->diabetes                                      = $request['diabetes'];
        $tatto->tumors_or_growths                             = $request['tumors_or_growths'];
        $tatto->hemophilia                                    = $request['hemophilia'];
        $tatto->liver_disease                                 = $request['liver_disease'];
        $tatto->bleeding_disorder                             = $request['bleeding_disorder'];
        $tatto->kidney_disease                                = $request['kidney_disease'];
        $tatto->epilepsy                                      = $request['epilepsy'];
        $tatto->jaundice                                      = $request['jaundice'];
        $tatto->exposure_to_aids                              = $request['exposure_to_aids'];
        $tatto->hepatitis                                     = $request['hepatitis'];
        $tatto->venereal_disease                              = $request['venereal_disease'];
        $tatto->herpes_infection_at_proposed_procedure_site   = $request['herpes_infection_at_proposed_procedure_site'];
        $tatto->name                                          = $request['name'];
        $tatto->todaysdate                                    = $this->formatDate($request['todaysdate']);
        $tatto->birthdate                                     = $this->formatDate($request['birthdate']);
        $tatto->phone                                         = $request['phone'];
        $tatto->address                                       = $request['address'];
        $tatto->stateid                                       = $request['stateid'];
        $tatto->signature                                     = $signature_path;
        $tatto->driving_licence_front                         = $driving_licence_front_path;
        $tatto->driving_licence_back                          = $driving_licence_back_path;
        $tatto->save();

        $data['artistdata'] = User::find($request['artist_id']);

        $data['tattodata'] = Tattoform::where('id', $tatto->id)->first();
        // return view('admin.email.tatto-submited-form', $data);
        // GET User Details
        $user = User::where('id', $request['user_id'])->first();

        $pdf = PDF::loadView('admin.email.tatto-submited-form', $data);

        //return $pdf->stream('tattoform.pdf'); die;
        $content = $pdf->download()->getOriginalContent();
        $pdfname = time() . '.pdf';
        Storage::put('public/tattopdf/' . $pdfname, $content);
        //$path =  Storage::url('public/tattopdf/'.$pdfname);
        $path = asset('storage/tattopdf/' . $pdfname);

        $toemail = $user->email;
        Mail::send('admin.email.view-tatto', ['fullpath' => $path], function ($message) use ($toemail) {
            $message->to($toemail);
            //$message->to('biswajitmaityniit@gmail.com');
            //$message->bcc('test@salesanta.com');
            $message->subject('User Tattoo Submitted Data.');
        });

        Quote::where('id', $request->dbid)
            ->update([
                'link_send_status' => '2',
                'pdf_path' => $path
            ]);
        return redirect()->route('admin.success')->with('message', 'Record added successfully!');
        //return redirect()->back()->with('message', 'Form data submited successfully.');
    }

    public function success()
    {
        return view('admin.sendlink.success');
    }

    public function deleteQuote($id)
    {
        $find =  Quote::where('id', decrypt($id))->first();
        if ($find) {
            $find->delete();
            return back()->with('msg', 'Quote deleted successfully');
        }
        return back()->with('msg', 'No Quote found');
    }

    public function deleteAppointment($id)
    {
        $find =  Appointment::where('id', decrypt($id))->first();
        if ($find) {
            $find->delete();
            return back()->with('msg', 'Appointment was deleted successfully');
        }
        return back()->with('msg', 'No Quote found');
    }
}
