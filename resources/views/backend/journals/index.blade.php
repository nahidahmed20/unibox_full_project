@extends('backend.layouts.app')
@section('title', 'Journal Entries')

@section('content')
<div class="app-content-wrapper pt-3">
    <div class="app-content">
        <div class="container-fluid px-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold"><i class="bi bi-journal-text me-2 text-primary"></i> Journal Entries</h3>
                <a href="{{ route('journals.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> New Journal Entry</a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Date</th>
                                    <th>Ref No</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Created By</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($journals as $journal)
                                <tr>
                                    <td class="ps-4">{{ \Carbon\Carbon::parse($journal->date)->format('d M Y') }}</td>
                                    <td class="fw-bold text-primary">{{ $journal->reference_no }}</td>
                                    <td>{{ Str::limit($journal->description, 50) }}</td>
                                    <td class="fw-bold">৳ {{ number_format($journal->total_amount, 2) }}</td>
                                    <td>{{ $journal->creator->name ?? 'System' }}</td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('journals.show', $journal->id) }}" class="btn btn-sm btn-light text-primary"><i class="bi bi-eye"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
