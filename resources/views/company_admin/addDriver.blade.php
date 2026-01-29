@extends('layouts.app')

@section('page_header')
<h1 class="m-0 text-dark">Add new driver</h1>
@endsection

@section('breadcrumb_list')
<li class="breadcrumb-item active">New driver</li>
@endsection

@section('content')

<div class="col-md-12">
    <!-- general form elements -->
    <div class="card">
        <div class="card-header">
          <h3 class="card-title">Add new Driver of <strong>{{ Auth::user()->companies[0]->company_name }}</strong></h3>
        </div>
        <!-- /.card-header -->

        <!-- form start -->
        <form role="form" action="{{ url('/company/dashboard/add/driver') }}" method="post">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label for="first_name">First Name</label> <span class="text-danger">*</span>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}"  autocomplete="first_name" placeholder="First Name..."  autofocus>
                              <div class="input-group-append">
                                <div class="input-group-text">
                                  <span class="fas fa-user"></span>
                                </div>
                              </div>

                              @error('first_name')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="last_name">Last Name</label> <span class="text-danger">*</span>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}"  autocomplete="last_name" placeholder="Last Name..." >
                                <div class="input-group-append">
                                  <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                  </div>
                                </div>
                            @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="email">Email Address</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email" placeholder="Email Address..." >
                              <div class="input-group-append">
                                <div class="input-group-text">
                                  <span class="fas fa-envelope"></span>
                                </div>
                              </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="phone">Phone Number</label> <span class="text-danger">*</span>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}"  autocomplete="phone" placeholder="Phone..." >
                              <div class="input-group-append">
                                <div class="input-group-text">
                                  <span class="fas fa-phone"></span>
                                </div>
                              </div>
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="password">Password</label> <span class="text-danger">*</span>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="new-password" placeholder="Password">
                              <div class="input-group-append">
                                <div class="input-group-text">
                                  <span class="fas fa-lock"></span>
                                </div>
                              </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="password_confirmation">Confirm Password</label> <span class="text-danger">*</span>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" name="password_confirmation" minlength="6" placeholder="Confirm Password">
                          <div class="input-group-append">
                            <div class="input-group-text">
                              <span class="fas fa-lock"></span>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="nid">NID number</label> <span class="text-danger">*</span>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control @error('nid') is-invalid @enderror" name="nid" value="{{ old('nid') }}"  autocomplete="nid" placeholder="NID number..." >
                              <div class="input-group-append">
                                <div class="input-group-text">
                                 <span class="fas fa-id-card"></span>
                                </div>
                              </div>
                          @error('nid')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="icheck-primary input-group pt-4">
                          <input type="checkbox" id="agreeTerms" class="form-control @error('terms') is-invalid @enderror" name="terms" value="agree">
                          <label for="agreeTerms">
                           I agree to the <a href="#">terms</a>
                          </label>
                          @error('terms')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                    </div>
                </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-sm">Register</button>
            </div>
        </form>
    </div>
    <!-- /.card -->
</div>
@endsection































@section('admin_css')

@endsection


@section('admin_scripts')

@endsection
