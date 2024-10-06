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

    public function getDepositSlips(Request $request){
        if (Auth::guard('artists')->check()){
            $payments = PaymentModel::with('user','artist')->where('artist_id',Auth::guard('artists')->user()->id)->get();
        }
        elseif (Auth::guard('admins')->check()){
            $payments = PaymentModel::with('user','artist')->get();
        }else{
            $salespersonId = Auth::guard('sales')->id(); 
            $artists = User::where('created_by', $salespersonId)->get();
            
            $payments = PaymentModel::with('user','artist')->whereIn('artist_id', $artists->pluck('id'))->get();
        }

        //dd($payments);
        return view('admin.payment.deposit',compact('payments'));
    }

    public function getFilteredDeposits(Request $request){

        // Format the start and end dates from request
        if ($request->has('start_date')) {
            $requestStartDate = explode('/',$request->start_date);
            $startDate = $requestStartDate[2].'-'.$requestStartDate[0].'-'.$requestStartDate[1];
        }else{
            $startDate = null;
        }

        if ($request->has('end_date')) {
            $requestEndDate = explode('/',$request->end_date);
            $endDate = $requestEndDate[2].'-'.$requestEndDate[0].'-'.$requestEndDate[1];
        }else{
            $endDate = null;
        }

        // var_dump($startDate);
        // var_dump($endDate);
        // exit;

        // Flash the input data to the session
        $request->flash();

        if (Auth::guard('artists')->check()){
            $query = PaymentModel::where('user_id',Auth::guard('artists')->user()->id);

            if(!empty($startDate)):
                $query->where('date', '>=', $startDate);
            endif;    

            if(!empty($endDate)):
                $query->where('date', '<=', $endDate);
            endif;    
            
            $payments = $query->get();
        }
        elseif (Auth::guard('admins')->check()){
            $query = PaymentModel::with('user');

            if(!empty($startDate)):
                $query->where('date', '>=', $startDate);
            endif;    

            if(!empty($endDate)):
                $query->where('date', '<=', $endDate);
            endif;    
            
            $payments = $query->get();
        }else{
            $salespersonId = Auth::guard('sales')->id(); 
            $artists = User::where('created_by', $salespersonId)->get();

            $query = PaymentModel::with('user');

            if(!empty($startDate)):
                $query->where('date', '>=', $startDate);
            endif;    

            if(!empty($endDate)):
                $query->where('date', '<=', $endDate);
            endif;    
            
            $payments = $query->whereIn('artist_id', $artists->pluck('id'))->get();
        }
        return view('admin.payment.deposit',compact('payments'));
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

    
    
    
    
    

    public function AddpaymentPost(Request $request)
    {
        // Validate the request inputs
        $this->validate($request, [
            'artist_id'        => 'required',
            'customers_name'   => 'required|string', // Ensuring it's a string
            'design'           => 'required|string', // Ensuring it's a string
            'price'            => 'required|numeric', // Ensure price is numeric
            'deposit'          => 'nullable|numeric', // Ensure deposit is numeric
            'tips'             => 'nullable|numeric', // Ensure tips is numeric
            'fees'             => 'nullable|numeric', // Ensure fees is numeric
            'total_due'       => 'nullable|numeric', // Ensure total_due is numeric
            'bill_image'       => 'image|mimes:jpeg,png,jpg,gif'
        ], [
            'artist_id.required' => 'Please select an artist',
            'customers_name.required' => 'Please enter customer name',
            'design.required' => 'Please enter Design',
            'price.required' => 'Please enter price',
            'bill_image.required' => 'Please upload Bill Document',
        ]);
    
        // Determine the user ID based on the authenticated guard
        if (Auth::guard('artists')->check()) {
            $userid = Auth::guard('artists')->user()->id;
        } elseif (Auth::guard('admins')->check()) {
            $userid = Auth::guard('admins')->user()->id;
        } else {
            $userid = Auth::guard('sales')->id();
        }
    
        // Handle the bill image upload
        $path = '';
        if ($request->hasFile('bill_image')) {
            $file = $request->file('bill_image');
            $filename = $file->getClientOriginalName();
            $file->storeAs('public/DepositSlip/', $filename);
            $path = Storage::url('public/DepositSlip/' . $filename);
        }
    
        // Create a new payment record
        $pmodel = new PaymentModel();
        $pmodel->user_id          = $userid;
        $pmodel->date             = now()->format('Y-m-d'); // Automatically set today's date
        $pmodel->artist_id        = $request->artist_id;
        $pmodel->customers_name    = $request->customers_name;
        $pmodel->design           = $request->design;
        $pmodel->placement        = $request->placement;
        $pmodel->price            = $request->price;
        $pmodel->deposit          = $request->deposit ?? 0; // Default to 0 if null
        $pmodel->tips             = $request->tips ?? 0; // Default to 0 if null
        $pmodel->fees             = $request->fees ?? 0; // Default to 0 if null
        $pmodel->total_due        = $request->total_due ?? 0; // Default to 0 if null
        $pmodel->payment_method   = $request->payment_method;
        $pmodel->bill_image       = $path;
    
        // Save the payment model
        $pmodel->save();
    
        return redirect()->back()->with('message', 'Payment added successfully.');
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
        // Validate the incoming request
        $this->validate($request, [
            'artist_id' => 'required',
            'customers_name' => 'required',
            'design' => 'required',
            'price' => 'required'
        ], [
            'artist_id.required' => 'Please select an artist',
            'customers_name.required' => 'Please enter customer name',
            'design.required' => 'Please enter Design',
            'price.required' => 'Please enter price',
            'banner_url.required' => 'Please enter banner url'
        ]);
    
        // Retrieve the payment model using the decrypted ID
        $pmodel = PaymentModel::find(decrypt($id));
    
        // Check if the model was found
        if (!$pmodel) {
            return redirect()->back()->withErrors(['message' => 'Payment not found.']);
        }
    
        // Get the user_id from the PaymentModel instance
        $userid = $pmodel->user_id;
    
        // Handle file upload if a new image is provided
        if ($request->hasFile('bill_image')) {
            $file = $request->file('bill_image');
            $filename = $file->getClientOriginalName();
            $file->storeAs('public/DepositSlip/', $filename);
            $path = Storage::url('public/DepositSlip/' . $filename);
        } else {
            // Use old image path if provided
            $path = $request->old_image_path ?? ''; // Use null coalescing operator for cleaner code
        }
    
        // Update model fields
        $pmodel->date = date('Y-m-d');
        $pmodel->artist_id = $request->input('artist_id');
        $pmodel->customers_name = $request->input('customers_name');
        $pmodel->design = $request->input('design');
        $pmodel->placement = $request->input('placement');
        $pmodel->price = $request->input('price');
        $pmodel->deposit = $request->input('deposit');
        $pmodel->tips = $request->input('tips');
        $pmodel->fees = $request->input('fees');
        $pmodel->total_due = $request->input('total_due');
        $pmodel->payment_method = $request->input('payment_method');
        $pmodel->bill_image = $path;
    
        // Save the updated model
        $pmodel->save();
    
        return redirect()->back()->with('message', 'Payment updated successfully.');
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
