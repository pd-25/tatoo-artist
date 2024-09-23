<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Options</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            padding: 30px;
            max-width: 400px;
            width: 100%;
        }
        h1 {
            font-weight: bold;
            font-size: 2.5rem;
            color: #333;
        }
        .btn {
            font-size: 1.2rem;
            width: 100%;
            padding: 15px;
            margin-bottom: 15px;
            transition: all 0.3s ease-in-out;
        }
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body style="background: url('https://asset.gecdesigns.com/img/background-templates/dark-blue-background-with-the-diamond-pattern-template-sr06012408-1704699724568-cover.webp')">
    <div class="login-card text-center">
        <h3>Select Login</h3>
        <div class="mt-4">
            <a href="{{ route('adminLogin') }}" class="btn btn-primary btn-lg">Admin Login</a>
            <a href="{{ route('salesLogin') }}" class="btn btn-success btn-lg">Sales Login</a>
            <a href="{{ route('artistLogin') }}" class="btn btn-info btn-lg">Artist Login</a>
        </div>
    </div>
</body>
</html>
