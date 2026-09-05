@extends('admin.layouts.app')

@section('title', 'Vehicle Categories')

@section('content')
<div class="container-fluid">
    <div class="page-title py-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4 class="mb-0 fw-bold">Vehicle Categories</h4>
                <p class="text-muted mb-0">Manage vehicle types, weight limits, and icons</p>
            </div>
            <div class="col-md-6 text-md-end mt-2 mt-md-0">
                <a href="{{ route('admin.vehicles.create') }}" class="btn btn-primary btn-sm">
                    <i data-feather="plus-circle"></i> Add Vehicle Category
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
                            <th>Image</th>
                            <th>Vehicle Name</th>
                            <th>Min Weight (Tons)</th>
                            <th>Max Weight (Tons)</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vehicles as $v)
                        <tr>
                            <td><strong>#{{ $v->id }}</strong></td>
                            <td>
                                @if($v->img)
                                    <img src="{{ asset($v->img) }}" width="50" height="50" class="rounded border p-1" alt="">
                                @endif
                            </td>
                            <td><span class="fw-bold">{{ $v->title }}</span></td>
                            <td>{{ $v->min_weight }} Tons</td>
                            <td>{{ $v->max_weight }} Tons</td>
                            <td>
                                @if($v->status == 1)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Disabled</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.vehicles.edit', $v->id) }}" class="btn btn-outline-primary" title="Edit">
                                        <i data-feather="edit-2"></i>
                                    </a>
                                    <form action="{{ route('admin.vehicles.toggleStatus', $v->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn {{ $v->status == 1 ? 'btn-outline-warning' : 'btn-outline-success' }}" title="Toggle Status">
                                            <i data-feather="{{ $v->status == 1 ? 'pause' : 'play' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.vehicles.destroy', $v->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this vehicle category?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Delete">
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
@endsection
