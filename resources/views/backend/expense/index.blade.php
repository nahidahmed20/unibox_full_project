@extends('backend.layouts.app')
@section('title', 'Expense List')

@section('content')

    {{-- ================= HEADER ================= --}}
    <div class="app-content-header mb-4 mt-3">
        <div class="container-fluid">
            <div class="row align-items-center">

                <div class="col-sm-6">
                    <h3 class="mb-0 fw-bold" style="color:#212b36;">
                        Expenses
                    </h3>
                </div>

                <div class="col-sm-6 text-end">
                    <button class="btn btn-dark rounded-pill px-4 fw-bold shadow-sm" id="addExpenseBtn">
                        + Add Expense
                    </button>
                </div>

            </div>
        </div>
    </div>

    {{-- ================= CONTENT ================= --}}
    <div class="app-content">
        <div class="container-fluid">
            <div class="card modern-card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive p-4">
                        <table id="expenseTable" class="table table-modern table-hover w-100 align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-end">Total:</th>
                                    <th id="totalAmount"></th>
                                    <th colspan="2"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= EXPANDED EXPENSE MODAL ================= --}}
    <div class="modal fade" id="expenseModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">
                        <i class="bi bi-receipt-cutoff text-danger me-2"></i>
                        Record Expense
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="expenseForm">
                        @csrf
                        <input type="hidden" id="expense_id" name="expense_id">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Expense Title / Item <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required placeholder="e.g. Office Rent, Electricity Bill">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Expense Category <span class="text-danger">*</span></label>
                                <select class="form-select select2" id="expense_category_id" name="expense_category_id" required>
                                    <option value="">Select Category</option>
                                    @foreach ($categories ?? [] as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Amount (৳) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control" id="amount" name="amount" required placeholder="0.00">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Expense Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="date" name="date" value="{{ date('Y-m-d') }}" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Description / Note</label>
                                <textarea class="form-control" id="description" name="description" rows="2" placeholder="Optional notes..."></textarea>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light border px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary px-4 fw-bold" id="saveBtn">
                        <i class="bi bi-check2-circle me-1"></i> Save Expense
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection


@push('scripts')
    <script>
        $(document).ready(function() {

            // ================= DATATABLE =================
            let table = $('#expenseTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('expenses.index') }}",
                lengthMenu: [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'category',
                        name: 'category'
                    }, // IMPORTANT
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'date',
                        name: 'date'
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

                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search categories...",
                    paginate: {
                        previous: '<i class="fa-solid fa-angle-left"></i>',
                        next: '<i class="fa-solid fa-angle-right"></i>'
                    }
                },

                footerCallback: function() {
                    let api = this.api();

                    let total = api.column(4, {
                            page: 'current'
                        }).data()
                        .reduce((a, b) => parseFloat(a) + parseFloat(b), 0);

                    $('#totalAmount').html(total.toFixed(2));
                }
            });


            // ================= OPEN ADD =================
            $('#addExpenseBtn').click(function() {

                $('#expenseForm')[0].reset();
                $('#expense_id').val('');
                $('#modalTitle').text('Add Expense');

                $('#expenseModal').modal('show');
            });


            // ================= SAVE =================
            $('#saveBtn').click(function(e) {
                e.preventDefault();

                let id = $('#expense_id').val();

                let url = id ?
                    "{{ url('/admin/expenses') }}/" + id :
                    "{{ route('expenses.store') }}";

                let formData = new FormData($('#expenseForm')[0]);

                if (id) {
                    formData.append('_method', 'PUT');
                }

                $.ajax({
                    url: url,
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function(res) {
                        $('#expenseModal').modal('hide');
                        toastr.success(res.message ?? 'Success');
                        table.ajax.reload(null, false);
                    },

                    error:function(xhr){
                        showErrors(xhr);
                    }
                });


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


            // ================= EDIT =================
            $(document).on('click', '.btn-edit', function() {
                let id = $(this).data('id');
                $.get("{{ url('/admin/expenses') }}/" + id + "/edit", function(res) {
                    let e = res.expense;
                    $('#expense_id').val(e.id);
                    $('#name').val(e.name);
                    $('#description').val(e.description);
                    $('#amount').val(e.amount);
                    $('#date').val(e.date);
                    $('#expense_category_id').val(e.expense_category_id);

                    $('#modalTitle').text('Edit Expense');

                    $('#expenseModal').modal('show');
                });

            });

        });
    </script>
@endpush

