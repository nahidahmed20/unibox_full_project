<style>
    /* Professional Compact Sidebar Styling */
    .app-sidebar {
        background: #111827 !important; /* Elegant Dark */
        border-right: 1px solid #1f2937;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .sidebar-wrapper {
        padding: 8px 10px;
    }

    /* Menu Items */
    .sidebar-wrapper .nav-item {
        margin-bottom: 1px;
    }

    .sidebar-wrapper .nav-link {
        border-radius: 6px !important;
        padding: 8px 12px !important;
        transition: all 0.2s ease;
        color: #9ca3af !important; /* Soft Gray */
        display: flex;
        align-items: center;
        font-weight: 500;
        font-size: 0.9rem;
        cursor: pointer;
        user-select: none;
    }

    /* Active & Hover States */
    .sidebar-wrapper .nav-link:hover {
        background: rgba(255, 255, 255, 0.05) !important;
        color: #f3f4f6 !important;
    }

    .sidebar-wrapper .nav-item.menu-open > .nav-link,
    .sidebar-wrapper .nav-link.active {
        background: linear-gradient(90deg, rgba(59, 130, 246, 0.15) 0%, rgba(59, 130, 246, 0.05) 100%) !important;
        color: #60a5fa !important;
        border-left: 3px solid #3b82f6;
    }

    /* Icons */
    .sidebar-wrapper .nav-icon {
        margin-right: 10px;
        font-size: 1.1rem;
        transition: transform 0.2s ease;
    }

    .sidebar-wrapper .nav-link.active .nav-icon {
        color: #3b82f6 !important;
        transform: scale(1.1);
    }

    /* Chevrons & Arrow Rotation */
    .sidebar-wrapper .nav-arrow {
        display: inline-block !important;
        transition: transform 0.22s ease !important;
    }
    .sidebar-wrapper .nav-item.menu-open > .nav-link .nav-arrow {
        transform: rotate(90deg) !important;
    }

    /* Submenus */
    .nav-treeview {
        margin-top: 1px;
        margin-bottom: 4px;
        background: #0b0f19 !important; /* Darker background for submenus */
        border-radius: 6px;
        padding: 4px 0;
    }

    .nav-treeview .nav-link {
        position: relative !important;
        padding: 6px 14px 6px 36px !important;
        font-size: 0.85rem;
        color: #9ca3af !important;
        border-left: none !important;
        background: transparent !important;
    }

    .nav-treeview .nav-link:hover {
        color: #f3f4f6 !important;
    }

    .nav-treeview .nav-link.active {
        color: #60a5fa !important;
        font-weight: 600;
        background: rgba(59, 130, 246, 0.08) !important;
    }

    .nav-treeview .nav-link.active::before {
        content: "" !important;
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        width: 6px;
        height: 6px;
        background-color: #3b82f6;
        border-radius: 50%;
        box-shadow: 0 0 8px rgba(59, 130, 246, 0.9);
    }

    /* Headers */
    .nav-header {
        font-size: 0.7rem !important;
        font-weight: 700;
        letter-spacing: 0.5px;
        color: #4b5563 !important;
        padding: 16px 15px 6px !important;
        text-transform: uppercase;
    }

    /* Branding */
    .brand-link {
        border-bottom: 1px solid #1f2937 !important;
        padding: 12px 15px !important;
        background: #111827 !important;
    }

    .brand-text {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700 !important;
        letter-spacing: 0.5px;
        color: #ffffff !important;
        font-size: 1.1rem;
    }

    /* Custom Scrollbar for Sidebar */
    .sidebar-wrapper::-webkit-scrollbar {
        width: 4px;
    }
    .sidebar-wrapper::-webkit-scrollbar-track {
        background: transparent;
    }
    .sidebar-wrapper::-webkit-scrollbar-thumb {
        background: #374151;
        border-radius: 4px;
    }
    .sidebar-wrapper:hover::-webkit-scrollbar-thumb {
        background: #4b5563;
    }
