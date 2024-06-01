<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- theme meta -->
    <meta name="theme-name" content="focus" />
    <title>@yield('title')</title>
    <!-- ================= Favicon ================== -->
    <!-- Standard -->
    <link rel="shortcut icon" href="http://placehold.it/64.png/000/fff">
    <!-- Retina iPad Touch Icon-->
    <link rel="apple-touch-icon" sizes="144x144" href="http://placehold.it/144.png/000/fff">
    <!-- Retina iPhone Touch Icon-->
    <link rel="apple-touch-icon" sizes="114x114" href="http://placehold.it/114.png/000/fff">
    <!-- Standard iPad Touch Icon-->
    <link rel="apple-touch-icon" sizes="72x72" href="http://placehold.it/72.png/000/fff">
    <!-- Standard iPhone Touch Icon-->
    <link rel="apple-touch-icon" sizes="57x57" href="http://placehold.it/57.png/000/fff">
    <!-- Styles -->

    <link href="{{ asset('admin-asset/css/lib/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin-asset/css/lib/themify-icons.css') }}" rel="stylesheet">

    <link href="{{ asset('admin-asset/css/lib/menubar/sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('admin-asset/css/lib/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('admin-asset/css/style.css') }}" rel="stylesheet">
</head>

<body>

    <div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
        <div class="nano">
            <div class="nano-content">
                <ul>
                    <div class="logo">
                        <a href="#"> <span>{{ env('APP_NAME') }}</span></a>
                    </div>

                    <li><a href="{{ route('artists.dashboard') }}"><i class="ti-desktop"></i>Dashboard </a></li>

                    @if (Auth::guard('artists')->check())
                        <li><a href="{{ route('artists.profile') }}"><i class="ti-user"></i>Profile </a></li>
                    @else

                        <li><a class="sidebar-sub-toggle"><i class="ti-bar-chart-alt"></i> Artist Management <span
                                    class="sidebar-collapse-icon ti-angle-down"></span></a>
                            <ul>
                                <li><a href="{{ route('artists.create') }}">Add Artist</a></li>

                                <li><a href="{{ route('artists.index') }}">All Artists</a>
                                </li>
                            </ul>
                        </li>
                    @endif


                    <li><a class="sidebar-sub-toggle"><i class="ti-bar-chart-alt"></i> Artwork Management <span
                                class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>

                            @if (Auth::guard('artists')->check())
                                <li><a href="{{ route('artists.getForm') }}">Add Artwork</a></li>

                                <li><a href="{{ route('artists.getArtistWiseArtwork') }}">My Artworks</a>
                                <li><a href="{{ route('admin.allComment') }}">All Comments</a>
                                </li>
                            @else
                                <li><a href="{{ route('artworks.create') }}">Add Artwork</a></li>

                                <li><a href="{{ route('artworks.index') }}">All Artworks</a>
                                <li><a href="{{ route('admin.allComment') }}">All Comments</a>
                                </li>
                            @endif
                        </ul>
                    </li>

                    <li><a class="sidebar-sub-toggle"><i class="ti-bar-chart-alt"></i> Banner Management <span
                                class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>
                            @if (Auth::guard('artists')->check())
                                <li><a href="{{ route('artists.bgetForm') }}">Add Banner</a></li>

                                <li><a href="{{ route('artists.getArtistWiseBanner') }}">My Banners</a>
                                </li>
                            @else
                                <li><a href="{{ route('banners.create') }}">Add Banner</a></li>

                                <li><a href="{{ route('banners.index') }}">All Banners</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                    <li><a href="{{ route('admin.getQuote') }}"><i class="ti-calendar"></i>Quote </a></li>
                    <li><a href="{{ route('admin.getAppointment') }}"><i class="ti-calendar"></i>Appointment </a></li>
                    <li><a href="{{ route('admin.deposit-slips') }}"><i class="ti-calendar"></i>Deposit Slips </a></li>
                    <li><a href="{{ route('admin.getAcceptPayment') }}"><i class="ti-credit-card"></i>Accept Payment</a></li>
                    <li><a href="{{ route('admin.getExpenses') }}"><i class="ti-money"></i>Expenses</a></li>
                    {{-- <li><a class="sidebar-sub-toggle"><i class="ti-bar-chart-alt"></i> Order Management <span
                                class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>
                            <li><a href="#">All Orders</a></li>
                            <li><a href="#">New Orders</a></li>
                            <li><a href="#">Completed Orders</a></li>


                        </ul>
                    </li> --}}




                    <li><a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();"><i
                                class="ti-close"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /# sidebar -->

    <div class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="float-left">
                        <div class="hamburger sidebar-toggle">
                            <span class="line"></span>
                            <span class="line"></span>
                            <span class="line"></span>
                        </div>
                    </div>
                    <div class="float-right">
                        <div class="dropdown dib">

                            <div class="header-icon dropdown">

                                <span class="user-avatar" data-toggle="dropdown"
                                    aria-expanded="false">{{ Auth::guard('artists')->check() ? Auth::guard('artists')->user()->name : auth()->user()->full_name }}
                                    <i class="ti-angle-down f-s-10"></i>
                                </span>
                                <div class="dropdown-menu dropdown-content-body">
                                    <div class="">
                                        <ul>

                                            <li>
                                                <a href="{{ route('logout') }}"
                                                    onclick="event.preventDefault();
                                                              document.getElementById('logout-form').submit();">
                                                    <i class="ti-power-off"></i>
                                                    <span>Logout</span>
                                                </a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                    class="d-none">
                                                    @csrf
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="content-wrap">
        <div class="main">
            @yield('content')
        </div>
    </div>

    <!-- jquery vendor -->
    <script src="{{ asset('admin-asset/js/lib/jquery.min.js') }}"></script>
    <script src="{{ asset('admin-asset/js/lib/jquery.nanoscroller.min.js') }}"></script>
    <!-- nano scroller -->
    <script src="{{ asset('admin-asset/js/lib/menubar/sidebar.js') }}"></script>
    <script src="{{ asset('admin-asset/js/lib/preloader/pace.min.js') }}"></script>
    <!-- sidebar -->

    <script src="{{ asset('admin-asset/js/lib/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin-asset/js/scripts.js') }}"></script>
    <!-- bootstrap -->
    <script src="{{ asset('admin-asset/js/lib/data-table/datatables.min.js') }}"></script>
    <script src="{{ asset('admin-asset/js/lib/data-table/datatables-init.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- scripit init-->
    {{-- <script src="{{ asset('admin-asset/js/dashboard2.js') }}"></script> --}}
    @yield('script')
    <script>
        $('.show_confirm').click(function(event) {

            var form = $(this).closest("form");

            var name = $(this).data("name");

            //  alert(form);

            event.preventDefault();

            swal({

                    title: `Are you sure you want to delete this data?`,

                    text: "If you delete this, it will be gone forever.",

                    icon: "warning",

                    buttons: true,
                    dangerMode: true,

                })

                .then((willDelete) => {

                    if (willDelete) {

                        form.submit();

                    } else {

                        swal("Your data file is safe!");

                    }

                });

        });
    </script>
</body>

</html>
