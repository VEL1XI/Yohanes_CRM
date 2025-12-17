@extends('layouts.app')

@section('title', 'Leads')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Daftar Leads</h2>
    <a href="{{ route('leads.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Lead
    </a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Company Name</th>
                    <th>PIC</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Created By</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leads as $lead)
                <tr>
                    <td>{{ $loop->iteration + ($leads->currentPage() - 1) * $leads->perPage() }}</td>
                    <td>{{ $lead->company_name }}</td>
                    <td>{{ $lead->pic }}</td>
                    <td>{{ $lead->email }}</td>
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
                    <td>{{ $lead->creator->name }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="{{ route('leads.show', $lead->lead_id) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('leads.edit', $lead->lead_id) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @if($lead->status != 'deal')
                            <a href="{{ route('projects.create') }}?lead_id={{ $lead->lead_id }}" class="btn btn-sm btn-success" title="Buat Project">
                                <i class="bi bi-folder-plus"></i>
                            </a>
                            @endif
                            <form action="{{ route('leads.destroy', $lead->lead_id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3">
            {{ $leads->links() }}
        </div>
    </div>
</div>
@endsection