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
                                    <th>Reference Image</th>
                                    <th>View Quote Details</th>
                                    <th>Send Link</th>
                                    <th>Delete Quote</th>
                                </tr>
                            </thead>
                            <tbody style="text-align: center;">
                                <?php 
                                  if(count($quotes)>0):
                                    foreach ($quotes as $index => $quote):

                                        $availability = date('jS F, Y', strtotime($quote->availability));
                                        $quote_created_at = date('jS F, Y', strtotime($quote->created_at));

                                        // Format quote description
                                        $escapedDescription = htmlspecialchars($quote->description, ENT_QUOTES, 'UTF-8');

                                        $formattedPhoneNumber = sprintf("(%s) %s-%s",
                                                                    substr(@$quote->user->phone, 0, 3),
                                                                    substr(@$quote->user->phone, 3, 3),
                                                                    substr(@$quote->user->phone, 6, 4)
                                                                );
                                  
                                ?>

                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td> {{ @$quote->user->name }}</td>

                                        <td> {{ @$quote->user->email }}</td>

                                        <td>{{ @$formattedPhoneNumber }}</td>

                                        <td>{{ @$quote->artist->name }} </td>

                                        <td>
                                            @if (!empty($quote->reference_image))
                                                <a href="{{ asset('storage/quoteImage/' . $quote->reference_image) }}"
                                                    class="btn btn-sm btn-success" target="_blank">View Link</a>
                                            @else
                                                <button class="btn btn-sm btn-danger" readonly>No image provided!</button>
                                            @endif
                                        </td>

                                        {{-- <td><span id="status-btn{{ $comment->id }}">
                                                <button class="btn btn-sm {{ $comment->status == 'Available' ? 'btn-success' : ($comment->status == 'Inactive' ? 'bg-danger' : 'bg-warning'); }}"  onclick="changeStatus('{{ $comment->id }}', {{ $comment->id}})" >
                                                    {{ $comment->status }}
                                                </button>
                                            </span>
                                            </td> --}}
                                        <td>
                                            <button class="btn btn-sm btn-primary viewQuoteDetails"
                                                data-size="{{ $quote->size }}" data-color="{{ $quote->color }}"
                                                data-whtogttato={{ $quote->when_get_tattooed }}
                                                data-budget="{{ $quote->budget }}" data-availability="{{ $availability }}"
                                                data-fbv="{{ $quote->front_back_view }}"
                                                data-created ="{{ $quote_created_at }}"
                                                data-desc="{{ $escapedDescription }}">View Quote Details</button>
                                        </td>

                                        <td>
                                            {{-- <a href="{{ route('admin.SendLink',[$quote->user_id]) }}" class="btn btn-sm btn-primary">SendLink</a> --}}
                                            @if ($quote->link_send_status == 0)
                                                <button class="btn btn-sm btn-primary" id=""
                                                    onclick="Sendlink({{ $quote->user_id }},{{ $quote->artist_id }},{{ $quote->id }})">SendLink</button>
                                            @elseif($quote->link_send_status == 1)
                                                <button class="btn btn-sm btn-warning" readonly>waiting for a user form
                                                    submit</button>
                                            @else
                                                <a href="{{ $quote->pdf_path }}" class="btn btn-sm btn-success"
                                                    target="_blank">View Link</a>
                                            @endif
                                        </td>

                                        <td>
                                            <form method="POST" action="{{ route('quote.delete', encrypt($quote->id)) }}"
                                                class="action-icon">
                                                @csrf
                                                <input name="_method" type="hidden" value="DELETE">
                                                <button type="submit" class="btn btn-sm btn-danger  delete-icon show_confirm"
                                                    data-toggle="tooltip" title='Delete'>
                                                    <i class="ti-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>

                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" style="text-align: center;">
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
                            <div class="quote-desc" id="quote_description">
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
        function Sendlink(userid, artistid, dbid) {

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
                    //alert(result); return false;
                    if (result == "emailsend") {
                        //swal('Email sent successfully.');
                        swal({
                            title: 'Email sent successfully.',
                            target: ".myClass"
                        });
                        location.reload();
                    } else {
                        swal('Some Error occur, relode the page');
                    }
                }
            });
        }

        function changeStatus(slug, id) {
            $.ajax({
                type: "POST",
                url: "#",
                data: {
                    'service_slug': slug,
                    '_token': '{{ csrf_token() }}'
                },
                dataType: "JSON",
                success: function(response) {
                    if (response.status) {
                        $("#status-btn" + id).load(window.location.href + " #status-btn" + id);
                        swal('Status updated');
                    } else {
                        swal('Some Error occur, relode the page');
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

            //console.log(description);

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
    </script>
@endsection
