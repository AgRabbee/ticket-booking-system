@extends('layouts.admin')

@section('page_header')
<h1 class="m-0 text-dark">All Company Admins</h1>
@endsection

@section('breadcrumb_list')
<li class="breadcrumb-item active">Company Admins</li>
@endsection

@section('content')
    <div class="col-12">
      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title">All Company Admins of <strong>Ticket Booking System</strong></h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped display responsive ">
            <thead>
            <tr>
                <th>Admin</th>
                <th>Email</th>
                <th>Company Name</th>
                <th>Company Description</th>
                <th>Company Address</th>
                <th>Company Registration No.</th>
                <th>TIN No.</th>
                <th>Company Image</th>
                <th>Trade</th>
                <th>VAT</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($admin_details as $value)
                    <tr>
                        <td>{{ $value->first_name . ' ' . $value->last_name }}</td>
                        <td>{{ $value->email }}</td>
                        <td>{{ $value->company_name }}</td>
                        <td>{{ $value->description }}</td>
                        <td>{{ $value->address }}</td>
                        <td>{{ $value->reg_no }}</td>
                        <td>{{ $value->tin_no }}</td>
                        <td>
                            <a href="{{asset('storage/company_image/'.$value->company_image)}}" target="_blank"><img src="{{asset('storage/company_image/'.$value->company_image)}}" width="75" height="40" alt=""></a>
                        </td>
                        <td>
                            <a href="{{asset('storage/company_image/'.$value->trade)}}" target="_blank"><img src="{{asset('storage/company_image/'.$value->trade)}}" width="75" height="40" alt=""></a>
                        </td>
                        <td>
                            <a href="{{asset('storage/company_image/'.$value->vat)}}" target="_blank"><img src="{{asset('storage/company_image/'.$value->vat)}}" width="75" height="40" alt=""></a>
                        </td>
                        <td>
                            @if($value->status == '0')
                             <div class="d-flex">
                                  <form action="{{ url('/dashboard/admins/active') }}" method="POST">
                                      {{ csrf_field() }}
                                      <input type="hidden" name="user_id" value="{{ $value->user_id }}">
                                      <input type="hidden" name="company_id" value="{{ $value->company_id }}">
                                        <button type="submit" class="btn btn-success btn-sm swalDefaultSuccess  mr-2">
                                            <i class="fas fa-check-circle"></i>
                                        </button>
                                  </form>
                                  <form action="{{ url('/dashboard/admins/deny') }}" method="POST">
                                      {{ csrf_field() }}
                                      <input type="hidden" name="user_id" value="{{ $value->user_id }}">
                                        <input type="hidden" name="company_id" value="{{ $value->company_id }}">
                                        <button type="submit" class="btn btn-danger btn-sm swalDefaultError">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                  </form>
                              </div>
                              @elseif( $value->status == '1')
                                  <div class="d-flex">
                                      <form action="{{ url('/dashboard/admins/pause') }}" method="POST" class="mr-1">
                                          {{ csrf_field() }}
                                          <input type="hidden" name="company_id" value="{{ $value->company_id }}">
                                          <button type="submit" class="btn btn-warning btn-sm swalDefaultWarning mr-2">
                                              <i class="far fa-pause-circle"></i>
                                          </button>


                                      </form>
                                      <form action="{{ url('/dashboard/admins/deny') }}" method="POST">
                                          {{ csrf_field() }}
                                          <input type="hidden" name="user_id" value="{{ $value->user_id }}">
                                            <input type="hidden" name="company_id" value="{{ $value->company_id }}">
                                            <button type="submit" class="btn btn-danger btn-sm swalDefaultError">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                      </form>
                                  </div>


                              @elseif( $value->status == '2')
                                  <div class="d-flex">
                                      <form action="{{ url('/dashboard/admins/active') }}" method="POST"  class="mr-1">
                                          {{ csrf_field() }}
                                          <input type="hidden" name="user_id" value="{{ $value->user_id }}">
                                          <input type="hidden" name="company_id" value="{{ $value->company_id }}">
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
                <th>Admin</th>
                <th>Email</th>
                <th>Company Name</th>
                <th>Company Description</th>
                <th>Company Address</th>
                <th>Company Registration No.</th>
                <th>TIN No.</th>
                <th>Company Image</th>
                <th>Trade</th>
                <th>VAT</th>
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
      "responsive": true
    });

  });
</script>

@endsection
