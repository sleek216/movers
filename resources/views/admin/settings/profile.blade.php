@extends('admin.layouts.app')

@section('title', 'Admin Profile')

@section('content')
<div class="container-fluid">
    <div class="page-title py-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4 class="mb-0 fw-bold">Admin Profile & Security</h4>
                <p class="text-muted mb-0">Update your username and master login password</p>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.settings.updateProfile') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Admin Username</label>
                            <input type="text" name="username" class="form-control" value="{{ $admin->username ?? 'admin' }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Admin Password</label>
                            <input type="text" name="password" class="form-control" value="{{ $admin->password ?? '' }}" required>
                            <small class="text-muted">You can change your password here directly.</small>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Update Admin Credentials</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
