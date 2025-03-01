@extends('admin.master')
@section('content')

<style>

.card-body{	padding:10px 15px !important; }

.error{	color:red !important; 
		font-size:12px !important;
	}
.nav-pills .nav-link{ width:210px !important; }

.table > :not(caption) > * > * {
	padding: 0.35rem 0.35rem !important;
 }

.noti-status
{
	font-weight:600;
	width:125px;
}

#noti_settings .h1, h1 {
    font-size: 1.25rem !important;
}

#noti_settings .h2, h2 {
    font-size: 1rem !important;
}

.col-tb-width
{
	width:100px !important;
}
.dropdown-toggle::after
{
	display:none !important;
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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
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
							  <button class="nav-link active mb-2 text-left" id="v-pills-password-tab" data-bs-toggle="pill" data-bs-target="#v-pills-password" type="button" role="tab"  aria-selected="true"><i class="fa fa-user"></i>&nbsp;&nbsp;Change Password</button>
							  <button class="nav-link text-left mb-2" id="v-pills-lead-status-tab" data-bs-toggle="pill" data-bs-target="#v-pills-lead-status" type="button" role="tab"  aria-selected="false"><i class="fas fa-stream"></i>&nbsp;&nbsp;Lead Status</button>
							  <button class="nav-link text-left mb-2" id="v-pills-billing-tab" data-bs-toggle="pill" data-bs-target="#v-pills-billing" type="button" role="tab"  aria-selected="false"><i class="fa fa-tasks"></i>&nbsp;&nbsp;Product Plans</button>
							  <button class="nav-link text-left mb-2" id="v-pills-business-category-tab" data-bs-toggle="pill" data-bs-target="#v-pills-business-category" type="button" role="tab"  aria-selected="false"><i class="fa fa-question-circle"></i>&nbsp;&nbsp;Business Category</button>
							  <button class="nav-link text-left mb-2" id="v-pills-email-whatsappno-tab" data-bs-toggle="pill" data-bs-target="#v-pills-email-whatsappno" type="button" role="tab"  aria-selected="false"><i class="fa fa-question-circle"></i>&nbsp;&nbsp;Email/Whatsapp No</button>
							</div>
							
							
 							  <div class="tab-content" id="v-pills-tabContent" style="width:100%;">
								<!--- TAB -1 ----------->
								
								<div class="tab-pane fade show active" id="v-pills-password" role="tabpanel" aria-labelledby="v-pills-my-profile-tab">
								
								<label class="mb-3"><b><u>Change Password</u></b></label>
								
								
								<form id="changeAdminPassword" autocomplete=off>
									@csrf
										<div class="form-group">
										<div class="row">
										<div class="col-lg-6 col-xl-6 col-xxl-6">
											<label for="current_password" class="form-label">Current Password<span class="text-red">*</span></label>
											<input type="text" class="form-control" id="current_password" name="current_password" autocomplete=off required="">
										</div>
										</div>
										</div>
										<div class="form-group">
										<div class="row">
										<div class="col-lg-6 col-xl-6 col-xxl-6">
											<label for="new_password" class="form-label">New Password<span class="text-red">*</span></label>
											<div style="position:relative;">
											    <input class="form-control form-control-solid h-auto" type="password"
												placeholder="Type your password here" name="new_password" id="new_password" minlength=5 maxlength=30 autocomplete="off" required />
												<span id="toggle_pwd" class="fa fa-fw field-icon-eye fa-eye mt-5"></span>
											</div>
										</div>
										</div></div>
										<div class="form-group">
										<div class="row">
										<div class="col-lg-6 col-xl-6 col-xxl-6">
											<label for="confirm_password" class="form-label">Confirm Password<span class="text-red">*</span></label>
											<div style="position:relative;">
											    <input class="form-control form-control-solid h-auto" type="password"
												placeholder="Type your password here" name="confirm_password" id="confirm_password" minlength=5 maxlength=30 autocomplete="off" required />
												<span id="conf_toggle_pwd" class="fa fa-fw field-icon-eye fa-eye mt-5"></span>
											</div>
										</div>
										</div></div>
										<button type="submit" class="btn btn-primary mt-3">Save Changes</button>
									</form>
	
																
								</div>
								

								<!--- TAB 3 LEAD STATUS --------------------------->
										
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
									
									<label class="mb-3"><b><u>Lead Statuses</u></b></label>
									
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
												<td>
													<button type="button" class="btn btn-outline delete-lead-status" id="{{$r->id}}"><i class="fa fa-trash"></i></button></td>
											@endif
										</tr>
										@endforeach
										
										</tbody>
									</table>
																		
									</div>
									</div>
								
								</div>

								<!--- TAB 4 PRODUCT AND SERVICE PLAN --------------------------->
								
								<div class="tab-pane fade" id="v-pills-billing" role="tabpanel" aria-labelledby="v-pills-billing-tab">
												
									<div class="row">
									<div class="col-lg-5 col-xl-5 col-xxl-5">
										<label class="mb-3"><b><u>Add Plan</u></b></label>
									
									<form id="formAddPlan">
									@csrf
									<div class="form-group">
										<label for="sms-notifications" class="form-label">Plan Name</label>
										<input type="text" class="form-control" id="plan_name" name="plan_name" required>
									</div>
									
									<div class="form-group">
									<div class="row">
									<div class="col-lg-6 col-xl-6 col-xxl-6">
										<label for="sms-notifications" class="form-label">Type</label>
										<select name="plan_type" class="form-control" required>
										<option value="1">Product</option>
										<option value="2">Service</option>
										</select>
									</div>
									
									<div class="col-lg-6 col-xl-6 col-xxl-6">
										<label for="sms-notifications" class="form-label">Users</label>
										<input type="number" class="form-control" name="users" required>
									</div>
									</div>
									</div>
									
									
									<div class="form-group">
									<div class="row">
									<div class="col-lg-6 col-xl-6 col-xxl-6">
										<label for="sms-notifications" class="form-label">Month</label>
										<input type="number" class="form-control" name="month" required>
									</div>
									
									<div class="col-lg-6 col-xl-6 col-xxl-6">
										<label for="sms-notifications" class="form-label">Price</label>
										<input type="number" class="form-control" id="price" name="price" required>
									</div>
									</div>
									</div>
									
									<button type="submit" id="btnAddPlan" class="btn btn-primary mt-3">Save Plan</button>
									
									</form>
									
									</div>
									<div class="col-lg-7 col-xl-7 col-xxl-7">
									
									<label class="mb-3"><b><u>Plan List</u></b></label>
									
									<table id="plans-table" class="table table-resposive table-striped table-hover dataTable " style="width:100% !important;">
										<thead>
										<tr >
											<th>No</th>
											<th>Plan_Name</th>
											<th>Type</th>
											<th>Users</th>
											<th>Month</th>
											<th>Price</th>
											<th>&nbsp;</th>
											<th></th>
										</tr>
											
										</thead>
										<tbody>

										
										</tbody>
									</table>
																		
									</div>
									</div>
		

								</div>
								
								<!-- TAB-5 HELP DETAILS ------------------------>
								
								<div class="tab-pane fade" id="v-pills-business-category" role="tabpanel" aria-labelledby="v-pills-help-tab">
									<label class="mb-3"><b><u>Help</u></b></label>
									
									
									<div class="row">
									<div class="col-lg-5 col-xl-5 col-xxl-5">
										<label class="mb-3"><b><u>Add Business Category</u></b></label>
									
									<form id="formAddBusiness">
									@csrf
									<div class="form-group">
										<label for="sms-notifications" class="form-label">Category Name</label>
										<input type="text" class="form-control" id="business_category_name" name="business_category_name" required>
									</div>
									
									<button type="submit" id="btnAddBusiness" class="btn btn-primary mt-3">Save Category</button>
									
									</form>
									
									</div>
									<div class="col-lg-7 col-xl-7 col-xxl-7">
									
									<label class="mb-3"><b><u>Plan List</u></b></label>
									
									<table id="business-category-table" class="table table-resposive table-striped table-hover dataTable " style="width:100% !important;">
										<thead>
										<tr >
											<th>No</th>
											<th>Business Category</th>
											<th>&nbsp;</th>
										</tr>
											
										</thead>
										<tbody>
										
									
										
										</tbody>
									</table>
																		
									</div>
									</div>

								</div>

								<div class="tab-pane fade" id="v-pills-email-whatsappno" role="tabpanel" aria-labelledby="v-pills-email-whatsappno-tab">
									<label class="mb-3"><b><u>Add Admin Email and WhatsApp No</u></b></label>
									
									
									<div class="row">
									<div class="col-lg-6 col-xl-6 col-xxl-6">
										<label class="mb-3">To set the email and WhatsApp number of Admin for send the notifications.</label>
									
									<form id="formEmailWhatsappNo">
									@csrf
									<div class="form-group">
										<label for="sms-notifications" class="form-label">Admin Email<span class="text-red">*</span></label>
										<input type="text" class="form-control" id="admin_email" name="admin_email" placeholder="test@gmail.com"  value="{{$ams->email??''}}" required>
									</div>
									
									<div class="form-group">
										<label for="sms-notifications" class="form-label">Admin Whatsapp No(include country code)<span class="text-red">*</span></label>
										<input type="text" class="form-control" id="admin_whatsapp_no" name="admin_whatsapp_no" placeholder="919845673200"  value="{{$ams->whatsapp_no??''}}" required>
									</div>
									
									<button type="submit" class="btn btn-primary mt-3"> Update </button>
									
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
	  
	</div> <!-- container-fluid -->
</div> <!-- End Page-content -->

<div class="modal fade" id="edit-plan-modal" tabindex="-1" aria-labelledby="addPartnerModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" >Edit</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
			
				<form id="formUpdatePlan">
				@csrf
				
					<input type="hidden" class="form-control" id="plan_id_edit" name="plan_id_edit" >
					
					<div class="form-group">
						<label for="sms-notifications" class="form-label">Plan Name</label>
						<input type="text" class="form-control" id="plan_name_edit" name="plan_name_edit" required>
					</div>
					
					<div class="form-group">
					<div class="row">
					<div class="col-lg-6 col-xl-6 col-xxl-6">
						<label for="sms-notifications" class="form-label">Type</label>
						<select name="plan_type_edit" id="plan_type_edit" class="form-control" required>
						<option value="1">Product</option>
						<option value="2">Service</option>
						</select>
					</div>
					
					<div class="col-lg-6 col-xl-6 col-xxl-6">
						<label for="sms-notifications" class="form-label">Users</label>
						<input type="number" class="form-control" name="users_edit" id="users_edit" required>
					</div>
					</div>
					</div>
					
					<div class="form-group">
					<div class="row">
					<div class="col-lg-6 col-xl-6 col-xxl-6">
						<label for="sms-notifications" class="form-label">Month</label>
						<input type="number" class="form-control" name="month_edit" id="month_edit" required>
					</div>
					
					<div class="col-lg-6 col-xl-6 col-xxl-6">
						<label for="sms-notifications" class="form-label">Price</label>
						<input type="number" class="form-control" id="price_edit" name="price_edit" required>
					</div>
					</div>
					</div>
					
					<div class="modal-footer" style="text-align:right;">
						<button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
						<button type="submit" id="btnPayment"  class="btn btn-primary">Update</button>
					</div>
					
				</form>

			</div>
			
		
		</div>
	</div>	
</div>


<div class="modal fade" id="edit-business-category" tabindex="-1" aria-labelledby="addPartnerModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" >Edit</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
			
				<form id="formUpdateBusiness">
				@csrf
				
					<input type="hidden" class="form-control" id="bcat_id_edit" name="bcat_id_edit" >
					
					<div class="form-group">
						<label for="sms-notifications" class="form-label">Category Name</label>
						<input type="text" class="form-control" id="business_category_name_edit" name="business_category_name_edit" required>
					</div>
										
					<div class="modal-footer" style="text-align:right;">
						<button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
						<button type="submit" id="btnBusinessUpdate"  class="btn btn-primary">Update</button>
					</div>
					
				</form>

			</div>
			
		
		</div>
	</div>	
</div>


@push('scripts')


<script>

$("#toggle_pwd").click(function() 
{
  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $("#new_password");
  if (input.attr("type") === "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});


$("#conf_toggle_pwd").click(function() 
{
  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $("#confirm_password");
  if (input.attr("type") === "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});


var table = $('#plans-table').DataTable({
            processing: true,
            serverSide: true,
			stateStatus: true,
			bAutoWidth: false,
			pageLength:10,
			"language": {
				searchPlaceholder: 'Search',
				sSearch: '',
			},
			"lengthMenu": [10, 25, 50,100,150,200],
			
            ajax: {
                url: "{{ route('admin.list-product-plans') }}",
                data: function (d) 
                {
                    //d.status = $('#filter_status').val(),
                }
            },
            columns: [
	        {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
            {data: 'plan_name', name: 'plan_name'},
			{data: 'type', name: 'type'},
            {data: 'users', name: 'users'},
			{data: 'month', name: 'month'},
			{data: 'pricing', name: 'pricing'},
            {data: 'action', name: 'action',},
            ],

        });
		
table.columns.adjust().draw();
 

var table2 = $('#business-category-table').DataTable({
            processing: true,
            serverSide: true,
			stateStatus: true,
			bAutoWidth: false,
			pageLength:10,
			"language": {
				searchPlaceholder: 'Search',
				sSearch: '',
			},
			"lengthMenu": [10, 25, 50,100,150,200],
			
            ajax: {
                url: "{{ route('admin.list-business-category') }}",
                data: function (d) 
                {
                    //d.status = $('#filter_status').val(),
                }
            },
            columns: [
	        {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
            {data: 'bussiness_category_name', name: 'bussiness_category_name'},
			{data: 'action', name: 'action',},
            ],

        });


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


$('#formAddPlan').validate({ 
	rules: {
		
	},
	
	submitHandler: function(form) 
	{
		$("#btnAddPlan").attr('disabled',true).html('Saving <i class="fa fa-spinner fa-spin"></i>');

		var formData=new FormData(document.getElementById('formAddPlan'));

			$.ajax({
				url: "{{ route('admin.save-plan')}}",
				type: 'post',
				dataType:'json',
				data: formData,
				success: function(res){
					if(res.status == 1)
					{
						
						toastr.success(res.msg);
						table.ajax.reload();
						$("#btnAddPlan").attr('disabled',false).html('Save Plan');
						$("#formAddPlan")[0].reset();

					}
					else{
						toastr.error(res.msg);
						$("#btnAddPlan").attr('disabled',false).html('Save Plan');
					}
				},
				cache: false,
				contentType: false,
				processData: false
			});
		}

});

$("#plans-table tbody").on('click','.confirm-plan-deletion',function()
{
	var id=$(this).attr('id');
	var tr=$(this).closest('tr');
		$.ajax({
			url: "{{ url('admin/delete-plan')}}"+"/"+id,
			type: 'get',
			//data:{ '_token':'{{csrf_token()}}','lead_status':lst},
			success: function(result){
				toastr.success(result.msg);
				tr.remove();
			}
		});
});


$("#plans-table tbody").on('click','.edit-plan',function()
{
	var id=$(this).attr('id');
	var tr=$(this).closest('tr');
	
	var plan=$(this).closest('tr').find('td').eq(1).text();
	
	var type=$(this).closest('tr').find('td').eq(2).text();
	var user=$(this).closest('tr').find('td').eq(3).text();
	var month=$(this).closest('tr').find('td').eq(4).text();
	var price=$(this).closest('tr').find('td').eq(5).text();
	
	$("#plan_id_edit").val(id);
	$("#plan_name_edit").val(plan);
	$("#plan_type_edit").val(type);
	$("#users_edit").val(user);
	$("#month_edit").val(month);
	$("#price_edit").val(price);
	
});


$('#formUpdatePlan').validate({ 
	rules: {
		
	},
	
	submitHandler: function(form) 
	{
		
		var formData=new FormData(document.getElementById('formUpdatePlan'));

			$.ajax({
				url: "{{ route('admin.update-plan')}}",
				type: 'post',
				dataType:'json',
				data: formData,
				success: function(res){
					if(res.status == 1)
					{
						toastr.success(res.msg);
						$("#edit-plan-modal").modal('hide');
						table.ajax.reload();
					}
					else{
						toastr.error(res.msg);
					}
				},
				cache: false,
				contentType: false,
				processData: false
				
			});
		}

});

//BUSINESS CATEGORY ---------------------------------------------------------


$('#formAddBusiness').validate({ 
	rules: {
		
	},
	
	submitHandler: function(form) 
	{
		$("#btnAddBusiness").attr('disabled',true).html('Saving <i class="fa fa-spinner fa-spin"></i>');

		var formData=new FormData(document.getElementById('formAddBusiness'));

			$.ajax({
				url: "{{ route('admin.save-business-category')}}",
				type: 'post',
				dataType:'json',
				data: formData,
				success: function(res){
					if(res.status == 1)
					{
						toastr.success(res.msg);
						table2.ajax.reload();
						$("#btnAddBusiness").attr('disabled',false).html('Save Category');
						$("#formAddBusiness")[0].reset();
					}
					else{
						toastr.error(res.msg);
						$("#btnAddBusiness").attr('disabled',false).html('Save Category');
					}
				},
				cache: false,
				contentType: false,
				processData: false
				
			});
		}

});

$("#business-category-table tbody").on('click','.edit-business',function()
{
	var id=$(this).attr('id');
	
	var bname=$(this).closest('tr').find('td').eq(1).text();

	$("#bcat_id_edit").val(id);
	$("#business_category_name_edit").val(bname);
});


$('#formUpdateBusiness').validate({ 
	rules: {
		
	},
	
	submitHandler: function(form) 
	{
		
		var formData=new FormData(document.getElementById('formUpdateBusiness'));

			$.ajax({
				url: "{{ route('admin.update-business-category')}}",
				type: 'post',
				dataType:'json',
				data: formData,
				success: function(res){
					if(res.status == 1)
					{
						toastr.success(res.msg);
						$("#edit-business-category").modal('hide');
						table2.ajax.reload();
					}
					else{
						toastr.error(res.msg);
					}
				},
				cache: false,
				contentType: false,
				processData: false
				
			});
		}

});


$("#business-category-table tbody").on('click','.confirm-business-deletion',function()
{
	var id=$(this).attr('id');
	var tr=$(this).closest('tr');
		$.ajax({
			url: "{{ url('admin/delete-business-category')}}"+"/"+id,
			type: 'get',
			//data:{ '_token':'{{csrf_token()}}','lead_status':lst},
			success: function(result){
				toastr.success(result.msg);
				tr.remove();
			}
		});
});

$('#formEmailWhatsappNo').validate({ 
	rules: {
		
	},
	
	submitHandler: function(form) 
	{
		
		var formData=new FormData(document.getElementById('formEmailWhatsappNo'));

			$.ajax({
				url: "{{ route('admin.update-email-whatsapp-no')}}",
				type: 'post',
				dataType:'json',
				data: formData,
				success: function(res){
					if(res.status == 1)
					{
						toastr.success(res.msg);
					}
					else{
						toastr.error(res.msg);
					}
				}
				,
				cache: false,
				contentType: false,
				processData: false
				
			});
		}

});
//--------------------------------------------------------------------------------



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
			$("#update_lead").attr('disabled',true).html('Updating <i class="fa fa-spinner fa-spin"></i>');
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
					$("#update_lead").attr('disabled',false).html('Save Changes');
				}
			},
			cache: false,
			contentType: false,
			processData: false
			
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


</script>


@endpush
@endsection


