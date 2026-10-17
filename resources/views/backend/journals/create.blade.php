@extends('backend.layouts.app')
@section('title', 'New Journal Entry')

@section('content')
<div class="app-content-wrapper pt-3">
    <div class="app-content">
        <div class="container-fluid px-4">
            <h3 class="fw-bold mb-4">New Journal Entry</h3>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('journals.store') }}" method="POST">
                @csrf
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label>Date <span class="text-danger">*</span></label>
                                <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-9">
                                <label>Description / Reference Note</label>
                                <input type="text" name="description" class="form-control" placeholder="Brief description of this journal entry">
                            </div>
                        </div>

                        <div class="table-responsive border rounded mb-3">
                            <table class="table mb-0" id="journalTable">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width: 35%">Account <span class="text-danger">*</span></th>
                                        <th style="width: 25%">Note</th>
                                        <th style="width: 15%">Debit (৳)</th>
                                        <th style="width: 15%">Credit (৳)</th>
                                        <th style="width: 10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Row 1 -->
                                    <tr>
                                        <td>
                                            <select name="account_id[]" class="form-select" required>
                                                <option value="">-- Select Account --</option>
                                                @foreach($accounts as $acc)
                                                    <option value="{{ $acc->id }}">{{ $acc->code }} - {{ $acc->name }} ({{ ucfirst($acc->type) }})</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input type="text" name="note[]" class="form-control" placeholder="Line Note"></td>
                                        <td><input type="number" step="0.01" name="debit[]" class="form-control debit-input" value="0" min="0"></td>
                                        <td><input type="number" step="0.01" name="credit[]" class="form-control credit-input" value="0" min="0"></td>
                                        <td><button type="button" class="btn btn-sm btn-danger remove-row" disabled><i class="bi bi-x-lg"></i></button></td>
                                    </tr>
                                    <!-- Row 2 -->
                                    <tr>
                                        <td>
                                            <select name="account_id[]" class="form-select" required>
                                                <option value="">-- Select Account --</option>
                                                @foreach($accounts as $acc)
                                                    <option value="{{ $acc->id }}">{{ $acc->code }} - {{ $acc->name }} ({{ ucfirst($acc->type) }})</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input type="text" name="note[]" class="form-control" placeholder="Line Note"></td>
                                        <td><input type="number" step="0.01" name="debit[]" class="form-control debit-input" value="0" min="0"></td>
                                        <td><input type="number" step="0.01" name="credit[]" class="form-control credit-input" value="0" min="0"></td>
                                        <td><button type="button" class="btn btn-sm btn-danger remove-row" disabled><i class="bi bi-x-lg"></i></button></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr class="bg-light">
                                        <td colspan="2">
                                            <button type="button" id="addRow" class="btn btn-sm btn-success"><i class="bi bi-plus-lg"></i> Add Row</button>
                                        </td>
                                        <td class="fw-bold text-end">Total Dr: <span id="totalDebit">0.00</span></td>
                                        <td class="fw-bold text-end">Total Cr: <span id="totalCredit">0.00</span></td>
                                        <td id="balanceStatus" class="fw-bold text-danger text-center">Unbalanced</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="text-end mt-4">
                            <a href="{{ route('journals.index') }}" class="btn btn-light me-2">Cancel</a>
                            <button type="submit" id="submitBtn" class="btn btn-primary px-5" disabled>Save Journal</button>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.querySelector('#journalTable tbody');
    const btnAdd = document.getElementById('addRow');
    const totalDebitEl = document.getElementById('totalDebit');
    const totalCreditEl = document.getElementById('totalCredit');
    const balanceStatusEl = document.getElementById('balanceStatus');
    const submitBtn = document.getElementById('submitBtn');

    function calculateTotal() {
        let totalDebit = 0;
        let totalCredit = 0;

        document.querySelectorAll('.debit-input').forEach(input => {
            totalDebit += parseFloat(input.value || 0);
        });
        document.querySelectorAll('.credit-input').forEach(input => {
            totalCredit += parseFloat(input.value || 0);
        });

        totalDebitEl.innerText = totalDebit.toFixed(2);
        totalCreditEl.innerText = totalCredit.toFixed(2);

        if (totalDebit === totalCredit && totalDebit > 0) {
            balanceStatusEl.innerText = 'Balanced';
            balanceStatusEl.className = 'fw-bold text-success text-center';
            submitBtn.disabled = false;
        } else {
            balanceStatusEl.innerText = 'Unbalanced';
            balanceStatusEl.className = 'fw-bold text-danger text-center';
            submitBtn.disabled = true;
        }

        // Enable/Disable remove buttons
        const rows = tableBody.querySelectorAll('tr');
        rows.forEach(row => {
            const btn = row.querySelector('.remove-row');
            btn.disabled = rows.length <= 2;
        });
    }

    tableBody.addEventListener('input', function(e) {
        if (e.target.classList.contains('debit-input')) {
            const row = e.target.closest('tr');
            if (e.target.value > 0) {
                row.querySelector('.credit-input').value = 0;
            }
            calculateTotal();
        }
        if (e.target.classList.contains('credit-input')) {
            const row = e.target.closest('tr');
            if (e.target.value > 0) {
                row.querySelector('.debit-input').value = 0;
            }
            calculateTotal();
        }
    });

    tableBody.addEventListener('click', function(e) {
        if (e.target.closest('.remove-row')) {
            e.target.closest('tr').remove();
            calculateTotal();
        }
    });

    btnAdd.addEventListener('click', function() {
        const newRow = tableBody.querySelector('tr').cloneNode(true);
        newRow.querySelectorAll('input').forEach(input => {
            if(input.type === 'number') input.value = 0;
            else input.value = '';
        });
        newRow.querySelector('.remove-row').disabled = false;
        tableBody.appendChild(newRow);
        calculateTotal();
    });

    calculateTotal();
});
</script>
@endsection
