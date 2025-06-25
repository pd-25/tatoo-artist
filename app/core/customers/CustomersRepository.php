<?php
namespace App\core\customers;

use App\Models\User;
use App\Models\Customers;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DB;
use App\Helper\UserHelper;

class CustomersRepository implements CustomersInterface
{

	public function storeCustomerData(array $data)
    {
        if (isset($data['profile_image']) && $data['profile_image'] != null) {
            $content_db = time() . rand(0000, 9999) . "." . $data['profile_image']->getClientOriginalExtension();
            $data['profile_image']->storeAs("public/ProfileImage", $content_db);
            $data['profile_image'] = $content_db;
        }

        $data['password'] = Hash::make($data['password']);
        $data['type'] = "customer";
        $data['name'] = $data['firstname'].' '.$data['lastname'];
        $data['state'] = $data['customer_state'];
        $data['phone'] = $data['mobile_number'];
        $data['dob'] = UserHelper::change_dateformat($data['dob']);

        // echo '<pre>'; print_r($data); echo '</pre>';
        
        // exit;
        
        return User::create($data);

        
        // return Customers::create($customerInfoStore); 
        //DB::commit();

        // DB::beginTransaction();
        // try{
	    //     $customer_id = DB::table('users')->insertGetId([
	    //     	'name' => $data['firstname'].' '.$data['lastname'],
	    //     	'username' => $data['username'],
	    //     	'phone' => $data['mobile_number'],
	    //     	'state' => $data['customer_state'],
	    //     	'zipcode' => $data['zipcode'],
	    //     	'profile_image' => $data['profile_image'],
	    //     	'email' =>$data['email'],
	    //     	'password' => $data['password'],
	    //     	'type' => $data['type'],
	        	
	    //     ]);

	    //     DB::table('customers')->insert([
	    //     	'customer_id' => $customer_id,
	    //     	'dob' => UserHelper::change_dateformat($data['dob']),
	    //     	'sex' => $data['sex'],
	    //     	'lead_source' => $data['lead_source'],
	    //     ]);

	    //     DB::commit();



        // }catch(\Exception $e){
        //     DB::rollback();
        // }

        // return;
        
    }

}