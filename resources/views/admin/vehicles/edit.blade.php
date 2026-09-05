@extends('admin.layouts.app')

@section('title', 'Edit Vehicle Category')

@section('content')
<div class="container-fluid">
    <div class="page-title py-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4 class="mb-0 fw-bold">Edit Vehicle Category: {{ $vehicle->title }}</h4>
            </div>
            <div class="col-md-6 text-md-end mt-2 mt-md-0">
                <a href="{{ route('admin.vehicles.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i data-feather="arrow-left"></i> Back to List
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.vehicles.update', $vehicle->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Vehicle Title / Type Name</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $vehicle->title) }}" required>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Min Weight (Tons)</label>
                                <input type="number" step="0.1" name="min_weight" class="form-control" value="{{ old('min_weight', $vehicle->min_weight) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Max Weight (Tons)</label>
                                <input type="number" step="0.1" name="max_weight" class="form-control" value="{{ old('max_weight', $vehicle->max_weight) }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Status</label>
                            <select class="form-select" name="status" required>
                                <option value="1" {{ $vehicle->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $vehicle->status == 0 ? 'selected' : '' }}>Disabled</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Vehicle Image / Icon</label>
                            @if($vehicle->img)
                                <div class="mb-2">
                                    <img src="{{ asset($vehicle->img) }}" width="60" height="60" class="border rounded p-1" alt="">
                                </div>
                            @endif
                            <input type="file" name="img" class="form-control" accept="image/*">
                            <small class="text-muted">Leave blank if you don't want to change the image.</small>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Update Vehicle Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
