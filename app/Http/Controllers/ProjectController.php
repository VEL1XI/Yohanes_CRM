<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectDetail;
use App\Models\Lead;
use App\Models\Service;
use App\Models\Customer;
use App\Models\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function index()
    {
        $query = Project::with(['lead', 'sales', 'details']);

        if (auth()->user()->isSales()) {
            $query->where('sales_id', auth()->id());
        }

        $projects = $query->latest()->paginate(10);
        return view('projects.index', compact('projects'));
    }

    public function create(Request $request)
    {
    $leads = Lead::whereNotIn('status', ['deal'])->get();
    $services = Service::where('status', 'aktif')->get();
    
    // Ambil lead_id dari query parameter (jika ada)
    $selectedLeadId = $request->query('lead_id');
    
    return view('projects.create', compact('leads', 'services', 'selectedLeadId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lead_id' => 'required|exists:leads,lead_id',
            'notes' => 'nullable|string',
            'services' => 'required|array|min:1',
            'services.*.service_id' => 'required|exists:services,service_id',
            'services.*.qty' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $project = Project::create([
                'lead_id' => $validated['lead_id'],
                'sales_id' => auth()->id(),
                'status' => 'pending',
                'notes' => $validated['notes'],
                'created_by' => auth()->id(),
            ]);

            foreach ($validated['services'] as $serviceData) {
                $service = Service::find($serviceData['service_id']);
                $qty = $serviceData['qty'];
                $price = $service->price;
                $subtotal = $qty * $price;

                ProjectDetail::create([
                    'project_id' => $project->project_id,
                    'service_id' => $service->service_id,
                    'qty' => $qty,
                    'price' => $price,
                    'subtotal' => $subtotal,
                ]);
            }

            DB::commit();
            return redirect()->route('projects.index')->with('success', 'Project berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat project: ' . $e->getMessage());
        }
    }

    public function show(Project $project)
    {
        $project->load(['lead', 'sales', 'details.service', 'creator']);
        return view('projects.show', compact('project'));
    }

    public function approve(Project $project)
    {
        if (!auth()->user()->isManager() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        DB::beginTransaction();
        try {
            $project->update(['status' => 'approved']);
            $project->lead->update(['status' => 'deal']);

            $customer = Customer::create([
                'lead_id' => $project->lead_id,
                'name' => $project->lead->company_name,
                'phone' => $project->lead->pic,
                'email' => $project->lead->email,
                'address' => $project->lead->address,
                'status' => 'aktif',
            ]);

            foreach ($project->details as $detail) {
                CustomerService::create([
                    'customer_id' => $customer->customer_id,
                    'service_id' => $detail->service_id,
                    'start_date' => now(),
                    'status' => 'aktif',
                ]);
            }

            DB::commit();
            return back()->with('success', 'Project berhasil diapprove dan customer dibuat');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal approve project: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, Project $project)
    {
        if (!auth()->user()->isManager() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $project->update([
            'status' => 'rejected',
            'notes' => $request->notes
        ]);

        return back()->with('success', 'Project berhasil direject');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project berhasil dihapus');
    }
}