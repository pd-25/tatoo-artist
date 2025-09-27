@extends('admin.layout.main')
@section('title', env('APP_NAME') . ' | Quote')
@section('content')
<style>
    .modal {
        z-index: 9999 !important;
    }

    .modal-backdrop {
        z-index: 9998 !important;
    }

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
            <div class="card-title pr ">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>All Quote Archives</h4>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="{{route('admin.getQuote')}}" class="btn btn-primary m-1">Back</a>
                    </div>
                </div>

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
                                <th>SN.</th>
                                <th>Full Name</th>
                                <th>User Email</th>
                                <th>Phone Number</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center;">
                            @if (count($quotes) > 0)
                            @foreach ($quotes as $index => $quote)
                            {{-- @if ($quote->quote_type == 1 && $quote->isarchive == 1) --}}
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
                                <td>{{ $index + 1 }}</td>
                                <td>{{ @$quote->user->name }}</td>
                                <td>{{ @$quote->user->email }}</td>
                                <td>{{ @$formattedPhoneNumber }}</td>
                                <!-- <td>{{ @$quote->artist->name }}</td> -->
                                <td>{{ date('m-d-Y',strtotime( $quote->created_at)) }}</td>
                                <td>
                                    @if ($quote->link_send_status == 0)
                                    <!-- <button class="btn btn-sm btn-primary"
                                                    onclick="Sendlink({{ $quote->user_id }},{{ $quote->artist_id }},{{ $quote->id }})">Send
                                                    Link</button> -->
                                    @elseif($quote->link_send_status == 1)
                                    <!-- <button class="btn btn-sm btn-warning"
                                                    onclick="AgainSendlink({{ $quote->user_id }},{{ $quote->artist_id }},{{ $quote->id }})">Again
                                                    Send Link</button> -->
                                    @else
                                    <!-- <a href="{{ $quote->pdf_path }}" class="btn btn-sm btn-success"
                                                    target="_blank">View Link</a> -->
                                    @endif

                                    <a href="{{ asset('storage/quoteImage/' . $quote->reference_image) }}"
                                            class="btn btn-sm btn-success" target="_blank">View
                                            Image</a>

                                    <button class="btn btn-sm btn-primary viewQuoteDetails"
                                        data-id="{{ $quote->id }}"
                                        data-size="{{ $quote->size }}"
                                        data-color="{{ $quote->color }}"
                                        data-whtogttato="{{ $quote->when_get_tattooed }}"
                                        data-budget="{{ $quote->budget }}"
                                        data-availability="{{ $availability }}"
                                        data-fbv="{{ $quote->front_back_view }}"
                                        data-created="{{ $quote_created_at }}"
                                        data-desc="{{ $escapedDescription }}"
                                        data-price="{{ $quote->provide_price ?? '' }}">
                                        View Quote Details
                                    </button>

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


<!-- Quote view modal -->
<!-- View Quote Details Modal -->
<div class="modal fade" id="viewQuoteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <h4 class="modal-title">Quote Details</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <h6><i class="fa fa-clone"></i> Other Information</h6>
                        <div class="table-responsive pt-2">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Size</th>
                                    <td id="quo_size">Not Provided</td>
                                </tr>
                                <tr>
                                    <th>Color</th>
                                    <td id="quo_color">Not Provided</td>
                                </tr>
                                <tr>
                                    <th>When looking to get tattooed?</th>
                                    <td id="quo_whtogttato">Not Provided</td>
                                </tr>
                                <tr>
                                    <th>Budget</th>
                                    <td id="quo_budget">Not Provided</td>
                                </tr>
                                <tr>
                                    <th>Availability</th>
                                    <td id="quo_availability">Not Provided</td>
                                </tr>
                                <tr>
                                    <th>Front/Back View</th>
                                    <td id="quo_front_back_view">Not Provided</td>
                                </tr>
                                <tr>
                                    <th>Quote Created On</th>
                                    <td id="quo_created">Not Provided</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-12">
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


@section('script')
<script>
    $(document).ready(function() {
        $(document).on("click", ".viewQuoteDetails", function() {
            let size = $(this).data('size');
            let color = $(this).data('color');
            let when_to_get_tatto = $(this).data('whtogttato');
            let budget = $(this).data('budget');
            let availability = $(this).data('availability');
            let front_back_view = $(this).data('fbv');
            let created = $(this).data('created');
            let quote_description = $(this).data('desc');

            // Fill modal data
            $("#quo_size").text(size || "Not Provided");
            $("#quo_color").text(color || "Not Provided");
            $("#quo_whtogttato").text(when_to_get_tatto || "Not Provided");
            $("#quo_budget").text(budget ? `$${budget}` : "Not Provided");
            $("#quo_availability").text(availability || "Not Provided");
            $("#quo_front_back_view").text(front_back_view || "Not Provided");
            $("#quo_created").text(created || "Not Provided");
            $("#quote_description").html(quote_description || "Not Provided");

            // Show modal
            $("#viewQuoteModal").modal('show');
        });
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

@endsection



@endsection