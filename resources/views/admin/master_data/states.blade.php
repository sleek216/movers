@extends('admin.layouts.app')

@section('title', 'States / Provinces')

@section('content')
<div class="container-fluid">
    <div class="page-title py-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4 class="mb-0 fw-bold">States & Regions</h4>
                <p class="text-muted mb-0">Manage service coverage areas</p>
            </div>
            <div class="col-md-6 text-md-end mt-2 mt-md-0">
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addStateModal">
                    <i data-feather="plus-circle"></i> Add New State
                </button>
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
                            <th>Image</th>
                            <th>State / Region Name</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($states as $state)
                        <tr>
                            <td><strong>#{{ $state->id }}</strong></td>
                            <td>
                                @if($state->img)
                                    <img src="{{ asset($state->img) }}" width="45" height="45" class="rounded" alt="">
                                @endif
                            </td>
                            <td><span class="fw-bold">{{ $state->title }}</span></td>
                            <td>
                                @if($state->status == 1)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Disabled</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <form action="{{ route('admin.states.toggleStatus', $state->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn {{ $state->status == 1 ? 'btn-outline-warning' : 'btn-outline-success' }}">
                                            <i data-feather="{{ $state->status == 1 ? 'pause' : 'play' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.states.destroy', $state->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this state?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">
                                            <i data-feather="trash-2"></i>
                                        </button>
                                    </form>
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

<!-- Add State Modal -->
<div class="modal fade" id="addStateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add State / Region</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.states.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">State Name</label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. California" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="1">Active</option>
                            <option value="0">Disabled</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">State Image (Optional)</label>
                        <input type="file" name="img" class="form-control" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save State</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
