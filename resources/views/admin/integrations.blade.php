@extends('admin.master')
@section('content')
<style>
    .col-md-3 a {
        text-decoration: none;
        color: inherit;
    }
    .col-md-3 img {
        max-width: 100px;
        height: auto;
    }
</style>

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Integrations</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                                <li class="breadcrumb-item active">Integrations</li>
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
                            <h5 class="card-title mb-0">Integrate with Other Apps</h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-md-3 mb-4">
                                    <a href="integration-detail.php?integration=whatsapp">
                                        <img src="{{asset('assets/images/whatsapp.jpg')}}" alt="WhatsApp" class="img-fluid" />
                                        <p class="mt-2">WhatsApp</p>
                                    </a>
                                </div>
                                <div class="col-md-3 mb-4">
                                    <a href="integration-detail.php?integration=paypal">
                                        <img src="{{asset('assets/images/paypal.png')}}" alt="PayPal" class="img-fluid" />
                                        <p class="mt-2">PayPal</p>
                                    </a>
                                </div>
                                <div class="col-md-3 mb-4">
                                    <a href="integration-detail.php?integration=email">
                                        <img src="{{asset('assets/images/email.jpg')}}" alt="Email" class="img-fluid" />
                                        <p class="mt-2">Email</p>
                                    </a>
                                </div>
                                <div class="col-md-3 mb-4">
                                    <a href="integration-detail.php?integration=sms">
                                        <img src="{{asset('assets/images/sms.png')}}" alt="SMS" class="img-fluid" />
                                        <p class="mt-2">SMS</p>
                                    </a>
                                </div>
                                <div class="col-md-3 mb-4">
                                    <a href="integration-detail.php?integration=mailchimp">
                                        <img src="{{asset('assets/images/mailchimp.png')}}" alt="MailChimp" class="img-fluid" />
                                        <p class="mt-2">MailChimp</p>
                                    </a>
                                </div>
                                <!-- Add more integrations as needed -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
@push('scripts')

@endpush
@endsection

