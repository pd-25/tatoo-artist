@extends('admin.layout.main')
@section('title', env('APP_NAME') . ' | Dashboard')
<style>
    .stat-widget-one .stat-digit {
        font-size: 17px !important;
        color: #373757;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<link href="https://canvasjs.com/assets/css/jquery-ui.1.11.2.min.css" rel="stylesheet" />
{{-- <script>
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
</script> --}}
// <script>
//     window.onload = function() {
//         var chart = new CanvasJS.Chart("chartContainer1", {
//             animationEnabled: true,
//             title: {
//                 text: "Activity"
//             },
//             axisY: {
//                 title: "Walk In",
//                 titleFontColor: "#4F81BC",
//                 lineColor: "#4F81BC",
//                 labelFontColor: "#4F81BC",
//                 tickColor: "#4F81BC"
//             },
//             axisY2: {
//                 title: "Quotes",
//                 titleFontColor: "#C0504E",
//                 lineColor: "#C0504E",
//                 labelFontColor: "#C0504E",
//                 tickColor: "#C0504E"
//             },
//             toolTip: {
//                 shared: true
//             },
//             legend: {
//                 cursor: "pointer",
//                 itemclick: toggleDataSeries
//             },
//             data: [{
//                     type: "column",
//                     name: "Walk In",
//                     legendText: "Walk In",
//                     showInLegend: true,
//                     indexLabel: "{y}",
//                     indexLabelFontSize: 12,
//                     dataPointWidth: 30, // Adjust spacing
//                     dataPoints: <?php echo json_encode($WALKInData); ?>
//                 },
//                 {
//                     type: "line", // Change to line
//                     name: "Quotes",
//                     legendText: "Quotes",
//                     axisYType: "secondary",
//                     showInLegend: true,
//                     lineThickness: 3, // Make the line thicker
//                     markerType: "circle",
//                     markerSize: 8,
//                     dataPoints: <?php echo json_encode($QuotesData); ?>
//                 }
//             ]
//         });
//         chart.render();

//         var chart2 = new CanvasJS.Chart("chartContainer2", {
//             animationEnabled: true,
//             title: {
//                 text: "Sales VS Expenses"
//             },
//             axisY: {
//                 title: "Sales",
//                 titleFontColor: "#4F81BC",
//                 lineColor: "#4F81BC",
//                 labelFontColor: "#4F81BC",
//                 tickColor: "#4F81BC"
//             },
//             axisY2: {
//                 title: "Expenses",
//                 titleFontColor: "#C0504E",
//                 lineColor: "#C0504E",
//                 labelFontColor: "#C0504E",
//                 tickColor: "#C0504E"
//             },
//             toolTip: {
//                 shared: true
//             },
//             legend: {
//                 cursor: "pointer",
//                 itemclick: toggleDataSeries
//             },
//             data: [{
//                     type: "column",
//                     name: "Sales",
//                     legendText: "Sales",
//                     showInLegend: true,
//                     indexLabel: "{y}",
//                     indexLabelFontSize: 12,
//                     dataPointWidth: 30, // Adjust spacing
//                     dataPoints: <?php echo json_encode($totalSalesDepositAmount); ?>
//                 },
//                 {
//                     type: "line", // Change to line
//                     name: "Expenses",
//                     legendText: "Expenses",
//                     axisYType: "secondary",
//                     showInLegend: true,
//                     lineThickness: 3, // Thicker line
//                     markerType: "square",
//                     markerSize: 8,
//                     dataPoints: <?php echo json_encode($totalExpensesAmountData); ?>
//                 }
//             ]
//         });
//         chart2.render();

//         function toggleDataSeries(e) {
//             if (typeof e.dataSeries.visible === "undefined" || e.dataSeries.visible) {
//                 e.dataSeries.visible = false;
//             } else {
//                 e.dataSeries.visible = true;
//             }
//             e.chart.render();
//         }
//     };
// </script>
<?php

// Encode data as JSON
$WALKInDataJSON = json_encode($WALKInData);
$QuotesDataJSON = json_encode($QuotesData);
$totalSalesDepositAmountJSON = json_encode($totalSalesDepositAmount);
$totalExpensesAmountDataJSON = json_encode($totalExpensesAmountData);
?>

{{-- @dd($WALKInData) --}}

<script>
window.onload = function () {

// Convert PHP data into JavaScript
var walkInData = <?php echo $WALKInDataJSON; ?>;
var quotesData = <?php echo $QuotesDataJSON; ?>;
var salesData = <?php echo $totalSalesDepositAmountJSON; ?>;
var expensesData = <?php echo $totalExpensesAmountDataJSON; ?>;

// First Chart: Walk-ins vs Quotes
var chart1 = new CanvasJS.Chart("chartContainer1", {
    animationEnabled: true,
    title: {
        text: "Walk-ins vs Quotes"
    },
    axisY: {
        title: "Number (in units)",
        titleFontColor: "#4F81BC",
        lineColor: "#4F81BC",
        labelFontColor: "#4F81BC",
        tickColor: "#4F81BC"
    },  
    toolTip: {
        shared: true
    },
    legend: {
        cursor: "pointer",
        itemclick: toggleDataSeries
    },
    data: [
        {
            type: "column",
            name: "Walk-ins",
            legendText: "Walk-ins",
            showInLegend: true,
            color: "#0080e0",
            dataPoints: walkInData
        },
        {
            type: "column",
            name: "Quotes",
            legendText: "Quotes",
            showInLegend: true,
            color: "#e08c00",
            dataPoints: quotesData
        }
    ]
});
chart1.render();

// Second Chart: Sales vs Expenses
var chart2 = new CanvasJS.Chart("chartContainer2", {
    animationEnabled: true,
    title: {
        text: "Sales vs Expenses"
    },
    axisY: {
        title: "Amount (in units)",
        titleFontColor: "#4F81BC",
        lineColor: "#4F81BC",
        labelFontColor: "#4F81BC",
        tickColor: "#4F81BC"
    },  
    toolTip: {
        shared: true
    },
    legend: {
        cursor: "pointer",
        itemclick: toggleDataSeries
    },
    data: [
        {
            type: "column",
            name: "Sales",
            legendText: "Sales",
            showInLegend: true,
            color: "#00b050",
            dataPoints: salesData
        },
        {
            type: "column",
            name: "Expenses",
            legendText: "Expenses",
            showInLegend: true,
            color: "#c00000",
            dataPoints: expensesData
        }
    ]
});
chart2.render();

// Function to toggle data series visibility
function toggleDataSeries(e) {
    if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
        e.dataSeries.visible = false;
    } else {
        e.dataSeries.visible = true;
    }
    e.chart.render();
}

}
</script>
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
                                    <div class="stat-digit">{{ $totalArtists }}</div>
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
                                    <div class="stat-digit">{{ $totalUsers }}</div>
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
                                    <div class="stat-digit">{{ $totalSubscriber }}</div>
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
                                    <div class="stat-digit">{{ $totalSalesPerson }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
            <div class="card">
                <div class="card-title pr">
                    <h4>Search By date</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.dashboard') }}" method="GET" enctype="multipart/form-data" name="paymentform">
                        @csrf
                        <div class="row d-flex justify-content-between">
                            <!-- Start Date -->
                            <div class="col-lg-5 col-md-5 col-sm-12">
                                <label for="start_date"><b>Start Date:</b></label>
                                <div class="input-group">
                                    <input type="text" id="start_date" name="start_date" value="{{ old('start_date') }}" class="form-control flatpickr" required>
                                    <div class="input-group-addon input-group-append">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>   
                            </div>
                    
                            <!-- End Date -->
                            <div class="col-lg-5 col-md-5 col-sm-12">
                                <label for="end_date"><b>End Date:</b></label>
                                <div class="input-group">
                                    <input type="text" id="end_date" name="end_date" class="form-control flatpickr" value="{{ old('end_date') }}" required>
                                    <div class="input-group-addon input-group-append">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>   
                            </div>
                    
                            <!-- Filter and Print Buttons -->
                            <div class="col-lg-2 col-md-2 col-sm-12 d-flex align-items-end justify-content-center">
                                <button type="submit" class="btn btn-primary w-100 m-1">Search</button>
                            </div>
                        </div> 
                    </form>

                  
                        
                </div>    
            </div>
        </div>  

                    <div class="col-lg-4">
                        <div class="card">
                            <div class="stat-widget-one">
                                <h5 class="text-center">Tire 1 Artists</h5>
                                <hr>
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
                                <h5 class="text-center">Tire 2 Artists</h5>
                                <hr>
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
                                <h5 class="text-center">Tire 3 Artists</h5>
                                <hr>
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
                                    <div class="stat-digit">{{ $totalArtists }}</div>
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
                                    <div class="stat-digit">{{ $totalAppointment }}</div>
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
                                    <div class="stat-digit">{{ $totalSubscriber }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
            <div class="card">
                <div class="card-title pr">
                    <h4>Search By date</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.dashboard') }}" method="GET" enctype="multipart/form-data" name="paymentform">
                        @csrf
                        <div class="row d-flex justify-content-between">
                            <!-- Start Date -->
                            <div class="col-lg-5 col-md-5 col-sm-12">
                                <label for="start_date"><b>Start Date:</b></label>
                                <div class="input-group">
                                    <input type="text" id="start_date" name="start_date" value="{{ old('start_date') }}" class="form-control flatpickr" required>
                                    <div class="input-group-addon input-group-append">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>   
                            </div>
                    
                            <!-- End Date -->
                            <div class="col-lg-5 col-md-5 col-sm-12">
                                <label for="end_date"><b>End Date:</b></label>
                                <div class="input-group">
                                    <input type="text" id="end_date" name="end_date" class="form-control flatpickr" value="{{ old('end_date') }}" required>
                                    <div class="input-group-addon input-group-append">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>   
                            </div>
                    
                            <!-- Filter and Print Buttons -->
                            <div class="col-lg-2 col-md-2 col-sm-12 d-flex align-items-end justify-content-center">
                                <button type="submit" class="btn btn-primary w-100 m-1">Search</button>
                            </div>
                        </div> 
                    </form>

                  
                        
                </div>    
            </div>
        </div>  
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="stat-widget-one">
                                <h5 class="text-center">Tire 1 Artists</h5>
                                <hr>
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
                                <h5 class="text-center">Tire 2 Artists</h5>
                                <hr>
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
                                <h5 class="text-center">Tire 3 Artists</h5>
                                <hr>
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
                                            @if ($havesubscription == 50)
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
                                            <div class="stat-digit">{{ $totalArtwork }}</div>
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
                                            <div class="stat-digit">{{ $totalAppointment }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="card">

                            <div class="card-body">
                                @if(auth()->guard('artists')->check())
                                <form action="{{ route('artists.dashboard') }}" method="GET">
                                    @else
                                    <form action="{{ route('admin.dashboard') }}" method="GET"
                                    enctype="multipart/form-data" name="reportform">
                                    @endif

                                    <div class="row d-flex justify-content-between">
                                        <div class="col-lg-5 col-md-5 col-sm-12">
                                            <label for="end_date"><b>Select Year:</b></label>
                                            <div class="input-group">
                                                <select name="selected_year" class="form-control">
                                                    <option value="">Select Year</option>
                                                    @for ($i = 0; $i <= 4; $i++)
                                                        @php $year = date('Y', strtotime("-$i year")); @endphp
                                                        <option value="{{ $year }}"
                                                            {{ request('selected_year', date('Y')) == $year ? 'selected' : '' }}>
                                                            {{ $year }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Filter and Print Buttons -->
                                        <div
                                            class="col-lg-2 col-md-2 col-sm-12 d-flex align-items-end justify-content-center">
                                            <button type="submit"
                                                class="btn btn-outline-danger w-100 m-1">Refresh</button>
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

                
            </div>

       


            <div class="row">
                <div class="col-lg-12">
                    
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
    <script src="https://canvasjs.com/assets/script/jquery-ui.1.11.2.min.js"></script>
    <script src="https://cdn.canvasjs.com/jquery.canvasjs.min.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        flatpickr(".flatpickr", {
            dateFormat: "m-d-Y", // Customize the date format
            allowInput: true, // Allow manual input
            defaultDate: "today", // Set default date to today
        });
    });
</script>
@endsection
