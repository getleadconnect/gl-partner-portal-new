<form id="editAgentForm">
	  @csrf
	  <input type="hidden" name="agent_id" value="{{$agent->id}}">
	  
		<div class="form-group">
			<label for="recipient-name" class="form-label">Name<span style="color: red;">*</span></label>
			<input type="text" class="form-control" placeholder=""
				value="{{ $agent->name }}" name="name_edit" id="name_edit" required>
		</div>
			
		<div class="form-group">
			<label for="recipient-name" class="form-label">Mobile<span style="color: red;">*</span></label>
			<input type="number" class="form-control" placeholder="" 
				value="{{ $agent->mobile }}" name="mobile_edit" id="mobile_edit" minlength=6 maxlength=10 required>
		</div>
	
		<div class="form-group">
			<label for="recipient-name" class="form-label">Email</label>
			<input type="email" class="form-control" placeholder="" value="{{ $agent->email }}" name="email_edit" id="email_edit" required>
		</div>
		
	<div class="form-group mt-3 mb-3" style="text-align:right;">
		<button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
		<button type="submit"  id="btnAgentSubmit" class="btn btn-primary">Submit</button>
	</div>
		
</form>

<script>

var editAgent=$('#editAgentForm').validate({
			
			rules: {

                },
              
                submitHandler: function(form) 
                {

					$("#btnAgentSubmit").attr('disabled',true).html('Saving <i class="fa fa-spinner fa-spin"></i>')
					
					$.ajax({
					url: "{{ route('admin.update-agent') }}",
					type: 'post',
					dataType:'json',
					data: $('#editAgentForm').serialize(),
					success: function(result) {

							if (result.status == 1) {
								$("#agent-table").DataTable().ajax.reload(null,false);
								$("#editAgentForm")[0].reset();
								toastr.success(result.msg);
								$("#btnSubmit").attr('disabled',false).html('Submit');
								$("#edit-agent-modal").modal('hide');
							}
							else
							{
								toastr.success(result.msg);
							}
						}
					});
				}
           });

</script>