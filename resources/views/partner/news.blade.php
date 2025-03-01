@extends('partner.master')
@section('content')
<style>
.offcanvas.offcanvas-end
{
	width:50% !important;
}
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
                                <<li class="breadcrumb-item"><a href="{{route('partner.dashboard')}}">Home</a></li>
                                <li class="breadcrumb-item active">News</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End page title -->

            <div class="row">
			
			@foreach($news as $nws)
			    <div class="col-4">

                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0"><a href="#" class="news-content" id="{{$nws->id}}" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight">{{$nws->title}}</a></h5>
								<div>
									<!-- content ----->
								</div>
                            </div>
                        </div>
                        <div class="card-body">
						{!! \Str::substr($nws->news_content,0,300)."......" !!}
                        </div>
                    </div>
					
                </div>
				
			@endforeach

            </div>

         
        </div> <!-- container-fluid -->
    </div>   <!-- End Page-content -->

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
	  
</div>


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

<script>


$(function () 
 {

	$(document).on('click', '.news-content', function ()
	{
	  $("#offcanvasRight").html('');
	   var id=$(this).attr('id');
		var Result=$("#offcanvasRight");
		jQuery.ajax({
			type: "GET",
			url: "{{url('partner/get-news-data')}}"+"/"+id,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
				Result.html(res);
			}
		});
	});

});
	
</script>

@endpush
@endsection