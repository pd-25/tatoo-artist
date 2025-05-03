<?php

namespace App\Http\Controllers\Admin\Payment;

use App\Http\Controllers\Controller;
use App\Models\ArtistData;
use Illuminate\Http\Request;
use App\Models\Placement;
use App\Models\PaymentModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function getAcceptPayment(Request $request)
    {
        if (Auth::guard('artists')->check()) {
            $payments = PaymentModel::with('placementData', 'artist')->where('artist_id', Auth::guard('artists')->user()->id)->get();
        } elseif (Auth::guard('admins')->check()) {
            $payments = PaymentModel::with('placementData', 'user', 'artist')->get();
        } else {
            $salespersonId = Auth::guard('sales')->id();
            $artists = User::where('created_by', $salespersonId)->get();

            $payments = PaymentModel::with('placementData', 'user', 'artist')->whereIn('artist_id', $artists->pluck('id'))->get();
        }
        //dd($payments);
        return view('admin.payment.index', compact('payments'));
    }
    public function depositArchiveMove(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json(['error' => 'No quotes selected.'], 400);
        }

        // Update the `isarchive` field to 1 for the given IDs
        PaymentModel::whereIn('id', $ids)->update(['isarchive' => 1]);

        return response()->json(['success' => 'Moved to archives sucessfully!']);
    }
    public function getDepositSlipsArchives(Request $request)
    {
        if (Auth::guard('artists')->check()) {
            $payments = PaymentModel::with('user', 'artist')->where('artist_id', Auth::guard('artists')->user()->id)->where('isarchive', 1)->orderBy('id', 'desc')->paginate('10');
        } elseif (Auth::guard('admins')->check()) {
            $payments = PaymentModel::with('user', 'artist')->where('isarchive', 1)->orderBy('id', 'desc')->paginate('10');
        } else {
            $salespersonId = Auth::guard('sales')->id();
            $artists = User::where('created_by', $salespersonId)->get();

            $payments = PaymentModel::with('user', 'artist')->whereIn('artist_id', $artists->pluck('id'))->where('isarchive', 1)->orderBy('id', 'desc')->paginate('10');
        }

        //dd($payments);
        return view('admin.payment.depositArchives', compact('payments'));
    }
    public function getDepositSlips(Request $request)
    {
        $payments = null;
        $customers = [];
        $ccfees=0;

        if (Auth::guard('artists')->check()) {
            $payments = PaymentModel::with('user', 'artist')
                ->where('artist_id', Auth::guard('artists')->user()->id)
                ->where('isarchive', 0)
                ->orderBy('id', 'desc')
                ->paginate(10);

        } elseif (Auth::guard('admins')->check()) {
            $payments = PaymentModel::with('user', 'artist')
                ->where('isarchive', 0)
                ->orderBy('id', 'desc')
                ->paginate(10);
        } else {
            $salespersonId = Auth::guard('sales')->id();
            $artists = User::where('created_by', $salespersonId)->get();
            $payments = PaymentModel::with('user', 'artist')
                ->whereIn('artist_id', $artists->pluck('id'))
                ->where('isarchive', 0)
                ->orderBy('id', 'desc')
                ->paginate(10);
        }
        $ccfees = $payments->sum('fees');
        // Extract unique customer names from the payments collection
        $customers = $payments->pluck('customers_name')->unique()->values()->toArray();

       

        // Remove dd($payments) to allow the view to render
        return view('admin.payment.deposit', compact('payments', 'customers','ccfees'));
    }
    // public function getDepositSlips(Request $request){
    //     if (Auth::guard('artists')->check()){
    //         $payments = PaymentModel::with('user','artist')->where('artist_id',Auth::guard('artists')->user()->id)->where('isarchive',0)->orderBy('id','desc')->paginate('10');
    //         dd($payments);
    //     }
    //     elseif (Auth::guard('admins')->check()){
    //         $payments = PaymentModel::with('user','artist')->where('isarchive',0)->orderBy('id','desc')->paginate('10');
    //         dd($payments);
    //     }else{
    //         $salespersonId = Auth::guard('sales')->id(); 
    //         $artists = User::where('created_by', $salespersonId)->get();

    //         $payments = PaymentModel::with('user','artist')->whereIn('artist_id', $artists->pluck('id'))->where('isarchive',0)->orderBy('id','desc')->paginate('10');
    //         dd($payments);
    //     }

    //     //dd($payments);
    //     return view('admin.payment.deposit',compact('payments'));
    // }

    // public function getFilteredDeposits(Request $request){

    //     if ($request->has('start_date')) {
    //         $requestStartDate = explode('/',$request->start_date);
    //         $startDate = $requestStartDate[2].'-'.$requestStartDate[0].'-'.$requestStartDate[1];
    //     }else{
    //         $startDate = null;
    //     }

    //     if ($request->has('end_date')) {
    //         $requestEndDate = explode('/',$request->end_date);
    //         $endDate = $requestEndDate[2].'-'.$requestEndDate[0].'-'.$requestEndDate[1];
    //     }else{
    //         $endDate = null;
    //     }

    //     $request->flash();

    //     if (Auth::guard('artists')->check()){
    //         $query = PaymentModel::where('artist_id',Auth::guard('artists')->user()->id);

    //         if(!empty($startDate)):
    //             $query->where('date', '>=', $startDate);
    //         endif;    

    //         if(!empty($endDate)):
    //             $query->where('date', '<=', $endDate);
    //         endif;    

    //         $payments = $query->paginate(10);
    //     }
    //     elseif (Auth::guard('admins')->check()){
    //         $query = PaymentModel::with('user');

    //         if(!empty($startDate)):
    //             $query->where('date', '>=', $startDate);
    //         endif;    

    //         if(!empty($endDate)):
    //             $query->where('date', '<=', $endDate);
    //         endif;    

    //         $payments = $query->paginate(10);
    //     }else{
    //         $salespersonId = Auth::guard('sales')->id(); 
    //         $artists = User::where('created_by', $salespersonId)->get();

    //         $query = PaymentModel::with('user');

    //         if(!empty($startDate)):
    //             $query->where('date', '>=', $startDate);
    //         endif;    

    //         if(!empty($endDate)):
    //             $query->where('date', '<=', $endDate);
    //         endif;    

    //         $payments = $query->whereIn('artist_id', $artists->pluck('id'))->paginate(10);
    //     }
    //     return view('admin.payment.deposit',compact('payments'));
    // }
    public function getFilteredDeposits(Request $request)
    {
        // Format the start and end dates from request safely
        $startDate = null;
        $endDate = null;

        if ($request->filled('start_date') && substr_count($request->start_date, '/') === 2) {
            $requestStartDate = explode('/', $request->start_date);
            if (count($requestStartDate) === 3) {
                $startDate = $requestStartDate[2] . '-' . $requestStartDate[0] . '-' . $requestStartDate[1];
            }
        }

        if ($request->filled('end_date') && substr_count($request->end_date, '/') === 2) {
            $requestEndDate = explode('/', $request->end_date);
            if (count($requestEndDate) === 3) {
                $endDate = $requestEndDate[2] . '-' . $requestEndDate[0] . '-' . $requestEndDate[1];
            }
        }

        // Flash old inputs
        $request->flash();

        $customerName = $request->input('customers_name');

        if (Auth::guard('artists')->check()) {
            // Payments query for artists
            $query = PaymentModel::where('artist_id', Auth::guard('artists')->user()->id);

            if (!empty($startDate)) {
                $query->where('date', '>=', $startDate);
            }

            if (!empty($endDate)) {
                $query->where('date', '<=', $endDate);
            }

            if (!empty($customerName)) {
                $query->where('customers_name', 'like', '%' . $customerName . '%');
            }

            $payments = $query->with('user')->paginate(10);

            // Get all customer names for this artist
            $customers = PaymentModel::where('artist_id', Auth::guard('artists')->user()->id)
                ->pluck('customers_name')
                ->unique()
                ->values()
                ->toArray();
        } elseif (Auth::guard('admins')->check()) {
            // Payments query for admins
            $query = PaymentModel::with('user');

            if (!empty($startDate)) {
                $query->where('date', '>=', $startDate);
            }

            if (!empty($endDate)) {
                $query->where('date', '<=', $endDate);
            }

            if (!empty($customerName)) {
                $query->where('customers_name', 'like', '%' . $customerName . '%');
            }

            $payments = $query->paginate(10);

            // Get all customer names for admins
            $customers = PaymentModel::pluck('customers_name')
                ->unique()
                ->values()
                ->toArray();
        } else {
            $salespersonId = Auth::guard('sales')->id();
            $artists = User::where('created_by', $salespersonId)->pluck('id');

            // Payments query for sales
            $query = PaymentModel::with('user')->whereIn('artist_id', $artists);

            if (!empty($startDate)) {
                $query->where('date', '>=', $startDate);
            }

            if (!empty($endDate)) {
                $query->where('date', '<=', $endDate);
            }

            if (!empty($customerName)) {
                $query->where('customers_name', 'like', '%' . $customerName . '%');
            }

            $payments = $query->paginate(10);

            // Get all customer names for this salesperson's artists
            $customers = PaymentModel::whereIn('artist_id', $artists)
                ->pluck('customers_name')
                ->unique()
                ->values()
                ->toArray();
        }

        // Pass both payments and customers to the view
        return view('admin.payment.deposit', compact('payments', 'customers'));
    }




    public function printDepositPDF(Request $request)
    {
        // Format the start and end dates from request
        if ($request->has('start_date')) {
            $requestStartDate = explode('/', $request->start_date);
            $startDate = $requestStartDate[2] . '-' . $requestStartDate[0] . '-' . $requestStartDate[1];
        } else {
            $startDate = null;
        }

        if ($request->has('end_date')) {
            $requestEndDate = explode('/', $request->end_date);
            $endDate = $requestEndDate[2] . '-' . $requestEndDate[0] . '-' . $requestEndDate[1];
        } else {
            $endDate = null;
        }

        // Query logic for different user guards
        if (Auth::guard('artists')->check()) {
            $query = PaymentModel::where('artist_id', Auth::guard('artists')->user()->id);

            if (!empty($startDate)) {
                $query->where('date', '>=', $startDate);
            }

            if (!empty($endDate)) {
                $query->where('date', '<=', $endDate);
            }

            $payments = $query->get();
        } elseif (Auth::guard('admins')->check()) {
            $query = PaymentModel::with('user');

            if (!empty($startDate)) {
                $query->where('date', '>=', $startDate);
            }

            if (!empty($endDate)) {
                $query->where('date', '<=', $endDate);
            }

            $payments = $query->get();
        } else {
            $salespersonId = Auth::guard('sales')->id();
            $artists = User::where('created_by', $salespersonId)->get();

            $query = PaymentModel::with('user');

            if (!empty($startDate)) {
                $query->where('date', '>=', $startDate);
            }

            if (!empty($endDate)) {
                $query->where('date', '<=', $endDate);
            }

            $payments = $query->whereIn('artist_id', $artists->pluck('id'))->get();
        }

        // Pass the payments data to a PDF view
        return view('admin.payment.reportprint', compact('payments', 'startDate', 'endDate'));
    }


    public function getPaymentMethods(Request $request)
    {
        $paymentMethods = [];
        $shop_percentage = null;
        $artistId = $request->artist_id;

        if ($artistId) {
            $artist = User::where('id', $artistId)->where('type', 'artist')->first();
            if ($artist && $artist->artistData) {
                $artistData = $artist->artistData;
                $paymentMethods = explode(',', $artistData->payment_method);
                $shop_percentage = $artistData->shop_percentage;
                $cc_fees = $artistData->cc_fees;
                $cc_fees_percentage = $artistData->cc_fees_percentage;
            }
        }

        return response()->json([
            'paymentMethods' => $paymentMethods,
            'shop_percentage' => $shop_percentage,
            'cc_fees' => $cc_fees,
            'cc_fees_percentage' => $cc_fees_percentage

        ]);
    }

    public function AddpaymentForm(Request $request)
    {
        $artistId = null;

        // Check if an artist is logged in and get their ID
        if (Auth::guard('artists')->check()) {
            $artistId = Auth::guard('artists')->id();
            $artists = collect(); // Initialize an empty collection if the user is an artist
        } elseif ($request->artist_id) {
            // Get the artist_id from the form if available (in case of admin or sales)
            $artistId = $request->artist_id;
            $artists = collect(); // Ensure it's initialized even if no guard matches
        }

        // Fetch the list of artists for admins or salespersons
        if (Auth::guard('admins')->check()) {
            $artists = User::where('type', '=', 'artist')->get();
        } elseif (Auth::guard('sales')->check()) {
            $salespersonId = Auth::guard('sales')->id();
            $artists = User::where('created_by', $salespersonId)
                ->where('type', '=', 'artist')
                ->get();
        }

        // Initialize payment methods array
        $paymentMethods = [];

        // Fetch the selected artist's payment methods if artistId is set
        if ($artistId) {
            $artist = User::where('id', $artistId)->where('type', 'artist')->first();
            if ($artist && $artist->artistData) {
                $artistData = $artist->artistData;
                $paymentMethods = explode(',', $artistData->payment_method);  // Split by comma into an array
            }
        }

        // Retrieve placements
        $placements = Placement::all();

        // Pass payment methods and other data to the view
        return view('admin.payment.create', compact('placements', 'artists', 'paymentMethods', 'artistId'));
    }







    // public function AddpaymentPost(Request $request)
    // {
    //     // Validate the request inputs
    //     $this->validate($request, [
    //         'artist_id'        => 'required',
    //         'customers_name'   => 'required|string', // Ensuring it's a string
    //         'design'           => 'required|string', // Ensuring it's a string
    //         'price'            => 'required|numeric', // Ensure price is numeric
    //         'deposit'          => 'nullable|numeric', // Ensure deposit is numeric
    //         'tips'             => 'nullable|numeric', // Ensure tips is numeric
    //         'fees'             => 'nullable|numeric', // Ensure fees is numeric
    //         'total_due'       => 'nullable|numeric', // Ensure total_due is numeric
    //         'bill_image'       => 'image|mimes:jpeg,png,jpg,gif'
    //     ], [
    //         'artist_id.required' => 'Please select an artist',
    //         'customers_name.required' => 'Please enter customer name',
    //         'design.required' => 'Please enter Design',
    //         'price.required' => 'Please enter price',
    //         'bill_image.required' => 'Please upload Bill Document',
    //     ]);

    //     // Determine the user ID based on the authenticated guard
    //     if (Auth::guard('artists')->check()) {
    //         $userid = Auth::guard('artists')->user()->id;
    //     } elseif (Auth::guard('admins')->check()) {
    //         $userid = Auth::guard('admins')->user()->id;
    //     } else {
    //         $userid = Auth::guard('sales')->id();
    //     }

    //     // Handle the bill image upload
    //     $path = '';
    //     if ($request->hasFile('bill_image')) {
    //         $file = $request->file('bill_image');
    //         $filename = $file->getClientOriginalName();
    //         $file->storeAs('public/DepositSlip/', $filename);
    //         $path = Storage::url('public/DepositSlip/' . $filename);
    //     }

    //     // Create a new payment record
    //     $pmodel = new PaymentModel();
    //     $pmodel->user_id          = $userid;
    //     $pmodel->date             = now()->format('Y-m-d'); // Automatically set today's date
    //     $pmodel->artist_id        = $request->artist_id;
    //     $pmodel->customers_name    = $request->customers_name;
    //     $pmodel->design           = $request->design;
    //     $pmodel->placement        = $request->placement;
    //     $pmodel->price            = $request->price;
    //     $pmodel->deposit          = $request->deposit ?? 0; // Default to 0 if null
    //     $pmodel->tips             = $request->tips ?? 0; // Default to 0 if null
    //     $pmodel->fees             = $request->fees ?? 0; // Default to 0 if null
    //     $pmodel->total_due        = $request->total_due ?? 0; // Default to 0 if null
    //     $pmodel->payment_method   = $request->payment_method;
    //     $pmodel->bill_image       = $path;

    //     // Save the payment model
    //     $pmodel->save();

    //     return redirect()->back()->with('message', 'Payment added successfully.');
    // }










