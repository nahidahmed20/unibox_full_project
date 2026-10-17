@extends('backend.layouts.app')
@section('title', 'Chart of Accounts')

@section('content')
<div class="app-content-wrapper pt-3">
    <div class="app-content">
        <div class="container-fluid px-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold"><i class="bi bi-card-checklist me-2 text-primary"></i> Chart of Accounts</h3>
                <a href="{{ route('accounts.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add Account</a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted">
                                <tr>
                                    <th class="ps-4">Code</th>
                                    <th>Account Name</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($accounts as $account)
                                <tr>
                                    <td class="ps-4 fw-bold text-primary">{{ $account->code }}</td>
                                    <td class="fw-medium">
                                        {{ $account->name }}
                                        @if($account->is_default)
                                            <span class="badge bg-info ms-2" style="font-size: 10px;">System</span>
                                        @endif
                                    </td>
                                    <td><span class="badge bg-secondary">{{ ucfirst($account->type) }}</span></td>
                                    <td>
                                        @if($account->status)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('accounts.edit', $account->id) }}" class="btn btn-sm btn-light text-primary"><i class="bi bi-pencil"></i></a>
                                        <form action="{{ route('accounts.destroy', $account->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-light text-danger" onclick="return confirm('Delete this account?')"><i class="bi bi-trash"></i></button>
                                        </form>
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
