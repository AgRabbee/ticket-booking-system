<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@hasSection('title')@yield('title') · @endif Ticket Booking System</title>
    <meta name="description" content="Book intercity bus tickets across Bangladesh. Search a route, pick your seat, pay by card and print your ticket.">
    <meta name="theme-color" content="#003527">
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/tbs-mark.svg') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:wght@500;600;700&family=Roboto:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&display=block">
    <link rel="stylesheet" href="{{ asset('css/tbs.css') }}?v={{ filemtime(public_path('css/tbs.css')) }}">
    @yield('public_css')
</head>
<body>
