@extends('layouts.app')

@section('title', 'Detail Layanan')

@section('content')
<div class="mb-4">
    <h2>{{ $service->service_name }}</h2>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="mb-4">
                    <h3 class="text-primary">{{ $service->speed }} Mbps</h3>
                    <h4 class="text-success">Rp {{ number_format($service->price, 0, ',', '.') }}/bulan</h4>
                    @if($service->status == 'aktif')
                        <span class="badge bg-success">Layanan Aktif</span>
                    @else
                        <span class="badge bg-secondary">Layanan Nonaktif</span>
                    @endif
                </div>

                <h5>Deskripsi Paket</h5>
                <p>{{ $service->description }}</p>

                <hr>

                <table class="table table-borderless">
                    <tr>
                        <th width="200">Created At</th>
                        <td>{{ $service->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Last Updated</th>
                        <td>{{ $service->updated_at->format('d M Y H:i') }}</td>
                    </tr>
                </table>

                <div class="mt-4">
                    <a href="{{ route('services.index') }}" class="btn btn-secondary">Kembali</a>
                    <a href="{{ route('services.edit', $service->service_id) }}" class="btn btn-warning">Edit Harga/Status</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Fitur Paket</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li><i class="bi bi-check-circle text-success"></i> Kecepatan {{ $service->speed }} Mbps</li>
                    <li><i class="bi bi-check-circle text-success"></i> Unlimited Quota</li>
                    <li><i class="bi bi-check-circle text-success"></i> 24/7 Support</li>
                    <li><i class="bi bi-check-circle text-success"></i> Free Installation</li>
                    <li><i class="bi bi-check-circle text-success"></i> Free Router</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection