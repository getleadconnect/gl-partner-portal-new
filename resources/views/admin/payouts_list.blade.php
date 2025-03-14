@extends('admin.master')
@section('content')
<style>
.error
{
	color:red !important;
	font-size:12px !important;
}

.payment-active { color:green;}
.payment-inactive{ color:red;}

.filter-select
{
	width:110px;
	height:34px;
	margin:8px 0px 8px 8px;
	border-color:#aaa !important;
}
.pd-view p{ margin-bottom:.3rem !important;}

.numericCol
{
	text-align:right;
}

.cursor-pointer
{
	cursor:pointer
}
</style>

 <div class="page-content">
        <div class="container-fluid">

            <!-- Start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Payout Details (Converted Leads)</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                                <li class="breadcrumb-item active">Business Leads</li>
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
                                <h5 class="card-title mb-0">Converted Leads</h5>
                                <div>
								{{--<button id="btnOffcanvas" class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Add Lead</button>--}}
								<a href="{{url('admin/payout-history')}}" class="btn btn-primary me-2" ><i class="fas fa-file"></i>&nbsp;Payout History</a>
                                </div>
                            </div>
                        </div>
						
                        <div class="card-body" style="padding-top:0px;">
						
						<div class="row mt-3">
						<div class="col-lg-12">
						
						<ul class="nav nav-tabs" id="myTab" role="tablist">
							  <li class="nav-item" role="presentation">
								<button class="nav-link active" id="unpaid-tab" data-bs-toggle="tab" data-bs-target="#unpaid-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true"><b>Un-Paid Leads</b></button>
							  </li>
							  <li class="nav-item" role="presentation">
								<button class="nav-link" id="paid-tab" data-bs-toggle="tab" data-bs-target="#paid-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false"><b>Paid Leads</b></button>
							  </li>
							  
						</ul>
						
						<div class="tab-content mt-3 " id="myTabContent">
							
							<!-- TAB -1 -------------------------------------------->
							  <div class="tab-pane fade show active" id="unpaid-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
							  

										<select id="unpaid_partner_filter" name="unpaid_partner_filter" class="filter-select">
											<option value="" selected disabled>Partners</option>
											<option value="">All</option>
											@foreach($partners as $key=>$value)
											  <option value="{{$key}}">{{$value}}</option>
											@endforeach
										</select>

									<div class="table-responsive">

									<!--<table id="partner-table" class="table table-striped table-centered align-middle table-nowrap mb-0" style="width:100%;">-->
										<table id="unpaid_leads_table" class="table table-striped table-hover table-nowrap mb-0" style="width:100% !important;">
											<thead>
												
											<tr id="tab-row">
												<th>No</th>
												<th>Partner</th>
												<th>Lead</th>
												<th>Email/Mobile</th>
												<!--<th>Company</th>-->
												<th>Status</th>
												<th>Amount</th>
												<th>Commission</th>
												<th>Paid</th>
												<th>Balance</th>
												<th>Action</th>
											</tr>
												
											</thead>
											<tbody>
										   
											</tbody>
										</table>
									</div>

							  </div>
							  
							<!-- TAB -2 -------------------------------------------->  
							
							  <div class="tab-pane fade" id="paid-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
							  
									  <div class="d-flex">
										<select id="paid_partner_filter" name="paid_partner_filter" class="filter-select">
											<option value="" selected disabled>Partners</option>
											<option value="">All</option>
											@foreach($partners as $key=>$value)
											<option value="{{$key}}">{{$value}}</option>
											@endforeach
										</select>
										
									 </div>


									<div class="table-responsive">

									<!--<table id="partner-table" class="table table-striped table-centered align-middle table-nowrap mb-0" style="width:100%;">-->
										<table id="paid_leads_table" class="table table-striped table-hover table-nowrap mb-0" style="width:100% !important;">
											<thead>
												
											<tr id="tab-row">
												<th>No</th>
												<th>Partner</th>
												<th>Lead</th>
												<th>Email/Mobile</th>
												<!--<th>Company</th>-->
												
												<th>Lead Status</th>
												<th>Commission</th>
												<th>Paid</th>
												<th>Status</th>
											</tr>
												
											</thead>
											<tbody>
										   
											</tbody>
										</table>
									</div>

							</div>
							<!-- TAB END --------------------------------------------->
							
						</div>
						
						</div>
						</div>

							
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- container-fluid -->
    </div>
	
    <!-- Add Partner Modal -->

	<div class="modal fade" id="set-payment-modal" tabindex="-1" aria-labelledby="addPartnerModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addPartnerModalLabel">Payment Details</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
			
			
			</div>
		</div>
	</div>	
