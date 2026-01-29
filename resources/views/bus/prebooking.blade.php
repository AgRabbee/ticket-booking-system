@extends('layouts.public')
@section('content')

<!--SEARCH-BAR-->
    <div class="container">
        <div class="row my-5">
            <div class="col-md-6">
                <div class="card card-info">
                      <div class="card-header">
                          <h3 class="card-title">Passenger Details</h3>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                          <form action="{{ url('/charge') }}" method="post" id="payment-form">
                              @csrf
                              <div class="form-group">
                                  <label for="f_name">First Name <span class="text-danger">*</span></label>
                                  <input type="text" name="f_name" id="f_name" class="form-control @error('f_name') is-invalid @enderror" required value="{{ old('f_name') }}">
                                  @error('f_name')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                  @enderror
                              </div>
                              <div class="form-group">
                                  <label for="l_name">last Name <span class="text-danger">*</span></label>
                                  <input type="text" name="l_name" id="l_name" class="form-control @error('l_name') is-invalid @enderror" required value="{{ old('l_name') }}">
                                  @error('l_name')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                  @enderror
                              </div>
                              <div class="form-group">
                                  <label for="phone">Phone <span class="text-danger">*</span></label>
                                  <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" required value="{{ old('phone') }}">
                                  @error('phone')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                  @enderror
                              </div>
                              <div class="form-group">
                                  <label for="email">Email <span class="text-muted">(optional)</span></label>
                                  <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                                  @error('email')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                  @enderror
                              </div>

                              <div class="text-center border rounded py-3">
                                  <h5>Total amount to pay: {{ ($total+21).'/-' }}</h5>
                              </div>

                            <div class="card-body">
                                <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="custom-content-below-stripe-tab" data-toggle="pill" href="#custom-content-below-stripe" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Stripe</a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-cash-on-delivery" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Cash on delivery</a>
                                    </li> --}}
                                </ul>
                                <div class="tab-content" id="custom-content-below-tabContent">
                                    <div class="tab-pane fade show active pt-3" id="custom-content-below-stripe" role="tabpanel" aria-labelledby="custom-content-below-stripe-tab">

                                          <div class="form-group">
                                            <label for="card-element">
                                              Credit or debit card
                                            </label>
                                            <div id="card-element">
                                              <!-- A Stripe Element will be inserted here. -->
                                            </div>

                                            <!-- Used to display form errors. -->
                                            <div id="card-errors" role="alert"></div>
                                          </div>

                                          <button class="btn btn-success btn-sm">Submit Payment</button>

                                    </div>
                                    {{-- <div class="tab-pane fade pt-3" id="custom-content-below-cash-on-delivery" role="tabpanel" aria-labelledby="custom-content-below-cash-on-delivery-tab">
                                        <div class="form-group">
                                            <label for="">Your Address</label>
                                            <textarea name="address" class="form-control" rows="3" cols="80"></textarea>
                                        </div>
                                        <div class="text-center">
                                            <input type="submit" class="btn btn-success btn-sm" name="" value="Confirm Reservation">
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                      </div>
                  </div>
            </div>
            <div class="col-md-6">
                <div class="card card-info">
                      <div class="card-header">
                          <h3 class="card-title">Journey Details</h3>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                           @foreach ($tripDetails as $value)
                               <p><input type="hidden" name="tripId" value="{{ $value->t_id }}"></p>

                               <p>{{ $value->start_name . ' - ' . $value->end_name}}</p>
                               <p>Company name: {{ $value->company_name }}</p>
                               <p>Journey Date: {{ $value->date .', '. $value->start_time }}</p>
                               <p>Seat(s) no:
                                   @foreach ($seats as $seat)
                                     {{ $seat.', ' }}
                                     <input type="hidden" name="seats[]" value=" {{ $seat.', ' }}">
                                   @endforeach
                                </p>
                                <p>Boarding at {{ $value->company_name.' bus counter, '.$value->start_name }}</p>

                           @endforeach

                           <br>

                           <h5>Fare Details</h5>
                           <hr>
                           <p>Ticket Price: {{ $total .'/-' }}</p>
                           <p>System fee: 21/-</p>
                           <p>Total: {{ ($total+21).'/-' }} </p>
                      </div>


                      <!--Total amount send-->
                      <input type="hidden" name="totalAmount" value="{{ $total }}">
                      <input type="hidden" name="fee" value="21">


                  </div>
            </div>

          </form>
        </div>
    </div>

<!--SEARCH-BAR-END-->

@endsection

@section('public_css')
<style media="screen">
    .StripeElement {
      box-sizing: border-box;
      height: 40px;
      padding: 10px 12px;
      border: 1px solid #ccc;
      border-radius: 4px;
      background-color: white;
      box-shadow: 0 1px 3px 0 #e6ebf1;
      -webkit-transition: box-shadow 150ms ease;
      transition: box-shadow 150ms ease;
    }

    .StripeElement--focus {
      box-shadow: 0 1px 3px 0 #cfd7df;
    }

    .StripeElement--invalid {
      border-color: #fa755a;
    }

    .StripeElement--webkit-autofill {
      background-color: #fefde5 !important;
    }
</style>
@endsection



@section('public_scripts')
<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">
    $(document).ready(function(){
        // Create a Stripe client.
        var stripe = Stripe('pk_test_qIyjmYGtr0GIZ7d6PLJOzO6S00ycAqmYYW');

        // Create an instance of Elements.
        var elements = stripe.elements();

        // Custom styling can be passed to options when creating an Element.
        // (Note that this demo uses a wider set of styles than the guide below.)
        var style = {
          base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
              color: '#aab7c4'
            }
          },
          invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
          }
        };

        // Create an instance of the card Element.
        var card = elements.create('card', {style: style});

        // Add an instance of the card Element into the `card-element` <div>.
        card.mount('#card-element');

        // Handle real-time validation errors from the card Element.
        card.addEventListener('change', function(event) {
          var displayError = document.getElementById('card-errors');
          if (event.error) {
            displayError.textContent = event.error.message;
          } else {
            displayError.textContent = '';
          }
        });

        // Handle form submission.
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
          event.preventDefault();

          stripe.createToken(card).then(function(result) {
            if (result.error) {
              // Inform the user if there was an error.
              var errorElement = document.getElementById('card-errors');
              errorElement.textContent = result.error.message;
            } else {
              // Send the token to your server.
              stripeTokenHandler(result.token);
            }
          });
        });

        // Submit the form with the token ID.
        function stripeTokenHandler(token) {
          // Insert the token ID into the form so it gets submitted to the server
          var form = document.getElementById('payment-form');
          var hiddenInput = document.createElement('input');
          hiddenInput.setAttribute('type', 'hidden');
          hiddenInput.setAttribute('name', 'stripeToken');
          hiddenInput.setAttribute('value', token.id);
          form.appendChild(hiddenInput);

          // console.log(token);
          // Submit the form
          form.submit();
        }
    });

</script>
@endsection
