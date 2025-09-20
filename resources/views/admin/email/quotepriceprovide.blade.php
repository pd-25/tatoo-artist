<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Quote Price Provided</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; margin:0; padding:20px;">

    <table align="center" width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1); padding:20px;">
        <tr>
            <td style="padding:20px;">
                <h2 style="color:#333;">Hello {{ $user_name }},</h2>

                <p style="color:#555; font-size:15px; line-height:1.6;">
                    I received a request for a Tattoo approximately <strong>{{ $size }}</strong> in 
                    <strong>{{ $color }}</strong> around <strong>{{ $when_to_get_tattoo }}</strong> 
                    with a Budget of approximately <strong>{{ $budget }}</strong>.
                </p>

                <p style="color:#555; font-size:15px; line-height:1.6;">
                    I see that you are available around <strong>{{ $availability }}</strong> and wish to have the tattoo on your 
                    <strong>{{ $front_back_view }}</strong>.
                </p>

                @if(!empty($extra_request))
                <p style="color:#555; font-size:15px; line-height:1.6;">
                    You also requested that <strong>{{ $extra_request }}</strong>.
                </p>
                @endif

                <p style="color:#555; font-size:15px; line-height:1.6;">
                    I can provide you the tattoo for <strong>${{ $provide_price }}</strong>.
                </p>

                <p style="color:#555; font-size:15px; line-height:1.6;">
                    I would love to work with you. If you are interested in moving forward, please click the button below to book an appointment.
                </p>

                <p style="text-align:center; margin:30px 0;">
                    <a href="{{ url('https://tattoome.net/' . urlencode($artist_user_name)) }}/" style="background:#28a745; color:#fff; text-decoration:none; padding:12px 20px; border-radius:5px; font-size:16px;">
                        Book Appointment
                    </a>
                </p>

                <p style="color:#555; font-size:15px; line-height:1.6;">
                    Thank you,<br>
                    <strong>{{ $artist_name }}</strong>
                </p>
            </td>
        </tr>
    </table>

</body>
</html>
