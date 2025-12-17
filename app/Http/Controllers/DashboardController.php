<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Customer;
use App\Models\Project;
use App\Models\Service;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'total_leads' => Lead::count(),
            'total_customers' => Customer::where('status', 'aktif')->count(),
            'total_projects' => Project::count(),
            'pending_approvals' => Project::where('status', 'pending')->count(),
            'total_services' => Service::where('status', 'aktif')->count(),
        ];

        $recent_leads = Lead::with('creator')->latest()->take(5)->get();
        $recent_projects = Project::with(['lead', 'sales'])->latest()->take(5)->get();

        return view('dashboard', compact('data', 'recent_leads', 'recent_projects'));
    }
}