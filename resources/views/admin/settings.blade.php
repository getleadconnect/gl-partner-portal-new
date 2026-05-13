@extends('admin.master')
@section('content')

<style>
.error { color:red !important; font-size:12px !important; }

/* ============ SETTINGS — PAGE HEADER ============ */
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
    gap: 0;
    background: var(--gl-surface);
    border: 1px solid var(--gl-border);
    border-radius: 8px;
    overflow: hidden;
}
@media (max-width: 900px) {
    .gl-settings { grid-template-columns: 1fr; }
}

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
    border: none;
    background: transparent;
    color: var(--gl-text-soft);
    font-family: inherit;
    font-size: 13px;
    font-weight: 500;
    text-align: left;
    border-radius: 7px;
    cursor: pointer;
    transition: background .15s ease, color .15s ease;
}
.gl-settings__nav .nav-link i {
    font-size: 16px;
    color: var(--gl-text-muted);
    width: 18px;
    line-height: 1;
    flex-shrink: 0;
}
.gl-settings__nav .nav-link:hover {
    background: #EEF2F8;
    color: var(--gl-accent);
}
.gl-settings__nav .nav-link:hover i { color: var(--gl-accent); }
.gl-settings__nav .nav-link.active {
    background: var(--gl-accent);
    color: #fff;
    box-shadow: 0 1px 2px rgba(15,23,42,0.08);
}
.gl-settings__nav .nav-link.active i { color: #fff; }

/* Right panel */
.gl-settings__panel {
    padding: 24px 28px;
    background: var(--gl-surface);
}
.gl-settings__panel-title {
    font-size: 15px;
    font-weight: 600;
    color: var(--gl-text);
    margin: 0 0 4px 0;
}
.gl-settings__panel-sub {
    font-size: 12.5px;
    color: var(--gl-text-muted);
    margin-bottom: 20px;
}
.gl-settings__panel .form-label {
    font-size: 12px;
    color: var(--gl-text-soft);
    font-weight: 500;
    margin-bottom: 6px;
    display: block;
}
.gl-settings__panel .form-control,
.gl-settings__panel .form-select {
    padding: 8px 12px;
    border: 1px solid var(--gl-border);
    border-radius: 6px;
    font-size: 13px;
    font-family: inherit;
    background: var(--gl-surface);
    color: var(--gl-text);
}
.gl-settings__panel .form-control:focus,
.gl-settings__panel .form-select:focus {
    border-color: var(--gl-accent);
    box-shadow: none;
    outline: none;
}
.gl-settings__panel .noti-status { font-weight: 500; max-width: 170px; }

/* gl-btn primitives */
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
.gl-btn-outline { background: #FFFFFF; border-color: #E7E9EE; color: #0F172A; }
.gl-btn-outline:hover { background: #FAFAFB; border-color: #CBD5E1; }

/* Lead-status mini table inside the panel */
.gl-settings__panel table { width: 100%; border-collapse: collapse; font-size: 13px; }
.gl-settings__panel table thead tr { background: var(--gl-surface-2); }
.gl-settings__panel table thead th {
    padding: 8px 12px; text-align: left;
    font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em;
    color: var(--gl-text-muted); font-weight: 600;
    border-bottom: 1px solid var(--gl-border-soft);
}
.gl-settings__panel table tbody td {
    padding: 10px 12px;
    border-bottom: 1px solid var(--gl-border-soft);
    color: var(--gl-text-soft);
}
.gl-settings__panel .row-action-btn {
    width: 28px; height: 28px;
    border: 1px solid var(--gl-border); background: var(--gl-surface);
    border-radius: 6px;
    display: inline-flex; align-items: center; justify-content: center;
    color: var(--gl-text-soft); cursor: pointer; padding: 0;
    transition: all .15s ease;
}
.gl-settings__panel .row-action-btn:hover {
    background: #FEE2E2; border-color: #DC2626; color: #DC2626;
}
.gl-settings__panel .row-action-btn i { font-size: 14px; }
</style>

    <div class="page-content">
        <div class="container-fluid">

            <div class="gl-page-header">
                <div class="gl-page-header__text">
                    <h1 class="gl-page-title">Settings</h1>
                    <div class="gl-page-subtitle">Account preferences, lead pipeline, and notifications.</div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="gl-settings">

                        <aside class="gl-settings__nav">
                            <div class="gl-settings__nav-label">Account</div>
                            <div class="nav flex-column" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <button class="nav-link active" id="v-pills-password-tab" data-bs-toggle="pill" data-bs-target="#v-pills-password" type="button" role="tab" aria-selected="true">
                                    <i class="bx bx-lock-alt"></i><span>Change Password</span>
                                </button>
                                <button class="nav-link" id="v-pills-notification-tab" data-bs-toggle="pill" data-bs-target="#v-pills-notification" type="button" role="tab" aria-selected="false">
                                    <i class="bx bx-bell"></i><span>Notification Settings</span>
                                </button>
                                <button class="nav-link" id="v-pills-lead-status-tab" data-bs-toggle="pill" data-bs-target="#v-pills-lead-status" type="button" role="tab" aria-selected="false">
                                    <i class="bx bx-list-ul"></i><span>Lead Status</span>
                                </button>

								<button class="nav-link" id="v-pills-partner-tier-tab" data-bs-toggle="pill" data-bs-target="#v-pills-partner-tier" type="button" role="tab" aria-selected="false">
                                    <i class="bx bx-list-ul"></i><span>Partner Tiers</span>
                                </button>

                                <button class="nav-link" id="v-pills-billing-tab" data-bs-toggle="pill" data-bs-target="#v-pills-billing" type="button" role="tab" aria-selected="false">
                                    <i class="bx bx-credit-card"></i><span>Billing Settings</span>
                                </button>
                                <button class="nav-link" id="v-pills-help-tab" data-bs-toggle="pill" data-bs-target="#v-pills-help" type="button" role="tab" aria-selected="false">
                                    <i class="bx bx-help-circle"></i><span>Admin Email / WhatsApp</span>
                                </button>
                            </div>
                        </aside>

                        <div class="gl-settings__panel">
                            <div class="tab-content" id="v-pills-tabContent" style="width:100%;">
								<!--- TAB -1 ----------->
								
								<div class="tab-pane fade show active" id="v-pills-password" role="tabpanel" aria-labelledby="v-pills-password-tab">

								<h3 class="gl-settings__panel-title">Change Password</h3>
								<div class="gl-settings__panel-sub">Update your administrator login password.</div>

								<form id="changeAdminPassword" autocomplete=off>
									@csrf
									<div class="form-group mb-3">
										<div class="row">
										<div class="col-lg-6 col-xl-6 col-xxl-6">
											<label for="current_password" class="form-label">Current Password</label>
											<input type="text" class="form-control" id="current_password" name="current_password" autocomplete=off required>
										</div>
										</div>
									</div>
									<div class="form-group mb-3">
										<div class="row">
										<div class="col-lg-6 col-xl-6 col-xxl-6">
											<label for="new_password" class="form-label">New Password</label>
											<input type="password" class="form-control" id="new_password" minlength=6 name="new_password" autocomplete=off required>
										</div>
										</div>
									</div>
									<div class="form-group mb-3">
										<div class="row">
										<div class="col-lg-6 col-xl-6 col-xxl-6">
											<label for="confirm_password" class="form-label">Confirm Password</label>
											<input type="password" class="form-control" id="confirm_password" minlength=6 name="confirm_password" autocomplete=off required>
										</div>
										</div>
									</div>
									<button type="submit" class="gl-btn gl-btn-primary mt-3"><i class="bx bx-save"></i> Save Changes</button>
								</form>

								</div>
								<!---- TAB-2 EDIT PROFILE ---------->					
								<div class="tab-pane fade" id="v-pills-notification" role="tabpanel" aria-labelledby="v-pills-notification-tab">

								<h3 class="gl-settings__panel-title">Notification Settings</h3>
								<div class="gl-settings__panel-sub">Enable or disable per-channel admin notifications.</div>

								<form id="notificationStatus">
								 @csrf
									<div class="mb-3">
										<label class="form-label">Email Notifications</label>
										<select class="form-select noti-status" id="email-status" name="email-status" required>
											<option value="1" @if($noti->email_status==1)selected @endif>Enabled</option>
											<option value="0" @if($noti->email_status==0)selected @endif>Disabled</option>
										</select>
									</div>

									<div class="mb-3">
										<label class="form-label">WhatsApp Notifications</label>
										<select class="form-select noti-status" id="whatsapp-status" name="whatsapp-status" required>
											<option value="1" @if($noti->whatsapp_status==1)selected @endif>Enabled</option>
											<option value="0" @if($noti->whatsapp_status==0)selected @endif>Disabled</option>
										</select>
									</div>

									<div class="mb-3">
										<label class="form-label">Telegram Notifications</label>
										<select class="form-select noti-status" id="telegram-status" name="telegram-status" required>
											<option value="1" @if($noti->telegram_status==1)selected @endif>Enabled</option>
											<option value="0" @if($noti->telegram_status==0)selected @endif>Disabled</option>
										</select>
									</div>
									<button type="button" id="btnNotificationStatus" class="gl-btn gl-btn-primary"><i class="bx bx-save"></i> Save Changes</button>
								</form>

								</div>
								
								<!--- TAB 3 CHANGE PASSWORD --------------------------->
										
								<div class="tab-pane fade" id="v-pills-lead-status" role="tabpanel" aria-labelledby="v-pills-lead-status-tab">

								<h3 class="gl-settings__panel-title">Lead Status</h3>
								<div class="gl-settings__panel-sub">Manage the lead pipeline stages used across the portal.</div>

								<div class="row">
									<div class="col-lg-5 col-xl-5 col-xxl-5">
										<div class="mb-3">
											<label for="lead_status" class="form-label">New Status</label>
											<input type="text" class="form-control" id="lead_status" name="lead_status" placeholder="e.g. Proposal Sent" required>
										</div>
										<button type="button" id="btnAddLeadStatus" class="gl-btn gl-btn-primary"><i class="bx bx-plus"></i> Add Status</button>
									</div>
									<div class="col-lg-7 col-xl-7 col-xxl-7">
										<table id="lead-status-table" style="width:100% !important;">
											<thead>
												<tr>
													<th style="width:50px;">No</th>
													<th>Lead Status</th>
													<th style="width:50px;"></th>
												</tr>
											</thead>
											<tbody>
											@foreach($lstatus as $key=>$r)
												<tr>
													<td>{{ ++$key }}</td>
													<td>{{ $r->lead_status }}</td>
													<td>
													@if($r->lead_status!="New" and $r->lead_status!="Got Business")
														<button type="button" class="row-action-btn delete-lead-status" id="{{ $r->id }}" title="Delete status"><i class="bx bx-trash"></i></button>
													@endif
													</td>
												</tr>
											@endforeach
											</tbody>
										</table>
									</div>
								</div>

								</div>

								<!--- TAB 4 CHANGE PASSWORD --------------------------->
								
								<div class="tab-pane fade" id="v-pills-billing" role="tabpanel" aria-labelledby="v-pills-billing-tab">
									<h3 class="gl-settings__panel-title">Billing Settings</h3>
									<div class="gl-settings__panel-sub">Payout cadence, GST and bank-detail rules.</div>
									<div style="color:var(--gl-text-muted);font-size:13px;">Coming soon.</div>
								</div>

								<div class="tab-pane fade" id="v-pills-help" role="tabpanel" aria-labelledby="v-pills-help-tab">
									<h3 class="gl-settings__panel-title">Admin Email / WhatsApp</h3>
									<div class="gl-settings__panel-sub">Where new partner / lead alerts get delivered.</div>
									<div id="noti_settings"></div>
								</div>

							</div>
						</div>

                    </div>
                </div>
            </div>

        </div> <!-- container-fluid -->
    </div> <!-- End Page-content -->

@push('scripts')
<script>

$("#btnAddLeadStatus").click(function()
{
	var lst=$("#lead_status").val();

	$.ajax({
			url: "{{ route('admin.save-lead-status')}}",
			type: 'post',
			data:{ '_token':'{{csrf_token()}}','lead_status':lst},
			success: function(result){
				if(result.status == 1)
				{
					var slno=$('#lead-status-table').find('tr').last().find('td').eq(0).text();
					slno=parseInt(slno)+1;
					var tr="<tr><td>"+slno+"</td><td>"+lst+"</td><td><button type='button' class='btn btn-outline delete-lead-status' id='"+result.id+"'><i class='fa fa-trash'></i></button></tr>";
					$("#lead-status-table tbody").append(tr);
					$("#lead_status").val('');						
					toastr.success(result.msg);
				}
				else{
					toastr.error(result.msg);
				}
			}
		});

});

$("#lead-status-table tbody").on('click','.delete-lead-status',function()
{
	var id=$(this).attr('id');
	var tr=$(this).closest('tr');
	if(confirm("Delete this lead status?"))
	{
		$.ajax({
			url: "{{ url('admin/delete-lead-status')}}"+"/"+id,
			type: 'get',
			//data:{ '_token':'{{csrf_token()}}','lead_status':lst},
			success: function(result){
				toastr.success(result.msg);
				tr.remove();
			}
		});
	}
});

$(document).ready(function()
{
	$('#changeAdminPassword').validate({ 
		rules: {
			current_password: {
				required: true
			},
			new_password: {
				required: true,
				minlength:6,
			},
			confirm_password: {
				required: true,
				minlength:6,
				equalTo:'#new_password',
			},
			minlength: {
				required: true,
				minlength: 6
			},
		},
		
		submitHandler: function(form) 
		{
			$("#update_lead").attr('disabled',true).html('Updating <i class="fa fa-spinner fa-spin"></i>')
			$.ajax({
			url: "{{ route('admin.update-admin-password') }}",
			method: 'post',
			data: $('#changeAdminPassword').serialize(),
			success: function(result){
				if(result.status == 1)
				{
					toastr.success(result.msg);
				}
				else{
					toastr.error(result.msg);
				}
			}
			});
		  }
	});
	
});

$("#btnNotificationStatus").click(function()
{
	
	var ema=$("#email-status").val();
	var wapp=$("#whatsapp-status").val();
	var tele=$("#telegram-status").val();
	
	jQuery.ajax({
			type: "post",
			url: "{{url('admin/change-notification-status')}}",
			dataType: 'json',
			data: {'_token':"{{csrf_token()}}",email_status:ema, wapp_status:wapp,tele_status:tele},
			success: function(res)
			{
			   if(res.status==1)
			   {
				   toastr.success("Notification status successfully changed");
			   }
			}
		});
	
});


$(document).on('click',"#v-pills-help-tab",function()
{
	alert("ok");
	jQuery.ajax({
			type: "get",
			url: "{{url('notification-manager/config')}}",
			dataType: 'html',
			success: function(res)
			{
			   $("#noti_settings").html(res);
			}
		});
});



</script>


@endpush
@endsection


