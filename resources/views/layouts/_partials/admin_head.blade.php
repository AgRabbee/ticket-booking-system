<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Dashboard · Ticket Booking System</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/css/tempusdominus-bootstrap-4.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css">
  <!-- jquery-ui -->
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/admin-lte/3.0.0-rc.3/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.9.1/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/daterangepicker@3.1.0/daterangepicker.css">
  <!-- select2 -->
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css">
  @yield('admin_css')
  <!-- Ticket Booking System theme -->
  <link rel="icon" type="image/svg+xml" href="{{ asset('images/tbs-mark.svg') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:wght@500;600;700&family=Roboto:wght@400;500;700&display=swap">
  <link rel="stylesheet" href="{{ asset('css/tbs-admin.css') }}?v={{ filemtime(public_path('css/tbs-admin.css')) }}">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
