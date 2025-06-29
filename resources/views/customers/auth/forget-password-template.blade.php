<!DOCTYPE html>
<html lang="en">

	<head>
    <title>Reset Password</title>
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
	        <h2>Password Reset</h2>
	    </div>
		<div class="section">
			<p>Hi {{ $userdata }}</p>
			<p><a href="{{ url('/') }}/{{ route('customerReset.password') }}"><strong>Click Here</strong></a></p>
		</div>
	</body>
</html>