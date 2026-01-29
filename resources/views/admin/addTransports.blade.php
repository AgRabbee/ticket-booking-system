@extends('layouts.admin')

@section('page_header')
<h1 class="m-0 text-dark">Add New Type</h1>
@endsection

@section('breadcrumb_list')
<li class="breadcrumb-item active">New transport type</li>
@endsection

@section('content')
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Add new transport type for <strong>Ticket Booking System</strong></h3>
            </div>
            <!-- /.card-header -->

            <!-- form start -->
            <form role="form" action="{{ url('/dashboard/add/transport') }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="date">Transport Type</label>
                                <div class="form-line">
                                    <input type="text" class="form-control @error('type') is-invalid @enderror" name="type" value="{{ old('type') }}"  autocomplete="type"  id="type" placeholder="Enter type">

                                @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="time">AC/NON-AC</label>
                                <div class="form-line">
                                        <div class="form-check form-check-inline">
                                          <input class="form-check-input  @error('ac/non-ac') is-invalid @enderror" type="radio" name="ac/non-ac" id="inlineRadio1" value="1">
                                          <label class="form-check-label" for="inlineRadio1">AC</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                          <input class="form-check-input  @error('ac/non-ac') is-invalid @enderror" type="radio" name="ac/non-ac" id="inlineRadio2" value="2">
                                          <label class="form-check-label" for="inlineRadio2">NON-AC</label>
                                        </div>

                                @error('ac/non-ac')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div><!-- /.col -->
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
