@extends('partner.master')
@section('content')
<style>
.error
{
	color:red !important;
	font-size:12px !important;
}

.nav-pills .nav-link
{
	width:200px !important;
}

.text-left
{
	text-align:left;
}
</style>

 <div class="page-content">
	<div class="container-fluid">
            <!-- Start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">My-Settings</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('partner.dashboard')}}">Home</a></li>
                                <li class="breadcrumb-item active">Settings</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End page title -->
	
		
			@if($update_message!="")
			<div class="alert alert-warning d-flex alert-dismissible fade show" role="alert">
			  <span>{!!$update_message!!}(Click <b>Edit Profile</b> Option)</span>
			  <button type="button" class="btn-close" data-bs-dismiss="alert"  style="font-size:16px;" aria-label="Close"></button>
			</div> 
			@endif

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

							<div class="vertical-nav">
							
							<div class="d-flex align-items-start" >
							  <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical" style="padding-right:50px;border-right:1px solid #e4e4e4;">
								<button class="nav-link active text-left mb-2" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-my-profile" type="button" role="tab" aria-controls="v-pills-my-profile" aria-selected="true"><i class="fa fa-user"></i>&nbsp;&nbsp;My Profile</button>
								<button class="nav-link text-left mb-2" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-edit-profile" type="button" role="tab" aria-controls="v-pills-edit-profile" aria-selected="false"><i class="fa fa-edit"></i>&nbsp;&nbsp;Edit Profile</button>
								<button class="nav-link text-left mb-2" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-password" type="button" role="tab" aria-controls="v-pills-password" aria-selected="false"><i class="fa fa-lock"></i>&nbsp;&nbsp;Password & Security</button>
								<button class="nav-link text-left mb-2" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-verification" type="button" role="tab" aria-controls="v-pills-verification" aria-selected="false"><i class="fa fa-check"></i>&nbsp;&nbsp;Email Verification</button>
								<button class="nav-link text-left mb-2" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-account" type="button" role="tab" aria-controls="v-pills-account" aria-selected="false"><i class="fa fa-user-circle"></i>&nbsp;&nbsp;Bank Account Details</button>
							  </div>
							  <div class="tab-content" id="v-pills-tabContent" style="padding-left:30px;width:100%;">
								<!--- TAB -1 ----------->
								
								<div class="tab-pane fade show active" id="v-pills-my-profile" role="tabpanel" aria-labelledby="v-pills-my-profile-tab">
																								
								<div class="row">
								<div class="col-lg-3 col-xl-3 col-xxl-3 text-center">
									@if ($partner->photo == "")
										<img src="{{url('/images/user_dummy.png')}}" style="width:100px;height:100px;">
									@else
										<img src="{{url('/uploads/partner').'/'.$partner->photo }}" id="partner_image"
											class="avatar img-circle img-thumbnail" alt="avatar" style="width:100px;height:100px;">
									@endif
								
								<h4>{{ \Str::upper($partner->name) }}</h4>
								<h6>{{ $partner->company_name ? $partner->company_name : 'GL-Partner Associate' }}</h6>
								
								<ul class="list-group">
									<li class="list-group-item text-left"><strong>Total Leads</strong> : <span >{{ $total_leads }}</span></li>
									<li class="list-group-item text-left"><strong>Open Leads</strong> : <span >{{ $open_leads }}</span></li>
									<li class="list-group-item text-left"><strong>Business Leads</strong> : <span >{{ $business_leads }}</span></li>
								</ul>

								</div>
								<div class="col-lg-1 col-xl-1 col-xxl-1" ></div>
								
								<div class="col-lg-8 col-xl-8 col-xxl-8 " >
																
								<div class="row mt-3">
										<label class="col-lg-4">Name</label>
										<div class="col-lg-6"><p>:<strong> {{ \Str::upper($partner->name) }}</strong></p></div>
								</div>
									<div class="row">
										<label class="col-lg-4">Company Name</label>
										<div class="col-lg-6">
											<p>: {{ $partner->company_name ? $partner->company_name : '-Nil-' }}</p>
										</div>
									</div>
									<div class="row">
										<label class="col-lg-4">Mobile</label>
										<div class="col-lg-6">
											<p>: {{ $partner->mobile ? "+".$partner->country_code." ".$partner->mobile : '-Nil-' }}</p>
										</div>
									</div>
									<div class="row">
										<label class="col-lg-4">Email</label>
										<div class="col-lg-6">
											<p>: {{ $partner->email ? $partner->email : '-Nil-' }}</p>
										</div>
									</div>
									<div class="row">
										<label class="col-lg-4">Website</label>
										<div class="col-lg-6">
											<p>: {{ $partner->website ? $partner->website : '-Nil-' }}</p>
										</div>
									</div>
									<div class="row">
										<label class="col-lg-4">Team size</label>
										<div class="col-lg-6">
											<p>: {{ $partner->team_size ? $partner->team_size : '-Nil-' }}</p>
										</div>
									</div>
									<div class="row">
										<label class="col-lg-4">Country</label>
										<div class="col-lg-6">
											<p>: {{ $partner->country_name ? $partner->country_name : '-Nil-' }}</p>
										</div>
									</div>
									
									<div class="row">
										<label class="col-lg-4">State</label>
										<div class="col-lg-6">
											<p>: {{ $partner->state ? $partner->state : '-Nil-' }}</p>
										</div>
									</div>
									
									<div class="row">
										<label class="col-lg-4">City</label>
										<div class="col-lg-6">
											<p>: {{ $partner->city ? $partner->city : '-Nil-' }}</p>
										</div>
									</div>
									
									<div class="row">
										<label class="col-lg-4">Pin Code</label>
										<div class="col-lg-6">
											<p>: {{ $partner->pin_code ? $partner->pin_code : '-Nil-' }}</p>
										</div>
									</div>
			
								</div>
						
								</div>
								</div>
								<!---- TAB-2 EDIT PROFILE ---------->					
								<div class="tab-pane fade" id="v-pills-edit-profile" role="tabpanel" aria-labelledby="v-pills-edit-profile-tab">
								
								<label> <b><u>Update Profile </u></b></label>
																
									<form id="form-profile" action="{{ route('partner.update-profile') }}" method="post" enctype="multipart/form-data">
									@csrf
									<input type="hidden" id="partner_id" name="partner_id" value="{{ $partner->id }}">
									<input type="hidden" id="country_name" name="country_name" value="{{ $partner->country_name }}">
									
									<div class="form-row row">
										<div class="form-group col-md-6">
											<label for="feFirstName">Name<span style="color:red;">*</span></label>
											<input type="text" class="form-control" id="partner_name" placeholder="Name"
												name="partner_name" value="{{ $partner->name }}" required>
										</div>
										<div class="form-group col-md-6">
											<label for="feLastName">Mobile<span style="color: red;">*</span></label><br>
											<input type="hidden" class="form-control" placeholder="" name="country_code" id="country_code" value="{{ $partner->country_code }}" >
											<input type="text" class="form-control" placeholder="Mobile Number" name="mobile" id="mobile" value="{{'+'.$partner->country_code. $partner->mobile }}" required>
										</div>
									</div>
									<div class="form-row row">
										<div class="form-group col-md-6">
											<label for="feEmailAddress">Email<span style="color: red;">*</span></label>
											<input type="email" class="form-control" id="email" placeholder="Email"
												name="email" value="{{ $partner->email }}" required>
										</div>
										<div class="form-group col-md-6">
											<label for="fePassword">Website</label>
											<input type="text" class="form-control" id="website" placeholder="Website"
												name="website" value="{{ $partner->website }}">
										</div>
									</div>
									<div class="form-row row">
										<div class="form-group col-md-6">
											<label for="feEmailAddress">Company Name<span style="color: red;">*</span></label>
											<input type="text" class="form-control" id="company_name"
												placeholder="Company Name" name="company_name"
												value="{{ $partner->company_name }}" required>
										</div>
										<div class="form-group col-md-6">
											<label for="fePassword">Team Size</label>
											<input type="number" class="form-control" id="team_size" placeholder="Team Size"
												name="team_size" value="{{ $partner->team_size }}">
										</div>
									</div>
									<div class="form-row row">
											<div class="form-group col-md-3 col-lg-3">
												<label for="feInputCity">Country<span style="color: red;">*</span></label>
												<select name="country" id="country" class="form-control">
												<option value="" > select </option>
												@foreach($countries as $key=>$value)
													<option value="{{$key}}" @if($key==$partner->country){{__('selected')}}@endif>{{$value}}</option>
												@endforeach
												</select>
											</div>
											
											<div class="form-group col-md-3 col-lg-3">
												<label for="feInputState">State<span style="color: red;">*</span></label>
												
												<select name="state" id="state" class="form-control">
												<option value="" > select </option>
												@foreach($states as $key=>$values)
													<option value="{{$values}}" @if($values==$partner->state){{__('selected')}}@endif>{{$values}}</option>
												@endforeach
												</select>
											</div>
											
											<div class="form-group col-md-3 col-lg-3">
												<label for="feInputState">City<span style="color: red;">*</span></label>
												<input type="text" class="form-control" id="city" name="city"
													value="{{ $partner->city }}" >
											</div>
											
											<div class="form-group col-md-2">
												<label for="inputZip">Pin Code<span style="color: red;">*</span></label>
												<input type="text" class="form-control" id="pin_code" name="pin_code"
													value="{{ $partner->pin_code }}" >
											</div>
											</div>
											<div class="form-row row">
												<div class="form-group col-lg-4">
													<label for="image">Update Photo</label>
													<input type="file" class="form-control" id="photo" name="photo">
												</div>
												<div class="form-group col-lg-2 pt-2">
												@if ($partner->photo == null)
														<img src="/images/user_dummy.jpeg" id="photoUrl" style="width:100px;height:100px;">
												@else
														<img src="/uploads/partner/{{ $partner->photo }}" id="photoUrl" style="width:70px;height:70px;">
												@endif
													</div>
																								
												<div class="form-group col-md-4">
													<label for="image">Update Company Logo</label>
													<input type="file" class="form-control" id="logo" name="logo">
												</div>
												<div class="form-group col-lg-2 pt-2">
												
												@if ($partner->company_logo == null)
														<img src="/images/user_dummy.jpeg" id="logoUrl" style="width:100px;height:100px;">
												@else
														<img src="/uploads/partner/{{ $partner->company_logo }}" id="logoUrl" style="width:70px;height:70px;">
												@endif
												</div>
												
											</div>
											<div class="form-row row mt-3">
												<div class="form-group col-md-12">
													<button type="submit" class="btn btn-success"> Save Changes </button>
												</div>
											</div>
										</form>
													
													
								</div>
								
								<!--- TAB 3 CHANGE PASSWORD --------------------------->
										
								<div class="tab-pane fade" id="v-pills-password" role="tabpanel" aria-labelledby="v-pills-password-tab">
								
									<label><b><u>Change User Password</u></b></label>
								
										<form id="changePasswordForm">
										@csrf
											<div class="form-row row">
												<div class="form-group col-md-6">
													<label for="fePassword">Current Password<span style="color: red;">*</span></label>
													<input type="password" class="form-control" id="current_password"
														placeholder="" name="current_password" required>
												</div>
											</div>
											<div class="form-row row">
												<div class="form-group col-md-6">
													<label for="fePassword">New Password<span style="color: red;">*</span></label>
													<div style="position:relative;">
													  <input class="form-control form-control-solid h-auto" type="password"
														placeholder="Type your password here" name="new_password" id="new_password" minlength=5 maxlength=30 autocomplete="off" required />
														<span id="toggle_pwd" class="fa fa-fw field-icon-eye fa-eye mt-5"></span>
													</div>
												</div>
											</div>
											<div class="form-row row">
												<div class="form-group col-md-6">
													<label for="fePassword">Confirm Password<span style="color: red;">*</span></label>
													<div style="position:relative;">
													    <input class="form-control form-control-solid h-auto" type="password"
														placeholder="Type your password here" name="confirm_password" id="confirm_password" minlength=5 maxlength=30 autocomplete="off" required />
														<span id="conf_toggle_pwd" class="fa fa-fw field-icon-eye fa-eye mt-5"></span>
													</div>
														
												</div>
												<label id="err-msg" style="color:red;font-size:12px;"></label>
											</div>
											<div class="form-row row mt-3">
												<div class="form-group col-md-12">
													<button type="submit" id="changePass" class="btn btn-success" id="change_password">Change Password</button>
												</div>
											</div>
										</form>
									</div>

								
								<div class="tab-pane fade" id="v-pills-verification" role="tabpanel" aria-labelledby="v-pills-verification-tab">
								
								<label><b><u>Email Verification</u></b></label>
														
								
								<div class="form-row row">
									<div class="form-group col-md-6">
										<label for="feEmailAddress"
											id="email-label">{{ $partner->email_verified_at == null ? 'Email you have provided' : 'Your email has been verified' }}</label>
										<input type="email" class="form-control" id="verify-email" placeholder="Email"
											name="email" disabled value="{{ $partner->email }}" required>
									</div>
								</div>
								
								<div class="hide" id="otp_div">
									<div class="form-row row">
										<div class="form-group col-md-6">
											<label for="feEmailAddress">Enter the OTP received on the above mail-id</label>
											<input type="number" class="form-control" id="otp" placeholder="OTP"
												name="otp" value="" required>
										</div>
									</div>
									<div class="form-row row">
										<div class="form-group col-md-12">
											<button type="button" class="btn btn-success mt-3" id="verify_otp"> Verify OTP</button>
										</div>
									</div>
								</div>
								
								<div class="form-row row">
									<div class="form-group col-md-12">
										@if ($partner->email_verified_at == null)
											<button type="button" class="btn btn-primary mt-3" id="request_verification"
												data-loading-text="<i class='fa fa-spinner fa-spin '></i> Sending OTP"> Request
												Verfication</button>
										@endif
									</div>
								</div>
							</div>
							
							<!-- TAB-5 ACCOUNT SETTINGS ------------------------>
							
								<div class="tab-pane fade" id="v-pills-account" role="tabpanel" aria-labelledby="v-pills-account-tab">
							
								<label><b><u>Bank Account Details</u></b></label>
								
								<div class="row">
								<div class="col-lg-6 col-xl-6 col-xxl-6">
								
									<form id="accountDetails">
									@csrf
									<input type="hidden" name="partner_id" value="{{$partner->id}}">
									
									<div class="form-group">
										<label for="feFirstName">Bank Name<span style="color: red;">*</span></label>
										<input type="text" class="form-control" id="bank_name" placeholder=""
											name="bank_name" value="{{ $partner->bank_name }}" required>
									</div>
									
									<div class="form-group">
										<label for="feLastName">Branch Name<span style="color: red;">*</span></label>
										<input type="text" class="form-control" id="branch_name" placeholder=""
											name="branch_name" value="{{ $partner->branch }}" required>
									</div>

									<div class="form-group">
										<label for="feFirstName">IFSC Code<span style="color: red;">*</span></label>
										<input type="text" class="form-control" id="ifsc_code" placeholder=""
											name="ifsc_code" value="{{ $partner->ifsc }}" required>
									</div>
									
									<div class="form-group">
										<label for="feLastName">Account Number<span style="color: red;">*</span></label>
										<input type="text" class="form-control" id="account_number"
											placeholder="" name="account_number"
											value="{{ $partner->account_number }}" required>
									</div>
																
									<div class="form-group">
										<label for="feFirstName">UPI ID</label>
										<input type="text" class="form-control" id="upi_id" placeholder=""
											name="upi_id" value="{{ $partner->upi_id }}">
									</div>
									
									<div class="form-group mt-3">
										  <button type="submit" class="btn btn-success" id="update_account_details">Save Changes</button>
								    </div>
									
									</form>
								
								</div>
							  </div>
							</div>
							
							</div>
	
                            
                        </div>
                    </div>
                </div>
            </div>
         
        </div> <!-- container-fluid -->
    </div>

    <!-- End Page-content -->

