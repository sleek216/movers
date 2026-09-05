@extends('admin.layouts.app')

@section('title', 'Add Vehicle Category')

@section('content')
<div class="container-fluid">
    <div class="page-title py-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4 class="mb-0 fw-bold">Add Vehicle Category</h4>
                <p class="text-muted mb-0">Create new vehicle classification for bookings</p>
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
                    <form action="{{ route('admin.vehicles.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Vehicle Title / Type Name</label>
                            <input type="text" name="title" class="form-control" placeholder="e.g. Medium Truck (6 Wheeler)" required value="{{ old('title') }}">
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Min Weight (Tons)</label>
                                <input type="number" step="0.1" name="min_weight" class="form-control" placeholder="e.g. 1" required value="{{ old('min_weight') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Max Weight (Tons)</label>
                                <input type="number" step="0.1" name="max_weight" class="form-control" placeholder="e.g. 5" required value="{{ old('max_weight') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Status</label>
                            <select class="form-select" name="status" required>
                                <option value="1">Active</option>
                                <option value="0">Disabled</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Vehicle Image / Icon</label>
                            <input type="file" name="img" class="form-control" accept="image/*" required>
                            <small class="text-muted">Recommended: PNG or SVG with transparent background.</small>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="reset" class="btn btn-light me-2">Reset</button>
                            <button type="submit" class="btn btn-primary">Create Vehicle Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