//payment add edit delete show etc.....
    public function AddpaymentPost(Request $request)
    {
        // Validate inputs
        $request->validate([
            'artist_id'        => 'required|integer',
            'customers_name'   => 'required|string',
            'design'           => 'required|string',
            'placement'        => 'nullable|string',
            'price'            => 'required|numeric',
            'deposit'          => 'nullable|numeric',
            'deposit_total'    => 'nullable|numeric',
            'tips'             => 'nullable|numeric',
            'fees'             => 'nullable|numeric',
            'total_due'        => 'nullable|numeric',
            'payment_method'   => 'required|string',
            'bill_image'       => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'reimbursed'       => 'nullable|integer',
            'notes'            => 'nullable|string'
        ]);

        // Logged-in user check
        if (Auth::guard('artists')->check()) {
            $userId = Auth::guard('artists')->id();
        } elseif (Auth::guard('admins')->check()) {
            $userId = Auth::guard('admins')->id();
        } else {
            $userId = Auth::guard('sales')->id();
        }

        // Handle bill image upload
        $imagePath = '';
        if ($request->hasFile('bill_image')) {
            $file = $request->file('bill_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/DepositSlip/', $filename);
            $imagePath = Storage::url('public/DepositSlip/' . $filename);
        }

        // Prepare values
        $price = $request->price;
        $deposit = $request->deposit ?? 0;
        $tips = $request->tips ?? 0;

        // Get artist data
        $artistData = ArtistData::where('artist_id', $request->artist_id)->first();
        $shopPercentageValue = $artistData ? (float)$artistData->shop_percentage : 0;
        $artistPercentageValue = 100 - $shopPercentageValue;

        $shopPercentage = round($deposit * $shopPercentageValue / 100, 2);
        $artistPercentage = round($deposit * $artistPercentageValue / 100, 2);

        // Fees Calculation Based on reimbursed & cc_fees
        $reimbursed = $request->reimbursed ?? 0;
        $fees = 0;

        if ($reimbursed == 0 && $artistData) {
            switch ((int)$artistData->cc_fees) {
                case 1:
                    $fees = 0;
                    break;
                case 2:
                    $fees = round(
                        $deposit * ($artistData->cc_fees_percentage / 100) * ($artistData->shop_percentage / 100),
                        2
                    );
                    break;
                case 3:
                    $fees = round(
                        $deposit * ($artistData->cc_fees_percentage / 100),
                        2
                    );
                    break;
                default:
                    $fees = 0;
            }
        }

        // Determine deposit_total and total_due
        $depositTotal = $request->deposit_total ?? $deposit;
        $totalDue = $request->total_due ?? ($price - $depositTotal);

        // Init payment model
        $payment = new PaymentModel();
        $payment->user_id           = $userId;
        $payment->artist_id         = $request->artist_id;
        $payment->customers_name    = $request->customers_name;
        $payment->design            = $request->design;
        $payment->placement         = $request->placement;
        $payment->price             = $price;
        $payment->deposit_total     = $depositTotal;
        $payment->tips              = $tips;
        $payment->fees              = $fees;
        $payment->total_due         = $totalDue;
        $payment->shop_percentage   = $shopPercentage;
        $payment->artist_percentage = $artistPercentage;
        $payment->payment_method    = $request->payment_method;
        $payment->bill_image        = $imagePath;
        $payment->isarchive         = 0;
        $payment->notes             = $request->notes;
        $payment->date              = now()->format('Y-m-d');

        // Add initial deposit log if deposit present
        if ($deposit > 0) {
            $payment->deposit_log = json_encode([[
                'date'       => now()->toDateTimeString(),
                'amount'     => $deposit,
                'method'     => $request->payment_method,
                'reimbursed' => $reimbursed,
            ]]);
        }

        $payment->save();

        return redirect()->route('admin.deposit-slips')->with('message', 'Payment added successfully.');
    }
    public function editpaymentForm(Request $request, $id)
    {
        if (Auth::guard('artists')->check()) {
            $artists = User::where('type', '=', 'artist')->get();
        } elseif (Auth::guard('admins')->check()) {
            $artists = User::where('type', '=', 'artist')->get();
        } else {
            $salespersonId = Auth::guard('sales')->id();
            $artists = User::where('created_by', $salespersonId)->where('type', '=', 'artist')->get();
        }

        $payments = PaymentModel::where('id', decrypt($id))->first();
        $placements = Placement::all();

        return view('admin.payment.edit', compact('payments', 'placements', 'artists'));
    }

    public function editpaymentPost(Request $request, $id)
    {
        $request->validate([
            'artist_id'        => 'required|integer',
            'customers_name'   => 'required|string',
            'design'           => 'required|string',
            'placement'        => 'nullable|string',
            'price'            => 'required|numeric|min:0',
            'deposit'          => 'nullable|numeric|min:0',
            'deposit_total'    => 'nullable|numeric|min:0',
            'tips'             => 'nullable|numeric|min:0',
            'fees'             => 'nullable|numeric|min:0',
            'total_due'        => 'nullable|numeric|min:0',
            'bill_image'       => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'notes'            => 'nullable|string'
        ]);
        $payment = PaymentModel::findOrFail($id);

        $price = $request->price;
        $deposit = $request->deposit ?? 0;
        $depositTotal = $request->deposit_total ?? $deposit;

        // Validation: Deposit & Total should not exceed Price
        if ($deposit > $price) {
            return back()->withInput()->withErrors(['deposit' => 'Initial deposit cannot be greater than price.']);
        }

        if ($depositTotal > $price) {
            return back()->withInput()->withErrors(['deposit_total' => 'Total deposit cannot be greater than price.']);
        }

        // Handle bill image (replace if uploaded)
        $imagePath = $payment->bill_image;
        if ($request->hasFile('bill_image')) {
            $file = $request->file('bill_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/DepositSlip/', $filename);
            $imagePath = Storage::url('public/DepositSlip/' . $filename);
        }

        // Percentages
        $artistData = ArtistData::where('artist_id', $request->artist_id)->first();
        $shopPercentageValue = $artistData ? (float)$artistData->shop_percentage : 0; // Assuming shop_percentage is a column in ArtistData
        $artistPercentageValue = 100 - $shopPercentageValue;

        $shopPercentage = round($depositTotal * $shopPercentageValue / 100, 2);
        $artistPercentage = round($depositTotal * $artistPercentageValue / 100, 2);


        $totalDue = $request->total_due ?? ($price - $depositTotal);

        // Update values
        $payment->artist_id         = $request->artist_id;
        $payment->customers_name    = $request->customers_name;
        $payment->design            = $request->design;
        $payment->placement         = $request->placement;
        $payment->price             = $price;
        $payment->deposit_total     = $depositTotal;
        $payment->tips              = $request->tips ?? 0;
        $payment->fees              = $request->fees ?? 0;
        $payment->total_due         = $totalDue;
        $payment->shop_percentage   = $shopPercentage;
        $payment->artist_percentage = $artistPercentage;
        $payment->bill_image        = $imagePath;
        $payment->notes             = $request->notes;

        // Update deposit log if initial deposit added
        if ($deposit > 0) {
            $existingLog = json_decode($payment->deposit_log, true) ?? [];
            $existingLog[] = [
                'date'   => now()->toDateTimeString(),
                'amount' => $deposit,
                'method' => $request->payment_method,
            ];
            $payment->deposit_log = json_encode($existingLog);
        }

        $payment->save();

        return redirect()->route('admin.deposit-slips')->with('message', 'Payment updated successfully.');
    }


    public function deletepaymentForm(Request $request, $id)
    {
        $pmodel = PaymentModel::find(decrypt($id));
        $pmodel->delete();
        return back()->with('msg', 'Record deleted successfully.');
    }
    public function paymentview(Request $request, $id)
    {

        if (Auth::guard('artists')->check()) {
            $artists = User::where('type', '=', 'artist')->get();
        } elseif (Auth::guard('admins')->check()) {
            $artists = User::where('type', '=', 'artist')->get();
        } else {
            $salespersonId = Auth::guard('sales')->id();
            $artists = User::where('created_by', $salespersonId)->where('type', '=', 'artist')->get();
        }

        $payments = PaymentModel::where('id', decrypt($id))->first();
        $placements = Placement::all();

        return view('admin.payment.print', compact('payments', 'placements', 'artists'));
    }



    public function showInstallments($id)
    {
        $payment = PaymentModel::findOrFail($id);
        $placement = Placement::find($payment->placement);
        $installments = $payment->deposit_log ? json_decode($payment->deposit_log, true) : [];

        return view('admin.payment.instalment', compact('payment', 'installments', 'placement'));
    }

    public function addDepositInstallment(Request $request)
    {
        $request->validate([
            'payment_id' => 'required|exists:payments,id',
            'amount'     => 'required|numeric|min:0.01',
            'method'     => 'required|string',
            'reimbursed' => 'nullable|integer'
        ]);

        $payment = PaymentModel::findOrFail($request->payment_id);

        // Get existing log or start new
        $log = $payment->deposit_log ? json_decode($payment->deposit_log, true) : [];

        // Add new installment entry
        $log[] = [
            'date'       => now()->toDateTimeString(),
            'amount'     => $request->amount,
            'method'     => $request->method,
            'reimbursed' => $request->reimbursed ?? 0,
        ];

        // Update deposit total
        $payment->deposit_total += $request->amount;
        $payment->deposit_log = json_encode($log);

        // Recalculate total due
        $price = $payment->price ?? 0;
        $deposit_total = $payment->deposit_total;
        $payment->total_due = $price - $deposit_total;

        // Update percentages
        $artistData = ArtistData::where('artist_id', $payment->artist_id)->first();
        $shopPercentageValue = $artistData ? (float)$artistData->shop_percentage : 0;
        $artistPercentageValue = 100 - $shopPercentageValue;

        $payment->shop_percentage = round($deposit_total * $shopPercentageValue / 100, 2);
        $payment->artist_percentage = round($deposit_total * $artistPercentageValue / 100, 2);

        // Recalculate fees based on reimbursed == 0 logs
        $totalValidDeposit = collect($log)
            ->filter(fn($entry) => ($entry['reimbursed'] ?? 0) == 0)
            ->sum('amount');

        $fees = 0;
        if ($artistData && $totalValidDeposit > 0) {
            switch ((int)$artistData->cc_fees) {
                case 1:
                    $fees = 0;
                    break;
                case 2:
                    $fees = round(
                        $totalValidDeposit * ($artistData->cc_fees_percentage / 100) * ($artistData->shop_percentage / 100),
                        2
                    );
                    break;
                case 3:
                    $fees = round(
                        $totalValidDeposit * ($artistData->cc_fees_percentage / 100),
                        2
                    );
                    break;
                default:
                    $fees = 0;
            }
        }

        $payment->fees = $fees;

        $payment->save();

        return redirect()->back()->with('message', 'Installment deposit added and totals updated successfully.');
    }
    public function updateReimbursed(Request $request, PaymentModel $payment)
    {
        $request->validate([
            'index' => 'required|integer',
        ]);

        $log = $payment->deposit_log ? json_decode($payment->deposit_log, true) : [];

        if (!isset($log[$request->index])) {
            return redirect()->back()->with('error', 'Invalid installment index.');
        }

        $originalLog = $log[$request->index]; // previous log before toggling

        // Toggle reimbursed value (0 <-> 1)
        $log[$request->index]['reimbursed'] = $originalLog['reimbursed'] == 1 ? 0 : 1;

        // Save back the updated log
        $payment->deposit_log = json_encode($log);
        $payment->save();

        // === Recalculate fees based on all reimbursed == 0 entries ===
        $artistData = ArtistData::where('artist_id', $payment->artist_id)->first();
        $totalFees = 0;

        if ($artistData) {
            foreach ($log as $entry) {
                if ($entry['reimbursed'] == 0 && in_array($artistData->cc_fees, [2, 3])) {
                    $deposit = (float)$entry['amount'];
                    $cc = (float)$artistData->cc_fees_percentage;
                    $shop = (float)$artistData->shop_percentage;

                    if ($artistData->cc_fees == 2) {
                        $totalFees += $deposit * $cc / 100 * $shop / 100;
                    } elseif ($artistData->cc_fees == 3) {
                        $totalFees += $deposit * $cc / 100;
                    }
                }
            }
        }

        // Update the recalculated fees
        $payment->fees = round($totalFees, 2);
        $payment->save();

        return redirect()->back()->with('message', 'Reimbursed status and fees updated successfully.');
    }

    public function deleteReimbursed(Request $request, PaymentModel $payment)
    {
        $request->validate([
            'index' => 'required|integer',
        ]);

        $log = $payment->deposit_log ? json_decode($payment->deposit_log, true) : [];

        if (!isset($log[$request->index])) {
            return redirect()->back()->with('error', 'Invalid installment index.');
        }

        // Remove the specified log entry
        unset($log[$request->index]);

        // Re-index array
        $log = array_values($log);
        $payment->deposit_log = json_encode($log);

        // Recalculate deposit total
        $depositTotal = 0;
        foreach ($log as $entry) {
            $depositTotal += (float) $entry['amount'];
        }
        $payment->deposit_total = $depositTotal;

        // Recalculate fees for reimbursed = 0
        $artistData = ArtistData::where('artist_id', $payment->artist_id)->first();
        $totalFees = 0;

        if ($artistData) {
            foreach ($log as $entry) {
                if ($entry['reimbursed'] == 0 && in_array($artistData->cc_fees, [2, 3])) {
                    $deposit = (float)$entry['amount'];
                    $cc = (float)$artistData->cc_fees_percentage;
                    $shop = (float)$artistData->shop_percentage;

                    if ($artistData->cc_fees == 2) {
                        $totalFees += $deposit * $cc / 100 * $shop / 100;
                    } elseif ($artistData->cc_fees == 3) {
                        $totalFees += $deposit * $cc / 100;
                    }
                }
            }
        }

        $payment->fees = round($totalFees, 2);

        // Update total due
        $price = $payment->price ?? 0;
        $payment->total_due = $price - $payment->deposit_total;

        // Recalculate shop/artist percentage
        $shopPercentage = $artistData ? (float)$artistData->shop_percentage : 0;
        $artistPercentage = 100 - $shopPercentage;

        $payment->shop_percentage = round($depositTotal * $shopPercentage / 100, 2);
        $payment->artist_percentage = round($depositTotal * $artistPercentage / 100, 2);

        $payment->save();

        return redirect()->back()->with('message', 'Installment deleted and values updated successfully.');
    }
}
