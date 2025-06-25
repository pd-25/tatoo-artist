
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
      <a class="navbar-brand" href="#">tattoostudio™</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="{{ route('customer.logout') }}">Logout</a></li>
          <!-- <li class="nav-item"><a class="nav-link" href="#">Queue (10)</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Appointments (5)</a></li>
          <li class="nav-item"><a class="nav-link active" href="#">Clients</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Staff</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Reports</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Forms</a></li> -->
        </ul>
        <!-- <span class="time-display ms-3">Tue Jun 24 08:09 PM IST</span> -->
      </div>
    </div>
  </nav>

  <div class="container mt-4">
    <div class="profile-header text-center">
      <?php //echo '<pre>'; print_r($profile); echo '</pre>'; ?>
      <h2>{{ $profile->name }}</h2>
      <!-- <p>VA 01234</p> -->
      <p>{{ $profile->phone }}</p>
      <p>{{ $profile->email }}</p>
      <!-- <div class="unused-deposits mt-3">
        <strong>$50 Unused Deposits</strong>
      </div> -->
      <!-- <div class="mt-3">
        <button class="btn btn-custom btn-sm me-2">Call</button>
        <button class="btn btn-custom btn-sm me-2">Message</button>
        <button class="btn btn-custom btn-sm">Email</button>
      </div> -->
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
            <input type="text" class="form-control" value="{{ $profile->phone }}">
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
            <input type="date" class="form-control" value="{{ $profile->dob }}">
          </div>
        </div>
      </form>
      <!-- <h4 class="mb-3">Release Forms</h4>
      <button class="btn btn-custom btn-sm">New Form</button>
      <h4 class="mb-3">Appointments</h4>
      <button class="btn btn-custom btn-sm">New Appointment</button>
      <h4 class="mb-3">Notes</h4>
      <button class="btn btn-custom btn-sm">New Note</button> -->
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>