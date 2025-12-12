<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\TierOneExport;
use App\Exports\TierTwoExport;
use App\Exports\TierThreeExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\SubscriptionMail;
use App\Models\ExpenseModel;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{
    public function index()
    {
        $path = storage_path('app/subscriptionplans.json');

        // Check if file exists, if not create it
        if (!file_exists($path)) {
            file_put_contents($path, json_encode([]));
        }

        // Read plans
        $plans = json_decode(file_get_contents($path), true);

        if (!auth()->guard('artists')->check()) {
            // If the user is not authenticated, show the subscription plans
            return view('admin.subscriptions.index', compact('plans'));
        }

        $userId = auth()->guard('artists')->user(); // Get the logged-in user ID
        $subscription = Subscription::where('user_id', $userId->id)->first();

        if ($subscription) {
            $sales = User::where('id', '=', $userId->created_by)
                ->first();

            // If a subscription exists, show the subscription details
            return view('admin.subscriptions.details', compact('subscription', 'sales', 'plans'));
        }

        // If no subscription exists, show subscription plans


        return view('admin.subscriptions.index', compact('plans'));
    }

    public function report(Request $request)
    {
        $query = Subscription::query();

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_option')) {
            $query->where('payment_option', $request->payment_option);
        }

        if ($request->filled('plan_name')) {
            $query->where('plan_name', 'LIKE', '%' . $request->plan_name . '%');
        }

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('created_at', [$request->date_from, $request->date_to]);
        }

        $subscriptions = $query->orderBy('id', 'desc')->get();

        return view('admin.subscriptions.report', compact('subscriptions'));
    }

    public function exportInExcelSubsOne(Request $request)
    {
        $filters = [
            'status' => $request->status,
            'plan_name' => $request->plan_name,
        ];

        return Excel::download(
            new TierOneExport($filters),
            'tier_1_subscriptions_' . date('Y-m-d_His') . '.xlsx'
        );
    }

    public function exportInExcelSubsTwo(Request $request)
    {
        $filters = [
            'status' => $request->status,
            'plan_name' => $request->plan_name,
        ];

        return Excel::download(
            new TierTwoExport($filters),
            'tier_2_subscriptions_' . date('Y-m-d_His') . '.xlsx'
        );
    }

    public function exportInExcelSubsThree(Request $request)
    {
        $filters = [
            'status' => $request->status,
            'plan_name' => $request->plan_name,
        ];

        return Excel::download(
            new TierThreeExport($filters),
            'tier_3_subscriptions_' . date('Y-m-d_His') . '.xlsx'
        );
    }



    public function create(Request $request)
    {
        if (!auth()->guard('artists')->check()) {
            // Redirect back with an error message
            return redirect()->back()->with('error', 'You are not registered as an artist. Please log in as an artist to subscribe.');
        }

        $userId = auth()->guard('artists')->user()->id;

        $subscriptionPlan = $request->query('plan', '');
        $plans = json_decode(file_get_contents(storage_path('app/subscriptionplans.json')), true);

        // Pass the subscription plan to the view
        return view('admin.subscriptions.create', compact('subscriptionPlan', 'userId', 'plans'));
    }
    // public function store(Request $request)
    // {
    //     if (!auth()->guard('artists')->check()) {
    //         // Redirect back with an error message
    //         return redirect()->back()->with('error', 'You are not registered as an artist. Please log in as an artist to subscribe.');
    //     }


    //     $userId = auth()->guard('artists')->user();
    //     $userEmail = $userId;

    //     // Find the sales email where the 'created_by' is the same as the current user ID
    //     $salesdata = User::where('id', '=', $userId->created_by)
    //         ->first();

    //     $adminEmail = 'tattoome1@yahoo.com'; // Admin email address

    //     // Validate the incoming data
    //     $validated =  $request->validate([
    //         'user_id' => 'required|integer|exists:users,id',
    //         'subscription_plan' => 'string|max:255',
    //         'plan_name' => 'string|max:255',
    //         'status' => 'required|string',
    //         'payment_option' => 'nullable|string|max:255',
    //         'zell_email' => 'nullable|email|max:255',
    //         'zell_phone' => 'nullable|string',
    //         'ach_bank_name' => 'nullable|string|max:255',
    //         'ach_type' => 'nullable|string|max:255',
    //         'ach_routing_number' => 'nullable|string|max:255',
    //         'ach_account_number' => 'nullable|string|max:255',
    //         'subscription_date' => 'nullable|string', // temporarily string
    //     ]);

    //     // Convert mm-dd-yyyy to Y-m-d
    //     if (!empty($validated['subscription_date'])) {
    //         $parts = explode('-', $validated['subscription_date']); // mm-dd-yyyy
    //         if (count($parts) === 3) {
    //             $validated['subscription_date'] = $parts[2] . '-' . $parts[0] . '-' . $parts[1]; // yyyy-mm-dd
    //         }
    //     }


    //     // Split price|name
    //     list($price, $name) = explode('|', $validated['subscription_plan']);

    //     // Reassign to proper fields
    //     $validated['subscription_plan'] = $price;
    //     $validated['plan_name'] = $name;

    //     // Create the subscription
    //     $subscription = Subscription::create($validated);
    //     $subscriptionData = array_merge($validated, ['created_at' => $subscription->created_at]);


    //     // $mailsubject = 'New Artist'. $userEmail->name . ' - Subscription Joining for ' . $validated['subscription_plan'];
    //     $mailsubject = 'New Artist';
    //     if (!empty($salesdata->email)) {
    //         Mail::to($salesdata->email)->send(new SubscriptionMail($userEmail, $subscriptionData, $salesdata, $mailsubject));
    //     }

    //     // Send the sales email

    //     // Send the admin email
    //     Mail::to($adminEmail)->send(new SubscriptionMail($userEmail, $subscriptionData, $salesdata, $mailsubject));

    //     // Redirect to the index page with a success message
    //     return redirect()->route('admin.subscriptions')->with('success', 'Subscription created successfully!');
    // }

    public function store(Request $request)
    {
        // Check if artist is logged in
        if (!auth()->guard('artists')->check()) {
            return redirect()->back()->with('error', 'You are not registered as an artist. Please log in as an artist to subscribe.');
        }

        $user = auth()->guard('artists')->user();
        $salesdata = User::where('id', $user->created_by)->first();
        $adminEmail = 'tattoome1@yahoo.com';

        // Validate data
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'subscription_plan' => 'string|max:255',
            'plan_name' => 'string|max:255',
            'status' => 'required|string',
            'payment_option' => 'nullable|string|max:255',
            'zell_email' => 'nullable|email|max:255',
            'zell_phone' => 'nullable|string',
            'ach_bank_name' => 'nullable|string|max:255',
            'ach_type' => 'nullable|string|max:255',
            'ach_routing_number' => 'nullable|string|max:255',
            'ach_account_number' => 'nullable|string|max:255',
            'subscription_date' => 'nullable|string', // coming as mm-dd-yyyy
        ]);

        // Convert mm-dd-yyyy → yyyy-mm-dd
        if (!empty($validated['subscription_date'])) {
            $parts = explode('-', $validated['subscription_date']);
            if (count($parts) === 3) {
                $validated['subscription_date'] = $parts[2] . '-' . $parts[0] . '-' . $parts[1];
            }
        }

        // Extract price | name (format: "540|Starter Plan")
        list($price, $name) = explode('|', $validated['subscription_plan']);

        $validated['subscription_plan'] = $price;
        $validated['plan_name'] = $name;

        // Load subscription plans JSON file
        $path = storage_path('app/subscriptionplans.json');
        $plans = json_decode(file_get_contents($path), true);

        // Find matching plan from JSON
        $matchedPlan = collect($plans)->first(function ($plan) use ($price, $name) {
            return $plan['price'] == $price && $plan['name'] == $name;
        });

        // Store subscription_id from JSON
        $validated['subscription_id'] = $matchedPlan['id'] ?? null;

        // Create subscription
        $subscription = Subscription::create($validated);
        $subscriptionData = array_merge($validated, ['created_at' => $subscription->created_at]);

        // Email Subject
        $mailsubject = 'New Artist';

        // Send email to sales
        if (!empty($salesdata->email)) {
            Mail::to($salesdata->email)->send(new SubscriptionMail($user, $subscriptionData, $salesdata, $mailsubject));
        }

        // Send email to admin
        Mail::to($adminEmail)->send(new SubscriptionMail($user, $subscriptionData, $salesdata, $mailsubject));

        return redirect()->route('admin.subscriptions')->with('success', 'Subscription created successfully!');
    }


    public function edit($id)
    {
        $plans = json_decode(file_get_contents(storage_path('app/subscriptionplans.json')), true);
        $artist = auth()->guard('artists')->user();
        if (!$artist) {
            return redirect()->back()->with('error', 'You are not registered as an artist.');
        }

        $subscription = Subscription::findOrFail($id);
        $userId = $artist->id;

        return view('admin.subscriptions.edit', compact('subscription', 'userId', 'plans'));
    }

    public function update(Request $request, $id)
    {
        $artist = auth()->guard('artists')->user();
        if (!$artist) {
            return redirect()->back()->with('error', 'You are not registered as an artist.');
        }

        $subscription = Subscription::findOrFail($id);

        // Base validation
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'subscription_plan' => 'required|string|max:255',
            'status' => 'required|string',
            'payment_option' => 'nullable|string|max:255',
            'subscription_date' => 'nullable|string',
            'full_name' => 'required|string|max:255',
            'acc_hold_type' => 'required|string|max:255',
            'ref_info' => 'required|string|max:255',
        ]);

        // Conditional validation
        if ($request->payment_option == 'zelle') {
            $request->validate([
                'zell_email' => 'required|email|max:255',
                'zell_phone' => 'required|string',
            ]);
        } elseif ($request->payment_option == 'ach') {
            $request->validate([
                'ach_bank_name' => 'required|string|max:255',
                'ach_type' => 'required|string|max:255',
                'ach_routing_number' => 'required|digits:9',
                'ach_account_number' => 'required|digits_between:8,18',
            ]);
        }

        // Parse subscription plan
        // list($price, $name) = explode('|', $request->subscription_plan);
        list($price, $name, $subscriptionIdFromFile) = explode('|', $request->subscription_plan);


        // Handle subscription date parsing
        $subscriptionDate = $request->subscription_date;
        if (!empty($subscriptionDate)) {
            try {
                // Check if it contains time (space character) - means it's from database
                if (strpos($subscriptionDate, ' ') !== false) {
                    // Already in Y-m-d H:i:s format, just extract date part
                    $subscriptionDate = Carbon::parse($subscriptionDate)->format('Y-m-d');
                } elseif (preg_match('/^\d{2}-\d{2}-\d{4}$/', $subscriptionDate)) {
                    // Format: mm-dd-yyyy (from datepicker)
                    $subscriptionDate = Carbon::createFromFormat('m-d-Y', $subscriptionDate)->format('Y-m-d');
                } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $subscriptionDate)) {
                    // Already in Y-m-d format
                    $subscriptionDate = Carbon::parse($subscriptionDate)->format('Y-m-d');
                } else {
                    // Try to parse automatically
                    $subscriptionDate = Carbon::parse($subscriptionDate)->format('Y-m-d');
                }
            } catch (\Exception $e) {
                // If parsing fails, keep the original subscription date
                $subscriptionDate = $subscription->subscription_date;
            }
        }

        // Update subscription
        $subscription->update([
            'user_id' => $request->user_id,
            'subscription_id' => $subscriptionIdFromFile,
            'subscription_plan' => $price,
            'plan_name' => $name,
            'status' => $request->status,
            'payment_option' => $request->payment_option,
            'zell_email' => $request->zell_email,
            'zell_phone' => $request->zell_phone,
            'ach_bank_name' => $request->ach_bank_name,
            'ach_type' => $request->ach_type,
            'ach_routing_number' => $request->ach_routing_number,
            'ach_account_number' => $request->ach_account_number,
            'subscription_date' => $subscriptionDate,
            'full_name' => $request->full_name,
            'acc_hold_type' => $request->acc_hold_type,
            'ref_info' => $request->ref_info,
        ]);

        // Prepare data for email
        $userdata = $artist; // Pass full Artist/User model
        $salesdata = User::find($artist->created_by); // Can be null
        $adminEmail = 'tattoome1@yahoo.com';
        $subscriptionData = $subscription->fresh()->toArray(); // Get fresh data after update
        $mailsubject = 'Artist ' . $subscriptionData['status'];

        // Send email to sales representative if exists
        if ($salesdata && $salesdata->email) {
            try {
                Mail::to($salesdata->email)->send(
                    new SubscriptionMail($userdata, $subscriptionData, $salesdata, $mailsubject)
                );
            } catch (\Exception $e) {
                // Log error but don't stop the process
                Log::error('Failed to send email to sales rep: ' . $e->getMessage());
            }
        }

        // Send email to admin
        try {
            Mail::to($adminEmail)->send(
                new SubscriptionMail($userdata, $subscriptionData, $salesdata, $mailsubject)
            );
        } catch (\Exception $e) {
            // Log error but don't stop the process
            Log::error('Failed to send email to admin: ' . $e->getMessage());
        }

        return redirect()->route('admin.subscriptions')->with('success', 'Subscription updated successfully!');
    }

    public function cronCreateExpance()
    {
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
                    $expance->created_at  = now();
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
            // return "All expenses created successfully!";
            return response()->json([
                'status' => 'success',
                'message' => 'All expenses created successfully!',
                'success_count' => $successCount,
                'fail_count' => $failCount
            ]);
        } elseif ($successCount > 0 && $failCount > 0) {
            // return "Expenses created successfully for $successCount subscriptions, but $failCount failed.";
            return response()->json([
                'status' => 'partial_success',
                'message' => "Expenses created successfully for $successCount subscriptions, but $failCount failed.",
                'success_count' => $successCount,
                'fail_count' => $failCount
            ]);
        } elseif ($successCount === 0 && $failCount > 0) {
            // return "Expense creation failed for all subscriptions.";
            return response()->json([
                'status' => 'failure',
                'message' => 'Expense creation failed for all subscriptions.',
                'success_count' => $successCount,
                'fail_count' => $failCount
            ]);
        } else {
            // return "No subscriptions found for processing.";
            return response()->json([
                'status' => 'empty',
                'message' => 'No subscriptions found for processing.',
                'success_count' => $successCount,
                'fail_count' => $failCount
            ]);
        }
    }
}
