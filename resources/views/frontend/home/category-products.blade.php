@extends('frontend.layouts.app')
@section('title', 'Home')
@section('content')
<section class="shop-grid pt-60 pb-100 single-category-page">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 ">
                        <div class="shop-grid-left">

                            {{-- TOP BAR --}}
                            <div class="top-grid-content">
                                <div class="shop-tab-nav">

                                    <nav>
                                        <div class="nav nav-tabs border-0" id="nav-tab" role="tablist">

                                            {{-- GRID --}}
                                            <button class="nav-link active"
                                                    id="nav-home-tab"
                                                    data-bs-toggle="tab"
                                                    data-bs-target="#nav-home"
                                                    type="button"
                                                    role="tab">

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
                                                    role="tab">

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
                            <li> <span class="disabled"> <i class="fa-regular fa-chevrons-left"></i> </span> </li>
                        @else
                            <li> <a href="{{ $products->previousPageUrl() }}"> <i class="fa-regular fa-chevrons-left"></i> </a> </li>
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
                            <li> <a href="{{ $products->nextPageUrl() }}"><i class="fa-regular fa-chevrons-right"></i> </a> </li>
                        @else
                            <li> <span class="disabled"> <i class="fa-regular fa-chevrons-right"></i> </span> </li>
                        @endif
                    </ul>
                @endif
            </div>
        </section>

@endsection
