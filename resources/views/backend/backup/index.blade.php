@extends('backend.layouts.app')
@section('title', 'Database Backups')

@section('content')
<main class="app-main pt-3 pb-5">
    <div class="container-fluid px-4">

        {{-- PAGE HEADER & BREADCRUMB --}}
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h4 class="mb-1 fw-bold text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-database-fill-gear text-primary"></i> Database Backup Management
                </h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-transparent p-0" style="font-size: 13px;">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item text-muted">Administration</li>
                        <li class="breadcrumb-item active fw-semibold text-dark">Database Backups</li>
                    </ol>
                </nav>
            </div>
            <div>
                <button type="button" class="btn btn-primary shadow-sm px-3 py-2 fw-semibold" id="btnCreateBackup">
                    <i class="bi bi-cloud-arrow-down-fill me-1"></i> Create New Backup
                </button>
            </div>
        </div>

        {{-- METRIC STATS CARDS --}}
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-sm-6">
                <div class="card h-100 mb-0 shadow-sm">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="flex-shrink-0 rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 22px;">
                            <i class="bi bi-database-fill-check"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <span class="text-muted fw-bold text-uppercase d-block" style="font-size: 11px;">Total Backups</span>
                            <h4 class="mb-0 fw-bold text-dark">{{ $totalBackups }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="card h-100 mb-0 shadow-sm">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="flex-shrink-0 rounded-3 bg-info-subtle text-info d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 22px;">
                            <i class="bi bi-hdd-stack-fill"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <span class="text-muted fw-bold text-uppercase d-block" style="font-size: 11px;">Storage Used</span>
                            <h4 class="mb-0 fw-bold text-dark">{{ $totalSize }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="card h-100 mb-0 shadow-sm">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="flex-shrink-0 rounded-3 bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 22px;">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <span class="text-muted fw-bold text-uppercase d-block" style="font-size: 11px;">Latest Backup</span>
                            <h6 class="mb-0 fw-bold text-dark text-truncate" style="font-size: 13.5px;" title="{{ $latestBackup }}">{{ $latestBackup }}</h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="card h-100 mb-0 shadow-sm">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="flex-shrink-0 rounded-3 bg-warning-subtle text-warning d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 22px;">
                            <i class="bi bi-server"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <span class="text-muted fw-bold text-uppercase d-block" style="font-size: 11px;">Database Name</span>
                            <h6 class="mb-0 fw-bold text-dark font-monospace text-truncate" style="font-size: 13px;" title="{{ $dbName }}">{{ $dbName }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MAIN DATA TABLE CARD --}}
        <div class="card modern-card shadow-sm">
            <div class="modern-card-header">
                <h5 class="card-title m-0">
                    <i class="bi bi-archive-fill text-primary"></i>
                    Available Database Backups
                </h5>
                <span class="badge bg-light text-muted border px-2 py-1" style="font-size: 11px;">
                    Stored in: storage/app/backups/
                </span>
            </div>

            <div class="card-body p-0">
                @if(count($backups) > 0)
                    <div class="table-responsive p-3">
                        <table id="backupTable" class="table table-modern table-hover w-100">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="35%">Backup File</th>
                                    <th width="15%">File Size</th>
                                    <th width="20%">Created Date & Time</th>
                                    <th width="10%">Age</th>
                                    <th width="15%" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($backups as $index => $backup)
                                    <tr>
                                        <td class="text-muted fw-semibold">{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="rounded-2 bg-light border p-2 text-primary d-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
                                                    <i class="bi bi-filetype-sql fs-6"></i>
                                                </div>
                                                <div>
                                                    <span class="fw-bold font-monospace text-dark d-block" style="font-size: 13px;">{{ $backup['name'] }}</span>
                                                    <small class="text-muted" style="font-size: 11px;">SQL Database Dump</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border px-2 py-1 font-monospace">
                                                <i class="bi bi-hdd me-1 text-muted"></i>{{ $backup['size'] }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-semibold text-dark">{{ $backup['date_formatted'] }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary-subtle text-secondary border px-2 py-1">{{ $backup['age'] }}</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-inline-flex gap-1">
                                                <a href="{{ route('backups.download', $backup['name']) }}" class="btn btn-sm btn-outline-primary" title="Download SQL Dump">
                                                    <i class="bi bi-download me-1"></i> Download
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger btn-delete-backup" data-filename="{{ $backup['name'] }}" title="Delete Backup">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mb-3 text-muted">
                            <i class="bi bi-database-exclamation display-4 text-warning"></i>
                        </div>
                        <h5 class="fw-bold text-dark">No Database Backups Found</h5>
                        <p class="text-muted mb-4" style="font-size: 13.5px;">You haven't generated any database backup files yet. Creating regular backups protects your store catalog, orders, and financial data.</p>
                        <button type="button" class="btn btn-primary px-4 py-2" id="btnEmptyCreate">
                            <i class="bi bi-cloud-arrow-down-fill me-1"></i> Generate First Backup Now
                        </button>
                    </div>
                @endif
            </div>
        </div>

    </div>
</main>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTables if table exists
        if ($('#backupTable').length > 0) {
            $('#backupTable').DataTable({
                responsive: true,
                order: [[3, 'desc']],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search backups...",
                    lengthMenu: "Show _MENU_ entries"
                }
            });
        }

        // Trigger backup creation
        function triggerCreateBackup() {
            Swal.fire({
                title: 'Create Database Backup?',
                text: "A complete SQL dump of database '{{ $dbName }}' (including all tables, sales, products, and settings) will be generated.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#64748b',
                confirmButtonText: '<i class="bi bi-download me-1"></i> Start Backup',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'btn btn-primary px-4',
                    cancelButton: 'btn btn-light border px-4'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Generating Backup...',
                        html: '<div class="py-2"><div class="spinner-border text-primary mb-2" role="status"></div><p class="text-muted mb-0" style="font-size: 13px;">Extracting schema and dumping records safely. Please wait...</p></div>',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    });

                    $.ajax({
                        url: "{{ route('backups.create') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Backup Successful!',
                                text: response.message || 'Database backup created successfully!',
                                confirmButtonColor: '#2563eb',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function(xhr) {
                            let msg = 'Failed to create backup.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                msg = xhr.responseJSON.message;
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Backup Error',
                                text: msg,
                                confirmButtonColor: '#ef4444'
                            });
                        }
                    });
                }
            });
        }

        $('#btnCreateBackup, #btnEmptyCreate').on('click', function(e) {
            e.preventDefault();
            triggerCreateBackup();
        });

        // Delete backup handler
        $(document).on('click', '.btn-delete-backup', function(e) {
            e.preventDefault();
            let filename = $(this).data('filename');
            let deleteUrl = "{{ url('admin/backups/delete') }}/" + encodeURIComponent(filename);

            Swal.fire({
                title: 'Delete Backup File?',
                html: `Are you sure you want to permanently delete <code class="text-danger fw-bold">${filename}</code>? This cannot be undone.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: '<i class="bi bi-trash me-1"></i> Yes, Delete',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'btn btn-danger px-4',
                    cancelButton: 'btn btn-light border px-4'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Deleting...',
                        html: '<div class="spinner-border text-danger" role="status"></div>',
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });

                    $.ajax({
                        url: deleteUrl,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message || 'Backup file deleted successfully.',
                                confirmButtonColor: '#2563eb'
                            }).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function(xhr) {
                            let msg = 'Unable to delete backup file.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                msg = xhr.responseJSON.message;
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Delete Error',
                                text: msg,
                                confirmButtonColor: '#ef4444'
                            });
                        }
                    });
                }
            });
        });
    });
</script>
@endpush

