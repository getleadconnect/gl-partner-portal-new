@extends('agent.master')
@section('content')
<style>
.error,.err-msg
{
	color:red !important;
	font-size:12px !important;
}
.numericCol
{
	text-align:right;
	padding-right:15px !important;
}
</style>

 <div class="page-content">
	<div class="container-fluid">
            <!-- Start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Leads</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('agent.dashboard')}}">Home</a></li>
                                <li class="breadcrumb-item active">Leads</li>
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
                                <h5 class="card-title mb-0">Manage Leads</h5>
                                <div>
                                <button id="btnOffcanvas" class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Add Leads</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                               
                            </div>
                            <div class="table-responsive">
							
							
							<!--<table id="partner-table" class="table table-striped table-centered align-middle table-nowrap mb-0" style="width:100%;">-->
                                <table id="leads-table" class="table table-striped table-hover table-nowrap mb-0" style="width:100%;">
                                    <thead>
                                    <tr>
										<th>No</th>
										<th>Lead</th>
										<th>Number</th>
										<th>Email</th>
										<th>Partner</th>
										<th>Amount</th>
										<th>Commission</th>
										<th>Payment</th>
										<th>Actions</th>
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
		
    </div><!-- container-fluid -->
 </div>   <!-- End Page-content -->
	

<div class="modal fade" id="edit-lead-modal" tabindex="-1" aria-labelledby="addPartnerModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addPartnerModalLabel">Edit Lead</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
						
						</div>
					</div>
				</div>	
			</div>				
	
	
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
	  <div class="offcanvas-header">
		<h5 id="offcanvasRightLabel">Add Lead</h5>
			<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	  </div>
	  <div class="offcanvas-body">
		<form id="lead-form">
		  @csrf
		  
		   <input type="text" class="form-control"  name="country_name" id="country_name">
		  
			<div class="form-group">
					<label for="recipient-name" class="form-label">Customer Name<span style="color: red;">*</span></label>
                    <input type="text" class="form-control" placeholder=""
					value="{{ old('name') }}" name="name" id="name" required>
				</div>
				
			   <div class="form-group">
					<label for="recipient-name" class="form-label">Mobile Number<span style="color: red;">*</span></label>
                        <input type="number" class="form-control" placeholder="" 
						value="{{ old('mobile') }}" name="mobile" id="mobile" required>
				</div>
				<div class="form-group">
					<label for="recipient-name" class="form-label">Company Name(your firm)</label>
                        <input type="text" class="form-control" placeholder=""
                            value="{{ old('company_name') }}" name="company_name" id="company_name">
				</div>
				
				<div class="form-group">
					<label for="recipient-name" class="form-label">Designation<span
                                style="color: red;">*</span></label>
                        <input type="text" class="form-control" placeholder=""
                            value="{{ old('designation') }}" name="designation" id="designation" required>
				</div>

			<div class="form-group">
					 <label for="recipient-name" class="form-label">Email</label>
                        <input type="text" class="form-control" placeholder=""
                            value="{{ old('email') }}" name="email" id="email">
			</div>
			<div class="form-group">
					<label for="recipient-name" class="form-label">Select Partner</label>
					<select id="partner_id" name="partner_id" class="form-control">
                      <option value="0" selected disabled>select</option>
					 @foreach($partner_list as $key=>$value)                     
						<option value="{{$key}}" >{{$value}}</option>
					 @endforeach
                   </select>

			</div>
			<div class="form-group">
				<label for="recipient-name" class="form-label">Lead Type</label>
                   <select id="plan_type" name="plan_type" class="form-control">
                      <option value="0" selected disabled>select</option>
                      <option value="1" >Product</option>
                      <option value="2">Service</option>
                   </select>
			</div>
			<div class="form-group">
				<label for="recipient-name" class="form-label">Lead Purpose</label>
                <select id="plan" name="plan" class="form-control" name="plan">
				<option value="" selected disabled>select</option>
                </select>
			</div>

			<div class="form-group">
				<label for="partnerPhone" class="form-label">Country</label>
				<select class="form-control" name="country" id="country" required>
				<option value="" selected disabled>select</option>
				@foreach($countries as $key=>$value)
				<option value="{{$key}}">{{$value}}</option>
				@endforeach
				</select>
			</div>

			<div class="form-group">
				<label for="recipient-name" class="form-label">State</label>
				<select name="state" id="state" class="form-control">
				<option value="" selected disabled>select</option>
				</select>
			</div>

			<div class="form-group">
			<div class="row">
			<div class="col-lg-7 col-xl-7 col-xxl-6">
			<label for="recipient-name" class="form-label">Area/Location</label>
				<input type="text" class="form-control" placeholder=""
				 value="{{ old('area') }}" name="area" id="area">
			</div>
			<div class="col-lg-5 col-xl-5 col-xxl-5">
				<label for="recipient-name" class="form-label">Pincode</label>
				<input type="text" class="form-control" placeholder=""
				 value="{{ old('pincode') }}" name="pincode" id="pincode">
			</div>
			</div>
			</div>
							
			<div class="form-group">
				<label for="recipient-name" class="form-label">Address</label>
				<textarea class="form-control" name="address" id="address" placeholder="">{{ old('address') }}</textarea>
			</div>
			<div class="form-group">
				<label for="recipient-name" class="form-label">Remarks</label>
				<textarea class="form-control" name="remarks" id="remarks" placeholder="">{{ old('remarks') }}</textarea>
			</div>
			
			
		<div class="form-group mt-3 mb-3" style="text-align:right;">
			<button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas" aria-label="Close">Close</button>
			<button type="submit" id="lead_submit"  class="btn btn-primary">Submit</button>
		</div>
		
	</form>
				
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

