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
.text-center
{
	text-align:center;
}
.fs-10
{
	font-size:10px;
	color:red;
	font-weight:600;
}

</style>

 <div class="page-content">
        <div class="container-fluid">

            <!-- Start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Verify Payouts</h4>
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
                                <h5 class="card-title mb-0">Payouts List</h5>
                                <div>
								{{--<button id="btnOffcanvas" class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Add Lead</button>--}}
								<a href="{{url('admin/payout-history')}}" class="btn btn-primary me-2" ><i class="fas fa-file"></i>&nbsp;Payout History</a>
                                </div>
                            </div>
                        </div>
						
                        <div class="card-body" style="padding-top:0px;">


								<div class="row row-cols-1 row-cols-lg-1 row-cols-xl-1 row-cols-xxl-1" >
									<div class="col">
										<div class="card overflow-hidden radius-10">
											<div class="card-body">
											<div class="d-flex overflow-hidden">
												<label style="width:100px;"> Filter By:</label>
													<div class="d-flex">
														<select id="partner_filter" name="partner_filter" class="filter-select-new">
															<option value="" selected disabled>Partners</option>
															<option value="">All</option>
															@foreach($partners as $key=>$value)
															<option value="{{$key}}">{{$value}}</option>
															@endforeach
														</select>
														
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="table-responsive">

									<!--<table id="partner-table" class="table table-striped table-centered align-middle table-nowrap mb-0" style="width:100%;">-->
										<table id="payment_verify" class="table table-striped table-hover  mb-0" style="width:100% !important;">
											<thead>
											<tr id="tab-row">
												<th>No</th>
												<th>Partner</th>
												<th>Company</th>
												<th>Lead</th>
												<th>Description</th>
												<th>Collected_Amount</th>
												<th>Commission</th>
												<th>Leads</th>
												<th>Pay-Status</th>
												<th>Status</th>
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


<div class="modal fade" id="view-payment-leads-modal" tabindex="-1" aria-labelledby="addPartnerModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addPartnerModalLabel">View Payment Leads</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
			
			<!-------------- contents here -------------------->

				
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

	
/*$("#unpaid_leads_table_filter").append(unpaid_partner_filter);

$("#unpaid_partner_filter").change(function()
 {
	table.draw();
 });*/



 var table = $('#payment_verify').DataTable({
            processing: true,
            serverSide: true,
			stateStatus: true,
			bAutoWidth: false,
			pageLength:50,
			
			"language": {
				searchPlaceholder: 'Search',
				sSearch: '',
			},
			"lengthMenu": [10, 25, 50,100,150,200],
			
            ajax: {
                url: "{{ route('admin.view-payments-for-verify') }}",
                data: function (d) 
                {
                    d.partner_id = $('#partner_filter').val()   
                }
            },
			
            columns: [
            
            {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
            {data: 'partner_name', name: 'partner_name'},
			{data: 'company_name', name: 'company_name'},
			{data: 'lead_name', name: 'lead_name'},
			{data: 'description', name: 'description'},
			{data: 'total_collection', name: 'total_collection',className:"numericCol"},
			{data: 'amount', name: 'amount',className:"numericCol"},
			{data: 'view_leads', name: 'view_leads',className:'text-center'},
			{data: 'pay_status', name: 'pay_status',className:'text-center'},
			{data: 'verify_status', name: 'verify_status'},
            ],
        });

	    $("#partner_filter").change(function()
		{
			table.ajax.reload();
		});
		


$("#payment_verify tbody").on( 'click', '.btn-verify', function()
	{
		var pid = $(this).attr('data-id')
		
		//var txt=($(this).attr('data-verify')=="1")?"verify":"unverified";
		
		Swal.fire({
			text: "You want to verify the payment!",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes, verify it!"
			}).then((result) => {
			if (result.isConfirmed) 
				
					$.ajax({
						url: "{{url('/admin/update-payment-verify_status')}}"+"/"+pid,
						type: "GET",          // or PUT
						dataType: 'html',
						success: function (response) {
							if(response==true)
							{
								var msg="Payment successfully verified!"
								toastr.success(msg);
								table.ajax.reload();
							}
						},
						error: function (xhr, status, error) {
							toastr.error(error);
							table.ajax.reload();
							}
						});

			});

	});


	$('#payment_verify tbody').on('click','.btn-view-leads', function()
		{
		
		var id=$(this).attr('data-id');

		var Result=$("#view-payment-leads-modal .modal-body");
		
			//$(this).attr("data-bs-target","#set-payment-modal");
		
				jQuery.ajax({
				type: "GET",
				url: "{{url('admin/get-payment-leads-list')}}"+"/"+id,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				Result.html(res);
				}
			});
	});










	});

 
 
 
</script>

@endpush
@endsection