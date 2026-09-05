@extends('admin.layouts.app')

@section('title', 'Transporter Payouts')

@section('content')
<div class="container-fluid">
    <div class="page-title py-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4 class="mb-0 fw-bold">Transporter Payout Requests</h4>
                <p class="text-muted mb-0">Withdrawal requests submitted by transporters</p>
            </div>
            <div class="col-md-6 text-md-end mt-2 mt-md-0">
                <a href="{{ route('admin.payouts.earnings') }}" class="btn btn-primary btn-sm">
                    <i data-feather="trending-up"></i> Earning Reports
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover datatable align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#ID</th>
                            <th>Transporter</th>
                            <th>Amount</th>
                            <th>Payout Method</th>
                            <th>Account Details</th>
                            <th>Request Date</th>
                            <th>Status</th>
                            <th>Proof</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payouts as $payout)
                        <tr>
                            <td><strong>#{{ $payout->id }}</strong></td>
                            <td>
                                <div class="fw-semibold">{{ $payout->owner_name ?? 'Owner #' . $payout->owner_id }}</div>
                                <small class="text-muted">{{ $payout->owner_mobile ?? '' }}</small>
                            </td>
                            <td><strong class="text-primary f-15">${{ number_format($payout->amt, 2) }}</strong></td>
                            <td><span class="badge bg-light text-dark border">{{ $payout->r_type ?: 'Bank Transfer' }}</span></td>
                            <td>
                                <div class="f-12">
                                    @if($payout->bank_name)
                                        <div><strong>Bank:</strong> {{ $payout->bank_name }}</div>
                                        <div><strong>Acc:</strong> {{ $payout->acc_number }} ({{ $payout->acc_name }})</div>
                                        <div><strong>IFSC:</strong> {{ $payout->ifsc_code }}</div>
                                    @elseif($payout->upi_id)
                                        <div><strong>UPI ID:</strong> {{ $payout->upi_id }}</div>
                                    @elseif($payout->paypal_id)
                                        <div><strong>PayPal:</strong> {{ $payout->paypal_id }}</div>
                                    @else
                                        <span class="text-muted">Direct</span>
                                    @endif
                                </div>
                            </td>
                            <td><small class="text-muted">{{ $payout->r_date }}</small></td>
                            <td>
                                @if($payout->status == 'Completed')
                                    <span class="badge bg-success">Completed</span>
                                @elseif($payout->status == 'Cancelled')
                                    <span class="badge bg-danger">Cancelled</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                            <td>
                                @if($payout->proof)
                                    <a href="{{ asset($payout->proof) }}" target="_blank" class="btn btn-sm btn-outline-info">View Receipt</a>
                                @else
                                    <span class="text-muted f-12">None</span>
                                @endif
                            </td>
                            <td>
                                @if($payout->status == 'Pending')
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#payoutModal{{ $payout->id }}">
                                        Process
                                    </button>

                                    <!-- Process Modal -->
                                    <div class="modal fade" id="payoutModal{{ $payout->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Process Payout #{{ $payout->id }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('admin.payouts.updateStatus', $payout->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <p class="mb-3">Transporter: <strong>{{ $payout->owner_name }}</strong><br>Amount: <strong>${{ number_format($payout->amt, 2) }}</strong></p>
                                                        
                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">Action Decision</label>
                                                            <select class="form-select" name="status" required>
                                                                <option value="Completed">Mark as Completed (Paid)</option>
                                                                <option value="Cancelled">Reject / Cancel Payout</option>
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">Upload Transfer Receipt / Proof</label>
                                                            <input type="file" name="proof" class="form-control" accept="image/*">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Update Payout</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted f-12">Processed</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
