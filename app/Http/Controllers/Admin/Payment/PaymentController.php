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
            $payments = PaymentModel::with('placementData','artist')->where('user_id',Auth::guard('artists')->user()->id)->get();
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
            $payments = PaymentModel::with('user','artist')->where('user_id',Auth::guard('artists')->user()->id)->get();
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
            $startDate = $requestStartDate[2].'-'.$requestStartDate[1].'-'.$requestStartDate[0];
        }else{
            $startDate = null;
        }

        if ($request->has('end_date')) {
            $requestEndDate = explode('/',$request->end_date);
            $endDate = $requestEndDate[2].'-'.$requestEndDate[1].'-'.$requestEndDate[0];
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

    public function AddpaymentForm(Request $request){

        if(Auth::guard('artists')->check()){
            $artists = User::where('type', '=', 'artist')->get();
        }
        elseif(Auth::guard('admins')->check()){
            $artists = User::where('type', '=', 'artist')->get();
        }else{
            $salespersonId = Auth::guard('sales')->id(); 
            $artists = User::where('created_by', $salespersonId)->where('type', '=', 'artist')->get();
        }

        $placements = Placement::all();
        return view('admin.payment.create',compact('placements','artists'));
    }

    public function AddpaymentPost(Request $request){
        $this->validate($request, [
            'artist_id'          => 'required',
            'customers_name'       => 'required',
            'design'               => 'required',
            'price'                => 'required',
            'bill_image'           => 'required|image|mimes:jpeg,png,jpg,gif'
        ],[
            'artist_id.required' => 'Please select an artist',
            'customers_name.required' => 'Please enter customer name',
            'design.required' => 'Please enter Design',
            'price.required' => 'Please enter price',
            'banner_url.required' => 'Please enter banner url',
            'bill_image.required' => 'Please upload Bill Document',
        ]);

        if(Auth::guard('artists')->check()){
            $userid = Auth::guard('artists')->user()->id;
        }
        elseif(Auth::guard('admins')->check()){
            $userid = Auth::guard('admins')->user()->id;
        }else{
            $userid = Auth::guard('sales')->id();
        }

        if ($request->hasFile('bill_image')) {
            // $path = Storage::disk('local')->put($request->file('photo')->getClientOriginalName(),$request->file('photo')->get());
            //$path = $request->file('bill_image')->store('/DepositSlip/1/smalls');
            $file = $request->file('bill_image');
            $filename = $file->getClientOriginalName();
            $file->storeAs('public/DepositSlip/',$filename);
            $path =  Storage::url('public/DepositSlip/'.$filename);

        }else{
            $path = '';
        }

        $pmodel = new PaymentModel();
            $pmodel->user_id                                       = $userid;
            $pmodel->date                                          = date('Y-m-d');
            $pmodel->artist_id                                   = $request['artist_id'];
            $pmodel->customers_name                                = $request['customers_name'];
            $pmodel->design                                        = $request['design'];
            $pmodel->placement                                     = $request['placement'];
            $pmodel->price                                         = $request['price'];
            $pmodel->deposit                                       = $request['deposit'];
            $pmodel->tips                                          = $request['tips'];
            $pmodel->fees                                          = $request['fees'];
            $pmodel->total_due                                     = $request['total_due'];
            $pmodel->payment_method                                = $request['payment_method'];
            $pmodel->bill_image                                    = $path;
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

    public function editpaymentPost(Request $request,$id){
        $this->validate($request, [
            'artist_id'          => 'required',
            'customers_name'       => 'required',
            'design'               => 'required',
            'price'                => 'required'
        ],[
            'artist_id.required' => 'Please select an artist',
            'customers_name.required' => 'Please enter customer name',
            'design.required' => 'Please enter Design',
            'price.required' => 'Please enter price',
            'banner_url.required' => 'Please enter banner url'
        ]);

        if(Auth::guard('artists')->check()){
            $userid = Auth::guard('artists')->user()->id;
        }else{
            $userid = Auth::user()->id;
        }

        if ($request->hasFile('bill_image')) {
            $file = $request->file('bill_image');
            $filename = $file->getClientOriginalName();
            $file->storeAs('public/DepositSlip/',$filename);
            $path =  Storage::url('public/DepositSlip/'.$filename);
        }else{
            if($request->old_image_path !=''){
                $path = $request->old_image_path;
            }else{
                $path = '';
            }
        }

        $pmodel = PaymentModel::find(decrypt($id));
            $pmodel->user_id                                       = $userid;
            $pmodel->date                                          = date('Y-m-d');
            $pmodel->artist_id                                   = $request->input('artist_id');
            $pmodel->customers_name                                = $request->input('customers_name');
            $pmodel->design                                        = $request->input('design');
            $pmodel->placement                                     = $request->input('placement');
            $pmodel->price                                         = $request->input('price');
            $pmodel->deposit                                       = $request->input('deposit');
            $pmodel->tips                                          = $request->input('tips');
            $pmodel->fees                                          = $request->input('fees');
            $pmodel->total_due                                     = $request->input('total_due');
            $pmodel->payment_method                                = $request->input('payment_method');
            $pmodel->bill_image                                    = $path;
        $pmodel->save();
        return redirect()->back()->with('message', 'Payment updated successfully.');


    }

    public function deletepaymentForm(Request $request,$id){
        $pmodel = PaymentModel::find(decrypt($id));
        $pmodel->delete();
        return back()->with('msg', 'Record deleted successfully.');
    }


}
