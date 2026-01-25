@extends('layouts.admin')

@section('page_header')
<h1 class="m-0 text-dark">All Users</h1>
@endsection

@section('breadcrumb_list')
<li class="breadcrumb-item active">All users</li>
@endsection

@section('content')
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-success">
        <div class="inner">
            <p>Company</p>

            <h3 class="text-center">{{$companyCount}}</h3>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="{{ url('dashboard/admins') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <p>Company Employees</p>

          <h3 class="text-center">{{$userCount[0]->count_company_users}}</h3>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="{{ url('/dashboard/users') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->

    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-warning">
        <div class="inner">
            <p>Customers</p>

            <h3 class="text-center">{{ count($customerCount)}}</h3>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <a href="{{ url('/dashboard/users') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-danger">
        <div class="inner">
            <p>Trips</p>

            <h3 class="text-center">{{$tripsCount[0]->tripsCount}}</h3>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
        <a href="{{ url('dashboard/all/trips') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->

@endsection



@section('admin_css')
    <!-- DataTables -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/datatables.net-bs4/1.10.19/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/datatables.net-responsive-bs4/2.2.3/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/css/jquery.dataTables.min.css">
@endsection


@section('admin_scripts')
    <!-- DataTables -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/jquery.dataTables.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/datatables.net-bs4/1.10.19/dataTables.bootstrap4.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/datatables-responsive/2.2.3/dataTables.responsive.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/datatables.net-responsive-bs4/2.2.3/responsive.bootstrap4.js"></script>

<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
  });
</script>

@endsection
