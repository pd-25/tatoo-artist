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
                    <h4>All Quotes</h4>
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
                                    <th>SN.</th>
                                    <th>User Name</th>
                                    <th>User Email</th>
                                    <th>User Contact</th>
                                    <th>Artist Name</th>
                                    <th>View Appointment Details</th>
                                    <th>Delete Appointment</th>
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
                                            <td><?=$index+1?></td>
                                            <td> {{ $appointment->user->name }}</td>

                                            <td>  {{ $appointment->user->email }}</td>

                                            <td>{{ $formattedPhoneNumber }}</td>

                                            <td>{{ $appointment->artist->name }} </td>

                                            <td> 
                                                <button class="btn btn-sm btn-primary viewAppointmentDetails" data-availability="{{$availability}}" data-created ="{{$appo_created_at}}" data-msg="{{$escapedMessage}}">View Quote Details</button>
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

        $(document).on("click",".viewAppointmentDetails",function(){
            let availability = $(this).data('availability');
            let created = $(this).data('created');
            let appointment_message = $(this).data('msg');

            //console.log(message);

            $("#appo_availability").text(availability);
            $("#appo_created").text(created);
            $("#appointment_message").html(appointment_message);

            $("#viewAppointmentModal").modal('show');
        });
    </script>
@endsection
