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
            <div class="card-title pr ">
                <div class="d-flex justify-content-between">
                    <div>
                <h4>All Walkin Archives</h4>
                    </div>
                <div class="d-flex align-items-center">
                <a href="{{route('artists.getWalkIn')}}" class="btn btn-primary m-1">Back</a>
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
                                
                                <th>User Email</th>
                                
                                <th>Artist Name</th>
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
                                            {{-- <td>{{ @$quote->user->name }}</td> --}}
                                            <td>{{ @$quote->user->email }}</td>
                                            {{-- <td>{{ @$formattedPhoneNumber }}</td> --}}
                                            <td>{{ @$quote->artist->name }}</td>
                                            <td>
                                                @if ($quote->link_send_status == 0)
                                                <button class="btn btn-sm btn-primary"
                                                    onclick="Sendlink({{ $quote->user_id }},{{ $quote->artist_id }},{{ $quote->id }})">Send
                                                    Link</button>
                                            @elseif($quote->link_send_status == 1)
                                                <button class="btn btn-sm btn-warning"
                                                    onclick="AgainSendlink({{ $quote->user_id }},{{ $quote->artist_id }},{{ $quote->id }})">Again
                                                    Send Link</button>
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






@endsection


