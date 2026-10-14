@extends('layouts.public')

@section('content')
    @php
        $board = $departures->take(6);
        $sampleFare = $departures->isNotEmpty() ? (int)$departures->first()->fare : 850;
    @endphp

    <section class="hero">
        <div class="wrap hero__grid">
            <div>
                <h1>Bus tickets across Bangladesh, seat by seat.</h1>
                <p class="hero__lead">Search a route, choose your exact seat on the bus, pay by card and print your ticket. You don't need an account.</p>

                @if (session()->has('message'))
                    <div class="alert @if(session('type') === 'danger') alert--danger @endif" role="alert" style="margin-top:24px">
                        <span class="icon" aria-hidden="true">info</span>
                        <span>{{ session('message') }}</span>
                    </div>
                @endif

                <form class="sheet search" id="search" action="{{ url('/bus/search') }}" method="post">
                    @csrf
                    <div class="search__grid">
                        <div>
                            <label class="field field--select @error('from') field--error @enderror">
                                <span class="field__label">From</span>
                                <select name="from" id="from" required>
                                    <option value="">Choose a district</option>
                                    @foreach ($tripsInfo as $value)
                                        <option value="{{ $value->id }}" @selected(old('from') == $value->id)>{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </label>
                            @error('from')<p class="field-msg">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="field field--select @error('to') field--error @enderror">
                                <span class="field__label">To</span>
                                <select name="to" id="to" required>
                                    <option value="">Choose a district</option>
                                    @foreach ($tripsInfo as $value)
                                        <option value="{{ $value->id }}" @selected(old('to') == $value->id)>{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </label>
                            @error('to')<p class="field-msg">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="field @error('date_of_journey') field--error @enderror">
                                <span class="field__label">Date of journey</span>
                                <input type="date" name="date_of_journey" id="date_of_journey" min="{{ date('Y-m-d') }}" value="{{ old('date_of_journey', $departures->isNotEmpty() ? $departures->first()->date : '') }}" required>
                            </label>
                            @error('date_of_journey')<p class="field-msg">{{ $message }}</p>@enderror
                        </div>
                        <button class="btn" type="submit"><span class="icon" aria-hidden="true">search</span> Search buses</button>
                    </div>
                </form>
            </div>

            <div class="board" aria-labelledby="board-title">
                <div class="board__head">
                    <h2 id="board-title">Next departures</h2>
                    @if ($departures->isNotEmpty())
                        <p>{{ number_format($departures->count()) }} trips on sale across {{ $routes->count() }} routes</p>
                    @endif
                </div>

                @forelse ($board as $i => $trip)
                    @php [$clock, $meridiem] = array_pad(explode(' ', $trip->start_time, 2), 2, ''); @endphp
                    <div class="board__row" style="--i: {{ $i }}">
                        <div class="board__time">
                            {{ $clock }}<small>{{ $meridiem }}</small>
                            <span class="board__date">{{ \Carbon\Carbon::parse($trip->date)->format('D j M') }}</span>
                        </div>
                        <div>
                            <div class="board__route">{{ $trip->start_name }} <span class="icon" aria-hidden="true">east</span><span class="sr-only">to</span> {{ $trip->end_name }}</div>
                            <div class="board__meta">{{ $trip->company_name }} · {{ $trip->seats_left }} {{ Str::plural('seat', $trip->seats_left) }} left</div>
                        </div>
                        <div class="board__fare"><small>BDT</small>{{ number_format($trip->fare) }}</div>
                        <form action="{{ url('/bus/search') }}" method="post">
                            @csrf
                            <input type="hidden" name="from" value="{{ $trip->start_point }}">
                            <input type="hidden" name="to" value="{{ $trip->end_point }}">
                            <input type="hidden" name="date_of_journey" value="{{ $trip->date }}">
                            <button class="btn btn--amber btn--sm" type="submit" aria-label="Book {{ $trip->start_name }} to {{ $trip->end_name }}, {{ $trip->start_time }}">Book</button>
                        </form>
                    </div>
                @empty
                    <div class="board__empty">
                        <span class="icon icon--xl" aria-hidden="true">event_busy</span>
                        <h3>No trips are on sale right now</h3>
                        <p>Every trip has a date, so this demo's timetable runs out. Add a few fresh trips with empty seats and the whole booking flow is ready to try.</p>
                        <form action="{{ url('/demo/trips') }}" method="post" data-once>
                            @csrf
                            <button class="btn btn--amber" type="submit" data-busy="Adding trips…"><span class="icon" aria-hidden="true">add</span> Generate demo trips</button>
                        </form>
                    </div>
                @endforelse

                @if ($departures->count() > $board->count())
                    <div class="board__foot">Showing the next {{ $board->count() }}. Search a route and date to see the rest.</div>
                @endif
            </div>
        </div>
    </section>

    @if ($routes->isNotEmpty())
        <section class="section" id="routes">
            <div class="wrap">
                <div class="section__head">
                    <h2>Popular routes</h2>
                    <p>Pick a route to see its next day of departures. Fares shown are the lowest on sale for that route.</p>
                </div>
                <div class="routes">
                    @foreach ($routes->take(10) as $route)
                        <form action="{{ url('/bus/search') }}" method="post">
                            @csrf
                            <input type="hidden" name="from" value="{{ $route->start_point }}">
                            <input type="hidden" name="to" value="{{ $route->end_point }}">
                            <input type="hidden" name="date_of_journey" value="{{ $route->next_date }}">
                            <button class="route" type="submit">
                                <span class="route__line">{{ $route->start_name }} <span class="route__track" aria-hidden="true"></span><span class="sr-only">to</span> {{ $route->end_name }}</span>
                                <span class="route__meta">From BDT {{ number_format($route->min_fare) }} · {{ $route->departures }} {{ Str::plural('departure', $route->departures) }} · next {{ \Carbon\Carbon::parse($route->next_date)->format('D j M') }}</span>
                                <span class="route__go"><span class="icon" aria-hidden="true">arrow_forward</span></span>
                            </button>
                        </form>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="section" id="how" @if($routes->isNotEmpty()) style="padding-top:0" @endif>
        <div class="wrap">
            <div class="section__head">
                <h2>From search to seat in four stops</h2>
            </div>
            <ol class="strip">
                <li class="strip__stop">
                    <h3>Search</h3>
                    <p>Choose where you're leaving from, where you're going and the date you want to travel.</p>
                </li>
                <li class="strip__stop">
                    <h3>Choose seats</h3>
                    <p>Open a bus to see its seat map. Booked seats are locked; tap the ones you want.</p>
                </li>
                <li class="strip__stop">
                    <h3>Pay</h3>
                    <p>Enter the passenger's name and phone, then pay by card through Stripe.</p>
                </li>
                <li class="strip__stop">
                    <h3>Travel</h3>
                    <p>Your ticket appears straight away. Print it, and get a copy by email if you gave an address.</p>
                </li>
            </ol>
        </div>
    </section>

    <section class="section band">
        <div class="wrap split">
            <div>
                <h2>You choose the seat, not the counter clerk</h2>
                <p class="muted" style="margin-top:12px; max-width:52ch; font-size:1.0625rem">Every bus is sold seat by seat, so the window seat in row C is yours the moment you pay for it. Try the sample bus.</p>
                <dl class="facts">
                    <div>
                        <span class="icon" aria-hidden="true">event_seat</span>
                        <dt>Live seat availability</dt>
                        <dd>The map is loaded fresh each time you open a bus.</dd>
                    </div>
                    <div>
                        <span class="icon" aria-hidden="true">credit_card</span>
                        <dt>Card payment through Stripe</dt>
                        <dd>Card details go straight to Stripe and are never stored here.</dd>
                    </div>
                    <div>
                        <span class="icon" aria-hidden="true">confirmation_number</span>
                        <dt>Printable ticket and invoice</dt>
                        <dd>Both are ready as soon as the payment goes through.</dd>
                    </div>
                    <div>
                        <span class="icon" aria-hidden="true">mail</span>
                        <dt>Email confirmation</dt>
                        <dd>Add an email address at checkout to get the booking details sent to you.</dd>
                    </div>
                </dl>
            </div>

            <div>
                <div class="bus" data-sample-bus data-fare="{{ $sampleFare }}">
                    <div class="bus__front">
                        <span>Sample bus, not a live trip</span>
                        <span class="icon" aria-hidden="true" title="Driver">airline_seat_recline_normal</span>
                    </div>
                    <div class="seats">
                        @php $sampleBooked = ['A3', 'B1', 'B2', 'C4', 'E1']; @endphp
                        @foreach (['A', 'B', 'C', 'D', 'E'] as $row)
                            @foreach ([1, 2, 3, 4] as $n)
                                <button class="seat" type="button" style="--col: {{ $n > 2 ? $n + 1 : $n }}" aria-pressed="{{ in_array($row.$n, ['C1', 'C2']) ? 'true' : 'false' }}" @disabled(in_array($row.$n, $sampleBooked))>{{ $row.$n }}</button>
                            @endforeach
                        @endforeach
                    </div>
                    <div class="legend">
                        <span><i></i> Available</span>
                        <span><i class="is-selected"></i> Selected</span>
                        <span><i class="is-booked"></i> Booked</span>
                    </div>
                    <div class="tally" aria-live="polite">
                        <span data-sample-count>2 seats</span>
                        <strong data-sample-total>BDT {{ number_format($sampleFare * 2) }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section operators" id="operators">
        <div class="wrap split" style="align-items:start">
            <div>
                <div class="section__head" style="margin-bottom:28px">
                    <h2>Run your bus company from one dashboard</h2>
                    <p>Register your company, wait for a system admin to approve it, then put your own trips on sale. Each company only ever sees its own buses, drivers and sales.</p>
                </div>
                <div class="form-actions" style="margin-top:0">
                    @auth
                        @if (Auth::user()->companies->count())
                            <a class="btn" href="{{ url('/company/dashboard') }}">Open company dashboard</a>
                        @elseif (Auth::user()->roles->pluck('name')->contains('Super Admin'))
                            <a class="btn" href="{{ url('/dashboard') }}">Open admin dashboard</a>
                        @else
                            <button class="btn" type="button" data-dialog-open="company-register">Register your company</button>
                        @endif
                    @else
                        <a class="btn" href="{{ url('/signUp') }}">Create an account to register</a>
                        <a class="btn btn--outline" href="{{ url('/signIn') }}">Try the demo dashboards</a>
                    @endauth
                </div>
            </div>
            <dl class="ledger">
                <div>
                    <dt>Trips</dt>
                    <dd>Schedule a trip by route, date, time, bus and driver. Seats go on sale at once, and you can change the fare later.</dd>
                </div>
                <div>
                    <dt>Buses</dt>
                    <dd>Add each bus with its type, registration number and seat count.</dd>
                </div>
                <div>
                    <dt>Drivers</dt>
                    <dd>Keep a list of your drivers and assign one to every trip.</dd>
                </div>
                <div>
                    <dt>Sales</dt>
                    <dd>See every seat sold with its passenger and trip, plus a month-by-month sales report.</dd>
                </div>
                <div>
                    <dt>Admin</dt>
                    <dd>System admins approve users and companies, manage transport types and read sales across all companies.</dd>
                </div>
            </dl>
        </div>
    </section>

    <section class="section" id="faq">
        <div class="wrap wrap--narrow">
            <div class="section__head">
                <h2>Questions travellers ask</h2>
            </div>
            <div class="faq">
                <details>
                    <summary>Do I need an account to book? <span class="icon" aria-hidden="true">add</span></summary>
                    <p>No. You only give the passenger's name and phone number at checkout. An account is needed if you want to register a bus company.</p>
                </details>
                <details>
                    <summary>How do I pay? <span class="icon" aria-hidden="true">add</span></summary>
                    <p>By debit or credit card through Stripe. This site runs Stripe in test mode, so no real money moves: use card number <code>4242 4242 4242 4242</code> with any future expiry date and any three-digit CVC.</p>
                </details>
                <details>
                    <summary>Can I book more than one seat? <span class="icon" aria-hidden="true">add</span></summary>
                    <p>Yes. Select as many free seats as you need on the seat map. The total updates as you go and all seats are paid for together.</p>
                </details>
                <details>
                    <summary>How do I get my ticket? <span class="icon" aria-hidden="true">add</span></summary>
                    <p>It is shown as soon as the payment succeeds, with a print button for the ticket and invoice. If you entered an email address, the booking details are sent there as well.</p>
                </details>
                <details>
                    <summary>Why is there a fee on top of the fare? <span class="icon" aria-hidden="true">add</span></summary>
                    <p>A flat system fee of BDT 21 is added to each booking, however many seats it covers. You see it in the fare summary before you pay.</p>
                </details>
                <details>
                    <summary>Is this a real bus service? <span class="icon" aria-hidden="true">add</span></summary>
                    <p>This deployment is a working demonstration. The booking system is fully functional, but the trips are sample data and payments are test payments, so please don't turn up at a counter expecting a bus.</p>
                </details>
            </div>
        </div>
    </section>
@endsection

@section('public_scripts')
    <script>
        (function () {
            var bus = document.querySelector('[data-sample-bus]');
            if (!bus) return;
            var fare = Number(bus.dataset.fare);
            var count = bus.querySelector('[data-sample-count]');
            var total = bus.querySelector('[data-sample-total]');

            bus.addEventListener('click', function (event) {
                var seat = event.target.closest('.seat');
                if (!seat || seat.disabled) return;
                seat.setAttribute('aria-pressed', seat.getAttribute('aria-pressed') === 'true' ? 'false' : 'true');
                var picked = bus.querySelectorAll('.seat[aria-pressed="true"]').length;
                count.textContent = picked + (picked === 1 ? ' seat' : ' seats');
                total.textContent = 'BDT ' + (picked * fare).toLocaleString('en-US');
            });
        })();
    </script>
@endsection
