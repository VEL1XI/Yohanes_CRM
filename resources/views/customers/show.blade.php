@extends('layouts.app')

@section('title', 'Detail Customer')

@section('content')
<div class="mb-4">
    <h2>Detail Customer</h2>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header">
                <h5>Informasi Customer</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="150">Customer ID</th>
                        <td>{{ $customer->customer_id }}</td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>{{ $customer->name }}</td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td>{{ $customer->phone }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $customer->email }}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{{ $customer->address }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($customer->status == 'aktif')
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ $customer->created_at->format('d M Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Layanan Berlangganan</h5>
            </div>
            <div class="card-body">
                @if($customer->services->count() > 0)
                <div class="list-group">
                    @foreach($customer->services as $cs)
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1">{{ $cs->service->service_name }}</h6>
                                <p class="mb-1">{{ $cs->service->speed }} Mbps - Rp {{ number_format($cs->service->price, 0, ',', '.') }}/bulan</p>
                                <small class="text-muted">
                                    Mulai: {{ $cs->start_date->format('d M Y') }}
                                    @if($cs->end_date)
                                        | Berakhir: {{ $cs->end_date->format('d M Y') }}
                                    @endif
                                </small>
                            </div>
                            <div>
                                @if($cs->status == 'aktif')
                                    <span class="badge bg-success">Aktif</span>
                                @elseif($cs->status == 'suspend')
                                    <span class="badge bg-warning">Suspend</span>
                                @else
                                    <span class="badge bg-secondary">Berakhir</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-center text-muted">Tidak ada layanan aktif</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('customers.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
    <a href="{{ route('customers.edit', $customer->customer_id) }}" class="btn btn-warning">
        <i class="bi bi-pencil"></i> Edit Customer
    </a>
    <a href="{{ route('customers.manage-services', $customer->customer_id) }}" class="btn btn-primary">
        <i class="bi bi-gear"></i> Kelola Layanan
    </a>
</div>
@endsection