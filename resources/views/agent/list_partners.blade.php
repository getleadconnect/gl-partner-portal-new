@extends('agent.master')
@section('content')
<style>
.error,.err-msg
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
                        <h4 class="mb-0">My Partners</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('agent.dashboard')}}">Home</a></li>
                                <li class="breadcrumb-item active">Partners</li>
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
                                <h5 class="card-title mb-0">Manage Partners</h5>
                                <div>
								<button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#invite_modal">Invite Partner</button>

                                <button id="btnOffcanvas" class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Add Partner</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                
                            </div>
                            <div class="table-responsive">
							
							
							<!--<table id="partner-table" class="table table-striped table-centered align-middle table-nowrap mb-0" style="width:100%;">-->
                                <table id="partner-table" class="table table-striped table-hover table-nowrap mb-0" style="width:100%;">
                                    <thead>
                                    <tr>
										<th>No</th>
										<th>Name</th>
										<th>Company</th>
										<th>Email</th>
										<th>Mobile</th>
										<th>Country</th>
										<th>State</th>
										<th>City</th>
									</tr>
										
                                    </thead>
                                    <tbody>
                                   
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Add Partner Modal -->
            <div class="modal fade" id="invite_modal" tabindex="-1" aria-labelledby="addPartnerModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addPartnerModalLabel">Invite Partner</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="padding:10px 30px;">
						 <form >
							@csrf
							<div class="form-group">
							<label>Enter Email-id</label>
							
							<div class="input-group">
							  <input type="email" class="form-control" id="invite_email" name="invite_email" placeholder="contact@gmail.com" aria-label="Recipient's email"  >
							  <button class="btn btn-primary" id="send_invitation" type="button" >Invite now</button>
							</div>
								<label class="m-0 err-msg" id="err-email"></label>
							</div>
											
						</form>
						<div class="d-flex align-items-center" style="flex-direction:column">
							<label>..........OR..........</label>
						</div>
						
						<div class="form-group">
							<label>Share this link</label>
							<div class="input-group mb-3">
							  <input type="text" class="form-control" id="link" value="https://gl-partner/partner/accept-invitation/i5rGqlnuzbfe" readonly>
							  <button class="btn btn-primary" id="copy" data-clipboard-target="#link" data-bs-toggle="popover"  data-bs-content="Link Copied!">Copy Link</button>
							</div>
						</div>
							
                        </div>
						<div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                        </div>
						
						
                    </div>
                </div>
        </div> 
		

	
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
	  <div class="offcanvas-header">
		<h5 id="offcanvasRightLabel">Add Partner</h5>
		<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	  </div>
	  <div class="offcanvas-body">

		<form id="create-partner-form">
		  @csrf
		  
			<div class="form-group">
					<label for="partnerName" class="form-label">Name</label>
					<input type="text" class="form-control" name="name" id="name" required>
				</div>
				
			   <div class="form-group">
					<label for="partnerEmail" class="form-label">Email</label>
					<input type="email" class="form-control" name="email" id="email" required>
				</div>
				<div class="form-group">
					<label for="partnerPhone" class="form-label">Mobile</label>
					<input type="number" class="form-control" minlength=10 maxlength=10 name="mobile" id="mobile" required>
				</div>
				
				<div class="form-group">
					<label for="partnerPhone" class="form-label">Password</label>
					<input type="text" class="form-control" name="password" id="password" required>
				</div>
				
				<div class="form-group">
					<label for="partnerPhone" class="form-label">Confirm Password</label>
					<input type="text" class="form-control" name="confirm_password" id="confirm_password" required>
				</div>

			<div class="form-group mt-3 mb-3" style="text-align:right;">
			<button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas" aria-label="Close">Close</button>
			<button type="submit" id="partner_submit"  class="btn btn-primary">Submit</button>
			</div>
		</form>
		
		
	  </div>
</div>

    </div><!-- container-fluid -->
 </div>   <!-- End Page-content -->

@push('scripts')

<script type="text/javascript">
    $(function () {
    toastr.options = {
        // "positionClass": "toast-top-right cp",
        "showDuration": "300000",
        "hideMethod": "fadeOut"
        }
    });
	

	
$(document).ready(function()
{
	//$("#addPartner").validate();
	
	$("#btnOffcanvas").click(function()
	{
		$('#addPartner')[0].reset();
		$("#state").html('<option value="" selected>select</option>');
	});
	

	
});
</script>

<script>
$(function () {
        var table = $('#partner-table').DataTable({
            processing: true,
            serverSide: true,
			saveState:true,
            ajax: "{{ route('agent.list-partners') }}",
            columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'company_name', name: 'company_name'},
            {data: 'email', name: 'email'},
            {data: 'mobile', name: 'mobile'},
			{data: 'country', name: 'country'},
			{data: 'state', name: 'state'},
			{data: 'city', name: 'city'},
            ]
        });
        
        /*$("#invite_partner").on('click',function()
        {
            $("#invite_modal").modal('show')
        })*/
		
		
		$("#send_invitation").on('click',function(e)
		{
			e.preventDefault();
			
			if($.trim($("#invite_email").val())=="")
			{
				
				$("#err-email").html("<span class='err-text'>Email missing, try again.!</span>");
			}
			else
			{
			        $(this).html('Sending mail &nbsp;&nbsp;<i class="fa fa-spinner fa-spin"></i>');
                				
					$.ajax({
							url: "{{ route('agent.invite-partner') }}",
							type: 'post',
							dataType:"json",
							data: {
								'_token': '{{ csrf_token() }}',
								'email_id':$("#invite_email").val()
							},
							success: function(result){
								$("#invite_modal").modal('hide')
								$("#send_invitation").html("Invite now")
								toastr.success(result.msg);
							}
					});
            }
		});
		
		
        $('#copy').on('click', function(event) {
            $.ajax({
                url: "{{ route('agent.get-invite-link') }}",
                method: 'post',
                data: {
                    '_token': '{{ csrf_token() }}',
                },
                success: function(result)
                {
                    console.log(result)
                    if(result.status == 1)
                    {
                         $("#link").val(result.link)
						 navigator.clipboard.writeText(result.link);
						 setTimeout(function(){$(".popover").removeClass('show');}, 500);
                    }
                }
            });
        });

        
        $('#create-partner-form').validate({ // initialize the plugin
                rules: {
                    password: {
                    minlength: 6,
                    },
                    confirm_password: {
                    minlength: 6,
                    equalTo: "#password"
                    },
                    name: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    mobile: {
                        required: true,
                        minlength:10,
                        maxlength:10
                    },
                    minlength: {
                        required: true,
                        minlength: 10
                    },
                    maxlength: {
                        required: true,
                        maxlength: 10
                    }
                },
                submitHandler: function(form) {
                    $.ajax({
                    url: "{{ route('agent.create-partner') }}",
                    type: 'post',
					dataType:"json",
                    data: $('#create-partner-form').serialize(),
                    success: function(result){
                        if(result.status == 1)
                        {
                            table.ajax.reload();    
                            $("#create-partner-form")[0].reset()
                            toastr.success(result.msg);
                        }
						}
                    });
                }
                
            });
    });
</script>

@endpush
@endsection