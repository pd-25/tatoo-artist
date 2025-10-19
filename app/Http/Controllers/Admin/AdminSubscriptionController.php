<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class AdminSubscriptionController extends Controller
{
    private $file = 'subscriptionplans.json';

    // Ensure admin auth
    public function __construct()
    {
        $this->middleware('auth:admins');
    }

    /**
     * Display a listing of the plans.
     */
    public function index()
    {
        $plans = $this->getPlans();
    }

    /**
     * Show the form for creating a new plan.
     */
    public function create()
    {
        return view('admin.subscriptions.admin-subscription-create-edit');
    }

    /**
     * Store a newly created plan in JSON.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
        ]);

        $plans = $this->getPlans();

        $newPlan = [
            'id' => $this->nextId($plans),
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
        ];

        $plans[] = $newPlan;

        Storage::put($this->file, json_encode($plans, JSON_PRETTY_PRINT));

        return redirect()->route('admin.subscriptions')->with('success', 'Plan created successfully.');
    }

    /**
     * Show the form for editing the specified plan.
     */
    public function edit($id)
    {
        $plans = $this->getPlans();
        $plan = collect($plans)->firstWhere('id', $id);

        if (!$plan) {
            return redirect()->route('admin.subscriptions')->with('error', 'Plan not found.');
        }

        return view('admin.subscriptions.admin-subscription-create-edit', compact('plan'));
    }

    /**
     * Update the specified plan in JSON.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
        ]);

        $plans = $this->getPlans();

        foreach ($plans as &$plan) {
            if ($plan['id'] == $id) {
                $plan['name'] = $request->name;
                $plan['price'] = $request->price;
                $plan['description'] = $request->description;
            }
        }

        Storage::put($this->file, json_encode($plans, JSON_PRETTY_PRINT));

        return redirect()->route('admin.subscriptions')->with('success', 'Plan updated successfully.');
    }

    /**
     * Remove the specified plan from JSON.
     */
    public function destroy($id)
    {
        $plans = $this->getPlans();
        $plans = array_filter($plans, fn($plan) => $plan['id'] != $id);
        $plans = array_values($plans);

        Storage::put($this->file, json_encode($plans, JSON_PRETTY_PRINT));

        return redirect()->route('admin.subscriptions')->with('success', 'Plan deleted successfully.');
    }

    /** Helper: Read plans from JSON */
    private function getPlans()
    {
        if (!Storage::exists($this->file)) {
            Storage::put($this->file, json_encode([]));
        }

        $plans = Storage::get($this->file);
        return json_decode($plans, true);
    }

    /** Helper: Generate next ID */
    private function nextId($plans)
    {
        if (empty($plans)) return 1;
        return max(array_column($plans, 'id')) + 1;
    }
}
