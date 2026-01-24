@extends('layouts.app')

@section('page_header')
<h1 class="m-0 text-dark">User Profile</h1>
@endsection

@section('breadcrumb_list')
<li class="breadcrumb-item active">Profile</li>
@endsection

@section('content')
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" src="{{ asset('AdminLTE/dist/img/user2-160x160.jpg')}}" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">{{Auth::user()->first_name. ' ' . Auth::user()->last_name}}</h3>

                <p class="text-muted text-center">{{ Auth::user()->roles[0]->name}}</p>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">About Me</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> Education</strong>

                <p class="text-muted">
                  Business in Information Technology from the <strong>University of Greenwich</strong>
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                <p class="text-muted">Dhaka, Bangladesh</p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

                <p class="text-muted">
                  <span class="tag tag-danger">UI Design</span>
                  <span class="tag tag-success">Web Developing</span>
                  <span class="tag tag-info">Javascript</span>
                  <span class="tag tag-warning">PHP</span>
                  <span class="tag tag-primary">Laravel</span>
                </p>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
             <div class="card">
               <div class="card-header p-2">
                 <ul class="nav nav-pills">
                   <li class="nav-item"><a class="nav-link active" href="#userDetails" data-toggle="tab">Details</a></li>
                   <li class="nav-item"><a class="nav-link" href="#passwrd" data-toggle="tab">Change Password</a></li>
                 </ul>
               </div><!-- /.card-header -->
               <div class="card-body card-info">
                 <div class="tab-content">
                   <div class="active tab-pane" id="userDetails">
                     <form class="form-horizontal">
                       <div class="form-group">
                         <label for="first_name" class="col-sm-2 control-label">First Name</label>

                         <div class="col-sm-10">
                           <input type="text" class="form-control" id="first_name" value="{{ Auth::user()->first_name }}" readonly>
                         </div>
                       </div>
                       <div class="form-group">
                         <label for="last_name" class="col-sm-2 control-label">Last Name</label>

                         <div class="col-sm-10">
                           <input type="text" class="form-control" id="last_name" value="{{ Auth::user()->last_name }}" readonly>
                         </div>
                       </div>
                       <div class="form-group">
                         <label for="email" class="col-sm-2 control-label">Email</label>

                         <div class="col-sm-10">
                           <input type="email" class="form-control" id="email" value="{{ Auth::user()->email }}" readonly>
                         </div>
                       </div>
                       <div class="form-group">
                         <label for="phone" class="col-sm-2 control-label">Phone</label>

                         <div class="col-sm-10">
                           <input type="text" class="form-control" id="phone" value="{{ Auth::user()->phone }}" readonly>
                         </div>
                       </div>
                       <div class="form-group">
                         <label for="nid" class="col-sm-2 control-label">NID</label>

                         <div class="col-sm-10">
                           <input type="text" class="form-control" id="nid" value="{{ Auth::user()->nid }}" readonly>
                         </div>
                       </div>


                       <div class="form-group">
                         <div class="col-sm-offset-2 col-sm-10">
                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-edit">Update Details</a>
                         </div>
                       </div>
                     </form>
                   </div>
                   <!-- /.tab-pane -->
                   <div class="tab-pane" id="passwrd">
                       <form class="" action="{{ url('/dashboard/users/'.Auth::user()->id.'/changePassword') }}" method="post">
                           @csrf
                           <div class="form-group row">
                               <label for="c_password" class="col-md-4 col-form-label text-md-right">{{ __('Current Password') }}</label>

                               <div class="col-md-6">
                                   <input id="c_password" type="password" class="form-control @error('c_password') is-invalid @enderror" name="c_password" required autocomplete="new-password">

                                   @error('c_password')
                                       <span class="invalid-feedback" role="alert">
                                           <strong>{{ $message }}</strong>
                                       </span>
                                   @enderror
                               </div>
                           </div>
                           <div class="form-group row">
                               <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('New Password') }}</label>

                               <div class="col-md-6">
                                   <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                   @error('password')
                                       <span class="invalid-feedback" role="alert">
                                           <strong>{{ $message }}</strong>
                                       </span>
                                   @enderror
                               </div>
                           </div>

                           <div class="form-group row">
                               <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                               <div class="col-md-6">
                                   <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                               </div>
                           </div>
                           <div class="form-group">
                               <input type="submit" class="btn btn-primary btn-sm" value="Change Password">
                           </div>
                       </form>
                   </div>
                   <!-- /.tab-pane -->
                 </div>
                 <!-- /.tab-content -->
               </div><!-- /.card-body -->
             </div>
             <!-- /.nav-tabs-custom -->
           </div>


          <!--edit modal-->
          <div class="modal fade" id="modal-edit" aria-hidden="true" style="display: none;">
           <div class="modal-dialog">
               <form class="" action="{{ url('/dashboard/users/'.Auth::user()->id.'/update') }}" method="post">
                   @csrf
               <div class="modal-content">
                   <div class="modal-header">
                       <h4 class="modal-title">User Details</h4>
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">×</span>
                       </button>
                   </div>
                   <div class="modal-body">
                       <div class="form-group">
                           <label for="first_name">First Name</label>
                           <input type="text" class="form-control" id="first_name" name="first_name" value="{{ Auth::user()->first_name }}">
                       </div>

                       <div class="form-group">
                           <label for="last_name">Last Name</label>
                           <input type="text" class="form-control" id="last_name" name="last_name" value="{{ Auth::user()->last_name }}">
                       </div>

                       <div class="form-group">
                           <label for="email">Email</label>
                           <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" readonly>
                       </div>

                       <div class="form-group">
                           <label for="phone">Phone</label>
                           <input type="text" class="form-control" id="phone" name="phone" value="{{ Auth::user()->phone }}" >
                       </div>
                       <div class="form-group">
                           <label for="nid">NID</label>
                           <input type="text" class="form-control" id="nid" name="nid" value="{{ Auth::user()->nid }}" >
                       </div>
                   </div>
                   <div class="modal-footer ">
                       <input type="submit" class="btn btn-primary" name="" value="Update changes">
                   </div>
               </div>
               <!-- /.modal-content -->

              </form>
           </div>
          <!-- /.modal-dialog -->
          </div>
          <!--modal-->
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
