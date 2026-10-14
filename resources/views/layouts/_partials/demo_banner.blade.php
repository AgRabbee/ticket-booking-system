@if (config('demo.banner.enabled'))
<div class="demo-banner" role="note" aria-label="{{ config('demo.banner.title') }}">
    <svg class="demo-banner__icon" viewBox="0 0 24 24" width="20" height="20" aria-hidden="true">
        <path fill="currentColor" d="M11 17h2v-6h-2v6Zm1-8a1 1 0 1 0 0-2 1 1 0 0 0 0 2Zm0 13a10 10 0 1 1 0-20 10 10 0 0 1 0 20Z"/>
    </svg>
    <p class="demo-banner__text">
        <strong>{{ config('demo.banner.title') }}.</strong>
        {{ config('demo.banner.message') }}
    </p>
</div>
@endif
