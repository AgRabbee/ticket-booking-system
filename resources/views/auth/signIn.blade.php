@extends('layouts.public')

@section('title', 'Sign in')

@section('content')
    <div class="pagehead">
        <div class="wrap">
            <h1>Sign in</h1>
            <p>For registered travellers, company admins and system admins. Booking a ticket doesn't need an account.</p>
        </div>
    </div>

    <div class="wrap pull">
        <div class="auth">
            <form class="sheet sheet--lg" id="sign_in" method="POST" action="{{ url('signIn') }}">
                @csrf
                <h2 class="sheet__title">Your account</h2>

                @if (count($errors) > 0)
                    <div class="alert alert--danger" role="alert" style="margin-bottom:20px">
                        <span class="icon" aria-hidden="true">error</span>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session()->has('message'))
                    <div class="alert @if(session('type') === 'danger') alert--danger @endif" role="alert" style="margin-bottom:20px">
                        <span class="icon" aria-hidden="true">{{ session('type') === 'danger' ? 'error' : 'check_circle' }}</span>
                        <span>{{ session('message') }}</span>
                    </div>
                @endif

                <div class="form-grid">
                    <label class="field">
                        <span class="field__label">Email</span>
                        <input type="email" name="email" id="email" autocomplete="username" required autofocus>
                    </label>
                    <label class="field">
                        <span class="field__label">Password</span>
                        <input type="password" name="password" id="password" autocomplete="current-password" required>
                    </label>
                </div>
                <div class="form-actions">
                    <button class="btn" type="submit"><span class="icon" aria-hidden="true">login</span> Sign in</button>
                    <a class="btn btn--text" href="{{ url('/signUp') }}">Create an account</a>
                </div>
                <p class="field-hint" style="margin:20px 0 0">Account still pending or locked out? <a href="{{ url('/contact') }}">Contact the system admin</a>.</p>
            </form>

            <aside class="sheet sheet--lg" aria-labelledby="demo-title">
                <span class="chip chip--amber">Demo</span>
                <h2 class="sheet__title" id="demo-title" style="margin-top:12px; margin-bottom:8px">Try a demo account</h2>
                <p class="muted">Pick a role to fill in the form, then sign in. All three use the password <strong class="num">{{ config('demo.password') }}</strong>. Demo accounts can add and edit, but can't delete data or lock other accounts.</p>
                <div class="demo-accounts">
                    <button class="demo-account" type="button" data-demo-email="{{ config('demo.logins.traveller') }}">
                        <span class="icon" aria-hidden="true">person</span>
                        <strong>Traveller</strong>
                        <small>{{ config('demo.logins.traveller') }} · can register a company</small>
                        <em>Use</em>
                    </button>
                    <button class="demo-account" type="button" data-demo-email="{{ config('demo.logins.company') }}">
                        <span class="icon" aria-hidden="true">directions_bus</span>
                        <strong>Company admin</strong>
                        <small>{{ config('demo.logins.company') }} · trips, buses, drivers, sales</small>
                        <em>Use</em>
                    </button>
                    <button class="demo-account" type="button" data-demo-email="{{ config('demo.logins.admin') }}">
                        <span class="icon" aria-hidden="true">shield_person</span>
                        <strong>System admin</strong>
                        <small>{{ config('demo.logins.admin') }} · users, companies, all sales</small>
                        <em>Use</em>
                    </button>
                </div>
            </aside>
        </div>
    </div>
@endsection

@section('public_scripts')
    <script>
        document.querySelectorAll('[data-demo-email]').forEach(function (button) {
            button.addEventListener('click', function () {
                document.getElementById('email').value = button.dataset.demoEmail;
                document.getElementById('password').value = @json(config('demo.password'));
                document.querySelector('#sign_in button[type="submit"]').focus();
            });
        });
    </script>
@endsection
