@extends('admin.master')
@section('content')
<style>
.error
{
	color:red !important;
	font-size:12px !important;
}

</style>
 <div class="page-content">
        <div class="container-fluid">

            <!-- Start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Agents</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                                <li class="breadcrumb-item active">Agents</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Details</h5>
                                <div>
									<!--<button id="btnOffcanvas" class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Add Agent</button>-->
                                </div>
                            </div>
                        </div>
                        <div class="card-body mt-1 pt-0">
   							
							<div class="row">
							<div class="col-lg-4 col-xl-4 col-xxl-4">
							
							<label><b><u>Add Agent</u></b></label>
							
							<div style="background:#efefef;padding:15px;">
							
							<form id="addAgentForm"  autocomplete=off>
							  @csrf
								<div class="form-group">
									<label for="recipient-name" class="form-label">Name<span style="color: red;">*</span></label>
									<input type="text" class="form-control" placeholder=""
									value="{{ old('name') }}" name="name" id="name" autocomplete=off required>
								</div>
									
								<div class="form-group">
									<label for="recipient-name" class="form-label">Mobile<span style="color: red;">*</span></label>
									<input type="number" class="form-control" placeholder="" 
									value="{{ old('mobile') }}" name="mobile" id="mobile" minlength=6 maxlength=15 required>
								</div>
							
								<div class="form-group">
									<label for="recipient-name" class="form-label">Email<span style="color: red;">*</span></label>
									<input type="text" class="form-control" placeholder=""
									value="{{ old('email') }}" name="email" id="email" autocomplete=off required>
								</div>
								
								<div class="form-group">
									<label for="recipient-name" class="form-label">Password</label>
									<div style="position:relative;">
										<input class="form-control form-control-solid h-auto" type="password"
										placeholder="Type your password here" name="password" id="password" minlength=5 maxlength=30 autocomplete="off" required />
										<span id="toggle_pwd" class="fa fa-fw field-icon-eye fa-eye mt-5"></span>
									</div>
								</div>
								
								<div class="form-group">
									<label for="recipient-name" class="form-label">Confirm Password</label>
									<div style="position:relative;">
										<input class="form-control form-control-solid h-auto" type="password"
										placeholder="Type your password here" name="confirm_password" id="confirm_password" minlength=5 maxlength=30 autocomplete="off" required />
										<span id="conf_toggle_pwd" class="fa fa-fw field-icon-eye fa-eye mt-5"></span>
									</div>
									<label id="conf_password" class="error" for="confirm_password"></label>
								</div>
								
								<div class="form-group mb-3" style="text-align:right;">
									<button type="submit" id="btnSubmit" class="btn btn-primary">Submit</button>
								</div>
							
							  </form>
						
							</div>
							

						</div>
							
							<div class="col-lg-8 col-xl-8 col-xxl-8">
							<label><b><u>Agents List</u></b></label>
								<div class="table-responsive">
								  <table id="agent-table" class="table table-striped table-hover table-nowrap mb-0" style="width:100% !important;">
										<thead>
										  
										<tr>
										  <th>No</th>
										  <th>Name</th>
										  <th>Email</th>
										  <th>Mobile</th>
										  <th>Action</th>
										</tr>
											
										</thead>
										<tbody>
									   
										</tbody>
									</table>
								</div>
							</div>
							</div> <!-- end row -------->
							
                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- container-fluid -->
    </div>	<!-- End Page-content -->
    	
		
            <!-- edit agent Modal -->
            <div class="modal fade" id="edit-agent-modal" tabindex="-1" aria-labelledby="addPartnerModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addPartnerModalLabel">Edit Agent</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            
                        </div>
                    </div>
                </div>
            </div>

	

@push('scripts')

<script type="text/javascript">
    $(function () {
    toastr.options = {
        // "positionClass": "toast-top-right cp",
        "showDuration": "300000",
        "hideMethod": "fadeOut"
        }
    });
			

</script>

 <script type="text/javascript">
 
 $("#toggle_pwd").click(function() 
{
  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $("#password");
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


$(function() {

var table = $('#agent-table').DataTable({
	processing: true,
	serverSide: true,
	ajax: "{{ route('admin.agents') }}",
	columns: [{
			data: 'DT_RowIndex',
			name: 'DT_RowIndex',
			orderable: false,
			searchable: false
		},
		{ data: 'name', name: 'name' },
		{ data: 'email',name: 'email' },
		{ data: 'mobile',name: 'mobile' },
		{ data: 'action',name: 'action',className: 'text-center'},
	]
});

$("#invite_partner").on('click', function() {
	$("#create_agent_modal").modal('show')
})


$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});


	var addAgent=$('#addAgentForm').validate({
			
			rules: {
                    name: { 
                        required: true
                    },
                    
                    mobile: {
                        required: true,
                        minlength:6,
                        maxlength:15,
                    },
                    email: {
                        required:true,
                        email:true,
                    },
					password: {
						minlength: 6,
                    },
					confirm_password: {
                        minlength: 6,
						equalTo: "#password",
                    },
 
                },
              
                submitHandler: function(form) 
                {
					if($("#password").val()!=$("#confirm_password").val())
					{
						$("#conf_password").html("Confirm password is not matching.").css('display','block');
					}
					else
					{
						$("#btnSubmit").attr('disabled',true).html('Saving <i class="fa fa-spinner fa-spin"></i>')
						
						$.ajax({
						url: "{{ route('admin.create-agent') }}",
						method: 'post',
						data: $('#addAgentForm').serialize(),
						success: function(result) {
								if (result.status == 1) {
									table.ajax.reload();
									$("#addAgentForm")[0].reset();
									toastr.success(result.msg);
									$("#btnSubmit").attr('disabled',false).html('Submit');
								}
								else
								{
									toastr.success(result.msg);
								}
							}
						});
					}
				}
				
            });
				
				
		/*$("#btnOffcanvas").click(function()
		{
			$('#addAgentForm')[0].reset();
			$("#btnSubmit").attr('disabled',false).html('Submit');
			addAgent.resetForm();
		});	*/

		
		$("#agent-table tbody").on( 'click', '.edit_agent', function ()
		  {
			var id=$(this).attr('id');
			var Result=$("#edit-agent-modal .modal-body");
			
				jQuery.ajax({
					type: "GET",
					url: "{{url('admin/edit-agent')}}"+"/"+id,
					dataType: 'html',
					//data: {vid: vid},
					success: function(res)
					{
					   Result.html(res);
					}
				});
		 });
		 
		 
	$(document).on('click','.confirm_agent_deletion',function()
        {
            $.ajax({
				url: "{{ route('admin.delete-agent') }}",
				type: 'post',
				dataType:'json',
				data: {'_token': '{{ csrf_token() }}','agent_id':$(this).data('id')},
				success: function(result)
				{
					if(result.status==1)
					{
						table.ajax.reload();
						toastr.success("Agent successfully removed!");
					}
					
				}
			});
        })	 
		 
		 
		 
 
 });


		
    </script>

@endpush
@endsection