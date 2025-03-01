<form  id="edit-lead-form">
	@csrf
	<input type="hidden" id="lead_id" name="lead_id" value="{{$lead->id}}">
	<input type="hidden" name="edit_country_name" id="edit_country_name" value="{{$lead->country_name}}">

	<div class="row" style="margin:0px 10px ;">
		<div class="col-md-6 form-group">
			<label for="recipient-name" class="form-control-label">Customer Name<span
					style="color: red;">*</span></label>
			<input type="text" class="form-control" placeholder=""
				value="{{ $lead->name }}" name="edit_name" id="edit_name"  required>
		</div>
		<div class="col-md-6 form-group">
			<label for="recipient-name" class="form-control-label">Mobile Number <span
					style="color: red;">*</span></label><br>
			<input type="hidden" class="form-control" placeholder="" value="{{ $lead->country_code }}" name="edit_country_code" id="edit_country_code">
			<input type="tel" class="form-control" placeholder="" value="{{'+'.$lead->country_code.$lead->mobile }}"  name="edit_mobile" id="edit_mobile" minlength=6 maxlength=15 required >
		</div>
		
		<div class="col-md-6 form-group">
			<label for="recipient-name" class="form-control-label">Company Name(your firm)<span style="color: red;">*</span></label>
			<input type="text" class="form-control" placeholder=""
				value="{{ $lead->company_name }}" name="edit_company_name" id="edit_company_name" required>
		</div>
		<div class="col-md-6 form-group">
			<label for="recipient-name" class="form-control-label">Designation</label>
			<input type="text" class="form-control" placeholder=""
				value="{{ $lead->designation}}" name="edit_designation" id="edit_designation" >
		</div>
		<div class="col-md-6 form-group">
			<label for="recipient-name" class="form-control-label">Email<span style="color: red;">*</span></label>
			<input type="email" class="form-control" placeholder=""
				value="{{ $lead->email}}" name="edit_email" id="edit_email" required>
		</div>
		<div class="col-md-6 form-group">
		<label for="recipient-name" class="form-control-label">Business Category<span style="color: red;">*</span></label>
			<select id="edit_bussiness_category_id" name="edit_bussiness_category_id" class="form-control" required>
                      <option value="0" selected disabled>select</option>
					  @foreach($bussiness_categories as $key=>$value)
					  <option value="{{$key}}" @if($key==$lead->bussiness_category_id){{__('selected')}}@endif>{{$value}}</option>
					  @endforeach
            </select>
		</div>
				
		{{-- <!--<div class="col-md-6 form-group">
			<label for="recipient-name" class="form-control-label">Lead Type<span style="color: red;">*</span></label>
			<select id="edit_plan_type" name="edit_plan_type" class="form-control" required>
				<option value="0" selected disabled>Lead Type</option>
				<option value="1" @if($lead->plan_type==1){{__('selected')}}@endif>Product</option>
				<option value="2" @if($lead->plan_type==2){{__('selected')}}@endif>Service</option>
			</select>
		</div>--> --}}
		
		{{-- <!--<div class="col-md-6 form-group">
			<label for="recipient-name" class="form-control-label">Select Plan<span style="color: red;">*</span></label>
			<select id="edit_plan" name="edit_plan" class="form-control" name="plan" required>
			@foreach($plan as $key=>$value)
				<option value="{{$key}}" @if($lead->plan_id==$key){{__('selected')}}@endif>{{$value}}</option>
			@endforeach
			</select>
		</div>--> --}}
		
		<div class="col-md-6 form-group">
			<label for="recipient-name" class="form-control-label">Country</label>
			<select name="edit_country" id="edit_country" class="form-control">
			@foreach($countries as $key=>$value)
				<option value="{{$key}}" @if($key==$lead->country){{__('selected')}}@endif>{{$value}}</option>
			@endforeach
			</select>
		</div>
		<div class="col-md-6 form-group">
			<label for="recipient-name" class="form-control-label">State</label>
			<select name="edit_state" id="edit_state" class="form-control" >
			@foreach($states as $key=>$svalue)
				<option value="{{$svalue}}" @if($svalue==$lead->state){{__('selected')}}@endif>{{$svalue}}</option>
			@endforeach
			</select>
		</div>
		<div class="col-md-6 form-group">
			<label for="recipient-name" class="form-control-label">Area/Location</label>
			<input type="text" class="form-control" placeholder=""
				value="{{ $lead->area}}" name="edit_area" id="edit_area" >
		</div>
		<div class="col-md-6 form-group">
			<label for="recipient-name" class="form-control-label">Pincode</label>
			<input type="number" class="form-control" placeholder=""
				value="{{ $lead->pincode }}" name="edit_pincode" id="edit_pincode">
		</div>
		<div class="col-md-6 form-group">
			<label for="recipient-name" class="form-control-label">Address</label>
			<textarea class="form-control" name="edit_address" id="edit_address" placeholder="">{{ $lead->address}}</textarea>
		</div>

		<div class="col-md-6 form-group">
			<label for="recipient-name" class="form-control-label">Remarks</label>
			<textarea class="form-control" name="edit_remarks" id="edit_remarks" placeholder="">{{ $lead->remarks}}</textarea>
		</div>

	</div>
	<div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" id="update_lead" class="btn btn-primary"> Update </button>
	</div>
</form>

<script>

var phone_number = window.intlTelInput(document.querySelector("#edit_mobile"), {
	  separateDialCode: true,
	  preferredCountries:["in"],
	  hiddenInput: "full_number",
	  utilsScript:"{{url('assets/intl-tel-input17.0.3/utils.js')}}"
	});


$('#edit-lead-form').validate({ 
	rules: {
		edit_name: {
			required: true
		},
		// edit_company_name: {
		//     required: true
		// },
		edit_mobile: {
			required: true,
			maxlength:15,
			minlength:6
		},
	},
	submitHandler: function(form) 
	{
		$("#update_lead").attr('disabled',true).html('Updating <i class="fa fa-spinner fa-spin"></i>');
		
		var code=phone_number.getSelectedCountryData()['dialCode'];
		$("#edit_country_code").val(code);
		
		$.ajax({
		url: "{{ route('partner.update-lead') }}",
		method: 'post',
		data: $('#edit-lead-form').serialize(),
		success: function(result){
			if(result.status == 1)
			{
				$("#update_lead").attr('disabled',false).html('Update')
				$('#my-leads-table').DataTable().ajax.reload(null, false);
				$("form#lead-form :input").each(function(){
					$(this).val('')
				});  
				$("#edit-lead-modal").modal('hide');
				toastr.success(result.msg);
			}
			else{
				toastr.error(result.msg);
			}
		}
		});
	  }
	});

$("#edit_country").on('change',function()
        {
            country = $(this).val()
			$("#edit_country_name").val($('#edit_country option:selected').text());
            $.ajax({
                    url: "{{ route('country-states') }}",
                    method: 'get',
                    data: {'country':country},
                    success: function(result)
                    {
                        if(result.states)
                        {
                            $('#edit_state').empty();
                            $.each(result.states, function(key, value) {
                                $('#edit_state').append('<option value="'+ value +'">'+ value +'</option>');
                            });
                        }
                    }
                });
        })

 $("#edit_plan_type").on('change',function()
        {
            plan_type = $(this).val()
            $.ajax({
                    url: "{{ route('get-plans') }}",
                    method: 'get',
                    data: {'plan_type':plan_type},
                    success: function(result)
                    {
                        $('#edit_plan').empty();
                        $('#edit_plan').append(result.data);
                    }
                });
        })

</script>