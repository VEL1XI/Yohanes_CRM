@extends('layouts.app')

@section('title', 'Tambah Layanan')

@section('content')
<div class="mb-4">
    <h2>Tambah Layanan Baru</h2>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('services.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Layanan</label>
                <input type="text" name="service_name" class="form-control @error('service_name') is-invalid @enderror" value="{{ old('service_name') }}" required>
                @error('service_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Kecepatan (Mbps)</label>
                <input type="number" name="speed" class="form-control @error('speed') is-invalid @enderror" value="{{ old('speed') }}" required>
                @error('speed')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Harga</label>
                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" required>
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('services.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection