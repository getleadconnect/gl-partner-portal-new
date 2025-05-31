@extends('partner.design')
@section('style')
    {{ Html::style('styles/user-profile.css') }}
@endsection
@section('code')
    <div class="emp-profile" style="border: 1px solid #337ab7;">
        <div class="row">
            {{-- <div class="col-md-3"> --}}
            {{-- <div class="profile-img"> --}}
            {{-- <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS52y5aInsxSm31CvHOFHWujqUx_wWTS9iM6s7BAm21oEN_RiGoog" alt=""/> --}}
            {{-- <div class="file btn btn-lg btn-primary"> --}}
            {{-- Change Photo
            <input type="file" name="file"/> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- <div class="text-center profile-img"> --}}
            {{-- <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle img-thumbnail" alt="avatar"> --}}
            {{-- <h6>Upload a different photo...</h6> --}}
            {{-- <input type="file" class="text-center center-block file-upload"> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            <div class="col-md-3 col-sm-6">
                <div class="progress blue">
                    <span class="progress-left">
                        <span class="progress-bar"></span>
                    </span>
                    <span class="progress-right">
                        <span class="progress-bar"></span>
                    </span>
                    <div class="progress-value">
                        {{-- {{ dd($partner->photo) }} --}}
                        @if ($partner->photo == null)
                            {
                            <img src="/images/user_dummy.jpeg" id="partner_image" class="avatar img-circle img-thumbnail"
                                alt="avatar">
                            }
                        @else
                            <img src="/uploads/partner/{{ $partner->photo }}" id="partner_image"
                                class="avatar img-circle img-thumbnail" alt="avatar">
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="profile-head">
                    <h3>{{ $partner->name }}</h3>
                    <h6>{{ $partner->company_name ? $partner->company_name : 'GL-Partner Associate' }}</h6>
                    {{-- <p class="proile-rating">RANKINGS : <span>8/10</span></p> --}}
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item active">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                aria-controls="home" aria-selected="true">My Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                                aria-controls="profile" aria-selected="false">Edit Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="security-tab" data-toggle="tab" href="#security" role="tab"
                                aria-controls="security" aria-selected="false">Password & Security</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="verification-tab" data-toggle="tab" href="#verification" role="tab"
                                aria-controls="verification" aria-selected="false">Profile Verification</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="account-tab" data-toggle="tab" href="#account" role="tab"
                                aria-controls="account" aria-selected="false">Account Details</a>
                        </li>
                    </ul>
                </div>
            </div>
            {{-- <div class="col-md-3 col-sm-6">
                <div class="progress blue">
                  <span class="progress-left">
                    <span class="progress-bar"></span>
                  </span>
                  <span class="progress-right">
                    <span class="progress-bar"></span>
                  </span>
                  <div class="progress-value">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS52y5aInsxSm31CvHOFHWujqUx_wWTS9iM6s7BAm21oEN_RiGoog" class="avatar img-circle img-thumbnail" alt="avatar">
                  </div>
                </div>
              </div> --}}
        </div>
        <div class="row">
            <div class="col-md-3">
                {{-- <div class="col-md-12 col-sm-12 col-xs-12 user-detail-section1 text-center"> --}}
                {{-- <button id="btn-contact" (click)="clearModal()" data-toggle="modal" data-target="#contact" class="btn btn-success btn-block follow _btns">Contactarme</button> 
                  <button class="btn btn-warning btn-block _btns" type="button">Complete Your Profile</button>                               
                  <div> --}}

                <div class="profile-completion">
                    <h2>{{ $partner->name }}</h2>
                    {{-- <p>Managin Director</p> --}}
                    <h4>90 %</h4>
                    <h3>Profile Completion</h3>
                    <button class="btn btn-primary btn-block" id="complete_profile" type="button">Complete Your
                        Profile</button>
                    {{-- <button class="btn btn-success btn-block top-pad" type="button">Request Profile Verification</button> --}}
                    <br>
                </div>
                {{-- </div> --}}
                {{-- <div class="col-sm-3"><!--left col--> --}}




                {{-- </hr><br> --}}


                {{-- <div class="panel panel-default">
                        <div class="panel-heading">Website <i class="fa fa-link fa-1x"></i></div>
                        <div class="panel-body"><a href="https://partner.getleadcrm.com/">GL-PARTNER</a></div>
                      </div> --}}


                <ul class="list-group">
                    <li class="list-group-item text-muted">Activity <i class="fa fa-dashboard fa-1x"></i></li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong>Total Leads</strong></span>
                        {{ $total_leads }}</li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong>Open Leads</strong></span>
                        {{ $open_leads }}</li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong>Closed Leads</strong></span>
                        {{ $closed_leads }}</li>
                    {{-- <li class="list-group-item text-right"><span class="pull-left"><strong></strong></span> 78</li> --}}
                </ul>

                {{-- <div class="panel panel-default">
                        <div class="panel-heading">Social Media</div>
                        <div class="panel-body">
                          <i class="fa fa-facebook fa-2x"></i> <i class="fa fa-github fa-2x"></i> <i class="fa fa-twitter fa-2x"></i> <i class="fa fa-pinterest fa-2x"></i> <i class="fa fa-google-plus fa-2x"></i>
                        </div>
                      </div>
                      --}}
                {{-- </div> --}}

            </div>
            <div class="col-md-8">
                <div class="tab-content profile-tab" id="myTabContent">
                    <div class="tab-pane fade  active in" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row">
                            <div class="col-md-3"><label>Name</label></div>
                            <div class="col-md-6">
                                <p>{{ $partner->name }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"><label>Company Name</label></div>
                            <div class="col-md-6">
                                <p>{{ $partner->company_name ? $partner->company_name : '-Nil-' }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"><label>Mobile</label></div>
                            <div class="col-md-6">
                                <p>{{ $partner->mobile ? $partner->mobile : '-Nil-' }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"><label>Email</label></div>
                            <div class="col-md-6">
                                <p>{{ $partner->email ? $partner->email : '-Nil-' }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"><label>Website</label></div>
                            <div class="col-md-6">
                                <p>{{ $partner->website ? $partner->website : '-Nil-' }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"><label>Team size</label></div>
                            <div class="col-md-6">
                                <p>{{ $partner->team_size ? $partner->team_size : '-Nil-' }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"><label>Country</label></div>
                            <div class="col-md-6">
                                <p>{{ $partner->country ? $partner->country : '-Nil-' }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"><label>State</label></div>
                            <div class="col-md-6">
                                <p>{{ $partner->state ? $partner->state : '-Nil-' }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"><label>Pin</label></div>
                            <div class="col-md-6">
                                <p>{{ $partner->pin_code ? $partner->pin_code : '-Nil-' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <form action="{{ route('partner.update-profile') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="partner_id" name="partner_id" value="{{ $partner->id }}">
                            <div class="form-row row">
                                <div class="form-group col-md-6">
                                    <label for="feFirstName">Name</label>
                                    <input type="text" class="form-control" id="feFirstName" placeholder="Name"
                                        name="partner_name" value="{{ $partner->name }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="feLastName">Mobile Number</label>
                                    <input type="number" class="form-control" id="feLastName"
                                        placeholder="Mobile Number" name="mobile" value="{{ $partner->mobile }}">
                                </div>
                            </div>
                            <div class="form-row row">
                                <div class="form-group col-md-6">
                                    <label for="feEmailAddress">Email</label>
                                    <input type="email" class="form-control" id="feEmailAddress" placeholder="Email"
                                        name="email" value="{{ $partner->email }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="fePassword">Website</label>
                                    <input type="text" class="form-control" id="Website" placeholder="Website"
                                        name="website" value="{{ $partner->website }}">
                                </div>
                            </div>
                            <div class="form-row row">
                                <div class="form-group col-md-6">
                                    <label for="feEmailAddress">Company Name</label>
                                    <input type="text" class="form-control" id="company_name"
                                        placeholder="Company Name" name="company_name"
                                        value="{{ $partner->company_name }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="fePassword">Team Size</label>
                                    <input type="number" class="form-control" id="team_size" placeholder="Team Size"
                                        name="team_size" value="{{ $partner->team_size }}">
                                </div>
                            </div>
                            <div class="form-row row">
                                <div class="form-group col-md-6">
                                    <label for="feInputCity">Country</label>
                                    {!! Form::select('country', $countries, null, ['class' => 'form-control', 'id' => 'country']) !!}
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="feInputState">State</label>
                                    {!! Form::select('state', $states, $partner->state, ['class' => 'form-control', 'id' => 'state']) !!}
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputZip">Pin Code</label>
                                    <input type="text" class="form-control" id="inputZip" name="pin_code"
                                        value="{{ $partner->pin_code }}">
                                </div>
                            </div>
                            <div class="form-row row">
                                <div class="form-group col-md-6">
                                    <label for="image">Update Photo</label>
                                    <input type="file" class="form-control" id="photo" name="photo">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="image">Update Company Logo</label>
                                    <input type="file" class="form-control" id="logo" name="logo">
                                </div>
                            </div>
                            <div class="form-row row">
                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-success"> Save Changes </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="verification" role="tabpanel" aria-labelledby="verification-tab">
                        <div class="form-row row">
                            <div class="form-group col-md-6">
                                <label for="feEmailAddress"
                                    id="email-label">{{ $partner->email_verified_at == null ? 'Email you have provided' : 'Your email has been verified' }}</label>
                                <input type="email" class="form-control" id="verify-email" placeholder="Email"
                                    name="email" disabled value="{{ $partner->email }}">
                            </div>
                        </div>
                        <div class="hidden" id="otp_div">
                            <div class="form-row row">
                                <div class="form-group col-md-6">
                                    <label for="feEmailAddress">Enter the OTP received on the above mail-id</label>
                                    <input type="number" class="form-control" id="otp" placeholder="OTP"
                                        name="otp" value="">
                                </div>
                            </div>
                            <div class="form-row row">
                                <div class="form-group col-md-12">
                                    <button type="button" class="btn btn-success" id="verify_otp"> Verify OTP</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-row row">
                            <div class="form-group col-md-12">
                                @if ($partner->email_verified_at == null)
                                    <button type="button" class="btn btn-primary" id="request_verification"
                                        data-loading-text="<i class='fa fa-spinner fa-spin '></i> Sending OTP"> Request
                                        Verfication</button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab">
                        <div class="form-row row">
                            <div class="form-group col-md-6">
                                <label for="fePassword">Current Password</label>
                                <input type="password" class="form-control" id="current_password"
                                    placeholder="Current Password" name="current+password">
                            </div>
                        </div>
                        <div class="form-row row">
                            <div class="form-group col-md-6">
                                <label for="fePassword">New Password</label>
                                <input type="password" class="form-control" id="new_password" placeholder="New Password"
                                    name="new_password">
                            </div>
                        </div>
                        <div class="form-row row">
                            <div class="form-group col-md-6">
                                <label for="fePassword">Confirm Password</label>
                                <input type="password" class="form-control" id="confirm_password"
                                    placeholder="Confrim Password" name="confirm_password">
                            </div>
                        </div>
                        <div class="form-row row">
                            <div class="form-group col-md-12">
                                <button type="button" class="btn btn-success" id="change_password">Change
                                    Password</button>
                            </div>
                        </div>
                    </div>


                    <div class="tab-pane fade" id="account" role="tabpanel" aria-labelledby="account-tab">
                        <div class="form-row row">
                            <div class="form-group col-md-6">
                                <label for="feFirstName">Bank Name</label>
                                <input type="text" class="form-control" id="bank_name" placeholder="Bank Name"
                                    name="bank_name" value="{{ $partner->bank_name }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="feLastName">Branch Name</label>
                                <input type="text" class="form-control" id="branch_name" placeholder="Branch Name"
                                    name="branch_name" value="{{ $partner->branch }}">
                            </div>
                        </div>
                        <div class="form-row row">
                            <div class="form-group col-md-6">
                                <label for="feFirstName">IFSC Code</label>
                                <input type="text" class="form-control" id="ifsc_code" placeholder="IFSC Code"
                                    name="ifsc_code" value="{{ $partner->ifsc }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="feLastName">Account Number</label>
                                <input type="text" class="form-control" id="account_number"
                                    placeholder="Account Number" name="account_number"
                                    value="{{ $partner->account_number }}">
                            </div>
                        </div>
                        <div class="form-row row">
                            <div class="form-group col-md-6">
                                <label for="feFirstName">UPI ID</label>
                                <input type="text" class="form-control" id="upi_id" placeholder="UPI ID"
                                    name="upi_id" value="{{ $partner->upi_id }}">
                            </div>
                        </div>
                        <div class="form-row row">
                          <div class="form-group col-md-12">
                              <button type="button" class="btn btn-success" id="update_account_details">Save Changes</button>
                          </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('script')
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
    <script>
        $("#country").on('change', function() {
            country = $(this).val()
            $.ajax({
                url: "{{ route('country-states') }}",
                method: 'get',
                data: {
                    'country': country
                },
                success: function(result) {
                    if (result.states) {
                        $('#state').empty();
                        $.each(result.states, function(key, value) {
                            $('#state').append('<option value="' + key + '">' + value +
                                '</option>');
                        });
                    }
                }
            });
        })

        $("#complete_profile").on('click', function() {
            $("#profile-tab").trigger('click')
        })

        $("#request_verification").on('click', function() {
            var $this = $(this);
            $this.button('loading');
            $.ajax({
                url: "{{ route('partner.send-otp') }}",
                method: 'post',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'partner_id': $("#partner_id").val(),
                    'mail_id': $("#verify-email").val()
                },
                success: function(result) {
                    $this.button('reset');
                    $("#otp_div").removeClass('hidden')
                    $this.addClass('hidden')
                }
            });
        })

        $("#change_password").on('click', function() {
            if ($("#new_password").val() == $("#confirm_password").val()) {
                $.ajax({
                    url: "{{ route('partner.change-password') }}",
                    method: 'post',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'current_password': $("#current_password").val(),
                        'new_password': $("#new_password").val()
                    },
                    success: function(result) {
                        if (result.status == 1) {
                            toastr.success(result.msg);
                        } else {
                            toastr.error(result.msg);
                        }

                    }
                });
            } else {
                toastr.error("New Password & confirm Password does not match");
            }
        })

        $("#verify_otp").on('click', function() {
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
                        $("#otp_div").addClass('hidden')
                        toastr.success(result.msg);
                    } else {
                        toastr.error(result.msg);
                    }
                }
            });
        })

        $("#update_account_details").on('click', function() {
            $.ajax({
                url: "{{ route('partner.update-account-details') }}",
                method: 'post',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'partner_id': $("#partner_id").val(),
                    'bank':$("#bank_name").val(),
                    'ifsc':$("#ifsc_code").val(),
                    'account_number':$("#account_number").val(),
                    'branch':$("#branch_name").val(),
                    'upi_id':$("#upi_id").val(),
                },
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
@endsection
@endsection
