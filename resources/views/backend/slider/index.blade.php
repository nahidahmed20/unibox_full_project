@extends('backend.layouts.app')

@section('title', 'Slider List')

@section('content')

    <div class="app-content-header mb-4 mt-3">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0 fw-bold" style="color:#212b36;">
                        Sliders
                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end mb-0 bg-transparent p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}" class="text-muted text-decoration-none">
                                Dashboard
                            </a>
                        </li>
                        <li class="breadcrumb-item active fw-bold text-dark"> Slider List </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    {{-- CONTENT --}}
    <div class="app-content">
        <div class="container-fluid">
            <div class="card modern-card shadow-sm">
                {{-- CARD HEADER --}}
                <div class="modern-card-header d-flex align-items-center justify-content-between">
                    <h4 class="card-title mb-0">
                        <i class="fa-solid fa-images text-muted me-2"></i>
                        All Sliders
                    </h4>
                    <button class="btn btn-dark rounded-pill px-4 fw-bold shadow-sm" id="addSliderBtn">
                        <i class="fa-solid fa-plus me-1"></i>
                        Add Slider
                    </button>
                </div>
                {{-- TABLE --}}
                <div class="card-body p-0">
                    <div class="table-responsive p-4">
                        <table id="sliderTable" class="table table-modern table-hover w-100">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Image</th>
                                    <th>Mobile Image</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th width="15%" class="text-center">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- MODAL --}}
    <div class="modal fade" id="sliderModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form id="sliderForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="slider_id" name="slider_id">
                    {{-- HEADER --}}
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold d-flex align-items-center gap-2">
                            <i class="fa-solid fa-images text-primary"></i>
                            <span id="modalTitle">Add Slider</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold"> Title </label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Slider main headline">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">
                                    Short Description
                                </label>
                                <textarea class="form-control" id="short_description" name="short_description" rows="1" placeholder="Brief subtitle or tagline"></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">
                                    Link
                                </label>
                                <input type="text" class="form-control" id="link" name="link" placeholder="e.g. /shop or https://...">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold"> Status </label>
                                <select class="form-select" id="status" name="status">
                                    <option value="1">
                                        Active
                                    </option>
                                    <option value="0">
                                        Inactive
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">
                                    Image
                                </label>
                                <input type="file" class="form-control" id="image" name="image">
                                <small class="text-muted">Homepage banner. Recommended: 1600 × 800 px.</small>
                                <img id="preview_image" class="mt-3 rounded border" style="max-height:120px;display:none;">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">
                                    Mobile Image
                                </label>
                                <input type="file" class="form-control" id="mobile_image" name="mobile_image">
                                <small class="text-muted">Optional portrait artwork for phones. Recommended: 800 × 1000 px.</small>
                                <img id="preview_mobile_image" class="mt-3 rounded border"
                                    style="max-height:120px;display:none;">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm">Save Slider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let table = $('#sliderTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('sliders.index') }}",
                lengthMenu: [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]],
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'image',
                        name: 'image',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'mobile_image',
                        name: 'mobile_image',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'short_description',
                        name: 'short_description'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],

                dom: '<"row align-items-center mb-4"' +
                    '<"col-md-4"l>' +
                    '<"col-md-4 d-flex justify-content-center"B>' +
                    '<"col-md-4 d-flex justify-content-end"f>' +
                    '>rt' +
                    '<"d-flex justify-content-between align-items-center mt-4"ip>',

                buttons: [{
                        extend: 'copy',
                        text: '<i class="fa-regular fa-copy"></i> Copy'
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fa-regular fa-file-excel"></i> Excel'
                    },
                    {
                        extend: 'csv',
                        text: '<i class="fa-solid fa-file-csv"></i> CSV'
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fa-regular fa-file-pdf"></i> PDF'
                    },
                    {
                        extend: 'print',
                        text: '<i class="fa-solid fa-print"></i> Print'
                    }
                ],
                order:[[1,'asc']],

                language:{
                    search:"_INPUT_",
                    searchPlaceholder:"Search brands...",
                    lengthMenu:"Show _MENU_ entries",

                    paginate:{
                        previous:'<i class="fa-solid fa-angle-left"></i>',
                        next:'<i class="fa-solid fa-angle-right"></i>'
                    }
                }
            });

            // ADD
            $('#addSliderBtn').click(function(){
                $('#sliderForm')[0].reset();
                $('#slider_id').val('');
                $('#preview_image').hide();
                $('#preview_mobile_image').hide();
                $('#modalTitle').text('Add Slider');
                $('#sliderModal').modal('show');
            });

            // SAVE / UPDATE
            $('#sliderForm').submit(function(e){
                e.preventDefault();
                let formData = new FormData(this);
                let id = $('#slider_id').val();
                if(id){
                    formData.append('_method','PUT');
                    $.ajax({
                        url:"{{ url('/admin/sliders') }}/"+id,
                        type:"POST",
                        data:formData,
                        contentType:false,
                        processData:false,
                        success:function(data){
                            $('#sliderModal').modal('hide');
                            toastr.success(data.message);
                            table.ajax.reload(null,false);
                        },
                        error:function(xhr){
                            showAjaxErrors(xhr);
                        }
                    });
                }else{
                    $.ajax({
                        url:"{{ route('sliders.store') }}",
                        type:"POST",
                        data:formData,
                        contentType:false,
                        processData:false,
                        success:function(data){
                            $('#sliderModal').modal('hide');
                            toastr.success(data.message);
                            table.ajax.reload(null,false);
                        },
                        error:function(xhr){
                            showAjaxErrors(xhr);
                        }
                    });
                }
            });
            // IMAGE PREVIEW
            $('#image,#mobile_image').change(function() {
                let input = this;
                let preview = input.id == 'image' ?
                    '#preview_image' :
                    '#preview_mobile_image';
                if (input.files[0]) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        $(preview).attr('src', e.target.result).show();
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            });

            // EDIT SLIDER
            $(document).on('click','.btn-edit',function(){
                let id = $(this).data('id');
                $.get("{{ url('/admin/sliders') }}/"+id+"/edit", function(res){
                    $('#slider_id').val(res.id);
                    $('#title').val(res.title);
                    $('#short_description').val(res.short_description);
                    $('#link').val(res.link);
                    $('#status').val(res.status);
                    if(res.image){
                        $('#preview_image')
                        .attr('src','/'+res.image)
                        .show();
                    }else{
                        $('#preview_image').hide();
                    }
                    if(res.mobile_image){
                        $('#preview_mobile_image')
                        .attr('src','/'+res.mobile_image)
                        .show();
                    }else{
                        $('#preview_mobile_image').hide();
                    }
                    $('#modalTitle').text('Edit Slider');
                    $('#sliderModal').modal('show');
                });
            });

            function showAjaxErrors(xhr) {
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
    </script>
@endpush

