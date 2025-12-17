@extends('layouts.app')

@section('title', 'Tambah Lead')

@section('content')
<div class="mb-4">
    <h2>Tambah Lead Baru</h2>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('leads.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Company Name</label>
                <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name') }}" required>
                @error('company_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">PIC (Person In Charge)</label>
                <input type="text" name="pic" class="form-control @error('pic') is-invalid @enderror" value="{{ old('pic') }}" required>
                @error('pic')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="3" required>{{ old('address') }}</textarea>
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Company Name Alias (Optional)</label>
                <input type="text" name="company_name_alias" class="form-control" value="{{ old('company_name_alias') }}">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('leads.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection