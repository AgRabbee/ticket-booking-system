@extends('layouts.public')
@section('page_header')
    <div class="card card-info">
        <div class="card-header">
            <h3>Register your company</h3>
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-8">
            <form action="{{ url('/company/register') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card-body">
                    <div class="form-group">
                        <label for="company_name">Company name</label>
                        <div class="form-line">
                            <input type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ old('company_name') }}"  autocomplete="company_name" placeholder="Type your company name...">

                            @error('company_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="company_description">Company Description</label>
                        <div class="form-line">
                            <textarea id="company_description" class="form-control @error('company_description') is-invalid @enderror" name="company_description" value="{{ old('company_description') }}"  autocomplete="company_description" rows="3" placeholder="Type your company description..."></textarea>
                            @error('company_description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address">Company Address</label>
                        <div class="form-line">
                            <input type="text" id="address" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}"  autocomplete="address" placeholder="Type your company address...">
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="reg_no">Company Registration No</label>
                        <div class="form-line">
                            <input type="text" id="reg_no" class="form-control @error('reg_no') is-invalid @enderror" name="reg_no" value="{{ old('reg_no') }}"  autocomplete="reg_no" placeholder="Type your company registration no...">
                            @error('reg_no')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="company_image">Upload Company Image</label>
                                <input type="file" id="company_image" name="company_image">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tin_no">TIN Number</label>
                                <div class="form-line">
                                    <input type="text" id="tin_no" class="form-control @error('tin_no') is-invalid @enderror" name="tin_no" value="{{ old('tin_no') }}"  autocomplete="tin_no" placeholder="Type your company TIN number...">
                                    @error('tin_no')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="trade">Upload Trade License</label>
                                <input type="file" id="trade" name="trade" class="form-control  @error('trade') is-invalid @enderror">
                                @error('trade')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="vat">Upload Vat Registration Certificate</label>
                                <input type="file" id="vat" name="vat" class="form-control  @error('vat') is-invalid @enderror">
                                @error('vat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <input type="submit" class="btn btn-primary btn-sm mx-auto mt-3 d-block" name="submit" value="Register Company">
                </div>
            </form>
        </div>

        <div class="col-md-4">

        </div>
    </div>
@endsection
