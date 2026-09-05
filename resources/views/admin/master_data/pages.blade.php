@extends('admin.layouts.app')

@section('title', 'Dynamic Pages')

@section('content')
<div class="container-fluid">
    <div class="page-title py-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4 class="mb-0 fw-bold">Dynamic Pages</h4>
                <p class="text-muted mb-0">Terms & Conditions, Privacy Policy, About Us</p>
            </div>
            <div class="col-md-6 text-md-end mt-2 mt-md-0">
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addPageModal">
                    <i data-feather="plus-circle"></i> Add New Page
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
                            <th>Page Title</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pages as $page)
                        <tr>
                            <td><strong>#{{ $page->id }}</strong></td>
                            <td><span class="fw-bold">{{ $page->title }}</span></td>
                            <td>
                                @if($page->status == 1)
                                    <span class="badge bg-success">Published</span>
                                @else
                                    <span class="badge bg-danger">Draft / Hidden</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editPageModal{{ $page->id }}">
                                        <i data-feather="edit-2"></i> Edit Content
                                    </button>
                                    <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this page?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">
                                            <i data-feather="trash-2"></i>
                                        </button>
                                    </form>
                                </div>

                                <!-- Edit Page Modal -->
                                <div class="modal fade" id="editPageModal{{ $page->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Page: {{ $page->title }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('admin.pages.update', $page->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">Page Title</label>
                                                        <input type="text" name="title" class="form-control" value="{{ $page->title }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">Content (HTML / Markdown Supported)</label>
                                                        <textarea name="description" rows="10" class="form-control" required>{{ $page->description }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">Status</label>
                                                        <select class="form-select" name="status" required>
                                                            <option value="1" {{ $page->status == 1 ? 'selected' : '' }}>Published</option>
                                                            <option value="0" {{ $page->status == 0 ? 'selected' : '' }}>Draft</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Update Page</button>
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

<!-- Add Page Modal -->
<div class="modal fade" id="addPageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Dynamic Page</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.pages.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Page Title</label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. Terms & Conditions" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Page Content</label>
                        <textarea name="description" rows="8" class="form-control" placeholder="Enter page text..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="1">Published</option>
                            <option value="0">Draft</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Page</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
