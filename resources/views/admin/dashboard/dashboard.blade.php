@extends('admin.layout.main')
@section('title', env('APP_NAME').' | Dashboard'  )
<style>
    .stat-widget-one .stat-digit {
    font-size: 17px !important;
    color: #373757;
}
</style>

<link href="https://canvasjs.com/assets/css/jquery-ui.1.11.2.min.css" rel="stylesheet" />
<script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer1", {
	animationEnabled: true,
	title:{
		text: "Activity"
	},	
	axisY: {
		title: "Walk In",
		titleFontColor: "#4F81BC",
		lineColor: "#4F81BC",
		labelFontColor: "#4F81BC",
		tickColor: "#4F81BC"
	},
	axisY2: {
		title: "Quotes",
		titleFontColor: "#C0504E",
		lineColor: "#C0504E",
		labelFontColor: "#C0504E",
		tickColor: "#C0504E"
	},	
	toolTip: {
		shared: true
	},
	legend: {
		cursor:"pointer",
		itemclick: toggleDataSeries
	},
	data: [{
		type: "column",
		name: "Walk In",
		legendText: "Walk In",
		showInLegend: true, 
		// dataPoints:[
		// 	{ label: "Jan", y: 266.21 },
		// ]
        dataPoints:<?php echo json_encode($WALKInData); ?>
	},
	{
		type: "column",	
		name: "Quotes",
		legendText: "Quotes",
		//axisYType: "secondary",
		showInLegend: true,
		// dataPoints:[
		// 	{ label: "Jan", y: 10.46 },
		// ]
        dataPoints:<?php echo json_encode($QuotesData); ?>
	}]
});
chart.render();



var chart2 = new CanvasJS.Chart("chartContainer2", {
	animationEnabled: true,
	title:{
		text: "Sales VS Expenses"
	},	
	axisY: {
		title: "Sales",
		titleFontColor: "#4F81BC",
		lineColor: "#4F81BC",
		labelFontColor: "#4F81BC",
		tickColor: "#4F81BC"
	},
	axisY2: {
		title: "Expenses",
		titleFontColor: "#C0504E",
		lineColor: "#C0504E",
		labelFontColor: "#C0504E",
		tickColor: "#C0504E"
	},	
	toolTip: {
		shared: true
	},
	legend: {
		cursor:"pointer",
		itemclick: toggleDataSeries
	},
	data: [{
		type: "column",
		name: "Sales",
		legendText: "Sales",
		showInLegend: true, 
		// dataPoints:[
		// 	{ label: "Jan", y: 266.21 },
		// ]
        dataPoints:<?php echo json_encode($totalSalesDepositAmount); ?>
	},
	{
		type: "column",	
		name: "Expenses",
		legendText: "Expenses",
		//axisYType: "secondary",
		showInLegend: true,
		// dataPoints:[
		// 	{ label: "Jan", y: 10.46 },
		// ]
        dataPoints:<?php echo json_encode($totalExpensesAmountData); ?>
	}]
});
chart2.render();

function toggleDataSeries(e) {
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	}
	else {
		e.dataSeries.visible = true;
	}
	chart.render();
}

}
</script>
// <script>  

// window.onload = function () {
//     var chart = new CanvasJS.Chart("chartContainer1", {
//         animationEnabled: true,
//         title: { text: "Activity" },
//         axisY: {
//             title: "Walk In",
//             titleFontColor: "#4F81BC",
//             lineColor: "#4F81BC",
//             labelFontColor: "#4F81BC",
//             tickColor: "#4F81BC"
//         },
//         axisY2: {
//             title: "Quotes",
//             titleFontColor: "#C0504E",
//             lineColor: "#C0504E",
//             labelFontColor: "#C0504E",
//             tickColor: "#C0504E"
//         },
//         toolTip: { shared: true },
//         legend: { cursor: "pointer", itemclick: toggleDataSeries },
//         data: [
//             {
//                 type: "column",
//                 name: "Walk In",
//                 legendText: "Walk In",
//                 showInLegend: true,
//                 indexLabel: "{y}",
//                 indexLabelFontSize: 12,
//                 dataPointWidth: 30, // Adjust spacing
//                 dataPoints: <?php echo json_encode($WALKInData); ?>
//             },
//             {
//                 type: "line", // Change to line
//                 name: "Quotes",
//                 legendText: "Quotes",
//                 axisYType: "secondary",
//                 showInLegend: true,
//                 lineThickness: 3, // Make the line thicker
//                 markerType: "circle",
//                 markerSize: 8,
//                 dataPoints: <?php echo json_encode($QuotesData); ?>
//             }
//         ]
//     });
//     chart.render();

