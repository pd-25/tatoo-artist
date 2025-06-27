<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tattoo Studio Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6f9;
      font-family: 'Arial', sans-serif;
    }
    .navbar {
      background-color: #2c3e50;
      padding: 1rem;
    }
    .navbar-brand {
      color: #ffffff;
      font-size: 1.5rem;
      font-weight: bold;
    }
    .nav-link {
      color: #ecf0f1 !important;
      margin: 0 1rem;
    }
    .nav-link:hover {
      color: #3498db !important;
    }
    .profile-header {
      background: linear-gradient(135deg, #3498db, #2c3e50);
      color: #ffffff;
      padding: 2rem;
      border-radius: 0 0 15px 15px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .profile-header h2 {
      margin-bottom: 0.5rem;
    }
    .unused-deposits {
      background-color: rgba(255, 255, 255, 0.2);
      padding: 0.75rem;
      border-radius: 10px;
      display: inline-block;
    }
    .profile-info {
      background-color: #ffffff;
      padding: 2rem;
      border-radius: 15px;
      margin-top: -2rem;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .form-label {
      font-weight: 500;
    }
    .btn-custom {
      background-color: #3498db;
      color: #ffffff;
      border: none;
    }
    .btn-custom:hover {
      background-color: #2980b9;
    }
    .time-display {
      color: #ecf0f1;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="{{ route('customer.logout') }}">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-4">
    <div class="profile-header">
      <div class="row mb-6">
        <div class="col-md-3">
          @if (!empty($profile->profile_image) && File::exists(public_path('storage/ProfileImage/' . $profile->profile_image)))
          <img style="height: 82px; width: 82px; object-fit: cover; border-radius:50%" src="{{ asset('storage/ProfileImage/'.$profile->profile_image) }}" alt="">
          @else
          <img style="height: 82px; width: 82px; object-fit: cover; border-radius:50%" src="{{asset('noimg.png') }}" alt="">
          @endif
        </div>
        <div class="col-md-6 text-center">
          <h2>{{ $profile->name }}</h2>
          <p id="display-phone">{{ $profile->phone }}</p>
          <p>{{ $profile->email }}</p>
        </div>
      </div>
    </div>
    <div class="profile-info">
      <h4 class="mb-4">Client Information</h4>
      <form>
        <div class="row mb-3">
          <div class="col-md-6">
            @php $exp_name = explode(' ', $profile->name); @endphp
            <label class="form-label">First Name</label>
            <input type="text" class="form-control" value="{{ $exp_name[0] }}">
          </div>
          <div class="col-md-6">
            <label class="form-label">Last Name</label>
            <input type="text" class="form-control" value="{{ $exp_name[1] }}">
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">State / Province</label>
            <input type="text" class="form-control" value="{{ $profile->state }}">
          </div>
          <div class="col-md-6">
            <label class="form-label">Zip / Postal Code</label>
            <input type="text" class="form-control" value="{{ $profile->zipcode }}">
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Phone</label>
            <input type="text" class="form-control" id="profile-phone" value="{{ $profile->phone }}" readonly>
          </div>
          <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" value="{{ $profile->email }}">
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Sex</label>
            <input type="text" class="form-control" value="{{ $profile->sex }}">
          </div>
          <div class="col-md-6">
            <label class="form-label">Date of Birth</label>
            <input type="text" class="form-control" value="{{ $dob }}">
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Lead Source</label>
            <input type="text" class="form-control" value="{{ $lead_name }}">
          </div>
          @if(!empty($profile->other_lead_source))
          <div class="col-md-6">
            <label class="form-label">Other Lead Source</label>
            <input type="text" class="form-control" value="{{ $profile->other_lead_source }}">
          </div>
          @endif
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Function to format phone number
    function formatPhoneNumber(phoneNumber) {
      // Remove all non-digit characters
      const cleaned = ('' + phoneNumber).replace(/\D/g, '');
      
      // Check if the number is valid length
      if (cleaned.length !== 10) return phoneNumber; // Return original if not 10 digits
      
      // Format as (XXX) XXX-XXXX
      const match = cleaned.match(/^(\d{3})(\d{3})(\d{4})$/);
      if (match) {
        return '(' + match[1] + ') ' + match[2] + '-' + match[3];
      }
      return phoneNumber;
    }

    // Format phone numbers on page load
    document.addEventListener('DOMContentLoaded', function() {
      const phoneInput = document.getElementById('profile-phone');
      const displayPhone = document.getElementById('display-phone');
      
      if (phoneInput) {
        const formattedPhone = formatPhoneNumber(phoneInput.value);
        phoneInput.value = formattedPhone;
      }
      
      if (displayPhone) {
        const formattedDisplayPhone = formatPhoneNumber(displayPhone.textContent);
        displayPhone.textContent = formattedDisplayPhone;
      }
    });
  </script>
</body>
</html>