</div>


<div class="modal fade" id="set-commission-modal" tabindex="-1" aria-labelledby="addPartnerModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addPartnerModalLabel">Set Collected Amount</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
			
			<input type="hidden" name="temp_comm_percentage" id="temp_comm_percentage">
			
			<form id="setLeadCommission">
			@csrf
			
			<input type="hidden" class="form-control" name="set_comm_lead_id" id="set_comm_lead_id">
			<input type="hidden" class="form-control" name="set_comm_lead_status" id="set_comm_lead_status">
			<input type="hidden" class="form-control" name="renewal_status" id="renewal_status" >
			
			<div class="form-group ">
				<input type="checkbox"  name="cbox_renewal" id="cbox_renewal" style="width:20px;height:20px;font-size:16px;vertical-align:middle;">&nbsp;&nbsp;Renewal Amount
			</div>
					
			
			<div class="form-group mt-2">
				<label for="set_comm_percentage" class="form-label">Commission (%)</label>
				<input type="number" class="form-control" name="set_comm_percentage" id="set_comm_percentage" readonly>
			</div>
			
			<div class="form-group">
			<div class="row">
			<div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
				<label for="recipient-name" class="form-label">Collected Amount</label>
				<input type="number" class="form-control"  name="set_collected_amount" id="set_collected_amount" aria-describedby="button-addon2">
				<label class="error" id="err-msg" style="display:none;"></label>
			</div>
			<div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
			<div class="form-group">
				<label for="recipient-name" class="form-label">Commission</label>
				<input type="number" class="form-control" name="set_commission" id="set_commission" >
			</div>
			</div>
			</div>
			</div>
			
			<div class="form-group">
				<label for="description" class="form-label">Description</label>
				<textarea rows=3 class="form-control" name="description" id="description"  required></textarea>
			</div>
									
			<div class="form-group mt-3 mb-3" style="text-align:right;">
				<button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
				<button type="submit"  class="btn btn-primary">Submit</button>
			</div>
			</form>
			</div>
		</div>
	</div>	
</div>

<!-- End Page-content -->


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

@if(Session::has('success'))
	<script>
	toastr.success("{{Session::get('success')}}")
</script>
@endif


