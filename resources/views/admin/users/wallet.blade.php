@extends('admin.layouts.app')

@section('title', 'Customer Wallet')

@section('content')
<div class="container-fluid">
    <div class="page-title py-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4 class="mb-0 fw-bold">Wallet: {{ $user->name }}</h4>
                <p class="text-muted mb-0">Current Balance: <strong class="text-primary">${{ number_format($user->wallet, 2) }}</strong></p>
            </div>
            <div class="col-md-6 text-md-end mt-2 mt-md-0">
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#adjustModal">
                    <i data-feather="plus-circle"></i> Adjust Wallet Balance
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm ms-2">Back to Customers</a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card border-0 shadow-sm">
        <div class="card-header">
            <h5 class="mb-0 fw-bold">Wallet Transaction History</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover datatable align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#ID</th>
                            <th>Description / Note</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Date & Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $t)
                        <tr>
                            <td>#{{ $t->id }}</td>
                            <td>{{ $t->message }}</td>
                            <td>
                                @if($t->status == 'Credit' || $t->status == 'credit')
                                    <span class="badge bg-success">Credit</span>
                                @else
                                    <span class="badge bg-danger">Debit</span>
                                @endif
                            </td>
                            <td><strong>${{ number_format($t->amt, 2) }}</strong></td>
                            <td>{{ $t->tdate }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No wallet transactions found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Adjust Wallet Modal -->
<div class="modal fade" id="adjustModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adjust Wallet Balance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.users.adjustWallet', $user->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Adjustment Type</label>
                        <select class="form-select" name="type" required>
                            <option value="Credit">Credit (Add Funds)</option>
                            <option value="Debit">Debit (Deduct Funds)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Amount ($)</label>
                        <input type="number" step="0.01" min="1" name="amount" class="form-control" placeholder="e.g. 50" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Reason / Note</label>
                        <textarea class="form-control" name="message" rows="2" placeholder="e.g. Promotional bonus, Refund, etc." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Apply Adjustment</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
