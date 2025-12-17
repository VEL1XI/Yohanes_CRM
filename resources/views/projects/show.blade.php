@extends('layouts.app')

@section('title', 'Detail Project')

@section('content')
<div class="mb-4">
    <h2>Detail Project</h2>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header">
                <h5>Informasi Project</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="200">Project ID</th>
                        <td>{{ $project->project_id }}</td>
                    </tr>
                    <tr>
                        <th>Lead Company</th>
                        <td>{{ $project->lead->company_name }}</td>
                    </tr>
                    <tr>
                        <th>PIC</th>
                        <td>{{ $project->lead->pic }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $project->lead->email }}</td>
                    </tr>
                    <tr>
                        <th>Sales</th>
                        <td>{{ $project->sales->name }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($project->status == 'pending')
                                <span class="badge bg-warning text-dark">Pending Approval</span>
                            @elseif($project->status == 'approved')
                                <span class="badge bg-success">Approved</span>
                            @else
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Notes</th>
                        <td>{{ $project->notes ?: '-' }}</td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ $project->created_at->format('d M Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Detail Layanan</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Layanan</th>
                            <th>Kecepatan</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($project->details as $detail)
                        <tr>
                            <td>{{ $detail->service->service_name }}</td>
                            <td>{{ $detail->service->speed }} Mbps</td>
                            <td>{{ $detail->qty }}</td>
                            <td>Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-end">Total:</th>
                            <th>Rp {{ number_format($project->getTotalAmount(), 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        @if($project->status == 'pending' && (auth()->user()->isManager() || auth()->user()->isAdmin()))
        <div class="card mb-3">
            <div class="card-header bg-warning">
                <h5 class="mb-0">Approval Manager</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('projects.approve', $project->project_id) }}" method="POST" class="mb-2">
                    @csrf
                    <button type="submit" class="btn btn-success w-100" onclick="return confirm('Approve project ini?')">
                        <i class="bi bi-check-circle"></i> Approve Project
                    </button>
                </form>

                <button class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#rejectModal">
                    <i class="bi bi-x-circle"></i> Reject Project
                </button>
            </div>
        </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h5>Actions</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('projects.index') }}" class="btn btn-secondary w-100">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('projects.reject', $project->project_id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Reject Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Alasan Rejection</label>
                        <textarea name="notes" class="form-control" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Reject Project</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection