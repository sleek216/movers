@extends('admin.layouts.app')

@section('title', 'Movers Communities & Groups')

@section('content')
<div class="container-fluid">
    <div class="page-title py-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4 class="mb-0 fw-bold">💬 Movers Communities & Hubs</h4>
                <p class="text-muted mb-0">Manage official community groups, transport corridors, and broadcast channels</p>
            </div>
            <div class="col-md-6 text-end">
                <button type="button" class="btn btn-primary px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#createGroupModal">
                    <i class="bi bi-plus-circle me-1"></i> Create New Community Group
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Stats Counter -->
<div class="container-fluid mb-4">
    <div class="row g-3">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-primary text-white p-3 rounded-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-white-50 small">Active Groups / Channels</span>
                        <h3 class="mb-0 fw-bold">{{ $totalGroups }}</h3>
                    </div>
                    <i class="bi bi-chat-square-dots-fill fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-success text-white p-3 rounded-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-white-50 small">Total Group Memberships</span>
                        <h3 class="mb-0 fw-bold">{{ $totalMemberships }}</h3>
                    </div>
                    <i class="bi bi-people-fill fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-info text-white p-3 rounded-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-white-50 small">Total Messages Exchanged</span>
                        <h3 class="mb-0 fw-bold">{{ $totalMessages }}</h3>
                    </div>
                    <i class="bi bi-chat-quote-fill fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Groups Table Card -->
<div class="container-fluid mb-4">
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white py-3 border-0">
            <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-collection-fill text-primary me-2"></i>All Community Channels</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Channel / Group</th>
                            <th>Category</th>
                            <th>Status / Badge</th>
                            <th>Active Members</th>
                            <th>Total Messages</th>
                            <th>Created Date</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($groups as $group)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-box me-3 rounded-3 bg-light d-flex align-items-center justify-content-center border" style="width: 46px; height: 46px; overflow: hidden;">
                                        @if($group->icon)
                                            <img src="{{ asset($group->icon) }}" alt="{{ $group->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <i class="bi bi-truck text-primary fs-4"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold text-dark">{{ $group->title }}</h6>
                                        <small class="text-muted text-truncate d-inline-block" style="max-width: 280px;">{{ $group->description ?? 'No description' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $group->category }}</span>
                            </td>
                            <td>
                                @if($group->is_official)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                        <i class="bi bi-patch-check-fill me-1"></i> Official Movers Hub
                                    </span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary px-2 py-1">Community</span>
                                @endif
                            </td>
                            <td>
                                <span class="fw-bold text-dark"><i class="bi bi-person me-1 text-primary"></i>{{ $group->members_count }}</span>
                            </td>
                            <td>
                                <span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1">
                                    <i class="bi bi-chat-left-text me-1"></i> {{ $group->messages_count }}
                                </span>
                            </td>
                            <td>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($group->created_at)->format('d M Y') }}</small>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group">
                                    <a href="{{ route('admin.communities.messages', $group->id) }}" class="btn btn-sm btn-outline-primary" title="View & Moderate Chat Messages">
                                        <i class="bi bi-chat-dots-fill me-1"></i> View Chat
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editModal{{ $group->id }}" title="Edit Group">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <form action="{{ route('admin.communities.destroy', $group->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this community group and all its messages?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Group">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Edit Modal for each group -->
                        <div class="modal fade" id="editModal{{ $group->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    <form action="{{ route('admin.communities.update', $group->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-header bg-light">
                                            <h5 class="modal-title fw-bold">✏️ Edit Community Group</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Group Title / Name <span class="text-danger">*</span></label>
                                                <input type="text" name="title" class="form-control" value="{{ $group->title }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Category</label>
                                                <input type="text" name="category" class="form-control" value="{{ $group->category }}" placeholder="e.g. Spot Rates, National Transport, Cloth Market, etc.">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Description</label>
                                                <textarea name="description" class="form-control" rows="3">{{ $group->description }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Group Icon / Logo (Optional)</label>
                                                <input type="file" name="icon" class="form-control" accept="image/*">
                                            </div>
                                            <div class="form-check form-switch mt-3">
                                                <input class="form-check-input" type="checkbox" name="is_official" id="officialCheck{{ $group->id }}" value="1" {{ $group->is_official ? 'checked' : '' }}>
                                                <label class="form-check-label fw-bold" for="officialCheck{{ $group->id }}">Official Verified Movers Channel</label>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-chat-square-dots fs-1 d-block mb-3 text-secondary"></i>
                                    <h5 class="fw-bold">No Community Groups Found</h5>
                                    <p class="mb-3">Create your first official freight community channel now!</p>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createGroupModal">
                                        <i class="bi bi-plus-circle me-1"></i> Create Community Group
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Create Group Modal -->
<div class="modal fade" id="createGroupModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('admin.communities.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle me-2"></i>Create New Community Group</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Group Title / Route Corridor <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. Lahore ➔ Karachi Daily Truckers Hub" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Category</label>
                        <input type="text" name="category" class="form-control" placeholder="e.g. Spot Rates, National Transport, Cloth Market, Grain Adda, etc.">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Brief description of the channel topics, guidelines or corridor..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Group Icon / Logo (Optional)</label>
                        <input type="file" name="icon" class="form-control" accept="image/*">
                        <small class="text-muted">Recommended: Square PNG/JPG (e.g. 200x200px)</small>
                    </div>
                    <div class="form-check form-switch mt-3">
                        <input class="form-check-input" type="checkbox" name="is_official" id="createOfficialCheck" value="1" checked>
                        <label class="form-check-label fw-bold" for="createOfficialCheck">Official Verified Movers Channel (Badge)</label>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4"><i class="bi bi-check2 me-1"></i> Create Group</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
