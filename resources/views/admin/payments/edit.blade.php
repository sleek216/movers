@extends('admin.layouts.app')

@section('title', 'Configure ' . $gateway->title)

@section('content')
<div class="container-fluid">
    <div class="page-title py-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4 class="mb-0 fw-bold">Configure Payment Gateway: {{ $gateway->title }}</h4>
            </div>
            <div class="col-md-6 text-md-end mt-2 mt-md-0">
                <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i data-feather="arrow-left"></i> Back to Gateways
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.payments.update', $gateway->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Gateway Title</label>
                            <input type="text" name="title" class="form-control" value="{{ $gateway->title }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Subtitle / Description</label>
                            <input type="text" name="subtitle" class="form-control" value="{{ $gateway->subtitle }}">
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Status in App</label>
                                <select class="form-select" name="status" required>
                                    <option value="1" {{ $gateway->status == 1 ? 'selected' : '' }}>Enabled (Active)</option>
                                    <option value="0" {{ $gateway->status == 0 ? 'selected' : '' }}>Disabled</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Environment Mode</label>
                                <select class="form-select" name="p_show" required>
                                    <option value="1" {{ $gateway->p_show == '1' ? 'selected' : '' }}>Production / Live</option>
                                    <option value="0" {{ $gateway->p_show == '0' ? 'selected' : '' }}>Sandbox / Test</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">API Credentials / Configuration JSON or Keys</label>
                            <textarea name="attributes" rows="5" class="form-control font-monospace" placeholder="Key details / Secret keys / JSON attributes">{{ $gateway->attributes }}</textarea>
                            <small class="text-muted">Enter key values (e.g. key_id, secret, public_key) required by this gateway.</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Gateway Logo</label>
                            @if($gateway->img)
                                <div class="mb-2">
                                    <img src="{{ asset($gateway->img) }}" height="40" alt="">
                                </div>
                            @endif
                            <input type="file" name="img" class="form-control" accept="image/*">
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Save Configuration</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
