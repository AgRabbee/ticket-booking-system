@extends('layouts.public')

@section('title', 'Contact')

@section('content')
    <div class="pagehead">
        <div class="wrap wrap--narrow">
            <h1>Contact the system admin</h1>
            <p>Ask about a booking, a pending account or a company registration.</p>
        </div>
    </div>

    <div class="wrap wrap--narrow pull">
        <form class="sheet sheet--lg" action="{{ url('/contact') }}" method="post">
            @csrf

            @if (session()->has('message'))
                <div class="alert @if(session('type') === 'danger') alert--danger @endif" role="alert" style="margin-bottom:20px">
                    <span class="icon" aria-hidden="true">info</span>
                    <span>{{ session('message') }}</span>
                </div>
            @endif

            <div class="form-grid">
                <div>
                    <label class="field @error('subject') field--error @enderror">
                        <span class="field__label">Subject</span>
                        <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required>
                    </label>
                    @error('subject')<p class="field-msg">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="field @error('email') field--error @enderror">
                        <span class="field__label">Your registered email</span>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" autocomplete="email" required>
                    </label>
                    @error('email')<p class="field-msg">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="field @error('msg') field--error @enderror">
                        <span class="field__label">Message</span>
                        <textarea id="msg" name="msg" rows="6">{{ old('msg') }}</textarea>
                    </label>
                    @error('msg')<p class="field-msg">{{ $message }}</p>@enderror
                </div>
            </div>
            <div class="form-actions">
                <button class="btn" type="submit"><span class="icon" aria-hidden="true">mail</span> Send message</button>
            </div>
        </form>
    </div>
@endsection
