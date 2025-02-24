@extends('admin.layout.main')
@section('title', env('APP_NAME') . ' | Quote')
@section('content')

    <style>


        .myClass {
            width: 500px;
            height: 500px;
            border: solid;
        }

        .ajax-loader {
            visibility: hidden;
            background-color: rgba(255, 255, 255, 0.7);
            position: absolute;
            z-index: +100 !important;
            width: 100%;
            height: 100%;
        }

        .ajax-loader img {
            position: relative;
            top: 50%;
            left: 50%;
        }
    </style>
    <!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="card">
                <div class="card-title pr">
                    <h4>Search Data based on date</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.getQuote') }}" method="GET" enctype="multipart/form-data" name="paymentform">
                        @csrf
                        <div class="row d-flex justify-content-between">
                            <!-- Start Date -->
                            <div class="col-lg-5 col-md-5 col-sm-12">
                                <label for="start_date"><b>Start Date:</b></label>
                                <div class="input-group">
                                    <input type="text" id="start_date" name="start_date" value="{{ request()->input('start_date') ?? date('m-d-Y') }}" class="form-control flatpickr" required>
                                    <div class="input-group-addon input-group-append">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>   
                            </div>
                    
                            <!-- End Date -->
                            <div class="col-lg-5 col-md-5 col-sm-12">
                                <label for="end_date"><b>End Date:</b></label>
                                <div class="input-group">
                                    <input type="text" id="end_date" name="end_date" class="form-control flatpickr" value="{{ request()->input('end_date') ?? date('m-d-Y') }}" required>
                                    <div class="input-group-addon input-group-append">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>   
                            </div>
                    
                            <!-- Filter and Print Buttons -->
                            <div class="col-lg-2 col-md-2 col-sm-12 d-flex align-items-end justify-content-center">
                                <button type="submit" class="btn btn-primary w-100 m-1">Search</button>
                            </div>
                        </div> 
                    </form>

                  
                        
                </div>    
            </div>
        </div>  
        <div class="col-lg-11">
            <div class="card">
                
                <div class="card-title pr">
                <div class="d-flex justify-content-between">
                    <div>
                    <h4>All Quotes</h>
                    </div>
                    <div class="d-flex align-items-center">
                    <a href="#" class="btn btn-success" data-toggle="modal" data-target="#createQuoteModal">Create
                    Quote</a>
                        <a href="{{route('admin.quoteArchive')}}" class="btn btn-primary m-1">Archives</a>
                        <button class="btn btn-primary m-1 d-none" id="moveToArchives">Move to Archives</button>
                    </div>
                </div>
              

                <div id="alert-container"></div>

@if (Session::has('msg'))
    <p class="alert alert-info">{{ Session::get('msg') }}</p>
    