//     var chart2 = new CanvasJS.Chart("chartContainer2", {
//         animationEnabled: true,
//         title: { text: "Sales VS Expenses" },
//         axisY: {
//             title: "Sales",
//             titleFontColor: "#4F81BC",
//             lineColor: "#4F81BC",
//             labelFontColor: "#4F81BC",
//             tickColor: "#4F81BC"
//         },
//         axisY2: {
//             title: "Expenses",
//             titleFontColor: "#C0504E",
//             lineColor: "#C0504E",
//             labelFontColor: "#C0504E",
//             tickColor: "#C0504E"
//         },
//         toolTip: { shared: true },
//         legend: { cursor: "pointer", itemclick: toggleDataSeries },
//         data: [
//             {
//                 type: "column",
//                 name: "Sales",
//                 legendText: "Sales",
//                 showInLegend: true,
//                 indexLabel: "{y}",
//                 indexLabelFontSize: 12,
//                 dataPointWidth: 30, // Adjust spacing
//                 dataPoints: <?php echo json_encode($totalSalesDepositAmount); ?>
//             },
//             {
//                 type: "line", // Change to line
//                 name: "Expenses",
//                 legendText: "Expenses",
//                 axisYType: "secondary",
//                 showInLegend: true,
//                 lineThickness: 3, // Thicker line
//                 markerType: "square",
//                 markerSize: 8,
//                 dataPoints: <?php echo json_encode($totalExpensesAmountData); ?>
//             }
//         ]
//     });
//     chart2.render();

//     function toggleDataSeries(e) {
//         if (typeof e.dataSeries.visible === "undefined" || e.dataSeries.visible) {
//             e.dataSeries.visible = false;
//         } else {
//             e.dataSeries.visible = true;
//         }
//         e.chart.render();
//     }
// };

