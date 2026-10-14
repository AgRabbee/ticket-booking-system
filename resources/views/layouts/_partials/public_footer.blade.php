<footer class="footer">
    <div class="wrap">
        <div class="footer__grid">
            <div>
                <a class="brand" href="{{ url('/') }}" style="color:#fff">
                    @include('layouts._partials.brand')
                    <span>Ticket Booking System</span>
                </a>
                <p class="footer__about">Intercity bus tickets across Bangladesh, with seat-level booking for travellers and dashboards for the operators who run the buses.</p>
            </div>
            <div>
                <h3>Travel</h3>
                <ul>
                    <li><a href="{{ url('/') }}#search">Search trips</a></li>
                    <li><a href="{{ url('/') }}#routes">Popular routes</a></li>
                    <li><a href="{{ url('/') }}#how">How it works</a></li>
                    <li><a href="{{ url('/') }}#faq">Questions</a></li>
                </ul>
            </div>
            <div>
                <h3>Operators</h3>
                <ul>
                    <li><a href="{{ url('/') }}#operators">Run your company here</a></li>
                    <li><a href="{{ url('/signIn') }}">Dashboard sign in</a></li>
                    <li><a href="{{ url('/signUp') }}">Create an account</a></li>
                </ul>
            </div>
            <div>
                <h3>Help</h3>
                <ul>
                    <li><a href="{{ url('/contact') }}">Contact the admin</a></li>
                    <li><a href="{{ url('/signIn') }}">Sign in</a></li>
                </ul>
            </div>
        </div>
        <div class="footer__base">
            <span>&copy; {{ date('Y') }} Ticket Booking System</span>
            <span>Demonstration deployment: trips are sample data and card payments run in Stripe test mode.</span>
        </div>
    </div>
</footer>
