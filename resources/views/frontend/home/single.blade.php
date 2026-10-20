@extends('frontend.layouts.app')
@section('uses-swiper', '1')
@section('title', $product->name . ' | Unibox')

@section('content')
@push('css')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/pages/home-single-1.css') }}">
@endpush

@php
    $totalStock = $product->stock;
@endphp

<section class="shop-section single pt-100 pb-100">
    <div class="container">
        <div class="row g-4">

            <!-- Product Gallery Image Section -->
            <div class="col-lg-6 col-md-12 product-details-wrap">
                <div class="product-slider-wrap">
                    <div class="swiper product-gallary-thumb">
                        <div class="swiper-wrapper" id="thumbWrapper">
                            @if($product->image)
                            <div class="swiper-slide"><div class="thumb-item"><img src="{{ asset($product->image) }}" alt="{{ $product->name }}"></div></div>
                            @endif
                            @foreach($product->images ?? [] as $img)
                            <div class="swiper-slide"><div class="thumb-item"><img src="{{ asset($img->image) }}" alt="{{ $product->name }}"></div></div>
                            @endforeach
                        </div>
                    </div>

                    <div class="swiper product-gallary">
                        <div class="swiper-wrapper" id="mainGalleryWrapper">
                            @if($product->image)
                            <div class="swiper-slide"><div class="gallary-item"><img src="{{ asset($product->image) }}" alt="{{ $product->name }}"></div></div>
                            @endif
                            @foreach($product->images ?? [] as $img)
                            <div class="swiper-slide"><div class="gallary-item"><img src="{{ asset($img->image) }}" alt="{{ $product->name }}"></div></div>
                            @endforeach
                        </div>
                        <div class="swiper-nav-next"><i class="fa-solid fa-chevron-right"></i></div>
                        <div class="swiper-nav-prev"><i class="fa-solid fa-chevron-left"></i></div>
                        <div class="stock-out-overlay" id="stockOutOverlay">Stock Out</div>
                    </div>
                </div>
            </div>

            <!-- Product Details Section -->
            <div class="col-lg-6 col-md-12">
                <div class="product-details">
                    <div class="product-info">
                        <div class="product-inner">

                            <span class="category">{{ $product->brand->name ?? '' }}</span>
                            <h3 class="title">{{ $product->name }}</h3>
                            
                            <h4 class="price">
                                ৳{{ $product->selling_price }}
                                @if($product->max_price)
                                    - ৳{{ $product->max_price }}
                                @endif
                                
                                @if($product->main_price)
                                    <span style="text-decoration: line-through; color: #a0aec0; font-size: 16px; margin-left: 10px;">
                                        ৳{{ $product->main_price }}
                                    </span>
                                @endif
                            </h4>

                            @if($product->short_description)
                            <div class="product-desc-wrap">
                                <p class="desc">{{ $product->short_description ?? '' }}</p>
                            </div>
                            @endif

                            @if($product->product_type !== 'single' && $product->sizes->count())
                            <div class="product-size mt-3">
                                <strong>Size:</strong>
                                <div class="d-flex gap-2 mt-2 flex-wrap">
                                    @foreach($product->sizes as $size)
                                        @php
                                            $targetSizeId = $size->size_id ?? $size->id;
                                            $stock = $product->variants->where('size_id', $targetSizeId)->sum('stock');
                                            $sizeName = $size->size->name ?? $size->name ?? 'N/A';
                                        @endphp
                                        <span class="size-item {{ $stock <= 0 ? 'disabled' : '' }}"
                                            data-size-id="{{ $targetSizeId }}"
                                            data-size="{{ $sizeName }}"
                                            data-stock="{{ $stock }}">
                                            {{ $sizeName }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            <input type="hidden" id="selectedSizeId">
                            <input type="hidden" id="selectedSize">

                            @if($product->product_type !== 'single' && $product->colors->count())
                            <div class="product-color mt-4">
                                <strong>Color: <span id="selectedColorName" class="text-muted fw-normal ms-1"></span></strong>
                                <div class="d-flex gap-2 mt-2 flex-wrap">
                                    @foreach($product->colors as $color)
                                        @php
                                            $targetColorId = $color->color_id; 
                                            $colorStock = $product->variants->where('color_id', $targetColorId)->sum('stock');
                                            $colorImages = $color->images ?? collect();
                                        @endphp
                                        <span class="color-box {{ $colorStock <= 0 ? 'stock-out' : '' }}"
                                            style="background: {{ $color->color->code ?? '#ccc' }}"
                                            data-color-id="{{ $targetColorId }}" 
                                            data-color-name="{{ $color->color->name ?? '' }}"
                                            data-color-stock="{{ $colorStock }}"
                                            data-color-images='@json($colorImages->pluck("image")->filter()->values())'
                                            title="{{ $color->color->name ?? '' }} {{ $colorStock <= 0 ? '(Stock Out)' : '' }}"
                                        ></span>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            <input type="hidden" id="selectedColorId">
                        </div>
                        
                        <!-- 🟢 Selectable Attributes Box 🟢 -->
                        @if($product->attributes && $product->attributes->count() > 0)
                        <div class="product-attributes-calculator">
                            <h4 class="attributes-heading">Choose your specifications to calculate the total cost.</h4>
                            
                            @foreach($product->attributes as $index => $attr)
                            <div class="attribute-step-wrapper">
                                <div class="attribute-step-title">
                                    Step {{ $index + 1 }}: Select {{ $attr->name }}
                                </div>
                                <div class="attribute-options-container">
                                    @foreach($attr->options as $optIndex => $opt)
                                        <!-- Hidden Radio Input -->
                                        <input type="radio" 
                                            name="custom_attributes[{{ $attr->id }}]" 
                                            id="attr_{{ $attr->id }}_opt_{{ $opt->id }}" 
                                            value="{{ $opt->value }}" 
                                            class="attribute-option-input"
                                            {{ $optIndex == 0 ? 'checked' : '' }}> <!-- by default first option selected -->
                                            
                                        <!-- Styled Label acting as Button -->
                                        <label for="attr_{{ $attr->id }}_opt_{{ $opt->id }}" class="attribute-option-label">
                                            {{ $opt->value }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                        <!-- ============================================== -->

                        <!-- 🟢 Calculator Size Dimension (Conditional) 🟢 -->
                        @if($product->is_calculator == 1)
                        <div class="product-attributes-calculator mt-4">
                            <h4 class="attributes-heading">Step Select Size Dimension (Width x Height)</h4>
                            <div class="row g-4 mt-1">
                                <div class="col-md-6">
                                    <label class="form-label text-muted" style="font-size: 12px; font-weight: 700; letter-spacing: 0.5px;">WIDTH (FEET & INCHES)</label>
                                    <div class="d-flex gap-2 align-items-center">
                                        <input type="number" id="width_ft" class="form-control text-center dim-input" value="0" min="0"> <span class="fw-bold text-muted">ft</span>
                                        <input type="number" id="width_in" class="form-control text-center dim-input" value="0" min="0" max="11"> <span class="fw-bold text-muted">in</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted" style="font-size: 12px; font-weight: 700; letter-spacing: 0.5px;">HEIGHT (FEET & INCHES)</label>
                                    <div class="d-flex gap-2 align-items-center">
                                        <input type="number" id="height_ft" class="form-control text-center dim-input" value="0" min="0"> <span class="fw-bold text-muted">ft</span>
                                        <input type="number" id="height_in" class="form-control text-center dim-input" value="0" min="0" max="11"> <span class="fw-bold text-muted">in</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 p-3 bg-light border rounded text-dark" style="font-size: 16px; font-weight: 600;">
                                = <span id="total_sqft">0.00</span> sq. ft
                            </div>
                            <input type="hidden" id="calc_sqft" value="0">
                        </div>
                        @endif

                        <div class="product-btn mt-4 d-flex gap-2 align-items-center">
                            <div class="qty-box">
                                <button class="qty-btn qty-minus">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" id="qty" value="1" min="1">
                                <button class="qty-btn qty-plus">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div class="cart-btn-wrap-2">
                                <button type="button" class="rr-primary-btn cart-btn" id="addToCartBtn" data-id="{{ $product->id }}" data-total-stock="{{ $totalStock }}">
                                    {{ $totalStock <= 0 ? 'Stock Out' : 'Add To Cart' }}
                                </button>
                            </div>
                        </div>
                        <a href="#" class="shop-details-btn rr-primary-btn mt-2 d-inline-block text-center w-100" id="buyNowBtn" data-id="{{ $product->id }}" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%) !important; border-radius: 9999px !important; font-weight: 800; font-size: 16px; padding: 14px 20px;">
                            <i class="fa-solid fa-bolt text-warning me-2"></i> অর্ডার করুন (Buy Now)
                        </a>

                        @if($product->extra_note)
                        <div class="product-extra-note mt-3 p-2 bg-light border rounded-3 small">
                            <i class="fa-solid fa-circle-info me-1 text-primary"></i> {{ $product->extra_note }}
                        </div>
                        @endif

                        {{-- TRUST & DELIVERY GUARANTEE BOX --}}
                        <div class="single-guarantee-box">
                            <div class="single-guarantee-item">
                                <i class="fa-solid fa-truck-fast"></i>
                                <span>সারা দেশে ক্যাশ অন ডেলিভারি সুবিধা (পণ্য হাতে পেয়ে মূল্য পরিশোধ)</span>
                            </div>
                            <div class="single-guarantee-item">
                                <i class="fa-solid fa-clock"></i>
                                <span>দ্রুত ডেলিভারি: ঢাকা সিটিতে ২৪-৪৮ ঘণ্টা, ঢাকার বাইরে ২-৪ দিন</span>
                            </div>
                            <div class="single-guarantee-item">
                                <i class="fa-solid fa-rotate-left"></i>
                                <span>৭ দিনের সহজ রিটার্ন এবং মানিব্যাক গ্যারান্টি</span>
                            </div>
                            <div class="single-guarantee-item">
                                <i class="fa-solid fa-shield-check"></i>
                                <span>১০০% অরিজিনাল ও অথেনটিক পণ্য নিশ্চিয়তা</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Description & Reviews Tabs -->
<section class="product-description pb-100">
    <div class="container">
        <ul class="nav tab-navigation" id="product-tab-navigation" role="tablist">
            <li role="presentation">
                <button class="active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Description</button>
            </li>
            
            <!-- 🟢 Specifications Tab Button 🟢 -->
            @if($product->attributes && $product->attributes->count() > 0)
            <li role="presentation">
                <button id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs" type="button" role="tab" aria-controls="specs" aria-selected="false">Specifications</button>
            </li>
            @endif

            <li role="presentation">
                <button id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Reviews ({{ $product->reviews->count() }})</button>
            </li>
        </ul>

        <div class="tab-content" id="product-tab-content">
            
            <!-- Description Tab -->
            <div class="tab-pane fade show active description" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="row gy-4 align-items-start mt-2"> 
                    <div class="col-12 {{ $product->size_guide ? 'col-lg-8 order-2 order-lg-1' : '' }}">
                        <div class="product-rich-description">
                            {!! $product->description !!}
                        </div>
                    </div>
                    @if($product->size_guide)
                    <div class="col-12 col-lg-4 order-1 order-lg-2">
                        <div class="size-guide-wrapper">
                            <img src="{{ asset($product->size_guide) }}" alt="Size Guide for {{ $product->name }}" class="img-fluid">
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- 🟢 Specifications Tab Content 🟢 -->
            @if($product->attributes && $product->attributes->count() > 0)
            <div class="tab-pane fade description" id="specs" role="tabpanel" aria-labelledby="specs-tab">
                <div class="row mt-4">
                    <div class="col-lg-8">
                        <h4 class="mb-4">Product Specifications & Attributes</h4>
                        <div class="table-responsive border rounded-3">
                            <table class="table table-striped table-hover mb-0">
                                <tbody>
                                    @foreach($product->attributes as $attr)
                                    <tr>
                                        <th width="35%" class="text-muted fw-semibold py-3 px-4">{{ $attr->name }}</th>
                                        <td class="text-dark fw-medium py-3 px-4">
                                            @if($attr->options && $attr->options->count() > 0)
                                                @foreach($attr->options as $opt)
                                                    <span class="badge bg-light text-dark border px-2 py-1 me-1">{{ $opt->value }}</span>
                                                @endforeach
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Reviews Tab -->
            <div class="tab-pane fade review" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                <div class="row product-review gy-lg-0 gy-4">
                    <div class="col-lg-5 col-md-12">
                        <div class="reviewr-wrap">
                            <div class="review-list">
                                @forelse($product->reviews as $review)
                                <div class="review-item">
                                    <div class="review-thumb">
                                        @if($review->user && $review->user->image)
                                            <img src="{{ asset($review->user->image) }}" alt="{{ $review->name }}">
                                        @else
                                            <img src="{{ asset('frontend/assets/img/shop/default-user.png') }}" alt="user">
                                        @endif
                                    </div>
                                    <div class="content">
                                        <div class="content-top">
                                            <h4 class="name">{{ $review->user_name }} <span>{{ $review->created_at->format('d M, Y') }}</span></h4>
                                            <ul class="review">
                                                @for($i=1; $i<=5; $i++)
                                                    <li><i class="fa-sharp fa-solid fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i></li>
                                                @endfor
                                            </ul>
                                        </div>
                                        <p>{{ $review->comment }}</p>
                                    </div>
                                </div>
                                @empty
                                <p>No reviews yet for this product.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7 col-md-12">
                        <div class="review-form-wrap">
                            <h4 class="title">Review this product</h4>
                            <span class="publish">Your email address will not be published. Required fields are marked *</span>
                            
                            <div class="blog-contact-form form-2 review-form">
                                <div class="request-form">
                                    @auth('customer')
                                        <form action="{{ route('product.review.store', $product->id) }}" method="post" class="form-horizontal">
                                            @csrf
                                            <div class="review-box pb-2">
                                                <span>Your ratings :</span>
                                                <input type="hidden" name="rating" id="rating-value" value="5">
                                                
                                                <ul class="review" id="star-rating" style="cursor: pointer; list-style: none; padding: 0; display: flex;">
                                                    <li data-value="1"><i class="fa-solid fa-star" style="color: #ffc107;"></i></li>
                                                    <li data-value="2"><i class="fa-solid fa-star" style="color: #ffc107;"></i></li>
                                                    <li data-value="3"><i class="fa-solid fa-star" style="color: #ffc107;"></i></li>
                                                    <li data-value="4"><i class="fa-solid fa-star" style="color: #ffc107;"></i></li>
                                                    <li data-value="5"><i class="fa-solid fa-star" style="color: #ffc107;"></i></li>
                                                </ul>
                                            </div>
                                            
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <div class="form-item">
                                                        <input type="text" name="name" class="form-control" 
                                                            value="{{ auth()->guard('customer')->user()->name }}" 
                                                            placeholder="Your Name" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-item">
                                                        <input type="email" name="email" class="form-control" 
                                                            value="{{ auth()->guard('customer')->user()->email }}" 
                                                            placeholder="Your Email" >
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <div class="form-item message-item">
                                                        <textarea name="comment" cols="30" rows="5" class="form-control address" placeholder="Comment" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="submit-btn">
                                                <button class="rr-primary-btn" type="submit">Submit</button>
                                            </div>
                                        </form>
                                    @else
                                        <div class="alert alert-info">
                                            Please <a href="{{ route('account.login') }}">login</a> to write a review.
                                        </div>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('javascript')
    <script>
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push({
            event: "view_item",
            ecommerce: {
                currency: "BDT",
                value: {{ $product->selling_price }},
                items: [
                    {
                        item_id: "{{ $product->id }}",
                        item_name: {!! json_encode($product->name) !!},
                        item_category: {!! json_encode($product->category->name ?? '') !!},
                        item_brand: {!! json_encode($product->brand->name ?? '') !!},
                        price: {{ $product->selling_price }},
                        quantity: 1
                    }
                ]
            }
        });

        // FB ViewContent
        if (typeof fbq === 'function') {
            fbq('track', 'ViewContent', {
                content_name: {!! json_encode($product->name) !!},
                content_category: {!! json_encode($product->category->name ?? '') !!},
                content_ids: ["{{ $product->id }}"],
                content_type: 'product',
                value: {{ $product->selling_price }},
                currency: 'BDT'
            });
        }
    
        $(document).ready(function () {

            const productType = "{{ $product->product_type }}";
            const hasSizeData  = {{ $product->sizes->count() > 0 ? 'true' : 'false' }};
            const hasColorData = {{ $product->colors->count() > 0 ? 'true' : 'false' }};
            const totalStock   = {{ $product->stock }};

            const isCalculator = {{ $product->is_calculator ?? 0 }};
            const pricePerSqft = {{ $product->price_per_sqft ?? 0 }};

            const hasSize  = hasSizeData && productType !== 'single';
            const hasColor = hasColorData && productType !== 'single';

            const defaultImages = @json(
                collect([$product->image])
                    ->merge($product->images->pluck('image'))
                    ->filter()
                    ->values()
            );

            let swiperMain = null;
            let swiperThumbs = null;

            function initSwipers() {
                swiperThumbs = new Swiper(".product-gallary-thumb", {
                    spaceBetween: 10,
                    slidesPerView: 4,
                    freeMode: true,
                    watchSlidesProgress: true,
                    breakpoints: {
                        768: { direction: 'vertical' },
                        0: { direction: 'horizontal' }
                    }
                });

                swiperMain = new Swiper(".product-gallary", {
                    spaceBetween: 10,
                    navigation: {
                        nextEl: ".swiper-nav-next",
                        prevEl: ".swiper-nav-prev",
                    },
                    thumbs: {
                        swiper: swiperThumbs,
                    },
                });
            }
            initSwipers();

            if (totalStock <= 0) {
                $('#addToCartBtn').text('Stock Out').prop('disabled', true).css({background: '#ccc', cursor: 'not-allowed', borderColor: '#ccc'});
                $('#buyNowBtn').text('Stock Out').css({pointerEvents: 'none', opacity: 0.6});
                $('#stockOutOverlay').addClass('show');
            }

            window.updateGallery = function(images) {
                if (!Array.isArray(images) || images.length === 0) images = defaultImages;
                
                let mainHtml = '', thumbHtml = '';
                images.forEach(img => {
                    let src = img.startsWith('http') ? img : '/' + img.replace(/^\//, '');
                    mainHtml += `<div class="swiper-slide"><div class="gallary-item"><img src="${src}"></div></div>`;
                    thumbHtml += `<div class="swiper-slide"><div class="thumb-item"><img src="${src}"></div></div>`;
                });

                if (swiperMain) swiperMain.destroy(true, true);
                if (swiperThumbs) swiperThumbs.destroy(true, true);

                $('#mainGalleryWrapper').html(mainHtml);
                $('#thumbWrapper').html(thumbHtml);

                initSwipers();
            };

            if(isCalculator == 1) {
                $('.dim-input').on('input', function() {
                    let w_ft = parseFloat($('#width_ft').val()) || 0;
                    let w_in = parseFloat($('#width_in').val()) || 0;
                    let h_ft = parseFloat($('#height_ft').val()) || 0;
                    let h_in = parseFloat($('#height_in').val()) || 0;

                    let totalWidthFt = w_ft + (w_in / 12);
                    let totalHeightFt = h_ft + (h_in / 12);
                    let totalSqft = totalWidthFt * totalHeightFt;

                    $('#total_sqft').text(totalSqft.toFixed(2));
                    $('#calc_sqft').val(totalSqft.toFixed(2));

                    let newPrice = totalSqft * pricePerSqft;
                    if(newPrice > 0) {
                        $('.price').html('৳' + newPrice.toFixed(2));
                    }
                });
            }

            $(document).on('click', '.color-box:not(.stock-out)', function () {
                $('.color-box').removeClass('active');
                $(this).addClass('active');
                $('#selectedColorId').val($(this).data('color-id'));
                $('#selectedColorName').text($(this).data('color-name'));
                
                let images = $(this).data('color-images');
                if (typeof images === 'string') images = JSON.parse(images);
                
                updateGallery(images);
            });

            $(document).on('click', '.size-item:not(.disabled)', function () {
                $('.size-item').removeClass('active');
                $(this).addClass('active');
                $('#selectedSizeId').val($(this).data('size-id'));
                $('#selectedSize').val($(this).data('size'));
            });

            function validateSelection() {
                if (productType === 'single') return true;
                if (hasSize && !$('#selectedSizeId').val()) { Swal.fire('Select Size', 'Please select a size', 'warning'); return false; }
                if (hasColor && !$('#selectedColorId').val()) { Swal.fire('Select Color', 'Please select a color', 'warning'); return false; }
                return true;
            }

            $('.qty-plus').click(function() {
                let input = $('#qty');
                input.val(parseInt(input.val()) + 1);
            });

            $('.qty-minus').click(function() {
                let input = $('#qty');
                let val = parseInt(input.val());
                if (val > 1) {
                    input.val(val - 1);
                }
            });

            $('#addToCartBtn, #buyNowBtn').on('click', function (event) {
                event.preventDefault();
                if (this.dataset.busy || !validateSelection()) return;
                const button = $(this);
                const buyNow = this.id === 'buyNowBtn';
                const originalLabel = button.text();
                const attributes = {};
                $('.attribute-option-input:checked').each(function () {
                    attributes[$(this).attr('name').match(/\d+/)[0]] = $(this).val();
                });
                const payload = {
                    _token: "{{ csrf_token() }}",
                    product_id: button.data('id'),
                    qty: $('#qty').val(),
                    size_id: $('#selectedSizeId').val() || null,
                    color_id: $('#selectedColorId').val() || null,
                    custom_attributes: attributes
                };
                if (isCalculator == 1) {
                    const area = parseFloat($('#calc_sqft').val()) || 0;
                    if (area <= 0) {
                        Swal.fire('Dimensions required', 'Enter a positive width and height.', 'warning');
                        return;
                    }
                    payload.dimensions = {
                        w_ft: $('#width_ft').val() || 0, w_in: $('#width_in').val() || 0,
                        h_ft: $('#height_ft').val() || 0, h_in: $('#height_in').val() || 0
                    };
                }
                this.dataset.busy = 'true';
                button.prop('disabled', true).text('Adding…');
                $.post("{{ route('cart.add') }}", payload).done(function (result) {
                    if (!result.success) {
                        Swal.fire('Unable to add item', result.message || 'Please check your options.', 'error');
                        return;
                    }
                    if (buyNow) { window.location.href = "{{ route('checkout') }}"; return; }
                    if (result.html) $('#cart-section').html(result.html);
                    $('.cart-item-count-render').text(result.cart_count);
                    document.querySelector('.cart-toggle').click();
                    window.Unibox.notify(result.message || 'Added to your shopping bag.');
                }).fail(function (response) {
                    Swal.fire('Unable to add item', response.responseJSON?.message || 'Please try again.', 'error');
                }).always(function () {
                    delete button[0].dataset.busy;
                    button.prop('disabled', false).text(originalLabel);
                });
            });
        });

        $(document).ready(function() {
            // Star Rating Logic
            $('#star-rating li').on('click', function() {
                let rating = $(this).data('value');
                $('#rating-value').val(rating);
                $('#star-rating li i').css('color', '#ccc');
                $('#star-rating li').each(function(index) {
                    if (index < rating) {
                        $(this).find('i').css('color', '#ffc107');
                    }
                });
            });

            $('#star-rating li').hover(
                function() {
                    let rating = $(this).data('value');
                    $('#star-rating li i').css('color', '#ccc');
                    $('#star-rating li').each(function(index) {
                        if (index < rating) {
                            $(this).find('i').css('color', '#ffc107');
                        }
                    });
                },
                function() {
                    let selected = $('#rating-value').val();
                    $('#star-rating li i').css('color', '#ccc');
                    $('#star-rating li').each(function(index) {
                        if (index < selected) {
                            $(this).find('i').css('color', '#ffc107');
                        }
                    });
                }
            );

            $('.product-rich-description').find('*').each(function() {
                var $this = $(this);
                $this.removeAttr('width').removeAttr('height');
                $this.css({
                    'width': '',
                    'min-width': '',
                    'max-width': '100%'
                });
            });
            $('.product-rich-description table').each(function() {
                if (!$(this).parent().hasClass('table-responsive')) {
                    $(this).wrap('<div class="table-responsive" style="width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; border: 1px solid #e5e7eb; margin-bottom: 15px;"></div>');
                }
            });
        });
    </script>
@endpush
