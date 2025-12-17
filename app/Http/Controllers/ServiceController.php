<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest()->paginate(10);
        return view('services.index', compact('services'));
    }

    public function show(Service $service)
    {
        return view('services.show', compact('service'));
    }

    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    // Hanya bisa update status dan harga
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $service->update($validated);

        return redirect()->route('services.index')
            ->with('success', 'Layanan berhasil diupdate');
    }

    // Tidak ada create, store, dan destroy
}