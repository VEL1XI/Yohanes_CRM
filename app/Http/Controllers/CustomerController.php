<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerService;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::with('services.service')->latest()->paginate(10);
        return view('customers.index', compact('customers'));
    }

    public function show(Customer $customer)
    {
        $customer->load(['lead', 'services.service']);
        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $customer->update($validated);

        return redirect()->route('customers.index')
            ->with('success', 'Customer berhasil diupdate');
    }

    // Method baru untuk manage services
    public function manageServices(Customer $customer)
    {
        $customer->load('services.service');
        $availableServices = Service::where('status', 'aktif')->get();
        
        return view('customers.manage-services', compact('customer', 'availableServices'));
    }

    // Method untuk add service
    public function addService(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,service_id',
        ]);

        // Cek apakah service sudah ada
        $existingService = CustomerService::where('customer_id', $customer->customer_id)
            ->where('service_id', $validated['service_id'])
            ->where('status', 'aktif')
            ->first();

        if ($existingService) {
            return back()->with('error', 'Layanan ini sudah aktif untuk customer');
        }

        CustomerService::create([
            'customer_id' => $customer->customer_id,
            'service_id' => $validated['service_id'],
            'start_date' => now(),
            'status' => 'aktif',
        ]);

        return back()->with('success', 'Layanan berhasil ditambahkan');
    }

    // Method untuk upgrade/downgrade service
    public function changeService(Request $request, Customer $customer, CustomerService $customerService)
    {
        $validated = $request->validate([
            'new_service_id' => 'required|exists:services,service_id',
        ]);

        DB::beginTransaction();
        try {
            // Nonaktifkan layanan lama
            $customerService->update([
                'status' => 'berakhir',
                'end_date' => now(),
            ]);

            // Tambah layanan baru
            CustomerService::create([
                'customer_id' => $customer->customer_id,
                'service_id' => $validated['new_service_id'],
                'start_date' => now(),
                'status' => 'aktif',
            ]);

            DB::commit();
            return back()->with('success', 'Layanan berhasil diganti');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengganti layanan: ' . $e->getMessage());
        }
    }

    // Method untuk suspend service
    public function suspendService(Customer $customer, CustomerService $customerService)
    {
        $customerService->update(['status' => 'suspend']);
        return back()->with('success', 'Layanan berhasil di-suspend');
    }

    // Method untuk activate service
    public function activateService(Customer $customer, CustomerService $customerService)
    {
        $customerService->update(['status' => 'aktif']);
        return back()->with('success', 'Layanan berhasil diaktifkan');
    }

    // Method untuk terminate service
    public function terminateService(Customer $customer, CustomerService $customerService)
    {
        $customerService->update([
            'status' => 'berakhir',
            'end_date' => now(),
        ]);
        return back()->with('success', 'Layanan berhasil dihentikan');
    }
}