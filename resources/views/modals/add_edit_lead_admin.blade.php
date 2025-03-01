<div class="modal fade" id="add_lead_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLongTitle">Add Lead</h4>
                <button type="button" class="close form-close" data-dismiss="modal" aria-label="Close" id="close_btn">
                </button>
            </div>
            <form class="kt-form kt-form--label-right" id="lead-form">
                @csrf
                <div class="row modal-body">
                    <div class="col-md-6 form-group">
                        <label for="recipient-name" class="form-control-label">Customer Name<span
                                style="color: red;">*</span></label>
                        <input type="text" class="form-control" placeholder="Customer Name"
                            value="{{ old('name') }}" name="name" id="name" required>
                    </div>
                    {{-- <div class="col-md-6 form-group">
                        <label for="recipient-name" class="form-control-label">Mobile Number<span
                                style="color: red;">*</span></label>
                        <input type="number" class="form-control" placeholder="Mobile Number"
                            value="{{ old('mobile') }}" name="mobile" id="mobile" required>
                    </div> --}}
					
                    <div class="col-md-6 form-group">
                        <label for="recipient-name" class="form-control-label">Mobile Number<span
                                style="color: red;">*</span></label>
                        <input type="number" class="form-control" placeholder="Mobile Number"
                            value="{{ old('mobile') }}" name="mobile" id="mobile" minlength=6 maxlength=15 required>
                    </div>
                    {{-- <div class="col-md-3 form-group">
                        <label for="recipient-name" class="form-control-label">Alernative Number</label>
                        <input type="number" class="form-control" placeholder="Alernative Number"
                            value="{{ old('mobile') }}" name="mobile_optional" id="mobile_optional" >
                    </div> --}}
                    <div class="col-md-6 form-group">
                        <label for="recipient-name" class="form-control-label">Company Name(your firm)</label>
                        <input type="text" class="form-control" placeholder="Company Name(your firm)"
                            value="{{ old('company_name') }}" name="company_name" id="company_name">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="recipient-name" class="form-control-label">Designation<span
                                style="color: red;">*</span></label>
                        <input type="text" class="form-control" placeholder="Designation"
                            value="{{ old('designation') }}" name="designation" id="designation" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="recipient-name" class="form-control-label">Email</label>
                        <input type="email" class="form-control" placeholder="Email"
                            value="{{ old('email') }}" name="email" id="email">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="recipient-name" class="form-control-label">Select Partner</label>
                        {!! Form::select('partner_id', $all_partners, null, ['class' => 'form-control selectpicker','data-live-search'=>'true','id'=>'partner_id','title'=>'Select partner']) !!}
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="recipient-name" class="form-control-label">Lead Type</label>
                        <select id="plan_type" name="plan_type" class="form-control">
                            <option value="0" selected disabled>Lead Type</option>
                            <option value="1" selected>Product</option>
                            <option value="2">Service</option>
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="recipient-name" class="form-control-label">Lead Purpose</label>
                        <select id="plan" name="plan" class="form-control" name="plan">
                        </select>
                        {{-- {!! Form::select('lead_purpose[]', $products, null, ['class' => 'form-control selectpicker','multiple','title'=>'Select Lead Purpose','required']) !!} --}}
                        {{-- <select id="plan" name="plan" class="form-control" name="plan">
                        </select> --}}
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="recipient-name" class="form-control-label">Country</label>
                        {!! Form::select('country', $countries, null, ['class' => 'form-control','id'=>'country']) !!}
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="recipient-name" class="form-control-label">State</label>
                        <select name="state" id="state" class="form-control">
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="recipient-name" class="form-control-label">Area/Location</label>
                        <input type="text" class="form-control" placeholder="Area/Location"
                            value="{{ old('area') }}" name="area" id="area">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="recipient-name" class="form-control-label">Pincode</label>
                        <input type="text" class="form-control" placeholder="Pincode"
                            value="{{ old('pincode') }}" name="pincode" id="pincode">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="recipient-name" class="form-control-label">Address</label>
                        <textarea class="form-control" name="address" id="address" placeholder="Address">{{ old('address') }}</textarea>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="recipient-name" class="form-control-label">Remarks</label>
                        <textarea class="form-control" name="remarks" id="remarks" placeholder="Remarks">{{ old('remarks') }}</textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="cancel_action"
                        data-dismiss="modal">Close</button>
                    <button type="submit" id="lead_submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="edit_lead_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLongTitle">Edit Lead</h4>
                <button type="button" class="close form-close" data-dismiss="modal" aria-label="Close" id="close_btn">
                </button>
            </div>
            <form class="kt-form kt-form--label-right" id="edit-lead-form">
                @csrf
                <input type="hidden" id="lead_id" name="lead_id">
                <div class="row modal-body">
                    <div class="col-md-6 form-group">
                        <label for="recipient-name" class="form-control-label">Customer Name<span
                                style="color: red;">*</span></label>
                        <input type="text" class="form-control" placeholder="Customer Name"
                            value="{{ old('name') }}" name="edit_name" id="edit_name" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="recipient-name" class="form-control-label">Mobile Number<span
                                style="color: red;">*</span></label>
                        <input type="number" class="form-control" placeholder="Mobile Number"
                            value="{{ old('mobile') }}" name="edit_mobile" id="edit_mobile" minlength=6 maxlength=15 required>
                    </div>
                    {{-- <div class="col-md-3 form-group">
                        <label for="recipient-name" class="form-control-label">Alternate Number<span
                                style="color: red;">*</span></label>
                        <input type="number" class="form-control" placeholder="Alternate Number"
                            value="{{ old('mobile') }}" name="edit_optional_mobile" id="edit_optional_mobile" required>
                    </div> --}}
                    <div class="col-md-6 form-group">
                        <label for="recipient-name" class="form-control-label">Company Name(your firm)</label>
                        <input type="text" class="form-control" placeholder="Company Name(your firm)"
                            value="{{ old('company_name') }}" name="edit_company_name" id="edit_company_name">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="recipient-name" class="form-control-label">Designation<span
                                style="color: red;">*</span></label>
                        <input type="text" class="form-control" placeholder="Designation"
                            value="{{ old('designation') }}" name="edit_designation" id="edit_designation" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="recipient-name" class="form-control-label">Email</label>
                        <input type="email" class="form-control" placeholder="Email"
                            value="{{ old('email') }}" name="edit_email" id="edit_email">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="recipient-name" class="form-control-label">Select Partner</label>
                        {!! Form::select('edit_partner_id', $all_partners, null, ['class' => 'form-control selectpicker','data-live-search'=>'true','id'=>'edit_partner_id','title'=>'Select partner']) !!}
                        {{-- {!! Form::select('partner_id', $partners, null, ['class' => 'form-control selectpicker','data-live-search'=>'true','id'=>'edit_partner_id']) !!} --}}
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="recipient-name" class="form-control-label">Lead Type</label>
                        <select id="edit_plan_type" name="edit_plan_type" class="form-control">
                            <option value="0" selected disabled>Lead Type</option>
                            <option value="1" selected>Product</option>
                            <option value="2">Service</option>
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="recipient-name" class="form-control-label">Lead Purpose</label>
                        {{-- {!! Form::select('edit_lead_purp', $product_services, null, ['class' => 'form-control selectpicker','multiple','title'=>'Select Lead Purpose','required','id'=>'edit_lead_purpose']) !!} --}}
                        <select id="edit_plan" name="edit_plan" class="form-control" name="plan">
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="recipient-name" class="form-control-label">Country</label>
                        {!! Form::select('edit_country', $countries, null, ['class' => 'form-control','id'=>'edit_country']) !!}
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="recipient-name" class="form-control-label">State</label>
                        <select name="edit_state" id="edit_state" class="form-control">
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="recipient-name" class="form-control-label">Area/Location</label>
                        <input type="text" class="form-control" placeholder="Area/Location"
                            value="{{ old('area') }}" name="edit_area" id="edit_area">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="recipient-name" class="form-control-label">Pincode</label>
                        <input type="text" class="form-control" placeholder="Pincode"
                            value="{{ old('pincode') }}" name="edit_pincode" id="edit_pincode">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="recipient-name" class="form-control-label">Address</label>
                        <textarea class="form-control" name="edit_address" id="edit_address" placeholder="Address">{{ old('address') }}</textarea>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="recipient-name" class="form-control-label">Remarks</label>
                        <textarea class="form-control" name="edit_remarks" id="edit_remarks" placeholder="Remarks">{{ old('remarks') }}</textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="cancel_action"
                        data-dismiss="modal">Close</button>
                    <button type="submit" id="update_lead" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>