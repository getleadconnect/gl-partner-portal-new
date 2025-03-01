@extends('admin.master')
@section('content')

 <div class="page-content">
        <div class="container-fluid">

            <!-- Start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Notifications</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                                <li class="breadcrumb-item active">Notifications</li>
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
                                <h5 class="card-title mb-0">Manage Notifications</h5>
                                <div>
									<!--<button id="btnOffcanvas" class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Add Agent</button>-->
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                        <div class="table-responsive">

							<!--<table id="partner-table" class="table table-striped table-centered align-middle table-nowrap mb-0" style="width:100%;">-->
                                <table id="notification-table" class="table table-striped table-hover table-nowrap mb-0" style="width:100% !important;">
                                    <thead>
                                      
										<tr>
										  <th>No</th>
										  <th>Notification</th>
										  <th>Date</th>
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
    </div>	<!-- End Page-content -->

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
$(function() {
			
	var table = $('#notification-table').DataTable({
		processing: true,
		serverSide: true,
		ajax: "{{ route('admin.notification-list') }}",
		columns: [{
				data: 'DT_RowIndex',
				name: 'DT_RowIndex',
				orderable: false,
				searchable: false
			},
			{ data: 'notification', name: 'notification' },
			{ data: 'cdate'},
			{ data: 'status',name: 'status' },
			{ data: 'action',name: 'action',className: 'text-center'},
		]
	});

		
$("#notification-table tbody").on('click','.confirm_deletion',function()
	{
		var id=$(this).data('id');
		
		$.ajax({
				url: "{{ url('admin/delete-notification') }}"+"/"+id,
				type: 'get',
				dataType:'json',
				
				success: function(result)
				{
					if(result.status)
					{
						toastr.success("Notification successfully removed!");
						table.ajax.reload();
					}
					
				}
			});
	});

});

</script>

@endpush
@endsection