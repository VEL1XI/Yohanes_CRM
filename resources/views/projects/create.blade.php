@extends('layouts.app')

@section('title', 'Buat Project')

@section('content')
<div class="mb-4">
    <h2>Buat Project Baru</h2>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('projects.store') }}" method="POST" id="projectForm">
            @csrf
            <div class="mb-3">
                <label class="form-label">Pilih Lead</label>
                <select name="lead_id" class="form-select @error('lead_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Lead --</option>
                    @foreach($leads as $lead)
                    <option value="{{ $lead->lead_id }}" {{ old('lead_id') == $lead->lead_id ? 'selected' : '' }}>
                        {{ $lead->company_name }} - {{ $lead->pic }}
                    </option>
                    @endforeach
                </select>
                @error('lead_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Notes</label>
                <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
            </div>

            <hr>

            <h5 class="mb-3">Layanan yang Ditawarkan</h5>
            <div id="serviceContainer">
                <div class="service-row mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Layanan</label>
                            <select name="services[0][service_id]" class="form-select service-select" required>
                                <option value="">-- Pilih Layanan --</option>
                                @foreach($services as $service)
                                <option value="{{ $service->service_id }}" data-price="{{ $service->price }}">
                                    {{ $service->service_name }} - {{ $service->speed }} Mbps - Rp {{ number_format($service->price, 0, ',', '.') }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" name="services[0][qty]" class="form-control qty-input" value="1" min="1" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Action</label>
                            <button type="button" class="btn btn-danger w-100 remove-service" style="display:none;">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-secondary mb-3" id="addService">
                <i class="bi bi-plus-circle"></i> Tambah Layanan
            </button>

            <hr>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Buat Project</button>
                <a href="{{ route('projects.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
let serviceIndex = 1;

document.getElementById('addService').addEventListener('click', function() {
    const container = document.getElementById('serviceContainer');
    const newRow = document.createElement('div');
    newRow.className = 'service-row mb-3';
    newRow.innerHTML = `
        <div class="row">
            <div class="col-md-6">
                <label class="form-label">Layanan</label>
                <select name="services[${serviceIndex}][service_id]" class="form-select service-select" required>
                    <option value="">-- Pilih Layanan --</option>
                    @foreach($services as $service)
                    <option value="{{ $service->service_id }}" data-price="{{ $service->price }}">
                        {{ $service->service_name }} - {{ $service->speed }} Mbps - Rp {{ number_format($service->price, 0, ',', '.') }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Quantity</label>
                <input type="number" name="services[${serviceIndex}][qty]" class="form-control qty-input" value="1" min="1" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Action</label>
                <button type="button" class="btn btn-danger w-100 remove-service">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
    `;
    container.appendChild(newRow);
    serviceIndex++;
    updateRemoveButtons();
});

document.getElementById('serviceContainer').addEventListener('click', function(e) {
    if (e.target.closest('.remove-service')) {
        e.target.closest('.service-row').remove();
        updateRemoveButtons();
    }
});

function updateRemoveButtons() {
    const rows = document.querySelectorAll('.service-row');
    rows.forEach((row, index) => {
        const removeBtn = row.querySelector('.remove-service');
        if (rows.length > 1) {
            removeBtn.style.display = 'block';
        } else {
            removeBtn.style.display = 'none';
        }
    });
}
</script>
@endpush
@endsection