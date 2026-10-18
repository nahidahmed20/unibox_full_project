@extends('backend.layouts.app')
@section('title', isset($account) ? 'Edit Account' : 'New Account')

@section('content')
<div class="app-content-header mb-4 mt-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h3 class="mb-0 fw-bold" style="color:#212b36;">{{ isset($account) ? 'Edit Account' : 'New Chart of Account' }}</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end mb-0 bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('accounts.index') }}" class="text-decoration-none text-muted">Accounts</a></li>
                    <li class="breadcrumb-item active fw-bold text-dark">{{ isset($account) ? 'Edit' : 'Create' }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card modern-card">
                    <div class="modern-card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">
                            <i class="fa-solid fa-calculator text-primary me-2"></i>
                            {{ isset($account) ? 'Edit Account Details' : 'Account Details' }}
                        </h4>
                        <a href="{{ route('accounts.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                            <i class="fa-solid fa-arrow-left me-1"></i> Back to List
                        </a>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ isset($account) ? route('accounts.update', $account->id) : route('accounts.store') }}" method="POST">
                            @csrf
                            @if(isset($account)) @method('PUT') @endif
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Account Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $account->name ?? '') }}" placeholder="e.g. City Bank Account, Cash in Hand" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Account Code <span class="text-danger">*</span></label>
                                <input type="text" name="code" class="form-control" value="{{ old('code', $account->code ?? '') }}" placeholder="e.g. 1001, 2001" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Account Type <span class="text-danger">*</span></label>
                                <select name="type" class="form-select" required>
                                    <option value="asset" {{ old('type', $account->type ?? '') == 'asset' ? 'selected' : '' }}>Asset (Bank, Cash, Inventory)</option>
                                    <option value="liability" {{ old('type', $account->type ?? '') == 'liability' ? 'selected' : '' }}>Liability (Payables, Loans)</option>
                                    <option value="equity" {{ old('type', $account->type ?? '') == 'equity' ? 'selected' : '' }}>Equity (Capital, Retained Earnings)</option>
                                    <option value="revenue" {{ old('type', $account->type ?? '') == 'revenue' ? 'selected' : '' }}>Revenue (Sales, Income)</option>
                                    <option value="expense" {{ old('type', $account->type ?? '') == 'expense' ? 'selected' : '' }}>Expense (Cost of Goods, Bills)</option>
                                </select>
                            </div>

                            <div class="p-3 bg-light rounded-3 mb-4 border">
                                <div class="form-check form-switch mb-2">
                                    <input type="checkbox" name="is_default" class="form-check-input" id="is_default" {{ old('is_default', $account->is_default ?? false) ? 'checked' : '' }} value="1">
                                    <label class="form-check-label fw-semibold" for="is_default">System Default Account</label>
                                    <div class="text-muted small">Marks this as a fundamental core account for automated financial journals</div>
                                </div>

                                <div class="form-check form-switch">
                                    <input type="checkbox" name="status" class="form-check-input" id="status" {{ old('status', $account->status ?? true) ? 'checked' : '' }} value="1">
                                    <label class="form-check-label fw-semibold" for="status">Active Account</label>
                                    <div class="text-muted small">Enable transactions and postings to this ledger</div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-2">
                                <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                                    <i class="fa-solid fa-check me-1"></i> {{ isset($account) ? 'Update Account' : 'Save Account' }}
                                </button>
                                <a href="{{ route('accounts.index') }}" class="btn btn-secondary rounded-pill px-4">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
