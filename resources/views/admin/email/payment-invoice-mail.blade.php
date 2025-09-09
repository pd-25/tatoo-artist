<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payment Invoice</title>
</head>
<body style="font-family: Arial, sans-serif; background-color:#f8f9fa; padding:20px; color:#333;">
    <table width="100%" cellspacing="0" cellpadding="0" style="max-width:600px; margin:auto; background:#fff; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.05); overflow:hidden;">
        <tr>
            <td style="background:#4F46E5; color:#fff; padding:20px; text-align:center;">
                <h1 style="margin:0; font-size:22px;">Payment Invoice</h1>
            </td>
        </tr>
        <tr>
            <td style="padding:20px;">
                <p style="font-size:16px;">Dear <strong>{{ $data['customer']->name }}</strong>,</p>
                <p>Thank you for your payment. Here are your invoice details:</p>

                <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse:collapse; margin-top:15px;">
                    <tr style="background:#f1f1f1;">
                        <td><strong>Artist</strong></td>
                        <td>{{ $data['artist']->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Design</strong></td>
                        <td>{{ $data['payment']->design }}</td>
                    </tr>
                    <tr style="background:#f9f9f9;">
                        <td><strong>Placement</strong></td>
                        <td>{{ $data['payment']->placement }}</td>
                    </tr>
                    <tr>
                        <td><strong>Price</strong></td>
                        <td>${{ number_format($data['payment']->price, 2) }}</td>
                    </tr>
                    <tr style="background:#f9f9f9;">
                        <td><strong>Deposit</strong></td>
                        <td>${{ number_format($data['payment']->deposit_total, 2) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tips</strong></td>
                        <td>${{ number_format($data['payment']->tips, 2) }}</td>
                    </tr>
                    <tr style="background:#f9f9f9;">
                        <td><strong>Fees</strong></td>
                        <td>${{ number_format($data['payment']->fees, 2) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Total Due</strong></td>
                        <td><strong>${{ number_format($data['payment']->total_due, 2) }}</strong></td>
                    </tr>
                    <tr style="background:#f9f9f9;">
                        <td><strong>Date</strong></td>
                        <td>{{ $data['payment']->date }}</td>
                    </tr>
                </table>

                @if($data['payment']->notes)
                    <p style="margin-top:15px;"><strong>Notes:</strong> {{ $data['payment']->notes }}</p>
                @endif

                <p style="margin-top:20px;">A copy of your invoice has been attached as PDF.</p>
                <p style="margin-top:10px;">Thank you,<br><strong>The Admin Team</strong></p>
            </td>
        </tr>
    </table>
</body>
</html>
