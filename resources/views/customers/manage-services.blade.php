@extends('layouts.app')

@section('title', 'Kelola Layanan Customer')

@section('content')
<div class="mb-4">
    <h2>Kelola Layanan: {{ $customer->name }}</h2>
    <p class="text-muted">Customer ID: #{{ $customer->customer_id }}</p>
</div>

<div class="row">
    <!-- Layanan Aktif -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Layanan Saat Ini</h5>
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                    <i class="bi bi-plus-circle"></i> Tambah Layanan
                </button>
            </div>
            <div class="card-body">
                @if($customer->services->where('status', 'aktif')->count() > 0)
                <div class="row">
                    @foreach($customer->services->where('status', 'aktif') as $cs)
                    <div class="col-md-6 mb-3">
                        <div class="card border-success">
                            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">{{ $cs->service->service_name }}</h6>
                                <span class="badge bg-light text-success">Aktif</span>
                            </div>
                            <div class="card-body">
                                <h4 class="text-primary">{{ $cs->service->speed }} Mbps</h4>
                                <h5 class="text-success">Rp {{ number_format($cs->service->price, 0, ',', '.') }}/bulan</h5>
                                <p class="text-muted small mb-2">Mulai: {{ $cs->start_date->format('d M Y') }}</p>
                                
                                <div class="btn-group w-100" role="group">
                                    <button class="btn btn-sm btn-warning" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#changeServiceModal{{ $cs->customer_service_id }}">
                                        <i class="bi bi-arrow-up-down"></i> Ganti
                                    </button>
                                    <form action="{{ route('customers.suspend-service', [$customer->customer_id, $cs->customer_service_id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-secondary" onclick="return confirm('Suspend layanan ini?')">
                                            <i class="bi bi-pause-circle"></i> Suspend
                                        </button>
                                    </form>
                                    <form action="{{ route('customers.terminate-service', [$customer->customer_id, $cs->customer_service_id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hentikan layanan ini?')">
                                            <i class="bi bi-x-circle"></i> Hentikan
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Ganti Layanan -->
                    <div class="modal fade" id="changeServiceModal{{ $cs->customer_service_id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('customers.change-service', [$customer->customer_id, $cs->customer_service_id]) }}" method="POST">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title">Ganti Layanan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="alert alert-info">
                                            <strong>Layanan Saat Ini:</strong><br>
                                            {{ $cs->service->service_name }} - {{ $cs->service->speed }} Mbps<br>
                                            Rp {{ number_format($cs->service->price, 0, ',', '.') }}/bulan
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Pilih Layanan Baru</label>
                                            <select name="new_service_id" class="form-select" required>
                                                <option value="">-- Pilih Layanan --</option>
                                                @foreach($availableServices->where('service_id', '!=', $cs->service_id) as $service)
                                                <option value="{{ $service->service_id }}">
                                                    {{ $service->service_name }} - {{ $service->speed }} Mbps - Rp {{ number_format($service->price, 0, ',', '.') }}
                                                    @if($service->speed > $cs->service->speed)
                                                        (⬆️ Upgrade)
                                                    @else
                                                        (⬇️ Downgrade)
                                                    @endif
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="alert alert-warning">
                                            <small>
                                                <i class="bi bi-info-circle"></i> 
                                                Layanan lama akan dinonaktifkan dan diganti dengan layanan baru.
                                            </small>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Ganti Layanan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-4">
                    <i class="bi bi-wifi-off" style="font-size: 3rem; color: #ccc;"></i>
                    <p class="text-muted mt-2">Tidak ada layanan aktif</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Layanan Suspend -->
        @if($customer->services->where('status', 'suspend')->count() > 0)
        <div class="card mt-3">
            <div class="card-header bg-warning">
                <h5 class="mb-0">Layanan Ter-suspend</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    @foreach($customer->services->where('status', 'suspend') as $cs)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">{{ $cs->service->service_name }}</h6>
                            <small class="text-muted">{{ $cs->service->speed }} Mbps - Rp {{ number_format($cs->service->price, 0, ',', '.') }}</small>
                        </div>
                        <form action="{{ route('customers.activate-service', [$customer->customer_id, $cs->customer_service_id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="bi bi-play-circle"></i> Aktifkan
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Riwayat Layanan -->
        @if($customer->services->where('status', 'berakhir')->count() > 0)
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">Riwayat Layanan</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Layanan</th>
                            <th>Kecepatan</th>
                            <th>Periode</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customer->services->where('status', 'berakhir') as $cs)
                        <tr>
                            <td>{{ $cs->service->service_name }}</td>
                            <td>{{ $cs->service->speed }} Mbps</td>
                            <td>
                                {{ $cs->start_date->format('d M Y') }} - 
                                {{ $cs->end_date ? $cs->end_date->format('d M Y') : 'Sekarang' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>

    <!-- Info Customer -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Info Customer</h5>
            </div>
            <div class="card-body">
                <p><strong>Nama:</strong><br>{{ $customer->name }}</p>
                <p><strong>Phone:</strong><br>{{ $customer->phone }}</p>
                <p><strong>Email:</strong><br>{{ $customer->email }}</p>
                <p><strong>Address:</strong><br>{{ $customer->address }}</p>
                <p><strong>Status:</strong><br>
                    @if($customer->status == 'aktif')
                        <span class="badge bg-success">Aktif</span>
                    @else
                        <span class="badge bg-secondary">Nonaktif</span>
                    @endif
                </p>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">Statistik</h5>
            </div>
            <div class="card-body">
                <p><strong>Total Layanan Aktif:</strong><br>{{ $customer->services->where('status', 'aktif')->count() }}</p>
                <p><strong>Total Biaya/Bulan:</strong><br>
                    Rp {{ number_format($customer->services->where('status', 'aktif')->sum(function($cs) { return $cs->service->price; }), 0, ',', '.') }}
                </p>
            </div>
        </div>

        <a href="{{ route('customers.show', $customer->customer_id) }}" class="btn btn-secondary w-100 mt-3">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<!-- Modal Tambah Layanan -->
<div class="modal fade" id="addServiceModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('customers.add-service', $customer->customer_id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Layanan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pilih Layanan</label>
                        <select name="service_id" class="form-select" required>
                            <option value="">-- Pilih Layanan --</option>
                            @foreach($availableServices as $service)
                            <option value="{{ $service->service_id }}">
                                {{ $service->service_name }} - {{ $service->speed }} Mbps - Rp {{ number_format($service->price, 0, ',', '.') }}/bulan
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah Layanan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection