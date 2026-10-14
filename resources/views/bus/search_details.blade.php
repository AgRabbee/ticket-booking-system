@extends('layouts.public')

@section('title', 'Choose a bus')

@section('content')
    @php
        $first = $search_details->first();
        $journeyDate = \Carbon\Carbon::parse($first->date);
    @endphp

    <div class="pagehead">
        <div class="wrap">
            <ol class="steps" aria-label="Booking progress">
                <li>Search</li>
                <li aria-current="step">Choose seats</li>
                <li>Pay</li>
                <li>Ticket</li>
            </ol>
            <h1 class="pagehead__route">{{ $first->start_name }} <span class="route__track" aria-hidden="true"></span><span class="sr-only">to</span> {{ $first->end_name }}</h1>
            <p>{{ $journeyDate->format('l, j F Y') }} · {{ $search_details->count() }} {{ Str::plural('bus', $search_details->count()) }} · <a href="{{ url('/') }}#search" style="color:var(--amber)">Change search</a></p>
        </div>
    </div>

    <div class="wrap pull">
        @foreach ($search_details as $value)
            @php
                [$clock, $meridiem] = array_pad(explode(' ', $value->start_time, 2), 2, '');
                $boarding = $value->company_name . ' bus counter, ' . $value->start_name;
            @endphp
            <article class="sheet trip" data-trip="{{ $value->t_id }}" data-fare="{{ $value->fare }}">
                <div class="trip__row">
                    <div class="trip__time">{{ $clock }}<small> {{ $meridiem }}</small></div>
                    <div>
                        <h2 class="trip__name">{{ $value->company_name }}</h2>
                        <div class="trip__tags">
                            <span class="chip">{{ $value->ac_type == '1' ? 'AC' : 'Non-AC' }}</span>
                            <span class="chip">Bus {{ $value->registration_no }}</span>
                            @if ($value->seats_left == 0)
                                <span class="chip chip--low">Sold out</span>
                            @elseif ($value->seats_left <= 5)
                                <span class="chip chip--low">{{ $value->seats_left }} {{ Str::plural('seat', $value->seats_left) }} left</span>
                            @else
                                <span class="chip chip--green">{{ $value->seats_left }} of {{ $value->total_seats }} seats free</span>
                            @endif
                        </div>
                    </div>
                    <div class="trip__fare"><small>per seat</small>BDT {{ number_format($value->fare) }}</div>
                    <button class="btn" type="button" data-seats-toggle aria-expanded="false" aria-controls="seats-panel-{{ $value->t_id }}" @disabled($value->seats_left == 0)>Select seats</button>
                </div>

                <div class="trip__panel" id="seats-panel-{{ $value->t_id }}" hidden>
                    <form class="trip__panel-grid" action="{{ url('/bus/booking') }}" method="post">
                        @csrf
                        <input type="hidden" name="trip_id" value="{{ $value->t_id }}">
                        <input type="hidden" name="total" value="0" data-total-input>
                        <input type="hidden" name="boarding_point" value="{{ $boarding }}">

                        <div class="bus" style="margin:0">
                            <div class="bus__front">
                                <span>Front of bus</span>
                                <span class="icon" aria-hidden="true" title="Driver">airline_seat_recline_normal</span>
                            </div>
                            <div class="seats" data-seats aria-label="Seat map">
                                <p class="loading" style="grid-column:1 / -1"><span class="spinner" aria-hidden="true"></span> Loading seats…</p>
                            </div>
                            <div class="legend">
                                <span><i></i> Available</span>
                                <span><i class="is-selected"></i> Selected</span>
                                <span><i class="is-booked"></i> Booked</span>
                            </div>
                        </div>

                        <div>
                            <h3>Your seats</h3>
                            <ul class="picked" data-picked aria-live="polite">
                                <li class="picked__none">Tap a free seat on the map to add it.</li>
                            </ul>
                            <div class="tally" style="border-top:0">
                                <span>Ticket price</span>
                                <strong data-total-text>BDT 0</strong>
                            </div>
                            <p class="field-hint" style="margin:16px 0 0"><strong>Boarding:</strong> {{ $boarding }}</p>
                            <div class="form-actions">
                                <button class="btn" type="submit" data-continue disabled>Continue to payment <span class="icon" aria-hidden="true">arrow_forward</span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </article>
        @endforeach
    </div>
