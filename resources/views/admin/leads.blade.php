@extends('admin.master')
@section('content')
<style>
.error
{
	color:red !important;
	font-size:12px !important;
}

.dataTables_wrapper .dataTables_filter {
    float: right;
    text-align: right;
    display: flex !important;
}

.filter-select
{
	width:110px;
	height:34px;
	margin:8px 0px 8px 8px;
	border-color:#aaa !important;
}
.lbl-bold
{
	font-weight:700;
	color:#5e34a3;
}

.payment-active { color:green;}
.payment-inactive{ color:red;}
.payment-pending{ color:purple;}
.form-select option{ color:black;}
.t-amt{ font-size:14px;font-weight:600;}
.pd-view p{ margin-bottom:.3rem;}
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
                               <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
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
									<button id="btnOffcanvas" class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Add Lead</button>
									<a href="javascript:void(0);" class="btn btn-primary me-2" id="export_to_excel"><i class="fas fa-file-export"></i>&nbsp;Export</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="padding-top:0px;">
                            <div class="d-flex">
								<select id="partner_filter" name="partner_filter" class="filter-select">
                                    <option value="" selected disabled>Partners</option>
									<option value="">All</option>
									@foreach($partners as $key=>$value)
                                    <option value="{{$key}}">{{$value}}</option>
									@endforeach
                                </select>
								
								 <select id="filter_status" name="filter_status" class="filter-select">
                                    <option value="" selected disabled>Status</option>
									<option value="">All</option>
									@foreach($lead_status as $value)
                                    <option value="{{$value->lead_status}}">{{$value->lead_status}}</option>
									@endforeach
									
                                </select>
								
								<select id="filter_payment_status" name="filter_payment_status" class="filter-select">
                                    <option value="" selected disabled>Payment</option>
									<option value="">All</option>
									<option value="0">Not Paid</option>
									<option value="1">Paid</option>
                                </select>
								
                            </div>
							
							<div class="d-flex mb-2">
							<label class="lbl-bold">Partner : <span id="partner"></span></label> 
							<label class="lbl-bold" style="margin-left:50px;">Leads : <span id="leads"></span></label>
                             </div>
														
                            <div class="table-responsive">

							    <table id="leads-table" class="table table-striped table-centered align-middle table-nowrap mb-0" style="width:100% !important;">
                                    <thead>
 										
									<tr id="tab-row">
										<th>No</th>
										<th>Lead</th>
										<th>Email/Mobile</th>
										<th>Company</th>
										<th>Partner</th>
										<th>Lead Status</th>
										<th>Amount</th>
										<th>Commission</th>
										<th>Payments</th>
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
        </div> <!-- container-fluid -->
    </div>
	
    <!-- Add Partner Modal -->

		   <div class="modal fade" id="edit-lead-modal" tabindex="-1" aria-labelledby="addPartnerModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
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
			<button type="button" class="button-close btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	  </div>
	  <div class="offcanvas-body">

	  <div class="loading-outer" style="display:none;">
		  <span class="spinner-loading">
		  <label style="font-size:48px;color:red;"> <i class="fa fa-spinner fa-spin"></i> </label>
		  <h6 style="color:red;"> Please Wait.......</h6>
		  </span>
	  </div>

	  
		<form id="lead-form">
		  @csrf
		  
		  <input type="hidden" class="form-control" name="country_name" id="country_name" >
					 
			<div class="form-group">
					<label for="recipient-name" class="form-label">Customer Name<span style="color: red;">*</span></label>
                    <input type="text" class="form-control" placeholder=""
					 name="name" id="name" required>
				</div>
				
			    <div class="form-group">
					<label for="recipient-name" class="form-label">Mobile Number<span style="color: red;">*</span></label>
					<br>
                        <input type="number" class="form-control" placeholder="" name="mobile" id="mobile" minlength=6 maxlength=15  required>
						<input type="hidden" class="form-control" placeholder="" name="country_code" id="country_code" value="91" required>
					</div>
				
				<div class="form-group">
					<label for="recipient-name" class="form-label">Company Name(Your firm)<span style="color: red;">*</span></label>
                        <input type="text" class="form-control" placeholder=""
                         name="company_name" id="company_name">
				</div>
				
				<div class="form-group">
					<label for="recipient-name" class="form-label">Designation </label>
                        <input type="text" class="form-control" placeholder=""
                             name="designation" id="designation" >
				</div>

			<div class="form-group">
					 <label for="recipient-name" class="form-label">Email<span style="color: red;">*</span></label>
                        <input type="email" class="form-control" placeholder="" name="email" id="email">
			</div>
			<div class="form-group">
					<label for="recipient-name" class="form-label">Select Partner<span style="color: red;">*</span></label>
					<select id="partner_id" name="partner_id" class="form-control" style="color:#000 !important;" required>
                      <option value="0" selected disabled>select</option>
					 @foreach($all_partners as $key=>$value)                     
						<option value="{{$key}}" >{{$value}}</option>
					 @endforeach
                   </select>

			</div>
			
			<div class="form-group">
					<label for="recipient-name" class="form-control-label">Business Category<span style="color: red;">*</span></label>
					   <select id="bussiness_category_id" name="bussiness_category_id" class="form-control" style="color:#000 !important;" required>
						  <option value="0" selected disabled>select</option>
						  @foreach($bussiness_categories as $key=>$value)
						  <option value="{{$key}}" >{{$value}}</option>
						  @endforeach
						  
					   </select>
				</div>
			
			<!--<div class="form-group">
				<label for="recipient-name" class="form-label">Lead Type<span style="color: red;">*</span></label>
                   <select id="plan_type" name="plan_type" class="form-control" required>
                      <option value="0" selected disabled>select</option>
                      <option value="1" >Product</option>
                      <option value="2">Service</option>
                   </select>
			</div> -->
			
			<!--<div class="form-group">
				<label for="recipient-name" class="form-label">Lead Purpose<span style="color: red;">*</span></label>
                <select id="plan" name="plan" class="form-control" name="plan" required>
				<option value="" selected disabled>select</option>
                </select>
			</div> -->
			
			<div class="form-group">
				<label for="partnerPhone" class="form-label">Country</label>
				<select class="form-control" name="country" id="country" style="color:#000;">
				<option value="" selected disabled>select</option>
				@foreach($countries as $key=>$value)
				<option value="{{$key}}">{{$value}}</option>
				@endforeach
				</select>
			</div>

			<div class="form-group">
				<label for="recipient-name" class="form-label">State</label>
				<select name="state" id="state" class="form-control" style="color:#000;">
				<option value="" selected disabled>select</option>
				</select>
			</div>

			<div class="form-group">
			<div class="row">
			<div class="col-lg-7 col-xl-7 col-xxl-6">
			<label for="recipient-name" class="form-label">Area/Location</label>
				<input type="text" class="form-control" placeholder=""  name="area" id="area" >
			</div>
			
			<div class="col-lg-5 col-xl-5 col-xxl-5">
				<label for="recipient-name" class="form-label">Pincode</label>
				<input type="number" class="form-control" placeholder=""
				  name="pincode" id="pincode" minlength=6 maxlength=6>
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
			<button type="button" class="button-close btn btn-danger" data-bs-dismiss="offcanvas" aria-label="Close">Close</button>
			<button type="submit" id="lead_submit"  class="btn btn-primary">Submit</button>
		</div>
		
	</form>
				
	</div>
