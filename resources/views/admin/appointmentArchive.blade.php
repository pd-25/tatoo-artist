@extends('admin.layout.main')
@section('title', env('APP_NAME').' | Quote'  )
@section('content')
<style>
    .myClass{
        width:500px;
        height: 500px;
        border: solid;
    }
    .ajax-loader {
        visibility: hidden;
        background-color: rgba(255,255,255,0.7);
        position: absolute;
        z-index: +100 !important;
        width: 100%;
        height:100%;
    }

    .ajax-loader img {
        position: relative;
        top:50%;
        left:50%;
    }
</style>
    <div class="row justify-content-center">

        <div class="col-lg-11">
            <div class="card">
                <div class="card-title pr">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>All Appointments Archives</h4>
                        </div>
                        <div class="d-flex align-items-center">
                            <a href="{{route('admin.getAppointment')}}" class="btn btn-primary m-1">Back</a>
                            
                        </div>
                    </div>
                    <div id="alert-container"></div>
                    @if (Session::has('msg'))
                        <p class="alert alert-info">{{ Session::get('msg') }}</p>
                    @endif
                </div>
                {{-- <div class="card-title text-right">
                    <a href="{{ route('artworks.create') }}" class="btn btn-sm btn-success">Add Comment</a>

                </div> --}}
                <div class="ajax-loader">
                    <img src="https://i.stack.imgur.com/MnyxU.gif" class="img-responsive" />
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table student-data-table m-t-20">
                            <thead style="text-align: center;">
                                <tr>
                                    {{-- <th><input type="checkbox" id="selectAll"></th> --}}
                                    <th>SN.</th>
                                    <th>User Name</th>
                                    <th>User Email</th>
                                    <th>User Contact</th>
                                    <th>Artist Name</th>
                                    <th>Appointment Details</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody style="text-align: center;">
                                <?php
                                  if(count($appointments)>0): 
                                    foreach ($appointments as $index => $appointment):

                                        $availability = date('jS F, Y', strtotime($appointment->availability));
                                        $appo_created_at = date('jS F, Y', strtotime($appointment->created_at));

                                        // Format quote description
                                        $escapedMessage = htmlspecialchars($appointment->message, ENT_QUOTES, 'UTF-8');

                                        $formattedPhoneNumber = sprintf("(%s) %s-%s",
                                                                    substr(@$appointment->user->phone, 0, 3),
                                                                    substr(@$appointment->user->phone, 3, 3),
                                                                    substr(@$appointment->user->phone, 6, 4)
                                                                );
                                  
                                ?>    

                                        <tr>
                                            {{-- <td><input type="checkbox" class="quoteCheckbox" value="{{ $appointment->id }}"></td> --}}
                                            <td><?=$index+1?></td>
                                            <td> {{ $appointment->user->name ?? 'No name available' }}</td>

                                            <td>  {{ $appointment->user->email ?? 'No name available' }}</td>

                                            <td>{{ $formattedPhoneNumber ?? 'No name available' }}</td>

                                            <td>{{ $appointment->artist->name ?? 'No name available' }} </td>

                                            <td> 
                                                <button class="btn btn-sm btn-primary viewAppointmentDetails" data-availability="{{$availability}}" data-created ="{{$appo_created_at}}" data-msg="{{$escapedMessage}}" data-username="{{$appointment->user->name}}" data-email="{{$appointment->user->email}}" data-phone="{{$formattedPhoneNumber}}" data-artist="{{$appointment->artist->name}}" data-availability="{{$availability}}" data-created ="{{$appo_created_at}}" data-msg="{{$escapedMessage}}">View Quote Details</button>
                                            </td>

                                            <td style="text-align: center;"> 
                                                <form method="POST" action="{{ route('appointment.delete', encrypt($appointment->id)) }}" class="action-icon">
                                                    @csrf
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button type="submit"
                                                        class="btn btn-sm btn-danger  delete-icon show_confirm"
                                                        data-toggle="tooltip" title='Delete'>
                                                        <i class="ti-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" style="text-align: center;">
                                            <b>No record is found at this moment!</b>
                                        </td>
                                    </tr>    
                                <?php endif; ?>      
                            </tbody>
                        </table>
                        {{$appointments->links()}}
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal window div-->
    <div class="modal fade show" id="viewAppointmentModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel">Appointment Details</h4>
            </div>
            <div class="modal-body">
    
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                <h6><i class="fa fa-clone"></i> Other Informations</h6>
                <div class="table-responsive pt-2">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Customer Name</th>
                            <td width="2%">:</td>
                            <td id="appo_username">Not Provided</td>
                        </tr>
                        <tr>
                            <th width="30%">Phone Number</th>
                            <td width="2%">:</td>
                            <td id="appo_phone">Not Provided</td>
                        </tr>
                        <tr>
                            <th width="30%">Email</th>
                            <td width="2%">:</td>
                            <td id="appo_email">Not Provided</td>
                        <tr>
                            <th width="30%">Artist Name</th>
                            <td width="2%">:</td>
                            <td id="appo_artist">Not Provided</td>  
                        </tr>

                        <tr>
                            <th width="30%">Availability</th>
                            <td width="2%">:</td>
                            <td id="appo_availability">Not Provided</td>
                        </tr>
                        <tr>
                            <th width="30%">Appointment Created On</th>
                            <td width="2%">:</td>
                            <td id="appo_created">Not Provided</td>
                        </tr>
                    </table>
                </div>
                </div>
            </div>
    
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                <h6><i class="fa fa-clone pr-1"></i>Message</h6>
                <div class="appo-desc" id="appointment_message">
                </div>
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
@endsection

@section('script')
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
                fetch("{{ route('appoinment.moveToArchives') }}", {
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
    <script>

        $(document).on("click",".viewAppointmentDetails",function(){
            let username = $(this).data('username');
            let phone = $(this).data('phone');
            let email = $(this).data('email');
            let artist = $(this).data('artist');
            let availability = $(this).data('availability');
            let created = $(this).data('created');
            let appointment_message = $(this).data('msg');

            //console.log(message);
            $("#appo_username").text(username);
            $("#appo_phone").text(phone);
            $("#appo_email").text(email);
            $("#appo_artist").text(artist);

            $("#appo_availability").text(availability);
            $("#appo_created").text(created);
            $("#appointment_message").html(appointment_message);

            $("#viewAppointmentModal").modal('show');
        });
    </script>
@endsection
