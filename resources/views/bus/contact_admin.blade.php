@extends('layouts.public')
@section('content')

    {{-- @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}}

    @if (session()->has('message'))
        <div class="alert alert-{{ session('type') }}">
            {{ session('message') }}
        </div>
    @endif


<!--SEARCH-BAR-->
    <div class="container">
        <form action="{{ url('/contact') }}" method="post">
            @csrf
        <div class="col-md-9 msg-box">
            <div class="card card-info ">
              <div class="card-header">
                <h3 class="card-title">Compose New Message</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="form-group">
                    <label for="subject">Subject</label><span class="text-danger">*</span>
                  <input class="form-control @error('subject') is-invalid @enderror" type="text" id="subject" value="{{ old('subject') }}" name="subject" required>
                  @error('subject')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>
                <div class="form-group">
                    <label for="email">Your Registered Email</label><span class="text-danger">*</span>
                    <input class="form-control @error('email') is-invalid @enderror" type="email"id="email" value="{{ old('email') }}" name="email" required>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="msg">Your Message</label>
                    <textarea name="msg" rows="5" cols="80" class="form-control"></textarea>
                </div>

              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <div class="float-right">
                  <button type="submit" class="btn btn-primary"><i class="far fa-envelope"></i> Send</button>
                </div>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
      </form>
    </div>
@endsection


@section('public_css')
    <style media="screen">
    .msg-box{
    		width:100%;
            margin: 0 auto;
    	}
</style>

@endsection
@section('public_scripts')
    <script type="text/javascript">


    </script>

@endsection
