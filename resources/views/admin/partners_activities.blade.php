@extends('admin.master')
@section('content')
<style>

.partner-active { color:green;}
.partner-inactive{ color:red;}

.partner-new-status { color:blue;}

.form-select option{ color:black;}

.dataTables_wrapper .dataTables_filter {
    float: right;    text-align: right;   display: flex !important;
}

#err-msg {color:red;	font-size:12px; }
.filter-select{	width:110px;	height:34px;	margin:8px 0px 8px 8px;	border-color:#aaa !important;
}
.pr-detail{position:fixed;	left:83px;	top:20px;	width:93%;	height:93%;	border:2px solid #b9d5ca;
	background:#fff; z-index:9999999;	
}
.prd-body{width:100%;	height:513px;	overflow-y:scroll;	scrollbar-width:thin; }
.txt-center{
	text-align:center;
}

.dropdown:hover{ cursor:pointer;}
@media (min-width: 992px) {
    .modal-lg, .modal-xl {
        --bs-modal-width: 600px !important;
    }
}
</style>

 <div class="page-content">
	<div class="container-fluid">
            <!-- Start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Partners Activity Report</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                                <li class="breadcrumb-item active">Partners</li>
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
                                <h5 class="card-title mb-0">Partners Activities</h5>
                                <div>
								  <a href="javascript:void(0);" class="btn btn-primary me-2" id="export_to_excel"><i class="fas fa-file-export"></i>&nbsp;Export</a>
                                </div>
                            </div>
                        </div>
						
						
                        <div class="card-body">

						<!--<div class="row row-cols-1 row-cols-lg-1 row-cols-xl-1 row-cols-xxl-1" style="margin-top:-20px !important;">
							<div class="col">
								<div class="card overflow-hidden radius-10">
									<div class="card-body">
									<div class="d-flex overflow-hidden">
										<label style="width:100px;"> Filter By:</label>
											<div class="d-flex">
													<select id="filterBox" name="filter-box" class="filter-select-new">
													<option value="">All</option>
													<option value="1">Active</option>
													<option value="0">Inactive</option>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div> -->


                            <div class="table-responsive">

							<!--<table id="partner-table" class="table table-striped table-centered align-middle table-nowrap mb-0" style="width:100%;">-->
                                <table id="partner-table" class="table table-striped table-hover table-nowrap mb-0" style="width:100% !important;">
                                    <thead>
  									<tr>
										<th>No</th>
										<th>Unique Id</th>
										<th>Partner Name</th>
										<th>Email</th>
										<th>Mobile</th>
										 <th>Status</th>
										<th>Latest Lead Name</th>
										<th>Company</th>
										<th>Lead Created At</th>
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
		
    </div> <!-- End Page-content -->

	
@push('scripts')

<script type="text/javascript">

    $(function () {
    toastr.options = {
        // "positionClass": "toast-top-right cp",
        "showDuration": "300000",
        "hideMethod": "fadeOut"
        }
    });

/*$("#country").select2({
	    dropdownParent: $('#offcanvasRight')
});*/


</script>

<script>


 $(function () {
        var table = $('#partner-table').DataTable({
            processing: true,
            serverSide: true,
			pageLength:50,
			/*dom: 'lBfrtip',
			buttons: [
			'csv', 'excel'
			],*/
			
			"language": {
				searchPlaceholder: 'Search',
				sSearch: '',
			},
			"lengthMenu": [10, 25, 50,100,150,200],
			
			ajax:
			{
				url:"{{ route('admin.view-partners-activities') }}",
				data: function (data) 
				{
				   data.searchStatus = $('#filterBox').val();
				},
			},
			
            columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
			{data: 'partnerId', name: 'partnerId',orderable: false, searchable: false},
			{data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
			{data: 'mobile', name: 'mobile'},
            {data: 'status', name: 'status'},
			{data: 'lead_name', name: 'lead_name'},
			{data: 'lead_company', name: 'lead_company'},
			{data: 'lead_created_at', name: 'lead_created_at'},

			{data: 'lead_status', name: 'lead_status'},
            ]
        });

	$("#export_to_excel").click(function()
	{
		var lnk="{{url('admin/export-partners-activity')}}";
		$("#export_to_excel").attr('href',lnk);	
	});

});
</script>

@endpush
@endsection