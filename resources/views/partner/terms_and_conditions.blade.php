@extends('partner.master')
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
   
     
</script>
@endpush

@endsection