</style>

<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ route('dashboard') }}" class="brand-link">
            <img src="{{ asset(setting('footer_logo')) }}" alt="Logo" class="brand-image opacity-75 shadow" />
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column">

                <li class="nav-header">DASHBOARD & ANALYTICS</li>
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>



                @canany(['sale.all', 'sale.view', 'order-sale.view', 'order-return.view', 'order-cancel.view', 'pos.view', 'pos-create'])
                    <li class="nav-item {{ request()->routeIs('sales.*', 'orders.*', 'order.*', 'coupons.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('sales.*', 'orders.*', 'order.*', 'coupons.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-cart-check-fill"></i>
                            <p>
                                Sales & Orders
                                <i class="nav-arrow bi bi-chevron-right ms-auto"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="{{ request()->routeIs('sales.*', 'orders.*', 'order.*', 'coupons.*') ? 'display: block;' : 'display: none;' }}">
                            @can('pos-create')
                                <li class="nav-item">
                                    <a href="{{ route('sales.create') }}" class="nav-link {{ request()->routeIs('sales.create') ? 'active' : '' }}">
                                        <i class="bi bi-pc-display-horizontal"></i>
                                        <p>POS Sale Create</p>
                                    </a>
                                </li>
                            @endcan
                            @can('sale.view')
                                <li class="nav-item">
                                    <a href="{{ route('sales.index') }}" class="nav-link {{ request()->routeIs('sales.index') ? 'active' : '' }}">
                                        <i class="bi bi-list-ul"></i>
                                        <p>POS Sale List</p>
                                    </a>
                                </li>
                            @endcan
                            @can('order-sale.view')
                                <li class="nav-item">
                                    <a href="{{ route('orders.index') }}" class="nav-link {{ request()->routeIs('orders.index') ? 'active' : '' }}">
                                        <i class="bi bi-shop"></i>
                                        <p>Ecommerce Orders <span id="pending-order-count" class="badge bg-danger float-end" style="display:none;">0</span></p>
                                    </a>
                                </li>
                            @endcan
                            @can('sale.view')
                                <li class="nav-item">
                                    <a href="{{ route('orders.sales-list') }}" class="nav-link {{ request()->routeIs('orders.sales-list') ? 'active' : '' }}">
                                        <i class="bi bi-list-ul"></i>
                                        <p>Ecommerce Sale List</p>
                                    </a>
                                </li>
                            @endcan
                            @can('order-return.view')
                                <li class="nav-item">
                                    <a href="{{ route('order.return') }}" class="nav-link {{ request()->routeIs('order.return') ? 'active' : '' }}">
                                        <i class="bi bi-arrow-return-left"></i>
                                        <p>Order Return List</p>
                                    </a>
                                </li>
                            @endcan
                            @can('order-cancel.view')
                                <li class="nav-item">
                                    <a href="{{ route('order.cancelled') }}" class="nav-link {{ request()->routeIs('order.cancelled') ? 'active' : '' }}">
                                        <i class="bi bi-x-circle"></i>
                                        <p>Order Cancel List</p>
                                    </a>
                                </li>
                            @endcan
                            <li class="nav-item">
                                <a href="{{ route('coupons.index') }}" class="nav-link {{ request()->routeIs('coupons.*') ? 'active' : '' }}">
                                    <i class="bi bi-ticket-perforated-fill text-warning"></i>
                                    <p>Coupons & Vouchers</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                @endcanany


                @canany(['products.all', 'product.view', 'product.create', 'product.bulk-product', 'category.view', 'sub-category.view', 'brand.view', 'unit.view', 'color.view', 'size.view', 'variation.view', 'attribute.view', 'view product'])
                    <li class="nav-item {{ request()->routeIs('products.*', 'categories.*', 'sub-categories.*', 'brands.*', 'units.*', 'colors.*', 'sizes.*', 'variations.*', 'attributes.*', 'specifications.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('products.*', 'categories.*', 'sub-categories.*', 'brands.*', 'units.*', 'colors.*', 'sizes.*', 'variations.*', 'attributes.*', 'specifications.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-box-seam-fill"></i>
                            <p>
                                Catalog Setup
                                <i class="nav-arrow bi bi-chevron-right ms-auto"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="{{ request()->routeIs('products.*', 'categories.*', 'sub-categories.*', 'brands.*', 'units.*', 'colors.*', 'sizes.*', 'variations.*', 'attributes.*', 'specifications.*') ? 'display: block;' : 'display: none;' }}">
                            @can('product.view')
                                <li class="nav-item"><a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}"><i class="bi bi-list-ul"></i><p>Product List</p></a></li>
                            @endcan
                            @can('product.create')
                                <li class="nav-item"><a href="{{ route('products.create') }}" class="nav-link {{ request()->routeIs('products.create') ? 'active' : '' }}"><i class="bi bi-plus-circle-fill"></i><p>Product Create</p></a></li>
                            @endcan
                            @can('product.bulk-product')
                                <li class="nav-item"><a href="{{ route('products.bulk_upload_view') }}" class="nav-link {{ request()->routeIs('products.bulk_upload_view') ? 'active' : '' }}"><i class="bi bi-cloud-arrow-up"></i><p>Bulk Product</p></a></li>
                            @endcan
                            @can('category.view')
                                <li class="nav-item"><a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}"><i class="bi bi-grid-fill"></i><p>Category List</p></a></li>
                            @endcan

                            @can('brand.view')
                                <li class="nav-item"><a href="{{ route('brands.index') }}" class="nav-link {{ request()->routeIs('brands.*') ? 'active' : '' }}"><i class="bi bi-patch-check"></i><p>Brand List</p></a></li>
                            @endcan
                            @can('unit.view')
                                <li class="nav-item"><a href="{{ route('units.index') }}" class="nav-link {{ request()->routeIs('units.*') ? 'active' : '' }}"><i class="bi bi-hash"></i><p>Unit List</p></a></li>
                            @endcan
                            @can('color.view')
                                <li class="nav-item"><a href="{{ route('colors.index') }}" class="nav-link {{ request()->routeIs('colors.*') ? 'active' : '' }}"><i class="bi bi-palette"></i><p>Color List</p></a></li>
                            @endcan
                            @can('size.view')
                                <li class="nav-item"><a href="{{ route('sizes.index') }}" class="nav-link {{ request()->routeIs('sizes.*') ? 'active' : '' }}"><i class="bi bi-rulers"></i><p>Size List</p></a></li>
                            @endcan
                            @can('attribute.view')
                                <li class="nav-item"><a href="{{ route('attributes.index') }}" class="nav-link {{ request()->routeIs('attributes.*') ? 'active' : '' }}"><i class="bi bi-list-check"></i><p>Attribute List</p></a></li>
                            @endcan
                            <li class="nav-item"><a href="{{ route('specifications.index') }}" class="nav-link {{ request()->routeIs('specifications.*') ? 'active' : '' }}"><i class="bi bi-card-list"></i><p>Specification List</p></a></li>

                            @can('variation.view')
                                <li class="nav-item"><a href="{{ route('variations.index') }}" class="nav-link {{ request()->routeIs('variations.*') ? 'active' : '' }}"><i class="bi bi-sliders"></i><p>Variation List</p></a></li>
                            @endcan
                            @can('view product')
                                <li class="nav-item"><a href="{{ route('products.barcode.index') }}" class="nav-link {{ request()->routeIs('products.barcode.index') || request()->routeIs('products.barcode.print') ? 'active' : '' }}"><i class="bi bi-upc-scan"></i><p>Print Barcode</p></a></li>
                            @endcan
                        </ul>
                    </li>
                @endcanany


                @canany(['purchase.all', 'purchase.view', 'purchase.create', 'stock_adjustment.all', 'stock_adjustment.view', 'stock_adjustment.create', 'supplier-view'])
                    <li class="nav-item {{ request()->routeIs('purchases.*', 'stock-adjustments.*', 'stock-adjustment.*', 'suppliers.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('purchases.*', 'stock-adjustments.*', 'stock-adjustment.*', 'suppliers.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-basket-fill"></i>
                            <p>
                                Inventory & Purchases
                                <i class="nav-arrow bi bi-chevron-right ms-auto"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="{{ request()->routeIs('purchases.*', 'stock-adjustments.*', 'stock-adjustment.*', 'suppliers.*') ? 'display: block;' : 'display: none;' }}">
                            @can('purchase.view')
                                <li class="nav-item"><a href="{{ route('purchases.index') }}" class="nav-link {{ request()->routeIs('purchases.index') ? 'active' : '' }}"><i class="bi bi-list-ul"></i><p>Purchase List</p></a></li>
                            @endcan
                            @can('purchase.create')
                                <li class="nav-item"><a href="{{ route('purchases.create') }}" class="nav-link {{ request()->routeIs('purchases.create') ? 'active' : '' }}"><i class="bi bi-plus-circle"></i><p>Purchase Create</p></a></li>
                            @endcan
                            @can('stock_adjustment.view')
                                <li class="nav-item"><a href="{{ route('stock-adjustments.index') }}" class="nav-link {{ request()->routeIs('stock-adjustments.index') ? 'active' : '' }}"><i class="bi bi-sliders"></i><p>Stock Adjustments</p></a></li>
                            @endcan
                            @can('stock_adjustment.create')
                                <li class="nav-item"><a href="{{ route('stock-adjustments.create') }}" class="nav-link {{ request()->routeIs('stock-adjustments.create') ? 'active' : '' }}"><i class="bi bi-plus-circle-dotted"></i><p>Adjustment Create</p></a></li>
                            @endcan
                            @can('supplier-view')
                                <li class="nav-item"><a href="{{ route('suppliers.index') }}" class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}"><i class="bi bi-person-badge-fill"></i><p>Supplier List</p></a></li>
                            @endcan
                        </ul>
                    </li>
                @endcanany


                @canany(['expense.all', 'expense.view', 'expense.category.view', 'report.view'])
                    <li class="nav-item {{ request()->routeIs('expenses.*', 'expenses-categories.*', 'reports.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('expenses.*', 'expenses-categories.*', 'reports.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-wallet2"></i>
                            <p>
                                Finance & Reports
                                <i class="nav-arrow bi bi-chevron-right ms-auto"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="{{ request()->routeIs('expenses.*', 'expenses-categories.*', 'reports.*') ? 'display: block;' : 'display: none;' }}">
                            @can('expense.view')
                                <li class="nav-item"><a href="{{ route('expenses.index') }}" class="nav-link {{ request()->routeIs('expenses.index') ? 'active' : '' }}"><i class="bi bi-receipt"></i><p>All Expenses</p></a></li>
                            @endcan
                            @can('expense.category.view')
                                <li class="nav-item"><a href="{{ route('expenses-categories.index') }}" class="nav-link {{ request()->routeIs('expenses-categories.*') ? 'active' : '' }}"><i class="bi bi-tags"></i><p>Expense Categories</p></a></li>
                            @endcan
                            @can('report.view')
                                <li class="nav-item"><a href="{{ route('reports.total-income') }}" class="nav-link {{ request()->routeIs('reports.total-income') ? 'active' : '' }}"><i class="bi bi-cash-coin"></i><p>Total Income</p></a></li>
                                <li class="nav-item"><a href="{{ route('reports.sales') }}" class="nav-link {{ request()->routeIs('reports.sales') ? 'active' : '' }}"><i class="bi bi-cart-check-fill"></i><p>Sales Report</p></a></li>
                                <li class="nav-item"><a href="{{ route('reports.purchase') }}" class="nav-link {{ request()->routeIs('reports.purchase') ? 'active' : '' }}"><i class="bi bi-bag-check-fill"></i><p>Purchase Report</p></a></li>
                                <li class="nav-item"><a href="{{ route('reports.low-stock') }}" class="nav-link {{ request()->routeIs('reports.low-stock') ? 'active' : '' }}"><i class="bi bi-exclamation-triangle-fill text-warning"></i><p>Stock Alert Report</p></a></li>
                                <li class="nav-item"><a href="{{ route('reports.orders') }}" class="nav-link {{ request()->routeIs('reports.orders') ? 'active' : '' }}"><i class="bi bi-cart-check"></i><p>Online Orders Report</p></a></li>
                                <li class="nav-item"><a href="{{ route('reports.top-products') }}" class="nav-link {{ request()->routeIs('reports.top-products') ? 'active' : '' }}"><i class="bi bi-award-fill text-primary"></i><p>Top Products Report</p></a></li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
                <li class="nav-item {{ request()->routeIs('accounts.*', 'journals.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('accounts.*', 'journals.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-bank"></i>
                        <p>
                            Accounting (Core)
                            <i class="nav-arrow bi bi-chevron-right ms-auto"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="{{ request()->routeIs('accounts.*', 'journals.*') ? 'display: block;' : 'display: none;' }}">
                        <li class="nav-item"><a href="{{ route('accounts.index') }}" class="nav-link {{ request()->routeIs('accounts.index') ? 'active' : '' }}"><i class="bi bi-card-checklist"></i><p>Chart of Accounts</p></a></li>
                        <li class="nav-item"><a href="{{ route('journals.index') }}" class="nav-link {{ request()->routeIs('journals.*') ? 'active' : '' }}"><i class="bi bi-journal-text"></i><p>Journal Entries</p></a></li>
                        <li class="nav-item"><a href="{{ route('accounts.ledger') }}" class="nav-link {{ request()->routeIs('accounts.ledger') ? 'active' : '' }}"><i class="bi bi-journal-bookmark-fill"></i><p>Ledger Report</p></a></li>
                    </ul>
                </li>


                @canany(['customer.view', 'member.view'])
                    <li class="nav-item {{ request()->routeIs('customers.*', 'members.*', 'admin.reviews.*', 'blocked-phones.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('customers.*', 'members.*', 'admin.reviews.*', 'blocked-phones.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-people-fill"></i>
                            <p>
                                CRM & People
                                <i class="nav-arrow bi bi-chevron-right ms-auto"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="{{ request()->routeIs('customers.*', 'members.*', 'admin.reviews.*', 'blocked-phones.*') ? 'display: block;' : 'display: none;' }}">
                            @can('customer.view')
                                <li class="nav-item"><a href="{{ route('customers.index') }}" class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}"><i class="bi bi-person-bounding-box"></i><p>Customers List</p></a></li>
                            @endcan
                            @can('member.view')
                                <li class="nav-item"><a href="{{ route('members.index') }}" class="nav-link {{ request()->routeIs('members.*') ? 'active' : '' }}"><i class="bi bi-person-lines-fill"></i><p>Members List</p></a></li>
                            @endcan
                            <li class="nav-item">
                                <a href="{{ route('admin.reviews.index') }}" class="nav-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                                    <i class="bi bi-star-half text-warning"></i>
                                    <p>Customer Reviews</p>
                                </a>
                            </li>
                            @can('customer.view')
                                <li class="nav-item">
                                    <a href="{{ route('blocked-phones.index') }}" class="nav-link {{ request()->routeIs('blocked-phones.*') ? 'active' : '' }}">
                                        <i class="bi bi-person-x-fill text-danger"></i>
                                        <p>Return & Block List</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany


                @canany(['slider.view', 'blog.list', 'blog-category.view', 'blog.view', 'about-us.all', 'our-services.all', 'clients.all', 'counters.all', 'features.all', 'team.all', 'testimonial.all', 'contact-us.view', 'newsletter.view'])
                    <li class="nav-item {{ request()->routeIs('sliders.*', 'blog-categories.*', 'blogs.*', 'about-us.*', 'our-services.*', 'features.*', 'counters.*', 'testimonials.*', 'teams.*', 'clients.*', 'contact.us.data', 'newsletter.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('sliders.*', 'blog-categories.*', 'blogs.*', 'about-us.*', 'our-services.*', 'features.*', 'counters.*', 'testimonials.*', 'teams.*', 'clients.*', 'contact.us.data', 'newsletter.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-window-desktop"></i>
                            <p>
                                Website Content
                                <i class="nav-arrow bi bi-chevron-right ms-auto"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="{{ request()->routeIs('sliders.*', 'blog-categories.*', 'blogs.*', 'about-us.*', 'our-services.*', 'features.*', 'counters.*', 'testimonials.*', 'teams.*', 'clients.*', 'contact.us.data', 'newsletter.*') ? 'display: block;' : 'display: none;' }}">
                            @can('slider.view')
                                <li class="nav-item"><a href="{{ route('sliders.index') }}" class="nav-link {{ request()->routeIs('sliders.*') ? 'active' : '' }}"><i class="bi bi-images"></i><p>Sliders</p></a></li>
                            @endcan
                            @can('blog-category.view')
                                <li class="nav-item"><a href="{{ route('blog-categories.index') }}" class="nav-link {{ request()->routeIs('blog-categories.*') ? 'active' : '' }}"><i class="bi bi-tags-fill"></i><p>Blog Categories</p></a></li>
                            @endcan
                            @can('blog.view')
                                <li class="nav-item"><a href="{{ route('blogs.index') }}" class="nav-link {{ request()->routeIs('blogs.*') ? 'active' : '' }}"><i class="bi bi-file-earmark-post"></i><p>Blogs</p></a></li>
                            @endcan
                            @can('about-us.all')
                                <li class="nav-item"><a href="{{ route('about-us.index') }}" class="nav-link {{ request()->routeIs('about-us.*') ? 'active' : '' }}"><i class="bi bi-building-fill"></i><p>Who We Are</p></a></li>
                            @endcan
                            @can('our-services.all')
                                <li class="nav-item"><a href="{{ route('our-services.index') }}" class="nav-link {{ request()->routeIs('our-services.*') ? 'active' : '' }}"><i class="bi bi-briefcase-fill"></i><p>Our Services</p></a></li>
                            @endcan
                            @can('features.all')
                                <li class="nav-item"><a href="{{ route('features.index') }}" class="nav-link {{ request()->routeIs('features.*') ? 'active' : '' }}"><i class="bi bi-hand-thumbs-up-fill"></i><p>Why Choose Us</p></a></li>
                            @endcan
                            @can('team.all')
                                <li class="nav-item"><a href="{{ route('teams.index') }}" class="nav-link {{ request()->routeIs('teams.*') ? 'active' : '' }}"><i class="bi bi-person-hearts"></i><p>Team Members</p></a></li>
                            @endcan
                            @can('testimonial.all')
                                <li class="nav-item"><a href="{{ route('testimonials.index') }}" class="nav-link {{ request()->routeIs('testimonials.*') ? 'active' : '' }}"><i class="bi bi-chat-heart-fill"></i><p>Testimonials</p></a></li>
                            @endcan
                            @can('counters.all')
                                <li class="nav-item"><a href="{{ route('counters.index') }}" class="nav-link {{ request()->routeIs('counters.*') ? 'active' : '' }}"><i class="bi bi-patch-check-fill"></i><p>Success Counters</p></a></li>
                            @endcan
                            @can('clients.all')
                                <li class="nav-item"><a href="{{ route('clients.index') }}" class="nav-link {{ request()->routeIs('clients.*') ? 'active' : '' }}"><i class="bi bi-person-check-fill"></i><p>Our Clients</p></a></li>
                            @endcan
                            @can('contact-us.view')
                                <li class="nav-item"><a href="{{ route('contact.us.data') }}" class="nav-link {{ request()->routeIs('contact.us.data') ? 'active' : '' }}"><i class="bi bi-envelope-paper-fill"></i><p>Contact Inquiries</p></a></li>
                            @endcan
                            @can('newsletter.view')
                                <li class="nav-item"><a href="{{ route('newsletter.list') }}" class="nav-link {{ request()->routeIs('newsletter.list') ? 'active' : '' }}"><i class="bi bi-send-check-fill"></i><p>Newsletter Subscriptions</p></a></li>
                            @endcan
                        </ul>
                    </li>
                @endcanany


                @canany(['location.all', 'division.view', 'district.view', 'upazila.view', 'shippings.view', 'materials.all', 'materials.view', 'courier.view'])
                    <li class="nav-item {{ request()->routeIs('locations.*', 'shippings.*', 'materials.*', 'couriers.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('locations.*', 'shippings.*', 'materials.*', 'couriers.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-truck"></i>
                            <p>
                                Logistics & Config
                                <i class="nav-arrow bi bi-chevron-right ms-auto"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="{{ request()->routeIs('locations.*', 'shippings.*', 'materials.*', 'couriers.*') ? 'display: block;' : 'display: none;' }}">

                            @can('division.view')
                                <li class="nav-item"><a href="{{ route('locations.divisions') }}" class="nav-link {{ request()->routeIs('locations.divisions') ? 'active' : '' }}"><i class="bi bi-map"></i><p>Divisions</p></a></li>
                            @endcan

                            @can('district.view')
                                <li class="nav-item"><a href="{{ route('locations.districts') }}" class="nav-link {{ request()->routeIs('locations.districts') ? 'active' : '' }}"><i class="bi bi-pin-map-fill"></i><p>Districts</p></a></li>
                            @endcan

                            @can('upazila.view')
                                <li class="nav-item"><a href="{{ route('locations.upazilas') }}" class="nav-link {{ request()->routeIs('locations.upazilas') ? 'active' : '' }}"><i class="bi bi-signpost-2"></i><p>Upazilas</p></a></li>
                            @endcan

                            @can('shippings.view')
                                <li class="nav-item"><a href="{{ route('shippings.index') }}" class="nav-link {{ request()->routeIs('shippings.*') ? 'active' : '' }}"><i class="bi bi-globe2"></i><p>Shipping Zones</p></a></li>
                            @endcan

                            @can('courier.view')
                                <li class="nav-item">
                                    <a href="{{ route('couriers.index') }}" class="nav-link {{ request()->routeIs('couriers.*') ? 'active' : '' }}">
                                        <i class="bi bi-box2-heart"></i>
                                        <p>Courier List</p>
                                    </a>
                                </li>
                            @endcan

                            @can('materials.view')
                                <li class="nav-item"><a href="{{ route('materials.index') }}" class="nav-link {{ request()->routeIs('materials.*') ? 'active' : '' }}"><i class="bi bi-gem"></i><p>Quality Materials</p></a></li>
                            @endcan

                        </ul>
                    </li>
                @endcanany


                @canany(['user.all', 'user.view', 'user.create', 'role.all', 'role.view', 'role.create', 'permission.all', 'permission.view', 'setting.view'])
                    <li class="nav-item {{ request()->routeIs('users.*', 'roles.*', 'permissions.*', 'settings.*', 'backups.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('users.*', 'roles.*', 'permissions.*', 'settings.*', 'backups.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-shield-lock-fill"></i>
                            <p>
                                Administration
                                <i class="nav-arrow bi bi-chevron-right ms-auto"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="{{ request()->routeIs('users.*', 'roles.*', 'permissions.*', 'settings.*', 'backups.*') ? 'display: block;' : 'display: none;' }}">
                            @can('user.view')
                                <li class="nav-item"><a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}"><i class="bi bi-person-lines-fill"></i><p>System Users</p></a></li>
                            @endcan
                            @can('role.view')
                                <li class="nav-item"><a href="{{ route('roles.index') }}" class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}"><i class="bi bi-person-workspace"></i><p>Roles & Rights</p></a></li>
                            @endcan
                            @can('permission.view')
                                <li class="nav-item"><a href="{{ route('permissions.index') }}" class="nav-link {{ request()->routeIs('permissions.*') ? 'active' : '' }}"><i class="bi bi-key-fill"></i><p>Permissions Setup</p></a></li>
                            @endcan
                            @can('setting.view')
                                <li class="nav-item"><a href="{{ route('settings.index') }}" class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}"><i class="bi bi-gear-wide-connected"></i><p>Global Settings</p></a></li>
                            @endcan
                            <li class="nav-item">
                                <a href="{{ route('backups.index') }}" class="nav-link {{ request()->routeIs('backups.*') ? 'active' : '' }}">
                                    <i class="bi bi-database-fill-gear text-info"></i>
                                    <p>Database Backups</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcanany


                <li class="nav-item">
                    <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*', 'user-profiles.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-person-circle"></i>
                        <p>My Profile</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon bi bi-box-arrow-right"></i>
                        <p>Logout</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>

            </ul>
        </nav>
    </div>
