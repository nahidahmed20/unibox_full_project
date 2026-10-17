<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
        public function ledger(\Illuminate\Http\Request $request)
    {
        $accounts = \App\Models\Account::orderBy('type')->orderBy('name')->get();
        $ledger = collect();
        $selectedAccount = null;

        if ($request->filled('account_id')) {
            $selectedAccount = \App\Models\Account::findOrFail($request->account_id);
            $ledger = \App\Models\JournalItem::where('account_id', $request->account_id)
                ->with('journalEntry')
                ->join('journal_entries', 'journal_items.journal_entry_id', '=', 'journal_entries.id')
                ->orderBy('journal_entries.date', 'asc')
                ->orderBy('journal_items.id', 'asc')
                ->select('journal_items.*')
                ->get();
        }

        return view('backend.accounts.ledger', compact('accounts', 'ledger', 'selectedAccount'));
    }

            public function index(Request $request)
    {
        $accounts = \App\Models\Account::orderBy('type')->orderBy('code')->get();
        return view('backend.accounts.index', compact('accounts'));
    }

    public function create()
    {
        return view('backend.accounts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:accounts,code',
            'type' => 'required|in:asset,liability,equity,revenue,expense',
            'status' => 'required|boolean'
        ]);

        \App\Models\Account::create($request->all());
        return redirect()->route('accounts.index')->with('success', 'Account created successfully');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $account = \App\Models\Account::findOrFail($id);
        return view('backend.accounts.edit', compact('account'));
    }

    public function update(Request $request, string $id)
    {
        $account = \App\Models\Account::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:accounts,code,'.$id,
            'type' => 'required|in:asset,liability,equity,revenue,expense',
            'status' => 'required|boolean'
        ]);

        $account->update($request->all());
        return redirect()->route('accounts.index')->with('success', 'Account updated successfully');
    }

    public function destroy(string $id)
    {
        $account = \App\Models\Account::findOrFail($id);
        if ($account->is_default) {
            return redirect()->route('accounts.index')->with('error', 'Cannot delete default system account.');
        }
        $account->delete();
        return redirect()->route('accounts.index')->with('success', 'Account deleted successfully');
    }
}



