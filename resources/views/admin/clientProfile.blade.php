@extends('admin.layout.main')
@section('title', env('APP_NAME') . ' | Quote')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

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
<div class="row justify-content-center">
    <div class="col-lg-11 mb-4">
        <form method="POST" action="" enctype="multipart/form-data">
            @csrf
            <div class="container mt-4">
                <div class="profile-header">
                    <div class="row p-4 align-items-center">
                        <div class="col-md-3 d-flex flex-column align-items-center">
                            @if (!empty($user->profile_image) && File::exists(public_path('storage/ProfileImage/' . $user->profile_image)))
                            <img style="height: 82px; width: 82px; object-fit: cover; border-radius:50%"
                                src="{{ asset('storage/ProfileImage/' . $user->profile_image) }}" alt="">
                            @else
                            <img style="height: 82px; width: 82px; object-fit: cover; border-radius:50%"
                                src="{{ asset('noimg.png') }}" alt="">
                            @endif

                        </div>

                        <div class="col-md-6 text-center">

                            <h2 style="font-weight: bold;">{{ $user->name }}</h2>
                            {{-- <p>{{ $user->username }}</p> --}}
                        </div>
                    </div>
                </div>

                <div class="profile-info mb-4">
                    <h4 class="mb-4" style="font-weight: bold">Client Information</h4>


                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">User Name</label>
                            <input type="text" class="form-control" value="{{ $user->username }}" readonly>
                        </div>

                        <div class="col-md-6">
                            @php $exp_name = explode(' ', $user->name); @endphp
                            <label class="form-label">Full Name</label>
                            <input type="text" name="username" class="form-control" value="{{$user->first_name}}" readonly>
                        </div>

                    </div>


                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control" value="{{ $user->phone ?? 'NA' }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email ID</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Country</label>
                            <input type="text" name="country" class="form-control" value="{{ $user->country ?? 'NA' }}" readonly>

                        </div>

                        <div class="col-md-6">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control" value="{{ $user->city ?? 'NA' }}" readonly>

                        </div>
                    </div>



                    <div class="row mb-3">

                        <div class="col-md-6">
                            <label class="form-label">State / Province</label>
                            <input type="text" name="state" class="form-control" value="{{ $user->state ?? 'NA' }}" readonly>

                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Zip / Postal Code</label>
                            <input type="text" name="zipcode" class="form-control" value="{{ $user->zipcode ?? 'NA' }}" readonly>

                        </div>
                    </div>



                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Date of Birth</label>
                            <input type="text" name="dob" class="form-control"
                                value="{{ $user->dob ? \Carbon\Carbon::parse($user->dob)->format('d-m-Y') : 'NA' }}"
                                readonly>



                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Sex</label>
                            <input type="text" name="sex" class="form-control" value="{{ $user->sex ?? 'NA' }}" readonly>


                        </div>


                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Lead Source</label>
                            <input type="text" class="form-control" value="{{ $user->lead_source ?? 'NA' }}"
                                readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Other Lead Source</label>
                            <input type="text" class="form-control" value="{{ $user->other_lead_source ?? 'NA' }}"
                                readonly>
                        </div>
                    </div>




                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Address 1</label>

                            <textarea name="address" id="address" rows="3" class="form-control" readonly>{{ $user->address ?? 'NA' }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Address 2</label>
                            <textarea name="address2" id="address2" rows="3" class="form-control" readonly>{{ $user->address2 ?? 'NA' }}</textarea>

                        </div>
                    </div>

                </div>

            </div>
    </div>
    </form>
</div>

</div>


<style>
    select.form-control:not([size]):not([multiple]) {
        height: calc(2.25rem + 2px);
    }

    .form-control {
        height: 42px !important;
        border-radius: 0px;
        box-shadow: none !important;
        border-color: #e7e7e7;
        font-family: 'Roboto', sans-serif;
        font-size: 14px;
    }
</style>
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
                        body: JSON.stringify({
                            ids: selectedIds
                        })
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script>
    $(function() {
        $('.datepicker').datetimepicker({
            "allowInputToggle": true,
            "showClose": true,
            "showClear": true,
            "showTodayButton": true,
            "format": "MM/DD/YYYY",
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