</div>

	
 <div class="modal fade" id="set-commission-modal" tabindex="-1" aria-labelledby="addPartnerModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addPartnerModalLabel">Set Collected Amount</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
			<form id="setLeadCommission">
			@csrf
			<input type="hidden" class="form-control" name="set_comm_lead_id" id="set_comm_lead_id">
			<input type="hidden" class="form-control" name="set_comm_lead_status" id="set_comm_lead_status">
			
			<div class="form-group">
				<label for="recipient-name" class="form-label">Commission (%)</label>
				<input type="text" class="form-control" name="set_comm_percentage" id="set_comm_percentage" readonly>
			</div>
			
			<div class="form-group">
				<label for="recipient-name" class="form-label">Collected Amount</label>
				<div class="input-group">
				  <input type="text" class="form-control"  name="set_collected_amount" id="set_collected_amount" aria-describedby="button-addon2">
				  <button class="btn btn-primary" type="button" id="btnSetAmount" >Set</button>
				</div>
				<label class="error" id="err-msg" style="display:none;"></label>
			</div>
			
			<div class="form-group">
				<label for="recipient-name" class="form-label">Commission</label>
				<input type="text" class="form-control" name="set_commission" id="set_commission" >
			</div>
									
			<div class="form-group mt-3 mb-3" style="text-align:right;">
				<button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
				<button type="button" id="btnLeadCommSubmit"  class="btn btn-primary">Submit</button>
			</div>
			</form>
			
			</div>
		</div>
	</div>	
</div>	


<!-- End Page-content -->

@push('scripts')

<script type="text/javascript">


var phone_number = window.intlTelInput(document.querySelector("#mobile"), {
	  separateDialCode: true,
	  preferredCountries:["in"],
	  hiddenInput: "full_number",
	  utilsScript:"{{url('assets/intl-tel-input17.0.3/utils.js')}}"
	});


    $(function () {
    toastr.options = {
        // "positionClass": "toast-top-right cp",
        "showDuration": "300000",
        "hideMethod": "fadeOut"
        }
    });
	
	$("#btnLeadCommSubmit").prop('disabled',true);
	
