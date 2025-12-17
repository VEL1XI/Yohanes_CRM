@extends('layouts.app')

@section('title', 'Edit Layanan')

@section('content')
<div class="mb-4">
    <h2>Edit Layanan: {{ $service->service_name }}</h2>
</div>

<div class="card">
    <div class="card-body">
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> 
            <strong>Catatan:</strong> Anda hanya bisa mengubah harga dan status. Nama layanan dan kecepatan tidak dapat diubah karena merupakan paket bawaan sistem.
        </div>

        <form action="{{ route('services.update', $service->service_id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label">Nama Layanan</label>
                <input type="text" class="form-control" value="{{ $service->service_name }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Kecepatan</label>
                <input type="text" class="form-control" value="{{ $service->speed }} Mbps" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Harga (Rp/bulan)</label>
                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $service->price) }}" required>
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Harga saat ini: Rp {{ number_format($service->price, 0, ',', '.') }}</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-control" rows="4" readonly>{{ $service->description }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Status Layanan</label>
                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                    <option value="aktif" {{ old('status', $service->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ old('status', $service->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Layanan nonaktif tidak akan muncul saat membuat project</small>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('services.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection