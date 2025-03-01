@extends('partner.design')
@section('code')
<div class="row">
    <div class="col-lg-12">
        <div class="page-header align_btn">
            <h2 class="">Partner Profile</h2>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Update Your Profile
            </div>
            <div class="panel-body">
                <form>
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="feFirstName">Name</label>
                        <input type="text" class="form-control" id="feFirstName" placeholder="Name" name="partner_name" value="{{ $partner->name }}">
                      </div>
                      <div class="form-group col-md-6">
                        <label for="feLastName">Mobile Number</label>
                        <input type="number" class="form-control" id="feLastName" placeholder="Mobile Number" name="mobile" value="{{ $partner->mobile }}">
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="feEmailAddress">Email</label>
                        <input type="email" class="form-control" id="feEmailAddress" placeholder="Email" name="email" value="{{ $partner->email }}">
                      </div>
                      <div class="form-group col-md-6">
                        <label for="fePassword">Website</label>
                        <input type="text" class="form-control" id="Website" placeholder="Website" name="website" value="{{ $partner->website }}">
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="feEmailAddress">Company Name</label>
                        <input type="text" class="form-control" id="company_name" placeholder="Company Name" name="company_name" value="{{ $partner->company_name }}">
                      </div>
                      <div class="form-group col-md-6">
                        <label for="fePassword">Team Size</label>
                        <input type="number" class="form-control" id="team_size" placeholder="Team Size" name="team_size" value="{{ $partner->team_size }}">
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="feInputCity">Country</label>
                        <input type="text" class="form-control" id="feInputCity">
                      </div>
                      <div class="form-group col-md-4">
                        <label for="feInputState">State</label>
                        <select id="feInputState" class="form-control">
                          <option selected="">Choose...</option>
                          <option>...</option>
                        </select>
                      </div>
                      <div class="form-group col-md-2">
                        <label for="inputZip">Pin Code</label>
                        <input type="text" class="form-control" id="inputZip" name="mobile" value="{{ $partner->mobile }}">
                      </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </div>
                  </form>
            </div>
        </div>
    </div>
</div>
@endsection