@push('scripts')

    @if (Session::get('success'))
        <script>
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                // "positionClass": "toast-top-right notification-position",
            }
            toastr.success("Your profile has been updated successfully !!!");
        </script>
    @endif


<script type="text/javascript">
$("#toggle_pwd").click(function() 
{
  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $("#new_password");
  if (input.attr("type") === "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});



$("#conf_toggle_pwd").click(function() 
{
  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $("#confirm_password");
  if (input.attr("type") === "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});



var phone_number = window.intlTelInput(document.querySelector("#mobile"), {
	  separateDialCode: true,
	  preferredCountries:["in"],
	  hiddenInput: "full_number",
	  utilsScript:"{{url('assets/intl-tel-input17.0.3/utils.js')}}"
	});
	
	
$("#form-profile").submit(function()
{
	var code=phone_number.getSelectedCountryData()['dialCode'];
	$("#country_code").val(code);
});

    $(function () {
    toastr.options = {
        // "positionClass": "toast-top-right cp",
        "showDuration": "300000",
        "hideMethod": "fadeOut"
        }
    });
	
photo.onchange = evt => {
  const [file] = photo.files

        var allowedExtensions="";
	    allowedExtensions = /(\.jpg|\.jpeg|\.jpe|\.png)$/i; 
	    var filePath = file.name;
		console.log(file);
	
		if (!allowedExtensions.exec(filePath)) { 
			alert('Invalid file type, Try again.'); 
			$("#photoUrl").prop('src','');
		}
		else
		{
			if (file) {
				photoUrl.src = URL.createObjectURL(file)
			  }
		}  
}

logo.onchange = evt => {
  const [file] = logo.files

        var allowedExtensions="";
	    allowedExtensions = /(\.jpg|\.jpeg|\.jpe|\.png)$/i; 
	    var filePath = file.name;
		console.log(file);
	
		if (!allowedExtensions.exec(filePath)) { 
			alert('Invalid file type, Try again.'); 
			$("#logoUrl").prop('src','');
		}
		else
		{
			if (file) {
				logoUrl.src = URL.createObjectURL(file)
			  }
		}  
}

        $("#country").on('change',function()
        {
            country = $(this).val()
			
			var country_name=($.trim($('#country option:selected').text())!="select")?$('#country option:selected').text():null;
			$("#country_name").val(country_name);
			
            $.ajax({
                    url: "{{ route('country-states') }}",
                    method: 'get',
                    data: {'country':country},
                    success: function(result)
                    {
                        if(result.states)
                        {
                            $('#state').empty();
							$('#state').append('<option value="">select</option>');
                            $.each(result.states, function(key, value) {
                                $('#state').append('<option value="'+ value +'">'+ value +'</option>');
                            });
                        }
                    }
                });
        })

        $("#plan_type").on('change',function()
        {
            plan_type = $(this).val()

            $.ajax({
                    url: "{{ route('get-plans') }}",
                    method: 'get',
                    data: {'plan_type':plan_type},
                    success: function(result)
                    {
                        $('#plan').html('<option value="" selected disabled>select</option>');
                        $('#plan').append(result.data);
                    }
                });
        })
       

		$('#changePasswordForm').validate({ 
                rules: {
                },
                submitHandler: function(form) 
                {
					$("#err-msg").html('');
					if($("#new_password").val()!=$("#confirm_password").val())
					{
						$("#err-msg").html('<span>Confirm password is not matching.</span>');
					}
					else
					{
					
						$.ajax
						({
						url: "{{ route('partner.change-password') }}",
						method: 'post',
						data: $('#changePasswordForm').serialize(),
						success: function(result)
							{
								if(result.status == 1)
								{
									toastr.success(result.msg);
									$('#changePasswordForm')[0].reset();
								}
								else{
									toastr.error(result.msg);
								}
							}
						});
					  }
				  }
                });


    $("#request_verification").on('click', function() {
            var $this = $(this);
            $this.attr('disabled',true).html('Sending <i class="fa fa-spinner fa-spin"></i>');
			
            $.ajax({
                url: "{{ route('partner.send-otp') }}",
                type: 'post',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'partner_id': $("#partner_id").val(),
                    'email_id': $("#verify-email").val()
                },
                success: function(result) 
				{
					if(result.status==1)
					{
						toastr.success(result.msg);
						$this.button('reset');
						$("#otp_div").removeClass('hide')
						$this.addClass('hide')
					}
					else
					{
						toastr.error(result.msg);
					}
                }
            });
        })


 $("#verify_otp").on('click', function() {
	 
	 if($.trim($("#otp").val())=="")
	 {
		toastr.error("Otp missing, Try again.!"); 
	 }
	 else
	 {
		$.ajax({
			url: "{{ route('partner.verify-otp') }}",
			method: 'post',
			data: {
				'_token': '{{ csrf_token() }}',
				'partner_id': $("#partner_id").val(),
				'otp': $("#otp").val(),
			},
			success: function(result) {
				if (result.status == 1) {
					$("#email-label").html("Your email has been verified")
					$("#otp_div").addClass('hide')
					toastr.success(result.msg);
				} else {
					toastr.error(result.msg);
				}
			}
		});
	 }
})

   $("form#accountDetails").on('submit', function(e) 
   {
	   e.preventDefault();

            $.ajax({
                url: "{{ route('partner.update-account-details') }}",
                type: 'post',
				dataType:'json',
                data: $('#accountDetails').serialize(),
                success: function(result) {
                    if (result.status == 1) {

                        toastr.success('Details updated successfully !!!');
                    } else {
                        toastr.error(result.msg);
                    }
                }
            });
    })

		
</script>

@endpush
@endsection