// </script>
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 p-r-0 title-margin-right">
            <div class="page-header">
                <div class="page-title">
                    <h1>Hello, <span>Welcome Here</span></h1>
                </div>
            </div>
        </div>
        <!-- /# column -->
        <div class="col-lg-4 p-l-0 title-margin-left">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Home</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /# column -->
    </div>
    <!-- /# row -->
    <section id="main-content">
        <div class="row">
            @if (Auth::guard('admins')->check())
                <div class="col-lg-3">
                    <div class="card">
                        <div class="stat-widget-one">
                            <div class="stat-icon dib"><i class="ti-money color-success border-success"></i>
                            </div>
                            <div class="stat-content dib">
                                <div class="stat-text">Total Artists</div>
                                <div class="stat-digit">{{$totalArtists}}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="stat-widget-one">
                            <div class="stat-icon dib"><i class="ti-layout-grid2 color-pink border-pink"></i>
                            </div>
                            <div class="stat-content dib">
                                <div class="stat-text">Total Users</div>
                                <div class="stat-digit">{{$totalUsers}}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                <div class="card">
                    <div class="stat-widget-one">
                        <div class="stat-icon dib"><i class="ti-user color-primary border-primary"></i>
                        </div>
                        <div class="stat-content dib">
                            <div class="stat-text">Total Subscriber</div>
                            <div class="stat-digit">{{$totalSubscriber}}</div>
                        </div>
                    </div>
                </div>
                 </div>
                 <div class="col-lg-3">
                <div class="card">
                    <div class="stat-widget-one">
                        <div class="stat-icon dib"><i class="ti-user color-primary border-primary"></i>
                        </div>
                        <div class="stat-content dib">
                            <div class="stat-text">Total Sales Person</div>
                            <div class="stat-digit">{{$totalSalesPerson}}</div>
                        </div>
                    </div>
                </div>
                 </div>
                 <div class="col-lg-4">
                <div class="card">
                    <div class="stat-widget-one">
                        <h5 class="text-center">Tire 1 Artists</h5><hr>
                        <div style="display: flex; justify-content: space-between">
                            <div class="stat-digit">Artists</div>
                            <div class="stat-digit">{{ @$totalArtist1 }}</div>
                        </div>
                        <div style="display: flex; justify-content: space-between">
                            <div class="stat-digit">Sales</div>
                            <div class="stat-digit">{{ @$totalsalesprice1 }}</div>
                        </div>
                        <div style="display: flex; justify-content: space-between">
                            <div class="stat-digit">Quotes</div>
                            <div class="stat-digit">{{ @$totalQuotes1 }}</div>
                        </div>                        
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="stat-widget-one">
                        <h5 class="text-center">Tire 2 Artists</h5><hr>
                        <div style="display: flex; justify-content: space-between">
                            <div class="stat-digit">Artists</div>
                            <div class="stat-digit">{{ @$totalArtist2 }}</div>
                        </div>
                        <div style="display: flex; justify-content: space-between">
                            <div class="stat-digit">Sales</div>
                            <div class="stat-digit">{{ @$totalsalesprice2 }}</div>
                        </div>
                        <div style="display: flex; justify-content: space-between">
                            <div class="stat-digit">Quotes</div>
                            <div class="stat-digit">{{ @$totalQuotes2 }}</div>
                        </div>                        
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="stat-widget-one">
                        <h5 class="text-center">Tire 3 Artists</h5><hr>
                        <div style="display: flex; justify-content: space-between">
                            <div class="stat-digit">Artists</div>
                            <div class="stat-digit">{{ @$totalArtist3 }}</div>
                        </div>
                        <div style="display: flex; justify-content: space-between">
                            <div class="stat-digit">Sales</div>
                            <div class="stat-digit">{{ @$totalsalesprice3 }}</div>
                        </div>
                        <div style="display: flex; justify-content: space-between">
                            <div class="stat-digit">Quotes</div>
                            <div class="stat-digit">{{ @$totalQuotes3 }}</div>
                        </div>                        
                    </div>
                </div>
            </div>
                
               
            @endif
            

            @if (!Auth::guard('admins')->check() && !Auth::guard('artists')->check())
            <div class="col-lg-4">
                    <div class="card">
                        <div class="stat-widget-one">
                            <div class="stat-icon dib"><i class="ti-money color-success border-success"></i>
                            </div>
                            <div class="stat-content dib">
                                <div class="stat-text">Total Artists</div>
                                <div class="stat-digit">{{$totalArtists}}</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                <div class="card">
                    <div class="stat-widget-one">
                        <div class="stat-icon dib"><i class="ti-user color-primary border-primary"></i>
                        </div>
                        <div class="stat-content dib">
                            <div class="stat-text">Total Appoinment</div>
                            <div class="stat-digit">{{$totalAppointment}}</div>
                        </div>
                    </div>
                </div>
                 </div>
                 <div class="col-lg-4">
                <div class="card">
                    <div class="stat-widget-one">
                        <div class="stat-icon dib"><i class="ti-user color-primary border-primary"></i>
                        </div>
                        <div class="stat-content dib">
                            <div class="stat-text">Total Subscriber</div>
                            <div class="stat-digit">{{$totalSubscriber}}</div>
                        </div>
                    </div>
                </div>
                 </div>
                 <div class="col-lg-4">
                <div class="card">
                    <div class="stat-widget-one">
                        <h5 class="text-center">Tire 1 Artists</h5><hr>
                        <div style="display: flex; justify-content: space-between">
                            <div class="stat-digit">Artists</div>
                            <div class="stat-digit">{{ @$totalArtist1 }}</div>
                        </div>
                        <div style="display: flex; justify-content: space-between">
                            <div class="stat-digit">Sales</div>
                            <div class="stat-digit">{{ @$totalsalesprice1 }}</div>
                        </div>
                        <div style="display: flex; justify-content: space-between">
                            <div class="stat-digit">Quotes</div>
                            <div class="stat-digit">{{ @$totalQuotes1 }}</div>
                        </div>                        
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="stat-widget-one">
                        <h5 class="text-center">Tire 2 Artists</h5><hr>
                        <div style="display: flex; justify-content: space-between">
                            <div class="stat-digit">Artists</div>
                            <div class="stat-digit">{{ @$totalArtist2 }}</div>
                        </div>
                        <div style="display: flex; justify-content: space-between">
                            <div class="stat-digit">Sales</div>
                            <div class="stat-digit">{{ @$totalsalesprice2 }}</div>
                        </div>
                        <div style="display: flex; justify-content: space-between">
                            <div class="stat-digit">Quotes</div>
                            <div class="stat-digit">{{ @$totalQuotes2 }}</div>
                        </div>                        
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="stat-widget-one">
                        <h5 class="text-center">Tire 3 Artists</h5><hr>
                        <div style="display: flex; justify-content: space-between">
                            <div class="stat-digit">Artists</div>
                            <div class="stat-digit">{{ @$totalArtist3 }}</div>
                        </div>
                        <div style="display: flex; justify-content: space-between">
                            <div class="stat-digit">Sales</div>
                            <div class="stat-digit">{{ @$totalsalesprice3 }}</div>
                        </div>
                        <div style="display: flex; justify-content: space-between">
                            <div class="stat-digit">Quotes</div>
                            <div class="stat-digit">{{ @$totalQuotes3 }}</div>
                        </div>                        
                    </div>
                </div>
            </div>
           
            @endif


            @if (Auth::guard('artists')->check())
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-4">
                    <div class="card">
                        <div class="stat-widget-one">
                            <div class="stat-icon dib"><i class="ti-money color-success border-success"></i>
                            </div>
                            <div class="stat-content dib">
                                <div class="stat-text">Subscription Plan</div>
                                @if($havesubscription == 50)
                                <div class="stat-digit">Starter Plan</div>
                                @elseif($havesubscription == 100)
                                <div class="stat-digit">Professional Plan</div>
                                @elseif($havesubscription == 300)
                                <div class="stat-digit">Elite Plan</div>
                                @else
                                <div class="stat-digit">No Plane</div>
                                @endif
                               

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="stat-widget-one">
                            <div class="stat-icon dib"><i class="ti-layout-grid2 color-pink border-pink"></i>
                            </div>
                            <div class="stat-content dib">
                                <div class="stat-text">Total Artworks</div>
                                <div class="stat-digit">{{$totalArtwork}}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                <div class="card">
                    <div class="stat-widget-one">
                        <div class="stat-icon dib"><i class="ti-user color-primary border-primary"></i>
                        </div>
                        <div class="stat-content dib">
                            <div class="stat-text">Total Appoinment</div>
                            <div class="stat-digit">{{$totalAppointment}}</div>
                        </div>
                    </div>
                </div>
                 </div>
                 
                 
            </div>
                <div class="card">

                    <div class="card-body">
                        <form action="{{ route('admin.dashboard') }}" method="GET" enctype="multipart/form-data" name="reportform">
                            <div class="row d-flex justify-content-between">
                                {{-- <div class="col-lg-5 col-md-5 col-sm-12">
                                    <label for="start_date"><b>Start Month:</b></label>
                                    <div class="input-group date datepicker">
                                        <input type="date" id="start_date" name="start_date" value="" class="form-control" required="" />
                                    </div>
                                </div>
            
                                <div class="col-lg-5 col-md-5 col-sm-12">
                                    <label for="end_date"><b>End Month:</b></label>
                                    <div class="input-group date datepicker">
                                        <input type="date" id="end_date" name="end_date" class="form-control" value="" required="" />
                                    </div>
                                </div> --}}

                                <div class="col-lg-5 col-md-5 col-sm-12">
                                    <label for="end_date"><b>Select Year:</b></label>
                                    <div class="input-group">
                                        <select name="selected_year" class="form-control">
                                            <option value="">Select Year</option>
                                            <option value="{{ date('Y') }}" @if(@$_GET['selected_year'] ==  date('Y')) selected @else selected  @endif >{{ date('Y') }}</option>
                                            <option value="{{ date('Y', strtotime('-1 year')) }}" @if(@$_GET['selected_year'] ==  date('Y', strtotime('-1 year'))) selected @endif >{{ date('Y', strtotime('-1 year')) }}</option>
                                            <option value="{{ date('Y', strtotime('-2 year')) }}" @if(@$_GET['selected_year'] ==  date('Y', strtotime('-2 year'))) selected @endif >{{ date('Y', strtotime('-2 year')) }}</option>
                                            <option value="{{ date('Y', strtotime('-3 year')) }}" @if(@$_GET['selected_year'] ==  date('Y', strtotime('-3 year'))) selected @endif >{{ date('Y', strtotime('-3 year')) }}</option>
                                            <option value="{{ date('Y', strtotime('-4 year')) }}" @if(@$_GET['selected_year'] ==  date('Y', strtotime('-4 year'))) selected @endif >{{ date('Y', strtotime('-4 year')) }}</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Filter and Print Buttons -->
                                <div class="ccol-lg-2 col-md-2 col-sm-12 d-flex align-items-end  justify-content-center">
                                    <button type="submit" class="btn btn-outline-danger  w-100 m-1">Refresh</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div id="resizable" style="height: 370px;border:1px solid gray;">
                                <div id="chartContainer1" style="height: 100%; width: 100%;"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="resizable" style="height: 370px;border:1px solid gray;">
                                <div id="chartContainer2" style="height: 100%; width: 100%;"></div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
            
            @endif

            {{-- <div class="col-lg-3">
                <div class="card">
                    <div class="stat-widget-one">
                        <div class="stat-icon dib"><i class="ti-link color-danger border-danger"></i></div>
                        <div class="stat-content dib">
                            <div class="stat-text">Referral</div>
                            <div class="stat-digit">2,781</div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
      
        {{-- <div class="row">
           
            <!-- /# column -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-title pr">
                        <h4>All Exam Result</h4>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table student-data-table m-t-20">
                                <thead>
                                    <tr>
                                        <th><label><input type="checkbox" value=""></label>Exam Name</th>
                                        <th>Subject</th>
                                        <th>Grade Point</th>
                                        <th>Percent Form</th>
                                        <th>Percent Upto</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Class Test</td>
                                        <td>Mathmatics</td>
                                        <td>
                                            4.00
                                        </td>
                                        <td>
                                            95.00
                                        </td>
                                        <td>
                                            100
                                        </td>
                                        <td>20/04/2017</td>
                                    </tr>
                                    <tr>
                                        <td>Class Test</td>
                                        <td>Mathmatics</td>
                                        <td>
                                            4.00
                                        </td>
                                        <td>
                                            95.00
                                        </td>
                                        <td>
                                            100
                                        </td>
                                        <td>20/04/2017</td>
                                    </tr>
                                    <tr>
                                        <td>Class Test</td>
                                        <td>English</td>
                                        <td>
                                            4.00
                                        </td>
                                        <td>
                                            95.00
                                        </td>
                                        <td>
                                            100
                                        </td>
                                        <td>20/04/2017</td>
                                    </tr>
                                    <tr>
                                        <td>Class Test</td>
                                        <td>Bangla</td>
                                        <td>
                                            4.00
                                        </td>
                                        <td>
                                            95.00
                                        </td>
                                        <td>
                                            100
                                        </td>
                                        <td>20/04/2017</td>
                                    </tr>
                                    <tr>
                                        <td>Class Test</td>
                                        <td>Mathmatics</td>
                                        <td>
                                            4.00
                                        </td>
                                        <td>
                                            95.00
                                        </td>
                                        <td>
                                            100
                                        </td>
                                        <td>20/04/2017</td>
                                    </tr>
                                    <tr>
                                        <td>Class Test</td>
                                        <td>English</td>
                                        <td>
                                            4.00
                                        </td>
                                        <td>
                                            95.00
                                        </td>
                                        <td>
                                            100
                                        </td>
                                        <td>20/04/2017</td>
                                    </tr>
                                    <tr>
                                        <td>Class Test</td>
                                        <td>Mathmatics</td>
                                        <td>
                                            4.00
                                        </td>
                                        <td>
                                            95.00
                                        </td>
                                        <td>
                                            100
                                        </td>
                                        <td>20/04/2017</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /# column -->
        </div> --}}
        <!-- /# row -->
        {{-- <div class="row">
            <div class="col-lg-3">
                <div class="card p-0">
                    <div class="stat-widget-three home-widget-three">
                        <div class="stat-icon bg-facebook">
                            <i class="ti-facebook"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-digit">8,268</div>
                            <div class="stat-text">Likes</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card p-0">
                    <div class="stat-widget-three home-widget-three">
                        <div class="stat-icon bg-youtube">
                            <i class="ti-youtube"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-digit">12,545</div>
                            <div class="stat-text">Subscribes</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card p-0">
                    <div class="stat-widget-three home-widget-three">
                        <div class="stat-icon bg-twitter">
                            <i class="ti-twitter"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-digit">7,982</div>
                            <div class="stat-text">Tweets</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card p-0">
                    <div class="stat-widget-three home-widget-three">
                        <div class="stat-icon bg-danger">
                            <i class="ti-linkedin"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-digit">9,658</div>
                            <div class="stat-text">Followers</div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        {{-- <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="year-calendar"></div>
                    </div>
                </div>
                <!-- /# card -->
            </div>
            <!-- /# column -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-title">
                        <h4>Notice Board </h4>

                    </div>
                    <div class="recent-comment m-t-15">
                        <div class="media">
                            <div class="media-left">
                                <a href="#"><img class="media-object" src="images/avatar/1.jpg"
                                        alt="..."></a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading color-primary">john doe</h4>
                                <p>Cras sit amet nibh libero, in gravida nulla.</p>
                                <p class="comment-date">10 min ago</p>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-left">
                                <a href="#"><img class="media-object" src="images/avatar/2.jpg"
                                        alt="..."></a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading color-success">Mr. John</h4>
                                <p>Cras sit amet nibh libero, in gravida nulla.</p>
                                <p class="comment-date">1 hour ago</p>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-left">
                                <a href="#"><img class="media-object" src="images/avatar/3.jpg"
                                        alt="..."></a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading color-danger">Mr. John</h4>
                                <p>Cras sit amet nibh libero, in gravida nulla.</p>
                                <div class="comment-date">Yesterday</div>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-left">
                                <a href="#"><img class="media-object" src="images/avatar/1.jpg"
                                        alt="..."></a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading color-primary">john doe</h4>
                                <p>Cras sit amet nibh libero, in gravida nulla.</p>
                                <p class="comment-date">10 min ago</p>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-left">
                                <a href="#"><img class="media-object" src="images/avatar/2.jpg"
                                        alt="..."></a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading color-success">Mr. John</h4>
                                <p>Cras sit amet nibh libero, in gravida nulla.</p>
                                <p class="comment-date">1 hour ago</p>
                            </div>
                        </div>
                        <div class="media no-border">
                            <div class="media-left">
                                <a href="#"><img class="media-object" src="images/avatar/3.jpg"
                                        alt="..."></a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading color-info">Mr. John</h4>
                                <p>Cras sit amet nibh libero, in gravida nulla.</p>
                                <div class="comment-date">Yesterday</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /# card -->
            </div>
            <!-- /# column -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-title">
                        <h4>Timeline</h4>

                    </div>
                    <div class="card-body">
                        <ul class="timeline">
                            <li>
                                <div class="timeline-badge primary"><i class="fa fa-smile-o"></i></div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <h5 class="timeline-title">School promote video sharing</h5>
                                    </div>
                                    <div class="timeline-body">
                                        <p>10 minutes ago</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="timeline-badge warning"><i class="fa fa-sun-o"></i></div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <h5 class="timeline-title">Ready our school website and online
                                            service</h5>
                                    </div>
                                    <div class="timeline-body">
                                        <p>20 minutes ago</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="timeline-badge danger"><i class="fa fa-times-circle-o"></i>
                                </div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <h5 class="timeline-title">Routine pubish our website form
                                            10/03/2017 </h5>
                                    </div>
                                    <div class="timeline-body">
                                        <p>30 minutes ago</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="timeline-badge success"><i class="fa fa-check-circle-o"></i>
                                </div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <h5 class="timeline-title">Principle quotation publish our website
                                        </h5>
                                    </div>
                                    <div class="timeline-body">
                                        <p>15 minutes ago</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="timeline-badge warning"><i class="fa fa-sun-o"></i></div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <h5 class="timeline-title">Class schedule publish our website</h5>
                                    </div>
                                    <div class="timeline-body">
                                        <p>20 minutes ago</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /# card -->
            </div>
        </div>
        <!-- /# row --> --}}

        {{-- <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-title">
                        <h4>Task</h4>

                    </div>
                    <div class="todo-list">
                        <div class="tdl-holder">
                            <div class="tdl-content">
                                <ul>
                                    <li>
                                        <label>
                                            <input type="checkbox"><i></i><span>22,Dec Publish The Final
                                                Exam Result</span>
                                            <a href='#' class="ti-close"></a>
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="checkbox" checked><i></i><span>First Jan Start Our
                                                School</span>
                                            <a href='#' class="ti-close"></a>
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="checkbox"><i></i><span>Recently Our Maganement
                                                Programme Start</span>
                                            <a href='#' class="ti-close"></a>
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="checkbox" checked><i></i><span>Check out some
                                                Popular courses</span>
                                            <a href='#' class="ti-close"></a>
                                        </label>
                                    </li>

                                    <li>
                                        <label>
                                            <input type="checkbox" checked><i></i><span>First Jan Start Our
                                                School</span>
                                            <a href='#' class="ti-close"></a>
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="checkbox" checked><i></i><span>Connect with one new
                                                person</span>
                                            <a href='#' class="ti-close"></a>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                            <input type="text" class="tdl-new form-control"
                                placeholder="Write new item and hit 'Enter'...">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-title pr">
                        <h4>All Expense</h4>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table student-data-table m-t-20">
                                <thead>
                                    <tr>
                                        <th><label><input type="checkbox" value=""></label>ID</th>
                                        <th>Expense Type</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Email</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><label><input type="checkbox" value=""></label>#2901</td>
                                        <td>
                                            Salary
                                        </td>
                                        <td>
                                            $2000
                                        </td>
                                        <td>
                                            <span class="badge badge-primary">Paid</span>
                                        </td>
                                        <td>
                                            edumin@gmail.com
                                        </td>
                                        <td>
                                            10/05/2017
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label><input type="checkbox" value=""></label>#2901</td>
                                        <td>
                                            Salary
                                        </td>
                                        <td>
                                            $2000
                                        </td>
                                        <td>
                                            <span class="badge badge-warning">Pending</span>
                                        </td>
                                        <td>
                                            edumin@gmail.com
                                        </td>
                                        <td>
                                            10/05/2017
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label><input type="checkbox" value=""></label>#2901</td>
                                        <td>
                                            Salary
                                        </td>
                                        <td>
                                            $2000
                                        </td>
                                        <td>
                                            <span class="badge badge-primary">Paid</span>
                                        </td>
                                        <td>
                                            edumin@gmail.com
                                        </td>
                                        <td>
                                            10/05/2017
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label><input type="checkbox" value=""></label>#2901</td>
                                        <td>
                                            Salary
                                        </td>
                                        <td>
                                            $2000
                                        </td>
                                        <td>
                                            <span class="badge badge-danger">Due</span>
                                        </td>
                                        <td>
                                            edumin@gmail.com
                                        </td>
                                        <td>
                                            10/05/2017
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label><input type="checkbox" value=""></label>#2901</td>
                                        <td>
                                            Salary
                                        </td>
                                        <td>
                                            $2000
                                        </td>
                                        <td>
                                            <span class="badge badge-primary">Paid</span>
                                        </td>
                                        <td>
                                            edumin@gmail.com
                                        </td>
                                        <td>
                                            10/05/2017
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /# column -->
        </div> --}}


        <div class="row">
            <div class="col-lg-12">
                {{-- <div class="footer">
                    <p>{{ date('Y') }} © Admin Board. - <a href="#">tshirt.com</a></p>
                </div> --}}
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
<script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
<script src="https://canvasjs.com/assets/script/jquery-ui.1.11.2.min.js"></script>
<script src="https://cdn.canvasjs.com/jquery.canvasjs.min.js"></script>
@endsection