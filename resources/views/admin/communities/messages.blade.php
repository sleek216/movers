@extends('admin.layouts.app')

@section('title', 'Community Chat Moderation - ' . $group->title)

@section('content')
<div class="container-fluid">
    <div class="page-title py-3">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-center">
                    <a href="{{ route('admin.communities.index') }}" class="btn btn-outline-secondary btn-sm me-3">
                        <i class="bi bi-arrow-left"></i> Back to Channels
                    </a>
                    <div>
                        <h4 class="mb-0 fw-bold">💬 {{ $group->title }}</h4>
                        <p class="text-muted mb-0">Live Messages Stream & Moderation History</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-end">
                <span class="badge bg-primary px-3 py-2 fs-6">
                    <i class="bi bi-chat-dots-fill me-1"></i> {{ $messages->total() }} Total Messages
                </span>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mb-4">
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-shield-check text-success me-2"></i>Live Group Chat Feed</h5>
            <small class="text-muted">Showing latest 50 messages</small>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Sender</th>
                            <th>Role / Type</th>
                            <th style="min-width: 250px;">Message Content</th>
                            <th>Media Attached</th>
                            <th>Timestamp</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($messages as $msg)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center fw-bold me-2" style="width: 38px; height: 38px;">
                                        {{ strtoupper(substr($msg->sender_name ?? 'User', 0, 1)) }}
                                    </div>
                                    <div>
                                        <span class="fw-bold text-dark d-block">{{ $msg->sender_name ?? 'Unknown User' }}</span>
                                        <small class="text-muted">{{ $msg->sender_mobile ?? 'N/A' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $msg->sender_id == 1 ? '👑 Admin' : 'Verified Member' }}</span>
                            </td>
                            <td>
                                <div class="p-2 rounded bg-light border text-dark" style="font-size: 0.92rem;">
                                    {{ $msg->message }}
                                </div>
                            </td>
                            <td>
                                @if($msg->media_url)
                                    <a href="{{ asset($msg->media_url) }}" target="_blank" class="badge bg-primary text-decoration-none p-2">
                                        <i class="bi bi-image me-1"></i> View Photo
                                    </a>
                                @else
                                    <span class="text-muted small">None</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($msg->created_at)->format('d M Y, h:i A') }}</small>
                            </td>
                            <td class="text-end pe-4">
                                <form action="{{ route('admin.communities.destroyMessage', $msg->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this message for spam/abuse moderation?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Message">
                                        <i class="bi bi-trash3-fill"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-chat-square-dots fs-1 d-block mb-3 text-secondary"></i>
                                    <h6 class="fw-bold">No Messages In This Group Yet</h6>
                                    <p class="mb-0">Transporters and shippers can send messages via Flutter Mobile App.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($messages->hasPages())
            <div class="p-3 border-top">
                {{ $messages->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
