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
                        <a href="#"><span>{{ Auth::guard('admins')->check() ? "Admin Panel" :  (Auth::guard('artists')->check() ? "Artists Panel" : "Sales Panel") }}</span></a>
                    </div>

                    @if (Auth::guard('admins')->check() || Auth::guard('sales')->check()) 
                        <li><a href="{{ route('admin.dashboard') }}"><i class="ti-desktop"></i>Dashboard </a></li>
                    @elseif (Auth::guard('artists')->check())
                        <li><a href="{{ route('artists.dashboard') }}"><i class="ti-desktop"></i>Dashboard </a></li> 
                       
                        @else
                        <li><a href="{{ route('admin.dashboard') }}"><i class="ti-desktop"></i>Dashboard </a></li> 

                    @endif       

                    @if (Auth::guard('artists')->check())
                    <li><a href="{{ route('admin.customers') }}"><i class="ti-desktop"></i>Customers </a></li>
                    <li><a href="{{ route('artists.getWalkIn') }}"><i class="ti-desktop"></i>Walk In </a></li>

                    
                        <li><a href="{{ route('artists.profile') }}"><i class="ti-user"></i>Profile </a></li>
                        <li><a href="{{ url('/user/artist-profile#profileHours') }}"><i class="ti-time"></i>Hours </a></li>
                    @else
                       
                            <li><a href="{{ route('admin.customers') }}"><i class="ti-desktop"></i>Customers </a></li>
                       

                        <li><a class="sidebar-sub-toggle"><i class="ti-bar-chart-alt"></i> Artist Management <span
                                    class="sidebar-collapse-icon ti-angle-down"></span></a>
                            <ul>
                                <li><a href="{{ route('artists.create') }}">Add Artist</a></li>

                                <li><a href="{{ route('artists.index') }}">All Artists</a>
                                </li>
                            </ul>
                        </li>
                        
                        @if (Auth::guard('admins')->check())
                            <li><a class="sidebar-sub-toggle"><i class="ti-bar-chart-alt"></i> Sales Management <span
                                class="sidebar-collapse-icon ti-angle-down"></span></a>
                                <ul>
                                    <li><a href="{{ route('sales.create') }}">Add Sales Person</a></li>

                                    <li><a href="{{ route('sales.index') }}">All Sales Person</a>
                                    </li>
                                </ul>
                            </li>
                        @endif    
                    @endif

                    @if (Auth::guard('artists')->check())
                        <li><a href="{{ route('artists.getForm') }}"><i class="ti-upload"></i> Upload Artwork</a></li>
                        <li><a href="{{ route('artists.getArtistWiseArtwork') }}"><i class="ti-image"></i> Modify Art</a>
                    @else
                        <li><a class="sidebar-sub-toggle"><i class="ti-bar-chart-alt"></i> Artwork Management <span
                        class="sidebar-collapse-icon ti-angle-down"></span></a>
                            <ul>
                                <li><a href="{{ route('artworks.create') }}">Add Artwork</a></li>

                                <li><a href="{{ route('artworks.index') }}">All Artworks</a>
                                <li><a href="{{ route('admin.allComment') }}">All Comments</a>
                                </li>
                            </ul> 
                        </li>       
                    @endif
                  
                    @if (Auth::guard('artists')->check())
                        <li><a href="{{ route('artists.getArtistWiseBanner') }}"><i class="ti-layout-slider"></i> Carousel </a></li>
                        <li><a href="{{ route('admin.allComment') }}"><i class="ti-comment"></i> Comments</a></li>
                        <li><a href="{{ route('artists.bgetForm') }}"><i class="ti-upload"></i> Banner</a></li>
                    @else
                            <li><a class="sidebar-sub-toggle"><i class="ti-bar-chart-alt"></i> Banner Management <span
                        class="sidebar-collapse-icon ti-angle-down"></span></a>
                            <ul>
                                <li><a href="{{ route('banners.create') }}">Add Banner</a></li>

                                <li><a href="{{ route('banners.index') }}">All Banners</a>
                                </li>
                            </ul>
                        </li>         
                    @endif
                     
                    
                    @if (Auth::guard('artists')->check() || Auth::guard('admins')->check() || Auth::guard('sales')->check())
                    <li><a href="{{ route('admin.getQuote') }}"><i class="ti-envelope"></i>Quote Form</a></li>
                     
                    <li><a href="{{ route('admin.getAppointment') }}"><i class="ti-calendar"></i>Appointment </a></li>
                    <li><a href="{{ route('admin.deposit-slips') }}"><i class="ti-calendar"></i>Deposit Slips </a></li>
                    
                    <li><a href="{{ route('admin.getAcceptPayment') }}"><i class="ti-credit-card"></i>Accept Payment</a></li>
                    <li><a href="{{ route('admin.getExpenses') }}"><i class="ti-money"></i>Manage Expenses</a></li>
                   
                    @endif
                    @if (Auth::guard('artists')->check())
                    <li><a href="{{ url('/user/artist-profile#companyLogo') }}"><i class="ti-image"></i> Comapany Logo </a></li>
 
                     @endif
                    {{-- <li><a class="sidebar-sub-toggle"><i class="ti-bar-chart-alt"></i> Order Management <span
                                class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>
                            <li><a href="#">All Orders</a></li>
                            <li><a href="#">New Orders</a></li>
                            <li><a href="#">Completed Orders</a></li>


                        </ul>
                    </li> --}}




                    <li>
                        @if(session()->has('sales_id'))
                           
                            <a href="{{ route('admin.revert.revertImpersonateforsales') }}">
                                <i class="ti-close"></i> Back To Sales Panel
                            </a>
                        @elseif(session()->has('admin_id'))
                        <a href="{{ route('admin.revert.impersonate') }}">
                            <i class="ti-close"></i> Back To Admin Panel
                        </a>
                        @else
                            <a href="{{ Auth::guard('admins')->check() ? route('admin.logout') : route('artist.logout') }}">
                                <i class="ti-close"></i> Logout
                            </a>
                        @endif
                    
                                          </li>
                    
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
                                    aria-expanded="false">{{ Auth::guard('admins')->check() ? Auth::guard('admins')->user()->name : ( Auth::guard('sales')->check() ? Auth::guard('sales')->user()->name : Auth::guard('artists')->user()->name) }}
                                    <i class="ti-angle-down f-s-10"></i>
                                </span>
                                <div class="dropdown-menu dropdown-content-body">
                                    <div class="">
                                        <ul>

                                            <li>
                                                @if(session()->has('admin_id'))
                                                    <a href="{{ route('admin.revert.impersonate') }}">
                                                        <i class="ti-close"></i> Back To Admin
                                                    </a>
                                                @else 
                                                    <a href="{{ Auth::guard('admins')->check() ? route('admin.logout') : ( Auth::guard('sales')->check() ? route('sales.logout') : route('artist.logout') ) }}">
                                                        <i class="ti-power-off"></i>
                                                        <span>Logout</span>
                                                    </a>
                                                @endif    
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
    <script src="{{ asset('admin-asset/js/lib//table-filter/filter-table.min.js') }}"></script>
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
