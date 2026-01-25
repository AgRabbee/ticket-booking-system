<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ticket Booking System| Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css')}}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/admin-lte/3.0.0-rc.3/css/adminlte.min.css">
    <style media="screen">
        .register-box {
            margin: 2% auto;
            width: 660px;
        }

        .blink {
            text-align: center;
        }

        .blink a {
            font-size: 36px;
            animation: blink 2.5s ease-in-out infinite;
        }

        @keyframes blink {
            0% {
                opacity: 0;
                font-weight: 0;
            }
            25% {
                opacity: .5;
                font-weight: 400;
            }
            50% {
                opacity: 1;
                font-weight: 500;
            }
            75% {
                opacity: .5;
                font-weight: 400;
            }
            100% {
                opacity: 0;
                font-weight: 0;
            }
            /* 0%{opacity: 0;}
            50%{opacity: .5;}
            100%{opacity: 1;} */
        }
    </style>
</head>
<body class="hold-transition register-page">
<div class="register-box">
    <div class="register-logo blink">
        <a href="{{ url('/') }}">Bus Ticket Booking System</a>
    </div>

    <div class="card">
        <div class="card-body register-card-body">
            <p class="login-box-msg">Register a new membership</p>

            <form id="sign_up" method="POST" action="{{ url('/signUp') }}">
                {{ csrf_field() }}

                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="first_name">First Name</label> <span class="text-danger">*</span>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                       name="first_name" value="{{ old('first_name') }}" autocomplete="first_name"
                                       placeholder="First Name..." required autofocus>
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
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                       name="last_name" value="{{ old('last_name') }}" autocomplete="last_name"
                                       placeholder="Last Name..." required>

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

                    <div class="row px-2">
                        <label for="email">Email</label> <span class="text-danger">*</span>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                                   value="{{ old('email') }}" autocomplete="email" placeholder="Email Address..."
                                   required>

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

                    <div class="row">
                        <div class="col-md-6">
                            <label for="password">Your Password</label> <span class="text-danger">*</span>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                       name="password" required autocomplete="new-password" placeholder="Password"
                                       required>

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
                            <label for="password_confirmation">Confirm Your Password</label> <span
                                class="text-danger">*</span>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" name="password_confirmation" minlength="6"
                                       placeholder="Confirm Password" required>
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
                            <label for="phone">Phone</label> <span class="text-danger">*</span>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                       name="phone" value="{{ old('phone') }}" autocomplete="phone"
                                       placeholder="Phone..." required>
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
                        <div class="col-md-6">
                            <label for="nid">NID Number</label> <span class="text-danger">*</span>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control @error('nid') is-invalid @enderror" name="nid"
                                       value="{{ old('nid') }}" autocomplete="nid" placeholder="NID number..." required>

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
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                                <label for="agreeTerms">
                                    I agree to the <a href="#">terms</a>
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </div>

            </form>

            {{-- <div class="social-auth-links text-center">
              <p>- OR -</p>
              <a href="#" class="btn btn-block btn-primary">
                <i class="fab fa-facebook mr-2"></i>
                Sign up using Facebook
              </a>
              <a href="#" class="btn btn-block btn-danger">
                <i class="fab fa-google-plus mr-2"></i>
                Sign up using Google+
              </a>
            </div> --}}

            <a href="{{ url('/signIn') }}" class="text-center mt-3 px-2">I already have a membership</a>
        </div>
        <!-- /.form-box -->
    </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="//cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
