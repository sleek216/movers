@extends('admin.layouts.app')

@section('title', 'Lorry Details #' . $lorry->id)

@section('content')
<div class="container-fluid">
    <div class="page-title py-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4 class="mb-0 fw-bold">Lorry Details: {{ $lorry->lorry_no }}</h4>
                <p class="text-muted mb-0">Vehicle specifications, registration documents, and approval</p>
            </div>
            <div class="col-md-6 text-md-end mt-2 mt-md-0">
                <a href="{{ route('admin.lorries.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i data-feather="arrow-left"></i> Back to Fleet
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-4 col-lg-5 mb-4">
            <!-- Transporter / Lorry Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold">Transporter Information</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Owner Name</span>
                            <strong>{{ $lorry->owner_name }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Mobile</span>
                            <strong>{{ $lorry->owner_mobile }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Email</span>
                            <span>{{ $lorry->owner_email }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Verification Action Box -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold">Verification Decision</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.lorries.verify', $lorry->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Status Decision</label>
                            <select class="form-select" name="is_verify" required>
                                <option value="1" {{ $lorry->is_verify == 1 ? 'selected' : '' }}>Approve Lorry</option>
                                <option value="2" {{ $lorry->is_verify == 2 ? 'selected' : '' }}>Reject Lorry</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Reason (If rejected)</label>
                            <textarea class="form-control" name="cancle_reason" rows="3" placeholder="Explain rejection reason...">{{ $lorry->cancle_reason }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Submit Verification</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-7 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold">Vehicle Specifications & Routes</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded">
                                <span class="text-muted d-block f-12">Lorry Plate Number</span>
                                <h5 class="fw-bold mb-0 text-primary">{{ $lorry->lorry_no }}</h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded">
                                <span class="text-muted d-block f-12">Vehicle Category</span>
                                <h5 class="fw-bold mb-0">{{ $lorry->vehicle_title }}</h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded">
                                <span class="text-muted d-block f-12">Weight Capacity</span>
                                <h5 class="fw-bold mb-0">{{ $lorry->weight }} Tons</h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded">
                                <span class="text-muted d-block f-12">Current State / Region</span>
                                <h5 class="fw-bold mb-0">{{ $lorry->state_title ?? 'N/A' }}</h5>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="p-3 bg-light rounded">
                                <span class="text-muted d-block f-12">Current Live Location</span>
                                <p class="fw-semibold mb-0">{{ $lorry->curr_location }}</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="p-3 bg-light rounded">
                                <span class="text-muted d-block f-12">Operating Routes</span>
                                <p class="fw-semibold mb-0">{{ $lorry->routes ?: 'All Routes' }}</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="p-3 bg-light rounded">
                                <span class="text-muted d-block f-12">Vehicle Notes / Description</span>
                                <p class="mb-0">{{ $lorry->description ?: 'None' }}</p>
                            </div>
                        </div>
                    </div>

                    <h5 class="fw-bold mt-4 mb-3">Vehicle Registration Documents</h5>
                    <div class="row">
                        <div class="col-md-6">
                            @if($lorry->document)
                                <a href="{{ asset($lorry->document) }}" target="_blank">
                                    <img src="{{ asset($lorry->document) }}" class="img-fluid rounded border" alt="Vehicle Document">
                                </a>
                            @else
                                <div class="p-4 bg-light text-center text-muted border rounded">No Document Uploaded</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
