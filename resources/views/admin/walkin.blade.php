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
<div class="row justify-content-center">
    <div class="col-lg-11">
        <div class="card card-css">
            <div class="card-title pr">
                <h4>Send walk-in</h4>

                @if (Session::has('msg'))
                    <p class="alert alert-info">{{ Session::get('msg') }}</p>
                @endif
            </div>
            <div class="ajax-loader">
                <img src="https://i.stack.imgur.com/MnyxU.gif" class="img-responsive" />
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-11">
                        <input type="text" placeholder="abc@gmail.com" class="form-control" id="inputEmail">
                    </div>
                    @php
                        if (Auth::guard('artists')->check()) {
                            $LoggedAuthId = auth()->guard("artists")->user()->id;
                        }elseif(Auth::guard('admins')->check()){
                            $LoggedAuthId = auth()->guard("admins")->user()->id;
                        }elseif(Auth::guard('sales')->check()){
                            $LoggedAuthId = auth()->guard("sales")->user()->id;
                        }
                        
                    @endphp
                    
                    <div class="col-md-1">
                        <button class="btn btn-md btn-success" type="button" onclick="Sendlink({{ $LoggedAuthId  }})">Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



















<div class="row justify-content-center">
    <div class="col-lg-11">
        <div class="card">
            <div class="card-title pr">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>All</h4>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="{{route('artists.getWalkInArchive')}}" class="btn btn-primary m-1">Archives</a>
                        <button class="btn btn-primary m-1 d-none" id="moveToArchives">Move to Archives</button>
                    </div>
                </div>

                <div id="alert-container"></div>

                @if (Session::has('msg'))
                    <p class="alert alert-info">{{ Session::get('msg') }}</p>
                    
                @endif
            </div>

            <div class="ajax-loader">
                <img src="https://i.stack.imgur.com/MnyxU.gif" class="img-responsive" />
            </div>
            
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table student-data-table m-t-20">
                        <thead style="text-align: center;">
                            <tr>
                                <th><input type="checkbox" id="selectAll"></th>
                                <th>SN.</th>
                                <th>User Email</th>
                                <th>Artist Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center;">
                            @if (count($quotes) > 0)
                                @foreach ($quotes as $index => $quote)
                                    {{-- @if ($quote->quote_type == 1 && $quote->isarchive == 0) --}}
                                        <tr data-id="{{ $quote->id }}">
                                            <td><input type="checkbox" class="quoteCheckbox" value="{{ $quote->id }}"></td>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ @$quote->user->email }}</td>
                                            <td>{{ @$quote->artist->name }}</td>
                                            <td>
                                                @if ($quote->link_send_status == 0)
                                                    <button class="btn btn-sm btn-primary"
                                                        onclick="Sendlink({{ $quote->user_id }},{{ $quote->artist_id }},{{ $quote->id }})">Send Link</button>
                                                @elseif($quote->link_send_status == 1)
                                                    <button class="btn btn-sm btn-warning"
                                                        onclick="AgainSendlink({{ $quote->user_id }},{{ $quote->artist_id }},{{ $quote->id }})">Again Send Link</button>
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
                                            </td>
                                        </tr>
                                    {{-- @endif --}}
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
                    {{ $quotes->links() }}
                </div>
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
                    if (result == "emailsend") {
                        swal({
                            title: 'Email sent successfully.',
                            target: ".myClass"
                        });
                        location.reload();
                    } else {
                        swal('Some Error occur, reload the page');
                    }
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
                    if (result == "emailsend") {
                        swal({
                            title: 'Email sent successfully.',
                            target: ".myClass"
                        });
                        location.reload();
                    } else {
                        swal('Some Error occur, reload the page');
                    }
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
