@php
    $navUser = Auth::user();
    $navRoles = $navUser ? $navUser->roles->pluck('name') : collect();
    $navCompany = $navUser ? $navUser->companies->first() : null;
    $canRegisterCompany = $navUser && $navUser->id != 1 && !$navCompany && $navRoles->first() === 'Customer';
    $companyErrors = $errors->hasAny(['company_name', 'company_description', 'address', 'reg_no', 'tin_no', 'company_image', 'trade', 'vat']);
@endphp
<header class="appbar">
    @include('layouts._partials.demo_banner')
    <div class="wrap appbar__row">
        <a class="brand" href="{{ url('/') }}">
            @include('layouts._partials.brand')
            <span>Ticket Booking System</span>
        </a>

        <button class="iconbtn appbar__toggle" type="button" data-nav-toggle aria-controls="site-nav" aria-expanded="false" aria-label="Menu">
            <span class="icon" aria-hidden="true">menu</span>
        </button>

        <nav class="appbar__nav" id="site-nav" aria-label="Main">
            <a class="appbar__link" href="{{ url('/') }}#routes">Routes</a>
            <a class="appbar__link" href="{{ url('/') }}#how">How it works</a>
            <a class="appbar__link" href="{{ url('/') }}#operators">For operators</a>
            <a class="appbar__link" href="{{ url('/contact') }}" @if(request()->is('contact')) aria-current="page" @endif>Contact</a>

            <div class="appbar__actions">
                @guest
                    <a class="btn btn--on-green btn--sm" href="{{ url('/signIn') }}">Sign in</a>
                    <a class="btn btn--amber btn--sm" href="{{ url('/signUp') }}">Create account</a>
                @else
                    <details class="menu">
                        <summary class="menu__trigger">
                            <span class="avatar" aria-hidden="true">{{ mb_substr($navUser->first_name, 0, 1) }}</span>
                            <span>{{ ucfirst($navUser->first_name) }}</span>
                        </summary>
                        <div class="menu__list">
                            <div class="menu__head">
                                <strong>{{ ucfirst($navUser->first_name) . ' ' . ucfirst($navUser->last_name) }}</strong>
                                <span>{{ $navUser->email }}</span>
                            </div>
                            @if ($navRoles->contains('Super Admin'))
                                <a class="menu__item" href="{{ url('/dashboard') }}"><span class="icon" aria-hidden="true">dashboard</span> Admin dashboard</a>
                            @elseif ($navCompany && $navCompany->company_status == 1)
                                <a class="menu__item" href="{{ url('/company/dashboard') }}"><span class="icon" aria-hidden="true">dashboard</span> Company dashboard</a>
                            @endif
                            <a class="menu__item" href="{{ url('/dashboard/users/' . $navUser->id) }}"><span class="icon" aria-hidden="true">person</span> Profile</a>
                            @if ($canRegisterCompany)
                                <button class="menu__item" type="button" data-dialog-open="company-register"><span class="icon" aria-hidden="true">domain_add</span> Register your company</button>
                            @endif
                            <form action="{{ route('logOut') }}" method="POST">
                                @csrf
                                <button class="menu__item" type="submit"><span class="icon" aria-hidden="true">logout</span> Sign out</button>
                            </form>
                        </div>
                    </details>
                @endguest
            </div>
        </nav>
    </div>
</header>

@if ($canRegisterCompany)
    <dialog class="dialog" id="company-register" aria-labelledby="company-register-title" @if($companyErrors) data-open-on-load @endif>
        <form action="{{ url('/company/register') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="dialog__head">
                <h2 id="company-register-title" style="font-size:1.625rem">Register your company</h2>
                <button class="iconbtn" type="button" data-dialog-close aria-label="Close"><span class="icon" aria-hidden="true">close</span></button>
            </div>
            <div class="dialog__body">
                <p class="muted" style="margin-bottom:20px">A system admin reviews each request. Once approved, your company dashboard appears in the account menu.</p>
                <div class="form-grid">
                    <div>
                        <label class="field @error('company_name') field--error @enderror">
                            <span class="field__label">Company name</span>
                            <input type="text" name="company_name" value="{{ old('company_name') }}" required>
                        </label>
                        @error('company_name')<p class="field-msg">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="field @error('company_description') field--error @enderror">
                            <span class="field__label">Company description</span>
                            <textarea name="company_description" rows="3" required style="min-height:84px">{{ old('company_description') }}</textarea>
                        </label>
                        @error('company_description')<p class="field-msg">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="field @error('address') field--error @enderror">
                            <span class="field__label">Company address</span>
                            <input type="text" name="address" value="{{ old('address') }}" required>
                        </label>
                        @error('address')<p class="field-msg">{{ $message }}</p>@enderror
                    </div>
                    <div class="form-grid form-grid--2">
                        <div>
                            <label class="field @error('reg_no') field--error @enderror">
                                <span class="field__label">Registration number</span>
                                <input type="text" name="reg_no" value="{{ old('reg_no') }}" required>
                            </label>
                            @error('reg_no')<p class="field-msg">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="field @error('tin_no') field--error @enderror">
                                <span class="field__label">TIN number</span>
                                <input type="text" inputmode="numeric" name="tin_no" value="{{ old('tin_no') }}" required>
                            </label>
                            @error('tin_no')<p class="field-msg">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="field @error('trade') field--error @enderror">
                                <span class="field__label">Trade licence (image)</span>
                                <input type="file" name="trade" accept="image/*" required>
                            </label>
                            @error('trade')<p class="field-msg">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="field @error('vat') field--error @enderror">
                                <span class="field__label">VAT certificate (image)</span>
                                <input type="file" name="vat" accept="image/*" required>
                            </label>
                            @error('vat')<p class="field-msg">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div>
                        <label class="field @error('company_image') field--error @enderror">
                            <span class="field__label">Company image (optional)</span>
                            <input type="file" name="company_image" accept="image/*">
                        </label>
                        @error('company_image')<p class="field-msg">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>
            <div class="dialog__foot">
                <button class="btn btn--text" type="button" data-dialog-close>Cancel</button>
                <button class="btn" type="submit" name="submit" value="Register Company">Send for review</button>
            </div>
        </form>
    </dialog>
@endif
