@extends('layouts.public')

@section('title', 'Profile')

@section('content')
    @php $user = Auth::user(); @endphp

    <div class="pagehead">
        <div class="wrap">
            <h1>Your profile</h1>
            <p>Keep your contact details current and change your password.</p>
        </div>
    </div>

    <div class="wrap pull">
        <div class="profile">
            <aside class="sheet sheet--lg profile__card">
                <span class="avatar avatar--lg" aria-hidden="true">{{ mb_substr($user->first_name, 0, 1) }}</span>
                <h2>{{ ucfirst($user->first_name) . ' ' . ucfirst($user->last_name) }}</h2>
                <p class="muted" style="overflow-wrap:anywhere">{{ $user->email }}</p>
                <p style="margin-top:12px"><span class="chip chip--green">{{ $user->roles->pluck('name')->first() ?? 'Customer' }}</span></p>
            </aside>

            <div class="stack">
                @if ($errors->any())
                    <div class="alert alert--danger" role="alert">
                        <span class="icon" aria-hidden="true">error</span>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="sheet sheet--lg" action="{{ url('/dashboard/users/' . $user->id . '/update') }}" method="post">
                    @csrf
                    <h2 class="sheet__title">Details</h2>
                    <div class="form-grid form-grid--2">
                        <label class="field @error('first_name') field--error @enderror">
                            <span class="field__label">First name</span>
                            <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
                        </label>
                        <label class="field @error('last_name') field--error @enderror">
                            <span class="field__label">Last name</span>
                            <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
                        </label>
                        <div style="grid-column:1 / -1">
                            <label class="field">
                                <span class="field__label">Email</span>
                                <input type="email" id="email" value="{{ $user->email }}" readonly>
                            </label>
                            <p class="field-hint">Your email is your sign-in name and can't be changed here.</p>
                        </div>
                        <label class="field @error('phone') field--error @enderror">
                            <span class="field__label">Phone</span>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required>
                        </label>
                        <label class="field @error('nid') field--error @enderror">
                            <span class="field__label">NID number</span>
                            <input type="text" inputmode="numeric" id="nid" name="nid" value="{{ old('nid', $user->nid) }}" required>
                        </label>
                    </div>
                    <div class="form-actions">
                        <button class="btn" type="submit">Save details</button>
                    </div>
                </form>

                <form class="sheet sheet--lg" action="{{ url('/dashboard/users/' . $user->id . '/changePassword') }}" method="post">
                    @csrf
                    <h2 class="sheet__title">Change password</h2>
                    <div class="form-grid">
                        <label class="field @error('c_password') field--error @enderror">
                            <span class="field__label">Current password</span>
                            <input id="c_password" type="password" name="c_password" autocomplete="current-password" required>
                        </label>
                        <div class="form-grid form-grid--2">
                            <label class="field @error('password') field--error @enderror">
                                <span class="field__label">New password</span>
                                <input id="password" type="password" name="password" autocomplete="new-password" required>
                            </label>
                            <label class="field">
                                <span class="field__label">Confirm new password</span>
                                <input id="password-confirm" type="password" name="password_confirmation" autocomplete="new-password" required>
                            </label>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button class="btn btn--tonal" type="submit">Change password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
