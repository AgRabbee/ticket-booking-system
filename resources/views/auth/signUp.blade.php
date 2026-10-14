@extends('layouts.public')

@section('title', 'Create account')

@section('content')
    <div class="pagehead">
        <div class="wrap wrap--narrow">
            <h1>Create an account</h1>
            <p>An account lets you register a bus company. A system admin activates each new account before its first sign-in.</p>
        </div>
    </div>

    <div class="wrap wrap--narrow pull">
        <form class="sheet sheet--lg" id="sign_up" method="POST" action="{{ url('/signUp') }}">
            @csrf
            <div class="form-grid form-grid--2">
                <div>
                    <label class="field @error('first_name') field--error @enderror">
                        <span class="field__label">First name</span>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" autocomplete="given-name" required autofocus>
                    </label>
                    @error('first_name')<p class="field-msg">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="field @error('last_name') field--error @enderror">
                        <span class="field__label">Last name</span>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" autocomplete="family-name" required>
                    </label>
                    @error('last_name')<p class="field-msg">{{ $message }}</p>@enderror
                </div>
                <div style="grid-column:1 / -1">
                    <label class="field @error('email') field--error @enderror">
                        <span class="field__label">Email</span>
                        <input type="email" name="email" value="{{ old('email') }}" autocomplete="email" required>
                    </label>
                    @error('email')<p class="field-msg">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="field @error('password') field--error @enderror">
                        <span class="field__label">Password</span>
                        <input type="password" name="password" minlength="6" autocomplete="new-password" required>
                    </label>
                    @error('password')<p class="field-msg">{{ $message }}</p>@else<p class="field-hint">At least 6 characters.</p>@enderror
                </div>
                <div>
                    <label class="field">
                        <span class="field__label">Confirm password</span>
                        <input type="password" name="password_confirmation" minlength="6" autocomplete="new-password" required>
                    </label>
                </div>
                <div>
                    <label class="field @error('phone') field--error @enderror">
                        <span class="field__label">Phone</span>
                        <input type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel" required>
                    </label>
                    @error('phone')<p class="field-msg">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="field @error('nid') field--error @enderror">
                        <span class="field__label">NID number</span>
                        <input type="text" inputmode="numeric" name="nid" value="{{ old('nid') }}" required>
                    </label>
                    @error('nid')<p class="field-msg">{{ $message }}</p>@enderror
                </div>
            </div>

            <label class="check" style="margin-top:20px">
                <input type="checkbox" id="agreeTerms" name="terms" value="agree" required>
                <span>I agree to the terms of use.</span>
            </label>

            <div class="form-actions">
                <button class="btn" type="submit">Create account</button>
                <a class="btn btn--text" href="{{ url('/signIn') }}">I already have an account</a>
            </div>
        </form>
    </div>
@endsection
