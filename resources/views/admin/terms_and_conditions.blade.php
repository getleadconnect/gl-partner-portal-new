@extends('admin.master')
@section('content')

    <div class="page-content">
        <div class="container-fluid">
            <!-- Start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">TERMS & CONDITIONS</h4>
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


            <!-- Latest Leads -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
														
                            <iframe src="{{url('agreement/agreement-1-10-2024.pdf')}}#toolbar=0&navpanes=0" style="width:80%;height:700px;"></iframe>

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
