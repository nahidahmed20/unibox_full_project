    <!-- jQuery (if not already included) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('backend/js/adminlte.js') }}"></script>
    <script>
        const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
        const Default = {
            scrollbarTheme: 'os-theme-light',
            scrollbarAutoHide: 'leave',
            scrollbarClickScroll: true,
        };
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (sidebarWrapper && OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js" crossorigin="anonymous"></script>
    <!-- sortablejs -->
    <script>
        new Sortable(document.querySelector('.connectedSortable'), {
            group: 'shared',
            handle: '.card-header',
        });

        const cardHeaders = document.querySelectorAll('.connectedSortable .card-header');
        cardHeaders.forEach((cardHeader) => {
            cardHeader.style.cursor = 'move';
        });
    </script>
    <!-- apexcharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
        integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8=" crossorigin="anonymous"></script>
    <!-- ChartJS -->
    
    <script>

        const sales_chart_options = {
            series: [{
                    name: 'Digital Goods',
                    data: [28, 48, 40, 19, 86, 27, 90],
                },
                {
                    name: 'Electronics',
                    data: [65, 59, 80, 81, 56, 55, 40],
                },
            ],
            chart: {
                height: 300,
                type: 'area',
                toolbar: {
                    show: false,
                },
            },
            legend: {
                show: false,
            },
            colors: ['#0d6efd', '#20c997'],
            dataLabels: {
                enabled: false,
            },
            stroke: {
                curve: 'smooth',
            },
            xaxis: {
                type: 'datetime',
                categories: [
                    '2023-01-01',
                    '2023-02-01',
                    '2023-03-01',
                    '2023-04-01',
                    '2023-05-01',
                    '2023-06-01',
                    '2023-07-01',
                ],
            },
            tooltip: {
                x: {
                    format: 'MMMM yyyy',
                },
            },
        };

        const sales_chart = new ApexCharts(
            document.querySelector('#revenue-chart'),
            sales_chart_options,
        );
        sales_chart.render();
    </script>
    <!-- jsvectormap -->
    <script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/js/jsvectormap.min.js"
        integrity="sha256-/t1nN2956BT869E6H4V1dnt0X5pAQHPytli+1nTZm2Y=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/maps/world.js"
        integrity="sha256-XPpPaZlU8S/HWf7FZLAncLg2SAkP8ScUTII89x9D3lY=" crossorigin="anonymous"></script>
    <!-- jsvectormap -->
    <script>
        // World map by jsVectorMap
        new jsVectorMap({
            selector: '#world-map',
            map: 'world',
        });

        // Sparkline charts
        const option_sparkline1 = {
            series: [{
                data: [1000, 1200, 920, 927, 931, 1027, 819, 930, 1021],
            }, ],
            chart: {
                type: 'area',
                height: 50,
                sparkline: {
                    enabled: true,
                },
            },
            stroke: {
                curve: 'straight',
            },
            fill: {
                opacity: 0.3,
            },
            yaxis: {
                min: 0,
            },
            colors: ['#DCE6EC'],
        };

        const sparkline1 = new ApexCharts(document.querySelector('#sparkline-1'), option_sparkline1);
        sparkline1.render();

        const option_sparkline2 = {
            series: [{
                data: [515, 519, 520, 522, 652, 810, 370, 627, 319, 630, 921],
            }, ],
            chart: {
                type: 'area',
                height: 50,
                sparkline: {
                    enabled: true,
                },
            },
            stroke: {
                curve: 'straight',
            },
            fill: {
                opacity: 0.3,
            },
            yaxis: {
                min: 0,
            },
            colors: ['#DCE6EC'],
        };

        const sparkline2 = new ApexCharts(document.querySelector('#sparkline-2'), option_sparkline2);
        sparkline2.render();

        const option_sparkline3 = {
            series: [{
                data: [15, 19, 20, 22, 33, 27, 31, 27, 19, 30, 21],
            }, ],
            chart: {
                type: 'area',
                height: 50,
                sparkline: {
                    enabled: true,
                },
            },
            stroke: {
                curve: 'straight',
            },
            fill: {
                opacity: 0.3,
            },
            yaxis: {
                min: 0,
            },
            colors: ['#DCE6EC'],
        };

        const sparkline3 = new ApexCharts(document.querySelector('#sparkline-3'), option_sparkline3);
        sparkline3.render();
    </script>
    <!-- jQuery (already included) -->
    <!-- Toastr (for compatibility) & SweetAlert2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- DataTables Core & Export Plugins -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>

    <script>
        // =========================================================
        // SWEETALERT2 MODERN TOAST SYSTEM (GLOBAL REPLACEMENT FOR TOASTR)
        // =========================================================
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
        window.Toast = Toast;

        // Bridge legacy toastr calls directly to SweetAlert2 so all pages look uniform
        window.toastr = {
            success: function(message, title) {
                Toast.fire({
                    icon: 'success',
                    title: title || message,
                    html: title ? message : undefined,
                    customClass: { popup: 'swal-toast-custom' }
                });
            },
            error: function(message, title) {
                Toast.fire({
                    icon: 'error',
                    title: title || message,
                    html: title ? message : undefined,
                    customClass: { popup: 'swal-toast-custom' }
                });
            },
            warning: function(message, title) {
                Toast.fire({
                    icon: 'warning',
                    title: title || message,
                    html: title ? message : undefined,
                    customClass: { popup: 'swal-toast-custom' }
                });
            },
            info: function(message, title) {
                Toast.fire({
                    icon: 'info',
                    title: title || message,
                    html: title ? message : undefined,
                    customClass: { popup: 'swal-toast-custom' }
                });
            }
        };

        // Automatic Flash Session Messages via SweetAlert2
        $(document).ready(function() {
            @if(session('success'))
                Toast.fire({
                    icon: 'success',
                    title: "{{ session('success') }}",
                    customClass: { popup: 'swal-toast-custom' }
                });
            @endif

            @if(session('error'))
                Toast.fire({
                    icon: 'error',
                    title: "{{ session('error') }}",
                    customClass: { popup: 'swal-toast-custom' }
                });
            @endif

            @if(session('warning'))
                Toast.fire({
                    icon: 'warning',
                    title: "{{ session('warning') }}",
                    customClass: { popup: 'swal-toast-custom' }
                });
            @endif

            @if(session('info'))
                Toast.fire({
                    icon: 'info',
                    title: "{{ session('info') }}",
                    customClass: { popup: 'swal-toast-custom' }
                });
            @endif
        });

        // =========================================================
        // GLOBAL DATATABLES DEFAULTS & EXPORT BUTTONS
        // =========================================================
        if (typeof $.fn.dataTable !== 'undefined') {
            $.extend(true, $.fn.dataTable.defaults, {
                dom: '<"row align-items-center mb-3"' +
                    '<"col-md-4 col-sm-12"l>' +
                    '<"col-md-4 col-sm-12 d-flex justify-content-center my-2 my-md-0"B>' +
                    '<"col-md-4 col-sm-12 d-flex justify-content-end"f>' +
                    '>rt' +
                    '<"d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2"ip>',
                buttons: [
                    { extend: 'copy', text: '<i class="fa-regular fa-copy me-1"></i> Copy', className: 'btn btn-sm btn-light border shadow-sm' },
                    { extend: 'excel', text: '<i class="fa-regular fa-file-excel me-1 text-success"></i> Excel', className: 'btn btn-sm btn-light border shadow-sm' },
                    { extend: 'csv', text: '<i class="fa-solid fa-file-csv me-1 text-info"></i> CSV', className: 'btn btn-sm btn-light border shadow-sm' },
                    { extend: 'pdf', text: '<i class="fa-regular fa-file-pdf me-1 text-danger"></i> PDF', className: 'btn btn-sm btn-light border shadow-sm' },
                    { extend: 'print', text: '<i class="fa-solid fa-print me-1 text-dark"></i> Print', className: 'btn btn-sm btn-light border shadow-sm' }
                ],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search records...",
                    lengthMenu: "Show _MENU_ entries",
                    paginate: {
                        previous: '<i class="fa-solid fa-chevron-left"></i>',
                        next: '<i class="fa-solid fa-chevron-right"></i>'
                    }
                }
            });
        }

        // Global Delete Confirmation Action
        $(document).ready(function(){
            $(document).on('click', '.btn-delete', function() {
                let form = $(this).closest('.delete-form');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This item will be permanently deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                    customClass: {
                        confirmButton: 'btn btn-danger px-4',
                        cancelButton: 'btn btn-light border px-4'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: form.attr('action'),
                            type: 'POST',
                            data: form.serialize(),
                            success: function(res) {
                                toastr.success(res.message || 'Item deleted successfully!');
                                let dt = form.closest('table').DataTable();
                                if (dt) {
                                    dt.ajax.reload(null, false);
                                }
                            },
                            error: function(err) {
                                toastr.error('Failed to delete item.');
                            }
                        });
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            let lastOrderCount = null;
            const audio = document.getElementById('order-sound');
            function playNotificationSound() {
                audio.play().then(() => {
                    console.log("সাউন্ড বাজছে");
                }).catch((error) => {
                    console.log("ইউজার এখনো পেজে ক্লিক করেনি, তাই সাউন্ড বাজেনি।");
                });
            }

            $(document).one('click', function() {
                audio.play().then(() => audio.pause());
            });

            function checkNewOrders() {
                $.ajax({
                    url: "{{ url('/admin/order/pending-count') }}",
                    method: 'GET',
                    success: function(response) {
                        let currentCount = response.count;
                        
                        if (lastOrderCount !== null && currentCount > lastOrderCount) {
                            playNotificationSound();
                        }
                        
                        lastOrderCount = currentCount;
                        
                        let badge = $('#pending-order-count');
                        if (currentCount > 0) {
                            badge.text(currentCount).show();
                        } else {
                            badge.hide();
                        }
                    },
                    error: function() {
                        console.log("অর্ডার চেক করতে সমস্যা হয়েছে");
                    }
                });
            }
            checkNewOrders();
            setInterval(checkNewOrders, 30000);
        });
    </script>

    <script>
        $(document).ready(function() {
            function fetchIncome(period = '', start_date = '', end_date = '') {
                $.ajax({
                    url: "{{ route('reports.total-income') }}", 
                    type: "GET",
                    data: { 
                        period: period, 
                        start_date: start_date, 
                        end_date: end_date 
                    },
                    success: function(res) {
                        $('#orderIncome').text(res.orderIncome);
                        $('#posIncome').text(res.posIncome);
                        $('#totalExpenses').text(res.totalExpenses);
                        $('#totalIncome').text(res.totalIncome);
                    },
                    error: function(err) {
                        console.error('AJAX Error:', err);

                        Swal.fire({
                            icon: 'error',
                            title: 'দুঃখিত!',
                            text: 'ডেটা লোড করতে সমস্যা হচ্ছে!',
                            confirmButtonText: 'ঠিক আছে'
                        });
                    }
                });
            }

            $('.btn-period').on('click', function() {
                console.log("Period button clicked. Value:", $(this).data('value'));
                $('.btn-period').removeClass('active');
                $(this).addClass('active');
                
                let period = $(this).data('value');
                
                $('#start_date').val('');
                $('#end_date').val('');
                
                fetchIncome(period); 
            });

            $('#dateFilterForm').on('submit', function(e) {
                e.preventDefault(); 
                
                let start = $('#start_date').val();
                let end = $('#end_date').val();

                if(!start || !end) {
                    if (!start || !end) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'সতর্কতা',
                            text: 'অনুগ্রহ করে শুরু এবং শেষের তারিখ সিলেক্ট করুন',
                            confirmButtonText: 'ঠিক আছে'
                        });

                        return;
                    }
                }

                $('.btn-period').removeClass('active');
                
                fetchIncome('', start, end);
            });

        });



    </script>

    @stack('scripts')