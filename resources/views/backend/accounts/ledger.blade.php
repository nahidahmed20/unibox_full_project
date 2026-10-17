@extends('backend.layouts.app')
@section('title', 'Ledger Report')

@section('content')
<div class="app-content-wrapper pt-3">
    <div class="app-content">
        <div class="container-fluid px-4">
            <h3 class="fw-bold mb-4"><i class="bi bi-journal-bookmark-fill me-2 text-primary"></i> General Ledger</h3>

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body">
                    <form action="{{ route('accounts.ledger') }}" method="GET" class="d-flex gap-3 align-items-end">
                        <div class="flex-grow-1">
                            <label class="form-label text-muted">Select Account</label>
                            <select name="account_id" class="form-select" required>
                                <option value="">-- Choose Account --</option>
                                @foreach($accounts as $acc)
                                    <option value="{{ $acc->id }}" {{ request('account_id') == $acc->id ? 'selected' : '' }}>
                                        {{ $acc->code }} - {{ $acc->name }} ({{ ucfirst($acc->type) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary px-4">View Ledger</button>
                    </form>
                </div>
            </div>

            @if($selectedAccount)
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white p-4 border-bottom">
                    <h5 class="mb-0 fw-bold">Ledger for: <span class="text-primary">{{ $selectedAccount->name }}</span></h5>
                    <small class="text-muted">Account Code: {{ $selectedAccount->code }} | Type: {{ ucfirst($selectedAccount->type) }}</small>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Date</th>
                                    <th>Ref No</th>
                                    <th>Description / Note</th>
                                    <th class="text-end">Debit (Dr)</th>
                                    <th class="text-end">Credit (Cr)</th>
                                    <th class="text-end pe-4">Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $balance = 0; @endphp
                                @forelse($ledger as $item)
                                    @php
                                        if(in_array($selectedAccount->type, ['asset', 'expense'])) {
                                            $balance += $item->debit - $item->credit;
                                        } else {
                                            $balance += $item->credit - $item->debit;
                                        }
                                    @endphp
                                <tr>
                                    <td class="ps-4">{{ \Carbon\Carbon::parse($item->journalEntry->date)->format('d M, Y') }}</td>
                                    <td><a href="{{ route('journals.show', $item->journalEntry->id) }}" class="text-decoration-none fw-bold">{{ $item->journalEntry->reference_no }}</a></td>
                                    <td>{{ $item->note ?? $item->journalEntry->description }}</td>
                                    <td class="text-end text-success">৳ {{ number_format($item->debit, 2) }}</td>
                                    <td class="text-end text-danger">৳ {{ number_format($item->credit, 2) }}</td>
                                    <td class="text-end pe-4 fw-bold">৳ {{ number_format($balance, 2) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">No transactions found for this account.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection
