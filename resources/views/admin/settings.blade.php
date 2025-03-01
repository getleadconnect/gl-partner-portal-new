@extends('admin.master')
@section('content')

<style>

.card-body{	padding:10px 15px !important; }

.error{	color:red !important; 
		font-size:12px !important;
	}
.nav-pills .nav-link{ width:200px !important; }

.table > :not(caption) > * > * {
	padding: 0.35rem 0.35rem !important;
 }

.noti-status
{
	font-weight:600;
	width:125px;
}

</style>

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Settings</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                                <li class="breadcrumb-item active">Settings</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
			
			<div class="row">
                <div class="col-12">
                    <div class="card">
                       <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Settings</h5>
                                <div>
								<!-- content here ---------->
                                </div>
                            </div>
                        </div>
                        <div class="card-body mb-5">
						
						<div class="vertical-nav">
							
							<div class="d-flex align-items-start" >
							  <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical" style="padding-right:50px;border-right:1px solid #e4e4e4;">
								<button class="nav-link active mb-2 text-left" id="v-pills-password-tab" data-bs-toggle="pill" data-bs-target="#v-pills-password" type="button" role="tab" aria-controls="v-pills-my-profile" aria-selected="true"><i class="fa fa-user"></i>&nbsp;&nbsp;Change Password</button>
								<button class="nav-link text-left mb-2" id="v-pills-notification-tab" data-bs-toggle="pill" data-bs-target="#v-pills-notification" type="button" role="tab" aria-controls="v-pills-edit-profile" aria-selected="false"><i class="fa fa-edit"></i>&nbsp;&nbsp;Notification Settings</button>
								<button class="nav-link text-left mb-2" id="v-pills-lead-status-tab" data-bs-toggle="pill" data-bs-target="#v-pills-lead-status" type="button" role="tab" aria-controls="v-pills-password" aria-selected="false"><i class="fas fa-stream"></i>&nbsp;&nbsp;Lead Status</button>
								<button class="nav-link text-left mb-2" id="v-pills-billing-tab" data-bs-toggle="pill" data-bs-target="#v-pills-billing" type="button" role="tab" aria-controls="v-pills-verification" aria-selected="false"><i class="fa fa-dollar"></i>&nbsp;&nbsp;Billing Settings</button>
								<button class="nav-link text-left mb-2" id="v-pills-help-tab" data-bs-toggle="pill" data-bs-target="#v-pills-help" type="button" role="tab" aria-controls="v-pills-account" aria-selected="false"><i class="fa fa-question-circle"></i>&nbsp;&nbsp;Admin email/Whatsapp No</button>
							  </div>
							
 							  <div class="tab-content" id="v-pills-tabContent" style="padding-left:30px;width:100%;">
								<!--- TAB -1 ----------->
								
								<div class="tab-pane fade show active" id="v-pills-password" role="tabpanel" aria-labelledby="v-pills-my-profile-tab">
								
								<label class="mb-3"><b><u>Change Password</u></b></label>
								
								
								<form id="changeAdminPassword" autocomplete=off>
									@csrf
										<div class="form-group">
										<div class="row">
										<div class="col-lg-6 col-xl-6 col-xxl-6">
											<label for="current_password" class="form-label">Current Password</label>
											<input type="text" class="form-control" id="current_password" name="current_password" autocomplete=off required="">
										</div>
										</div>
										</div>
										<div class="form-group">
										<div class="row">
										<div class="col-lg-6 col-xl-6 col-xxl-6">
											<label for="new_password" class="form-label">New Password</label>
											<input type="password" class="form-control" id="new_password" minlength=6 name="new_password" autocomplete=off required="">
										</div>
										</div></div>
										<div class="form-group">
										<div class="row">
										<div class="col-lg-6 col-xl-6 col-xxl-6">
											<label for="confirm_password" class="form-label">Confirm Password</label>
											<input type="password" class="form-control" id="confirm_password" minlength=6 name="confirm_password" autocomplete=off required="">
										</div>
										</div></div>
										<button type="submit" class="btn btn-primary mt-3">Save Changes</button>
									</form>
	
																
								</div>
								<!---- TAB-2 EDIT PROFILE ---------->					
								<div class="tab-pane fade" id="v-pills-notification" role="tabpanel" aria-labelledby="v-pills-edit-profile-tab">
								
								<label class="mb-3"><b><u>Change Notification Status</u></b></label>
								
								<form id="notificationStatus">
								 @csrf
									<div class="mb-3">
										<label for="email-notifications" class="form-label">Email Notifications</label>
										
										<select class="form-select noti-status" id="email-status" name="email-status" required>
											<option value="1" @if($noti->email_status==1){{ __('selected')}}@endif >Enabled</option>
											<option value="0" @if($noti->email_status==0){{ __('selected')}}@endif>Disabled</option>
										</select>
										
									</div>
									
									<div class="mb-3">
										<label for="email-notifications" class="form-label">WhatsApp Notifications</label>
										<select class="form-select noti-status" id="whatsapp-status" name="whatsapp-status" required>
											<option value="1" @if($noti->whatsapp_status==1){{ __('selected')}}@endif>Enabled</option>
											<option value="0" @if($noti->whatsapp_status==0){{ __('selected')}}@endif>Disabled</option>
										</select>
									</div>
									
									<div class="mb-3">
										<label for="sms-notifications" class="form-label">Telegram Notifications</label>
										<select class="form-select noti-status" id="telegram-status" name="telegram-status" required>
											<option value="1" @if($noti->telegram_status==1){{ __('selected')}}@endif>Enabled</option>
											<option value="0" @if($noti->telegram_status==0){{ __('selected')}}@endif>Disabled</option>
										</select>
									</div>
									<button type="button" id="btnNotificationStatus" class="btn btn-primary">Save Changes</button>
								</form>

								</div>
								
								<!--- TAB 3 CHANGE PASSWORD --------------------------->
										
								<div class="tab-pane fade" id="v-pills-lead-status" role="tabpanel" aria-labelledby="v-pills-lead-status-tab">
									
									<div class="row">
									<div class="col-lg-5 col-xl-5 col-xxl-5">
										<label class="mb-3"><b><u>Add Lead Status</u></b></label>
									
									<div class="mb-3">
										<label for="sms-notifications" class="form-label">Lead Status</label>
										<input type="text" class="form-control" id="lead_status" name="lead_sttaus" required>
									</div>
									<button type="button" id="btnAddLeadStatus" class="btn btn-primary">Add Status</button>
									
									</div>
									<div class="col-lg-7 col-xl-7 col-xxl-7">
									
									<table id="lead-status-table" class="table table-striped table-hover table-nowrap mb-0" style="width:100% !important;">
										<thead>
										<tr >
											<th>No</th>
											<th>Lead Status</th>
											<th></th>
										</tr>
											
										</thead>
										<tbody>
										
										@foreach($lstatus as $key=>$r)
										<tr >
											<td>{{++$key}}</td>
											<td>{{$r->lead_status}}</td>
											@if($r->lead_status!="New" and $r->lead_status!="Got Business")
												<td><button type="button" class="btn btn-outline delete-lead-status" id="{{$r->id}}"><i class="fa fa-trash"></i></button></td>
											@endif
										</tr>
										@endforeach
										</tbody>
									</table>
																		
									</div>
									</div>
								
								</div>

								<!--- TAB 4 CHANGE PASSWORD --------------------------->
								
								<div class="tab-pane fade" id="v-pills-billing" role="tabpanel" aria-labelledby="v-pills-billing-tab">
									<label class="mb-3"><b><u>Billing Settings</u></b></label>

								</div>
								
								<!-- TAB-5 ACCOUNT SETTINGS ------------------------>
								
								<div class="tab-pane fade" id="v-pills-help" role="tabpanel" aria-labelledby="v-pills-help-tab">
									<label class="mb-3"><b><u>Help</u></b></label>
									<div id="noti_settings">
									
									</div>
								</div>
							
							</div>
  
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


