@extends('admin.layouts.app')

@section('title', 'Bilty #' . $bilty->bilty_number . ' - Details & KYC')

@section('content')
<div class="container-fluid py-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold">📄 Bilty Details: <span class="text-primary font-monospace">{{ $bilty->bilty_number }}</span></h4>
            <p class="text-muted mb-0">Booked on {{ $bilty->bilty_date ? $bilty->bilty_date->format('d M, Y') : $bilty->created_at->format('d M, Y') }} | Status: <span class="badge bg-primary">{{ $bilty->status }}</span></p>
        </div>
        <div>
            <a href="{{ route('admin.bilties.print', $bilty->id) }}" target="_blank" class="btn btn-dark fw-bold me-2">
                <i class="fas fa-print me-1"></i> Print 3-Copy Bilty
            </a>
            <a href="{{ route('admin.bilties.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Register
            </a>
        </div>
    </div>

    <div class="row g-4">
        <!-- Parties & Route Details -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-map-marked-alt me-2"></i>Consignor (Sender) & Consignee (Receiver)</h6>
                </div>
                <div class="card-body">
                    <div class="p-3 bg-light rounded-3 mb-3">
                        <span class="badge bg-success mb-2">Consignor / بھیجنے والا</span>
                        <h5 class="fw-bold mb-1">{{ $bilty->consignor_name }}</h5>
                        <p class="mb-1 text-muted"><i class="fas fa-phone-alt me-2 text-primary"></i>{{ $bilty->consignor_phone ?: 'N/A' }}</p>
                        <p class="mb-0 text-muted"><i class="fas fa-map-pin me-2 text-danger"></i><strong>{{ $bilty->consignor_city }}</strong> - {{ $bilty->consignor_address }}</p>
                    </div>

                    <div class="p-3 bg-light rounded-3">
                        <span class="badge bg-danger mb-2">Consignee / وصول کنندہ</span>
                        <h5 class="fw-bold mb-1">{{ $bilty->consignee_name }}</h5>
                        <p class="mb-1 text-muted"><i class="fas fa-phone-alt me-2 text-primary"></i>{{ $bilty->consignee_phone ?: 'N/A' }}</p>
                        <p class="mb-0 text-muted"><i class="fas fa-map-pin me-2 text-danger"></i><strong>{{ $bilty->consignee_city }}</strong> - {{ $bilty->consignee_address }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cargo & Freight Details -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-boxes me-2"></i>Cargo, Weight & Freight Breakdown</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="text-muted small">Goods Description</label>
                            <div class="fw-bold fs-6">{{ $bilty->goods_description }}</div>
                        </div>
                        <div class="col-6">
                            <label class="text-muted small">Packaging & Quantity</label>
                            <div class="fw-bold fs-6">{{ $bilty->total_packages }} {{ $bilty->package_type }}</div>
                        </div>
                        <div class="col-6">
                            <label class="text-muted small">Total Weight</label>
                            <div class="fw-bold fs-6">{{ $bilty->weight_value }} {{ $bilty->weight_unit }}</div>
                        </div>
                        <div class="col-6">
                            <label class="text-muted small">Payment Term</label>
                            <div><span class="badge bg-info text-dark fs-6">{{ $bilty->payment_status }}</span></div>
                        </div>
                    </div>

                    <div class="p-3 bg-light rounded-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Total Freight (Kul Kiraya):</span>
                            <span class="fw-bold text-success fs-5">Rs. {{ number_format($bilty->freight_total) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Advance Paid (Peshgi):</span>
                            <span class="fw-semibold text-primary">Rs. {{ number_format($bilty->advance_paid) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Balance Due (Baqi):</span>
                            <span class="fw-bold text-danger fs-6">Rs. {{ number_format($bilty->balance_amount) }}</span>
                        </div>
                        @if($bilty->loading_charges > 0)
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Hamali / Loading:</span>
                            <span class="text-muted">Rs. {{ number_format($bilty->loading_charges) }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- 🛡️ Driver & Vehicle KYC Verification -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-id-card me-2"></i>Driver & Vehicle KYC Verification</h6>
                </div>
                <div class="card-body">
                    @if($bilty->driver_name)
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="text-muted small">Driver Name</label>
                            <div class="fw-bold">{{ $bilty->driver_name }}</div>
                        </div>
                        <div class="col-6">
                            <label class="text-muted small">Driver Phone</label>
                            <div class="fw-bold">{{ $bilty->driver_phone }}</div>
                        </div>
                        <div class="col-6">
                            <label class="text-muted small">Driver CNIC</label>
                            <div class="fw-bold font-monospace">{{ $bilty->driver_cnic ?: 'N/A' }}</div>
                        </div>
                        <div class="col-6">
                            <label class="text-muted small">Truck No. & Type</label>
                            <div><span class="badge bg-secondary font-monospace fs-6">{{ $bilty->truck_number }}</span> ({{ $bilty->truck_type ?: 'Truck' }})</div>
                        </div>
                    </div>

                    <!-- KYC Document Photos -->
                    <label class="text-muted small mb-2 fw-semibold">Verification Photos & Documents:</label>
                    <div class="row g-2">
                        @if($bilty->driver_cnic_front)
                        <div class="col-4">
                            <div class="border rounded p-1 text-center bg-light">
                                <a href="{{ asset($bilty->driver_cnic_front) }}" target="_blank">
                                    <img src="{{ asset($bilty->driver_cnic_front) }}" class="img-fluid rounded" style="max-height: 90px;" alt="CNIC Front">
                                </a>
                                <div class="text-muted small mt-1">CNIC Front</div>
                            </div>
                        </div>
                        @endif

                        @if($bilty->driver_cnic_back)
                        <div class="col-4">
                            <div class="border rounded p-1 text-center bg-light">
                                <a href="{{ asset($bilty->driver_cnic_back) }}" target="_blank">
                                    <img src="{{ asset($bilty->driver_cnic_back) }}" class="img-fluid rounded" style="max-height: 90px;" alt="CNIC Back">
                                </a>
                                <div class="text-muted small mt-1">CNIC Back</div>
                            </div>
                        </div>
                        @endif

                        @if($bilty->driver_license)
                        <div class="col-4">
                            <div class="border rounded p-1 text-center bg-light">
                                <a href="{{ asset($bilty->driver_license) }}" target="_blank">
                                    <img src="{{ asset($bilty->driver_license) }}" class="img-fluid rounded" style="max-height: 90px;" alt="License">
                                </a>
                                <div class="text-muted small mt-1">License</div>
                            </div>
                        </div>
                        @endif

                        @if($bilty->driver_photo)
                        <div class="col-4">
                            <div class="border rounded p-1 text-center bg-light">
                                <a href="{{ asset($bilty->driver_photo) }}" target="_blank">
                                    <img src="{{ asset($bilty->driver_photo) }}" class="img-fluid rounded" style="max-height: 90px;" alt="Driver Photo">
                                </a>
                                <div class="text-muted small mt-1">Driver Photo</div>
                            </div>
                        </div>
                        @endif

                        @if($bilty->truck_book_photo)
                        <div class="col-4">
                            <div class="border rounded p-1 text-center bg-light">
                                <a href="{{ asset($bilty->truck_book_photo) }}" target="_blank">
                                    <img src="{{ asset($bilty->truck_book_photo) }}" class="img-fluid rounded" style="max-height: 90px;" alt="Truck Book">
                                </a>
                                <div class="text-muted small mt-1">Truck Book</div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @else
                    <p class="text-muted mb-0">No driver assigned yet.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- 🤝 Guarantor / Zamanatdar Record -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="mb-0 fw-bold text-success"><i class="fas fa-shield-alt me-2"></i>Guarantor / Zamanatdar (ضمانت دار) Record</h6>
                </div>
                <div class="card-body">
                    @if($bilty->guarantor_name)
                    <div class="p-3 bg-light rounded-3 mb-3 border-start border-4 border-success">
                        <div class="row g-2">
                            <div class="col-6">
                                <label class="text-muted small">Guarantor Name</label>
                                <div class="fw-bold fs-6">{{ $bilty->guarantor_name }}</div>
                            </div>
                            <div class="col-6">
                                <label class="text-muted small">Phone Number</label>
                                <div class="fw-bold">{{ $bilty->guarantor_phone ?: 'N/A' }}</div>
                            </div>
                            <div class="col-6">
                                <label class="text-muted small">CNIC Number</label>
                                <div class="fw-bold font-monospace">{{ $bilty->guarantor_cnic ?: 'N/A' }}</div>
                            </div>
                            <div class="col-6">
                                <label class="text-muted small">Relationship / Adda</label>
                                <div class="fw-bold text-primary">{{ $bilty->guarantor_relation ?: 'Adda Reference' }}</div>
                            </div>
                            @if($bilty->guarantor_note)
                            <div class="col-12 mt-2">
                                <label class="text-muted small">Guarantee Note / Terms</label>
                                <div class="p-2 bg-white rounded border small">{{ $bilty->guarantor_note }}</div>
                            </div>
                            @endif
                        </div>
                    </div>

                    @if($bilty->guarantor_cnic_photo)
                    <label class="text-muted small mb-2 fw-semibold">Guarantor CNIC / Document Photo:</label>
                    <div class="col-4">
                        <div class="border rounded p-1 text-center bg-light">
                            <a href="{{ asset($bilty->guarantor_cnic_photo) }}" target="_blank">
                                <img src="{{ asset($bilty->guarantor_cnic_photo) }}" class="img-fluid rounded" style="max-height: 90px;" alt="Guarantor CNIC">
                            </a>
                            <div class="text-muted small mt-1">CNIC Copy</div>
                        </div>
                    </div>
                    @endif
                    @else
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-user-shield fa-2x mb-2 text-secondary"></i>
                        <p class="mb-0">No guarantor registered for this bilty.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
