@php
    use Illuminate\Support\Facades\Auth;
@endphp

<div class="d-flex justify-content-between align-items-center">
    <div>
        <h5 class="mb-0" style="color: #1f2937; font-weight: 600;">{{ $title ?? 'Dashboard' }}</h5>
        <small class="text-muted">{{ $subtitle ?? '' }}</small>
    </div>
    <div class="d-flex align-items-center gap-3">
        <span class="text-muted">{{ Auth::user()->name }}</span>
        <span class="badge bg-primary">{{ Auth::user()->email }}</span>
    </div>
</div>
