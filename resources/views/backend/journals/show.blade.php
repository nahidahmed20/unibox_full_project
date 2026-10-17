@extends('backend.layouts.app')
@section('title', 'View Journal')

@section('content')
<div class="app-content-wrapper pt-3">
    <div class="app-content">
        <div class="container-fluid px-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold"><i class="bi bi-eye me-2 text-primary"></i> Journal Entry Details</h3>
                <a href="{{ route('journals.index') }}" class="btn btn-light border"><i class="bi bi-arrow-left"></i> Back to Journals</a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <h6 class="text-muted mb-1">Reference No</h6>
                            <h5 class="fw-bold">{{ $journal->reference_no }}</h5>
                        </div>
                        <div class="col-sm-6 text-end">
                            <h6 class="text-muted mb-1">Date</h6>
                            <h5 class="fw-bold">{{ \Carbon\Carbon::parse($journal->date)->format('d F Y') }}</h5>
                        </div>
                    </div>
                    
                    @if($journal->description)
                    <div class="mb-4">
                        <h6 class="text-muted mb-1">Description</h6>
                        <p class="mb-0">{{ $journal->description }}</p>
                    </div>
                    @endif

                    <div class="table-responsive border rounded">
                        <table class="table mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Account</th>
                                    <th>Note</th>
                                    <th class="text-end">Debit (Dr)</th>
                                    <th class="text-end">Credit (Cr)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($journal->items as $item)
                                <tr>
                                    <td class="fw-medium">{{ $item->account->code }} - {{ $item->account->name }}</td>
                                    <td class="text-muted">{{ $item->note }}</td>
                                    <td class="text-end text-success">{{ $item->debit > 0 ? '৳ '.number_format($item->debit, 2) : '-' }}</td>
                                    <td class="text-end text-danger">{{ $item->credit > 0 ? '৳ '.number_format($item->credit, 2) : '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-light fw-bold">
                                <tr>
                                    <td colspan="2" class="text-end">Total:</td>
                                    <td class="text-end">৳ {{ number_format($journal->total_amount, 2) }}</td>
                                    <td class="text-end">৳ {{ number_format($journal->total_amount, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
