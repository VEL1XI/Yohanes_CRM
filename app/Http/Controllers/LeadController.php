<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index()
    {
        $leads = Lead::with('creator')->latest()->paginate(10);
        return view('leads.index', compact('leads'));
    }

    public function create()
    {
        return view('leads.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'pic' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'company_name_alias' => 'nullable|string|max:255',
        ]);

        $validated['status'] = 'baru';
        $validated['created_by'] = auth()->id();

        Lead::create($validated);

        return redirect()->route('leads.index')->with('success', 'Lead berhasil ditambahkan');
    }

    public function show(Lead $lead)
    {
        $lead->load('creator', 'projects.details.service');
        return view('leads.show', compact('lead'));
    }

    public function edit(Lead $lead)
    {
        return view('leads.edit', compact('lead'));
    }

    public function update(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'pic' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'company_name_alias' => 'nullable|string|max:255',
            'status' => 'required|in:baru,follow-up,menunggu,deal',
        ]);

        $lead->update($validated);

        return redirect()->route('leads.index')->with('success', 'Lead berhasil diupdate');
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();
        return redirect()->route('leads.index')->with('success', 'Lead berhasil dihapus');
    }
}