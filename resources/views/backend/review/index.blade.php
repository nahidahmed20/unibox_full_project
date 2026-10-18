@extends('backend.layouts.app')
@section('title', 'Product Reviews')

@section('content')
<style>
    .bg-primary-light { background-color: rgba(13, 110, 253, 0.1); }
    .bg-success-light { background-color: rgba(25, 135, 84, 0.1); }
    .bg-warning-light { background-color: rgba(255, 193, 7, 0.15); }
    .bg-info-light { background-color: rgba(13, 202, 240, 0.1); }
    .star-rating i {
        color: #f59e0b;
        font-size: 14px;
    }
</style>

<div class="app-content-wrapper pt-3">
    <div class="container-fluid px-4">

        {{-- PAGE HEADER & BREADCRUMB --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-1 fw-bold text-dark"><i class="bi bi-star-half me-2 text-warning"></i> Customer Reviews</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-transparent p-0" style="font-size: 14px;">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item active fw-bold text-dark">Reviews</li>
                    </ol>
                </nav>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- KPI STATS CARDS --}}
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-primary-light text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-chat-quote fs-4"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">Total Reviews</h6>
                            <h4 class="mb-0 fw-bold">{{ $totalReviews }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-warning-light text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-star-fill fs-4"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">Average Rating</h6>
                            <h4 class="mb-0 fw-bold">{{ $averageRating }} / 5.0</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-success-light text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-check2-circle fs-4"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">Approved Reviews</h6>
                            <h4 class="mb-0 fw-bold">{{ $approvedReviews }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-info-light text-info rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-clock-history fs-4"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">Pending Moderation</h6>
                            <h4 class="mb-0 fw-bold">{{ $pendingReviews }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- REVIEWS TABLE --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted">
                            <tr>
                                <th class="ps-4">Product</th>
                                <th>Customer</th>
                                <th>Rating</th>
                                <th style="max-width: 350px;">Feedback / Comment</th>
                                <th>Submitted On</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reviews as $rev)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            @if($rev->product && $rev->product->image)
                                                <img src="{{ asset($rev->product->image) }}" class="rounded-3 me-2" style="width: 45px; height: 45px; object-fit: cover;" alt="">
                                            @else
                                                <div class="rounded-3 bg-light d-flex align-items-center justify-content-center me-2 text-muted" style="width: 45px; height: 45px;">
                                                    <i class="bi bi-image"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-bold text-dark text-truncate" style="max-width: 200px;">
                                                    {{ $rev->product->name ?? 'Deleted Product' }}
                                                </div>
                                                <small class="text-muted">SKU: {{ $rev->product->sku ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $rev->user_name ?? ($rev->user->name ?? 'Customer') }}</div>
                                        <small class="text-muted">{{ $rev->email ?? ($rev->user->email ?? '') }}</small>
                                    </td>
                                    <td>
                                        <div class="star-rating">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="bi {{ $i <= $rev->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                            @endfor
                                            <span class="ms-1 fw-bold text-dark small">({{ $rev->rating }})</span>
                                        </div>
                                    </td>
                                    <td style="max-width: 350px;">
                                        <div class="text-dark">{{ $rev->comment }}</div>
                                    </td>
                                    <td>
                                        <small class="text-secondary">{{ $rev->created_at->format('d M, Y h:i A') }}</small>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input toggle-review-btn" type="checkbox" role="switch"
                                                data-id="{{ $rev->id }}" {{ $rev->status ? 'checked' : '' }} title="Toggle Live/Hidden">
                                            <label class="form-check-label small ms-1 {{ $rev->status ? 'text-success fw-bold' : 'text-muted' }}">
                                                {{ $rev->status ? 'Published' : 'Hidden' }}
                                            </label>
                                        </div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <form action="{{ route('admin.reviews.destroy', $rev->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this review permanently?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light text-danger" title="Delete Review">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="bi bi-chat-square-text fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                        No customer reviews recorded yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($reviews->hasPages())
                    <div class="p-3 border-top">
                        {{ $reviews->links() }}
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.toggle-review-btn').forEach(toggle => {
            toggle.addEventListener('change', function () {
                const id = this.getAttribute('data-id');
                const label = this.nextElementSibling;
                fetch(`/admin/reviews/${id}/toggle-status`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        label.textContent = data.status ? 'Published' : 'Hidden';
                        label.className = 'form-check-label small ms-1 ' + (data.status ? 'text-success fw-bold' : 'text-muted');
                    } else {
                        alert('Could not update status');
                    }
                })
                .catch(() => alert('Network error'));
            });
        });
    });
</script>
@endsection

