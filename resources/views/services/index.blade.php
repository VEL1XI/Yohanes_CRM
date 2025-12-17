@extends('layouts.app')

@section('title', 'Master Layanan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Master Layanan Internet</h2>
    <span class="text-muted">Paket Layanan Bawaan Sistem</span>
</div>

<div class="row">
    @foreach($services as $service)
    <div class="col-md-6 mb-4">
        <div class="card {{ $service->status == 'aktif' ? 'border-success' : 'border-secondary' }}">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-wifi"></i> {{ $service->service_name }}
                </h5>
                @if($service->status == 'aktif')
                    <span class="badge bg-success">Aktif</span>
                @else
                    <span class="badge bg-secondary">Nonaktif</span>
                @endif
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h3 class="text-primary">{{ $service->speed }} Mbps</h3>
                    <h4 class="text-success">Rp {{ number_format($service->price, 0, ',', '.') }}/bulan</h4>
                </div>
                <p class="text-muted">{{ $service->description }}</p>
                
                <div class="d-flex gap-2">
                    <a href="{{ route('services.show', $service->service_id) }}" class="btn btn-sm btn-info">
                        <i class="bi bi-eye"></i> Detail
                    </a>
                    <a href="{{ route('services.edit', $service->service_id) }}" class="btn btn-sm btn-warning">
                        <i class="bi bi-pencil"></i> Edit Harga/Status
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection