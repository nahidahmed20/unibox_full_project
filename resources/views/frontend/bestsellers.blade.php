@extends('frontend.layouts.app')
@section('title', 'Bestsellers | Most Popular Finds')

@section('content')
<section class="container py-5">
    {{-- BESTSELLERS HERO BANNER --}}
    <div class="p-4 p-md-5 mb-5 rounded-4 border bg-light position-relative overflow-hidden" style="background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <nav aria-label="breadcrumb" class="mb-2">
                    <ol class="breadcrumb mb-0 small">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-muted text-decoration-none"><i class="fa-solid fa-house me-1"></i> Home</a></li>
                        <li class="breadcrumb-item active fw-bold text-dark">Bestsellers</li>
                    </ol>
                </nav>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge bg-warning text-dark px-3 py-1 rounded-pill fw-bold" style="font-size: 11px;">
                        <i class="fa-solid fa-fire me-1"></i> TOP RATED & POPULAR
                    </span>
                </div>
                <h1 class="fw-bold text-dark mb-1" style="font-size: clamp(26px, 3.5vw, 38px);">
                    Customer Bestsellers
                </h1>
                <p class="text-muted mb-0 small">
                    Our most-loved pieces, thoughtfully chosen and ordered again and again.
                </p>
            </div>
            <div class="d-none d-md-block text-warning opacity-75">
                <i class="fa-solid fa-award" style="font-size: 64px;"></i>
            </div>
        </div>
    </div>

    @include('frontend.home.partials.product_list', ['products' => $bestsellers])
    <div class="mt-5 d-flex justify-content-center">{{ $bestsellers->links() }}</div>
</section>
@endsection
