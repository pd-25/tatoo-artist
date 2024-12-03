<!DOCTYPE html>
<html>
<head>
    <title>New Subscription Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 20px;
        }
        h2 {
            color: #0080e0;
            border-bottom: 2px solid #0080e0;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        p {
            margin: 10px 0;
        }
        strong {
            color: #555;
        }
        .section {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    
    <div class="section">
        <h2>Profile Details</h2>
        <p><strong>Artist Name:</strong> {{ $userdata->name  ?? 'N/A'  }}</p>
        <p><strong>Artist Email:</strong> {{ $userdata->email  ?? 'N/A' }}</p>
        <p><strong>Artist Username:</strong> {{ $userdata->username  ?? 'N/A' }}</p>
        <p><strong>Artist Phone:</strong> {{ $userdata->phone  ?? 'N/A' }}</p>
        <p><strong>Main Address:</strong> {{ $userdata->address  ?? 'N/A' }}</p>
        <p><strong>Address Line 2:</strong> {{ $userdata->address2  ?? 'N/A' }}</p>
        <p><strong>City:</strong> {{ $userdata->city  ?? 'N/A' }}</p>
        <p><strong>State:</strong> {{ $userdata->state  ?? 'N/A' }}</p>
        <p><strong>Zip Code:</strong> {{ $userdata->zipcode  ?? 'N/A' }}</p>
        <p><strong>Sales Representative:</strong> {{ $salesdata->name  ?? 'N/A' }}</p>
    </div>

    <div class="section">
        <h2>Subscription Details</h2>
        <p><strong>Signup Date:</strong> {{ $userdata->created_at->format('m/d/Y') }}</p>
        <p><strong>Subscription Date:</strong> {{ \Carbon\Carbon::parse($subscriptionData['created_at'])->format('m/d/Y') }}</p>
        <p><strong>Subscription Level:</strong> {{ $subscriptionData['subscription_plan'] }}</p>
        <p><strong>Status:</strong> {{ $subscriptionData['status'] }}</p>
        <p><strong>Zelle Email:</strong> {{ $subscriptionData['zell_email'] ?? 'N/A' }}</p>
        <p><strong>Zelle Phone:</strong> {{ $subscriptionData['zell_phone'] ?? 'N/A' }}</p>
        <p><strong>ACH Bank Name:</strong> {{ $subscriptionData['ach_bank_name'] ?? 'N/A' }}</p>
        <p><strong>ACH Type:</strong> {{ $subscriptionData['ach_type'] ?? 'N/A' }}</p>
        <p><strong>ACH Routing Number:</strong> {{ $subscriptionData['ach_routing_number'] ?? 'N/A' }}</p>
        <p><strong>ACH Account Number:</strong> {{ $subscriptionData['ach_account_number'] ?? 'N/A' }}</p>
    </div>

</body>
</html>
