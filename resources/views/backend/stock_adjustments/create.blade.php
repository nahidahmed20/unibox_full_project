@extends('backend.layouts.app')
@section('title', 'Create Stock Adjustment')
@section('content')
    @push('styles')
        <style>
            .shopify-card {
                background: #fff;
                border: 1px solid #e2e8f0;
                border-radius: 14px;
                box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
                overflow: hidden;
            }

            .shopify-input {
                border: 1px solid #cbd5e1;
                border-radius: 10px;
                padding: 10px 14px;
                transition: all 0.2s;
            }

            .shopify-input:focus {
                border-color: #4361ee;
                box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
                outline: none;
            }

            .table-container {
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                overflow: hidden;
            }

            .table thead {
                background: #f8fafc;
                border-bottom: 1px solid #e2e8f0;
            }

            .table thead th {
                color: #64748b;
                font-size: 13px;
                font-weight: 600;
                text-transform: uppercase;
                padding: 14px;
            }

            #searchResults {
                position: absolute;
                width: 100%;
                background: #fff;
                border: 1px solid #e2e8f0;
                border-radius: 10px;
                max-height: 300px;
                overflow-y: auto;
                z-index: 999;
                box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            }

            .search-item {
                padding: 12px 15px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                cursor: pointer;
                border-bottom: 1px solid #f1f5f9;
                transition: .2s;
            }

            .search-item:hover {
                background: #f8fafc;
            }

            .product-info {
                display: flex;
                flex-direction: column;
            }

            .product-title {
                font-size: 14px;
                font-weight: 700;
                color: #1e293b;
            }

            .product-meta {
                font-size: 12px;
                color: #64748b;
            }

            .product-add {
                font-size: 20px;
                color: #4361ee;
            }
        </style>
    @endpush

    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1" style="color: #212b36;">Create Stock Adjustment</h3>
                <p class="text-muted small mb-0">Record inventory addition or reduction with audit tracking</p>
            </div>
            <button type="submit" form="adjustmentForm" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                <i class="fa-solid fa-check me-1"></i> Save Adjustment
            </button>
        </div>

        <form id="adjustmentForm">
            @csrf
            <div class="row">
                <div class="col-lg-8">
                    <div class="shopify-card p-4 mb-4">
                        <div class="mb-4">
                            <label class="form-label fw-bold">Search Products</label>
                            <div class="position-relative">
                                <input type="text" id="productSearch" class="form-control shopify-input"
                                    placeholder="Type SKU or Product Name to adjust stock...">
                                <div id="searchResults" style="display: none;"></div>
                            </div>
                        </div>

                        <div class="table-container">
                            <table class="table align-middle mb-0" id="selectedProducts">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Variation</th>
                                        <th>Cost Price</th>
                                        <th>Qty</th>
                                        <th>Total Value</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="shopify-card p-4">
                        <h5 class="fw-bold mb-3">Adjustment Details</h5>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted">Adjustment Type</label>
                            <select class="form-select shopify-input" name="type" id="type" required>
                                <option value="addition">Addition (+) Increase Stock</option>
                                <option value="subtraction">Subtraction (-) Decrease Stock</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted">Reason</label>
                            <select class="form-select shopify-input" name="reason" id="reason" required>
                                <option value="Stock Correction">Stock Correction</option>
                                <option value="Damage">Damage / Broken</option>
                                <option value="Theft">Theft / Lost</option>
                                <option value="Expired">Expired</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted">Reference No</label>
                            <input type="text" name="reference_no" value="{{ $nextAdjustmentNo ?? 'ADJ-'.time() }}"
                                class="form-control shopify-input" placeholder="e.g. ADJ-0001">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted">Date</label>
                            <input type="date" name="adjustment_date" value="{{ date('Y-m-d') }}" class="form-control shopify-input" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted">Notes / Remarks</label>
                            <textarea name="note" class="form-control shopify-input" rows="3" placeholder="Write reason details..."></textarea>
                        </div>

                        <hr>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="fs-5 text-muted">Total Value</span>
                            <h3 class="fw-bold mb-0">BDT <span id="grandTotal">0.00</span></h3>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let rowIndex = 0;

            $("#productSearch").on("keyup", function() {
                let q = $(this).val();

                if (q.length < 2) {
                    $("#searchResults").hide();
                    return;
                }
                $.ajax({
                    url: "{{ route('products.search') }}",
                    type: "GET",
                    data: { q: q },
                    success: function(res) {
                        let html = "";
                        if (res.length > 0) {
                            res.forEach(function(p) {
                                html += `
                                <div class="search-item"
                                    data-product='${JSON.stringify(p).replace(/'/g, "&apos;")}'>
                                    <div style="flex:1">
                                        <div class="product-name-text fw-bold">${p.name}</div>
                                        <div class="product-sku-text text-muted small">
                                            SKU : ${p.sku ?? '-'} | Price : ${p.purchase_price}
                                        </div>
                                    </div>
                                    <i class="fa fa-plus-circle text-success fs-5"></i>
                                </div>
                            `;
                            });
                        } else {
                            html = `
                            <div class="p-3 text-center text-muted">
                                No Product Found
                            </div>
                        `;
                        }
                        $("#searchResults").html(html).show();
                    }
                });
            });

            $(document).on("click", ".search-item", function() {
                let product = JSON.parse($(this).attr("data-product"));
                addProduct(product);
            });

            function addProduct(p) {
                $("#searchResults").hide();
                $("#productSearch").val("");
                
                let sizes = p.sizes || [];
                let colors = p.colors || [];
                let sizeHtml = "";
                
                if (sizes.length > 0) {
                    sizeHtml = `
                    <select name="products[${rowIndex}][size_id]" class="form-select form-select-sm mb-1 shopify-input py-1">
                        ${sizes.map(function (s) {
                            return `<option value="${s.id}">${s.size}</option>`;
                        }).join("")}
                    </select>
                `;
                }
                
                let colorHtml = "";
                if (colors.length > 0) {
                    colorHtml = `
                    <select name="products[${rowIndex}][color_id]" class="form-select form-select-sm shopify-input py-1">
                        ${colors.map(function(c){
                            let colorName = c.color ? c.color.name : "Default";
                            return `<option value="${c.color_id}">${colorName}</option>`;
                        }).join("")}
                    </select>
                `;
                }

                let row = `
                <tr>
                    <td>
                        <div>
                            <strong>${p.name}</strong><br>
                            <small class="text-muted">SKU : ${p.sku ?? '-'}</small>
                            <input type="hidden" name="products[${rowIndex}][id]" value="${p.id}">
                        </div>
                    </td>
                    <td>
                        ${sizeHtml}
                        ${colorHtml}
                    </td>
                    <td>
                        <input type="number" class="form-control price shopify-input" name="products[${rowIndex}][price]" value="${p.purchase_price}" step="0.01">
                    </td>
                    <td>
                        <input type="number" class="form-control qty shopify-input" name="products[${rowIndex}][qty]" value="1" min="1">
                    </td>
                    <td class="row-total fw-semibold">
                        ${parseFloat(p.purchase_price).toFixed(2)}
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm remove rounded-circle">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
                $("#selectedProducts tbody").append(row);
                rowIndex++;
                calculateTotal();
            }

            $(document).on("input", ".price, .qty", function() {
                calculateTotal();
            });

            function calculateTotal() {
                let grandTotal = 0;
                $("#selectedProducts tbody tr").each(function() {
                    let price = parseFloat($(this).find(".price").val()) || 0;
                    let qty = parseFloat($(this).find(".qty").val()) || 0;
                    let total = price * qty;
                    $(this).find(".row-total").text(total.toFixed(2));
                    grandTotal += total;
                });
                $("#grandTotal").text(grandTotal.toFixed(2));
            }
            $(document).on("click", ".remove", function() {
                $(this).closest("tr").remove();
                calculateTotal();
            });

            $("#adjustmentForm").submit(function(e) {
                e.preventDefault();
                
                if($("#selectedProducts tbody tr").length === 0) {
                    toastr.error("Please add at least one product to adjust stock.");
                    return;
                }

                $.ajax({
                    url: "{{ route('stock-adjustments.store') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(res) {
                        toastr.success(res.message || "Stock adjusted successfully");
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    },
                    error: function(xhr) {
                        if(xhr.status == 422){
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value){
                                toastr.error(value[0]);
                            });
                        } else {
                            toastr.error("Something went wrong. Please try again.");
                        }
                    }
                });
            });

            $(document).click(function(e) {
                if (!$(e.target).closest("#productSearch, #searchResults").length) {
                    $("#searchResults").hide();
                }
            });
        });
    </script>
@endpush