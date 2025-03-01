@extends('partner.master')
@section('content')

    <div class="page-content">
        <div class="container-fluid">
            <!-- Start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Dashboard</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End page title -->

@if($update_message!="")

<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
  <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
  </symbol>
</svg>

<div class="alert alert-warning d-flex alert-dismissible fade show" role="alert">
  <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:" style="margin-top:3px;">
  <use xlink:href="#exclamation-triangle-fill"></use></svg>
  <span>{!! $update_message !!}(Click 'Edit profile')</span>
  <button type="button" class="btn-close" data-bs-dismiss="alert"  style="font-size:18px;margin-top:3px;" aria-label="Close"></button>
</div> 
		
@endif

            <!-- Welcome Message -->
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-success text-center" role="alert">
                        <h4 class="alert-heading">Welcome Back, {{ Auth::guard('partner')->user()->name }}</h4>
                        <p>Manage your partners and leads effectively with our comprehensive dashboard.</p>
                    </div>
                </div>
            </div>
			
						<div class="row mt-2">
								<!-- Partners Statistics -->
								<div class="col-lg-4 col-xl-4 col-xxl-4">
									<div class="card">
										<div class="card-body pd-card">
											<h6 class="card-title">Total Leads : {{$data['leads_count']}} </h6>
										</div>
									</div>
								</div>
								
								<div class="col-lg-4 col-xl-4 col-xxl-4">
									<div class="card">
										<div class="card-body pd-card">
											<h6 class="card-title">Leads(Converted): {{$data['leads_business']}} </h6>
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-xl-4 col-xxl-4">
									<div class="card">
										<div class="card-body pd-card">
											<h6 class="card-title">Leads Open: {{$data['leads_count']-$data['leads_business']}}</h6>
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-xl-4col-xxl-4">
									<div class="card">
										<div class="card-body pd-card">
											<h6 class="card-title">Commission :  {{"₹ ".number_format($data['total_commission'],2,'.','')}}</h6>
										</div>
									</div>
								</div>
								
								<div class="col-lg-4 col-xl-4 col-xxl-4">
									<div class="card">
										<div class="card-body pd-card">
											<h6 class="card-title">Paid : {{"₹ ".number_format($data['paid_commission'],2,'.','')}}</h6>
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-xl-4 col-xxl-4">
									<div class="card">
										<div class="card-body pd-card">
											<h6 class="card-title">Balance : {{"₹ ".abs(number_format($data['paid_commission']-$data['total_commission'],2,'.',''))}}</h6>
											</div>
									</div>
								</div>

							</div>
	
            <!-- Latest Leads -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Leads </h5>
														
                            <div class="table-responsive">
                            
								<table id="business-leads-table" class="table table-striped table-hover table-nowrap mb-0" style="width:100% !important;">
                                    <thead>
 										
									<tr id="tab-row">
										<th>No</th>
										<th>Lead</th>
										<th>Email</th>
										<th>Mobile</th>
										<th>Company</th>
										<th>Address</th>
										<th>Location</th>
										<th>Lead Status</th>
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
    <!-- End Page-content -->
@push('scripts')

<script type="text/javascript">
   
   var table = $('#business-leads-table').DataTable({
            processing: true,
            serverSide: true,
			stateStatus: true,
			"language": {
				searchPlaceholder: 'Search',
				sSearch: '',
			},
			"lengthMenu": [10, 25, 50,100,150,200],
			
            ajax: {
                url: "{{ route('partner.get-business-leads') }}",
                data: function (d) 
                {
                }
            },
		
			columns: [
				{data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
				{data: 'name', name: 'name'},
				{data: 'email', name: 'email'},
				{data: 'mobile', name: 'mobile'},
				{data: 'company_name', name: 'company_name'},
				{data: 'address', name: 'address'},
				{data: 'area', name: 'area'},
				{data: 'lead_status', name: 'lead_status'},
            ],
   });
   
</script>
@endpush

@endsection
