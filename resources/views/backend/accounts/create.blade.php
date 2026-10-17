@extends('backend.layouts.app')
@section('title', isset($account) ? 'Edit Account' : 'New Account')

@section('content')
<div class="app-content-wrapper pt-3">
    <div class="app-content">
        <div class="container-fluid px-4">
            <h3 class="fw-bold mb-4">{{ isset($account) ? 'Edit Account' : 'Add New Account' }}</h3>

            <div class="card border-0 shadow-sm rounded-4 col-lg-6">
                <div class="card-body p-4">
                    <form action="{{ isset($account) ? route('accounts.update', $account->id) : route('accounts.store') }}" method="POST">
                        @csrf
                        @if(isset($account)) @method('PUT') @endif
                        
                        <div class="mb-3">
                            <label>Account Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $account->name ?? '') }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Account Code <span class="text-danger">*</span></label>
                            <input type="text" name="code" class="form-control" value="{{ old('code', $account->code ?? '') }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Account Type <span class="text-danger">*</span></label>
                            <select name="type" class="form-select" required>
                                <option value="asset" {{ old('type', $account->type ?? '') == 'asset' ? 'selected' : '' }}>Asset (Bank, Cash, Inventory)</option>
                                <option value="liability" {{ old('type', $account->type ?? '') == 'liability' ? 'selected' : '' }}>Liability (Payables, Loans)</option>
                                <option value="equity" {{ old('type', $account->type ?? '') == 'equity' ? 'selected' : '' }}>Equity (Capital, Retained Earnings)</option>
                                <option value="revenue" {{ old('type', $account->type ?? '') == 'revenue' ? 'selected' : '' }}>Revenue (Sales, Income)</option>
                                <option value="expense" {{ old('type', $account->type ?? '') == 'expense' ? 'selected' : '' }}>Expense (Cost of Goods, Bills)</option>
                            </select>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="is_default" class="form-check-input" id="is_default" {{ old('is_default', $account->is_default ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_default">System Default (Cannot be deleted easily)</label>
                        </div>

                        <div class="mb-4 form-check">
                            <input type="checkbox" name="status" class="form-check-input" id="status" {{ old('status', $account->status ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="status">Active Account</label>
                        </div>

                        <button type="submit" class="btn btn-primary px-4">Save Account</button>
                        <a href="{{ route('accounts.index') }}" class="btn btn-light ms-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
