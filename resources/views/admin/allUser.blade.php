@extends('layouts.admin')

@section('page_header')
<h1 class="m-0 text-dark">All Users</h1>
@endsection

@section('breadcrumb_list')
<li class="breadcrumb-item active">All users</li>
@endsection

@section('content')
    <div class="col-12">
      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title">All company's employee of <strong>Ticket Booking System</strong></h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped display responsive">
            <thead>
            <tr>
                <th>User Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>NID</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($users as $value)
                <tr>
                    <td>{{ $value->first_name. ' '. $value->last_name }}</td>
                    <td>{{ $value->email }}</td>
                    <td>{{ $value->phone }}</td>
                    <td>{{ $value->nid }}</td>
                    <td>
                        @if($value->user_status == '0')
                         <div class="d-flex">
                              <form action="{{ url('/dashboard/users/active') }}" method="POST">
                                  {{ csrf_field() }}
                                  <input type="hidden" name="user_id" value="{{ $value->id }}">
                                    <button type="submit" class="btn btn-success btn-sm swalDefaultSuccess  mr-2">
                                        <i class="fas fa-check-circle"></i>
                                    </button>
                              </form>
                              <form action="{{ url('/dashboard/users/deny') }}" method="POST">
                                  {{ csrf_field() }}
                                  <input type="hidden" name="user_id" value="{{ $value->id }}">
                                    <button type="submit" class="btn btn-danger btn-sm swalDefaultError">
                                        <i class="fas fa-ban"></i>
                                    </button>
                              </form>
                          </div>
                      @elseif( $value->user_status == '1')
                          <div class="d-flex">
                              <form action="{{ url('/dashboard/users/pause') }}" method="POST" class="mr-1">
                                  {{ csrf_field() }}
                                  <input type="hidden" name="user_id" value="{{ $value->id }}">
                                  <button type="submit" class="btn btn-warning btn-sm swalDefaultWarning mr-2">
                                      <i class="far fa-pause-circle"></i>
                                  </button>


                              </form>
                              <form action="{{ url('/dashboard/users/deny') }}" method="POST">
                                  {{ csrf_field() }}
                                  <input type="hidden" name="user_id" value="{{ $value->id }}">
                                    <button type="submit" class="btn btn-danger btn-sm swalDefaultError">
                                        <i class="fas fa-ban"></i>
                                    </button>
                              </form>
                          </div>


                      @elseif( $value->user_status == '2')
                          <div class="d-flex">
                              <form action="{{ url('/dashboard/users/active') }}" method="POST"  class="mr-1">
                                  {{ csrf_field() }}
                                  <input type="hidden" name="user_id" value="{{ $value->id }}">
                                    <button type="submit" class="btn btn-success btn-sm swalDefaultSuccess mr-2">
                                        <i class="fas fa-check-circle"></i>
                                    </button>
                              </form>

                              <button type="button" disabled class="btn btn-danger btn-sm">
                                  <i class="fas fa-times-circle"></i>
                              </button>
                          </div>
                  @endif
                    </td>
                </tr>

                @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th>User Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>NID</th>
                <th>Action</th>
            </tr>
            </tfoot>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->




    <div class="col-12">
      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title">All customers of <strong>Ticket Booking System</strong></h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped display responsive">
            <thead>
            <tr>
                <th>User Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>NID</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($customers as $value)
                <tr>
                    <td>{{ $value->first_name. ' '. $value->last_name }}</td>
                    <td>{{ $value->email }}</td>
                    <td>{{ $value->phone }}</td>
                    <td>{{ $value->nid }}</td>
                    <td>
                        @if($value->user_status == '0')
                         <div class="d-flex">
                              <form action="{{ url('/dashboard/users/active') }}" method="POST">
                                  {{ csrf_field() }}
                                  <input type="hidden" name="user_id" value="{{ $value->u_id }}">
                                    <button type="submit" class="btn btn-success btn-sm swalDefaultSuccess  mr-2">
                                        <i class="fas fa-check-circle"></i>
                                    </button>
                              </form>
                              <form action="{{ url('/dashboard/users/deny') }}" method="POST">
                                  {{ csrf_field() }}
                                  <input type="hidden" name="user_id" value="{{ $value->u_id }}">
                                    <button type="submit" class="btn btn-danger btn-sm swalDefaultError">
                                        <i class="fas fa-ban"></i>
                                    </button>
                              </form>
                          </div>
                      @elseif( $value->user_status == '1')
                          <div class="d-flex">
                              <form action="{{ url('/dashboard/users/pause') }}" method="POST" class="mr-1">
                                  {{ csrf_field() }}
                                  <input type="hidden" name="user_id" value="{{ $value->u_id }}">
                                  <button type="submit" class="btn btn-warning btn-sm swalDefaultWarning mr-2">
                                      <i class="far fa-pause-circle"></i>
                                  </button>


                              </form>
                              <form action="{{ url('/dashboard/users/deny') }}" method="POST">
                                  {{ csrf_field() }}
                                  <input type="hidden" name="user_id" value="{{ $value->u_id }}">
                                    <button type="submit" class="btn btn-danger btn-sm swalDefaultError">
                                        <i class="fas fa-ban"></i>
                                    </button>
                              </form>
                          </div>


                      @elseif( $value->user_status == '2')
                          <div class="d-flex">
                              <form action="{{ url('/dashboard/users/active') }}" method="POST"  class="mr-1">
                                  {{ csrf_field() }}
                                  <input type="hidden" name="user_id" value="{{ $value->u_id }}">
                                    <button type="submit" class="btn btn-success btn-sm swalDefaultSuccess mr-2">
                                        <i class="fas fa-check-circle"></i>
                                    </button>
                              </form>

                              <button type="button" disabled class="btn btn-danger btn-sm">
                                  <i class="fas fa-times-circle"></i>
                              </button>
                          </div>
                  @endif
                    </td>
                </tr>

                @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th>User Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>NID</th>
                <th>Action</th>
            </tr>
            </tfoot>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->


@endsection



@section('admin_css')

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/datatables-responsive/css/jquery.dataTables.min.css')}}">


@endsection


@section('admin_scripts')

    <!-- DataTables -->
    <script src="{{ asset('AdminLTE/plugins/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{ asset('AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{ asset('AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.js')}}"></script>
    <script src="{{ asset('AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.js')}}"></script>

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
