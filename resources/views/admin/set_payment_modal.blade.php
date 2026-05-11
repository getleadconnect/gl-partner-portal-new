<input type="hidden" name="temp_comm_percentage" id="temp_comm_percentage">
	<form  id="paymentForm" method="POST" action="{{route('admin.save-payout')}}" enctype="multipart/form-data">
		@csrf

		<input type="hidden" class="form-control" name="pay_partner_id" id="pay_partner_id" value="{{$partner->id}}">
		<input type="hidden" class="form-control" name="pay_percentage" id="pay_percentage" value="{{$partner->commission_percentage}}" >
		<input type="hidden" class="form-control" name="collected_amount" id="collected_amount"  value="0">
		<input type="hidden" class="form-control" name="commission_amount" id="commission_amount"  value="0">
		
		<input type="hidden"  class="form-control" name="lead_ids" id="lead_ids" value="{{$payment->lead_id}}">
		<input type="hidden"  class="form-control" name="verified_payment_id" id="verified_payment_id" value="{{$vpid}}">
				
		<div class="form-group">
			<label for="pay_amount" class="form-label">Payable Amount<span class="required">*</span></label>
				<input type="text" class="form-control disabled"  name="pay_amount" id="pay_amount"  value="{{$payment->commission??0}}" required readonly>
		</div>

		<div class="form-group">
			<label for="payment_date" class="form-label">Payment Date<span class="required">*</span></label>
				<input type="date" class="form-control"  name="payment_date" id="payment_date"  value="{{old('payment_date')}}" required>
		</div>
								
		<div class="form-group">
			<label for="payment_id" class="form-label">Payment Id<span class="required">*</span></label>
				<input type="text" class="form-control"  name="payment_id" id="payment_id"  value="{{old('payment_id')}}" required>
		</div>

		<div class="form-group">
			<label for="description" class="form-label">Description<span class="required">*</span></label>
			<textarea rows=2 class="form-control" name="description" id="description" required>{{old('description')}}</textarea>
		</div>
		
		<div class="form-group">
			<label for="payment_receipt" class="form-label">Upload Payment Receipt</label>
			<input type="file" class="form-control" name="payment_receipt" id="payment_receipt" >
		</div>

		<div class="form-group mt-3 mb-3" style="text-align:right;">
			<button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
			<button type="submit" id="btn_payment"  class="btn btn-primary">Submit</button>
		</div>
	</form>

	<script>

$("#pay_amount").keyup(function()
{
	var bal=parseFloat($("#pay_balance").val());
	var pamt=parseFloat($("#pay_amount").val());
	
	//var ids1=$("#lead_commission_id").val();
	//var ids=ids1.split(',');

	if(pamt==bal)
	{
		$("#err_amt").html('');
		$("#btn_payment").prop('disabled',false);
	}
	else 
	{
		$("#err_amt").html('Invalid Amount');
		$("#btn_payment").prop('disabled',true);
	}
	
});

$("#pay_amount").blur(function()
{
	var bal=parseFloat($("#pay_balance").val());
	var pamt=parseFloat($("#pay_amount").val());

	if(pamt<bal || pamt>bal)
	{
		$("#err_amt").html('Invalid Amount');
		$("#btn_payment").prop('disabled',true);
	}
	
});


var payValidator=$('#paymentForm').validate({ 
        rules: {
			'set_comm_percentage':{required:true,},
			'set_collected_amount':{required:true,},
			'set_commission':{required:true,},
			'description':{required:true,}
            },
});



</script>