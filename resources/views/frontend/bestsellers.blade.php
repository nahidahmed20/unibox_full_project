@extends('frontend.layouts.app')
@section('title', 'বেস্ট সেলার্স | Most Popular Finds')

@section('content')
<div class="ub-bestsellers-page py-4 py-md-5">
    <div class="container">

        {{-- 1. LUXURY BESTSELLERS HERO BANNER --}}
        <div class="p-4 p-md-5 mb-4 mb-md-5 rounded-4 position-relative overflow-hidden shadow-sm"
             style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #312e81 100%); color: #ffffff;">
            <div class="row align-items-center g-4 position-relative" style="z-index: 2;">
                <div class="col-lg-8">
                    <nav aria-label="breadcrumb" class="mb-3">
                        <ol class="breadcrumb mb-0 small text-white-50">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50 text-decoration-none"><i class="fa-solid fa-house me-1"></i> Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('search') }}" class="text-white-50 text-decoration-none">All Products</a></li>
                            <li class="breadcrumb-item active text-white fw-semibold" aria-current="page">Bestsellers</li>
                        </ol>
                    </nav>

                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2); font-size: 12px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase;">
                        <i class="fa-solid fa-fire text-warning"></i>
                        <span>MOST LOVED & TOP RATED PICKS</span>
                    </div>

                    <h1 class="fw-bolder mb-2 text-white" style="font-size: clamp(28px, 4vw, 42px); line-height: 1.2;">
                        বেস্ট সেলার্স কালেকশন
                    </h1>
                    <p class="mb-3 text-white-50 fs-6" style="max-width: 620px; line-height: 1.6;">
                        আমাদের গ্রাহকদের সবচেয়ে পছন্দের, সর্বাধিক বিক্রিত ও ট্রেন্ডিং প্রোডাক্টগুলো এখানে পেয়ে যাবেন। প্রতিটি পণ্যে রয়েছে সর্বোচ্চ মান ও সন্তুষ্টির নিশ্চয়তা।
                    </p>

                    <div class="d-flex align-items-center flex-wrap gap-2 gap-md-3">
                        <span class="badge rounded-pill px-3 py-2 text-white" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15); font-size: 12px; font-weight: 500;">
                            <i class="fa-solid fa-star text-warning me-1"></i> ৪.৯ / ৫ কাস্টমার রেটিং
                        </span>
                        <span class="badge rounded-pill px-3 py-2 text-white" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15); font-size: 12px; font-weight: 500;">
                            <i class="fa-solid fa-truck-fast text-info me-1"></i> দ্রুত হোম ডেলিভারি
                        </span>
                        <span class="badge rounded-pill px-3 py-2 text-white" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15); font-size: 12px; font-weight: 500;">
                            <i class="fa-solid fa-shield-halved text-success me-1"></i> ১০০% অরিজিনাল পণ্য
                        </span>
                    </div>
                </div>

                <div class="col-lg-4 text-center text-lg-end d-none d-lg-block">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 110px; height: 110px; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15);">
                        <i class="fa-solid fa-fire text-warning" style="font-size: 54px;"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. TOOLBAR / FILTERING ROW --}}
        <div class="p-3 mb-4 rounded-4 bg-white border shadow-xs d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold" style="font-size: 12.5px;">
                    <i class="fa-solid fa-boxes-stacked me-1"></i> মোট {{ $bestsellers->total() }}টি বেস্টসেলার
                </span>
                @if($bestsellers->total() > 0)
                    <span class="text-muted small d-none d-sm-inline">
                        (দেখাচ্ছে: {{ $bestsellers->firstItem() }}–{{ $bestsellers->lastItem() }})
                    </span>
                @endif
            </div>

            <form method="GET" class="d-flex align-items-center gap-2">
                <label for="sort-select" class="small text-muted fw-semibold d-none d-sm-inline">সাজান:</label>
                <select id="sort-select" name="sort" class="form-select form-select-sm rounded-pill shadow-none" style="min-width: 170px; font-size: 13px;" onchange="this.form.submit()">
                    <option value="">ডিফল্ট (নতুন আগে)</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>মূল্য: কম থেকে বেশি</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>মূল্য: বেশি থেকে কম</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>পুরাতন আগে</option>
                </select>
            </form>
        </div>

        {{-- 3. PRODUCT GRID --}}
        @if($bestsellers->isNotEmpty())
            <div class="ub-product-grid">
                @foreach($bestsellers as $product)
                    @include('frontend.components.product-card', ['product' => $product])
                @endforeach
            </div>

            {{-- 4. PAGINATION --}}
            @if ($bestsellers->hasPages())
                <div class="mt-5 d-flex justify-content-center">
                    {{ $bestsellers->links() }}
                </div>
            @endif
        @else
            <div class="p-5 my-4 text-center rounded-4 bg-white border shadow-xs">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light mb-3" style="width: 80px; height: 80px;">
                    <i class="fa-solid fa-box-open text-muted" style="font-size: 34px;"></i>
                </div>
                <h4 class="fw-bold text-dark mb-2">বর্তমানে কোনো বেস্টসেলার প্রোডাক্ট নেই</h4>
                <p class="text-muted small mb-4" style="max-width: 440px; margin: 0 auto;">আমাদের সম্পূর্ণ ক্যাটালগ ও নতুন কালেকশনগুলো ঘুরে দেখুন।</p>
                <a href="{{ route('search') }}" class="btn btn-dark rounded-pill px-4 py-2.5 fw-bold text-white shadow-sm" style="background: #0f172a;">
                    <i class="fa-solid fa-arrow-left me-1"></i> সকল প্রোডাক্ট দেখুন
                </a>
            </div>
        @endif

    </div>
</div>
@endsection
