<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AdminMail;
use App\Mail\SalesMail;
use App\Mail\WelcomeMail;
use App\Models\ExpenseModel;
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
        $userEmail = $userId ;

        // Find the sales email where the 'created_by' is the same as the current user ID
        $salesdata = User::where('id', '=', $userId->created_by)
        ->first();

        $adminEmail = 'tattoome1@yahoo.com'; // Admin email address

        // Validate the incoming data
        $validated =  $request->validate([
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
            'subscription_date' => 'nullable|date',
        ]);

        // Create the subscription
        $subscription = Subscription::create($validated);
        $subscriptionData = array_merge($validated, ['created_at' => $subscription->created_at]);
    //   $data['user_id'] => auth()->guard('artists')->id();
    //     $data['transaction_date'] => $subscription->subscription_date
    //     $data['payment_method'] => $subscription->payment_option
    //     $data['amount'] => auth()->guard('artists')->id();
    //     $data['expense_items'] => auth()->guard('artists')->id();
    //     $data['expense_items'] => auth()->guard('artists')->id();
    //     $data['expense_items'] => auth()->guard('artists')->id();
    //     $data['note'] => auth()->guard('artists')->id();
        
    //     $expenseCreate = Expense::c

        // Send the welcome email to the user
        // Mail::to($userEmail)->send(new WelcomeMail($userEmail));
        $mailsubject = $userEmail->name . ' - Subscription Joining for ' . $validated['subscription_plan'];
        if (!empty($salesdata->email)) {
            Mail::to($salesdata->email)->send(new SalesMail($userEmail, $subscriptionData, $salesdata, $mailsubject));
            
        }
        
        // Send the sales email

        // Send the admin email
        Mail::to($adminEmail)->send(new AdminMail($userEmail,$subscriptionData,$salesdata,$mailsubject ));

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
    // Ensure the user is logged in as an artist
    if (!auth()->guard('artists')->check()) {
        return redirect()->back()->with('error', 'You are not registered as an artist. Please log in as an artist to update the subscription.');
    }

    // Retrieve the authenticated user
    $userId = auth()->guard('artists')->user();
    $userEmail = $userId;

    // Retrieve the subscription
    $subscription = Subscription::findOrFail($id);

    // Retrieve sales data
    $salesdata = User::where('id', $userId->created_by)->first();
    if (!$salesdata) {
        return redirect()->back()->with('error', 'Sales representative data not found.');
    }

    $adminEmail = 'tattoome1@yahoo.com'; // Admin email address

    // Validate the incoming request
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
        'subscription_date' => 'nullable|date',
    ]);

    // Update the subscription
    $subscription->update($request->all());

    // Prepare subscription data for the emails
    $subscriptionData = $subscription->toArray();
    $mailsubject = $subscriptionData['status'] . ' Subscription by ' . $userId->name;

    // Send the sales email
    Mail::to($salesdata->email)->send(new SalesMail($userEmail, $subscriptionData, $salesdata,$mailsubject ));

    // Send the admin email
    Mail::to($adminEmail)->send(new AdminMail($userEmail, $subscriptionData, $salesdata,$mailsubject ));

    // Redirect to the subscriptions index page with a success message
    return redirect()->route('admin.subscriptions')->with('success', 'Subscription updated successfully!');
}

public function cronCreateExpance() {
    // Fetch subscriptions with status "Renew" and subscription_date not null
    $subscriptionList = Subscription::where("status", "=", "Renew")
        ->whereNotNull("subscription_date")
        ->get();

    // Initialize counters for success and failure
    $successCount = 0;
    $failCount = 0;

    foreach ($subscriptionList as $subscription) {
        try {
            // Check if subscription_date matches the 28-day cycle
            $subscriptionDate = \Carbon\Carbon::parse($subscription->subscription_date);
            $currentDate = \Carbon\Carbon::now();
           

            // Calculate the difference in days
            $daysDifference = $subscriptionDate->diffInDays($currentDate);
            // dd($daysDifference);


            // Proceed only if the difference is a multiple of 28 days
            if ($daysDifference % 30 === 0) {
                // Create a new ExpenseModel entry
                $expance = new ExpenseModel();

                // Set the fields for the ExpenseModel
                $expance->user_id = $subscription->user_id;
                $expance->amount = $subscription->subscription_plan;
                $expance->note = "Expense for subscription";
                $expance->payment_method = $subscription->payment_option;
                $expance->transaction_date = now();
                $expance->expense_items = "advertising";

                // Save the ExpenseModel
                $expance->save();
                $successCount++;
            }
        } catch (\Exception $e) {
            // Increment fail count if an exception occurs
            $failCount++;
        }
    }

    // Return a response based on the results
    if ($successCount > 0 && $failCount === 0) {
        return "All expenses created successfully!";
    } elseif ($successCount > 0 && $failCount > 0) {
        return "Expenses created successfully for $successCount subscriptions, but $failCount failed.";
    } elseif ($successCount === 0 && $failCount > 0) {
        return "Expense creation failed for all subscriptions.";
    } else {
        return "No subscriptions found for processing.";
    }
}

}