@endif
                </div>
                <div class="card-title text-right">
                    
                </div>
                <div class="ajax-loader">
                    <img src="https://i.stack.imgur.com/MnyxU.gif" class="img-responsive" />
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table student-data-table m-t-20">
                            <thead style="text-align: center;">
                                <tr>
                                <th class="text-center"><input type="checkbox" id="selectAll"></th>
                                    <th class="text-center">SN.</th>
                                    <th class="text-center">User Name</th>
                                    <th class="text-center">User Email</th>
                                    <th class="text-center">User Contact</th>
                                    <th class="text-center">Artist Name</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody style="text-align: center;">
                                @if (count($quotes) > 0)
                                    @foreach ($quotes as $index => $quote)
                                        <!-- @if ($quote->quote_type != 1) -->
                                            @php
                                                $availability = date('jS F, Y', strtotime($quote->availability));
                                                $quote_created_at = date('jS F, Y', strtotime($quote->created_at));
                                                $escapedDescription = htmlspecialchars(
                                                    $quote->description,
                                                    ENT_QUOTES,
                                                    'UTF-8',
                                                );
                                                $formattedPhoneNumber = sprintf(
                                                    '(%s) %s-%s',
                                                    substr(@$quote->user->phone, 0, 3),
                                                    substr(@$quote->user->phone, 3, 3),
                                                    substr(@$quote->user->phone, 6, 4),
                                                );
                                            @endphp

                                            <tr>
                                            <td><input type="checkbox" class="quoteCheckbox" value="{{ $quote->id }}"></td>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ @$quote->user->name }}</td>
                                                <td>{{ @$quote->user->email }}</td>
                                                <td>{{ @$formattedPhoneNumber }}</td>
                                                <td>{{ @$quote->artist->name }}</td>
                                                <td>{{ date('m-d-Y',strtotime( $quote->created_at)) }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-info toggle-actions mb-1">Show
                                                        Actions</button>
                                                    <div class="quote-actions" style="display: none;">
                                                        <a href="{{ asset('storage/quoteImage/' . $quote->reference_image) }}"
                                                            class="btn btn-sm btn-success" target="_blank">View
                                                            Image</a><br>
                                                        <button class="btn btn-sm btn-primary viewQuoteDetails"
                                                            data-size="{{ $quote->size }}" data-color="{{ $quote->color }}"
                                                            data-whtogttato="{{ $quote->when_get_tattooed }}"
                                                            data-budget="{{ $quote->budget }}"
                                                            data-availability="{{ $availability }}"
                                                            data-fbv="{{ $quote->front_back_view }}"
                                                            data-created ="{{ $quote_created_at }}"
                                                            data-desc="{{ $escapedDescription }}">View Quote
                                                            Details</button><br>
                                                        @if ($quote->link_send_status == 0)
                                                            <button class="btn btn-sm btn-primary"
                                                                onclick="Sendlink({{ $quote->user_id }},{{ $quote->artist_id }},{{ $quote->id }})">Send Consent
                                                                Link</button>
                                                        @elseif($quote->link_send_status == 1)
                                                            <button class="btn btn-sm btn-warning"
                                                                onclick="AgainSendlink({{ $quote->user_id }},{{ $quote->artist_id }},{{ $quote->id }})">Again
                                                                Send Consent
                                                                Link</button>
                                                        @else
                                                            <a href="{{ $quote->pdf_path }}" class="btn btn-sm btn-success"
                                                                target="_blank">View Link</a>
                                                        @endif
                                                        <form method="POST"
                                                            action="{{ route('quote.delete', encrypt($quote->id)) }}"
                                                            class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-sm btn-danger delete-icon show_confirm"
                                                                data-toggle="tooltip" title="Delete">
                                                                <i class="ti-trash"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        <!-- @endif -->
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" style="text-align: center;">
                                            <b>No record is found at this moment!</b>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal window div-->
    <div class="modal fade show" id="viewQuoteModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated flipInY">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Quote Details</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <h6><i class="fa fa-clone"></i> Other Informations</h6>
                            <div class="table-responsive pt-2">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="30%">Size</th>
                                        <td width="2%">:</td>
                                        <td id="quo_size">Not Provided</td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Color</th>
                                        <td width="2%">:</td>
                                        <td id="quo_color">Not Provided</td>
                                    </tr>
                                    <tr>
                                        <th width="30%">When are you looking to get tattooed?</th>
                                        <td width="2%">:</td>
                                        <td id="quo_whtogttato">Not Provided</td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Budget</th>
                                        <td width="2%">:</td>
                                        <td id="quo_budget">Not Provided</td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Availability</th>
                                        <td width="2%">:</td>
                                        <td id="quo_availability">Not Provided</td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Front and Back Data</th>
                                        <td width="2%">:</td>
                                        <td id="quo_front_back_view">Not Provided</td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Quote Created On</th>
                                        <td width="2%">:</td>
                                        <td id="quo_created">Not Provided</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <h6><i class="fa fa-clone pr-1"></i>Description</h6>
                            <div class="quote-desc" id="quote_description"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal ends here -->

    <!-- Create Quote Modal -->
    <div class="modal fade" id="createQuoteModal" tabindex="-1" role="dialog" aria-labelledby="createQuoteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createQuoteModalLabel">Create Quote</h5>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                <div class="modal-body">
                    <!-- Form inside modal -->
                    <form action="{{ route('admin.storeQuote') }}" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="artist_id" class="col-form-label">Artist ID</label>
                                @if (Auth::guard('artists')->check())
                                    <input type="text" class="form-control"
                                        value="{{ Auth::guard('artists')->user()->name }}" readonly>
                                    <input type="hidden" name="artist_id"
                                        value="{{ Auth::guard('artists')->user()->id }}">
                                @else
                                    <select name="artist_id" class="form-control" id="artist_id">
                                        <option value="">Select Artist</option>
                                        @foreach ($artists as $user)
                                            <option value="{{ $user->id }}"
                                                {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label for="user_id" class="col-form-label">User ID</label>
                                <select name="user_id" class="form-control" id="user_id">
                                    <option value="">Select User</option>
                                    @foreach ($customers as $user)
                                        <option value="{{ $user->id }}"
                                            {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group d-flex justify-content-center mt-3">
                            <button type="submit" class="btn btn-primary">Create Quote</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
document.addEventListener("DOMContentLoaded", function() {
    const selectAll = document.getElementById("selectAll");
    const checkboxes = document.querySelectorAll(".quoteCheckbox");
    const moveToArchives = document.getElementById("moveToArchives");

    function toggleMoveToArchives() {
        const selectedIds = Array.from(checkboxes)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value); 

        moveToArchives.classList.toggle("d-none", selectedIds.length === 0);

        // Store selected IDs in a data attribute
        moveToArchives.setAttribute("data-selected", JSON.stringify(selectedIds));
    }

    selectAll.addEventListener("change", function() {
        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAll.checked;
        });
        toggleMoveToArchives();
    });

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener("change", toggleMoveToArchives);
    });

    moveToArchives.addEventListener("click", function() {
        const selectedIds = JSON.parse(moveToArchives.getAttribute("data-selected") || "[]");
        
        if (selectedIds.length > 0) {
            console.log("Selected IDs: ", selectedIds);
            // Send these IDs to the server via AJAX or form submission
            fetch("{{ route('quote.moveToArchives') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ ids: selectedIds })
            }).then(response => response.json())
            .then(data => {
            if (data.success) {
                // Show Bootstrap alert
                const alertDiv = document.createElement("div");
                alertDiv.className = "alert alert-info";
                alertDiv.innerHTML = data.success;
                document.getElementById("alert-container").appendChild(alertDiv);

                // Remove alert after 3 seconds
                setTimeout(() => {
                    alertDiv.remove();
                    location.reload();
                }, 3000);
            } else {
                alert("Something went wrong!");
            }
        })
        .catch(error => console.error("Error:", error));
        }
    });
});
</script>
@endsection

