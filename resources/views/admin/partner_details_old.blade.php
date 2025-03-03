@extends('admin.master')
@section('content')

<style>
p{	margin-bottom:5px !important; }
.container{ padding:0px 20px; }
.pd-card {  padding:10px !important;  }

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
                        <h4 class="mb-0">Partner Details</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                                <li class="breadcrumb-item active">Partner Details</li>
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
									<a href="{{ route('admin.channel-partners')}}" class="btn btn-primary me-2"><i class="fas fa-arrow-left"></i>&nbsp;Back To Partners</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="padding-top:0px;">

							<div class="row">
							<div class="col-lg-3 col-xl-3 col-xxl-3">
								<div class="row">
									<div class="col-lg-12 col-xl-12 col-xxl-12">
											<div class="form-group mt-3">
												<p><h4>{{$data['partner']->name}}</h4> </p>
												<p>{{$data['partner']->email}}</p>
												<p>{{$data['partner']->mobile}}</p>
											</div>
											
									</div>
									</div>
									<hr class="mb-0">
									<div class="row">
									<div class="col-lg-12 col-xl-12 col-xxl-12">
									<label ><b><u>Company Details</u></b></label>

									<p><h5>{{$data['partner']->company_name}}</h5></p>
												<p>{{$data['partner']->website}}</p>
												<p>{{$data['partner']->city.", ".$data['partner']->pin_code}}</p>

									<label class="mt-3"><b><u>Bank Account Details</u></b></label>

										<div class="form-group">
											<p>Bank : {{$data['partner']->bank_name}}</p>
											<p>IFSC : {{$data['partner']->ifsc}}</p>
											<p>Branch : {{$data['partner']->branch}}</p>
											<p>A/C No : {{$data['partner']->account_number}} </p>
											<p>UPI ID : {{$data['partner']->upi_id}} </p>
											<p class="mt-2" style="font-weight:600;">Commission(%) : {{$data['partner']->commission_percentage}} </p>
										</div>
										
									</div>
									</div>

							</div>
							
							<div class="col-lg-9 col-xl-9 col-xxl-9">
														
							 <div class="row mt-2">
								<!-- Partners Statistics -->
								<div class="col-lg-4 col-xl-4 col-xxl-4">
									<div class="card">
										<div class="card-body pd-card">
											<h6 class="card-title">Total Leads : {{$data['total_leads']}}</h6>
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-xl-4 col-xxl-4">
									<div class="card">
										<div class="card-body pd-card">
											<h6 class="card-title">Leads(Business) : {{$data['business_leads']}}</h6>
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-xl-4 col-xxl-4">
									<div class="card">
										<div class="card-body pd-card">
											<h6 class="card-title">Leads Open : {{$data['open_leads']}}</h6>
										</div>
									</div>
								</div>
								
								
							
							</div>
							
							<div class="row mt-2">
								<!-- Partners Statistics -->
								<div class="col-lg-4 col-xl-4 col-xxl-4">
									<div class="card">
										<div class="card-body pd-card">
											<h6 class="card-title">Commission : {{$data['total_commission']}}</h6>
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-xl-4 col-xxl-4">
									<div class="card">
										<div class="card-body pd-card">
											<h6 class="card-title">Paid : {{$data['commission_paid']}}</h6>
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-xl-4 col-xxl-4">
									<div class="card">
										<div class="card-body pd-card">
											<h6 class="card-title">Balance : {{$data['total_commission']-$data['commission_paid']}}</h6>
										</div>
									</div>
								</div>
	
							</div>
	
	
						<div class="table-responsive">
						
						<label><b><u>Leads </u></b></label>

								<!--<table id="partner-table" class="table table-striped table-centered align-middle table-nowrap mb-0" style="width:100%;">-->
									<table id="leads-table" class="table table-striped table-hover table-nowrap mb-0" style="width:100% !important;">
										<thead>
											
										<tr >
											<th>No</th>
											<th>Name</th>
											<th>Mobile</th>
											<th>Email</th>
											<th>Company</th>
											<th>Status</th>
											<th>Commission</th>
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

<script type="text/javascript">

var pid="{{$data['partner']->id}}";

 var table = $('#leads-table').DataTable({
            processing: true,
            serverSide: true,
			stateStatus: true,
			"language": {
				searchPlaceholder: 'Search',
				sSearch: '',
			},
			"lengthMenu": [10, 25, 50,100,150,200],
			
            ajax: {
                url: "{{ url('admin/get-partner-leads')}}"+"/"+pid,
                data: function (d) 
                {
                    //d.status = $('#filter_status').val(),
                }
            },
			
			
            columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
            {data: 'name', name: 'name'},
			{data: 'mobile', name: 'mobile'},
            {data: 'email', name: 'email'},
			{data: 'company_name', name: 'company_name'},
			{data: 'lead_status', name: 'lead_status'},
            {data: 'commission_amount', name: 'commission_amount',className:"numericCol"},
            ],
        });

</script>

@endpush
@endsection