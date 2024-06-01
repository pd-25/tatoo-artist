<?php

namespace App\Http\Controllers\Admin\Dashboard;

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
class DashboardController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index() {
        //Total user count
        $totalUsers = User::count();

        // Count the total number of artists
        $totalArtists = User::where('type', 'artist')->count();

        //Total artwork count
        $totalArtworks = Artwork::count();

        return view('admin.dashboard.dashboard',compact('totalUsers','totalArtists','totalArtworks'));
    }

    public function impersonate($salesExeID){
        // Save the current admin's ID in the session for later revert
        session(['admin_id' => Auth::guard('admins')->id()]);

        if (Auth::guard('admins')->check()) {
            Auth::guard('admins')->logout();
        }

        // Perform impersonation
        Auth::guard('sales')->loginUsingId($salesExeID);

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
            // Re-login as the admin
            Auth::guard('admins')->loginUsingId(session('admin_id'));
            session()->forget('admin_id'); // Remove the admin_id from session
        }

        // Redirect back to the admin panel
        return redirect()->route('sales.index');
    }

    public function getQuote(){
        if(Auth::guard('artists')->check()){
            $data['quotes'] = Quote::where('artist_id',auth()->guard('artists')->id())->with('user', 'artist')->get();
        }
        elseif(Auth::guard('admins')->check()){
            $data['quotes'] = Quote::with('user', 'artist')->get();
        }else{
            $salespersonId = Auth::guard('sales')->id(); 
            $artists = User::where('created_by', $salespersonId)->get();

            $data['quotes'] = Quote::with('user', 'artist')->whereIn('artist_id', $artists->pluck('id'))->get(); 
        }
        
        //dd($data['quotes']);

        return view('admin.quote', $data);
    }

    public function getAppointment(){
        if(Auth::guard('artists')->check()){
            $data['appointments'] = Appointment::where('artist_id',auth()->guard('artists')->id())->with('user', 'artist')->get();
        } elseif(Auth::guard('admins')->check()){
            $data['appointments'] = Appointment::with('user', 'artist')->get();
        }else{

            $salespersonId = Auth::guard('sales')->id(); 
            $artists = User::where('created_by', $salespersonId)->get();

            $data['appointments'] = Appointment::with('user', 'artist')->whereIn('artist_id', $artists->pluck('id'))->get(); 
        }
        
        //dd($data['quotes']);

        return view('admin.appointment', $data);
    }


    function SendLink(Request $request){
        //$data['artist_id'] = request()->segment(2);
        //return view('admin.sendlink.index', $data);

        //$toemail = Auth::user()->email;

        // GET User Details
        $user = User::where('id', $request->userid)->first();
        $toemail =$user->email;
       try {
            Mail::send('admin.email.sendlink', ["useremail"=>$user->email,"user_id"=>$user->id,"artist_id"=>$request->artistid,"dbid"=>$request->dbid], function($message) use ($toemail){
                $message->to($toemail);
               //$message->to('biswajitmaityniit@gmail.com');
                //$message->bcc('');
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

    public function formlinkurl(Request $request){
        $data['user_id'] = request()->segment(2);
        $data['artist_id'] = request()->segment(3);
        $data['dbid'] = request()->segment(4);

        //check if this form is belongs to this user and the form is already submitted
        $quote = Quote::where('user_id', request()->segment(2))
              ->where('artist_id', request()->segment(3))
              ->where('id', request()->segment(4))
              ->first();
        
        if($quote):
           if(!is_null($quote->pdf_path)):
               $error_msg1 = "We have already received your submitted data.";
               $error_msg2 = "We'll be in touch shortly!";
               return view('admin.sendlink.error',compact('error_msg1','error_msg2'));
           else:
               return view('admin.sendlink.index',$data);
           endif;    
        else:
           $error_msg1 = "Something went wrong.";
           $error_msg2 = "Please get in touch us.";
           return view('admin.sendlink.error',compact('error_msg1','error_msg2'));
        endif;         
    }

    public function userformsubmit(Request $request){
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

        if($request->file('signature')){
            $file       = $request->file('signature');
            $name       = $file->getClientOriginalName();
            $signature_path = $file->store('tattoform','public',$name);
        }else{
            $signature_path = '';
        }

        if($request->file('driving_licence_front')){
            $fileds       = $request->file('driving_licence_front');
            $nameds       = $fileds->getClientOriginalName();
            $driving_licence_front_path = $fileds->store('tattoform','public',$nameds);
        }else{
            $driving_licence_front_path = '';
        }

        if($request->file('driving_licence_back')){
            $filedsb       = $request->file('driving_licence_back');
            $namedsb       = $filedsb->getClientOriginalName();
            $driving_licence_back_path = $filedsb->store('tattoform','public',$namedsb);
        }else{
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
            $tatto->todaysdate                                    = $request['todaysdate'];
            $tatto->birthdate                                     = $request['birthdate'];
            $tatto->phone                                         = $request['phone'];
            $tatto->address                                       = $request['address'];
            $tatto->stateid                                       = $request['stateid'];
            $tatto->signature                                     = $signature_path;
            $tatto->driving_licence_front                         = $driving_licence_front_path;
            $tatto->driving_licence_back                          = $driving_licence_back_path;
		$tatto->save();

        $data['artistdata'] = DB::table('users')
                                ->where('id', $request['artist_id'])
                                ->get();
        $data['tattodata'] = Tattoform::where('id', $tatto->id)->first();

        // GET User Details
        $user = User::where('id', $request['user_id'])->first();

        $pdf = PDF::loadView('admin.email.tatto-submited-form', $data);

        //return $pdf->stream('tattoform.pdf'); die;
        $content = $pdf->download()->getOriginalContent();
        $pdfname = time().'.pdf';
        Storage::put('public/tattopdf/'.$pdfname,$content);
        //$path =  Storage::url('public/tattopdf/'.$pdfname);
        $path = asset('storage/tattopdf/'.$pdfname);

        $toemail =$user->email;
        Mail::send('admin.email.view-tatto', ['fullpath'=>$path], function($message) use ($toemail){
            $message->to($toemail);
            //$message->to('biswajitmaityniit@gmail.com');
            //$message->bcc('test@salesanta.com');
            $message->subject('User Tattoo Submitted Data.');
        });

        Quote::where('id', $request->dbid)
        ->update([
            'link_send_status' => '2',
            'pdf_path'=>$path
         ]);
         return redirect()->route('admin.success')->with('message', 'Record added successfully!');
        //return redirect()->back()->with('message', 'Form data submited successfully.');
    }

    public function success(){
        return view('admin.sendlink.success');
    }

    public function deleteQuote($id) {
        $find =  Quote::where('id', decrypt($id))->first();
        if($find) {
            $find->delete();
            return back()->with('msg', 'Quote deleted successfully');
        }
        return back()->with('msg', 'No Quote found');

    }

    public function deleteAppointment($id) {
        $find =  Appointment::where('id', decrypt($id))->first();
        if($find) {
            $find->delete();
            return back()->with('msg', 'Appointment was deleted successfully');
        }
        return back()->with('msg', 'No Quote found');

    }



}
