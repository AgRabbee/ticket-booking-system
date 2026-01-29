@extends('layouts.app')

@section('page_header')
<h1 class="m-0 text-dark">Add new Transport</h1>
@endsection

@section('breadcrumb_list')
<li class="breadcrumb-item active">New Transport</li>
@endsection

@section('content')

<div class="col-md-12">
    <!-- general form elements -->
    <div class="card">
        <div class="card-header">
          <h3 class="card-title">All Trips of <strong>{{ Auth::user()->companies[0]->company_name }}</strong></h3>
        </div>
        <!-- /.card-header -->

        <!-- form start -->
        <form role="form" action="{{ url('/company/add/transport') }}" method="post">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date">Transport Type</label> <span class="text-danger">*</span>
                            <div class="form-line">
                                <select class="form-control @error('transport_type') is-invalid @enderror" name="transport_type" >
                                    <option value="">--Select One--</option>
                                    @foreach ($transport_types as $value)
                                        @if ($value->ac_type == 1)
                                            <option value="{{ $value->id }}">{{ $value->transport_type }} - AC</option>
                                        @else
                                            <option value="{{ $value->id }}">{{ $value->transport_type }} - NON-AC</option>
                                        @endif

                                    @endforeach
                                </select>
                            @error('transport_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="time">Total Seats</label> <span class="text-danger">*</span>
                            <div class="form-line">
                                <input type="number" class="form-control @error('total_seats') is-invalid @enderror" name="total_seats"  value="{{ old('total_seats') }}"  autocomplete="total_seats"  id="total_seats" placeholder="No of Total seats">
                            @error('total_seats')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="time">Registration No.</label> <span class="text-danger">*</span>
                            <div class="form-line">
                                <input type="text" class="form-control @error('registration_no') is-invalid @enderror" name="registration_no"  value="{{ old('registration_no') }}"  autocomplete="registration_no"  id="registration_no" placeholder="Registration no...">
                            @error('registration_no')
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
                <input type="submit" class="btn btn-primary" name="" value="Add">
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
