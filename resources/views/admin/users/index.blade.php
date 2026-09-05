@extends('admin.layouts.app')

@section('title', 'Customers')

@section('content')
<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
    <div>
        <h3 class="fw-bold mb-1">Customer Management</h3>
        <p class="text-muted mb-0">List of registered clients, KYC documents, and account status</p>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table datatable align-middle">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Wallet Balance</th>
                        <th>KYC Status</th>
                        <th>Account Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td><strong class="text-secondary">#{{ $user->id }}</strong></td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                @if($user->pro_pic)
                                    <img src="{{ asset($user->pro_pic) }}" width="40" height="40" class="rounded-circle border" alt="">
                                @else
                                    <div class="rounded-circle bg-light-primary text-primary d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-bold">{{ $user->name }}</div>
                                    <small class="text-muted">Joined: {{ $user->rdate ? date('d M Y', strtotime($user->rdate)) : 'N/A' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td><span class="font-monospace">{{ $user->ccode }} {{ $user->mobile }}</span></td>
                        <td><strong class="text-primary">${{ number_format($user->wallet, 2) }}</strong></td>
                        <td>
                            @if($user->is_verify == 1)
                                <span class="badge badge-soft-success"><i class="bi bi-check-circle-fill me-1"></i> Verified</span>
                            @elseif($user->is_verify == 2)
                                <span class="badge badge-soft-danger"><i class="bi bi-x-circle-fill me-1"></i> Rejected</span>
                            @else
                                <span class="badge badge-soft-warning"><i class="bi bi-clock-fill me-1"></i> Pending Doc</span>
                            @endif
                        </td>
                        <td>
                            @if($user->status == 1)
                                <span class="badge badge-soft-success">Active</span>
                            @else
                                <span class="badge badge-soft-danger">Blocked</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.users.wallet', $user->id) }}" class="btn btn-outline-primary" title="Wallet">
                                    <i class="bi bi-wallet2"></i>
                                </a>
                                
                                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#verifyModal{{ $user->id }}" title="View KYC Documents">
                                    <i class="bi bi-file-earmark-person"></i>
                                </button>

                                <form action="{{ route('admin.users.toggleStatus', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn {{ $user->status == 1 ? 'btn-outline-danger' : 'btn-outline-success' }}" title="{{ $user->status == 1 ? 'Block Account' : 'Activate Account' }}">
                                        <i class="bi {{ $user->status == 1 ? 'bi-lock-fill' : 'bi-unlock-fill' }}"></i>
                                    </button>
                                </form>
                            </div>

                            <!-- KYC Document Modal -->
                            <div class="modal fade" id="verifyModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content" style="border-radius: var(--radius-lg);">
                                        <div class="modal-header border-0 pb-0">
                                            <h5 class="modal-title fw-bold">KYC Verification - {{ $user->name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('admin.users.verifyDocument', $user->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body text-start">
                                                <div class="row g-3 mb-4">
                                                    <div class="col-6 text-center">
                                                        <label class="form-label fw-bold small text-muted text-uppercase">National ID / Document</label>
                                                        @if($user->identity_document)
                                                            <a href="{{ asset($user->identity_document) }}" target="_blank">
                                                                <img src="{{ asset($user->identity_document) }}" class="img-fluid rounded border shadow-sm" style="max-height: 140px;" alt="">
                                                            </a>
                                                        @else
                                                            <div class="p-4 bg-light text-muted border rounded small">No Document</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-6 text-center">
                                                        <label class="form-label fw-bold small text-muted text-uppercase">Client Selfie</label>
                                                        @if($user->selfie)
                                                            <a href="{{ asset($user->selfie) }}" target="_blank">
                                                                <img src="{{ asset($user->selfie) }}" class="img-fluid rounded border shadow-sm" style="max-height: 140px;" alt="">
                                                            </a>
                                                        @else
                                                            <div class="p-4 bg-light text-muted border rounded small">No Selfie</div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Verification Status</label>
                                                    <select class="form-select" name="is_verify" required>
                                                        <option value="1" {{ $user->is_verify == 1 ? 'selected' : '' }}>Approved / Verified</option>
                                                        <option value="2" {{ $user->is_verify == 2 ? 'selected' : '' }}>Reject / Incomplete</option>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Rejection Comment / Note</label>
                                                    <textarea class="form-control" name="reject_comment" rows="2" placeholder="Explain reason if rejected...">{{ $user->reject_comment }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0 pt-0">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Save Decision</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