@section('script')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        flatpickr(".flatpickr", {
            dateFormat: "m-d-Y", // Customize the date format
            allowInput: true, // Allow manual input
            // defaultDate: "today", // Set default date to today
        });
    });
</script>
    <script>
       function Sendlink(authUserId) {
    const inputEmail = document.getElementById("inputEmail").value;
    $.ajax({
        type: "POST",
        url: "{{ route('admin.SendLink') }}",
        data: {
            'type': 'walkin',
            'email': inputEmail,
            'artistid': authUserId,
            '_token': '{{ csrf_token() }}'
        },
        beforeSend: function() {
            $('.ajax-loader').show();
        },
        complete: function() {
            $('.ajax-loader').hide();
        },
        success: function(result) {
            if (result.message === "Email sent successfully") {
                swal({
                    title: 'Email sent successfully.',
                    target: ".myClass"
                }).then(() => {
                    location.reload();
                });
            } else {
                swal('Some error occurred, please reload the page');
            }
        },
        error: function(xhr) {
            swal('An error occurred: ' + xhr.responseJSON.error);
        }
    });
}

function AgainSendlink(userid, artistid, dbid) {
    $.ajax({
        type: "POST",
        url: "{{ route('admin.SendLink') }}",
        data: {
            'userid': userid,
            'artistid': artistid,
            'dbid': dbid,
            '_token': '{{ csrf_token() }}'
        },
        beforeSend: function() {
            $('.ajax-loader').show();
        },
        complete: function() {
            $('.ajax-loader').hide();
        },
        success: function(result) {
            if (result.message === "Email sent successfully") {
                swal({
                    title: 'Email sent successfully.',
                    target: ".myClass"
                }).then(() => {
                    location.reload();
                });
            } else {
                swal('Some error occurred, please reload the page');
            }
        },
        error: function(xhr) {
            swal('An error occurred: ' + xhr.responseJSON.error);
        }
    });
}


        $(document).on("click", ".viewQuoteDetails", function() {
            let size = $(this).data('size');
            let color = $(this).data('color');
            let when_to_get_tatto = $(this).data('whtogttato');
            let budget = $(this).data('budget');
            let availability = $(this).data('availability');
            let front_back_view = $(this).data('fbv');
            let created = $(this).data('created');
            let quote_description = $(this).data('desc');

            $("#quo_size").text(size);
            $("#quo_color").text(color);
            $("#quo_whtogttato").text(when_to_get_tatto);
            $("#quo_budget").text(`$${budget}`);
            $("#quo_availability").text(availability);
            $("#quo_front_back_view").text(front_back_view);
            $("#quo_created").text(created);
            $("#quote_description").html(quote_description);

            $("#viewQuoteModal").modal('show');
        });

        $(document).on("click", ".toggle-actions", function() {
            let actionsDiv = $(this).siblings(".quote-actions");
            actionsDiv.toggle();
            if (actionsDiv.is(':visible')) {
                $(this).text('Hide Actions');
            } else {
                $(this).text('Show Actions');
            }
        });
    </script>
    
@endsection