$(document).ready(function()
{

	$("#btnOffcanvas").click(function()
	{
		$('#lead-form')[0].reset();
		$("#state").html('<option value="" selected>select</option>');
		$("#plan").html('<option value="" selected>select</option>');
	});
	
});
</script>

<script>
 $(function () {
        var table = $('#leads-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('agent.list-leads') }}",
                data: function (d) 
                {
                    //d.payment_status = $('#payment_filter').val(),
                    //d.partner_id = $('#partner_filter').val()   
                }
            },
            columns: [
            
            {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'mobile', name: 'mobile'},
            {data: 'email', name: 'email'},
			{data: 'partner', name: 'partner'},
			{data: 'amt_collected',className:'numericCol'},
			{data: 'c_amount',className:'numericCol'},
			{data: 'pay_status'},
            {data: 'actions', name: 'actions'},
            ]
        });


        $('#lead-form').validate({ // initialize the plugin
                rules: {
                    name: {
                        required: true
                    },
                    partner_id: {
                        required: true
                    },
                    mobile: {
                        required: true,
                        minlength:10,
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
                        url: "{{ route('agent.save-lead') }}",
                        type: 'post',
						dataType:"json",
                        data: $('#lead-form').serialize(),
                        success: function(result){
                            if(result.status == 1)
                            {
                                table.ajax.reload();    
                                $('#lead-form')[0].reset();
								$("#state").html('<option value="" selected>select</option>');
								$("#plan").html('<option value="" selected>select</option>');
                                toastr.success(result.msg);
                            }
                        }
                        });
                    }
            });

		$("#leads-table tbody").on( 'click', '.edit_lead', function ()
		  {
			var id=$(this).attr('id');
			var Result=$("#edit-lead-modal .modal-body");
			
					jQuery.ajax({
					type: "GET",
					url: "{{url('agent/edit-agent-lead')}}"+"/"+id,
					dataType: 'html',
					//data: {vid: vid},
					success: function(res)
					{
					   Result.html(res);
					}
				});
		  });


        $("#country").on('change',function()
        {
            country = $(this).val()
			$("#country_name").val($('#country option:selected').text());
            $.ajax({
                    url: "{{ route('country-states') }}",
                    method: 'get',
                    data: {'country':country},
                    success: function(result)
                    {
                        if(result.states)
                        {
                            $('#state').empty();
                            $.each(result.states, function(key, value) {
                            $('#state').append('<option value="'+ value +'">'+ value +'</option>');
                            });
                        }
                    }
                });
        })


        $("#plan_type").on('change',function()
        {
            plan_type = $(this).val()
            $.ajax({
                    url: "{{ route('get-plans') }}",
                    method: 'get',
                    data: {'plan_type':plan_type},
                    success: function(result)
                    {
                        $('#plan').empty();
                        $('#plan').append(result.data);
                    }
                });
        })
        

        $(document).on('change','#payment_status',function()
        {
            lead_id = $(this).data('lead-id')
            $.ajax({
                    url: "{{ route('admin.update-payment-status') }}",
                    method: 'get',
                    data: {'lead_id':lead_id,'status':$(this).val()},
                    success: function(result)
                    {
                        if(result.status)
                        {
                            toastr.success(result.msg);
                            table.ajax.reload();
                        }
                        
                    }
                });
        })


		
    });
</script>

@endpush
@endsection