</script>

<script type="text/javascript">
    $(function () {
		
		//---------datatable -------------------------------------
		
		
        var table = $('#leads-table').DataTable({
            processing: true,
            serverSide: true,
			stateStatus: true,
			scrollX:true,
			"language": {
				searchPlaceholder: 'Search',
				sSearch: '',
			},
			"lengthMenu": [10, 25, 50,100,150,200],
			
            ajax: {
                url: "{{ route('admin.list-leads') }}",
                data: function (d) 
                {
                    d.status = $('#filter_status').val();
                    d.partner_id = $('#partner_filter').val();  
					d.pay_status = $('#filter_payment_status').val();  
                }
            },
            columns: [
				{data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
				{data: 'name', name: 'name'},
				{data: 'mobile', name: 'mobile'},
				{data: 'company_name', name: 'company_name'},
				{data: 'partner', name: 'partner'},
				{data: 'status', name: 'status'},
				{data: 'amount_collected', name: 'amount_collected'},
				{data: 'commission_amount', name: 'commission_amount'},
				{data: 'pay_status', name: 'pay_status'},
				{data: 'action', name: 'action'},
            ],
			
            "drawCallback": function( json ) {
					$("#partner").html("All");
					$("#leads").html(table.page.info().recordsTotal);
						
					if($('#partner_filter').find(":selected").val()!="")
					{
						$("#partner").html($('#partner_filter').find(":selected").text());
						$("#leads").html(table.page.info().recordsTotal);
					}
            }
        });

//---------------------------------------------------------------
        
$(".dataTables_filter").append(partner_filter);
$(".dataTables_filter").append(filter_status);
$(".dataTables_filter").append(filter_payment_status);

$("#filter_status").change(function()
	{
		table.draw();
	});

$("#partner_filter").change(function()
	{
		table.draw();
	});
$("#filter_payment_status").change(function()
	{
		table.draw();
	});

var addLeadValidator=$('#lead-form').validate({ 
                rules: {
                    name: {
                        required: true
                    },
                    company_name: {
                        required: true
                    },
                    partner_id: {
                        required: true
                    },
                    mobile: {
                        required: true,
						minlength:6,
                        maxlength:15,
                    },
					pincode: {
                        minlength:6,
                        maxlength:6,
                    },
                },
                submitHandler: function(form) 
                {
                    $("#lead_submit").attr('disabled',true).html('Saving <i class="fa fa-spinner fa-spin"></i>')
					
					$(".loading-outer").css('display','block');

					var code=phone_number.getSelectedCountryData()['dialCode'];
					$("#country_code").val(code);
					
					formData=new FormData(document.getElementById('lead-form'));
					
                    $.ajax({
						url: "{{ route('admin.create-lead') }}",
						type: 'post',
						dataType:'json',
						data: formData ,  //$("#lead-form").serialize(),
						success: function(result)
                        {
                            if(result.status == 1)
                            {
                                table.ajax.reload();    
                                toastr.success(result.msg);
								$("#lead-form")[0].reset();
                                $("#lead_submit").attr('disabled',false).html('Submit')
								$("#state").html('<option value="" selected>select</option>');
								$(".loading-outer").css('display','none');
                            }
                            else{
								toastr.error(result.msg);
								$("#lead_submit").attr('disabled',false).html('Submit')
								$(".loading-outer").css('display','none');
							}
                        },
						cache: false,
						contentType: false,
						processData: false
						
                    });
                  }
            });

$(".button-close").click(function()
{
	$(".loading-outer").css('display','none');
});

	$("#btnOffcanvas").click(function()
	{
		$('#lead-form')[0].reset();
		$("#state").html('<option value="" selected>select</option>');
		addLeadValidator.resetForm();
	});

			
		$("#leads-table tbody").on( 'click', '.edit_lead', function ()
		  {
			var id=$(this).attr('id');
			var Result=$("#edit-lead-modal .modal-body");
			
					jQuery.ajax({
					type: "GET",
					url: "{{url('admin/edit-lead')}}"+"/"+id,
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
							$('#state').append('<option value="" selected disabled> select </option>');
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
						$('#plan').append("<option value='' selected>select</option>");
                        $('#plan').append(result.data);
                    }
                });
        })
		
		// set commission -------------------------------------------------------
		
		var lstat='';
		$(document).on('click','#lead_status',function()
        {
            lstat=$(this).val();
		});
		
				
		$(document).on('change','#lead_status',function()
        {

		    lead_id = $(this).data('lead-id')
			var lstatus=$(this).val()
			var com_per=$(this).data('commission');
			
			if(com_per==0 && lstatus=="Got Business")
			{
				alert("Please set partner commission.!");
				$(this).val(lstat);
			}
			else
			{
				if(lstatus=="Got Business")
				{
					
					$("#setLeadCommission")[0].reset();
					var id=$(this).attr('id');
					$("#set_comm_lead_id").val(lead_id);
					$("#set_comm_lead_status").val(lstatus);
					$("#set_comm_percentage").val(com_per);
					$("#set-commission-modal").modal('show');
				}
				else
				{
					$.ajax({
						url: "{{ route('admin.update-lead-status') }}",
						type: 'get',
						dataType:'json',
						data: {'lead_id':lead_id,'lead_status':$(this).val()},
						success: function(result)
						{
							if(result.status)
							{
								toastr.success(result.msg);
								table.ajax.reload();
							}
							
						}
					});
				}
			}
        });
				
		
		$(document).on('click','#btnSetAmount',function()
        {
            var camt=$("#set_collected_amount").val();
			var com_per=$("#set_comm_percentage").val();
			if(camt!="")
			{
				comm=(parseInt(camt)*parseInt(com_per))/100;
				$("#set_commission").val(Math.round(comm,2));
				$("#err-msg").html("").css('display','none');
				$("#btnLeadCommSubmit").prop('disabled',false);
			}
			else
			{
				$("#err-msg").html("Invalid Amount!").css('display','block');
			}
        });
		
		
		
		$(document).on('click','#btnLeadCommSubmit',function()
        {
            var camt=$("#set_collected_amount").val();
			var comm=$("#set_commission").val();
			
			if(camt!="" && comm!="")
			{
				$.ajax({
					url: "{{ route('admin.update-lead-commission') }}",
					type: 'post',
					dataType:'json',
					data: $("#setLeadCommission").serialize(),
					success: function(result)
					{
						if(result.status==1)
						{
							toastr.success(result.msg);
							table.ajax.reload();
							$("#setLeadCommission")[0].reset();
							$("#set-commission-modal").modal('hide');
							
						}
						
					}
				});
			}
			else
			{
				$("#err-msg").html("Invalid Amount!").css('display','block');
			}
        });
		
		
		//-------------------------------------------------

        $(document).on('click','.confirm_deletion',function()
        {
            $.ajax({
                    url: "{{ route('admin.delete-lead') }}",
                    method: 'post',
                    data: {'_token': '{{ csrf_token() }}','lead_id':$(this).data('id')},
                    success: function(result)
                    {
                        if(result.status)
                        {
                            toastr.success("Lead successfully removed!");
                            table.ajax.reload();
                        }
                        
                    }
                });
        })


	$("#export_to_excel").click(function()
	{
		var status=($("#filter_status").find(':selected').val()!="")?$("#filter_status").find(':selected').val():"All";
		var partner=($("#partner_filter").find(':selected').val()!="")?$("#partner_filter").find(':selected').val():"All";
		var pay_status=($("#filter_payment_status").find(':selected').val()!="")?$("#filter_payment_status").find(':selected').val():"All";
		var lnk="{{url('admin/export-lead-list')}}"+"/"+status+"/"+partner+"/"+pay_status;
		$("#export_to_excel").attr('href',lnk);	
	});
	


/// SET PAYMENT DETAILS -------------same functions added into payout blade file-------------------------------------------------------


 var paymentValidator=$('#paymentForm').validate({ 
                rules: {

                },
                submitHandler: function(form) 
                {
                    $("#btnPayment").attr('disabled',true).html('Saving <i class="fa fa-spinner fa-spin"></i>')
					
					var formData=new FormData(document.getElementById('paymentForm'));
					
                    $.ajax({
                    url: "{{ route('admin.save-payout') }}",
                    type: 'post',
                    data: formData,
                    success: function(result){
                        if(result.status == 1)
                        {
                            $("#btnPayment").attr('disabled',false).html('Submit')
							table.ajax.reload();
                            toastr.success(result.msg);
							$('#paymentForm')[0].reset();
							paymentValidator.resetForm();
							$("#payment-detail-modal").modal('hide');
                        }
                    },
					cache: false,
					contentType: false,
					processData: false
                    });
                  }
                });

		var cstatus='';
		$(document).on('click','#payment_status',function()
        {
            cstatus=$(this).val();
		});
		
		
		$(document).on('change','#payment_status',function()
        {
            lead_id = $(this).data('lead-id');
			var pstatus=$(this).val();
			
				$.ajax({
						url: "{{ route('admin.update-payment-status') }}",
						method: 'get',
						data: {'lead_id':lead_id,'status':$(this).val()},
						success: function(result)
						{
							if(result.status==1)
							{
								toastr.success(result.msg);
								table.ajax.reload();
							}
							else
							{
								toastr.warning(result.msg);
							}
							
						}
					});
				
        })


});	
		
</script>


@endpush
@endsection