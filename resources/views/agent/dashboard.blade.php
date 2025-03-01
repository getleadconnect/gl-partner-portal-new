@extends('agent.master')
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

            <!-- Welcome Message -->
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-success text-center" role="alert">
                        <h4 class="alert-heading">Welcome Back, {{ Auth::guard('agent')->user()->name }}</h4>
                        <p>Manage your partners and leads effectively with our comprehensive dashboard.</p>
                    </div>
                </div>
            </div>

            <!-- Latest Leads -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Latest Leads</h5>
                            <div class="table-responsive">
                                
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
        
</script>
@endpush

@endsection
