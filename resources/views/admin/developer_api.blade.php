@extends('admin.master')
@section('content')
<style>
.error
{
	color:red !important;
	font-size:12px !important;
}
</style>
 <div class="page-content">
        <div class="container-fluid">

            <!-- Start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Agents</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                                <li class="breadcrumb-item active">Agents</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End page title -->
			
			

            <div class="row">
                <div class="col-lg-3 col-xl-3 col-xxl-3">

                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">API Navigation</h5>
                                <div>
									<!--<button  class="btn btn-primary" type="button" >Add</button>-->
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

							<ul class="nav flex-column">
                                <li class="nav-item"><a class="nav-link" href="#introduction">Introduction</a></li>
                                <li class="nav-item"><a class="nav-link" href="#authentication">Authentication</a></li>
                                <li class="nav-item"><a class="nav-link" href="#endpoints">API Endpoints</a></li>
                                <ul>
                                    <li class="nav-item"><a class="nav-link" href="#get-event">Get Event Details</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#create-event">Create New Event</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#update-event">Update Event</a></li>
                                    <!-- Add more endpoints as needed -->
                                </ul>
                                <li class="nav-item"><a class="nav-link" href="#error-handling">Error Handling</a></li>
                            </ul>	
			
						</div>

					</div>
					</div> <!-- col-end ---------->
					<div class="col-lg-9 col-xl-9 col-xxl-9">
						
					<div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">API Documentation</h5>
                                <div>
									<!--<button  class="btn btn-primary" type="button" >Add</button>-->
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <section id="introduction">
                                <h5>Introduction</h5>
                                <p>Welcome to the Developer API documentation. This API allows developers to interact with our event management system programmatically. Below you will find the necessary information to get started, including authentication details, API endpoints, and example requests and responses.</p>
                            </section>

                            <section id="authentication">
                                <h5>Authentication</h5>
                                <p>All API requests must be authenticated using an API key. You can obtain your API key by logging into your account and navigating to the API section.</p>
                                <pre><code class="language-bash">Authorization: Bearer YOUR_API_KEY</code></pre>
                            </section>

                            <section id="endpoints">
                                <h5>API Endpoints</h5>

                                <section id="get-event">
                                    <h6>1. Get Event Details</h6>
                                    <p>Retrieve details of a specific event.</p>
                                    <pre><code class="language-bash">GET /api/events/{event_id}</code></pre>
                                    <pre><code class="language-json">
{
    "event_id": "123",
    "name": "Sample Event",
    "date": "2024-07-02",
    "location": "Sample Location"
}
                                    </code></pre>
                                </section>

                                <section id="create-event">
                                    <h6>2. Create New Event</h6>
                                    <p>Create a new event in the system.</p>
                                    <pre><code class="language-bash">POST /api/events</code></pre>
                                    <pre><code class="language-json">
{
    "name": "New Event",
    "date": "2024-07-10",
    "location": "New Location"
}
                                    </code></pre>
                                    <pre><code class="language-json">
{
    "message": "Event created successfully",
    "event_id": "124"
}
                                    </code></pre>
                                </section>

                                <section id="update-event">
                                    <h6>3. Update Event</h6>
                                    <p>Update an existing event.</p>
                                    <pre><code class="language-bash">PUT /api/events/{event_id}</code></pre>
                                    <pre><code class="language-json">
{
    "name": "Updated Event",
    "date": "2024-07-15",
    "location": "Updated Location"
}
                                    </code></pre>
                                    <pre><code class="language-json">
{
    "message": "Event updated successfully"
}
                                    </code></pre>
                                </section>

                                <!-- Add more endpoints as needed -->
                            </section>

                            <section id="error-handling">
                                <h5>Error Handling</h5>
                                <p>In case of errors, the API will return appropriate HTTP status codes and error messages.</p>
                                <pre><code class="language-json">
{
    "error": "Invalid API key",
    "code": 401
}
                                </code></pre>
                            </section>
                        </div>

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
<!-- Include syntax highlighting library for code blocks -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/themes/prism.min.css" rel="stylesheet" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/prism.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/components/prism-bash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/components/prism-json.min.js"></script>

@endpush
@endsection