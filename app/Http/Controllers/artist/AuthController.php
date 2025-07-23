<?php

namespace App\Http\Controllers\artist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function userlogin(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        try {

            $guard_type = $request->guard_type;
            //dd(Auth::guard());
            //exit;
            if($guard_type == "admins"){
                $type = "admin";
            }else if($guard_type == "sales"){
                $type = "sales";
            }else if($guard_type == "artists"){
                $type = "artist";
            }else if($guard_type == "customers"){
                $type = "customer";
            }
            // echo $guard_type;
            // exit;
    
            if(Auth::guard($guard_type)->attempt(["email" => $request->email, "password" => $request->password, "type" => $type])){

                if ($guard_type === 'admins') {
                    return redirect()->route('admin.dashboard'); // Redirect admin to dashboard
                }else if ($guard_type === 'customers') {
                    session()->put('cust_email', $request->email);
                    return redirect()->route('customerProfile'); // Redirect customer profile
                }  
                else if ($guard_type === 'sales') {
                    return redirect()->route('admin.dashboard'); // Redirect admin to dashboard
                } else {
                    return redirect()->route('artists.dashboard'); // Redirect regular user to dashboard
                }

            }else{
                if ($guard_type === 'admins') {
                    return redirect()->route('adminLogin')->with("msg", "Invalid credentials")->withInput();
                }else if($guard_type === 'customers'){
                    return redirect()->route('customerLogin')->with("msg", "Invalid credentials")->withInput();
                }
                else if ($guard_type === 'sales') {
                    return redirect()->route('salesLogin')->with("msg", "Invalid credentials")->withInput();
                } else {
                    return redirect()->route('artistLogin')->with("msg", "Invalid credentials")->withInput();
                }
            }

        } catch (\Throwable $th) {
            // throw $th;
            return back()->with("msg", throw $th);
        }
    }

    public function logoutArtist(Request $request)
    {
        Auth::guard('artists')->logout(); // Logout regular user
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('artistLogin');
    }

    public function logoutSales(Request $request)
    {
        Auth::guard('sales')->logout(); // Logout admin user
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('salesLogin');
    }

    public function logoutAdmin(Request $request)
    {
        Auth::guard('admins')->logout(); // Logout admin user
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('adminLogin');
    }

    public function logoutCustomer(Request $request)
    {
        Auth::guard('customers')->logout(); // Logout admin user
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('customerLogin');
    }
}
