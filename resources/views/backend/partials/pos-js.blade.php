<script>
    $(document).ready(function () {
        let cart = [];
        window.currentVariants = [];

        // Focus search box automatically for barcode scanner
        setTimeout(function() {
            $("#searchProduct").focus();
        }, 500);

        // Filter Products by Search & Category
        function filterProducts() {
            let search = $("#searchProduct").val().trim().toLowerCase();
            let category = $(".pos-cat-pill.active").data("id");
            let visibleCount = 0;

            $(".pos-product-card").each(function () {
                let name = ($(this).data("name") || "").toString().toLowerCase();
                let sku = ($(this).data("sku") || "").toString().toLowerCase();
                let barcode = ($(this).data("barcode") || "").toString().toLowerCase();
                let cat = $(this).data("category");

                let matchesSearch = search === "" || name.indexOf(search) > -1 || sku.indexOf(search) > -1 || barcode.indexOf(search) > -1;
                let matchesCategory = (category === "all" || String(cat) === String(category));

                if (matchesSearch && matchesCategory) {
                    $(this).show();
                    visibleCount++;
                } else {
                    $(this).hide();
                }
            });

            $("#visibleProductCount").text(visibleCount);
        }

        $("#searchProduct").on("input", filterProducts);

        // Barcode Scanner detection (Enter key in search box)
        $("#searchProduct").on("keypress", function (e) {
            if (e.which === 13) {
                e.preventDefault();
                let scanCode = $(this).val().trim().toLowerCase();
                if (!scanCode) return;

                // Find exact match by barcode or SKU
                let matchedCard = null;
                $(".pos-product-card").each(function () {
                    let barcode = ($(this).data("barcode") || "").toString().toLowerCase();
                    let sku = ($(this).data("sku") || "").toString().toLowerCase();
                    if (barcode === scanCode || sku === scanCode) {
                        matchedCard = $(this);
                        return false;
                    }
                });

                if (matchedCard && matchedCard.length) {
                    matchedCard.click();
                    $(this).val("").trigger("input");
                } else {
                    // Try first visible product if only 1 is visible
                    let visibleCards = $(".pos-product-card:visible");
                    if (visibleCards.length === 1) {
                        visibleCards.first().click();
                        $(this).val("").trigger("input");
                    } else if (visibleCards.length === 0) {
                        toastr.warning("No product found for barcode: " + scanCode);
                    }
                }
            }
        });

        // Category Tab Filter
        $(".pos-cat-pill").on("click", function () {
            $(".pos-cat-pill").removeClass("active");
            $(this).addClass("active");
            let catId = $(this).data("id");
            $("#category_filter").val(catId);
            filterProducts();
        });

        // Category Dropdown Filter (Sync with Tabs)
        $("#category_filter").on("change", function () {
            let catId = $(this).val();
            $(".pos-cat-pill").removeClass("active");
            let targetPill = $('.pos-cat-pill[data-id="' + catId + '"]');
            if (targetPill.length) {
                targetPill.addClass("active");
                let container = $("#categoryBar");
                if (container.length) {
                    let scrollPos = targetPill.position().left + container.scrollLeft() - (container.width() / 2) + (targetPill.width() / 2);
                    container.animate({ scrollLeft: scrollPos }, 200);
                }
            }
            filterProducts();
        });

        // Category Scroll Buttons
        $("#scrollCatLeft").on("click", function () {
            $("#categoryBar").animate({ scrollLeft: "-=200" }, 200);
        });
        $("#scrollCatRight").on("click", function () {
            $("#categoryBar").animate({ scrollLeft: "+=200" }, 200);
        });

        // Payment Method Selector
        $(".pos-pay-pill").on("click", function () {
            $(".pos-pay-pill").removeClass("active");
            $(this).addClass("active");
            $("#payment_method").val($(this).data("method"));
        });

        // Clear Cart Button
        $("#clearCartBtn").on("click", function () {
            if (cart.length === 0) return;
            if (confirm("Are you sure you want to clear all items in the cart?")) {
                cart = [];
                renderCart();
                toastr.info("Cart cleared.");
            }
        });

        // Product Card Click (Add to Cart or Open Variant Modal)
        $(document).on("click", ".pos-product-card", function () {
            let product = {
                id: $(this).data("id"),
                name: $(this).data("name"),
                price: parseFloat($(this).data("price")),
                type: $(this).data("type"),
                stock: parseInt($(this).data("stock")),
                variants: $(this).data("variants"),
                qty: 1
            };

            if (product.stock <= 0) {
                toastr.error("This product is Out of Stock!");
                return;
            }

            if (product.type === "single" || !product.variants || product.variants.length === 0) {
                addToCart(product);
                return;
            }

            // Extract Unique Colors and Sizes for Variant Modal
            let uniqueColors = [];
            let uniqueSizes = [];
            let colorIds = [];
            let sizeIds = [];

            $.each(product.variants, function (i, v) {
                if (v.color && v.color.id && !colorIds.includes(v.color.id)) {
                    colorIds.push(v.color.id);
                    uniqueColors.push({ id: v.color.id, name: v.color.name });
                }
                if (v.size && v.size.id && !sizeIds.includes(v.size.id)) {
                    sizeIds.push(v.size.id);
                    uniqueSizes.push({ id: v.size.id, name: v.size.name });
                }
            });

            if (uniqueColors.length > 0) {
                $("#modal_color").closest(".mb-4").show();
                let colorHtml = '<option value="">-- Choose Color --</option>';
                $.each(uniqueColors, function (i, c) {
                    colorHtml += '<option value="' + c.id + '">' + c.name + '</option>';
                });
                $("#modal_color").html(colorHtml);
            } else {
                $("#modal_color").closest(".mb-4").hide();
                $("#modal_color").val("");
            }

            if (uniqueSizes.length > 0) {
                $("#modal_size").closest(".mb-4").show();
                let sizeHtml = '<option value="">-- Choose Size --</option>';
                $.each(uniqueSizes, function (i, s) {
                    sizeHtml += '<option value="' + s.id + '">' + s.name + '</option>';
                });
                $("#modal_size").html(sizeHtml);
            } else {
                $("#modal_size").closest(".mb-4").hide();
                $("#modal_size").val("");
            }

            $("#modal_product_id").val(product.id);
            $("#modal_product_name").val(product.name);
            $("#modal_product_price").val(product.price);
            window.currentVariants = product.variants;

            $("#variantStock").html(product.stock);
            let variantModal = new bootstrap.Modal(document.getElementById("variantModal"));
            variantModal.show();
        });

        // Variant stock preview
        function updateVariantStock() {
            let color = $("#modal_color").val();
            let size = $("#modal_size").val();
            let isColorVisible = $("#modal_color").closest(".mb-4").is(":visible");
            let isSizeVisible = $("#modal_size").closest(".mb-4").is(":visible");

            let matchedVariant = window.currentVariants.find(function (item) {
                let matchColor = (!isColorVisible || color === "") ? true : (String(item.color_id) === String(color));
                let matchSize = (!isSizeVisible || size === "") ? true : (String(item.size_id) === String(size));
                return matchColor && matchSize;
            });

            $("#variantStock").html(matchedVariant ? matchedVariant.stock : 0);
        }

        $(document).on("change", "#modal_color, #modal_size", updateVariantStock);

        // Add Variant to Cart from Modal
        $("#addVariantCart").on("click", function () {
            let colorId = $("#modal_color").val();
            let sizeId = $("#modal_size").val();
            let isColorVisible = $("#modal_color").closest(".mb-4").is(":visible");
            let isSizeVisible = $("#modal_size").closest(".mb-4").is(":visible");

            if (isColorVisible && !colorId) {
                toastr.warning("Please choose a Color");
                return;
            }
            if (isSizeVisible && !sizeId) {
                toastr.warning("Please choose a Size");
                return;
            }

            let availableStock = parseInt($("#variantStock").text()) || 0;
            if (availableStock <= 0) {
                toastr.error("This variation is currently Out of Stock!");
                return;
            }

            let product = {
                id: $("#modal_product_id").val(),
                name: $("#modal_product_name").val(),
                price: parseFloat($("#modal_product_price").val()),
                stock: availableStock,
                qty: 1,
                color_id: colorId || null,
                color_name: isColorVisible ? $("#modal_color option:selected").text() : null,
                size_id: sizeId || null,
                size_name: isSizeVisible ? $("#modal_size option:selected").text() : null
            };

            addToCart(product);
            bootstrap.Modal.getInstance(document.getElementById("variantModal")).hide();
        });

        // Add to Cart Logic
        function addToCart(product) {
            let existingIndex = cart.findIndex(function (item) {
                let sameColor = (item.color_id || 0) == (product.color_id || 0);
                let sameSize = (item.size_id || 0) == (product.size_id || 0);
                return item.id == product.id && sameColor && sameSize;
            });

            if (existingIndex > -1) {
                if (cart[existingIndex].qty + 1 <= cart[existingIndex].stock) {
                    cart[existingIndex].qty++;
                    toastr.success("Updated quantity for " + product.name);
                } else {
                    toastr.error("Cannot add more. Reached stock limit (" + cart[existingIndex].stock + ")");
                }
            } else {
                if (product.qty <= product.stock) {
                    cart.push(product);
                    toastr.success("Added " + product.name + " to cart");
                } else {
                    toastr.error("Insufficient stock!");
                }
            }

            renderCart();
        }

        // Render Cart Table & Counts
        function renderCart() {
            let count = cart.reduce((acc, item) => acc + item.qty, 0);
            $("#cartItemCount").text(count);

            if (cart.length === 0) {
                $("#emptyCartState").show();
                $("#cartTable").hide();
                $("#cartBody").empty();
                calculate();
                return;
            }

            $("#emptyCartState").hide();
            $("#cartTable").show();

            let html = "";
            $.each(cart, function (index, item) {
                let total = item.qty * item.price;
                html += `
                <tr>
                    <td style="width: 50%;">
                        <div class="pos-cart-item-title">${item.name}</div>
                        <div class="pos-cart-item-meta">
                            ${item.color_name ? '<span class="pos-variant-chip"><i class="bi bi-circle-fill text-muted me-1" style="font-size: 8px;"></i>' + item.color_name + '</span>' : ''}
                            ${item.size_name ? '<span class="pos-variant-chip">' + item.size_name + '</span>' : ''}
                            <small class="text-muted">Stock: ${item.stock}</small>
                        </div>
                        <input type="hidden" name="product_id[]" value="${item.id}">
                        <input type="hidden" name="color_id[]" value="${item.color_id || ''}">
                        <input type="hidden" name="size_id[]" value="${item.size_id || ''}">
                        <input type="hidden" name="selling_price[]" value="${item.price}">
                        <input type="hidden" class="row-total" name="total_price[]" value="${total}">
                    </td>
                    <td style="width: 25%;">
                        <div class="pos-qty-pill">
                            <button type="button" class="pos-qty-btn minus" data-index="${index}">-</button>
                            <input type="text" class="pos-qty-input" name="quantity[]" value="${item.qty}" readonly>
                            <button type="button" class="pos-qty-btn plus" data-index="${index}">+</button>
                        </div>
                    </td>
                    <td style="width: 20%; text-align: right;">
                        <span class="pos-cart-price">৳${total.toFixed(2)}</span>
                    </td>
                    <td style="width: 5%; text-align: right;">
                        <button type="button" class="pos-cart-remove-btn remove" data-index="${index}" title="Remove item">
                            <i class="bi bi-x-circle-fill"></i>
                        </button>
                    </td>
                </tr>
                `;
            });

            $("#cartBody").html(html);
            calculate();
        }

        // Calculation of Subtotal, Discount, Delivery, Paid, Due
        function calculate() {
            let subtotal = 0;
            $(".row-total").each(function () {
                subtotal += parseFloat($(this).val() || 0);
            });

            // Discount
            let discountInput = parseFloat($("#discount").val() || 0);
            let discountType = $("#discount_type").val();
            let discountAmount = 0;

            if (discountType === "percent") {
                discountAmount = (subtotal * discountInput) / 100;
            } else {
                discountAmount = Math.min(discountInput, subtotal);
            }

            // Delivery
            let deliveryCharge = 0;
            let deliveryType = $("#delivery_type").val();
            if (deliveryType === "inside") {
                deliveryCharge = 60;
            } else if (deliveryType === "outside") {
                deliveryCharge = 120;
            }

            let grandTotal = Math.max(0, (subtotal - discountAmount) + deliveryCharge);

            // Paid and Due / Change
            let paidAmount = parseFloat($("#paid_amount").val() || 0);

            if (paidAmount >= grandTotal && grandTotal > 0) {
                let change = paidAmount - grandTotal;
                $("#changeOrDueLabel").text("Change / Return").removeClass("text-muted text-danger").addClass("text-success");
                $("#dueAmount").text("৳" + change.toFixed(2)).removeClass("text-danger").addClass("text-success");
                $("#due_amount").val(0);
            } else {
                let due = Math.max(0, grandTotal - paidAmount);
                $("#changeOrDueLabel").text("Balance Due").removeClass("text-success").addClass("text-danger");
                $("#dueAmount").text("৳" + due.toFixed(2)).removeClass("text-success").addClass("text-danger");
                $("#due_amount").val(due.toFixed(2));
            }

            $("#subtotalDisplay").text("৳" + subtotal.toFixed(2));
            $("#grandTotal").text("৳" + grandTotal.toFixed(2));
            $("#grand_total").val(grandTotal.toFixed(2));
        }

        $(document).on("input change", "#discount, #discount_type, #delivery_type, #paid_amount", calculate);

        // Quantity Stepper buttons
        $(document).on("click", ".plus", function () {
            let index = $(this).data("index");
            if (cart[index].qty < cart[index].stock) {
                cart[index].qty++;
                renderCart();
            } else {
                toastr.error("Reached available stock limit (" + cart[index].stock + ")");
            }
        });

        $(document).on("click", ".minus", function () {
            let index = $(this).data("index");
            if (cart[index].qty > 1) {
                cart[index].qty--;
                renderCart();
            } else {
                // If 1, remove item on minus
                cart.splice(index, 1);
                renderCart();
            }
        });

        $(document).on("click", ".remove", function () {
            let index = $(this).data("index");
            cart.splice(index, 1);
            renderCart();
        });

        // Quick Cash Buttons
        $("#exactCashBtn").on("click", function () {
            let total = parseFloat($("#grand_total").val() || 0);
            $("#paid_amount").val(total).trigger("input");
        });

        $(".quick-add-cash").on("click", function () {
            let addAmt = parseFloat($(this).data("amount") || 0);
            $("#paid_amount").val(addAmt).trigger("input");
        });

        // Initialize Select2 on Customer Select
        $('.customer-select').select2({
            placeholder: "-- Choose Customer --",
            allowClear: true,
            width: '100%'
        });

        // AJAX Add New Customer
        $("#addCustomerForm").on("submit", function (e) {
            e.preventDefault();
            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('customers.store') }}",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.success) {
                        $('#addCustomerModal').modal('hide');
                        $("#addCustomerForm")[0].reset();
                        toastr.success("Customer Added Successfully");
                        let newCustomer = response.customer;
                        let newOption = new Option(newCustomer.phone + ' - ' + newCustomer.name, newCustomer.id, true, true);
                        $('.customer-select').append(newOption).trigger('change');
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            toastr.error(value[0]);
                        });
                    } else {
                        toastr.error("Could not save customer.");
                    }
                }
            });
        });

        // Sale Form Submission
        $("#saleForm").on("submit", function (e) {
            e.preventDefault();

            let customerId = $("#customer_select").val();
            if (!customerId) {
                toastr.warning("Please select a customer first!");
                $("#customer_select").select2('open');
                return false;
            }

            if (cart.length === 0) {
                toastr.warning("Cart is empty! Select products or scan barcodes.");
                $("#searchProduct").focus();
                return false;
            }

            let submitBtn = $("#submitBtn");
            let originalHtml = submitBtn.html();
            submitBtn.prop("disabled", true).html('<span class="spinner-border spinner-border-sm me-2"></span> Processing Sale...');

            let formData = new FormData(this);
            formData.append('cart', JSON.stringify(cart));

            $.ajax({
                url: "{{ route('sales.store') }}",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    submitBtn.prop("disabled", false).html(originalHtml);

                    if (response.success) {
                        toastr.success(response.message || "Sale completed successfully!");
                        cart = [];
                        renderCart();
                        $("#saleForm")[0].reset();
                        $("#payment_method").val("cash");
                        $(".pos-pay-pill").removeClass("active").first().addClass("active");
                        $("#paid_amount").val(0);
                        calculate();

                        if (response.invoice_url) {
                            window.open(response.invoice_url, '_blank');
                        }
                    } else {
                        toastr.error(response.message || "Failed to complete sale!");
                    }
                },
                error: function (xhr) {
                    submitBtn.prop("disabled", false).html(originalHtml);
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            toastr.error(value[0]);
                        });
                    } else {
                        toastr.error("An unexpected error occurred while completing the sale.");
                    }
                }
            });
        });
    });
</script>