<style>
    /* =========================================================
       ULTRA-RESPONSIVE COMPACT POS SYSTEM STYLING
       Tailored for 13.5" Laptops (1366x768 / 1280x720 / 1080p scaled)
       and Large Desktop Screens Alike
       ========================================================= */

    :root {
        --pos-bg: #f8fafc;
        --pos-border: #e2e8f0;
        --pos-text: #1e293b;
        --pos-muted: #64748b;
        --pos-emerald: #10b981;
        --pos-danger: #ef4444;
        --pos-accent: #2563eb;
    }

    /* POS Wrapper - Fills full viewport without page scrolling */
    .pos-screen-wrapper {
        background-color: var(--pos-bg);
        height: calc(100vh - 58px);
        max-height: calc(100vh - 58px);
        overflow: hidden;
        display: flex;
        font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
    }

    /* ================= LEFT SECTION: CATALOG & SEARCH ================= */
    .pos-catalog-section {
        flex: 1;
        min-width: 0; /* Prevents flex children from overflowing */
        display: flex;
        flex-direction: column;
        height: 100%;
        overflow: hidden;
        border-right: 1px solid var(--pos-border);
        background: #f8fafc;
    }

    /* Top Bar */
    .pos-top-bar {
        background: #ffffff;
        padding: 10px 16px;
        border-bottom: 1px solid var(--pos-border);
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }

    .pos-search-box {
        position: relative;
        flex: 1;
        min-width: 180px;
    }

    .pos-search-box i.search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
    }

    .pos-search-input {
        width: 100%;
        height: 38px;
        background: #f1f5f9;
        border: 1px solid transparent;
        border-radius: 10px;
        padding-left: 38px;
        padding-right: 65px;
        font-size: 13px;
        font-weight: 500;
        color: var(--pos-text);
        transition: all 0.2s ease;
    }

    .pos-search-input:focus {
        background: #ffffff;
        border-color: var(--pos-accent);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        outline: none;
    }

    .pos-search-box .search-shortcut-badge {
        position: absolute;
        right: 8px;
        top: 50%;
        transform: translateY(-50%);
        background: #e2e8f0;
        color: #64748b;
        font-size: 10px;
        font-weight: 700;
        padding: 2px 6px;
        border-radius: 4px;
    }

    /* Category Dropdown (for quick selection on 13.5" screens) */
    .pos-cat-dropdown-select {
        height: 38px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 600;
        max-width: 160px;
        border-color: #e2e8f0;
    }

    /* Horizontal Category Bar with Nav Buttons */
    .pos-category-wrapper {
        background: #ffffff;
        border-bottom: 1px solid var(--pos-border);
        display: flex;
        align-items: center;
        padding: 6px 12px;
        gap: 6px;
        flex-shrink: 0;
    }

    .pos-cat-scroll-btn {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        color: #475569;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        cursor: pointer;
        flex-shrink: 0;
        transition: all 0.15s ease;
    }

    .pos-cat-scroll-btn:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .pos-category-bar {
        display: flex;
        gap: 6px;
        overflow-x: auto;
        white-space: nowrap;
        scrollbar-width: none;
        scroll-behavior: smooth;
        flex: 1;
        padding: 2px 0;
    }

    .pos-category-bar::-webkit-scrollbar {
        display: none;
    }

    .pos-cat-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 8px;
        background: #f1f5f9;
        color: #475569;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s ease;
        border: 1px solid transparent;
        user-select: none;
        flex-shrink: 0;
    }

    .pos-cat-pill:hover {
        background: #e2e8f0;
        color: #1e293b;
    }

    .pos-cat-pill.active {
        background: #0f172a;
        color: #ffffff;
    }

    .pos-cat-pill .cat-count {
        background: rgba(0, 0, 0, 0.08);
        padding: 1px 6px;
        border-radius: 20px;
        font-size: 10px;
    }

    .pos-cat-pill.active .cat-count {
        background: rgba(255, 255, 255, 0.2);
        color: #ffffff;
    }

    /* Product Grid Scroll Container */
    .pos-product-scroll {
        flex: 1;
        overflow-y: auto;
        padding: 14px 16px;
    }

    .pos-product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(145px, 1fr));
        gap: 12px;
    }

    /* Compact Product Card for 13.5" Displays */
    .pos-product-card {
        background: #ffffff;
        border: 1px solid var(--pos-border);
        border-radius: 12px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        cursor: pointer;
        position: relative;
        user-select: none;
    }

    .pos-product-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(0,0,0,0.06);
        border-color: #cbd5e1;
    }

    .pos-product-card:active {
        transform: scale(0.98);
    }

    .pos-card-thumb {
        position: relative;
        height: 105px;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 8px;
        border-bottom: 1px solid #f1f5f9;
    }

    .pos-card-thumb img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        transition: transform 0.2s ease;
    }

    .pos-product-card:hover .pos-card-thumb img {
        transform: scale(1.05);
    }

    .pos-stock-badge {
        position: absolute;
        top: 6px;
        left: 6px;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .pos-stock-badge.in-stock {
        background: #dcfce7;
        color: #15803d;
    }

    .pos-stock-badge.low-stock {
        background: #fef3c7;
        color: #b45309;
    }

    .pos-stock-badge.out-of-stock {
        background: #fee2e2;
        color: #b91c1c;
    }

    .pos-variant-indicator {
        position: absolute;
        top: 6px;
        right: 6px;
        background: #38bdf8;
        color: #ffffff;
        padding: 2px 5px;
        border-radius: 4px;
        font-size: 9px;
        font-weight: 700;
    }

    .pos-card-details {
        padding: 8px 10px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        justify-content: space-between;
    }

    .pos-product-cat {
        font-size: 10px;
        font-weight: 600;
        color: #94a3b8;
        text-transform: uppercase;
        margin-bottom: 2px;
    }

    .pos-product-title {
        font-size: 12px;
        font-weight: 600;
        color: var(--pos-text);
        line-height: 1.3;
        margin-bottom: 6px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 31px;
    }

    .pos-price-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: auto;
    }

    .pos-selling-price {
        font-size: 14px;
        font-weight: 700;
        color: #0f172a;
    }

    .pos-add-btn-icon {
        width: 26px;
        height: 26px;
        border-radius: 6px;
        background: #f1f5f9;
        color: #0f172a;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        transition: all 0.15s ease;
    }

    .pos-product-card:hover .pos-add-btn-icon {
        background: #0f172a;
        color: #ffffff;
    }

    /* ================= RIGHT SECTION: CART & REGISTER ================= */
    .pos-cart-section {
        width: 380px;
        min-width: 340px;
        background: #ffffff;
        height: 100%;
        display: flex;
        flex-direction: column;
        box-shadow: -3px 0 15px rgba(0, 0, 0, 0.04);
        z-index: 10;
        overflow: hidden;
    }

    /* Cart Header */
    .pos-cart-header {
        padding: 10px 14px;
        border-bottom: 1px solid var(--pos-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #ffffff;
        flex-shrink: 0;
    }

    .pos-cart-header h4 {
        margin: 0;
        font-size: 15px;
        font-weight: 700;
        color: var(--pos-text);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .pos-item-counter-badge {
        background: #0f172a;
        color: #ffffff;
        font-size: 11px;
        padding: 2px 7px;
        border-radius: 20px;
        font-weight: 700;
    }

    .pos-clear-cart-btn {
        background: transparent;
        border: none;
        color: #94a3b8;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .pos-clear-cart-btn:hover {
        color: var(--pos-danger);
    }

    /* Customer Selection Bar */
    .pos-customer-bar {
        padding: 8px 14px;
        background: #f8fafc;
        border-bottom: 1px solid var(--pos-border);
        flex-shrink: 0;
    }

    .pos-customer-input-group {
        display: flex;
        gap: 6px;
    }

    .pos-customer-select-wrapper {
        flex: 1;
    }

    .pos-customer-select-wrapper .select2-container--default .select2-selection--single {
        height: 36px;
        border-radius: 8px;
        border: 1px solid var(--pos-border);
        padding-top: 3px;
        background: #ffffff;
        font-size: 12px;
    }

    .pos-add-customer-btn {
        width: 36px;
        height: 36px;
        background: #ffffff;
        border: 1px solid var(--pos-border);
        border-radius: 8px;
        color: var(--pos-accent);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        cursor: pointer;
        flex-shrink: 0;
    }

    .pos-add-customer-btn:hover {
        background: var(--pos-accent);
        color: #ffffff;
    }

    /* Form Container */
    #saleForm {
        display: flex;
        flex-direction: column;
        flex: 1 1 0%;
        min-height: 0;
        overflow: hidden;
    }

    /* Cart Items Scrollable List - GUARANTEED SCROLL & VISIBILITY */
    .pos-cart-items-wrapper {
        flex: 1 1 0%;
        min-height: 140px;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 8px 12px;
    }

    .pos-cart-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 6px;
    }

    .pos-cart-table tr {
        background: #f8fafc;
        border-radius: 8px;
    }

    .pos-cart-table td {
        padding: 8px 8px;
        vertical-align: middle;
    }

    .pos-cart-table td:first-child {
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
    }

    .pos-cart-table td:last-child {
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
    }

    .pos-cart-item-title {
        font-size: 12px;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.3;
        margin-bottom: 2px;
    }

    .pos-cart-item-meta {
        font-size: 11px;
        color: #64748b;
        display: flex;
        gap: 4px;
        flex-wrap: wrap;
    }

    .pos-variant-chip {
        background: #e2e8f0;
        padding: 1px 5px;
        border-radius: 4px;
        font-size: 10px;
        font-weight: 600;
    }

    /* Quantity Pill Control */
    .pos-qty-pill {
        display: inline-flex;
        align-items: center;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        overflow: hidden;
    }

    .pos-qty-btn {
        width: 22px;
        height: 24px;
        border: none;
        background: transparent;
        color: #0f172a;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
    }

    .pos-qty-btn:hover {
        background: #f1f5f9;
    }

    .pos-qty-input {
        width: 26px;
        height: 24px;
        border: none;
        text-align: center;
        font-size: 11px;
        font-weight: 700;
        color: #0f172a;
        outline: none;
        background: transparent;
    }

    .pos-cart-price {
        font-size: 13px;
        font-weight: 700;
        color: #0f172a;
        white-space: nowrap;
    }

    .pos-cart-remove-btn {
        border: none;
        background: transparent;
        color: #cbd5e1;
        font-size: 13px;
        cursor: pointer;
        padding: 2px;
    }

    .pos-cart-remove-btn:hover {
        color: var(--pos-danger);
    }

    /* Empty Cart State */
    .pos-empty-cart {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: #94a3b8;
        text-align: center;
        padding: 20px;
    }

    .pos-empty-cart i {
        font-size: 36px;
        margin-bottom: 8px;
        color: #cbd5e1;
    }

    .pos-empty-cart h6 {
        font-weight: 700;
        color: #64748b;
        font-size: 13px;
        margin-bottom: 2px;
    }

    .pos-empty-cart p {
        font-size: 11px;
        margin: 0;
    }

    /* Compact Bottom Register Summary - NEVER CRUSHES THE CART */
    .pos-cart-footer {
        background: #ffffff;
        border-top: 1px solid var(--pos-border);
        padding: 10px 14px;
        box-shadow: 0 -3px 12px rgba(0, 0, 0, 0.03);
        flex-shrink: 0; /* Prevents shrinking */
    }

    .pos-calc-row {
        display: flex;
        gap: 8px;
        margin-bottom: 8px;
    }

    .pos-calc-col {
        flex: 1;
    }

    .pos-calc-col label {
        font-size: 10px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        margin-bottom: 2px;
        display: block;
    }

    /* Quick Cash Suggestion Chips */
    .pos-quick-cash-row {
        display: flex;
        gap: 4px;
        margin-bottom: 8px;
    }

    .pos-cash-chip {
        flex: 1;
        padding: 4px 0;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        color: #475569;
        text-align: center;
        cursor: pointer;
        user-select: none;
    }

    .pos-cash-chip:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    /* Payment Method Selector */
    .pos-payment-methods {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 4px;
        margin-bottom: 8px;
    }

    .pos-pay-pill {
        padding: 5px 2px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        text-align: center;
        font-size: 10px;
        font-weight: 700;
        color: #475569;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
    }

    .pos-pay-pill.active {
        border-color: #0f172a;
        background: #0f172a;
        color: #ffffff;
    }

    /* Grand Total & Submit Combined Bar */
    .pos-action-bar {
        background: #0f172a;
        color: #ffffff;
        border-radius: 10px;
        padding: 8px 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .pos-total-display-wrap {
        line-height: 1.1;
    }

    .pos-total-display-wrap small {
        font-size: 9px;
        text-transform: uppercase;
        color: #94a3b8;
        font-weight: 700;
        display: block;
    }

    .pos-total-display-wrap .total-amount {
        font-size: 18px;
        font-weight: 800;
        color: #ffffff;
    }

    .pos-complete-btn {
        height: 38px;
        background: #10b981;
        border: none;
        border-radius: 8px;
        color: #ffffff;
        font-size: 13px;
        font-weight: 700;
        padding: 0 16px;
        display: flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        white-space: nowrap;
        transition: background 0.15s ease;
    }

    .pos-complete-btn:hover {
        background: #059669;
    }

    /* Custom Slim Scrollbars */
    .pos-cart-items-wrapper::-webkit-scrollbar,
    .pos-product-scroll::-webkit-scrollbar {
        width: 4px;
    }
    .pos-cart-items-wrapper::-webkit-scrollbar-thumb,
    .pos-product-scroll::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
</style>