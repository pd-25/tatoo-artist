<?php
namespace App\Http\Controllers\Customers;

use App\core\customers\CustomersInterface;
use App\Http\Controllers\Controller;
use App\Mail\CustomerResetPasswordMail;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use DB;
use Auth;
use App\Helper\UserHelper;
use Illuminate\Support\Facades\Mail;

class CustomersController extends Controller
{
    private $customersInterface;

    public function __construct(CustomersInterface $customersInterface)
    {
        $this->customersInterface = $customersInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $leads = DB::table('lead_source')->get();
        return view('customers/auth/register', ['leads'=>$leads]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([

            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'username' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'zipcode' => 'required',
            'mobile_number' => 'required',
            'sex' => 'required',
            'dob' => 'required',
            'profile_image' => 'required|image|mimes:jpeg,png,jpg|max:100',
            'password' => 'required',
            'conf_password' => 'required',
        ],
        [
            'firstname.required' => 'First Name is required.',
            'lastname.required' => 'Last Name is required.',
            'username.required' => 'Username is required.',
            'email.required' => 'Email is required.',
            'zipcode.required' => 'Zipcode is required.',
            'mobile_number.required' => 'Mobile number is required.',
            'sex.required' => 'Sex field is required.',
            'dob.required' => 'Enter your date of birth',
            'profile_image.required' => 'The image field must be an image file of type: PNG, JPG of max size 100KB',
            'password.required' => 'Password field is required.',
            'conf_password.required' => 'Please re-enter your password',
            
        
        ]);

        $data = $request->only('firstname', 'lastname', 'username', 'email', 'customer_state', 'zipcode', 'mobile_number', 'password', 'profile_image', 'sex',  'dob', 'lead_source');
        //$customerInfo = $request->only('sex',  'dob', 'lead_source');
        // echo '<pre>'; print_r($data); echo '</pre>';
        // echo '<pre>'; print_r($customerInfo); echo '</pre>';
        // exit;
        $store = $this->customersInterface->storeCustomerData($data);
        if ($store) {

            return redirect()->route('customerRegister.success')->with('msg', 'Thank You For Registering With Tattoome.');
        } else {
            return back()->with('msg', 'Some error occur.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function registerSuccess(){
        return view('customers/auth/register-success');
    }

    public function customerProfile(){
        $profile = User::where('email', session()->get('cust_email'))->first();
        //$dob = UserHelper::display_dateformat($profile->dob);
        return view('customers/profile', ['profile'=>$profile]);
        if(!empty($profile)){
            return view('customers/profile');
        }else{
            return redirect()->route('customerLogin');
        }
        
    }

    public function forgetPassword(){
        return view('customers.auth.forget-password');
    }

    public function checkCustomerEmail(Request $request){
        $request->validate([
            'email' => 'required|email',
        ],
        [
            'email.required' => 'Please enter valid email.',
        ]);

        $email = $request->only('email');
        $checkEmailRes = User::where('email', $email)->first();
        $mailsubject = 'Reset Password';
        if(!empty($checkEmailRes)){
            $customer_name = $checkEmailRes->name;
            session()->put('requested_email', $email);
            Mail::to($email)->send(new CustomerResetPasswordMail($customer_name, $mailsubject ));
            return redirect()->route('customer.forgetPsswordMailSuccess')->with(['msg'=>'Email has been sent. Please check and reset your password', 'cname'=>$checkEmailRes->name]);
        }else{
            return back()->with('msg', 'Please enter valid email.');
        }
    }

    public function forgetPasswordMailSuccess(){
        return view('customers/auth/forget-password-email-sent');
    }

    public function resetPassword(){
        $requested_email = session()->get('requested_email');
        if(!empty($requested_email)){
            return view('customers/auth/reset-password');
        }else{
            return redirect()->route('customer.forgetPassword');
        }
        
    }

    public function storeResetPassword(Request $request){
        $request->validate([
            'password' => 'required|min:6',
        ],
        [
            'password.required' => 'Please enter a new password.',
        ]);
        $requested_email = session()->get('requested_email');

        if(!empty($requested_email)){
            $newpass = Hash::make($request->password);
            User::where('email', $requested_email)->update([
                'password'=>$newpass
            ]);
            return redirect()->route('customer.resetPasswordSuccess')->with(['msg'=>'Password reset successfully!']);
        }else{
            return redirect()->route('customer.forgetPassword');
        }

    }

    public function resetPasswordSuccess(){
        return view('customers.auth.reset-password-success');
    }
    
}
