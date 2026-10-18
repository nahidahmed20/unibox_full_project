@extends('backend.layouts.app')
@section('title', 'Category Catalog')

@section('content')

<main class="app-main pt-3 pb-5">
    <div class="container-fluid px-4">

        {{-- PAGE HEADER & BREADCRUMB --}}
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h4 class="mb-1 fw-bold text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-diagram-3-fill text-primary"></i> Category Catalog
                </h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-transparent p-0" style="font-size: 13px;">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item active fw-semibold text-dark">Category Management</li>
                    </ol>
                </nav>
            </div>
            <div>
                <button class="btn btn-primary shadow-sm px-3 py-2 fw-semibold" id="addCategoryBtn">
                    <i class="bi bi-plus-lg me-1"></i> Add New Category
                </button>
            </div>
        </div>

        {{-- KPI STATS CARDS --}}
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-sm-6">
                <div class="card h-100">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="flex-shrink-0 rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 46px; height: 46px; font-size: 22px;">
                            <i class="bi bi-tags-fill"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <span class="text-muted fw-bold text-uppercase d-block" style="font-size: 11px;">Total Categories</span>
                            <h4 class="mb-0 fw-bold text-dark">{{ \App\Models\Category::count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="card h-100">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="flex-shrink-0 rounded-3 bg-info-subtle text-info d-flex align-items-center justify-content-center" style="width: 46px; height: 46px; font-size: 22px;">
                            <i class="bi bi-diagram-3-fill"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <span class="text-muted fw-bold text-uppercase d-block" style="font-size: 11px;">Main Categories</span>
                            <h4 class="mb-0 fw-bold text-dark">{{ \App\Models\Category::whereNull('parent_id')->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="card h-100">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="flex-shrink-0 rounded-3 bg-warning-subtle text-warning d-flex align-items-center justify-content-center" style="width: 46px; height: 46px; font-size: 22px;">
                            <i class="bi bi-diagram-2-fill"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <span class="text-muted fw-bold text-uppercase d-block" style="font-size: 11px;">Sub Categories</span>
                            <h4 class="mb-0 fw-bold text-dark">{{ \App\Models\Category::whereNotNull('parent_id')->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="card h-100">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="flex-shrink-0 rounded-3 bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 46px; height: 46px; font-size: 22px;">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <span class="text-muted fw-bold text-uppercase d-block" style="font-size: 11px;">Active Status</span>
                            <h4 class="mb-0 fw-bold text-dark">{{ \App\Models\Category::where('status', '1')->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MAIN DATA TABLE CARD --}}
        <div class="card modern-card">
            <div class="modern-card-header">
                <h5 class="card-title m-0">
                    <i class="bi bi-list-nested text-primary"></i>
                    All Categories List
                </h5>
                <span class="badge bg-light text-muted border px-2 py-1" style="font-size: 11px;">Live Catalog Data</span>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive p-3">
                    <table id="categoryTable" class="table table-modern table-hover w-100">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="20%">Category Name</th>
                                <th width="15%">Parent Category</th>
                                <th width="12%" class="text-center">Image</th>
                                <th>Description</th>
                                <th width="10%" class="text-center">Status</th>
                                <th width="15%" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</main>

{{-- ================= WIDE & MODERN CATEGORY MODAL ================= --}}
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="categoryForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="category_id" name="category_id">

                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-folder-plus text-primary"></i>
                        <span id="modalTitle">Add New Category</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        {{-- Left Column --}}
                        <div class="col-md-7">
                            <div class="mb-3">
                                <label for="parent_id" class="form-label">Parent Category</label>
                                <select class="form-select select2" id="parent_id" name="parent_id">
                                    <option value="">None (Top-Level / Main Category)</option>
                                    @foreach(App\Models\Category::all() as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-muted" style="font-size: 11px;">Leave empty to make this a primary root category.</small>
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required placeholder="e.g. Acrylic Signs & Crests">
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Category Status</label>
                                <select id="status" name="status" class="form-select">
                                    <option value="1">Active (Visible in Store)</option>
                                    <option value="0">Inactive (Hidden)</option>
                                </select>
                            </div>
                        </div>

                        {{-- Right Column: Image & Description --}}
                        <div class="col-md-5">
                            <div class="mb-3">
                                <label class="form-label">Category Thumbnail</label>
                                <div class="border rounded-3 p-3 text-center bg-light">
                                    <div class="mb-2">
                                        <img id="previewImage" src="" alt="Category Image" class="rounded-3 border shadow-sm" style="max-height: 110px; max-width: 100%; display: none; object-fit: contain;">
                                    </div>
                                    <label for="image" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1 cursor-pointer">
                                        <i class="bi bi-image me-1"></i> Choose File
                                    </label>
                                    <input type="file" class="d-none" id="image" name="image" accept="image/*">
                                    <small class="text-muted d-block mt-2" style="font-size: 10px;">Recommended: 400x400 JPG, PNG, WebP</small>
                                </div>
                            </div>

                            <div class="mb-0">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Brief description of category..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light border px-3" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary px-4 fw-bold" id="saveCategoryBtn">
                        <i class="bi bi-check2-circle me-1"></i>
                        Save Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(function() {
        // Initialize Select2 in Modal
        $('#categoryModal').on('shown.bs.modal', function () {
            $('#parent_id').select2({
                dropdownParent: $('#categoryModal'),
                width: '100%'
            });
        });

        let table = $('#categoryTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('categories.data') }}",
            lengthMenu: [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]],
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name', className: 'fw-bold text-dark' },
                { data: 'parent', name: 'parent', className: 'text-muted' },
                { data: 'image', name: 'image', orderable: false, searchable: false, className: 'text-center' },
                { data: 'description', name: 'description', className: 'text-muted', defaultContent: '<span class="text-muted fst-italic">No description</span>' },
                { data: 'status', name: 'status', orderable: false, searchable: false, className: 'text-center' },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
            ],
            dom: '<"row align-items-center mb-3"' +
                '<"col-md-4"l>' +
                '<"col-md-4 d-flex justify-content-center"B>' +
                '<"col-md-4 d-flex justify-content-end"f>' +
                '>rt' +
                '<"d-flex justify-content-between align-items-center flex-wrap gap-2 mt-4 px-1"ip>',
            buttons: [
                { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy', className: 'btn btn-sm btn-light border' },
                { extend: 'excel', text: '<i class="fa-regular fa-file-excel"></i> Excel', className: 'btn btn-sm btn-light border' },
                { extend: 'csv', text: '<i class="fa-solid fa-file-csv"></i> CSV', className: 'btn btn-sm btn-light border' },
                { extend: 'print', text: '<i class="fa-solid fa-print"></i> Print', className: 'btn btn-sm btn-light border' }
            ],
            order: [[1, 'asc']],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search categories...",
                lengthMenu: "Show _MENU_ entries",
                paginate: {
                    previous: '<i class="fa-solid fa-chevron-left"></i>',
                    next: '<i class="fa-solid fa-chevron-right"></i>'
                }
            }
        });

        $('#addCategoryBtn').on('click', function () {
            $('#categoryForm')[0].reset();
            $('#category_id').val('');
            $('#parent_id').val('').trigger('change');
            $('#status').val('1');
            $('#previewImage').attr('src', '').hide();
            $('#modalTitle').text('Add New Category');
            $('#categoryModal').modal('show');
        });

        $('#categoryForm').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            let id = $('#category_id').val();
            let saveBtn = $('#saveCategoryBtn');
            let origHtml = saveBtn.html();
            saveBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Saving...');

            let url = id === '' ? "{{ route('categories.store') }}" : "{{ url('admin/categories') }}/" + id;
            if (id !== '') {
                formData.append('_method', 'PUT');
            }

            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    saveBtn.prop('disabled', false).html(origHtml);
                    $('#categoryModal').modal('hide');
                    $('#categoryForm')[0].reset();
                    $('#parent_id').val('').trigger('change');
                    $('#previewImage').attr('src', '').hide();
                    toastr.success(response.message || 'Category saved successfully!');
                    table.ajax.reload(null, false);
                },
                error: function(xhr) {
                    saveBtn.prop('disabled', false).html(origHtml);
                    showErrors(xhr);
                }
            });
        });

        $('#image').change(function() {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#previewImage').attr('src', e.target.result).show();
            }
            if (this.files[0]) {
                reader.readAsDataURL(this.files[0]);
            }
        });

        function showErrors(xhr) {
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                let errors = '';
                $.each(xhr.responseJSON.errors, function(key, value) {
                    errors += value + '<br>';
                });
                toastr.error(errors);
            } else {
                toastr.error('Something went wrong!');
            }
        }
    });

    $(document).on('click', '.btn-edit', function () {
        let id = $(this).data('id');
        $.ajax({
            url: "{{ url('admin/categories') }}/" + id + "/edit",
            type: "GET",
            success: function (data) {
                $('#category_id').val(data.id);
                $('#name').val(data.name);
                $('#parent_id').val(data.parent_id).trigger('change');
                $('#description').val(data.description || '');
                let normalizedStatus = (data.status === '1' || data.status === 1 || data.status === 'active') ? '1' : '0';
                $('#status').val(normalizedStatus);
                if (data.image) {
                    $('#previewImage').attr('src', data.image).show();
                } else {
                    $('#previewImage').attr('src', '').hide();
                }
                $('#modalTitle').text('Edit Category: ' + data.name);
                $('#categoryModal').modal('show');
            }
        });
    });
</script>
@endpush
