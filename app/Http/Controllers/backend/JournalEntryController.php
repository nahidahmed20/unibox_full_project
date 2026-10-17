<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JournalEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
            public function index(Request $request)
    {
        $journals = \App\Models\JournalEntry::latest()->paginate(20);
        return view('backend.journals.index', compact('journals'));
    }

    public function create()
    {
        $accounts = \App\Models\Account::where('status', 1)->orderBy('name')->get();
        return view('backend.journals.create', compact('accounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'reference_no' => 'required|string|max:255',
            'description' => 'required|string',
            'account_id' => 'required|array|min:2',
            'account_id.*' => 'required|exists:accounts,id',
            'debit' => 'required|array|min:2',
            'credit' => 'required|array|min:2',
        ]);

        $totalDebit = collect($request->debit)->sum();
        $totalCredit = collect($request->credit)->sum();

        if (round($totalDebit, 2) !== round($totalCredit, 2)) {
            return back()->with('error', 'Total Debit and Total Credit must be equal!')->withInput();
        }

        \DB::transaction(function () use ($request) {
            $journal = \App\Models\JournalEntry::create([
                'date' => $request->date,
                'reference_no' => $request->reference_no,
                'description' => $request->description,
            ]);

            foreach ($request->account_id as $key => $accountId) {
                if ($request->debit[$key] > 0 || $request->credit[$key] > 0) {
                    \App\Models\JournalItem::create([
                        'journal_entry_id' => $journal->id,
                        'account_id' => $accountId,
                        'description' => $request->description,
                        'debit' => $request->debit[$key] ?? 0,
                        'credit' => $request->credit[$key] ?? 0,
                    ]);
                }
            }
        });

        return redirect()->route('journals.index')->with('success', 'Journal Entry created successfully');
    }

    public function show(string $id)
    {
        $journal = \App\Models\JournalEntry::with('items.account')->findOrFail($id);
        return view('backend.journals.show', compact('journal'));
    }

    public function edit(string $id)
    {
        // Journal entries are usually immutable, but if needed, we can implement it.
        return back()->with('error', 'Journal Entries cannot be edited once posted.');
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        // Usually should not delete, but for admin:
        $journal = \App\Models\JournalEntry::findOrFail($id);
        $journal->items()->delete();
        $journal->delete();
        return redirect()->route('journals.index')->with('success', 'Journal Entry deleted successfully');
    }
}


