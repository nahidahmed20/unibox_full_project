@extends('frontend.layouts.app')
@section('title', isset($category) ? $category->name : (request('search') ? 'Search: ' . request('search') : 'All Products'))

@section('content')
<section class="shop-grid pt-4 pb-80 single-category-page">
    <div class="container">
        {{-- CATEGORY / SEARCH HERO BANNER --}}
        <div class="p-4 p-md-5 mb-4 rounded-4 border bg-light position-relative overflow-hidden" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="flex-grow-1">
                    <nav aria-label="breadcrumb" class="mb-2">
                        <ol class="breadcrumb mb-0 small">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-muted text-decoration-none"><i class="fa-solid fa-house me-1"></i> Home</a></li>
                            @if(isset($category))
                                <li class="breadcrumb-item"><a href="{{ route('search') }}" class="text-muted text-decoration-none">All Products</a></li>
                                @if($category->parent)
                                    <li class="breadcrumb-item"><a href="{{ route('category.show', $category->parent->slug) }}" class="text-muted text-decoration-none">{{ $category->parent->name }}</a></li>
                                @endif
                                <li class="breadcrumb-item active fw-bold text-dark">{{ $category->name }}</li>
                            @elseif(request('search'))
                                <li class="breadcrumb-item"><a href="{{ route('search') }}" class="text-muted text-decoration-none">All Products</a></li>
                                <li class="breadcrumb-item active fw-bold text-dark">Search Results</li>
                            @else
                                <li class="breadcrumb-item active fw-bold text-dark">All Products</li>
                            @endif
                        </ol>
                    </nav>

                    <h1 class="fw-bold text-dark mb-1" style="font-size: clamp(24px, 3.5vw, 36px);">
                        @if(isset($category))
                            {{ $category->name }}
                        @elseif(request('search'))
                            Search: "{{ request('search') }}"
                        @else
                            All Products
                        @endif
                    </h1>

                    <p class="text-muted mb-0 small">
                        @if(isset($category))
                            Showing {{ $products->total() }} curated products in {{ $category->name }}.
                        @elseif(request('search'))
                            Found {{ $products->total() }} results for "{{ request('search') }}".
                        @else
                            Showing all {{ $products->total() }} products ready for fast delivery.
                        @endif
                    </p>

                    @if(isset($category) && $category->children && $category->children->count() > 0)
                        <div class="d-flex align-items-center flex-wrap gap-2 mt-3 pt-3 border-top">
                            <span class="small text-muted fw-semibold me-1"><i class="fa-solid fa-layer-group me-1"></i> Subcategories:</span>
                            @foreach($category->children as $child)
                                <a href="{{ route('category.show', $child->slug) }}" class="badge bg-white text-dark border px-3 py-2 rounded-pill text-decoration-none shadow-xs" style="font-size: 13px; font-weight: 500;">
                                    {{ $child->name }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>

                @if(isset($category) && $category->image)
                    <div class="d-none d-md-block">
                        <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="rounded-4 shadow-sm border" style="width: 80px; height: 80px; object-fit: cover;">
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="shop-grid-left">

                    {{-- TOP BAR --}}
                    <div class="top-grid-content d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                                <div class="shop-tab-nav">

                                    <nav>
                                        <div class="nav nav-tabs border-0" id="nav-tab" role="tablist">

                                            {{-- GRID --}}
                                            <button class="nav-link active"
                                                    id="nav-home-tab"
                                                    data-bs-toggle="tab"
                                                    data-bs-target="#nav-home"
                                                    type="button"
                                                    role="tab"
                                                    aria-label="Grid view">

                                                <svg width="20" height="17" viewBox="0 0 20 17">
                                                    <rect x="15" width="5" height="3" fill="currentColor"/>
                                                    <rect x="15" y="7" width="5" height="3" fill="currentColor"/>
                                                    <rect x="15" y="14" width="5" height="3" fill="currentColor"/>
                                                    <rect x="7.71875" width="5" height="3" fill="currentColor"/>
                                                    <rect x="7.71875" y="7" width="5" height="3" fill="currentColor"/>
                                                    <rect x="7.71875" y="14" width="5" height="3" fill="currentColor"/>
                                                    <rect width="5" height="3" fill="currentColor"/>
                                                    <rect y="7" width="5" height="3" fill="currentColor"/>
                                                    <rect y="14" width="5" height="3" fill="currentColor"/>
                                                </svg>

                                            </button>

                                            {{-- LIST --}}
                                            <button class="nav-link"
                                                    id="nav-profile-tab"
                                                    data-bs-toggle="tab"
                                                    data-bs-target="#nav-profile"
                                                    type="button"
                                                    role="tab"
                                                    aria-label="List view">

                                                <svg width="20" height="17" viewBox="0 0 20 17">
                                                    <rect x="5.71875" width="14.2857" height="3" fill="currentColor"/>
                                                    <rect x="5.71875" y="7" width="14.2857" height="3" fill="currentColor"/>
                                                    <rect x="5.71875" y="14" width="14.2857" height="3" fill="currentColor"/>
                                                    <rect width="3.80952" height="3" fill="currentColor"/>
                                                    <rect y="7" width="3.80952" height="3" fill="currentColor"/>
                                                    <rect y="14" width="3.80952" height="3" fill="currentColor"/>
                                                </svg>

                                            </button>

                                        </div>
                                    </nav>

                                    <span>
                                        Showing {{ $products->firstItem() }}–{{ $products->lastItem() }}
                                        of {{ $products->total() }} results
                                    </span>

                                </div>
                                <form method="GET">
                                    @if(request('search'))
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                    @endif
                                    @if(request('category_id'))
                                        <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                                    @endif
                                    <select name="sort" class="form-select" onchange="this.form.submit()">
                                        <option value="">Default Sorting</option>
                                        <option value="latest"
                                            {{ request('sort') == 'latest' ? 'selected' : '' }}>
                                            Latest Products
                                        </option>
                                        <option value="price_low"
                                            {{ request('sort') == 'price_low' ? 'selected' : '' }}>
                                            Price Low to High
                                        </option>
                                        <option value="price_high"
                                            {{ request('sort') == 'price_high' ? 'selected' : '' }}>
                                            Price High to Low
                                        </option>
                                    </select>
                                </form>
                            </div>

                             <div id="productArea">
                                @include('frontend.home.partials.product_list', ['products' => $products])
                            </div>
                            

                        </div>
                    </div>
                    
                </div>
                @if ($products->hasPages())
                    <ul class="pagination-wrap mt-50">
                        {{-- Previous --}}
                        @if ($products->onFirstPage())
                            <li> <span class="disabled"> <i class="fa-solid fa-chevron-left"></i> </span> </li>
                        @else
                            <li> <a href="{{ $products->previousPageUrl() }}"> <i class="fa-solid fa-chevron-left"></i> </a> </li>
                        @endif
                        {{-- Page Numbers --}}
                        @foreach ($products->links()->elements[0] ?? [] as $page => $url)
                            @if ($page == $products->currentPage())
                                <li> <a href="{{ $url }}" class="active"> {{ $page }} </a> </li>
                            @else
                                <li><a href="{{ $url }}">{{ $page }} </a></li>
                            @endif
                        @endforeach
                        {{-- Next --}}
                        @if ($products->hasMorePages())
                            <li> <a href="{{ $products->nextPageUrl() }}"><i class="fa-solid fa-chevron-right"></i> </a> </li>
                        @else
                            <li> <span class="disabled"> <i class="fa-solid fa-chevron-right"></i> </span> </li>
                        @endif
                    </ul>
                @endif
            </div>
        </section>

@endsection
