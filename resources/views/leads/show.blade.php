@extends('layouts.app')

@section('title', 'Detail Lead')

@section('content')
<div class="mb-4">
    <h2>Detail Lead</h2>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-borderless">
            <tr>
                <th width="200">Company Name</th>
                <td>{{ $lead->company_name }}</td>
            </tr>
            <tr>
                <th>PIC</th>
                <td>{{ $lead->pic }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $lead->email }}</td>
            </tr>
            <tr>
                <th>Address</th>
                <td>{{ $lead->address }}</td>
            </tr>
            <tr>
                <th>Company Alias</th>
                <td>{{ $lead->company_name_alias ?: '-' }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    @if($lead->status == 'baru')
                        <span class="badge bg-primary">Baru</span>
                    @elseif($lead->status == 'follow-up')
                        <span class="badge bg-info">Follow-up</span>
                    @elseif($lead->status == 'menunggu')
                        <span class="badge bg-warning">Menunggu</span>
                    @else
                        <span class="badge bg-success">Deal</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Created By</th>
                <td>{{ $lead->creator->name }}</td>
            </tr>
            <tr>
                <th>Created At</th>
                <td>{{ $lead->created_at->format('d M Y H:i') }}</td>
            </tr>
        </table>

        <div class="mt-3">
            <a href="{{ route('leads.index') }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('leads.edit', $lead->lead_id) }}" class="btn btn-warning">Edit</a>
            @if($lead->status != 'deal')
            <a href="{{ route('projects.create') }}?lead_id={{ $lead->lead_id }}" class="btn btn-success">
                <i class="bi bi-folder-plus"></i> Buat Project
            </a>
            @endif
        </div>
    </div>
</div>

@if($lead->projects->count() > 0)
<div class="card mt-3">
    <div class="card-header">
        <h5>Riwayat Project</h5>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Project ID</th>
                    <th>Sales</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lead->projects as $project)
                <tr>
                    <td>#{{ $project->project_id }}</td>
                    <td>{{ $project->sales->name }}</td>
                    <td>Rp {{ number_format($project->getTotalAmount(), 0, ',', '.') }}</td>
                    <td>
                        @if($project->status == 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @elseif($project->status == 'approved')
                            <span class="badge bg-success">Approved</span>
                        @else
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('projects.show', $project->project_id) }}" class="btn btn-sm btn-info">Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection