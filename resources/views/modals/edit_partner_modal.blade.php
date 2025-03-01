<form id="editPartner">
  @csrf
  
   	<input type="hidden" name="partner_id" value="{{$part->id}}">
	<input type="hidden" class="form-control" name="country_name_edit" id="country_name_edit" value="{{$part->country_name}}">
					  
		      
	<div class="form-group">
			<label for="name" class="form-label">Name<span class="required">*</span></label>
			<input type="text" class="form-control" name="name_edit" id="name_edit" value="{{$part->name}}" required>
		</div>
		
	   <div class="form-group">
			<label for="email" class="form-label">Email<span class="required">*</span></label>
			<input type="email" class="form-control disabled" name="email_edit" id="email_edit" value="{{$part->email}}" required readonly>
		</div>

		<div class="form-group">
		<div class="row">
		<div class="col-lg-8 col-xl-8 col-xxl-8">
			<label for="mobile" class="form-label">Mobile<span class="required">*</span></label>
			<input type="hidden" class="form-control" name="country_code_edit" id="country_code_edit" value="{{$part->country_code}}" required>
			<input type="tel" class="form-control disabled" name="mobile_edit" id="mobile_edit" value="{{'+'.$part->country_code.$part->mobile }}" minlength=6 maxlength=15 required readonly>
		</div>
		<div class="col-lg-4 col-xl-4 col-xxl-4">
			<label for="comm_percentage" class="form-label">Commission.(%)</label>
			<input type="number" class="form-control" name="comm_percentage_edit" id="comm_percentage_edit" value="{{$part->commission_percentage}}" required>
		</div>
		</div>
		</div>
		
		
	<div class="form-group">
			<label for="company_name" class="form-label">Company Name<span class="required">*</span></label>
		<input type="text" class="form-control" name="company_name_edit" id="company_name_edit" value="{{$part->company_name}}" required>
		</div>
		
	   <div class="form-group">
			<label for="website" class="form-label">Website</label>
		<input type="text" class="form-control" name="website_edit" id="website_edit" value="{{$part->website}}">
		</div>
	  	
		<div class="form-group">
			<label for="partnerPhone" class="form-label">Country<span class="required">*</span></label>
			<select class="form-control" name="country_edit" id="country_edit" required>
			<option value="" selected disabled>select</option>
			@foreach($countries as $key=>$value)
			<option value="{{$key}}" @if($key==$part->country){{__('selected')}}@endif>{{$value}}</option>
			@endforeach
			</select>
		</div>
		
		<div class="form-group">
			<label for="partnerPhone" class="form-label">State<span class="required">*</span></label>
			<select class="form-control" name="state_edit" id="state_edit" required>
			<option value="" selected disabled>select</option>
			@foreach($states as $key=>$svalue)
			<option value="{{$svalue}}" @if($svalue==$part->state){{__('selected')}}@endif>{{$svalue}}</option>
			@endforeach
			</select>
		</div>
		
		<div class="form-group">
		<div class="row">
		<div class="col-lg-7 col-xl-7 col-xxl-6">
			<label for="partnerPhone" class="form-label">City<span class="required">*</span></label>
			<input type="text" class="form-control" name="city_edit" id="city_edit" value="{{$part->city}}" required>
		</div>
		<div class="col-lg-5 col-xl-5 col-xxl-5">
			<label for="partnerPhone" class="form-label">Pin Code</label>
			<input type="text" class="form-control" name="pincode_edit" id="pincode_edit"  minlength=6 maxlength=6 value="{{$part->pin_code}}" >
		</div>
		</div>
		</div>
				
		<div class="form-group">
		<div class="row">
		<div class="col-lg-7 col-xl-7 col-xxl-6">
			<label for="partnerPhone" class="form-label">Bank Name</label>
			<input type="text" class="form-control" name="bank_name_edit" id="bank_name_edit" value="{{$part->bank_name}}">
		</div>
		<div class="col-lg-5 col-xl-5 col-xxl-5">
			<label for="partnerPhone" class="form-label">IFSC Code</label>
			<input type="text" class="form-control" name="ifsc_edit" id="ifsc_edit" value="{{$part->ifsc}}">
		</div>
		</div>
		</div>
	
		
		<div class="form-group">
		<div class="row">
		<div class="col-lg-7 col-xl-7 col-xxl-6">
			<label for="partnerPhone" class="form-label">Branch</label>
			<input type="text" class="form-control" name="branch_edit" id="branch_edit" value="{{$part->branch}}" >
		</div>
		<div class="col-lg-5 col-xl-5 col-xxl-5">
			<label for="partnerPhone" class="form-label">Account Number</label>
			<input type="text" class="form-control" name="account_number_edit" id="account_number_edit" value="{{$part->account_number}}" >
		</div>
		</div>
		</div>

	
	<div class="form-group">
	<div class="row">
	<div class="col-lg-7 col-xl-7 col-xxl-7">
		<label for="partnerPhone" class="form-label">UPI ID</label>
		<input type="text" class="form-control" name="upi_id_edit" id="upi_id_edit" value="{{$part->upi_id}}" >
	</div>
	
	</div>
	</div>
	<div class="form-group mt-3 mb-3" style="text-align:right;">
	<button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
	<button type="submit" id="partner_submit"  class="btn btn-primary">Submit</button>
	</div>
</form>

@push('scripts')
<script>

/*$("#country_edit").select2({
	    dropdownParent: $('#edit-partner-modal')
});*/

	var phone_number = window.intlTelInput(document.querySelector("#mobile_edit"), 
	{
	  separateDialCode: true,
	  preferredCountries:["in"],
	  hiddenInput: "full_number",
	  utilsScript:"{{url('assets/intl-tel-input17.0.3/utils.js')}}"
	});


$('#editPartner').validate({
	rules:{
		pincode_edit:{
			required:true,
			minlength:6,
			maxlength:6
		},
		mobile_edit:{
			required:true,
			minlength:6,
			maxlength:15
		}
	},
  submitHandler: function(form) 
	{
		$("#partner_submit").attr('disabled',true).html('Saving <i class="fa fa-spinner fa-spin"></i>')
		
		var ccode=phone_number.getSelectedCountryData()['dialCode'];
		$("#country_code_edit").val(ccode);
			
		$.ajax({
		url: "{{ route('admin.update-partner') }}",
		type: 'post',
		dataType:'json',
		data: $("#editPartner").serialize(),
		success: function(result){
			if(result.status == 1)
			{

				$("#partner_submit").attr('disabled',false).html('Submit')
				$("#partner-table").DataTable().ajax.reload(null,false);
				toastr.success(result.msg);
				$('#editPartner')[0].reset();
				$('#edit-partner-modal').modal('hide');
			}
			else
			{
				toastr.success(result.msg);
			}
		}
		});
	}
});

$("#country_edit").on('change',function()
	{
		country = $(this).val()
		$("#country_name_edit").val($('#country_edit option:selected').text());
		
		$.ajax({
			url: "{{ route('country-states') }}",
			method: 'get',
			data: {'country':country},
			success: function(result)
			{
				if(result.states)
				{
					$('#state_edit').empty();
					$.each(result.states, function(key, value) {
						$('#state_edit').append('<option value="'+ value +'">'+ value +'</option>');
					});
				}
			}
		 });
	})

</script>
