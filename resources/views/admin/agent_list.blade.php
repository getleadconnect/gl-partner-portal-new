@extends('admin.master')
@section('content')
<style>
.error { color:red !important; font-size:12px !important; }

/* ============ AGENTS — PAGE HEADER ============ */
.gl-page-header {
    display: flex; align-items: flex-start; justify-content: space-between;
    gap: 16px; padding: 8px 4px 20px; flex-wrap: wrap;
    font-family: 'Geist', -apple-system, BlinkMacSystemFont, sans-serif;
}
.gl-page-title { font-size: 24px; font-weight: 700; color: #0F172A; letter-spacing: -0.01em; margin: 0 0 4px 0; line-height: 1.2; }
.gl-page-subtitle { font-size: 13px; color: #475569; }

/* ============ AGENTS — LAYOUT ============ */
.gl-agents-grid {
    display: grid;
    grid-template-columns: 360px 1fr;
    gap: 20px;
    font-family: 'Geist', -apple-system, BlinkMacSystemFont, sans-serif;
}
@media (max-width: 1100px) {
    .gl-agents-grid { grid-template-columns: 1fr; }
}

.gl-card {
    background: #FFFFFF;
    border: 1px solid #E7E9EE;
    border-radius: 8px;
    box-shadow: 0 1px 2px rgba(15,23,42,0.04);
    overflow: hidden;
}
.gl-card-header {
    padding: 14px 20px;
    border-bottom: 1px solid #F0F2F5;
    display: flex; align-items: center; justify-content: space-between;
}
.gl-card-header .title { font-size: 14px; font-weight: 600; color: #0F172A; }
.gl-card-header .subtitle { font-size: 12px; color: #94A3B8; margin-top: 2px; }

/* ============ AGENTS — FORM ============ */
.gl-form { padding: 22px 24px; }
.gl-form h3 {
    font-size: 14px; font-weight: 600; margin-bottom: 18px; color: #0F172A;
}
.gl-form .field { margin-bottom: 14px; }
.gl-form label {
    display: block; font-size: 12px; font-weight: 500;
    color: #475569; margin-bottom: 6px;
}
.gl-form label .req { color: #DC2626; }
.gl-form input, .gl-form select {
    width: 100%; padding: 8px 12px;
    border: 1px solid #E7E9EE; border-radius: 6px;
    font-size: 13px; font-family: inherit;
    background: #FFFFFF; color: #0F172A; outline: none;
    transition: border-color .15s ease;
}
.gl-form input:focus, .gl-form select:focus { border-color: #1E3A5F; }
.gl-form .field-pwd { position: relative; }
.gl-form .field-pwd .toggle-eye {
    position: absolute; top: 50%; right: 10px;
    transform: translateY(-50%); cursor: pointer;
    color: #94A3B8; font-size: 14px;
}
.gl-form .hint { font-size: 11px; color: #94A3B8; margin-top: 5px; }
.gl-form .form-actions {
    display: flex; gap: 8px; margin-top: 8px; justify-content: flex-end;
}
.gl-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 14px; border-radius: 8px;
    font-size: 13px; font-weight: 500; line-height: 1.2;
    font-family: inherit; cursor: pointer;
    border: 1px solid transparent; white-space: nowrap;
    transition: background .15s ease, border-color .15s ease, color .15s ease;
}
.gl-btn-outline { background: #FFFFFF; border-color: #E7E9EE; color: #0F172A; }
.gl-btn-outline:hover { background: #FAFAFB; border-color: #CBD5E1; }
.gl-btn-primary { background: #1E3A5F; color: #fff; border-color: #1E3A5F; box-shadow: 0 1px 2px rgba(15,23,42,0.08); }
.gl-btn-primary:hover { background: #15294A; border-color: #15294A; color: #fff; }

/* ============ AGENTS — TABLE ============ */
.gl-agents {
    --gl-surface: #FFFFFF;
    --gl-surface-2: #FAFAFB;
    --gl-border: #E7E9EE;
    --gl-border-soft: #F0F2F5;
    --gl-text: #0F172A;
    --gl-text-soft: #475569;
    --gl-text-muted: #94A3B8;
    padding:10px;
}
.gl-agents table.data { width: 100%; border-collapse: collapse; font-size: 13px; }
.gl-agents table.data thead tr { background: var(--gl-surface-2); }
.gl-agents table.data thead th {
    padding: 10px 16px; text-align: left;
    font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em;
    color: var(--gl-text-muted); font-weight: 600;
    border-bottom: 1px solid var(--gl-border-soft); white-space: nowrap;
}
.gl-agents table.data thead th.num { text-align: right; }
.gl-agents table.data tbody td {
    padding: 12px 16px; border-bottom: 1px solid var(--gl-border-soft);
    color: var(--gl-text-soft); vertical-align: middle; background: var(--gl-surface);
}
.gl-agents table.data tbody tr:hover td { background: #FAFBFC; }
.gl-agents table.data td.num { font-family: 'Geist Mono', monospace; text-align: right; font-variant-numeric: tabular-nums; }
.gl-agents table.data td.num.strong { color: var(--gl-text); font-weight: 600; }

.gl-agents .row-avatar { display: inline-flex; align-items: center; gap: 10px; }
.gl-agents .row-avatar .av {
    width: 32px; height: 32px; border-radius: 50%;
    display: grid; place-items: center; font-size: 11px; font-weight: 600;
    color: #fff; flex-shrink: 0; letter-spacing: 0.02em;
}
.gl-agents .row-avatar .av.c1 { background: #1E3A5F; }
.gl-agents .row-avatar .av.c2 { background: #059669; }
.gl-agents .row-avatar .av.c3 { background: #B68B3C; }
.gl-agents .row-avatar .av.c4 { background: #DC2626; }
.gl-agents .row-avatar .av.c5 { background: #475569; }
.gl-agents .row-avatar .av.c6 { background: #2C5282; }
.gl-agents .row-avatar .nm { line-height: 1.25; }
.gl-agents .row-avatar .nm .name { color: var(--gl-text); font-weight: 500; font-size: 13px; }
.gl-agents .row-avatar .nm .sub { color: var(--gl-text-muted); font-size: 11px; margin-top: 2px; font-family: 'Geist Mono', monospace; }

/* Row action buttons (icons) */
.gl-agents .row-action { display: inline-flex; gap: 6px; justify-content: flex-end; }
.gl-agents .row-action-btn {
    width: 32px; height: 32px;
    border: 1px solid var(--gl-border); background: var(--gl-surface);
    border-radius: 50%;
    display: inline-flex; align-items: center; justify-content: center;
    color: var(--gl-text-soft); cursor: pointer; padding: 0;
    transition: background .15s ease, border-color .15s ease, color .15s ease;
}
.gl-agents .row-action-btn i { font-size: 15px; line-height: 1; }
.gl-agents .row-action-btn:hover {
    background: #EEF2F8; border-color: #1E3A5F; color: #1E3A5F;
}
.gl-agents .row-action-btn.danger:hover {
    background: #FEE2E2; border-color: #DC2626; color: #DC2626;
}

.gl-agents .empty-row td { text-align: center; padding: 24px; color: var(--gl-text-muted); }
</style>

<div class="page-content">
    <div class="container-fluid">

        <div class="gl-page-header">
            <div class="gl-page-header__text">
                <h1 class="gl-page-title">Agents</h1>
                <div class="gl-page-subtitle">Internal team members who manage partners and close deals.</div>
            </div>
        </div>

        <div class="gl-agents-grid">

            {{-- ADD AGENT FORM --}}
            <div class="gl-card">
                <div class="gl-form">
                    <h3>Add new agent</h3>

                    <form id="addAgentForm" autocomplete="off">
                        @csrf

                        <div class="field">
                            <label>Full Name <span class="req">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="e.g. John Doe" autocomplete="off" required>
                        </div>

                        <div class="field">
                            <label>Email <span class="req">*</span></label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="agent@getlead.co.uk" autocomplete="off" required>
                            <div class="hint">Used for login.</div>
                        </div>

                        <div class="field">
                            <label>Mobile <span class="req">*</span></label>
                            <input type="number" name="mobile" id="mobile" value="{{ old('mobile') }}" placeholder="+91 …" minlength="6" maxlength="15" required>
                        </div>

                        <div class="field">
                            <label>Password <span class="req">*</span></label>
                            <div class="field-pwd">
                                <input type="password" name="password" id="password" minlength="5" maxlength="30" autocomplete="off" required>
                                <span id="toggle_pwd" class="fa fa-fw fa-eye toggle-eye"></span>
                            </div>
                            <div class="hint">Agent can reset on first login.</div>
                        </div>

                        <div class="field">
                            <label>Confirm Password <span class="req">*</span></label>
                            <div class="field-pwd">
                                <input type="password" name="confirm_password" id="confirm_password" minlength="5" maxlength="30" autocomplete="off" required>
                                <span id="conf_toggle_pwd" class="fa fa-fw fa-eye toggle-eye"></span>
                            </div>
                            <label id="conf_password" class="error" for="confirm_password"></label>
                        </div>

                        <div class="form-actions">
                            <button type="reset" class="gl-btn gl-btn-outline">Reset</button>
                            <button type="submit" id="btnSubmit" class="gl-btn gl-btn-primary">
                                <i class="bx bx-user-plus"></i> Send Invite
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- AGENTS TABLE --}}
            <div class="gl-card">
                <div class="gl-card-header">
                    <div>
                        <div class="title">Active agents</div>
                        <div class="subtitle">{{ $total_agents ?? 0 }} total · {{ $assigned_agents ?? 0 }} assigned to partners</div>
                    </div>
                </div>
                <div class="table-responsive gl-agents">
                    <table id="agent-table" class="data" style="width:100% !important;">
                        <thead>
                            <tr>
                                <th>Agent</th>
                                <th>Mobile</th>
                                <th class="num">Partners</th>
                                <th class="num">Leads · Open</th>
                                <th>Joined</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
</div>

{{-- Edit agent modal --}}
<div class="modal fade" id="edit-agent-modal" tabindex="-1" aria-labelledby="editAgentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAgentModalLabel">Edit Agent</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

@push('scripts')

<script type="text/javascript">
$(function () {
    toastr.options = { "showDuration": "300000", "hideMethod": "fadeOut" };
});

$("#toggle_pwd").click(function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $("#password");
    input.attr("type", input.attr("type") === "password" ? "text" : "password");
});

$("#conf_toggle_pwd").click(function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $("#confirm_password");
    input.attr("type", input.attr("type") === "password" ? "text" : "password");
});

$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});

$(function() {

    var table = $('#agent-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.agents') }}",
        language: { searchPlaceholder: 'Search', sSearch: '', emptyTable: 'No agents yet — add your first one on the left.' },
        columns: [
            { data: 'agent',            name: 'agent',            orderable: false, searchable: false },
            { data: 'mobile_fmt',       name: 'mobile_fmt',       orderable: false, searchable: false },
            { data: 'partners_count',   name: 'partners_count',   orderable: false, searchable: false, className: 'num strong' },
            { data: 'open_leads_count', name: 'open_leads_count', orderable: false, searchable: false, className: 'num strong' },
            { data: 'joined',           name: 'joined',           orderable: false, searchable: false },
            { data: 'action',           name: 'action',           orderable: false, searchable: false, className: 'text-end' },
        ]
    });

    var addAgent = $('#addAgentForm').validate({
        rules: {
            name:             { required: true },
            mobile:           { required: true, minlength: 6, maxlength: 15 },
            email:            { required: true, email: true },
            password:         { minlength: 6 },
            confirm_password: { minlength: 6, equalTo: "#password" },
        },
        submitHandler: function(form) {
            if ($("#password").val() !== $("#confirm_password").val()) {
                $("#conf_password").html("Confirm password is not matching.").css('display','block');
                return;
            }
            $("#btnSubmit").attr('disabled', true).html('Saving <i class="fa fa-spinner fa-spin"></i>');
            $.ajax({
                url: "{{ route('admin.create-agent') }}",
                method: 'post',
                data: $('#addAgentForm').serialize(),
                success: function(result) {
                    if (result.status == 1) {
                        table.ajax.reload();
                        $("#addAgentForm")[0].reset();
                        toastr.success(result.msg);
                    } else {
                        toastr.error(result.msg);
                    }
                    $("#btnSubmit").attr('disabled', false).html('<i class="bx bx-user-plus"></i> Send Invite');
                },
                error: function() {
                    $("#btnSubmit").attr('disabled', false).html('<i class="bx bx-user-plus"></i> Send Invite');
                    toastr.error('Could not save agent, please try again.');
                }
            });
        }
    });

    // EDIT — load existing edit_agent_admin modal partial
    $("#agent-table tbody").on('click', '.edit_agent', function () {
        var id = $(this).attr('id');
        var Result = $("#edit-agent-modal .modal-body");
        jQuery.ajax({
            type: "GET",
            url:  "{{ url('admin/edit-agent') }}/" + id,
            dataType: 'html',
            success: function(res) { Result.html(res); }
        });
    });

    // DELETE — SweetAlert confirm
    $("#agent-table tbody").on('click', '.confirm_agent_deletion', function () {
        var agentId = $(this).data('id');
        Swal.fire({
            title: 'Delete this agent?',
            text:  'This action cannot be undone. Partners currently assigned to this agent will be unassigned.',
            icon:  'warning',
            showCancelButton:  true,
            confirmButtonText: 'Yes, delete',
            cancelButtonText:  'Cancel',
            confirmButtonColor: '#DC2626',
            cancelButtonColor:  '#94A3B8',
            reverseButtons:     true,
        }).then(function (result) {
            if (!result.isConfirmed) return;
            $.ajax({
                url: "{{ route('admin.delete-agent') }}",
                type: 'post',
                dataType: 'json',
                data: { '_token':'{{ csrf_token() }}', 'agent_id': agentId },
                success: function(result) {
                    if (result.status == 1) {
                        table.ajax.reload();
                        toastr.success("Agent successfully removed!");
                    } else {
                        toastr.error('Could not delete the agent.');
                    }
                },
                error: function() {
                    toastr.error('Could not delete the agent, please try again.');
                }
            });
        });
    });

});
</script>

@endpush
@endsection
