@extends('layouts.app')

@section('title', 'Projects')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Daftar Projects</h2>
    @if(auth()->user()->isSales() || auth()->user()->isAdmin())
    <a href="{{ route('projects.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Buat Project
    </a>
    @endif
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Lead Company</th>
                    <th>Sales</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects as $project)
                <tr>
                    <td>{{ $loop->iteration + ($projects->currentPage() - 1) * $projects->perPage() }}</td>
                    <td>{{ $project->lead->company_name }}</td>
                    <td>{{ $project->sales->name }}</td>
                    <td>Rp {{ number_format($project->getTotalAmount(), 0, ',', '.') }}</td>
                    <td>
                        @if($project->status == 'pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                        @elseif($project->status == 'approved')
                            <span class="badge bg-success">Approved</span>
                        @else
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                    </td>
                    <td>{{ $project->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('projects.show', $project->project_id) }}" class="btn btn-sm btn-info">
                            <i class="bi bi-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">
                        <div class="py-4">
                            <i class="bi bi-folder-x" style="font-size: 3rem; color: #ccc;"></i>
                            <p class="text-muted mt-2">Belum ada project</p>
                            @if(auth()->user()->isSales() || auth()->user()->isAdmin())
                            <a href="{{ route('projects.create') }}" class="btn btn-primary mt-2">
                                <i class="bi bi-plus-circle"></i> Buat Project Pertama
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($projects->count() > 0)
        <div class="mt-3">
            {{ $projects->links() }}
        </div>
        @endif
    </div>
</div>
@endsection