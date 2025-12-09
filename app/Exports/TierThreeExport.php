<?php

namespace App\Exports;

use App\Models\Subscription;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TierThreeExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Subscription::with('user')->where('subscription_id', '3');

        // Apply filters
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        if (!empty($this->filters['plan_name'])) {
            $query->where('plan_name', 'LIKE', '%' . $this->filters['plan_name'] . '%');
        }

        return $query->orderBy('id', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            '#',
            'Artist Name',
            'Artist Email',
            'Getting Plan',
            'Updated Plan',
            'ACH Bank',
            'ACH Account',
            'ACH Routing',
            'Status',
            'Created At',
            'Updated At',
        ];
    }

    public function map($subscription): array
    {
        $planName = 'No Plan';
        $planPrice = '0';

        $path = storage_path('app/subscriptionplans.json');
        if (file_exists($path)) {
            $plans = json_decode(file_get_contents($path), true);
            $matchedPlan = collect($plans)->firstWhere('id', (string)$subscription->subscription_id);

            if ($matchedPlan) {
                $planName = $matchedPlan['name'];
                $planPrice = $matchedPlan['price'];
            }
        }

        static $counter = 0;
        $counter++;

        return [
            $counter,
            $subscription->user->name ?? 'N/A',
            $subscription->user->email ?? 'N/A',
            '$' . $subscription->subscription_plan,
            '$' . $planPrice,
            $subscription->ach_bank_name ?? '-',
            $subscription->ach_account_number ?? '-',
            $subscription->ach_routing_number ?? '-',
            ucfirst($subscription->status),
            $subscription->created_at ? $subscription->created_at->format('Y-m-d H:i:s') : '-',
            $subscription->updated_at ? $subscription->updated_at->format('Y-m-d H:i:s') : '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}