@extends('layouts.public')

@section('title', 'Your ticket')

@section('content')
    <div class="pagehead">
        <div class="wrap">
            <ol class="steps" aria-label="Booking progress">
                <li>Search</li>
                <li>Choose seats</li>
                <li>Pay</li>
                <li aria-current="step">Ticket</li>
            </ol>
            @if (count($printDetails))
                <h1>Your seats are booked</h1>
                <p>Print this ticket or keep it on your phone, and show it at the counter before boarding.</p>
            @else
                <h1>No ticket to show</h1>
                <p>Tickets appear here straight after a booking is paid for.</p>
            @endif
        </div>
    </div>

    <div class="wrap pull">
        @if (count($printDetails))
            @include('bus._ticket')
            <div class="form-actions no-print">
                <a class="btn" href="{{ url('/print_invoice') }}" target="_blank" rel="noopener"><span class="icon" aria-hidden="true">print</span> Print ticket and invoice</a>
                <a class="btn btn--outline" href="{{ url('/') }}">Book another trip</a>
            </div>
        @else
            <div class="sheet sheet--lg">
                <p class="muted">We couldn't find a recent booking in this browser session.</p>
                <div class="form-actions">
                    <a class="btn" href="{{ url('/') }}#search">Search trips</a>
                </div>
            </div>
        @endif
    </div>
@endsection
