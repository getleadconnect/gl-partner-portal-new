@extends('admin.master')
@section('content')

<style>

.card-body{	padding:10px 15px !important; }

.error{	color:red !important; 
		font-size:12px !important;
	}
.nav-pills .nav-link{ width:210px !important; }

.table > :not(caption) > * > * {
	padding: 0.35rem 0.35rem !important;
 }

.noti-status
{
	font-weight:600;
	width:125px;
}

#noti_settings .h1, h1 {
    font-size: 1.25rem !important;
}

#noti_settings .h2, h2 {
    font-size: 1rem !important;
}

.col-tb-width
{
	width:100px !important;
}
.dropdown-toggle::after
{
	display:none !important;
}
</style>


    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Notification Settings</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">Notification Settings</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
			
			<div class="row">
                <div class="col-12">
                    <div class="card">
                       <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Settings</h5>
                                <div>
								<!-- content here ---------->
                                </div>
                            </div>
                        </div>
                        <div class="card-body mb-5">
						
						<div class="col-9">
						<div id="noti_settings">
							<!--- notification page here ------------------>
						
						</div>
						</div>
				</div>
			 </div>
		 </div>
	  </div>
	  
	</div> <!-- container-fluid -->
</div> <!-- End Page-content -->

@push('scripts')

<script>

$(document).ready(function()
{
	jQuery.ajax({
			type: "get",
			url: "{{url('notification-manager/config')}}",
			dataType: 'html',
			success: function(res)
			{
			   $("#noti_settings").html(res);
			}
		});
});

</script>


@endpush
@endsection


