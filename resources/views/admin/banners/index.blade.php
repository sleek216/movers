@extends('admin.layouts.app')

@section('title', 'Banners')

@section('content')
<div class="container-fluid">
    <div class="page-title py-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4 class="mb-0 fw-bold">Promotional Banners</h4>
                <p class="text-muted mb-0">Manage home screen promotional and slider banners</p>
            </div>
            <div class="col-md-6 text-md-end mt-2 mt-md-0">
                <a href="{{ route('admin.banners.create') }}" class="btn btn-primary btn-sm">
                    <i data-feather="plus-circle"></i> Add New Banner
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
                            <th>Banner Preview</th>
                            <th>Target Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($banners as $banner)
                        <tr>
                            <td><strong>#{{ $banner->id }}</strong></td>
                            <td>
                                @if($banner->img)
                                    <img src="{{ asset($banner->img) }}" height="70" class="rounded border" alt="Banner">
                                @endif
                            </td>
                            <td><span class="badge bg-light text-dark border">{{ $banner->b_type ?? 'User' }}</span></td>
                            <td>
                                @if($banner->status == 1)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Disabled</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <form action="{{ route('admin.banners.toggleStatus', $banner->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn {{ $banner->status == 1 ? 'btn-outline-warning' : 'btn-outline-success' }}" title="Toggle Status">
                                            <i data-feather="{{ $banner->status == 1 ? 'pause' : 'play' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this banner?');">
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
