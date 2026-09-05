@extends('admin.layouts.app')

@section('title', 'Transporters')

@section('content')
<div class="container-fluid">
    <div class="page-title py-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4 class="mb-0 fw-bold">Transporters / Lorry Owners</h4>
                <p class="text-muted mb-0">Manage transporter accounts, commissions, and document approvals</p>
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
                            <th>Avatar</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Commission (%)</th>
                            <th>Doc Status</th>
                            <th>Account Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($owners as $owner)
                        <tr>
                            <td><strong>#{{ $owner->id }}</strong></td>
                            <td>
                                @if($owner->pro_pic)
                                    <img src="{{ asset($owner->pro_pic) }}" width="40" height="40" class="rounded-circle" alt="">
                                @else
                                    <div class="bg-light-success rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i data-feather="user"></i>
                                    </div>
                                @endif
                            </td>
                            <td><span class="fw-semibold">{{ $owner->name }}</span></td>
                            <td>{{ $owner->email }}</td>
                            <td>{{ $owner->ccode }} {{ $owner->mobile }}</td>
                            <td><strong>{{ $owner->commission ?? 0 }}%</strong></td>
                            <td>
                                @if($owner->is_verify == 1)
                                    <span class="badge bg-success">Approved</span>
                                @elseif($owner->is_verify == 2)
                                    <span class="badge bg-danger">Rejected</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                            <td>
                                @if($owner->status == 1)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Blocked</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <!-- Verify Documents Modal Trigger -->
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#verifyModal{{ $owner->id }}" title="Verify Documents">
                                        <i data-feather="file-text"></i>
                                    </button>

                                    <!-- Commission Modal Trigger -->
                                    <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#commissionModal{{ $owner->id }}" title="Edit Commission">
                                        <i data-feather="percent"></i>
                                    </button>

                                    <!-- Status Toggle Form -->
                                    <form action="{{ route('admin.owners.toggleStatus', $owner->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn {{ $owner->status == 1 ? 'btn-outline-danger' : 'btn-outline-success' }}" title="{{ $owner->status == 1 ? 'Block Account' : 'Activate Account' }}">
                                            <i data-feather="{{ $owner->status == 1 ? 'lock' : 'unlock' }}"></i>
                                        </button>
                                    </form>
                                </div>

                                <!-- Verification Modal -->
                                <div class="modal fade" id="verifyModal{{ $owner->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Documents - {{ $owner->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('admin.owners.verifyDocument', $owner->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="row g-3 mb-3">
                                                        <div class="col-6 text-center">
                                                            <label class="form-label fw-bold">Identity Document</label>
                                                            @if($owner->identity_document)
                                                                <a href="{{ asset($owner->identity_document) }}" target="_blank">
                                                                    <img src="{{ asset($owner->identity_document) }}" class="img-fluid rounded border" style="max-height: 140px;" alt="">
                                                                </a>
                                                            @else
                                                                <div class="p-3 bg-light text-muted border rounded">No Document</div>
                                                            @endif
                                                        </div>
                                                        <div class="col-6 text-center">
                                                            <label class="form-label fw-bold">Selfie</label>
                                                            @if($owner->selfie)
                                                                <a href="{{ asset($owner->selfie) }}" target="_blank">
                                                                    <img src="{{ asset($owner->selfie) }}" class="img-fluid rounded border" style="max-height: 140px;" alt="">
                                                                </a>
                                                            @else
                                                                <div class="p-3 bg-light text-muted border rounded">No Selfie</div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">Verification Decision</label>
                                                        <select class="form-select" name="is_verify" required>
                                                            <option value="1" {{ $owner->is_verify == 1 ? 'selected' : '' }}>Approve / Verified</option>
                                                            <option value="2" {{ $owner->is_verify == 2 ? 'selected' : '' }}>Reject</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">Comments / Rejection Reason</label>
                                                        <textarea class="form-control" name="reject_comment" rows="2" placeholder="Optional comments...">{{ $owner->reject_comment }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save Decision</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Commission Modal -->
                                <div class="modal fade" id="commissionModal{{ $owner->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Set Commission</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('admin.owners.updateCommission', $owner->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">Commission Percentage (%)</label>
                                                        <input type="number" step="0.1" min="0" max="100" name="commission" value="{{ $owner->commission ?? 0 }}" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Save</button>
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
</div>
@endsection
