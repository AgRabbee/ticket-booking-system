<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-5">
    <a class="navbar-brand" href="{{ url('/') }}">Ticket Booking System</a>

    <div class="collapse navbar-collapse d-flex justify-content-end" id="navbarSupportedContent">
        <ul class="navbar-nav">
            @guest
            @else
                @if (Auth::user()->id != 1)
                    @if (!Auth::user()->companies->count())
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="modal" data-target="#company_register" href="#"><i class="far fa-building"></i> Register your Company</a>
                        </li>
                    @endif
                @endif
            @endguest



            <!-- User Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#"><i class="far fa-user"></i></a>

                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    @guest
                        <span class="dropdown-item dropdown-header">Sign In / Sign Up</span>
                        <div class="dropdown-divider"></div>
                        <a href="{{ url('/signIn') }}" class="dropdown-item">
                            <i class="fas fa-sign-in-alt mr-2"></i> Sign In
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ url('/signUp') }}" class="dropdown-item">
                            <i class="fas fa-user-plus mr-2"></i> Sign Up
                        </a>
                    @else
                        <span class="dropdown-item dropdown-header">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name}}</span>

                        <div class="dropdown-divider"></div>


                        @if (Auth::user()->roles[0]->name == 'Customer')
                            @if (Auth::user()->roles[0]->name == 'Super Admin')
                                <a href="{{ url('/dashboard') }}" class="dropdown-item">
                                    <i class="fas fa-address-card mr-2"></i> Dashboard
                                </a>
                            @elseif (Auth::user()->companies->count() && Auth::user()->companies[0]->company_status == 1)
                                <a href="{{ url('/company/dashboard') }}" class="dropdown-item">
                                    <i class="fas fa-address-card mr-2"></i> Dashboard
                                </a>
                            @endif
                        @endif

                        <div class="dropdown-divider"></div>

                        <a href="{{ route('logOut') }}" class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt mr-2"></i> Sign Out
                        </a>
                            <form id="logout-form" action="{{ route('logOut') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                            </form>
                    @endguest
                </div>
            </li>

        </ul>
    </div>
</nav>

<!-- /.modal -->
<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-success">Announcement!!!</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Coming up with the next update...</p>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default mx-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- /.company_register -->
<div class="modal fade" id="company_register">
  <div class="modal-dialog modal-lg">
      <form action="{{ url('/company/register') }}" method="post" enctype="multipart/form-data">
      {{ csrf_field() }}
        <div class="modal-content">
          <div class="modal-header bd-info">
            <h3 class="modal-title">Register your company</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
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
                          <div class="input-group">
                              <input type="file" class="form-control" name="company_image" id="company_image">
                              <label class="custom-file-label" for="company_image">Choose file</label>
                          </div>
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
                          <div class="input-group">
                              <input type="file" class="form-control @error('trade') is-invalid @enderror" name="trade" id="trade" value="{{ old('tradetrade') }}">
                              <label class="custom-file-label" for="trade">Choose file</label>
                              @error('trade')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="vat">Upload Vat Registration Certificate</label>
                        <div class="input-group">
                            <input type="file" class="form-control @error('vat') is-invalid @enderror" name="vat" id="vat" value="{{ old('vat') }}">
                            <label class="custom-file-label" for="vat">Choose file</label>
                            @error('vat')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                  </div>
              </div>
          </div>
          <div class="modal-footer justify-content-around">
            <button type="button" class="btn btn-default mx-auto" data-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-primary mx-auto" name="submit" value="Register Company">
          </div>
        </div>
        <!-- /.modal-content -->
    </form>
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