@endsection

@section('public_scripts')
    <script>
        (function () {
            var seatsUrl = @json(url('/seat_allocations'));

            function money(amount) {
                return 'BDT ' + amount.toLocaleString('en-US');
            }

            document.querySelectorAll('[data-trip]').forEach(function (trip) {
                var toggle = trip.querySelector('[data-seats-toggle]');
                var panel = trip.querySelector('.trip__panel');
                var map = trip.querySelector('[data-seats]');
                var picked = trip.querySelector('[data-picked]');
                var totalText = trip.querySelector('[data-total-text]');
                var totalInput = trip.querySelector('[data-total-input]');
                var submit = trip.querySelector('[data-continue]');
                var fare = Number(trip.dataset.fare);
                var loaded = false;

                function refresh() {
                    var chosen = Array.prototype.slice.call(map.querySelectorAll('.seat[aria-pressed="true"]'));
                    picked.innerHTML = '';
                    panel.querySelectorAll('input[name="seats[]"]').forEach(function (input) { input.remove(); });

                    if (!chosen.length) {
                        picked.innerHTML = '<li class="picked__none">Tap a free seat on the map to add it.</li>';
                    }

                    chosen.forEach(function (seat) {
                        var item = document.createElement('li');
                        var name = document.createElement('span');
                        var price = document.createElement('span');
                        name.textContent = 'Seat ' + seat.value;
                        price.textContent = money(fare);
                        item.appendChild(name);
                        item.appendChild(price);
                        picked.appendChild(item);

                        var input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'seats[]';
                        input.value = seat.value;
                        map.parentNode.appendChild(input);
                    });

                    totalText.textContent = money(fare * chosen.length);
                    totalInput.value = fare * chosen.length;
                    submit.disabled = chosen.length === 0;
                }

                function draw(seats) {
                    map.innerHTML = '';
                    seats.forEach(function (seat) {
                        var number = parseInt(String(seat.seat_number).slice(1), 10) || 1;
                        var button = document.createElement('button');
                        button.type = 'button';
                        button.className = 'seat';
                        button.value = seat.seat_number;
                        button.textContent = seat.seat_number;
                        button.style.setProperty('--col', number > 2 ? number + 1 : number);
                        button.setAttribute('aria-pressed', 'false');
                        if (Number(seat.seat_status) !== 0) {
                            button.disabled = true;
                            button.setAttribute('aria-label', 'Seat ' + seat.seat_number + ', booked');
                        }
                        map.appendChild(button);
                    });
                }

                function load() {
                    fetch(seatsUrl + '?trip_id=' + encodeURIComponent(trip.dataset.trip), { headers: { 'Accept': 'application/json' } })
                        .then(function (response) {
                            if (!response.ok) throw new Error('Request failed');
                            return response.json();
                        })
                        .then(function (data) {
                            loaded = true;
                            draw(data.success || []);
                        })
                        .catch(function () {
                            map.innerHTML = '';
                            var message = document.createElement('p');
                            message.className = 'field-msg';
                            message.style.gridColumn = '1 / -1';
                            message.style.margin = '0';
                            message.textContent = 'The seat map did not load. Close this panel and open it again to retry.';
                            map.appendChild(message);
                        });
                }

                toggle.addEventListener('click', function () {
                    var open = panel.hidden;
                    panel.hidden = !open;
                    toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
                    toggle.textContent = open ? 'Hide seats' : 'Select seats';
                    if (open && !loaded) load();
                });

                map.addEventListener('click', function (event) {
                    var seat = event.target.closest('.seat');
                    if (!seat || seat.disabled) return;
                    seat.setAttribute('aria-pressed', seat.getAttribute('aria-pressed') === 'true' ? 'false' : 'true');
                    refresh();
                });
            });

            // With a single bus there is nothing to compare, so open its seat map straight away.
            var toggles = document.querySelectorAll('[data-seats-toggle]:not([disabled])');
            if (toggles.length === 1) toggles[0].click();
        })();
    </script>
@endsection
