
<script type="text/javascript">
        var gk_isXlsx = false;
        var gk_xlsxFileLookup = {};
        var gk_fileData = {};
        function filledCell(cell) {
          return cell !== '' && cell != null;
        }
        function loadFileData(filename) {
        if (gk_isXlsx && gk_xlsxFileLookup[filename]) {
            try {
                var workbook = XLSX.read(gk_fileData[filename], { type: 'base64' });
                var firstSheetName = workbook.SheetNames[0];
                var worksheet = workbook.Sheets[firstSheetName];

                // Convert sheet to JSON to filter blank rows
                var jsonData = XLSX.utils.sheet_to_json(worksheet, { header: 1, blankrows: false, defval: '' });
                // Filter out blank rows (rows where all cells are empty, null, or undefined)
                var filteredData = jsonData.filter(row => row.some(filledCell));

                // Heuristic to find the header row by ignoring rows with fewer filled cells than the next row
                var headerRowIndex = filteredData.findIndex((row, index) =>
                  row.filter(filledCell).length >= filteredData[index + 1]?.filter(filledCell).length
                );
                // Fallback
                if (headerRowIndex === -1 || headerRowIndex > 25) {
                  headerRowIndex = 0;
                }

                // Convert filtered JSON back to CSV
                var csv = XLSX.utils.aoa_to_sheet(filteredData.slice(headerRowIndex)); // Create a new sheet from filtered array of arrays
                csv = XLSX.utils.sheet_to_csv(csv, { header: 1 });
                return csv;
            } catch (e) {
                console.error(e);
                return "";
            }
        }
        return gk_fileData[filename] || "";
        }
        </script><!DOCTYPE html>
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
      <a class="navbar-brand" href="{{ url('/') }}"><img src="{{asset('logo.jpeg') }}" style="width: 150px; height: 28px; object-fit:cover;" /></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          
          <li class="nav-item"><a class="nav-link" href="{{ route('tatto-quotes.create') }}">Get Quote Now</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('customerProfile') }}">Profile</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('customer.logout') }}">Logout</a></li>
          
        </ul>
        <!-- <span class="time-display ms-3">Tue Jun 24 08:09 PM IST</span> -->
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
          <p>{{ $profile->phone }}</p>
          <p>{{ $profile->email }}</p>
        </div>
        
      </div>
      
      
    </div>
    <div class="profile-info">
      <h4 class="mb-4">Client Information</h4>
      @if (Session::has('msg'))
          <p class="alert alert-success">{{ Session::get('msg') }}</p>
      @endif
      <form method="POST" action="{{ route('customerProfile.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
          <div class="col-md-6">
            @php $exp_name = explode(' ', $profile->name); @endphp
            <label class="form-label">First Name</label>
            <input type="text" name="firstname" class="form-control" value="{{ $exp_name[0] }}" readonly>
          </div>
          <div class="col-md-6">
            <label class="form-label">Last Name</label>
            <input type="text" name="lastname" class="form-control" value="{{ $exp_name[1] }}" readonly>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">State / Province</label>
            <input type="text" name="state" class="form-control" value="{{ $profile->state }}">
          </div>
          <div class="col-md-6">
            <label class="form-label">Zip / Postal Code</label>
            <input type="text" name="zipcode" class="form-control" value="{{ $profile->zipcode }}">
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Phone</label>
            <input type="text" name="mobile_number" id="mobile_number" class="form-control" value="{{ $profile->phone }}" placeholder="(999) 999-9999">
          </div>
          <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" value="{{ $profile->email }}" readonly disabled>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Sex</label>
            <input type="text" class="form-control" value="{{ $profile->sex }}" readonly>
          </div>
          <div class="col-md-6">
            <label class="form-label">Date of Birth</label>
            <input type="text" class="form-control" value="{{ $dob }}" readonly>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Lead Source</label>
            <input type="text" class="form-control" value="{{ $lead_name }}" readonly>
          </div>
          @if(!empty($profile->other_lead_source))
          <div class="col-md-6">
            <label class="form-label">Other Lead Source</label>
            <input type="text" class="form-control" value="{{ $profile->other_lead_source }}" readonly>
          </div>
          @endif
        </div>
        <button type="submit" class="btn btn-primary" name="Update">Update</button>
      </form>
      
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script type="text/javascript">
    // Mobile number formatting
    document.getElementById('mobile_number').addEventListener('input', function(e) {
        // Remove all non-digit characters
        let phoneNumber = e.target.value.replace(/\D/g, '');
        
        // Format the phone number
        if (phoneNumber.length > 0) {
            phoneNumber = '(' + phoneNumber.substring(0, 3) + ') ' + phoneNumber.substring(3, 6) + '-' + phoneNumber.substring(6, 10);
        }
        
        // Update the input value
        e.target.value = phoneNumber;
        
        // Store the raw numbers in a data attribute
        const rawNumber = e.target.value.replace(/\D/g, '');
        e.target.setAttribute('data-raw-value', rawNumber);
    });

    // Before form submission, update the value with raw numbers
    // document.querySelector('form').addEventListener('submit', function(e) {
    //     const mobileInput = document.getElementById('mobile_number');
    //     const rawValue = mobileInput.getAttribute('data-raw-value') || mobileInput.value.replace(/\D/g, '');
    //     mobileInput.value = rawValue;
    // });
  </script>
</body>
</html>