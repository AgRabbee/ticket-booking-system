@extends('layouts.public')

@section('title', 'Print ticket')

@section('content')
    <div class="pagehead">
        <div class="wrap">
            @if (count($printDetails))
                <h1>Ticket and invoice</h1>
                <p class="no-print">The print dialog opens by itself. If it doesn't, use the button below.</p>
            @else
                <h1>No ticket to print</h1>
                <p>Tickets appear here straight after a booking is paid for.</p>
            @endif
        </div>
    </div>

    <div class="wrap pull">
        @if (count($printDetails))
            @include('bus._ticket')
            <div class="form-actions no-print">
                <button class="btn" type="button" onclick="window.print()"><span class="icon" aria-hidden="true">print</span> Print</button>
            </div>
        @else
            <div class="sheet sheet--lg">
                <div class="form-actions" style="margin-top:0">
                    <a class="btn" href="{{ url('/') }}#search">Search trips</a>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('public_scripts')
    @if (count($printDetails))
        <script>
            window.addEventListener('load', function () {
                // Wait for the web fonts so the printout matches the screen.
                (document.fonts ? document.fonts.ready : Promise.resolve()).then(function () { window.print(); });
            });
        </script>
    @endif
@endsection
