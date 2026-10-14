@include('layouts._partials.public_head')
@include('layouts._partials.public_navbar')

@include('sweetalert::alert')
<main id="main">
    @yield('content')
</main>
@include('layouts._partials.public_footer')
@include('layouts._partials.public_foot')
