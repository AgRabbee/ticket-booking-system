@extends('layouts.admin')

@section('page_header')
<h1 class="m-0 text-dark">All Transport Types</h1>
@endsection

@section('breadcrumb_list')
<li class="breadcrumb-item active">Transport types</li>
@endsection

@section('content')
    <div class="col-12">
      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title">All transport types of <strong>Ticket Booking System</strong></h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped display responsive">
            <thead>
            <tr>
                <th>Transport Type</th>
                <th>Ac/Non-ac</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($transports as $value)
                <tr>
                    <td>{{ $value->transport_type }}</td>
                    <td>
                        @if ($value->ac_type == 1)
                            AC
                        @else
                            NON-AC
                        @endif

                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="#" class="btn btn-primary" type="button" data-toggle="modal" data-target="#modal-edit{{ $value->id }}"><i class="fas fa-edit"></i></a>
                            <a href="#" class="btn btn-danger" type="button" data-toggle="modal" data-target="#modal-delete{{ $value->id }}"><i class="fas fa-trash"></i></a>
                      </div>
                    </td>
                </tr>



                <!--edit modal-->
                    <div class="modal fade" id="modal-edit{{ $value->id }}" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                            <form class="" action="{{ url('/dashboard/edit/'.$value->id.'/transport') }}" method="post">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Edit Transport</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="type" value="{{ $value->transport_type }}">
                                        </div>
                                        <div class="form-group">
                                            @if ($value->ac_type == 1)
                                                <div class="form-check form-check-inline">
                                                  <input class="form-check-input" type="radio" name="ac_type" id="inlineRadio1" checked value="1">
                                                  <label class="form-check-label" for="inlineRadio1">AC</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                  <input class="form-check-input" type="radio" name="ac_type" id="inlineRadio2" value="2">
                                                  <label class="form-check-label" for="inlineRadio2">NON-AC</label>
                                                </div>
                                            @else
                                                <div class="form-check form-check-inline">
                                                  <input class="form-check-input" type="radio" name="ac_type" id="inlineRadio1" value="1">
                                                  <label class="form-check-label" for="inlineRadio1">AC</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                  <input class="form-check-input" type="radio" name="ac_type" id="inlineRadio2" checked value="2">
                                                  <label class="form-check-label" for="inlineRadio2">NON-AC</label>
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <input type="submit" class="btn btn-primary" name="" value="Update changes">
                                    </div>
                                </div>
                            <!-- /.modal-content -->
                            </form>
                        </div>
                    <!-- /.modal-dialog -->
                    </div>
                <!--modal-->

                <!--delete modal-->
                    <div class="modal fade" id="modal-delete{{ $value->id }}" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                            <form class="" action="{{ url('/dashboard/delete/'.$value->id.'/transport') }}" method="post">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Default Modal</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure to delete the transport record??</p>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                        <input type="submit" class="btn btn-primary" name="" value="Proceed">
                                    </div>
                                </div>
                            <!-- /.modal-content -->
                            </form>
                        </div>
                    <!-- /.modal-dialog -->
                    </div>
                <!--modal-->





                @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th>Transport Type</th>
                <th>Ac/Non-ac</th>
                <th>Actions</th>
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
    });
  });
</script>

@endsection
