@extends('admin.layout.main')
@section('title', env('APP_NAME') . ' | User Profile')
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
        <div class="d-flex mt-3">
            <form method="GET" action="" id="userSelectForm" class="w-100">
                <select name="user_id" class="form-control" style="color: black; font-size: 1.5rem; font-weight: 500;" onchange="if(this.value) window.location.href=this.value;">
                    <option value="" selected>Select to view customers</option>
                    @foreach ($users as $u)
                    <option
                        value="{{ route('artists.view-user-details', $u->id) }}"
                        @if($u->id == $user->id) @endif>
                        {{ $u->name }} ({{ $u->email }})
                    </option>
                    @endforeach
                </select>
            </form>


        </div>
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
                            <p style="font-weight: 500; font-size: 1.42rem;">Converted as customer: {{ \Carbon\Carbon::parse($user->coverted_date)->format('m-d-Y') }}</p>
                            {{-- <p>{{ $user->username }}</p> --}}
                        </div>
                    </div>
                </div>

                <div class="profile-info mb-4">
                    <h4 class="mb-4" style="font-weight: bold">Client Information</h4>


                    <div class="row mb-3">

                        @php
                        $exp_name = explode(' ', $user->name, 2);
                        $first_name = $exp_name[0] ?? '';
                        $last_name = $exp_name[1] ?? '';
                        @endphp

                        <div class="col-md-4">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" class="form-control" value="{{ $first_name }}" readonly>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" class="form-control" value="{{ $last_name }}" readonly>
                        </div>


                        {{-- <div class="col-md-4">
                            <label class="form-label">User Name</label>
                            <input type="text" class="form-control" value="{{ $user->username }}" readonly>
                    </div> --}}

                </div>


                <div class="row mb-3">
                    @php
                    $formattedPhone = $user->phone
                    ? preg_replace("/(\d{3})(\d{3})(\d{4})/", "($1) $2-$3", preg_replace('/\D/', '', $user->phone))
                    : 'NA';
                    @endphp

                    <div class="col-md-6">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control" value="{{ $formattedPhone }}" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email ID</label>
                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" readonly>
                    </div>
                </div>

                <!-- <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Country</label>
                        <input type="text" name="country" class="form-control" value="{{ $user->country ?? 'NA' }}" readonly>

                    </div>

                    <div class="col-md-6">
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-control" value="{{ $user->city ?? 'NA' }}" readonly>

                    </div>
                </div> -->



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
                            value="{{ $user->dob ? \Carbon\Carbon::parse($user->dob)->format('m-d-Y') : 'NA' }}"
                            readonly>



                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Sex</label>
                        <input type="text" name="sex" class="form-control" value="{{ $user->sex ?? 'NA' }}" readonly>


                    </div>


                </div>

                <div class="row mb-3">
                    <!-- <div class="col-md-12">
                        <label class="form-label">Lead Source</label>
                        <input type="text" class="form-control" value="{{ $user->leadSource->lead_source_name ?? 'NA' }}"
                            readonly>
                    </div> -->

                    <!-- <div class="col-md-6">
                            <label class="form-label">Other Lead Source</label>
                            <input type="text" class="form-control" value="{{ $user->other_lead_source ?? 'NA' }}"
                                readonly>
                        </div> -->
                </div>




                <div class="row mb-3">
                    <div class="col-md-12">
                        <form action="{{ route('artist.user-note.update', $user->id) }}" method="POST" encript="multipart/form-data">
                            <label class="form-label" for="note">Note</label>
                            @csrf
                            <textarea id="note" name="note" rows="7" class="form-control">{{ old('note', $user->note) }}</textarea>
                            <button type="submit" class="btn btn-primary mt-3">Update Note</button>
                        </form>
                    </div>
                    
                        <!-- <div class="col-md-6">
                            <label class="form-label">Address 2</label>
                            <textarea name="address2" id="address2" rows="3" class="form-control" readonly>{/{ $user->address2 ?? 'NA' }}</textarea>

                        </div> -->
                </div>

                @push('scripts')
                <script>
                    function updateUserNote() {
                        var note = document.getElementById("address").value;
                        var userId = {{ $user->id }};

                        fetch(`/edit-user-note/${userId}`, {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({ note: note })
                        })
                        .then(response => {
                            if (response.ok) {
                                alert("Note updated successfully.");
                            } else {
                                alert("Failed to update note.");
                            }
                        });
                    }
                </script>
                @endpush

                <div class="row mb-3">
                    <div class="col-md-12">
                        <h4 class="mb-4" style="font-weight: bold">Payment Information</h4>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Date</th>
                                    <th>Price</th>
                                    <th>Paid</th>
                                    <th>Total Due</th>
                                    <th>Tips</th>
                                    <th>CC Fees</th>
                                    <th>Payment Method</th>
                                    <th>Shop Percentage</th>
                                    <th>Artist Percentage</th>
                                    <th>Design</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($depositeDetails as $payment)
                                <tr>
                                    <td>#{{ $loop->iteration }}</td>
                                    <td>{{ $payment->date ? \Carbon\Carbon::parse($payment->date)->format('m-d-Y') : 'NA' }}</td>
                                    <td>${{ number_format($payment->price, 2) }}</td>
                                    <td>${{ number_format($payment->deposit_total, 2) }}</td>
                                    <td>${{ number_format($payment->total_due, 2) }}</td>
                                    <td>${{ number_format($payment->tips, 2) }}</td>
                                    <td>${{ number_format($payment->fees, 2) }}</td>
                                    <td style="text-transform: capitalize;">{{ $payment->payment_method ?? 'NA' }}</td>
                                    <td>
                                        ${{ $payment->shop_percentage}}
                                    </td>
                                    <td>
                                        ${{ $payment->artist_percentage}}
                                    </td>
                                    <td>{{ $payment->design ?? 'NA' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="11" class="text-center text-muted">No payments done yet.</td>
                                </tr>
                                @endforelse

                            </tbody>

                            <tfoot>
                                <tr>
                                    <th colspan="2" style="text-align: right;">Total:</th>
                                    <th>${{ $depositeDetails->sum('price') }}</th>
                                    <th>${{ $depositeDetails->sum('deposit_total') }}</th>
                                    <th>${{ $depositeDetails->sum('total_due') }}</th>
                                    <th>${{ $depositeDetails->sum('tips') }}</th>
                                    <th>${{ $depositeDetails->sum('fees') }}</th>
                                    <th></th>
                                    <th>${{ $depositeDetails->sum('shop_percentage') }}</th>
                                    <th>${{ $depositeDetails->sum('artist_percentage') }}</th>
                                    <th></th>
                                </tr>
                            </tfoot>

                            
                        </table>
                    </div>
                </div>


                <div class="row mb-3">
                    <div class="col-md-12">
                        <h4 class="mb-4" style="font-weight: bold">Medical History</h4>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Date</th>
                                    <th>Form</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($medicalForms as $form)
                                <tr>
                                    <td>#{{ $loop->iteration }}</td>
                                    <td>{{ $form->todaysdate ? \Carbon\Carbon::parse($form->todaysdate)->format('m-d-Y') : 'NA' }}</td>
                                    <td>
                                        <a href="{{ route('artists.view-user-medical-details', $form->id) }}" target="_blank" class="btn btn-primary">PDF</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">No medical forms found.</td>
                                </tr>
                                @endforelse

                            </tbody>
                        </table>
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