<script type="text/javascript">
    $(function () {

		//---------datatable -------------------------------------
				
        var table = $('#unpaid_leads_table').DataTable({
            processing: true,
            serverSide: true,
			stateStatus: true,
			bAutoWidth: false,
			
			"language": {
				searchPlaceholder: 'Search',
				sSearch: '',
			},
			"lengthMenu": [10, 25, 50,100,150,200],
			
            ajax: {
                url: "{{ route('admin.got-business-unpaid-leads') }}",
                data: function (d) 
                {
                    d.partner_id = $('#unpaid_partner_filter').val()   
                }
            },
            columns: [
            
            {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
			{data: 'partner', name: 'partner'},
            {data: 'lead_name', name: 'lead_name'},
			{data: 'email', name: 'email'},
            //{data: 'company_name', name: 'company_name'},
			
			{data: 'status', name: 'status',className:"full-width-select"},
			{data: 'amount_collected', name: 'amount_collected',className:'numericCol'},
			{data: 'commission_amount', name: 'commission_amount',className:'numericCol'},
			{data: 'amount', name: 'amount',className:'numericCol'},
			{data: 'balance', name: 'balance',className:'numericCol'},
			{data: 'actions', name: 'action',orderable: false, searchable: false,className:"text-center"},
            ],
        });
		
$("#unpaid_leads_table_filter").append(unpaid_partner_filter);

$("#unpaid_partner_filter").change(function()
 {
	table.draw();
 });


var table2 = $('#paid_leads_table').DataTable({
            processing: true,
            serverSide: true,
			stateStatus: true,
			bAutoWidth: false,
			
			"language": {
				searchPlaceholder: 'Search',
				sSearch: '',
			},
			"lengthMenu": [10, 25, 50,100,150,200],
			
            ajax: {
                url: "{{ route('admin.got-business-paid-leads')}}",
                data: function (d) 
                {
                    d.partner_id = $('#paid_partner_filter').val()   
                }
            },
            columns: [
            
            {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
			{data: 'partner', name: 'partner'},
            {data: 'name', name: 'name'},
			{data: 'email', name: 'email'},
            //{data: 'company_name', name: 'company_name'},
			
			{data: 'status', name: 'status',className:"full-width-select"},
			{data: 'com_amount', name: 'com_amount',className:'numericCol'},
			{data: 'paid_amount', name: 'paid_amount',className:'numericCol'},
			{data: 'pay_status', name: 'action',orderable: false, searchable: false,className:"text-center"},
            ],
        });


$("#paid_leads_table_filter").append(paid_partner_filter);

$("#paid_partner_filter").change(function()
	{
		table2.draw();
	});

$("#paid-tab").click(function()
		{
			table2.ajax.reload();
		});
		



/// SET PAYMENT DETAILS -------------same functions added into leads blade file-------------------------------------------------------

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

	$(document).on('change','#cbox_renewal',function()
	{
		if($(this).is(':checked'))
		{
			$("#set_comm_percentage").val(5);
			$("#renewal_status").val('Renewal');
		}				
		else
		{
			$("#set_comm_percentage").val($("#temp_comm_percentage").val());
			$("#renewal_status").val('');
		}
		
	});



	$("#unpaid_leads_table tbody").on( 'click', '.set-commission', function()
	{
		var lead_id = $(this).attr('data-leadid')
		var com_per=$(this).attr('data-percentage');
		var lead_status=$(this).attr('data-leadstatus');
				
			$("#setLeadCommission")[0].reset();
			var id=$(this).attr('id');
			$("#set_comm_lead_id").val(lead_id);
			$("#set_comm_percentage").val(com_per);
			$("#temp_comm_percentage").val(com_per);
			
			$("#set_comm_lead_status").val(lead_status);
			$("#set-commission-modal").modal('show');
	});
		

	$(document).on('keyup','#set_collected_amount',function()
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
	
		
	var sValidator=$('#setLeadCommission').validate({ 
                rules: {
					set_comm_percentage:{required:true,},
					set_collected_amount:{required:true,},
					set_commission:{required:true,},
					description:{required:true,}
                },
                submitHandler: function(form) 
                {

					formData=new FormData(document.getElementById('setLeadCommission'));
					
                    $.ajax({
					url: "{{ route('admin.update-lead-commission') }}",
					type: 'post',
					dataType:'json',
					data: formData,
					success: function(result)
					{
						if(result.status==1)
						{
							toastr.success(result.msg);
							table.ajax.reload();
							$("#setLeadCommission")[0].reset();
							$("#set-commission-modal").modal('hide');
							
						}
						else
						{
							toastr.error(result.msg);
						}
					},
					cache: false,
					contentType: false,
					processData: false
                    });
				}
            });

		
		
		/*$("#unpaid_leads_table tbody").on('click','.btn-pay',function()
        {
            lead_id = $(this).data('leadid');
			var pstatus=$(this).val();

			if(pstatus==1)
			{

				$("#lead_pay_status").val(pstatus);
				
				$.ajax({
                    url: "{{ url('admin/get-lead-details')}}"+"/"+lead_id,
                    type: 'get',
					dataType:'json',
                    success: function(res)
                    {

						if(res.status==1)
                        {
                            $("#pay_lead_id").val(res.data.id);
							$("#pay_partner_id").val(res.data.partner_id);
							$("#pay_commission").val(res.data.commission_amount);
							$("#pay_percentage").val(res.data.commission_percentage);
							$("#pay_amount").val(res.data.amount_collected);
							$("#payment-detail-modal").modal('show');
				
                        }
						else
						{
							toastr.warning(res.msg);
						}
                    }
                });

			}
			else
			{
		
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
			}
        })

*/


});

</script>

@endpush
@endsection