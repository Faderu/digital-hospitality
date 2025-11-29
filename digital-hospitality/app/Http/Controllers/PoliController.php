<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use Illuminate\Http\Request;

class PoliController extends Controller
{
    public function index()
    {
        $polis = Poli::all();
        return view('admin.polis.index', compact('polis'));
    }

    public function create()
    {
        return view('admin.polis.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:polis',
            'description' => 'nullable|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('icon')) {
            $validated['icon'] = $request->file('icon')->store('icons', 'public');
        }

        Poli::create($validated);
        return redirect()->route('polis.index')->with('success', 'Poli created successfully');
    }

    public function show(Poli $poli)
    {
        return view('admin.polis.show', compact('poli'));
    }

    public function edit(Poli $poli)
    {
        return view('admin.polis.edit', compact('poli'));
    }

    public function update(Request $request, Poli $poli)
    {
        $validated = $request->validate([
            'name' => 'required|unique:polis,name,' . $poli->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('icon')) {
            $validated['icon'] = $request->file('icon')->store('icons', 'public');
        }

        $poli->update($validated);
        return redirect()->route('polis.index')->with('success', 'Poli updated successfully');
    }

    public function destroy(Poli $poli)
    {
        $poli->delete();
        return redirect()->route('polis.index')->with('success', 'Poli deleted successfully');
    }
}