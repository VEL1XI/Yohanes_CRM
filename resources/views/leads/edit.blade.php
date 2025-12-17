@extends('layouts.app')

@section('title', 'Edit Lead')

@section('content')
<div class="mb-4">
    <h2>Edit Lead</h2>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('leads.update', $lead->lead_id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label">Company Name</label>
                <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name', $lead->company_name) }}" required>
                @error('company_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">PIC</label>
                <input type="text" name="pic" class="form-control @error('pic') is-invalid @enderror" value="{{ old('pic', $lead->pic) }}" required>
                @error('pic')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $lead->email) }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="3" required>{{ old('address', $lead->address) }}</textarea>
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Company Name Alias</label>
                <input type="text" name="company_name_alias" class="form-control" value="{{ old('company_name_alias', $lead->company_name_alias) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                    <option value="baru" {{ old('status', $lead->status) == 'baru' ? 'selected' : '' }}>Baru</option>
                    <option value="follow-up" {{ old('status', $lead->status) == 'follow-up' ? 'selected' : '' }}>Follow-up</option>
                    <option value="menunggu" {{ old('status', $lead->status) == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="deal" {{ old('status', $lead->status) == 'deal' ? 'selected' : '' }}>Deal</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('leads.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>