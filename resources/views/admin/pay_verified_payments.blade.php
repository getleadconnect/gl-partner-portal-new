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
</style>

 <div class="page-content">
        <div class="container-fluid">

            <!-- Start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Set Payouts</h4>
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
												<th>Action</th>
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
	<div class="modal-dialog modal-sm">
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

$("#btn_payment").prop('disabled',true);

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
                url: "{{ route('admin.view-verified-payments-list') }}",
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
			{data: 'action', name: 'action',className:'text-center'},
            ],
        });

$("#partner_filter").change(function()
		{
			table.ajax.reload();
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

$('#payment_verify tbody').on('click','.btn-pay', function()
		{
		
		var id=$(this).attr('data-id');

		var Result=$("#set-payment-modal .modal-body");
		
			//$(this).attr("data-bs-target","#set-payment-modal");
		
				jQuery.ajax({
				type: "GET",
				url: "{{url('admin/get-payment-details')}}"+"/"+id,
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