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

       
        
    }

}