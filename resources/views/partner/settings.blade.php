@extends('partner.master')
@section('content')
<style>
.error { color:red !important; font-size:12px !important; }

/* ============ PAGE HEADER ============ */
.gl-page-header {
    display: flex; align-items: flex-start; justify-content: space-between;
    gap: 16px; padding: 8px 4px 20px; flex-wrap: wrap;
    font-family: 'Geist', -apple-system, BlinkMacSystemFont, sans-serif;
}
.gl-page-title { font-size: 24px; font-weight: 700; color: #0F172A; letter-spacing: -0.01em; margin: 0 0 4px 0; line-height: 1.2; }
.gl-page-subtitle { font-size: 13px; color: #475569; }

/* ============ SETTINGS LAYOUT ============ */
.gl-settings {
    --gl-surface: #FFFFFF;
    --gl-surface-2: #FAFAFB;
    --gl-border: #E7E9EE;
    --gl-border-soft: #F0F2F5;
    --gl-text: #0F172A;
    --gl-text-soft: #475569;
    --gl-text-muted: #94A3B8;
    --gl-accent: #1E3A5F;
    font-family: 'Geist', -apple-system, BlinkMacSystemFont, sans-serif;
    display: grid;
    grid-template-columns: 260px 1fr;
    background: var(--gl-surface);
    border: 1px solid var(--gl-border);
    border-radius: 8px;
    overflow: hidden;
}
@media (max-width: 900px) { .gl-settings { grid-template-columns: 1fr; } }

/* Vertical nav */
.gl-settings__nav {
    padding: 18px 14px;
    background: var(--gl-surface-2);
    border-right: 1px solid var(--gl-border-soft);
}
@media (max-width: 900px) {
    .gl-settings__nav { border-right: 0; border-bottom: 1px solid var(--gl-border-soft); }
}
.gl-settings__nav-label {
    font-size: 10.5px;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--gl-text-muted);
    font-weight: 600;
    padding: 0 12px 10px;
}
.gl-settings__nav .nav-link {
    display: flex; align-items: center; gap: 10px;
    width: 100%;
    padding: 10px 12px;
    margin-bottom: 2px;
    border: none; background: transparent;
    color: var(--gl-text-soft);
    font-family: inherit; font-size: 13px; font-weight: 500;
    text-align: left; border-radius: 7px;
    cursor: pointer;
    transition: background .15s ease, color .15s ease;
}
.gl-settings__nav .nav-link i {
    font-size: 16px; color: var(--gl-text-muted); width: 18px; line-height: 1; flex-shrink: 0;
}
.gl-settings__nav .nav-link:hover { background: #EEF2F8; color: var(--gl-accent); }
.gl-settings__nav .nav-link:hover i { color: var(--gl-accent); }
.gl-settings__nav .nav-link.active {
    background: var(--gl-accent); color: #fff;
    box-shadow: 0 1px 2px rgba(15,23,42,0.08);
}
.gl-settings__nav .nav-link.active i { color: #fff; }

/* Right panel */
.gl-settings__panel { padding: 24px 28px; background: var(--gl-surface); }
.gl-settings__panel-title {
    font-size: 15px; font-weight: 600; color: var(--gl-text); margin: 0 0 4px 0;
}
.gl-settings__panel-sub {
    font-size: 12.5px; color: var(--gl-text-muted); margin-bottom: 20px;
}

.gl-settings__panel .form-label {
    font-size: 12px; color: var(--gl-text-soft); font-weight: 500;
    margin-bottom: 6px; display: block;
}
.gl-settings__panel .form-control,
.gl-settings__panel .form-select {
    padding: 8px 12px;
    border: 1px solid var(--gl-border); border-radius: 6px;
    font-size: 13px; font-family: inherit;
    background: var(--gl-surface); color: var(--gl-text);
}
.gl-settings__panel .form-control:focus,
.gl-settings__panel .form-select:focus {
    border-color: var(--gl-accent); box-shadow: none; outline: none;
}

/* My Profile cards */
.gl-profile {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 24px;
}
@media (max-width: 900px) { .gl-profile { grid-template-columns: 1fr; } }
.gl-profile__card {
    background: #FAFBFD;
    border: 1px solid var(--gl-border-soft);
    border-radius: 10px;
    padding: 20px;
    text-align: center;
}
.gl-profile__avatar {
    width: 96px; height: 96px; border-radius: 50%;
    object-fit: cover; border: 3px solid #fff;
    box-shadow: 0 4px 12px rgba(15,23,42,0.08);
    margin-bottom: 12px;
}
.gl-profile__name {
    font-size: 16px; font-weight: 600; color: var(--gl-text); margin: 6px 0 2px;
}
.gl-profile__sub {
    font-size: 12px; color: var(--gl-text-muted);
    font-family: 'Geist Mono', monospace; letter-spacing: 0.04em;
    margin-bottom: 2px;
}
.gl-profile__org {
    font-size: 12px; color: var(--gl-text-soft); margin-bottom: 14px;
}
.gl-profile__stats {
    display: flex; gap: 8px; flex-wrap: wrap; justify-content: center;
    margin-top: 8px;
}
.gl-profile__stat {
    flex: 1; min-width: 80px;
    background: #fff; border: 1px solid var(--gl-border-soft);
    border-radius: 8px; padding: 10px 8px;
}
.gl-profile__stat-label {
    font-size: 10px; color: var(--gl-text-muted);
    text-transform: uppercase; letter-spacing: 0.06em; font-weight: 600;
    margin-bottom: 2px;
}
.gl-profile__stat-value {
    font-size: 18px; font-weight: 600; color: var(--gl-text);
    font-family: 'Geist Mono', monospace;
}

.gl-profile__details { padding: 4px; }
.gl-profile__row {
    display: grid;
    grid-template-columns: 140px 1fr;
    padding: 10px 0;
    border-bottom: 1px solid var(--gl-border-soft);
    font-size: 13.5px;
}
.gl-profile__row:last-child { border-bottom: 0; }
.gl-profile__row-label {
    color: var(--gl-text-muted); font-size: 12px; font-weight: 500;
    text-transform: uppercase; letter-spacing: 0.04em;
    align-self: center;
}
.gl-profile__row-value { color: var(--gl-text); font-weight: 500; }
.gl-profile__row-value.muted { color: var(--gl-text-muted); font-weight: 400; }

/* Verify badge */
.gl-pill {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 9px; border-radius: 999px;
    font-size: 11.5px; font-weight: 500;
}
.gl-pill.success { background: #ECFDF5; color: #059669; }
.gl-pill.warn { background: #FEF3C7; color: #B45309; }

/* Buttons */
.gl-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 14px; border-radius: 8px;
    font-size: 13px; font-weight: 500; line-height: 1.2;
    font-family: inherit; cursor: pointer;
    border: 1px solid transparent; white-space: nowrap;
    transition: background .15s ease, border-color .15s ease, color .15s ease;
}
.gl-btn i { font-size: 15px; line-height: 1; }
.gl-btn-primary { background: #1E3A5F; color: #fff; border-color: #1E3A5F; box-shadow: 0 1px 2px rgba(15,23,42,0.08); }
.gl-btn-primary:hover { background: #15294A; border-color: #15294A; color: #fff; }
.gl-btn-success { background: #059669; color: #fff; border-color: #059669; }
.gl-btn-success:hover { background: #04855B; border-color: #04855B; color: #fff; }
.gl-btn-outline { background: #FFFFFF; border-color: #E7E9EE; color: #0F172A; }
.gl-btn-outline:hover { background: #FAFAFB; border-color: #CBD5E1; }

/* Password show/hide eye */
.field-icon-eye {
    position: absolute; top: 50% !important; right: 10px; transform: translateY(-50%);
    cursor: pointer; color: var(--gl-text-muted); font-size: 14px;
}
.field-pwd { position: relative; }

/* Image preview thumb */
.gl-thumb {
    width: 72px; height: 72px;
    object-fit: cover; border-radius: 8px;
    border: 1px solid var(--gl-border);
}
</style>

<div class="page-content">
    <div class="container-fluid">

        <div class="gl-page-header">
            <div class="gl-page-header__text">
                <h1 class="gl-page-title">My Settings</h1>
                <div class="gl-page-subtitle">Manage your profile, security, and bank details.</div>
            </div>
        </div>

        @if(!empty($update_message))
            <div class="alert alert-warning d-flex alert-dismissible fade show" role="alert">
                <span>{!! $update_message !!}(Click <b>Edit Profile</b> Option)</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" style="font-size:16px;" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="gl-settings">

                    <aside class="gl-settings__nav">
                        <div class="gl-settings__nav-label">Profile</div>
                        <div class="nav flex-column" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-my-profile" type="button" role="tab" aria-selected="true">
                                <i class="bx bx-user"></i><span>My Profile</span>
                            </button>
                            <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-edit-profile" type="button" role="tab" aria-selected="false">
                                <i class="bx bx-edit-alt"></i><span>Edit Profile</span>
                            </button>
                            <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-password" type="button" role="tab" aria-selected="false">
                                <i class="bx bx-lock-alt"></i><span>Password &amp; Security</span>
                            </button>
                            <button class="nav-link" id="v-pills-verify-tab" data-bs-toggle="pill" data-bs-target="#v-pills-verification" type="button" role="tab" aria-selected="false">
                                <i class="bx bx-check-shield"></i><span>Email Verification</span>
                            </button>
                            <button class="nav-link" id="v-pills-account-tab" data-bs-toggle="pill" data-bs-target="#v-pills-account" type="button" role="tab" aria-selected="false">
                                <i class="bx bx-credit-card"></i><span>Bank Account Details</span>
                            </button>
                        </div>
                    </aside>

                    <div class="gl-settings__panel">
                        <div class="tab-content" id="v-pills-tabContent">

                            {{-- ===== MY PROFILE ===== --}}
                            <div class="tab-pane fade show active" id="v-pills-my-profile" role="tabpanel">
                                <h3 class="gl-settings__panel-title">My Profile</h3>
                                <div class="gl-settings__panel-sub">Your account overview and contact details.</div>

                                <div class="gl-profile">
                                    <div class="gl-profile__card">
                                        @if ($partner->photo == "")
                                            <img src="{{ url('/images/user_dummy.png') }}" class="gl-profile__avatar">
                                        @else
                                            <img src="{{ url('/uploads/partner').'/'.$partner->photo }}" class="gl-profile__avatar">
                                        @endif

                                        <div class="gl-profile__name">{{ \Str::upper($partner->name) }}</div>
                                        @if($partner->unique_id != null)
                                            <div class="gl-profile__sub">ID: {{ \Str::upper($partner->unique_id) }}</div>
                                        @endif
                                        <div class="gl-profile__org">{{ $partner->company_name ?: 'GL-Partner Associate' }}</div>

                                        <div class="gl-profile__stats">
                                            <div class="gl-profile__stat">
                                                <div class="gl-profile__stat-label">Total</div>
                                                <div class="gl-profile__stat-value">{{ $total_leads }}</div>
                                            </div>
                                            <div class="gl-profile__stat">
                                                <div class="gl-profile__stat-label">Open</div>
                                                <div class="gl-profile__stat-value">{{ $open_leads }}</div>
                                            </div>
                                            <div class="gl-profile__stat">
                                                <div class="gl-profile__stat-label">Closed</div>
                                                <div class="gl-profile__stat-value">{{ $business_leads }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="gl-profile__details">
                                        <div class="gl-profile__row">
                                            <div class="gl-profile__row-label">Name</div>
                                            <div class="gl-profile__row-value">{{ \Str::upper($partner->name) }}</div>
                                        </div>
                                        <div class="gl-profile__row">
                                            <div class="gl-profile__row-label">Company</div>
                                            <div class="gl-profile__row-value {{ $partner->company_name ? '' : 'muted' }}">{{ $partner->company_name ?: '—' }}</div>
                                        </div>
                                        <div class="gl-profile__row">
                                            <div class="gl-profile__row-label">Mobile</div>
                                            <div class="gl-profile__row-value {{ $partner->mobile ? '' : 'muted' }}">{{ $partner->mobile ? '+'.$partner->country_code.' '.$partner->mobile : '—' }}</div>
                                        </div>
                                        <div class="gl-profile__row">
                                            <div class="gl-profile__row-label">Email</div>
                                            <div class="gl-profile__row-value">
                                                {{ $partner->email ?: '—' }}
                                                @if($partner->email_verified_at)
                                                    <span class="gl-pill success" style="margin-left:8px;">Verified</span>
                                                @else
                                                    <span class="gl-pill warn" style="margin-left:8px;">Not verified</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="gl-profile__row">
                                            <div class="gl-profile__row-label">Website</div>
                                            <div class="gl-profile__row-value {{ $partner->website ? '' : 'muted' }}">{{ $partner->website ?: '—' }}</div>
                                        </div>
                                        <div class="gl-profile__row">
                                            <div class="gl-profile__row-label">Team Size</div>
                                            <div class="gl-profile__row-value {{ $partner->team_size ? '' : 'muted' }}">{{ $partner->team_size ?: '—' }}</div>
                                        </div>
                                        <div class="gl-profile__row">
                                            <div class="gl-profile__row-label">Country</div>
                                            <div class="gl-profile__row-value {{ $partner->country_name ? '' : 'muted' }}">{{ $partner->country_name ?: '—' }}</div>
                                        </div>
                                        <div class="gl-profile__row">
                                            <div class="gl-profile__row-label">State</div>
                                            <div class="gl-profile__row-value {{ $partner->state ? '' : 'muted' }}">{{ $partner->state ?: '—' }}</div>
                                        </div>
                                        <div class="gl-profile__row">
                                            <div class="gl-profile__row-label">City</div>
                                            <div class="gl-profile__row-value {{ $partner->city ? '' : 'muted' }}">{{ $partner->city ?: '—' }}</div>
                                        </div>
                                        <div class="gl-profile__row">
                                            <div class="gl-profile__row-label">Pin Code</div>
                                            <div class="gl-profile__row-value {{ $partner->pin_code ? '' : 'muted' }}">{{ $partner->pin_code ?: '—' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ===== EDIT PROFILE ===== --}}
                            <div class="tab-pane fade" id="v-pills-edit-profile" role="tabpanel">
                                <h3 class="gl-settings__panel-title">Edit Profile</h3>
                                <div class="gl-settings__panel-sub">Keep your contact and business details up to date.</div>

                                <form id="form-profile" action="{{ route('partner.update-profile') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" id="partner_id" name="partner_id" value="{{ $partner->id }}">
                                    <input type="hidden" id="country_name" name="country_name" value="{{ $partner->country_name }}">

                                    <div class="row">
                                        <div class="form-group col-md-6 mb-3">
                                            <label class="form-label">Name <span style="color:#DC2626;">*</span></label>
                                            <input type="text" class="form-control" id="partner_name" name="partner_name" value="{{ $partner->name }}" required>
                                        </div>
                                        <div class="form-group col-md-6 mb-3">
                                            <label class="form-label">Mobile <span style="color:#DC2626;">*</span></label><br>
                                            <input type="hidden" class="form-control" name="country_code" id="country_code" value="{{ $partner->country_code }}">
                                            <input type="text" class="form-control" name="mobile" id="mobile" value="{{ '+'.$partner->country_code.$partner->mobile }}" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6 mb-3">
                                            <label class="form-label">Email <span style="color:#DC2626;">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{ $partner->email }}" required>
                                        </div>
                                        <div class="form-group col-md-6 mb-3">
                                            <label class="form-label">Website</label>
                                            <input type="text" class="form-control" id="website" name="website" value="{{ $partner->website }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6 mb-3">
                                            <label class="form-label">Company Name <span style="color:#DC2626;">*</span></label>
                                            <input type="text" class="form-control" id="company_name" name="company_name" value="{{ $partner->company_name }}" required>
                                        </div>
                                        <div class="form-group col-md-6 mb-3">
                                            <label class="form-label">Team Size</label>
                                            <input type="number" class="form-control" id="team_size" name="team_size" value="{{ $partner->team_size }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-3 mb-3">
                                            <label class="form-label">Country <span style="color:#DC2626;">*</span></label>
                                            <select name="country" id="country" class="form-control">
                                                <option value="">select</option>
                                                @foreach($countries as $key=>$value)
                                                    <option value="{{ $key }}" @if($key==$partner->country)selected @endif>{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3 mb-3">
                                            <label class="form-label">State <span style="color:#DC2626;">*</span></label>
                                            <select name="state" id="state" class="form-control">
                                                <option value="">select</option>
                                                @foreach($states as $key=>$values)
                                                    <option value="{{ $values }}" @if($values==$partner->state)selected @endif>{{ $values }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3 mb-3">
                                            <label class="form-label">City <span style="color:#DC2626;">*</span></label>
                                            <input type="text" class="form-control" id="city" name="city" value="{{ $partner->city }}">
                                        </div>
                                        <div class="form-group col-md-3 mb-3">
                                            <label class="form-label">Pin Code <span style="color:#DC2626;">*</span></label>
                                            <input type="text" class="form-control" id="pin_code" name="pin_code" value="{{ $partner->pin_code }}">
                                        </div>
                                    </div>

                                    <div class="row align-items-center">
                                        <div class="form-group col-md-4 mb-3">
                                            <label class="form-label">Profile Photo</label>
                                            <input type="file" class="form-control" id="photo" name="photo">
                                        </div>
                                        <div class="form-group col-md-2 mb-3">
                                            @if ($partner->photo == null)
                                                <img src="/images/user_dummy.jpeg" id="photoUrl" class="gl-thumb">
                                            @else
                                                <img src="/uploads/partner/{{ $partner->photo }}" id="photoUrl" class="gl-thumb">
                                            @endif
                                        </div>
                                        <div class="form-group col-md-4 mb-3">
                                            <label class="form-label">Company Logo</label>
                                            <input type="file" class="form-control" id="logo" name="logo">
                                        </div>
                                        <div class="form-group col-md-2 mb-3">
                                            @if ($partner->company_logo == null)
                                                <img src="/images/user_dummy.jpeg" id="logoUrl" class="gl-thumb">
                                            @else
                                                <img src="/uploads/partner/{{ $partner->company_logo }}" id="logoUrl" class="gl-thumb">
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <button type="submit" class="gl-btn gl-btn-primary"><i class="bx bx-save"></i> Save Changes</button>
                                    </div>
                                </form>
                            </div>

                            {{-- ===== PASSWORD ===== --}}
                            <div class="tab-pane fade" id="v-pills-password" role="tabpanel">
                                <h3 class="gl-settings__panel-title">Password &amp; Security</h3>
                                <div class="gl-settings__panel-sub">Change the password you use to log in.</div>

                                <form id="changePasswordForm">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-md-6 mb-3">
                                            <label class="form-label">Current Password <span style="color:#DC2626;">*</span></label>
                                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6 mb-3">
                                            <label class="form-label">New Password <span style="color:#DC2626;">*</span></label>
                                            <div class="field-pwd">
                                                <input class="form-control" type="password" placeholder="Type your password here" name="new_password" id="new_password" minlength="5" maxlength="30" autocomplete="off" required>
                                                <span id="toggle_pwd" class="fa fa-fw fa-eye field-icon-eye"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6 mb-3">
                                            <label class="form-label">Confirm Password <span style="color:#DC2626;">*</span></label>
                                            <div class="field-pwd">
                                                <input class="form-control" type="password" placeholder="Type your password here" name="confirm_password" id="confirm_password" minlength="5" maxlength="30" autocomplete="off" required>
                                                <span id="conf_toggle_pwd" class="fa fa-fw fa-eye field-icon-eye"></span>
                                            </div>
                                            <label id="err-msg" style="color:#DC2626;font-size:12px;"></label>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <button type="submit" id="changePass" class="gl-btn gl-btn-primary"><i class="bx bx-save"></i> Change Password</button>
                                    </div>
                                </form>
                            </div>

                            {{-- ===== EMAIL VERIFICATION ===== --}}
                            <div class="tab-pane fade" id="v-pills-verification" role="tabpanel">
                                <h3 class="gl-settings__panel-title">Email Verification</h3>
                                <div class="gl-settings__panel-sub">Verify the email you receive lead notifications on.</div>

                                <div class="row">
                                    <div class="form-group col-md-6 mb-3">
                                        <label class="form-label" id="email-label">
                                            @if($partner->email_verified_at == null)
                                                Email you have provided
                                            @else
                                                Your email has been verified
                                            @endif
                                            @if($partner->email_verified_at)
                                                <span class="gl-pill success" style="margin-left:8px;">Verified</span>
                                            @else
                                                <span class="gl-pill warn" style="margin-left:8px;">Pending</span>
                                            @endif
                                        </label>
                                        <input type="email" class="form-control" id="verify-email" name="email" disabled value="{{ $partner->email }}" required>
                                    </div>
                                </div>

                                <div class="hide" id="otp_div">
                                    <div class="row">
                                        <div class="form-group col-md-6 mb-3">
                                            <label class="form-label">Enter the OTP received on the above mail-id</label>
                                            <input type="number" class="form-control" id="otp" placeholder="OTP" name="otp" value="" required>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" class="gl-btn gl-btn-success" id="verify_otp"><i class="bx bx-check-shield"></i> Verify OTP</button>
                                    </div>
                                </div>

                                <div>
                                    @if ($partner->email_verified_at == null)
                                        <button type="button" class="gl-btn gl-btn-primary mt-3" id="request_verification" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Sending OTP">
                                            <i class="bx bx-mail-send"></i> Request Verification
                                        </button>
                                    @endif
                                </div>
                            </div>

                            {{-- ===== BANK ACCOUNT ===== --}}
                            <div class="tab-pane fade" id="v-pills-account" role="tabpanel">
                                <h3 class="gl-settings__panel-title">Bank Account Details</h3>
                                <div class="gl-settings__panel-sub">Where payouts are credited.</div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <form id="accountDetails">
                                            @csrf
                                            <input type="hidden" name="partner_id" value="{{ $partner->id }}">

                                            <div class="form-group mb-3">
                                                <label class="form-label">Bank Name <span style="color:#DC2626;">*</span></label>
                                                <input type="text" class="form-control" id="bank_name" name="bank_name" value="{{ $partner->bank_name }}" required>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label">Branch Name <span style="color:#DC2626;">*</span></label>
                                                <input type="text" class="form-control" id="branch_name" name="branch_name" value="{{ $partner->branch }}" required>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label">IFSC Code <span style="color:#DC2626;">*</span></label>
                                                <input type="text" class="form-control" id="ifsc_code" name="ifsc_code" value="{{ $partner->ifsc }}" required>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label">Account Number <span style="color:#DC2626;">*</span></label>
                                                <input type="text" class="form-control" id="account_number" name="account_number" value="{{ $partner->account_number }}" required>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label">UPI ID</label>
                                                <input type="text" class="form-control" id="upi_id" name="upi_id" value="{{ $partner->upi_id }}">
                                            </div>
                                            <div class="mt-3">
                                                <button type="submit" class="gl-btn gl-btn-primary" id="update_account_details"><i class="bx bx-save"></i> Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

@push('scripts')

@if (Session::get('success'))
    <script>
        toastr.options = { "closeButton": true, "progressBar": true };
        toastr.success("Your profile has been updated successfully !!!");
    </script>
@endif

<script type="text/javascript">
$("#toggle_pwd").click(function () {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $("#new_password");
    input.attr("type", input.attr("type") === "password" ? "text" : "password");
});

$("#conf_toggle_pwd").click(function () {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $("#confirm_password");
    input.attr("type", input.attr("type") === "password" ? "text" : "password");
});

var phone_number = window.intlTelInput(document.querySelector("#mobile"), {
    separateDialCode: true,
    preferredCountries: ["in"],
    hiddenInput: "full_number",
    utilsScript: "{{ url('assets/intl-tel-input17.0.3/utils.js') }}"
});

$("#form-profile").submit(function () {
    var code = phone_number.getSelectedCountryData()['dialCode'];
    $("#country_code").val(code);
});

$(function () { toastr.options = { "showDuration": "300000", "hideMethod": "fadeOut" }; });

photo.onchange = evt => {
    const [file] = photo.files;
    var allowed = /(\.jpg|\.jpeg|\.jpe|\.png)$/i;
    if (!allowed.exec(file.name)) {
        alert('Invalid file type, Try again.');
        $("#photoUrl").prop('src', '');
    } else if (file) {
        photoUrl.src = URL.createObjectURL(file);
    }
};

logo.onchange = evt => {
    const [file] = logo.files;
    var allowed = /(\.jpg|\.jpeg|\.jpe|\.png)$/i;
    if (!allowed.exec(file.name)) {
        alert('Invalid file type, Try again.');
        $("#logoUrl").prop('src', '');
    } else if (file) {
        logoUrl.src = URL.createObjectURL(file);
    }
};

$("#country").on('change', function () {
    var country = $(this).val();
    var country_name = ($.trim($('#country option:selected').text()) != "select") ? $('#country option:selected').text() : null;
    $("#country_name").val(country_name);
    $.ajax({
        url: "{{ route('country-states') }}",
        method: 'get',
        data: { 'country': country },
        success: function (result) {
            if (result.states) {
                $('#state').empty();
                $('#state').append('<option value="">select</option>');
                $.each(result.states, function (key, value) {
                    $('#state').append('<option value="' + value + '">' + value + '</option>');
                });
            }
        }
    });
});

$('#changePasswordForm').validate({
    submitHandler: function (form) {
        $("#err-msg").html('');
        if ($("#new_password").val() != $("#confirm_password").val()) {
            $("#err-msg").html('<span>Confirm password is not matching.</span>');
            return;
        }
        $.ajax({
            url: "{{ route('partner.change-password') }}",
            method: 'post',
            data: $('#changePasswordForm').serialize(),
            success: function (result) {
                if (result.status == 1) {
                    toastr.success(result.msg);
                    $('#changePasswordForm')[0].reset();
                } else {
                    toastr.error(result.msg);
                }
            }
        });
    }
});

$("#request_verification").on('click', function () {
    var $this = $(this);
    $this.attr('disabled', true).html('Sending <i class="fa fa-spinner fa-spin"></i>');
    $.ajax({
        url: "{{ route('partner.send-otp') }}",
        type: 'post',
        data: {
            '_token': '{{ csrf_token() }}',
            'partner_id': $("#partner_id").val(),
            'email_id':   $("#verify-email").val()
        },
        success: function (result) {
            if (result.status == 1) {
                toastr.success(result.msg);
                $("#otp_div").removeClass('hide');
                $this.addClass('hide');
            } else {
                toastr.error(result.msg);
            }
        }
    });
});

$("#verify_otp").on('click', function () {
    if ($.trim($("#otp").val()) == "") {
        toastr.error("Otp missing, Try again.!");
        return;
    }
    $.ajax({
        url: "{{ route('partner.verify-otp') }}",
        method: 'post',
        data: {
            '_token': '{{ csrf_token() }}',
            'partner_id': $("#partner_id").val(),
            'otp':        $("#otp").val(),
        },
        success: function (result) {
            if (result.status == 1) {
                $("#email-label").html("Your email has been verified");
                $("#otp_div").addClass('hide');
                toastr.success(result.msg);
            } else {
                toastr.error(result.msg);
            }
        }
    });
});

$("form#accountDetails").on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        url: "{{ route('partner.update-account-details') }}",
        type: 'post',
        dataType: 'json',
        data: $('#accountDetails').serialize(),
        success: function (result) {
            if (result.status == 1) {
                toastr.success('Details updated successfully !!!');
            } else {
                toastr.error(result.msg);
            }
        }
    });
});
</script>
@endpush
@endsection
