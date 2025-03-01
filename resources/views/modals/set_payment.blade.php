<style>
.history-table
{
	border:1px solid #e4e4e4 !important;
}

.history-table th
{
	padding-left:10px;
	border:1px solid #e4e4e4;
}

.history-table td
{
	padding-left:10px;
	border:1px solid #e4e4e4;
}
</style>

<div class="row">

<div class="col-lg-6 col-xl-6 col-xxl-6" style="padding-left:30px;">

<label><h6><u>Add Payment</u></h6></label>

<form  method="POST"  onsubmit="return check_amount();" action="{{url('admin/save-payout')}}" enctype="multipart/form-data">
@csrf
<input type="hidden" class="form-control" name="pay_lead_id" id="pay_lead_id" value="{{$lead->id}}">
<input type="hidden" class="form-control" name="pay_partner_id" id="pay_partner_id" value="{{$lead->partner_id}}">
<input type="hidden" class="form-control"  name="pay_percentage" id="pay_percentage" value="{{$lead->commission_percentage}}" >
<input type="hidden" class="form-control"  name="collection_amount" id="collection_amount" value="{{$lead->amount_collected}}" >

<div class="form-group">
<div class="row">

<div class="col-lg-6 col-xl-6 col-xxl-6">
	<label for="recipient-name" class="form-label">Commission</label>
	  <input type="text" class="form-control disabled"  name="commission_amount" id="commission_amount" value="{{$lead->commission_amount}}" required readonly>
</div>

<div class="col-lg-6 col-xl-6 col-xxl-6">
	<label for="recipient-name" class="form-label">Balance Amount</label>
	  <input type="text" class="form-control disabled"  name="pay_balance" id="pay_balance" value="{{$lead->balance}}" required readonly>
</div>

</div>
</div>

<div class="form-group">
<div class="row">
<div class="col-lg-6 col-xl-6 col-xxl-6">
	<label for="recipient-name" class="form-label">Amount</label>
	  <input type="text" class="form-control"  name="pay_amount" id="pay_amount" value="{{$lead->balance}}" required >
	  <label id="err_amt" style="color:red;font-size:12px;margin:0px;"></label>
</div>
<div class="col-lg-6 col-xl-6 col-xxl-6">
	<label for="recipient-name" class="form-label">Payment Date</label>
	  <input type="date" class="form-control"  name="payment_date" id="payment_date" required>
</div>
</div>
</div>

<div class="form-group">
	<label for="recipient-name" class="form-label">Payment Id</label>
	  <input type="text" class="form-control"  name="payment_id" id="payment_id" required>
</div>

<div class="form-group">
	<label for="recipient-name" class="form-label">Upload Payment Receipt</label>
	<input type="file" class="form-control" name="payment_receipt" id="payment_receipt" >
</div>

<div class="form-group mt-3 mb-3" style="text-align:right;">
	<button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
	<button type="submit" id="btnPayment"  class="btn btn-primary">Submit</button>
</div>
</form>

</div>

<div class="col-lg-6 col-xl-6 col-xxl-6" style="padding-right:30px;">

<label><h6><u>Payment History</u></h6></label>
<table style="width:100%;" class="histoy-table">
<tr>
	<th>Slno</th>
	<th>Payment Date</th>
	<th style="text-align:right;">Amount</th>
	<th style="text-align:right;">Receipt</th>
</tr>
@php
$tot=0;
@endphp

@if($pay_history->count()>0)


	@foreach($pay_history as $key=>$row)

	@php
		$tot=$tot+$row->amount;
	@endphp
	<tr>
		<td>{{++$key}}</td>
		<td>{{$row->payment_date}}</td>
		<td align="right">{{number_format($row->amount,'2','.','')}}</td>
		<td align="center">
		@if($row->receipt!="")
		<a href="{{url('uploads/receipts').'/'.$row->receipt}}" target="_blank" style="font-size:12px;">View</a>
		@endif
		</td>
	</tr>
	@endforeach
@else
<tr>
<td colspan=3 style="text-align:center;line-height:35px;color:red;font-size:12px;"> No data were found.!</td>
</tr>
@endif

<tr>
	<td colspan=2 align="right" style="font-weight:600;">Total Paid:</td>
	<td align="right" style="font-weight:600;">{{number_format($tot,'2','.','')}}</td>
	<td >&nbsp;</td>
</tr>
	
</table>
</div>

</div>

</form>

<script>

function check_amount()
{
	var bal=parseFloat($("#pay_balance").val());
	var pamt=parseFloat($("#pay_amount").val());

	if(pamt<=bal)
	{
		$("#err_amt").html('');
		return true;
	}
	else
	{
		$("#err_amt").html('Invalid Amount');
		return false;
	}
	
}

</script>			