</aside>

@push('scripts')
<script>
    (function() {
        'use strict';

        function setupAdminSidebar() {
            var $ = window.jQuery;

            // 1. Auto-expand active parent menu on page load
            document.querySelectorAll('.sidebar-wrapper .nav-treeview').forEach(function(tree) {
                if (tree.querySelector('.nav-link.active')) {
                    var parent = tree.closest('.nav-item');
                    if (parent) {
                        parent.classList.add('menu-open');
                        var parentLink = parent.querySelector(':scope > .nav-link');
                        if (parentLink) {
                            parentLink.classList.add('active');
                        }
                        tree.style.display = 'block';
                    }
                }
            });

            // 2. Prevent duplicate global event binding
            if (window._adminSidebarInitialized) return;
            window._adminSidebarInitialized = true;

            // 3. Robust Event Delegation for Parent Menu Toggles
            document.addEventListener('click', function(e) {
                var link = e.target.closest('.sidebar-wrapper .nav-item > a');
                if (!link) return;

                var parent = link.closest('.nav-item');
                if (!parent) return;

                var submenu = parent.querySelector(':scope > .nav-treeview');
                if (!submenu) {
                    // Regular menu item (e.g., Dashboard, Profile) - normal navigation
                    return;
                }

                // Prevent jumping to '#' or page reload
                e.preventDefault();
                e.stopPropagation();

                var $ = window.jQuery;
                var isOpen = parent.classList.contains('menu-open');

                // Accordion behavior: close other open menus in the same level
                var siblingOpenItems = parent.parentElement.querySelectorAll(':scope > .nav-item.menu-open');
                siblingOpenItems.forEach(function(sib) {
                    if (sib !== parent) {
                        sib.classList.remove('menu-open');
                        var sibSub = sib.querySelector(':scope > .nav-treeview');
                        if (sibSub) {
                            if ($) {
                                $(sibSub).stop(true, true).slideUp(200);
                            } else {
                                sibSub.style.display = 'none';
                            }
                        }
                    }
                });

                // Toggle target submenu
                if (isOpen) {
                    parent.classList.remove('menu-open');
                    if ($) {
                        $(submenu).stop(true, true).slideUp(200);
                    } else {
                        submenu.style.display = 'none';
                    }
                } else {
                    parent.classList.add('menu-open');
                    if ($) {
                        $(submenu).stop(true, true).slideDown(200);
                    } else {
                        submenu.style.display = 'block';
                    }
                }
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', setupAdminSidebar);
        } else {
            setupAdminSidebar();
        }
    })();
</script>
@endpush


