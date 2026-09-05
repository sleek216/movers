@extends('admin.layouts.app')

@section('title', 'Platform Settings')

@section('content')
<div class="container-fluid">
    <div class="page-title py-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4 class="mb-0 fw-bold">Platform & App Settings</h4>
                <p class="text-muted mb-0">General configurations, Push Notifications, SMS, and Map keys</p>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    <!-- General Settings Section -->
                    <div class="col-12">
                        <h5 class="fw-bold border-bottom pb-2 text-primary">General Configuration</h5>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Platform Name</label>
                        <input type="text" name="webname" class="form-control" value="{{ $setting->webname ?? 'Movers Freight' }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Currency Symbol</label>
                        <input type="text" name="currency" class="form-control" value="{{ $setting->currency ?? '$' }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Timezone</label>
                        <input type="text" name="timezone" class="form-control" value="{{ $setting->timezone ?? 'Asia/Kolkata' }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Signup Referral Credit ($)</label>
                        <input type="number" name="scredit" class="form-control" value="{{ $setting->scredit ?? 0 }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Referrer Reward Credit ($)</label>
                        <input type="number" name="rcredit" class="form-control" value="{{ $setting->rcredit ?? 0 }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">App Logo</label>
                        @if($setting && $setting->weblogo)
                            <div class="mb-2">
                                <img src="{{ asset($setting->weblogo) }}" height="40" alt="Logo">
                            </div>
                        @endif
                        <input type="file" name="weblogo" class="form-control" accept="image/*">
                    </div>

                    <!-- Push Notification Keys -->
                    <div class="col-12 mt-4">
                        <h5 class="fw-bold border-bottom pb-2 text-primary">OneSignal Push Notifications</h5>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">User App OneSignal App ID</label>
                        <input type="text" name="one_key" class="form-control" value="{{ $setting->one_key ?? '' }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">User App REST API Key</label>
                        <input type="text" name="one_hash" class="form-control" value="{{ $setting->one_hash ?? '' }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Transporter / Driver App OneSignal App ID</label>
                        <input type="text" name="d_key" class="form-control" value="{{ $setting->d_key ?? '' }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Transporter / Driver App REST API Key</label>
                        <input type="text" name="d_hash" class="form-control" value="{{ $setting->d_hash ?? '' }}">
                    </div>

                    <!-- SMS & OTP Configuration -->
                    <div class="col-12 mt-4">
                        <h5 class="fw-bold border-bottom pb-2 text-primary">SMS & OTP Gateway (Twilio / Msg91)</h5>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">SMS Gateway Type</label>
                        <select class="form-select" name="sms_type">
                            <option value="0" {{ ($setting->sms_type ?? '') == '0' ? 'selected' : '' }}>Twilio</option>
                            <option value="1" {{ ($setting->sms_type ?? '') == '1' ? 'selected' : '' }}>Msg91</option>
                            <option value="2" {{ ($setting->sms_type ?? '') == '2' ? 'selected' : '' }}>Disabled</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Twilio Account SID / Auth Key</label>
                        <input type="text" name="acc_id" class="form-control" value="{{ $setting->acc_id ?? '' }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Twilio Auth Token</label>
                        <input type="text" name="auth_token" class="form-control" value="{{ $setting->auth_token ?? '' }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Twilio Phone Number</label>
                        <input type="text" name="twilio_number" class="form-control" value="{{ $setting->twilio_number ?? '' }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Require Mobile OTP on Registration?</label>
                        <select class="form-select" name="otp_auth">
                            <option value="Yes" {{ ($setting->otp_auth ?? '') == 'Yes' ? 'selected' : '' }}>Yes (Real SMS Verification)</option>
                            <option value="No" {{ ($setting->otp_auth ?? '') == 'No' ? 'selected' : '' }}>No (Demo Mode / Any OTP Allowed)</option>
                        </select>
                    </div>

                    <!-- 🤖 AI & Smart Search Engine Configuration -->
                    <div class="col-12 mt-4">
                        <div class="d-flex align-items-center justify-content-between border-bottom pb-2">
                            <h5 class="fw-bold mb-0 text-primary">
                                <i class="fas fa-brain me-2"></i>AI Route Engine & Map Settings
                            </h5>
                            <span class="badge bg-success px-3 py-2">Dynamic Multi-Engine</span>
                        </div>
                        <p class="text-muted small mt-1">Configure your preferred AI provider (Google Gemini or ChatGPT OpenAI) and Google Maps API keys for voice parsing and road navigation.</p>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Active AI Engine</label>
                        <select class="form-select fw-bold" name="ai_provider">
                            <option value="gemini" {{ ($setting->ai_provider ?? 'gemini') == 'gemini' ? 'selected' : '' }}>🌟 Google Gemini AI (Recommended)</option>
                            <option value="chatgpt" {{ ($setting->ai_provider ?? '') == 'chatgpt' ? 'selected' : '' }}>⚡ OpenAI / ChatGPT (GPT-4o mini)</option>
                            <option value="offline" {{ ($setting->ai_provider ?? '') == 'offline' ? 'selected' : '' }}>📱 Built-in Offline Regex Parser</option>
                        </select>
                        <small class="text-muted">Select which AI parses voice & natural text queries</small>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Google Gemini API Key</label>
                        <input type="text" name="gemini_api_key" class="form-control font-monospace" placeholder="AQ.Ab8RN... or AIzaSy..." value="{{ $setting->gemini_api_key ?? '' }}">
                        <small class="text-muted">Used when Active AI Engine is set to Google Gemini</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">OpenAI / ChatGPT API Key</label>
                        <input type="text" name="openai_api_key" class="form-control font-monospace" placeholder="sk-proj-..." value="{{ $setting->openai_api_key ?? '' }}">
                        <small class="text-muted">Used when Active AI Engine is set to ChatGPT</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Google Maps API Key (Places & Geocoding)</label>
                        <input type="text" name="google_map_key" class="form-control font-monospace" placeholder="AIzaSy..." value="{{ $setting->google_map_key ?? '' }}">
                        <small class="text-muted">Google Places & Geocoding key for micro-roads and addresses</small>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-primary px-4 py-2 fw-bold">
                        <i class="fas fa-save me-2"></i>Save All Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
