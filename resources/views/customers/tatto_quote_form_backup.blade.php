<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Tattoo Quote Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
/*      background-color: #0b0d1c;*/
      color: #b0e0e6;
    }
    .form-check-label {
      color: #00bcd4;
    }
    .form-control, .form-control:focus {
      background-color: #1c1e2a;
      border: none;
      color: #fff;
    }
    .form-section {
      padding: 20px;
    }
    .btn-custom {
      background-color: #00bcd4;
      color: white;
    }
    .nav-tabs .nav-link.active {
      background-color: #00bcd4;
      color: white !important;
    }
    .nav-tabs .nav-link {
      color: #00bcd4;
    }
    .navbar {
  background-color: #2c3e50;
  padding: 1rem;
  color: #fff;
}
@media (min-width: 992px) {
  .navbar-expand-lg {
    flex-wrap: nowrap;
    justify-content: flex-start;
  }
}
.profile-header {
  background: linear-gradient(135deg, #3498db, #2c3e50);
  color: #ffffff;
  padding: 2rem;
/*  border-radius: 0 0 15px 15px;*/
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
    .svg-container {
      max-width: 200px;
      margin: auto;
    }
    /*  STYLING FOR BODY SVG  */
    svg path {
      fill: #cccccc33;
      stroke: #00bcd4;
      stroke-width: 1;
      cursor: pointer;
      transition: fill 0.3s;
    }
    svg path.active {
      fill: #00bcd4;
    }
    .output {
      color: #00e0ff;
      margin-top: 1rem;
    }
    .btn-custom {
      background-color: #00bcd4;
      color: white;
    }
  </style>
</head>
<body>

  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <!-- <a class="navbar-brand" href="#">tattoostudio™</a> -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          {{-- <li class="nav-item" style="color:#fff;"><a class="nav-link" href="{{ route('tatto-quotes.create') }}">Get Quote Now</a></li> --}}
          <li class="nav-item"><a class="nav-link" href="{{ route('customer.logout') }}">Logout</a></li>
          <!-- 
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
  <div class="profile-header">
  <h2 class="text-center text-info">Quote Now</h2>
</div>
  
  <div class="tab-content bg-dark rounded-bottom" id="quoteTabsContent" style="padding: 10px;">
    <!-- TAB 1 -->
    <div class="tab-pane fade show active form-section" id="form1" role="tabpanel">
      <!-- method="POST" action="{{ route('tatto-quotes.store') }}" enctype="multipart/form-data" -->
      <form >
        @csrf
        <!-- Tattoo Size -->
        <h5>How big would you like the tattoo?</h5>
        <div class="row">
          <div class="col-md-4 form-check"><input class="form-check-input" type="radio" name="size" id="credit" value="Size of a Credit Card"><label class="form-check-label" for="credit">Size of a Credit Card</label></div>
          <div class="col-md-4 form-check"><input class="form-check-input" type="radio" name="size" id="palm" value="Palm Sized"><label class="form-check-label" for="palm">Palm Sized</label></div>
          <div class="col-md-4 form-check"><input class="form-check-input" type="radio" name="size" id="hand" value="Hand Sized"><label class="form-check-label" for="hand">Hand Sized</label></div>
          <div class="col-md-4 form-check"><input class="form-check-input" type="radio" name="size" id="half" value="Half-Sleeve or Larger"><label class="form-check-label" for="half">Half-Sleeve or Larger</label></div>
          <div class="col-md-4 form-check"><input class="form-check-input" type="radio" name="size" id="undecided" value="Haven't Decided"><label class="form-check-label" for="undecided">Haven't Decided</label></div>
        </div>

        <!-- Color -->
        <h5 class="mt-3">Would you like your tattoo to have color or only black & grey ink?</h5>
        <div class="row">
          <div class="col-md-3 form-check"><input class="form-check-input" type="radio" name="color" id="color" value="Color"><label class="form-check-label" for="color">Color</label></div>
          <div class="col-md-3 form-check"><input class="form-check-input" type="radio" name="color" id="black" value="Black & Grey"><label class="form-check-label" for="black">Black & Grey</label></div>
          <div class="col-md-3 form-check"><input class="form-check-input" type="radio" name="color" id="notSure" value="Haven't Decided"><label class="form-check-label" for="notSure">Haven't Decided</label></div>
        </div>
      </form>

        <!-- Image Upload -->
        <form id="image-upload" enctype="multipart/form-data">
        <h5 class="mt-3">Do you have any reference images for your tattoo?</h5>
        <input class="form-control" type="file" name="reference_image">
        
      </form>

        <!-- Availability -->
        <form>
        <h5 class="mt-3">Are you flexible with the availability of the tattoo artist?</h5>
        <input class="form-control col-md-3" type="date" name="availability" id="availability">

        <!-- Budget -->
        <h5 class="mt-3">What is your budget for this tattoo?</h5>
        <div class="row">
          <div class="col-md-3 form-check"><input class="form-check-input" type="radio" name="budget" id="b1" value="Under $100"><label class="form-check-label" for="b1">Under $100</label></div>
          <div class="col-md-3 form-check"><input class="form-check-input" type="radio" name="budget" id="b2" value="$100 - $200"><label class="form-check-label" for="b2">$100 - $200</label></div>
          <div class="col-md-3 form-check"><input class="form-check-input" type="radio" name="budget" id="b3" value="$200 - $500"><label class="form-check-label" for="b3">$200 - $500</label></div>
          <div class="col-md-3 form-check"><input class="form-check-input" type="radio" name="budget" id="b4" value="$500 - $1000"><label class="form-check-label" for="b4">$500 - $1000</label></div>
          <div class="col-md-3 form-check"><input class="form-check-input" type="radio" name="budget" id="b5" value="Over $1000"><label class="form-check-label" for="b5">Over $1000</label></div>
        </div>

        <!-- When -->
        <h5 class="mt-3">When would you like to get tattooed?</h5>
        <div class="row">
          <div class="col-md-3 form-check"><input class="form-check-input" type="radio" name="when" id="w1" value="Next few days"><label class="form-check-label" for="w1">Next few days</label></div>
          <div class="col-md-3 form-check"><input class="form-check-input" type="radio" name="when" id="w2" value="Next week"><label class="form-check-label" for="w2">Next week</label></div>
          <div class="col-md-3 form-check"><input class="form-check-input" type="radio" name="when" id="w3" value="Next month"><label class="form-check-label" for="w3">Next month</label></div>
          <div class="col-md-3 form-check"><input class="form-check-input" type="radio" name="when" id="w4" value="I'm flexible"><label class="form-check-label" for="w4">I'm flexible</label></div>
        </div>

        <!-- Description -->
        <h5 class="mt-3">Describe your tattoo idea and where you'd like it on your body.</h5>
        <textarea class="form-control" rows="1" placeholder="Describe your text here..." name="description" id="description"></textarea>

        <!-- Next Button -->
        <div class="text-end mt-4">
          <!-- <button type="button" class="btn btn-custom" data-bs-toggle="tab" data-bs-target="#form2">Next</button> -->


          <!-- <button type="submit" class="btn btn-custom">Submit</button> -->
        </div>
      </form>
    </div>

    <!-- TAB 2 -->
    <div class="tab-pane fade form-section" id="form2" role="tabpanel">
      <form>
        <div class="container text-center my-5">
          <h2 class="text-info">Tattoo Zone Selector (Front & Back)</h2>

          <div class="row">
            <!-- Front View -->
            <div class="col-md-6">
              <h4 class="text-light">Front</h4>
              <div class="svg-container">
                <svg id="frontSvg" viewBox="0 0 200 500" xmlns="http://www.w3.org/2000/svg">
                  <path id="front_head" d="M80 20 Q100 0 120 20 Q110 60 90 60 Z"/>
                  <path id="front_chest" d="M60 60 Q100 50 140 60 Q130 100 70 100 Z"/>
                  <path id="front_abdomen" d="M70 100 Q100 110 130 100 Q130 150 70 150 Z"/>
                  <path id="front_leftArm" d="M40 60 Q20 120 40 180 Q60 120 60 60 Z"/>
                  <path id="front_rightArm" d="M160 60 Q180 120 160 180 Q140 120 140 60 Z"/>
                  <path id="front_leftLeg" d="M80 150 Q70 250 85 380 Q95 250 90 150 Z"/>
                  <path id="front_rightLeg" d="M120 150 Q130 250 115 380 Q105 250 110 150 Z"/>
                </svg>
              </div>
            </div>

            <!-- Back View -->
            <div class="col-md-6">
              <h4 class="text-light">Back</h4>
              <div class="svg-container">
                <svg id="backSvg" viewBox="0 0 200 500" xmlns="http://www.w3.org/2000/svg">
                  <path id="back_head" d="M80 20 Q100 0 120 20 Q110 60 90 60 Z"/>
                  <path id="back_upperBack" d="M60 60 Q100 50 140 60 Q130 100 70 100 Z"/>
                  <path id="back_lowerBack" d="M70 100 Q100 110 130 100 Q130 150 70 150 Z"/>
                  <path id="back_leftArm" d="M40 60 Q20 120 40 180 Q60 120 60 60 Z"/>
                  <path id="back_rightArm" d="M160 60 Q180 120 160 180 Q140 120 140 60 Z"/>
                  <path id="back_leftLeg" d="M80 150 Q70 250 85 380 Q95 250 90 150 Z"/>
                  <path id="back_rightLeg" d="M120 150 Q130 250 115 380 Q105 250 110 150 Z"/>
                </svg>
              </div>
            </div>
          </div>
        </div>
        <div class="text-end mt-4">
          <input type="hidden" name="photoname" id="photoname">
          <input type="hidden" name="tattooZones" id="tattooZones" value="">
          <div class="alert alert-info" style="display: none; text-align:center;" id="success-msg"></div>
          <button type="button" onclick="saveTattoQuote();" class="btn btn-custom">Submit</button>
        </div>
      </form>
    </div>
    <ul class="nav nav-tabs" id="quoteTabs" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="form1-tab" data-bs-toggle="tab" data-bs-target="#form1" type="button" role="tab">1</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="form2-tab" data-bs-toggle="tab" data-bs-target="#form2" type="button" role="tab">2</button>
    </li>
  </ul>
  </div>
  
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script type="text/javascript">
  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  function saveTattoQuote(){
    var size = $("input[type='radio'][name=size]").val();
    var color = $("input[type='radio'][name=color]").val();
    var photoname = $("#photoname").val();
    var availability = $("#availability").val();
    var budget = $("input[type='radio'][name=budget]").val();
    var when = $("input[type='radio'][name=when]").val();
    var description = $("#description").val();
    var tattooZones = $("#tattooZones").val();
    //alert(size);
    var filename = "{{ route('tatto-quotes.store') }}";
    var request  = $.ajax({
                url  : filename,
                type : "POST",
                data : {
                      size : size,
                      color : color,
                      budget : budget,
                      when_get_tattooed : when,
                      availability : availability,
                      description : description,
                      reference_image : photoname,
                      front_back_view : tattooZones
                    },
                    dataType : "json"
                });
                request.done(function(result){
                  // alert(result.message1);
                  // alert(result.message2);
                  if(result.flag == 1){
                    $("#success-msg").show();
                    $("#success-msg").text(result.msg);
                    //alert(msg);
                  }

                  
                });
                request.fail(function(jqXHR,textStatus){
                  //alert(textStatus);
                  // alert('Please fill the form correctly.');
                });
  }

  $('#image-upload').on('change', function(e) {
    //alert('img');
        e.preventDefault();
        let formData = new FormData(this);
        
        $.ajax({
            type:'POST',
            url: "{{ route('tatooRefImage.store') }}",
            data: formData,
            contentType: false,
            processData: false,

            success: (response) => {
                if (response) {
                   
                    $("#photoname").val(response.imagename);
                    $("#uploadphoto_success").text(response.message);
                    //alert('Image has been uploaded successfully');
                }
            },

            error: function(response){
               
                // var output = jQuery.parseJSON(response);
                // alert(output.errors);
                // var output = jQuery.parseJSON(response);
                // alert(response.errors);
                //assets/images/user.png
                $("#filename").val("");
                
            }

        });

    });

  // ------------------------SCRIPT FOR BODY SVG------------------------ //
  const selected = new Set();
  const outputs = document.getElementById('selectedOutput');
  const hidden = document.getElementById('tattooZones');

  function bindSvg(svgId) {
    const paths = document.querySelectorAll(`#${svgId} path`);
    paths.forEach(p => {
      p.addEventListener('click', () => {
        p.classList.toggle('active');
        if (selected.has(p.id)) selected.delete(p.id);
        else selected.add(p.id);
        update();
      });
    });
  }

  function update() {
    const arr = Array.from(selected);
    hidden.value = arr.join(', ');
    outputs.textContent = arr.length ? 'Selected Zones: ' + arr.join(', ') : 'Selected Zones: None';
  }

  function handleSubmit() {
    alert('Zones submitted: ' + hidden.value);
    return false;
  }

  bindSvg('frontSvg');
  bindSvg('backSvg');
</script>
</body>
</html>
