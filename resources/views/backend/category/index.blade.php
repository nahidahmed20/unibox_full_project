@extends('backend.layouts.app')
@section('title', 'Categories')

@section('content')
<style>
    #categoryModal .modal-content{
        border:0;
        border-radius:16px;
    }

    #categoryModal .modern-card-header{
        padding:1rem 1.25rem;
        border-bottom:1px solid #eee;
    }
</style>
    <div class="app-content-wrapper pt-3">
    <div class="container-fluid px-4">

        {{-- PAGE HEADER & BREADCRUMB --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-1 fw-bold text-dark"><i class="bi bi-diagram-3 me-2 text-primary"></i> Category Catalog</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-transparent p-0" style="font-size: 14px;">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item active fw-bold text-dark">Category List</li>
                    </ol>
                </nav>
            </div>
            <div>
                <button class="btn btn-primary shadow-sm" id="addCategoryBtn"><i class="bi bi-plus-lg me-2"></i> Add Category</button>
            </div>
        </div>

        {{-- KPI STATS CARDS --}}
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-primary-light text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-tags fs-4"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">Total Categories</h6>
                            <h4 class="mb-0 fw-bold">{{ \App\Models\Category::count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-info-light text-info rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-diagram-3 fs-4"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">Main Categories</h6>
                            <h4 class="mb-0 fw-bold">{{ \App\Models\Category::whereNull('parent_id')->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-warning-light text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-diagram-2 fs-4"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">Sub Categories</h6>
                            <h4 class="mb-0 fw-bold">{{ \App\Models\Category::whereNotNull('parent_id')->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-success-light text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-check-circle fs-4"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">Active Categories</h6>
                            <h4 class="mb-0 fw-bold">{{ \App\Models\Category::where('status', '1')->orWhere('status', 'active')->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MAIN DATA TABLE CARD --}}
        <div class="card modern-card border-0 shadow-sm rounded-4">
            <div class="modern-card-header bg-white border-bottom p-4 rounded-top-4 d-flex justify-content-between align-items-center">
                <h5 class="card-title m-0 fw-bold"><i class="bi bi-list-ul text-primary me-2"></i> All Categories</h5>
            </div>

                <div class="card-body p-0">
                    <div class="table-responsive p-4">
                        <table id="categoryTable" class="table table-modern table-hover w-100">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="20%">Category Name</th>
                                    <th width="15%">Parent Category</th>
                                    <th width="15%">Image</th>
                                    <th>Description</th>
                                    <th width="12%">Status</th>
                                    <th width="15%" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="categoryModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form id="categoryForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="category_id" name="category_id">
                    <div class="modal-content">
                        <div class="modern-card-header d-flex justify-content-between align-items-center"
                            style="background:#000032; color:#fff;">

                            <h4 class="card-title mb-0" style="color:#fff;">
                                <i class="fa-solid fa-folder-open me-2" style="color:#fff;"></i>
                                <span id="modalTitle" style="color:#fff;">Add Category</span>
                            </h4>

                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <label for="parent_id" class="form-label fw-bold">Parent Category</label>
                                <select class="form-select" id="parent_id" name="parent_id">
                                    <option value="">None (Root Category)</option>
                                    @foreach(App\Models\Category::all() as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Category Name</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description"></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Image</label>
                                <input type="file" class="form-control" id="image" name="image">

                                <img id="previewImage" src="" style="max-height:100px;display:none" class="mt-2">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select id="status" name="status" class="form-select">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Close
                            </button>

                            <button type="submit" class="btn btn-primary">
                                Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection


@push('scripts')
    <script>
        $(function() {
            let table = $('#categoryTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('categories.data') }}",
                lengthMenu: [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name',
                        className: 'fw-bold text-dark'
                    },
                    {
                        data: 'parent',
                        name: 'parent',
                        className: 'text-muted'
                    },
                    {
                        data: 'image',
                        name: 'image',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'description',
                        name: 'description',
                        className: 'text-muted'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ],

                dom: '<"row align-items-center mb-4"' +
                    '<"col-md-4"l>' +
                    '<"col-md-4 d-flex justify-content-center"B>' +
                    '<"col-md-4 d-flex justify-content-end"f>' +
                    '>rt' +
                    '<"d-flex justify-content-between align-items-center mt-4"ip>',

                buttons: [

                    {
                        extend: 'copy',
                        text: '<i class="fa-regular fa-copy"></i> Copy',
                        exportOptions: {
                            columns: ':not(:nth-child(3)):not(:nth-child(6))'
                        }
                    },

                    {
                        extend: 'excel',
                        text: '<i class="fa-regular fa-file-excel"></i> Excel',
                        exportOptions: {
                            columns: ':not(:nth-child(3)):not(:nth-child(6))'
                        }
                    },

                    {
                        extend: 'csv',
                        text: '<i class="fa-solid fa-file-csv"></i> CSV',
                        exportOptions: {
                            columns: ':not(:nth-child(3)):not(:nth-child(6))'
                        }
                    },

                    {
                        extend: 'pdf',
                        text: '<i class="fa-regular fa-file-pdf"></i> PDF',
                        exportOptions: {
                            columns: ':not(:nth-child(3)):not(:nth-child(6))'
                        }
                    },

                    {
                        extend: 'print',
                        text: '<i class="fa-solid fa-print"></i> Print',
                        exportOptions: {
                            columns: ':not(:nth-child(3)):not(:nth-child(6))'
                        }
                    }

                ],

                order: [
                    [1, 'asc']
                ],

                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search categories...",
                    lengthMenu: "Show _MENU_ entries",
                    paginate: {
                        previous: '<i class="fa-solid fa-angle-left"></i>',
                        next: '<i class="fa-solid fa-angle-right"></i>'
                    }
                }

            });

            $('#addCategoryBtn').on('click', function () {

                $('#categoryForm')[0].reset();
            $('#parent_id').val('');

                $('#modalTitle').text('Add Category');

                const modal = new bootstrap.Modal(
                    document.getElementById('categoryModal')
                );

                modal.show();

            });


            $('#categoryForm').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                let id = $('#category_id').val();
                if (id == '') {
                    storeCategory(formData);
                } else {
                    updateCategory(id, formData);
                }
            });

            function storeCategory(formData) {
                $.ajax({
                    url: "{{ route('categories.store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#categoryModal').modal('hide');
                        $('#categoryForm')[0].reset();
            $('#parent_id').val('');
                        $('#previewImage').hide();
                        toastr.success(response.message);
                        table.ajax.reload(null, false);

                    },

                    error: function(xhr) {
                        showErrors(xhr);
                    }
                });
            }

            function updateCategory(id, formData) {
                formData.append('_method', 'PUT');
                $.ajax({
                    url: "{{ url('admin/categories') }}/" + id,
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#categoryModal').modal('hide');
                        toastr.success(response.message);
                        table.ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        showErrors(xhr);
                    }
                });
            }

            $('#image').change(function() {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#previewImage').attr('src', e.target.result).show();
                }
                reader.readAsDataURL(this.files[0]);
            });


            function showErrors(xhr) {
                if (xhr.responseJSON &&
                    xhr.responseJSON.errors) {
                    let errors = '';
                    $.each(xhr.responseJSON.errors,
                        function(key, value) {
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
                    $('#parent_id').val(data.parent_id);
                    $('#description').val(data.description);
                    $('#status').val(data.status);
                    if (data.image) {
                        $('#previewImage')
                            .attr('src', data.image)
                            .show();
                    } else {
                        $('#previewImage').hide();
                    }
                    $('#modalTitle').text('Edit Category');
                    $('#categoryModal').modal('show');
                }
            });
        });
    </script>
@endpush











