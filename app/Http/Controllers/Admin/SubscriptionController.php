<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AdminMail;
use App\Mail\SalesMail;
use App\Mail\WelcomeMail;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
class SubscriptionController extends Controller
{
    public function index()
    {
        if (!auth()->guard('artists')->check()) {
            // If the user is not authenticated, show the subscription plans
            return view('admin.subscriptions.index');
        }

        $userId = auth()->guard('artists')->user(); // Get the logged-in user ID
        $subscription = Subscription::where('user_id', $userId->id)->first();

        if ($subscription) {
            $sales = User::where('id', '=', $userId->created_by)
            ->first();
            
            // If a subscription exists, show the subscription details
            return view('admin.subscriptions.details', compact('subscription','sales'));
        }

        // If no subscription exists, show subscription plans
        return view('admin.subscriptions.index');
    }


    public function create(Request $request)
    {
        if (!auth()->guard('artists')->check()) {
            // Redirect back with an error message
            return redirect()->back()->with('error', 'You are not registered as an artist. Please log in as an artist to subscribe.');
        }

        $userId = auth()->guard('artists')->user()->id;

        $subscriptionPlan = $request->query('plan', '');

        // Pass the subscription plan to the view
        return view('admin.subscriptions.create', compact('subscriptionPlan', 'userId'));
    }
    public function store(Request $request)
    {
        if (!auth()->guard('artists')->check()) {
            // Redirect back with an error message
            return redirect()->back()->with('error', 'You are not registered as an artist. Please log in as an artist to subscribe.');
        }


        $userId = auth()->guard('artists')->user();
        $userEmail = $userId ->email;

        // Find the sales email where the 'created_by' is the same as the current user ID
        $salesEmail = User::where('id', '=', $userId->created_by)
        ->first()->email;

        $adminEmail = 'sweetdevelopers.sales@gmail.com'; // Admin email address

        // Validate the incoming data
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'subscription_plan' => 'required|string|max:255',
            'status' => 'required|string',
            'payment_option' => 'nullable|string|max:255',
            'zell_email' => 'nullable|email|max:255',
            'zell_phone' => 'nullable|string',
            'ach_bank_name' => 'nullable|string|max:255',
            'ach_type' => 'nullable|string|max:255',
            'ach_routing_number' => 'nullable|string|max:255',
            'ach_account_number' => 'nullable|string|max:255',
        ]);

        // Create the subscription
        Subscription::create($request->all());

        // Send the welcome email to the user
        Mail::to($userEmail)->send(new WelcomeMail($userEmail));

        // Send the sales email
        Mail::to($salesEmail)->send(new SalesMail($userEmail));

        // Send the admin email
        Mail::to($adminEmail)->send(new AdminMail($userEmail));

        // Redirect to the index page with a success message
        return redirect()->route('admin.subscriptions')->with('success', 'Subscription created successfully!');
    }
    public function edit($id)
{
    if (!auth()->guard('artists')->check()) {
        // Redirect back with an error message
        return redirect()->back()->with('error', 'You are not registered as an artist. Please log in as an artist to edit the subscription.');
    }

    $subscription = Subscription::findOrFail($id);
    $subscriptionPlan = $subscription->subscription_plan;
    $userId = auth()->guard('artists')->user()->id;

    // Pass the subscription to the view
    return view('admin.subscriptions.edit', compact('subscription', 'subscriptionPlan', 'userId'));
}
public function update(Request $request, $id)
{
    if (!auth()->guard('artists')->check()) {
        // Redirect back with an error message
        return redirect()->back()->with('error', 'You are not registered as an artist. Please log in as an artist to update the subscription.');
    }

    $subscription = Subscription::findOrFail($id);
    $userId = auth()->guard('artists')->user();
    $userEmail = $userId->email;

    // Find the sales email where the 'created_by' is the same as the current user ID
    $salesEmail = User::where('id', '=', $userId->created_by)->first()->email;

    $adminEmail = 'sweetdevelopers.sales@gmail.com'; // Admin email address

    // Validate the incoming data
    $request->validate([
        'user_id' => 'required|integer|exists:users,id',
        'subscription_plan' => 'required|string|max:255',
        'status' => 'required|string',
        'payment_option' => 'nullable|string|max:255',
        'zell_email' => 'nullable|email|max:255',
        'zell_phone' => 'nullable|string',
        'ach_bank_name' => 'nullable|string|max:255',
        'ach_type' => 'nullable|string|max:255',
        'ach_routing_number' => 'nullable|string|max:255',
        'ach_account_number' => 'nullable|string|max:255',
    ]);

    // Update the subscription
    $subscription->update($request->all());

    // Send the updated subscription email to the user
    Mail::to($userEmail)->send(new WelcomeMail($userEmail));

    // Send the sales email
    Mail::to($salesEmail)->send(new SalesMail($userEmail));

    // Send the admin email
    Mail::to($adminEmail)->send(new AdminMail($userEmail));

    // Redirect to the index page with a success message
    return redirect()->route('admin.subscriptions')->with('success', 'Subscription updated successfully!');
}


}
