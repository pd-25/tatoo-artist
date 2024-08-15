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
                <div class="card-title text-right">
                    <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#createQuoteModal">Create Quote</a>
                </div>
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
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody style="text-align: center;">
                                @if(count($quotes) > 0)
                                    @foreach ($quotes as $index => $quote)
                                        @php
                                            $availability = date('jS F, Y', strtotime($quote->availability));
                                            $quote_created_at = date('jS F, Y', strtotime($quote->created_at));
                                            $escapedDescription = htmlspecialchars($quote->description, ENT_QUOTES, 'UTF-8');
                                            $formattedPhoneNumber = sprintf("(%s) %s-%s",
                                                substr(@$quote->user->phone, 0, 3),
                                                substr(@$quote->user->phone, 3, 3),
                                                substr(@$quote->user->phone, 6, 4)
                                            );
                                        @endphp

                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ @$quote->user->name }}</td>
                                            <td>{{ @$quote->user->email }}</td>
                                            <td>{{ @$formattedPhoneNumber }}</td>
                                            <td>{{ @$quote->artist->name }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-info toggle-actions mb-1">Show Actions</button>
                                                <div class="quote-actions" style="display: none;">
                                                    <a href="{{ asset('storage/quoteImage/' . $quote->reference_image) }}" class="btn btn-sm btn-success" target="_blank">View Image</a><br>
                                                    <button class="btn btn-sm btn-primary viewQuoteDetails"
                                                        data-size="{{ $quote->size }}" data-color="{{ $quote->color }}"
                                                        data-whtogttato="{{ $quote->when_get_tattooed }}"
                                                        data-budget="{{ $quote->budget }}" data-availability="{{ $availability }}"
                                                        data-fbv="{{ $quote->front_back_view }}"
                                                        data-created ="{{ $quote_created_at }}"
                                                        data-desc="{{ $escapedDescription }}">View Quote Details</button><br>
                                                    @if ($quote->link_send_status == 0)
                                                        <button class="btn btn-sm btn-primary" onclick="Sendlink({{ $quote->user_id }},{{ $quote->artist_id }},{{ $quote->id }})">Send Link</button>
                                                    @elseif($quote->link_send_status == 1)
                                                        <button class="btn btn-sm btn-warning" onclick="Sendlink({{ $quote->user_id }},{{ $quote->artist_id }},{{ $quote->id }})">Again Send Link</button>
                                                    @else
                                                        <a href="{{ $quote->pdf_path }}" class="btn btn-sm btn-success" target="_blank">View Link</a>
                                                    @endif
                                                    <form method="POST" action="{{ route('quote.delete', encrypt($quote->id)) }}" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger delete-icon show_confirm" data-toggle="tooltip" title="Delete">
                                                            <i class="ti-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
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
    <div class="modal fade" id="createQuoteModal" tabindex="-1" role="dialog" aria-labelledby="createQuoteModalLabel" aria-hidden="true">
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
                                    <input type="text" class="form-control" value="{{ Auth::guard('artists')->user()->name }}" readonly>
                                    <input type="hidden" name="artist_id" value="{{ Auth::guard('artists')->user()->id }}">
                                @else
                                    <select name="artist_id" class="form-control" id="artist_id">
                                        <option value="">Select Artist</option>
                                        @foreach($artists as $user)
                                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label for="user_id" class="col-form-label">User ID</label>
                                <select name="user_id" class="form-control" id="user_id">
                                    <option value="">Select User</option>
                                    @foreach($customers as $user)
                                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
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
