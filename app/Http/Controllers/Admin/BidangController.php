<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use Illuminate\Http\Request;

class BidangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bidangs = Bidang::paginate(10);
        return view('admin.bidangs.index', compact('bidangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.bidangs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:10|unique:bidangs',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        Bidang::create($validated);

        return redirect()->route('admin.bidangs.index')
            ->with('success', 'Seksi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bidang $bidang)
    {
        return view('admin.bidangs.show', compact('bidang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bidang $bidang)
    {
        return view('admin.bidangs.edit', compact('bidang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bidang $bidang)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:10|unique:bidangs,kode,' . $bidang->id,
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $bidang->update($validated);

        return redirect()->route('admin.bidangs.index')
            ->with('success', 'Seksi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bidang $bidang)
    {
        $bidang->delete();

        return redirect()->route('admin.bidangs.index')
            ->with('success', 'Seksi berhasil dihapus.');
    }
}
