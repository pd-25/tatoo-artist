<?php

namespace App\Http\Controllers\Admin\Payment;

use App\Http\Controllers\Controller;
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
    public function getAcceptPayment(Request $request){
        if (Auth::guard('artists')->check()){
            $payments = PaymentModel::with('placementData','artist')->where('artist_id',Auth::guard('artists')->user()->id)->get();
        } 
        elseif(Auth::guard('admins')->check()){
            $payments = PaymentModel::with('placementData', 'user', 'artist')->get();
        }else{
            $salespersonId = Auth::guard('sales')->id(); 
            $artists = User::where('created_by', $salespersonId)->get();

            $payments = PaymentModel::with('placementData', 'user', 'artist')->whereIn('artist_id', $artists->pluck('id'))->get(); 

        }
        //dd($payments);
        return view('admin.payment.index',compact('payments'));
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
    public function getDepositSlipsArchives(Request $request){
        if (Auth::guard('artists')->check()){
            $payments = PaymentModel::with('user','artist')->where('artist_id',Auth::guard('artists')->user()->id)->where('isarchive',1)->orderBy('id','desc')->paginate('10');
        }
        elseif (Auth::guard('admins')->check()){
            $payments = PaymentModel::with('user','artist')->where('isarchive',1)->orderBy('id','desc')->paginate('10');
        }else{
            $salespersonId = Auth::guard('sales')->id(); 
            $artists = User::where('created_by', $salespersonId)->get();
            
            $payments = PaymentModel::with('user','artist')->whereIn('artist_id', $artists->pluck('id'))->where('isarchive',1)->orderBy('id','desc')->paginate('10');
        }

        //dd($payments);
        return view('admin.payment.depositArchives',compact('payments'));
    }
    public function getDepositSlips(Request $request){
        if (Auth::guard('artists')->check()){
            $payments = PaymentModel::with('user','artist')->where('artist_id',Auth::guard('artists')->user()->id)->where('isarchive',0)->orderBy('id','desc')->paginate('10');
        }
        elseif (Auth::guard('admins')->check()){
            $payments = PaymentModel::with('user','artist')->where('isarchive',0)->orderBy('id','desc')->paginate('10');
        }else{
            $salespersonId = Auth::guard('sales')->id(); 
            $artists = User::where('created_by', $salespersonId)->get();
            
            $payments = PaymentModel::with('user','artist')->whereIn('artist_id', $artists->pluck('id'))->where('isarchive',0)->orderBy('id','desc')->paginate('10');
        }

        //dd($payments);
        return view('admin.payment.deposit',compact('payments'));
    }

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
        }
        elseif (Auth::guard('admins')->check()) {
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
        }
        else {
            $salespersonId = Auth::guard('sales')->id();
            $artists = User::where('created_by', $salespersonId)->pluck('id');
    
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
        }
    
        return view('admin.payment.deposit', compact('payments'));
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
        $artistId = $request->artist_id;
    
        if ($artistId) {
            $artist = User::where('id', $artistId)->where('type', 'artist')->first();
            if ($artist && $artist->artistData) {
                $artistData = $artist->artistData;
                $paymentMethods = explode(',', $artistData->payment_method);  // Split by comma into an array
            }
        }
    
        return response()->json($paymentMethods);
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
        $fees = $request->fees ?? 0;
    
        // Calculate percentages
        $shopPercentage = round($deposit * 0.03, 2);
        $artistPercentage = round($deposit * 0.02, 2);
    
        // Determine deposit_total
        $depositTotal = $request->deposit_total ?? $deposit;
    
        // Determine total_due
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
        $payment->date              = now()->format('Y-m-d');
    
        // Add initial deposit log if deposit present
        if ($deposit > 0) {
            $payment->deposit_log = json_encode([[
                'date'   => now()->toDateTimeString(),
                'amount' => $deposit,
                'method' => $request->payment_method,
            ]]);
        }
    
        $payment->save();
    
        return redirect()->route('admin.deposit-slips')->with('message', 'Payment added successfully.');

    }
    
    public function showInstallments($id)
{
    $payment = PaymentModel::findOrFail($id);
    $placement= Placement::find($payment->placement);
    $installments = $payment->deposit_log ? json_decode($payment->deposit_log, true) : [];

    return view('admin.payment.instalment', compact('payment', 'installments','placement'));
}

public function addDepositInstallment(Request $request)
{
    $request->validate([
        'payment_id' => 'required|exists:payments,id',
        'amount'     => 'required|numeric|min:0.01',
        'method'     => 'required|string',
    ]);

    $payment = PaymentModel::findOrFail($request->payment_id);

    // Get existing log or start new
    $log = $payment->deposit_log ? json_decode($payment->deposit_log, true) : [];

    // Add new installment entry
    $log[] = [
        'date'   => now()->toDateTimeString(),
        'amount' => $request->amount,
        'method' => $request->method,
    ];

    // Update deposit total
    $payment->deposit_total += $request->amount;
    $payment->deposit_log = json_encode($log);

    // Recalculate totals
    $price = $payment->price ?? 0;
    $tips  = $payment->tips ?? 0;
    $fees  = $payment->fees ?? 0;
    $deposit_total = $payment->deposit_total;

    $payment->total_due = $price  - $deposit_total;

    // Update percentages
    $payment->shop_percentage   = ($deposit_total * 3) / 100;
    $payment->artist_percentage = ($deposit_total * 2) / 100;

    $payment->save();

    return redirect()->back()->with('message', 'Installment deposit added and totals updated successfully.');
}

    

    public function editpaymentForm(Request $request,$id){
        if(Auth::guard('artists')->check()){
            $artists = User::where('type', '=', 'artist')->get();
        }
        elseif(Auth::guard('admins')->check()){
            $artists = User::where('type', '=', 'artist')->get();
        }else{
            $salespersonId = Auth::guard('sales')->id(); 
            $artists = User::where('created_by', $salespersonId)->where('type', '=', 'artist')->get();
        }

        $payments = PaymentModel::where('id',decrypt($id))->first();
        $placements = Placement::all();

        return view('admin.payment.edit',compact('payments','placements','artists'));
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
            'payment_method'   => 'required|string',
            'bill_image'       => 'nullable|image|mimes:jpeg,png,jpg,gif',
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
        $shopPercentage = round($depositTotal * 0.03, 2);
        $artistPercentage = round($depositTotal * 0.02, 2);
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
        $payment->payment_method    = $request->payment_method;
        $payment->bill_image        = $imagePath;
    
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
    

    public function deletepaymentForm(Request $request,$id){
        $pmodel = PaymentModel::find(decrypt($id));
        $pmodel->delete();
        return back()->with('msg', 'Record deleted successfully.');
    }
    public function paymentview(Request $request,$id){
     
        if(Auth::guard('artists')->check()){
            $artists = User::where('type', '=', 'artist')->get();
        }
        elseif(Auth::guard('admins')->check()){
            $artists = User::where('type', '=', 'artist')->get();
        }else{
            $salespersonId = Auth::guard('sales')->id(); 
            $artists = User::where('created_by', $salespersonId)->where('type', '=', 'artist')->get();
        }

        $payments = PaymentModel::where('id',decrypt($id))->first();
        $placements = Placement::all();

        return view('admin.payment.print',compact('payments','placements','artists'));
    }

}
