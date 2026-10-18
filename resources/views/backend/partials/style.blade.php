    <!--begin::Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Noto+Sans+Bengali:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" crossorigin="anonymous" media="print" onload="this.media='all'" />
    <!--end::Fonts-->

    <!--begin::Third Party Plugin (OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css" crossorigin="anonymous" />
    <!--begin::Icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <!--begin::Required Plugin (AdminLTE, includes Bootstrap 5)-->
    <link rel="stylesheet" href="{{ asset('backend/css/adminlte.css') }}" />

    <!--begin::Plugins-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" />
    <!--end::Plugins-->

    {{-- =========================================================
       UNIBOX LUXURY ADMIN DESIGN SYSTEM & GLOBAL OVERRIDES
       ========================================================= --}}
    <style>
        :root {
            --ub-primary: #2563eb;
            --ub-primary-hover: #1d4ed8;
            --ub-primary-light: #eff6ff;
            --ub-dark: #0f172a;
            --ub-dark-hover: #1e293b;
            --ub-muted: #64748b;
            --ub-border: #e2e8f0;
            --ub-bg: #f8fafc;
            --ub-card: #ffffff;
            --ub-success: #10b981;
            --ub-warning: #f59e0b;
            --ub-danger: #ef4444;
        }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif !important;
            background-color: var(--ub-bg) !important;
            color: #0f172a;
        }

        .app-content {
            background-color: var(--ub-bg);
            padding-bottom: 50px;
        }

        /* ================= PROPORTIONAL & LUXURY MODALS ================= */
        .modal-backdrop.show {
            backdrop-filter: blur(8px) !important;
            -webkit-backdrop-filter: blur(8px) !important;
            background-color: rgba(15, 23, 42, 0.5) !important;
        }

        .modal.fade .modal-dialog {
            transform: scale(0.96) translateY(-10px);
            transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.25s ease !important;
        }

        .modal.show .modal-dialog {
            transform: scale(1) translateY(0);
        }

        /* Default standard modals (1-2 fields like Brand, Color, Size, Unit, Spec): Compact, snug & elegant */
        @media (min-width: 576px) {
            .modal-dialog {
                max-width: 520px;
                margin: 2rem auto;
            }
            .modal-dialog.modal-sm {
                max-width: 380px;
            }
        }

        /* Large modals (Category with images, Blog editor, Coupons, Customer profile): Wide & spacious */
        @media (min-width: 768px) {
            .modal-dialog.modal-lg,
            .modal-dialog.modal-dialog-lg {
                max-width: 840px !important;
            }
        }

        /* Extra large modals (Multi-product tables, POS select, order dispatch, comprehensive reporting) */
        @media (min-width: 992px) {
            .modal-dialog.modal-xl,
            .modal-dialog.modal-dialog-xl {
                max-width: 1140px !important;
            }
        }

        .modal-content {
            border: 1px solid rgba(226, 232, 240, 0.8) !important;
            border-radius: 16px !important;
            box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.25), 0 0 0 1px rgba(0, 0, 0, 0.03) !important;
            overflow: hidden;
            background: #ffffff;
        }

        .modal-header,
        .modal-header-modern {
            background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%) !important;
            border-bottom: 1px solid #f1f5f9 !important;
            padding: 18px 24px !important;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-title,
        .modal-title-modern {
            font-size: 16px !important;
            font-weight: 700 !important;
            color: #0f172a !important;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin: 0;
            line-height: 1.3;
        }

        .modal-title i,
        .modal-title-modern i {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: rgba(37, 99, 235, 0.08) !important;
            color: #2563eb !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            flex-shrink: 0;
        }

        .modal-header .btn-close {
            width: 30px;
            height: 30px;
            padding: 0;
            border-radius: 50%;
            background-color: #f1f5f9;
            background-size: 9px;
            opacity: 0.65;
            transition: all 0.2s ease;
            margin: 0;
            box-shadow: none !important;
        }

        .modal-header .btn-close:hover {
            background-color: #e2e8f0;
            opacity: 1;
            transform: rotate(90deg);
        }

        .modal-body {
            padding: 24px !important;
            background: #ffffff !important;
        }

        .modal-dialog-scrollable .modal-body {
            overflow-x: hidden;
        }

        .modal-footer {
            background: #f8fafc !important;
            border-top: 1px solid #f1f5f9 !important;
            padding: 14px 24px !important;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            border-bottom-left-radius: 16px;
            border-bottom-right-radius: 16px;
        }

        .modal-footer .btn-secondary,
        .modal-footer .btn-light,
        .modal-footer button[data-bs-dismiss="modal"] {
            background: #ffffff !important;
            border: 1px solid #cbd5e1 !important;
            color: #475569 !important;
            font-weight: 600 !important;
            font-size: 13px !important;
            padding: 8px 18px !important;
            border-radius: 9px !important;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04) !important;
            transition: all 0.2s ease !important;
        }

        .modal-footer .btn-secondary:hover,
        .modal-footer .btn-light:hover,
        .modal-footer button[data-bs-dismiss="modal"]:hover {
            background: #f1f5f9 !important;
            border-color: #94a3b8 !important;
            color: #0f172a !important;
            transform: translateY(-1px);
        }

        .modal-footer .btn-primary,
        .modal-footer button[type="submit"] {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important;
            border: 1px solid #1d4ed8 !important;
            color: #ffffff !important;
            font-weight: 600 !important;
            font-size: 13px !important;
            padding: 8px 22px !important;
            border-radius: 9px !important;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.22) !important;
            transition: all 0.2s ease !important;
        }

        .modal-footer .btn-primary:hover,
        .modal-footer button[type="submit"]:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%) !important;
            box-shadow: 0 6px 14px rgba(37, 99, 235, 0.32) !important;
            transform: translateY(-1px);
        }

        /* ================= MODERN CARDS & PANELS ================= */
        .card,
        .modern-card,
        .shopify-card {
            border: 1px solid var(--ub-border) !important;
            border-radius: 14px !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03) !important;
            background: #ffffff !important;
            margin-bottom: 24px;
        }

        .card > .card-header,
        .modern-card-header {
            background: #ffffff !important;
            border-bottom: 1px solid var(--ub-border) !important;
            padding: 16px 24px !important;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 700;
            color: var(--ub-dark);
            border-top-left-radius: 14px !important;
            border-top-right-radius: 14px !important;
        }

        .card-title,
        .modern-card-header h4,
        .modern-card-header h5 {
            font-size: 16px !important;
            font-weight: 700 !important;
            color: var(--ub-dark) !important;
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
        }

        .card-body {
            padding: 24px !important;
        }

        /* ================= INPUTS & CONTROLS FOR CREATE / EDIT ================= */
        .form-label, label {
            font-size: 12.5px !important;
            font-weight: 700 !important;
            color: #334155 !important;
            margin-bottom: 6px !important;
            display: inline-block;
            letter-spacing: 0.2px;
        }

        .form-control,
        .form-select {
            border-radius: 10px !important;
            border: 1px solid #cbd5e1 !important;
            padding: 9px 14px !important;
            font-size: 13.5px !important;
            font-weight: 500 !important;
            color: var(--ub-dark) !important;
            background-color: #ffffff !important;
            min-height: 42px;
            transition: all 0.15s ease-in-out;
        }

        .form-control:focus,
        .form-select:focus {
            background-color: #ffffff !important;
            border-color: var(--ub-primary) !important;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1) !important;
            outline: none;
        }

        .form-control::placeholder {
            color: #94a3b8;
            font-weight: 400;
        }

        textarea.form-control {
            min-height: auto;
        }

        /* Select2 Inputs Styling */
        .select2-container--default .select2-selection--single {
            height: 42px !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 10px !important;
            display: flex !important;
            align-items: center !important;
            padding: 0 8px !important;
            background: #ffffff !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 40px !important;
            font-size: 13.5px !important;
            font-weight: 500 !important;
            color: var(--ub-dark) !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px !important;
            right: 8px !important;
        }

        .select2-dropdown {
            border-radius: 10px !important;
            border: 1px solid #cbd5e1 !important;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08) !important;
            font-size: 13.5px !important;
            overflow: hidden;
        }

        .select2-container {
            width: 100% !important;
        }

        /* ================= TABLES & DATATABLES ================= */
        .table-modern,
        .table {
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-modern thead th,
        .table thead th {
            background-color: #f8fafc !important;
            color: var(--ub-muted) !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
            font-size: 11.5px !important;
            letter-spacing: 0.5px !important;
            padding: 12px 16px !important;
            border-bottom: 1px solid var(--ub-border) !important;
        }

        .table-modern tbody td,
        .table tbody td {
            padding: 14px 16px !important;
            vertical-align: middle !important;
            color: var(--ub-dark) !important;
            font-size: 13.5px !important;
            border-bottom: 1px solid #f1f5f9 !important;
        }

        .table-modern tbody tr:hover td,
        .table tbody tr:hover td {
            background-color: #f8fafc !important;
        }

        /* DataTables Controls */
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #cbd5e1 !important;
            border-radius: 8px !important;
            padding: 6px 14px !important;
            font-size: 13px !important;
            outline: none;
            transition: all 0.2s ease;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: var(--ub-primary) !important;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1) !important;
        }

        .dataTables_wrapper .dataTables_length select {
            border-radius: 8px !important;
            padding: 6px 12px !important;
            border: 1px solid #cbd5e1 !important;
            font-size: 13px !important;
        }

        /* ================= DATATABLES PAGINATION & INFO POLISH ================= */
        .dataTables_wrapper .dataTables_info {
            font-size: 13px !important;
            font-weight: 500 !important;
            color: #64748b !important;
            padding: 8px 0 !important;
            margin: 0 !important;
        }

        .dataTables_wrapper .dataTables_paginate {
            margin: 0 !important;
            padding: 0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: flex-end !important;
        }

        /* Reset Bootstrap 5 / DataTables <ul> container */
        .dataTables_wrapper .dataTables_paginate ul.pagination {
            display: inline-flex !important;
            align-items: center !important;
            gap: 5px !important;
            margin: 0 !important;
            padding: 0 !important;
            list-style: none !important;
        }

        /* Crucial: neutralize the <li> wrapper so it does NOT create a box-in-box */
        .dataTables_wrapper .dataTables_paginate ul.pagination > li,
        .dataTables_wrapper .dataTables_paginate ul.pagination > li.paginate_button,
        .dataTables_wrapper .dataTables_paginate ul.pagination > li.page-item {
            border: none !important;
            background: transparent !important;
            padding: 0 !important;
            margin: 0 !important;
            min-width: auto !important;
            height: auto !important;
            display: inline-flex !important;
            align-items: center !important;
            box-shadow: none !important;
        }

        /* Style the actual clickable button / link: .page-link OR non-bootstrap a.paginate_button */
        .dataTables_wrapper .dataTables_paginate .pagination .page-link,
        .dataTables_wrapper .dataTables_paginate > a.paginate_button,
        .dataTables_wrapper .dataTables_paginate > span > a.paginate_button {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-width: 36px !important;
            height: 36px !important;
            padding: 0 12px !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            color: #475569 !important;
            background-color: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 8px !important;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04) !important;
            text-decoration: none !important;
            cursor: pointer !important;
            transition: all 0.2s ease-in-out !important;
            outline: none !important;
            line-height: 1 !important;
            margin: 0 !important;
        }

        /* Hover state */
        .dataTables_wrapper .dataTables_paginate .pagination .page-link:hover,
        .dataTables_wrapper .dataTables_paginate > a.paginate_button:hover:not(.disabled):not(.current),
        .dataTables_wrapper .dataTables_paginate > span > a.paginate_button:hover:not(.disabled):not(.current) {
            background-color: #f1f5f9 !important;
            border-color: #cbd5e1 !important;
            color: #0f172a !important;
            transform: translateY(-1px);
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.06) !important;
        }

        /* Active / Current state */
        .dataTables_wrapper .dataTables_paginate .pagination .page-item.active .page-link,
        .dataTables_wrapper .dataTables_paginate .pagination .page-link.active,
        .dataTables_wrapper .dataTables_paginate > a.paginate_button.current,
        .dataTables_wrapper .dataTables_paginate > span > a.paginate_button.current {
            background-color: var(--ub-primary, #2563eb) !important;
            border-color: var(--ub-primary, #2563eb) !important;
            color: #ffffff !important;
            font-weight: 700 !important;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3) !important;
            cursor: default !important;
            transform: none !important;
        }

        /* Disabled state */
        .dataTables_wrapper .dataTables_paginate .pagination .page-item.disabled .page-link,
        .dataTables_wrapper .dataTables_paginate .pagination .page-link.disabled,
        .dataTables_wrapper .dataTables_paginate > a.paginate_button.disabled,
        .dataTables_wrapper .dataTables_paginate > a.paginate_button.disabled:hover {
            background-color: #f8fafc !important;
            border-color: #f1f5f9 !important;
            color: #94a3b8 !important;
            cursor: not-allowed !important;
            opacity: 0.6 !important;
            box-shadow: none !important;
            transform: none !important;
        }

        /* Previous and Next buttons padding polish */
        .dataTables_wrapper .dataTables_paginate .page-item:first-child .page-link,
        .dataTables_wrapper .dataTables_paginate .page-item:last-child .page-link,
        .dataTables_wrapper .dataTables_paginate > a.paginate_button.previous,
        .dataTables_wrapper .dataTables_paginate > a.paginate_button.next {
            padding: 0 14px !important;
            font-weight: 600 !important;
        }

        /* ================= BUTTONS & BADGES ================= */
        .btn {
            border-radius: 10px !important;
            font-weight: 600 !important;
            font-size: 13.5px !important;
            padding: 8px 18px !important;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .btn-sm {
            padding: 5px 12px !important;
            font-size: 12px !important;
            border-radius: 8px !important;
        }

        .btn-primary {
            background-color: var(--ub-primary) !important;
            border-color: var(--ub-primary) !important;
            color: #ffffff !important;
        }

        .btn-primary:hover {
            background-color: var(--ub-primary-hover) !important;
            border-color: var(--ub-primary-hover) !important;
            transform: translateY(-1px);
        }

        .btn-dark {
            background-color: var(--ub-dark) !important;
            border-color: var(--ub-dark) !important;
            color: #ffffff !important;
        }

        .btn-dark:hover {
            background-color: var(--ub-dark-hover) !important;
            border-color: var(--ub-dark-hover) !important;
            transform: translateY(-1px);
        }

        .badge {
            font-weight: 700 !important;
            border-radius: 6px !important;
            padding: 4px 8px !important;
            font-size: 11px !important;
        }

        /* Taka Font Support */
        .taka-font, .taka-symbol {
            font-family: 'Noto Sans Bengali', 'Plus Jakarta Sans', sans-serif !important;
            font-weight: 700;
        }

        /* Slim Custom Scrollbars */
        ::-webkit-scrollbar { width: 7px; height: 7px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* ================= UNIVERSAL DATATABLES EXPORT BUTTONS ================= */
        .dt-buttons {
            display: inline-flex !important;
            gap: 6px !important;
            flex-wrap: wrap;
            align-items: center;
        }

        .dt-buttons .btn,
        .dt-button,
        button.dt-button {
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            color: #475569 !important;
            font-size: 12.5px !important;
            font-weight: 600 !important;
            padding: 6px 14px !important;
            border-radius: 8px !important;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04) !important;
            transition: all 0.2s ease !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            margin: 0 !important;
            text-decoration: none !important;
        }

        .dt-buttons .btn:hover,
        .dt-button:hover,
        button.dt-button:hover {
            background: #f8fafc !important;
            border-color: #cbd5e1 !important;
            color: #0f172a !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.06) !important;
        }

        /* Auto-inject icons for buttons initialized with text strings */
        .buttons-copy:not(:has(i))::before { content: "\f0c5"; font-family: "Font Awesome 6 Free"; font-weight: 400; margin-right: 5px; }
        .buttons-excel:not(:has(i))::before { content: "\f1c3"; font-family: "Font Awesome 6 Free"; font-weight: 400; color: #10b981; margin-right: 5px; }
        .buttons-csv:not(:has(i))::before { content: "\f6dd"; font-family: "Font Awesome 6 Free"; font-weight: 900; color: #0284c7; margin-right: 5px; }
        .buttons-pdf:not(:has(i))::before { content: "\f1c1"; font-family: "Font Awesome 6 Free"; font-weight: 400; color: #ef4444; margin-right: 5px; }
        .buttons-print:not(:has(i))::before { content: "\f02f"; font-family: "Font Awesome 6 Free"; font-weight: 900; color: #334155; margin-right: 5px; }

        /* ================= SWEETALERT2 LUXURY POLISH ================= */
        .swal2-popup {
            border-radius: 18px !important;
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif !important;
            padding: 24px !important;
            border: 1px solid #e2e8f0 !important;
            box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.25) !important;
        }

        .swal2-popup.swal-toast-custom {
            box-shadow: 0 15px 35px rgba(15, 23, 42, 0.12), 0 3px 10px rgba(0, 0, 0, 0.04) !important;
            border-radius: 14px !important;
            border: 1px solid #e2e8f0 !important;
            padding: 12px 18px !important;
            background: #ffffff !important;
        }

        .swal2-popup.swal-toast-custom .swal2-title {
            font-size: 13.5px !important;
            font-weight: 600 !important;
            color: #0f172a !important;
            margin: 0 !important;
        }

        .swal2-popup.swal-toast-custom .swal2-icon {
            width: 24px !important;
            height: 24px !important;
            margin: 0 10px 0 0 !important;
        }

        .swal2-popup.swal-toast-custom .swal2-timer-progress-bar {
            background: #3b82f6 !important;
            height: 3px !important;
        }

        .swal2-actions .btn {
            border-radius: 10px !important;
            padding: 8px 20px !important;
            font-weight: 600 !important;
            font-size: 13.5px !important;
        }
    </style>
    @stack('styles')