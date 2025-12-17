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
                    <td><span class="badge bg-info">{{ $lead->status }}</span></td>
                    <td>{{ $lead->creator->name }}</td>
                    <td>
                        <a href="{{ route('leads.show', $lead->lead_id) }}" class="btn btn-sm btn-info">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('leads.edit', $lead->lead_id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('leads.destroy', $lead->lead_id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
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