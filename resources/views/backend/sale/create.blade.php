@extends('backend.layouts.app')
@section('title', 'Point of Sale (POS)')

@push('styles')
    @include('backend.partials.pos-css')
@endpush

@section('content')
<div class="pos-screen-wrapper">

    {{-- ================= LEFT: PRODUCTS & CATALOG ================= --}}
    <div class="pos-catalog-section">

        {{-- Top Bar: Search & Barcode Scan --}}
        <div class="pos-top-bar">
            <div class="pos-search-box">
                <i class="bi bi-search search-icon"></i>
                <input type="text" id="searchProduct" class="pos-search-input" placeholder="Search product by name, SKU, or scan barcode..." autocomplete="off">
                <span class="search-shortcut-badge"><i class="bi bi-upc-scan me-1"></i> SCAN</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <select id="category_filter" class="form-select form-select-sm pos-cat-dropdown-select">
                    <option value="all">All Categories ({{ $products->count() }})</option>
                    @foreach ($categories as $category)
                        @php
                            $cCount = $products->where('category_id', $category->id)->count();
                        @endphp
                        <option value="{{ $category->id }}">{{ $category->name }} ({{ $cCount }})</option>
                    @endforeach
                </select>
                <span class="badge bg-light text-dark border px-2 py-2 fw-bold d-none d-sm-inline-flex align-items-center" style="font-size: 12px;">
                    <i class="bi bi-box-seam me-1 text-primary"></i> <span id="visibleProductCount">{{ $products->count() }}</span>
                </span>
            </div>
        </div>

        {{-- Horizontal Categories Bar with Left/Right Buttons --}}
        <div class="pos-category-wrapper">
            <button type="button" class="pos-cat-scroll-btn" id="scrollCatLeft" title="Scroll Left">
                <i class="bi bi-chevron-left"></i>
            </button>
            <div class="pos-category-bar" id="categoryBar">
                <div class="pos-cat-pill active" data-id="all">
                    <i class="bi bi-grid-fill"></i>
                    <span>All Items</span>
                    <span class="cat-count">{{ $products->count() }}</span>
                </div>
                @foreach ($categories as $category)
                    @php
                        $count = $products->where('category_id', $category->id)->count();
                    @endphp
                    <div class="pos-cat-pill" data-id="{{ $category->id }}">
                        <span>{{ $category->name }}</span>
                        <span class="cat-count">{{ $count }}</span>
                    </div>
                @endforeach
            </div>
            <button type="button" class="pos-cat-scroll-btn" id="scrollCatRight" title="Scroll Right">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>

        {{-- Product Grid --}}
        <div class="pos-product-scroll">
            <div class="pos-product-grid" id="productGrid">
                @foreach ($products as $product)
                    @php
                        $stockClass = $product->stock <= 0 ? 'out-of-stock' : ($product->stock <= ($product->alert_quantity ?? 5) ? 'low-stock' : 'in-stock');
                        $stockText = $product->stock <= 0 ? 'Out of Stock' : ($product->stock <= ($product->alert_quantity ?? 5) ? "Low: {$product->stock}" : "Stock: {$product->stock}");
                    @endphp
                    <div class="pos-product-card"
                        data-id="{{ $product->id }}"
                        data-name="{{ $product->name }}"
                        data-price="{{ $product->selling_price }}"
                        data-category="{{ $product->category_id }}"
                        data-type="{{ $product->product_type }}"
                        data-stock="{{ $product->stock }}"
                        data-sku="{{ strtolower($product->sku ?? '') }}"
                        data-barcode="{{ strtolower($product->barcode ?? '') }}"
                        data-variants='@json($product->variants)'>

                        <div class="pos-card-thumb">
                            <span class="pos-stock-badge {{ $stockClass }}">{{ $stockText }}</span>
                            @if($product->product_type === 'multiple')
                                <span class="pos-variant-indicator"><i class="bi bi-layers-fill"></i> Variants</span>
                            @endif
                            @if ($product->image)
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" loading="lazy">
                            @else
                                <img src="{{ asset('backend/no-image.png') }}" alt="No Image">
                            @endif
                        </div>

                        <div class="pos-card-details">
                            <div>
                                <div class="pos-product-cat">{{ $product->category->name ?? 'General' }}</div>
                                <div class="pos-product-title" title="{{ $product->name }}">{{ $product->name }}</div>
                            </div>
                            <div class="pos-price-row">
                                <span class="pos-selling-price">৳{{ number_format($product->selling_price, 2) }}</span>
                                <div class="pos-add-btn-icon">
                                    <i class="bi bi-plus-lg"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    {{-- ================= RIGHT: CART & REGISTER ================= --}}
    <div class="pos-cart-section">

        {{-- Cart Header --}}
        <div class="pos-cart-header">
            <h4>
                <i class="bi bi-bag-check-fill text-primary"></i> Current Sale
                <span class="pos-item-counter-badge" id="cartItemCount">0</span>
            </h4>
            <button type="button" class="pos-clear-cart-btn" id="clearCartBtn" title="Empty Cart">
                <i class="bi bi-trash3"></i> Clear
            </button>
        </div>

        {{-- Customer Selector Bar --}}
        <div class="pos-customer-bar">
            <div class="pos-customer-input-group">
                <div class="pos-customer-select-wrapper">
                    <select name="customer_id" id="customer_select" form="saleForm" class="customer-select form-control" required>
                        <option value="">-- Choose Customer --</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}" {{ $loop->first ? 'selected' : '' }}>
                                {{ $customer->phone }} - {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="button" class="pos-add-customer-btn" data-bs-toggle="modal" data-bs-target="#addCustomerModal" title="Add Customer">
                    <i class="bi bi-person-plus-fill"></i>
                </button>
            </div>
        </div>

        <form id="saleForm" action="{{ route('sales.store') }}" method="POST" class="d-flex flex-column flex-grow-1 overflow-hidden m-0">
            @csrf
            <input type="hidden" name="sale_date" value="{{ date('Y-m-d') }}">
            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
            <input type="hidden" name="branch_id" value="{{ auth()->user()->branch_id ?? '' }}">

            {{-- Cart Items List Area --}}
            <div class="pos-cart-items-wrapper">
                <div id="emptyCartState" class="pos-empty-cart">
                    <i class="bi bi-cart3"></i>
                    <h6>Your register is empty</h6>
                    <p>Select products from the left or scan barcode to begin.</p>
                </div>

                <table class="pos-cart-table" id="cartTable" style="display: none;">
                    <tbody id="cartBody">
                        {{-- Items rendered via JS --}}
                    </tbody>
                </table>
            </div>

            {{-- Cart Summary & Register Footer (Ultra Compact for 13.5" Displays) --}}
            <div class="pos-cart-footer">

                {{-- Row 1: Subtotal, Discount, Delivery --}}
                <div class="pos-calc-row">
                    <div class="pos-calc-col">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="m-0">Subtotal</label>
                            <span class="fw-bold text-dark" style="font-size: 12px;" id="subtotalDisplay">৳0.00</span>
                        </div>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text py-0 px-2 text-muted" style="font-size: 11px;">Disc</span>
                            <input type="number" id="discount" name="discount" class="form-control form-control-sm text-end fw-bold" value="0" min="0" step="0.01">
                            <select id="discount_type" name="discount_type" class="form-select form-select-sm" style="max-width: 65px; font-size: 11px;">
                                <option value="flat">৳</option>
                                <option value="percent">%</option>
                            </select>
                        </div>
                    </div>
                    <div class="pos-calc-col">
                        <div class="mb-1">
                            <label class="m-0">Delivery / Shipping</label>
                        </div>
                        <select name="delivery_type" id="delivery_type" class="form-select form-select-sm" style="font-size: 11px; height: 31px;">
                            <option value="free" data-charge="0">Pickup / Free (৳0)</option>
                            <option value="inside" data-charge="60">Inside Dhaka (৳60)</option>
                            <option value="outside" data-charge="120">Outside Dhaka (৳120)</option>
                        </select>
                    </div>
                </div>

                {{-- Row 2: Payment Method Pills --}}
                <input type="hidden" name="payment_method" id="payment_method" value="cash">
                <div class="pos-payment-methods">
                    <div class="pos-pay-pill active" data-method="cash">
                        <i class="bi bi-cash-stack"></i>
                        <span>Cash</span>
                    </div>
                    <div class="pos-pay-pill" data-method="bkash">
                        <i class="bi bi-phone"></i>
                        <span>bKash</span>
                    </div>
                    <div class="pos-pay-pill" data-method="nagad">
                        <i class="bi bi-wallet2"></i>
                        <span>Nagad</span>
                    </div>
                    <div class="pos-pay-pill" data-method="bank">
                        <i class="bi bi-bank"></i>
                        <span>Bank</span>
                    </div>
                </div>

                {{-- Row 3: Quick Cash Chips --}}
                <div class="pos-quick-cash-row">
                    <div class="pos-cash-chip" id="exactCashBtn">Exact</div>
                    <div class="pos-cash-chip quick-add-cash" data-amount="500">৳500</div>
                    <div class="pos-cash-chip quick-add-cash" data-amount="1000">৳1000</div>
                    <div class="pos-cash-chip quick-add-cash" data-amount="2000">৳2000</div>
                </div>

                {{-- Row 4: Paid Amount & Balance / Due --}}
                <div class="pos-calc-row align-items-center mb-2">
                    <div class="pos-calc-col">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text py-0 px-2 fw-bold text-muted" style="font-size: 11px;">Paid ৳</span>
                            <input type="number" id="paid_amount" name="paid_amount" class="form-control form-control-sm text-end fw-bold" value="0" min="0" step="0.01">
                        </div>
                    </div>
                    <div class="pos-calc-col text-end">
                        <small class="fw-bold d-block text-truncate text-danger" id="changeOrDueLabel" style="font-size: 10px;">Balance Due</small>
                        <span class="fw-bold text-danger fs-6" id="dueAmount">৳0.00</span>
                    </div>
                </div>

                {{-- Hidden Calculation Fields --}}
                <input type="hidden" id="grand_total" name="grand_total" value="0">
                <input type="hidden" id="due_amount" name="due_amount" value="0">

                {{-- Row 5: Action Bar (Grand Total & Submit Combined) --}}
                <div class="pos-action-bar">
                    <div class="pos-total-display-wrap">
                        <small>Grand Total</small>
                        <div class="total-amount" id="grandTotal">৳0.00</div>
                    </div>
                    <button type="submit" class="pos-complete-btn" id="submitBtn">
                        <i class="bi bi-check2-circle fs-5"></i>
                        <span>CONFIRM SALE</span>
                    </button>
                </div>

            </div>
        </form>

    </div>

</div>

@include('backend.sale.varient_modal')
@include('backend.sale.customer_modal')

@endsection

@push('scripts')
    @include('backend.partials.pos-js')
@endpush