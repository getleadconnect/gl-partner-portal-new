@extends('admin.master')
@section('content')

	<div class="page-content">
        <div class="container-fluid">

            <!-- Start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Edit News</h4>
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
                                <h5 class="card-title mb-0">News</h5>
                                <div>
									<a href="{{route('admin.news')}}" class="btn btn-primary" type="button">Back To News</a>
									<!--<a href="javascript:void(0);" class="btn btn-primary me-2" id="export_to_excel"><i class="fas fa-file-export"></i>&nbsp;Export</a>-->
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="padding-top:0px;">
					
							<form  method="post" action="{{ route('admin.update-news') }}" enctype="multipart/form-data">
							@csrf
							
							<input type="hidden" name="news_id" value="{{$nws->id}}">
							
							<div class="form-group">
								<label for="recipient-name" class="form-label">Title</label>
								<input type="text" class="form-control" name="title" id="title"  value="{{$nws->title}}" required>
							</div>
							
							<div class="form-group">
								<label for="recipient-name" class="form-label">News Content</label>
								<textarea class="form-control" style="height:200px;" name="news_content" id="news_content" required>{{$nws->news_content}}</textarea>
							</div>

							<div class="form-group mt-3 mb-3" style="text-align:right;">
								<button type="submit"  class="btn btn-primary">Submit</button>
							</div>
							</form>
					

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

$(function () 
{

});	
		
</script>


@endpush
@endsection