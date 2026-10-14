@extends('layouts.public')

@section('title', 'Passenger and payment')

@section('content')
    @php
        $trip = $tripDetails->first();
        $fee = 21;
        $ticketPrice = $trip->fare * count($seats);
        $journeyDate = \Carbon\Carbon::parse($trip->date);
    @endphp

    <div class="pagehead">
        <div class="wrap">
            <ol class="steps" aria-label="Booking progress">
                <li>Search</li>
                <li>Choose seats</li>
                <li aria-current="step">Pay</li>
                <li>Ticket</li>
            </ol>
            <h1>Passenger and payment</h1>
            <p>{{ count($seats) }} {{ Str::plural('seat', count($seats)) }} on the {{ $trip->start_time }} {{ $trip->company_name }} bus, {{ $journeyDate->format('j F') }}.</p>
        </div>
    </div>

    <div class="wrap pull">
        <form class="checkout" action="{{ url('/charge') }}" method="post" id="payment-form">
            @csrf
            <input type="hidden" name="tripId" value="{{ $trip->t_id }}">
            <input type="hidden" name="totalAmount" value="{{ $ticketPrice }}">
            <input type="hidden" name="fee" value="{{ $fee }}">
            @foreach ($seats as $seat)
                <input type="hidden" name="seats[]" value="{{ trim($seat, " ,") }}">
            @endforeach

            <div class="stack">
                @if ($errors->any())
                    <div class="alert alert--danger" role="alert">
                        <span class="icon" aria-hidden="true">error</span>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <section class="sheet sheet--lg">
                    <h2 class="sheet__title">Passenger</h2>
                    <div class="form-grid form-grid--2">
                        <label class="field @error('f_name') field--error @enderror">
                            <span class="field__label">First name</span>
                            <input type="text" name="f_name" id="f_name" value="{{ old('f_name') }}" autocomplete="given-name" required>
                        </label>
                        <label class="field @error('l_name') field--error @enderror">
                            <span class="field__label">Last name</span>
                            <input type="text" name="l_name" id="l_name" value="{{ old('l_name') }}" autocomplete="family-name" required>
                        </label>
                        <label class="field @error('phone') field--error @enderror">
                            <span class="field__label">Phone</span>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" autocomplete="tel" required>
                        </label>
                        <div>
                            <label class="field @error('email') field--error @enderror">
                                <span class="field__label">Email (optional)</span>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" autocomplete="email">
                            </label>
                            <p class="field-hint">We send the booking details here.</p>
                        </div>
                    </div>
                </section>

                <section class="sheet sheet--lg">
                    <h2 class="sheet__title">Card payment</h2>
                    <div class="alert alert--amber" style="margin-bottom:20px">
                        <span class="icon" aria-hidden="true">info</span>
                        <span><strong>Demo payment.</strong> Stripe is in test mode, so no real money moves. Use card <strong class="num">4242 4242 4242 4242</strong>, any future expiry date, any CVC and any postcode.</span>
                    </div>
                    <div class="field">
                        <label class="field__label" for="card-element">Credit or debit card</label>
                        <div id="card-element"></div>
                    </div>
                    <div id="card-errors" role="alert"></div>
                    <div class="form-actions">
                        <button class="btn" type="submit" id="pay-button"><span class="icon" aria-hidden="true">lock</span> Pay BDT {{ number_format($ticketPrice + $fee) }}</button>
                        <a class="btn btn--text" href="{{ url('/') }}">Cancel</a>
                    </div>
                </section>
            </div>

            <aside class="sheet sheet--lg" aria-labelledby="journey-title">
                <h2 class="sheet__title" id="journey-title">Your journey</h2>
                <div class="pagehead__route" style="font:600 1.5rem/1.2 var(--font-display)">
                    {{ $trip->start_name }} <span class="route__track" aria-hidden="true" style="max-width:56px"></span><span class="sr-only">to</span> {{ $trip->end_name }}
                </div>
                <dl class="summary" style="margin-top:16px">
                    <div><dt>Operator</dt><dd>{{ $trip->company_name }}</dd></div>
                    <div><dt>Date</dt><dd>{{ $journeyDate->format('D, j M Y') }}</dd></div>
                    <div><dt>Departs</dt><dd>{{ $trip->start_time }}</dd></div>
                    <div><dt>Seats</dt><dd>{{ collect($seats)->map(fn($seat) => trim($seat, " ,"))->implode(', ') }}</dd></div>
                    <div><dt>Boarding</dt><dd>{{ $trip->company_name . ' bus counter, ' . $trip->start_name }}</dd></div>
                    <div><dt>Ticket price ({{ count($seats) }} × {{ number_format($trip->fare) }})</dt><dd>BDT {{ number_format($ticketPrice) }}</dd></div>
                    <div><dt>System fee</dt><dd>BDT {{ $fee }}</dd></div>
                    <div class="summary__total"><dt>Total</dt><dd>BDT {{ number_format($ticketPrice + $fee) }}</dd></div>
                </dl>
            </aside>
        </form>
    </div>
@endsection

@section('public_scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        (function () {
            var form = document.getElementById('payment-form');
            var button = document.getElementById('pay-button');
            var errors = document.getElementById('card-errors');
            var label = button.innerHTML;

            if (typeof Stripe === 'undefined') {
                errors.textContent = 'The card form did not load. Check your connection and reload this page.';
                button.disabled = true;
                return;
            }

            var stripe = Stripe(@json(config('services.stripe.key') ?: 'pk_test_qIyjmYGtr0GIZ7d6PLJOzO6S00ycAqmYYW'));
            var card = stripe.elements().create('card', {
                style: {
                    base: {
                        color: '#16201B',
                        fontFamily: 'Roboto, system-ui, sans-serif',
                        fontSize: '16px',
                        '::placeholder': { color: '#5C6A63' }
                    },
                    invalid: { color: '#B3261E', iconColor: '#B3261E' }
                }
            });
            card.mount('#card-element');

            card.addEventListener('change', function (event) {
                errors.textContent = event.error ? event.error.message : '';
            });

            form.addEventListener('submit', function (event) {
                event.preventDefault();
                button.disabled = true;
                button.textContent = 'Processing payment…';

                stripe.createToken(card).then(function (result) {
                    if (result.error) {
                        errors.textContent = result.error.message;
                        button.disabled = false;
                        button.innerHTML = label;
                        return;
                    }

                    var input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'stripeToken';
                    input.value = result.token.id;
                    form.appendChild(input);
                    form.submit();
                });
            });
        })();
    </script>
@endsection
