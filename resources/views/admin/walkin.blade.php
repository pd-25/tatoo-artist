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

        .card-css {
            margin-top: 14%;
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
                        <div class="col-md-1">
                            <button class="btn btn-md btn-success" type="button" onclick="Sendlink()">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function Sendlink() {
            const inputEmail = document.getElementById("inputEmail").value;
            $.ajax({
                type: "POST",
                url: "{{ route('admin.SendLink') }}",
                data: {
                    'type': 'walkin',
                    'email': inputEmail,
                    'artistid': "{{ auth()->guard('artists')->user()->id }}",
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
