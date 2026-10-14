@php
    $booking = $printDetails[0];
    $fee = 21;
    $ticketPrice = $booking->fare * count($printDetails);
    $journeyDate = \Carbon\Carbon::parse($booking->date);
@endphp

<header class="doc-head print-only">
    <div class="brand">
        @include('layouts._partials.brand')
        <span>Ticket Booking System</span>
    </div>
    <div class="doc-head__meta">
        <strong>{{ $booking->payment_status == 1 ? 'E-ticket · Paid' : 'E-ticket · Unpaid' }}</strong>
        Payment #{{ $booking->id }} · issued {{ date('j M Y', strtotime($booking->created_at)) }}
    </div>
</header>

<div class="ticket">
    <div class="ticket__main">
        <div class="brand" style="color:var(--ink)">
            @include('layouts._partials.brand')
            <span>Ticket Booking System</span>
        </div>
        <div class="ticket__route">
            {{ $booking->startPoint }} <span class="route__track" aria-hidden="true"></span><span class="sr-only">to</span> {{ $booking->endPoint }}
        </div>
        <dl class="kv">
            <div><dt>Passenger</dt><dd>{{ $booking->first_name . ' ' . $booking->last_name }}</dd></div>
            <div><dt>Date</dt><dd>{{ $journeyDate->format('D, j M Y') }}</dd></div>
            <div><dt>Departs</dt><dd>{{ $booking->start_time }}</dd></div>
            <div><dt>Operator</dt><dd>{{ $booking->company_name }}</dd></div>
            <div><dt>Phone</dt><dd>{{ $booking->phone }}</dd></div>
            <div><dt>Boarding</dt><dd>{{ $booking->company_name }} counter, {{ $booking->startPoint }}</dd></div>
        </dl>
    </div>
    <div class="ticket__stub">
        <dl class="kv">
            <div>
                <dt>{{ Str::plural('Seat', count($printDetails)) }}</dt>
                <dd class="ticket__seats">
                    @foreach ($printDetails as $line)
                        <span>{{ $line->seat_number }}</span>
                    @endforeach
                </dd>
            </div>
            <div><dt>Payment ID</dt><dd>#{{ $booking->id }}</dd></div>
            <div><dt>{{ $booking->payment_status == 1 ? 'Paid' : 'To pay' }}</dt><dd>BDT {{ number_format($ticketPrice + $fee) }}</dd></div>
        </dl>
    </div>
</div>

<section class="sheet sheet--lg" style="margin-top:24px" aria-labelledby="invoice-title">
    <h2 class="sheet__title" id="invoice-title">Invoice</h2>
    <p class="muted" style="margin:-12px 0 16px">
        Payment #{{ $booking->id }} on {{ date('j M Y', strtotime($booking->created_at)) }}@if ($booking->email) · {{ $booking->email }}@endif
    </p>
    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Seat</th>
                    <th>Journey</th>
                    <th>Date</th>
                    <th>Departs</th>
                    <th>Fare (BDT)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($printDetails as $line)
                    <tr>
                        <td>{{ $line->seat_number }}</td>
                        <td>{{ $line->startPoint }} to {{ $line->endPoint }}</td>
                        <td>{{ $line->date }}</td>
                        <td>{{ $line->start_time }}</td>
                        <td>{{ number_format($line->fare) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr><td colspan="4">Ticket price</td><td>{{ number_format($ticketPrice) }}</td></tr>
                <tr><td colspan="4">System fee</td><td>{{ $fee }}</td></tr>
                <tr><td colspan="4"><strong>Total</strong></td><td><strong>{{ number_format($ticketPrice + $fee) }}</strong></td></tr>
            </tfoot>
        </table>
    </div>
</section>

<p class="doc-foot print-only">
    Show this ticket at the {{ $booking->company_name }} counter in {{ $booking->startPoint }} before boarding.
    @if ($booking->payment_status != 1) This booking is not paid yet; pay the total at the counter. @endif
    Amounts are in BDT and include a system fee of {{ $fee }} per booking.
</p>
