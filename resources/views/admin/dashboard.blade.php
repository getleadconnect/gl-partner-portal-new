@extends('admin.master')
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
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End page title -->

            <!-- Welcome Message -->
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-success text-center" role="alert">
                        <h4 class="alert-heading">Welcome Back, {{ Auth::guard('admin')->user()->name }}</h4>
                        <p>Manage your partners and leads effectively with our comprehensive dashboard.</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Partners Statistics -->
                <div class="col-xl-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Partners</h5>
                            <h4>{{ $data['total_partners'] }}</h4>
                            <p class="text-muted mb-1">Partners added this week: {{$data['partner_this_week']}}</p>
                            <p class="text-muted mb-1">Partners added this month: {{$data['partner_this_month']}}</p>
                        </div>
                    </div>
                </div>

                <!-- Leads Statistics -->
                <div class="col-xl-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Leads</h5>
                            <h4>{{ $data['total_leads'] }}</h4>
                            <p class="text-muted mb-1">Leads added this week: {{$data['lead_this_week']}}</p>
                            <p class="text-muted mb-1">Leads added this month: {{$data['lead_this_month']}}</p>
                        </div>
                    </div>
                </div>

                <!-- Payout Statistics -->
                <div class="col-xl-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Payouts</h5>
                            <h4>₹ {{number_format($data['total_commission'],2,'.','')}}/{{number_format($data['total_commission_paid'],2,'.','')}}</h4>
                            <p class="text-muted mb-1">Payouts this week: ₹ {{number_format($data['total_this_week'],2,'.','')}}/{{number_format($data['payout_this_week'],2,'.','')}}</p>
                            <p class="text-muted mb-1">Payouts this month: ₹ {{number_format($data['total_this_month'],2,'.','')}}/{{number_format($data['payout_this_month'],2,'.','')}}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Latest Leads ------>
			
            <div class="row">
                <div class="col-lg-8 col-xl-8 col-xxl-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Latest Leads</h5>
                              <div class="table-responsive">
                                <table id="latest-leads-table" class="table table-striped table-centered align-middle table-nowrap mb-0" style="width:100% !important;">
                                    <thead>
                                        <tr>
											<th>SlNo</th>
                                            <th>Lead</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Partner</th>
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
				
				 <div class="col-lg-4 col-xl-4 col-xxl-4">
                    <div class="card">
                        <div class="card-body">
                          <h5 class="card-title">Recent Notifications</h5>
						    <ul class="list-group">
							 @foreach($recent_noti as $row)
							   <li class="list-group-item"><i class="fas fa-exclamation-circle"></i>&nbsp;&nbsp;{{$row->notification}}</li>
							 @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
@push('scripts')

<script type="text/javascript">
        $(function() {
            var table = $('#latest-leads-table').DataTable({
                processing: true,
                serverSide: true,
				paging:false,
				pageLength:false,
				searching:false,
				bInfo : false,
				
                ajax: "{{ route('admin.get-latest-leads') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    { data: 'name', name: 'name' },
                    { data: 'email',name: 'email' },
					{ data: 'mobile',name: 'mobile' },
					{ data: 'partner',name: 'partner' },
					{ data: 'lead_status',name: 'lead_status',className: 'text-center'},
                ]
            });

            $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            
        });
    </script>
@endpush

@endsection
