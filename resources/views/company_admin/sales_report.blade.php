@extends('layouts.app')

@section('page_header')
<h1 class="m-0 text-dark">Sales Reports</h1>
@endsection

@section('breadcrumb_list')
<li class="breadcrumb-item active">Reports</li>
@endsection

@section('content')

<div class="col-md-12 col-xs-12">

    <!-- PIE CHART -->
           <div class="card card-success">
             <div class="card-header">
               <h3 class="card-title">Monthly Sales</h3>

               <div class="card-tools">
                 <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                 </button>
               </div>
             </div>
             <div class="card-body">
               <div id="piechart"></div>
             </div>
             <!-- /.card-body -->
           </div>
           <!-- /.card -->
</div>

@endsection



@section('admin_css')
<style media="screen">

        #piechart {
        width: 100%;
        min-height: 450px;
        }
</style>
@endsection


@section('admin_scripts')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

@php
// $app = json_decode($reportData,true);//@json($reportData);
$someArray = json_decode($reportData, true);
$data1 ='';
//print_r($someArray);

foreach ($someArray as $key => $value) {
    $data1 .=  "['".$value["month"] . "', " . $value["total"] . "],";
  }
 $data1 = rtrim($data1,',');
 @endphp

<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      google.charts.setOnLoadCallback(drawChart2);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          @php echo $data1; @endphp]);

        var options = {
          title: 'Monthly sales percentage'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }

    </script>




@endsection
