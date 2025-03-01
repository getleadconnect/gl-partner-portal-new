@extends('partner.master')
@section('content')
<style>
.numericCol
{
	text-align:right;
}

.cursor-pointer
{
	cursor:pointer
}

table th,td
{
	padding-left:30px !important;
}
table tr
{
	line-height:20px;
	font-size:12px !important;
}

</style>

 <div class="page-content">
        <div class="container-fluid">

            <!-- Start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Payout History</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                                <li class="breadcrumb-item active">History Details</li>
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
								{{--<button id="btnOffcanvas" class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Add Lead</button>--}}
								<a href="{{route('partner.leads')}}" class="btn btn-primary me-2" ><i class="fas fa-file"></i>&nbsp;My-Leads</a>
                                
                                </div>
                            </div>
                        </div>
						
                    <div class="card-body" style="padding-top:0px;">
						
						
					<div class="row mt-2">
						<div class="col-lg-6 col-xl-6 col-xxl-6">
							
							<div class="table-responsive">
							<h5 class="mt-3 mb-3"><u>Payments</u></h5>
							
							<table id="payments_table" class="table table-striped table-hover table-nowrap mb-0" style="width:100% !important;">
								<thead>
								<tr id="tab-row">
									<th>No</th>
									<th>Lead</th>
									<th>Amount</th>
									<th>Commission</th>
									<th>Paid</th>
									<th>Balance</th>
									<th>Status</th>
								</tr>
									
								</thead>
								<tbody>
							   
								</tbody>
							</table>
							</div>
							</div>
						<div class="col-lg-6 col-xl-6 col-xxl-6" style="border-left:1px solid #c4c4c4;">
						
							<div class="table-responsive">
							<h5 class="mt-3 mb-3"><u>Payment Histories</u></h5>

							 <table id="payment_history" class="table table-striped table-hover table-nowrap mb-0" style="width:100% !important;">
								<thead>
								<tr id="tab-row">
									<th>No</th>
									<th>Lead</th>
									<th>Payment Date</th>
									<th>Amount</th>
									<th>Payment Id</th>
									<th>Receipt</th>
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
		</div>
	</div>
</div> <!-- container-fluid -->
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
				
        var table = $('#payments_table').DataTable({
            processing: true,
            serverSide: true,
			stateStatus: true,
			bAutoWidth: false,
			scrollX:true,
			
			"language": {
				searchPlaceholder: 'Search',
				sSearch: '',
			},
			"lengthMenu": [10, 25, 50,100,150,200],
			
            ajax: {
                url: "{{ route('partner.view-payment-details') }}",
                data: function (d) 
                {
                    d.partner_id = $('#filter_partner_id').val()   
                }
            },
            columns: [
            
            {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
            {data: 'name', name: 'name'},
			{data: 'amount_collected', name: 'amount_collected',className:'numericCol'},
			{data: 'commission_amount', name: 'commission_amount',className:'numericCol'},
			{data: 'amount', name: 'amount',className:'numericCol'},
			{data: 'balance', name: 'balance',className:'numericCol'},
			{data: 'status', name: 'status'},
            ],
        });
		
//$("#unpaid_leads_table_filter").append(unpaid_partner_filter);

 var table2 = $('#payment_history').DataTable({
            processing: true,
            serverSide: true,
			stateStatus: true,
			bAutoWidth: false,
			scrollX:true,
			"language": {
				searchPlaceholder: 'Search',
				sSearch: '',
			},
			"lengthMenu": [10, 25, 50,100,150,200],
			
            ajax: {
                url: "{{ route('partner.view-payment-history') }}",
                data: function (d) 
                {
                    d.partner_id = $('#filter_partner_id').val()   
                }
            },
			
            columns: [
            
            {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
            {data: 'name', name: 'name'},
			{data: 'payment_date', name: 'payment_date'},
			{data: 'amount', name: 'amount',className:"numericCol"},
			{data: 'payment_id', name: 'payment_id'},
			{data: 'receipt', name: 'receipt'},
            ],
        });

	    $("#filter_partner_id").change(function()
		{
			table.ajax.reload();
			table2.ajax.reload();
		});
		
	});

</script>

@endpush
@endsection