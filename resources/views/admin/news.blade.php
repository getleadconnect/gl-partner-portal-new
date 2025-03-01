@extends('admin.master')
@section('content')
<style>
.error
{
	color:red !important;
	font-size:12px !important;
}

.dataTables_wrapper .dataTables_filter {
    float: right;
    text-align: right;
    display: flex !important;
}

.filter-select
{
	width:110px;
	height:34px;
	margin:8px 0px 8px 8px;
	border-color:#aaa !important;
}
.lbl-bold
{
	font-weight:700;
	color:#5e34a3;
}

.payment-active { color:green;}
.payment-inactive{ color:red;}
.payment-pending{ color:purple;}
.form-select option{ color:black;}
.t-amt{ font-size:14px;font-weight:600;}
.pd-view p{ margin-bottom:.3rem;}
</style>

	<div class="page-content">
        <div class="container-fluid">

            <!-- Start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">News</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                                <li class="breadcrumb-item active">News</li>
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
                                <h5 class="card-title mb-0">Manage News</h5>
                                <div>
									<!--<button id="btnAddNews" class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#add-news-modal">Add News</button>-->
									<a href="{{route('admin.add-news')}}" class="btn btn-primary" >Add News</a>
									<!--<a href="javascript:void(0);" class="btn btn-primary me-2" id="export_to_excel"><i class="fas fa-file-export"></i>&nbsp;Export</a>-->
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="padding-top:0px;">
					
                            <!--<div class="table-responsive">-->

                                <table id="news-table" class="table table-striped table-hover mb-0" style="width:100% !important;">
                                    <thead>
 										
									<tr id="tab-row">
										<th>No</th>
										<th>Title</th>
										<th>Content</th>
										<th>Actions</th>
									</tr>
										
                                    </thead>
                                    <tbody>
                                   
                                    </tbody>
                                </table>
                            <!--</div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- container-fluid -->
    </div><!-- End Page-content -->

@push('scripts')

@if (Session::get('success'))
        <script>
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                // "positionClass": "toast-top-right notification-position",
            }
            toastr.success("{{Session::get('success')}}");
        </script>
    @endif
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
    $(function () {
		
		//---------datatable -------------------------------------
				
        var table = $('#news-table').DataTable({
            processing: true,
            serverSide: true,
			stateStatus: true,
			
			"language": {
				searchPlaceholder: 'Search',
				sSearch: '',
			},
			"lengthMenu": [10, 25, 50,100,150,200],
			
            ajax: {
                url: "{{ route('admin.get-news-list') }}",
                /*data: function (d) 
                {
                    d.partner_id = $('#filter').val()   
                }*/
            },
            columns: [
            
            {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
            {data: 'title', name: 'title'},
			{data: 'news_content', name: 'news_content'},
            {data: 'action', name: 'action'},
            ],
        });

 
//---------------------------------------------------------------
        
/*$(".dataTables_filter").append(partner_filter);
$(".dataTables_filter").append(filter_status);
$(".dataTables_filter").append(filter_payment_status);*/

/*
$("#filter_status").change(function()
	{
		table.draw();
	});

$("#partner_filter").change(function()
	{
		table.draw();
	});
$("#filter_payment_status").change(function()
	{
		table.draw();
	});
*/

 $(document).on('click','.confirm_deletion',function()
        {
            $.ajax({
                    url: "{{ route('admin.delete-news') }}",
                    method: 'post',
                    data: {'_token': '{{ csrf_token() }}','news_id':$(this).data('id')},
                    success: function(result)
                    {
                        if(result.status)
                        {
                            toastr.success("News successfully removed!");
                            table.ajax.reload();
                        }
                        
                    }
                });
        })


});	
		
</script>


@endpush
@endsection