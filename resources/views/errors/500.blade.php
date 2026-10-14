<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Something went wrong · Ticket Booking System</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/tbs-mark.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:wght@500;600;700&family=Roboto:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="{{ asset('css/tbs.css') }}">
</head>
<body>
<main class="errorpage">
    <div>
        <div class="errorpage__code">500</div>
        <h1>We broke down on the way</h1>
        <p>Something failed on our side and your request didn't go through. Please try again from the home page.</p>
        <a class="btn btn--amber" href="{{ url('/') }}">Back to departures</a>
    </div>
</main>
</body>
</html>
