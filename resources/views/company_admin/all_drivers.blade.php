@extends('layouts.app')

@section('page_header')
<h1 class="m-0 text-dark">All Drivers</h1>
@endsection

@section('breadcrumb_list')
<li class="breadcrumb-item active">All Drivers</li>
@endsection

@section('content')

<div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">All Drivers of <strong>{{ Auth::user()->companies[0]->company_name }}</strong></h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
          <tr>
              <th>User Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>NID</th>
          </tr>
          </thead>
          <tbody>
              @foreach ($driver_details as $value)
                  <tr>
                      <td>{{ $value->first_name. ' ' . $value->last_name }}</td>
                      <td>{{ $value->email }}</td>
                      <td>{{ $value->phone }}</td>
                      <td>{{ $value->nid }}</td>
                  </tr>
              @endforeach
          </tbody>
          <tfoot>
          <tr>
              <th>User Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>NID</th>
          </tr>
          </tfoot>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>

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
      $('#example1').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "order": []
      });

  });
</script>
@endsection
