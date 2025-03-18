@extends('admin.master')
@section('content')
<style>
.error
{
	color:red !important;
	font-size:12px !important;
}

.payment-active { color:green;}
.payment-inactive{ color:red;}

.filter-select
{
	width:110px;
	height:34px;
	margin:8px 0px 8px 8px;
	border-color:#aaa !important;
}
.pd-view p{ margin-bottom:.3rem !important;}

.numericCol
{
	text-align:right;
}

.cursor-pointer
{
	cursor:pointer
}

.selected
{
	background-color:#a7ddf5 !important;
}
.fs-10
{
	font-size:10px;
	color:blue;
}

</style>

 <div class="page-content">
        <div class="container-fluid">

            <!-- Start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Payments </h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                                <li class="breadcrumb-item active">Partner Payments</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End page title -->
			
			<div class="row">
                <div class="col-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Partner:&nbsp;<span style="color:#4776cf;">{{strtoupper($partner->name)}}</span></h5>
                            </div>
                        </div>
                        <!--<div class="card-body" style="padding-top:0px;">
                        </div>-->
                    </div>
                </div>
				<div class="col-2">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Total Amount:&nbsp;<span style="color:#4776cf;">₹ {{number_format($total->sum_commission,'2','.','')}}</span></h5>
                            </div>
                        </div>
                    </div>
                </div>
				
				<div class="col-2">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Paid:&nbsp;<span style="color:#4776cf;">₹ {{number_format($tot_paid,'2','.','')}}</span></h5>
                            </div>
                        </div>
                       
                    </div>
                </div>
				
				<div class="col-2">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Balance:&nbsp;<span style="color:#4776cf;">₹ {{number_format($total->sum_balance,'2','.','')}}</span></h5>
                            </div>
                        </div>
                       
                    </div>
                </div>
				<div class="col-2">
					<!-- content here --->
                </div>
				<div class="col-1">
                       <a href="{{url()->previous()}}" class="btn btn-primary me-2" style="padding:7px 10px;" ><i class="fas fa-arrow-left"></i>&nbsp;Back</a>
                    </div>
                </div>
				
            </div>

            <div class="row">
                <div class="col-12 col-lg-3 col-xl-3 col-xxl-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Pay Commission</span></h5>
                                <div>
								{{--<button id="btnOffcanvas" class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Add Lead</button>--}}
								<button id="btnClear" class="btn btn-primary" type="button" > Clear </button>
                                </div>
                            </div>
                        </div>
						
                        <div class="card-body pt-3" style="padding-top:0px;">

						<form  id="paymentForm" enctype="multipart/form-data">
						@csrf

						<input type="hidden" class="form-control" name="pay_partner_id" id="pay_partner_id" value="{{$partner->id}}">
						<input type="hidden" class="form-control" name="pay_percentage" id="pay_percentage" value="{{$partner->commission_percentage}}" >
						<input type="hidden" class="form-control" name="collected_amount" id="collected_amount"  value="0">
						<input type="hidden" class="form-control" name="commission_amount" id="commission_amount"  value="0">
						
						<input type="hidden"  class="form-control" name="lead_ids" id="lead_ids">
						<input type="hidden"  class="form-control" name="lead_commission_id" id="lead_commission_id">

						<div class="form-group">
						<div class="row">
						<div class="col-lg-6 col-xl-6 col-xxl-6">
							<label for="pay_balance" class="form-label">Payable Amount<span class="required">*</span></label>
							  <input type="text" class="form-control disabled"  name="pay_balance" id="pay_balance"  value="{{old('pay_balance')??0}}" required readonly>
						</div>
						
						<div class="col-lg-6 col-xl-6 col-xxl-6">
							<label for="pay_amount" class="form-label">Amount<span class="required">*</span></label>
							  <input type="number" class="form-control"  name="pay_amount" id="pay_amount"  value="{{old('pay_amount')}}??0" required >
							  <label id="err_amt" style="color:red;font-size:12px;margin:0px;">{{Session::get('error')}}</label>
						</div>
						</div>
						</div>

						<div class="form-group">
						<div class="row">
						<div class="col-lg-6 col-xl-6 col-xxl-6">
							<label for="payment_date" class="form-label">Payment Date<span class="required">*</span></label>
							  <input type="date" class="form-control"  name="payment_date" id="payment_date"  value="{{old('payment_date')}}" required>
						</div>
												
						<div class="col-lg-6 col-cl-6 col-xxl-6">
							<label for="payment_id" class="form-label">Payment Id<span class="required">*</span></label>
							  <input type="text" class="form-control"  name="payment_id" id="payment_id"  value="{{old('payment_id')}}" required>
						</div>
						</div>
						</div>
						
						<div class="form-group mt-2">
							<label for="description" class="form-label">Description<span class="required">*</span></label>
							<textarea rows=3 class="form-control" name="description" id="description" required>{{old('description')}}</textarea>
						</div>
						
						<div class="form-group mt-2">
							<label for="payment_receipt" class="form-label">Upload Payment Receipt</label>
							<input type="file" class="form-control" name="payment_receipt" id="payment_receipt" >
						</div>

						<div class="form-group mt-3 mb-3" style="text-align:right;">
							<button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
							<button type="submit" id="btn_payment"  class="btn btn-primary">Submit</button>
						</div>
						</form>
						
						
					</div>
					</div>
					
					</div>	
						
					<div class="col-lg-9 col-xl-9 col-xxl-9">

					<div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Details</span></h5>
                                <div>
								{{--<button id="btnOffcanvas" class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Add Lead</button>--}}
								
								
                                </div>
                            </div>
                        </div>
						
                        <div class="card-body pt-3">

	
						<ul class="nav nav-tabs" id="myTab" role="tablist">
							  <li class="nav-item" role="presentation">
								<button class="nav-link active" id="unpaid-tab" data-bs-toggle="tab" data-bs-target="#unpaid-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true"><b>Lead commissions</b></button>
							  </li>
							  <li class="nav-item" role="presentation">
								<button class="nav-link" id="payment-history-tab" data-bs-toggle="tab" data-bs-target="#history-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false"><b>Payment History</b></button>
							  </li>
							  
						</ul>

						
						<div class="tab-content mt-2" id="myTabContent">
							
							<!-- TAB -1 -------------------------------------------->
							  <div class="tab-pane fade show active" id="unpaid-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
							  
								<input type="hidden" name="partner_id" id="partner_id" value="{{$pid}}">

								<div class="table-responsive">
									<!--<table id="partner-table" class="table table-striped table-centered align-middle table-nowrap mb-0" style="width:100%;">-->
										<table id="unpaid_leads_table" class="table-hover table-nowrap mb-0" style="width:100% !important;">
											<thead>
												
											<tr id="tab-row">
												<th>&nbsp;</th>
												<th>Lead_Id</th>
												<th>No</th>
												<th>Lead</th>
												<th>Description</th>
												<th>Status</th>
												<th>Amount</th>
												<th>Commission</th>
												<th>Paid</th>
												<th>Balance</th>
											</tr>
												
											</thead>
											<tbody>
										   
											</tbody>
										</table>
									</div>

							  </div>
							  
							<div class="tab-pane fade" id="history-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="1"> 
							  
							<div class="table-responsive">
							<!--<table id="partner-table" class="table table-striped table-centered align-middle table-nowrap mb-0" style="width:100%;">-->
								<table id="pay_history" class="table table-striped table-hover  mb-0" style="width:100% !important;">
									<thead>
									<tr id="tab-row">
										<th>No</th>
										<th>Lead</th>
										<th>Payment Date</th>
										<th>Commission</th>
										<th>Paid</th>
										<th>Payment Id</th>
										<th>Receipt</th>
									</tr>
										
									</thead>
									<tbody>
								   
									</tbody>
								</table>
							</div>

   						    </div>
  

						</div>
						
						</div>
						
						
						
						</div>

							
                        </div>
                    </div>
        </div> <!-- container-fluid -->
</div>
	
    <!-- Add Partner Modal -->

<div class="modal fade" id="set-payment-modal" tabindex="-1" aria-labelledby="addPartnerModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addPartnerModalLabel">Payment Details</h5>
				 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
			
			
			</div>
		</div>
	</div>	
</div>

<!-- End Page-content -->




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

@if(Session::has('success'))
	<script>
	toastr.success("{{Session::get('success')}}")
</script>
@endif

@if(Session::has('error'))
	<script>
	toastr.error("{{Session::get('error')}}")
</script>
@endif

<script type="text/javascript">

$("#btn_payment").prop('disabled',true);

//---------datatable -------------------------------------

	var pid=$("#partner_id").val();
		
     var table = $('#unpaid_leads_table').DataTable({
            processing: true,
            serverSide: true,
			stateStatus: true,
			bAutoWidth: false,
			pageLength:50,
			lengthChange: false,
										
			"language": {
				searchPlaceholder: 'Search',
				sSearch: '',
			},

            ajax: {
                url: "{{ url('admin/got-business-partner-unpaid-leads')}}"+"/"+pid,
                //data: function (d) {}
            },
			
            columns: [
			{data: 'chkbox', name: 'chkbox',orderable: false, searchable: false},
			{data: 'lead_id', name: 'lead_id',orderable: false, searchable: false,visible:false},
			{data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
            {data: 'name', name: 'name'},
			{data: 'description', name: 'description'},
			{data: 'status', name: 'status',className:"full-width-select"},
			{data: 'amount_collected', name: 'amount_collected',className:'numericCol'},
			{data: 'commission_amount', name: 'commission_amount',className:'numericCol'},
			{data: 'amount', name: 'amount',className:'numericCol'},
			{data: 'balance', name: 'balance',className:'numericCol'},
            ],
			
        });

$("#unpaid_partner_filter").change(function()
 {
	table.draw();
 });

$("#btnClear").click(function()
{
	$("#pay_balance").val(0);
	$("#pay_amount").val(0);
	$('#unpaid_leads_table tbody input:checkbox').prop('checked', false);
	$('#unpaid_leads_table tbody tr').removeClass('selected');
	$("#lead_commission_id").val('');
	$("#lead_ids").val('');
});


table.on('click', '.selbox', function()
{
	$("#pay_amount").val('');
	if($(this).is(':checked'))
	{
		$(this).closest('tr').addClass('selected');
		//var data=table.row('.selected').data();
		var data=table.row($(this).closest('tr')).data();
				
		var lid=$("#lead_ids").val();
			lid+=','+data.lead_id;
			$("#lead_ids").val(lid);
		
		var lcid=$("#lead_commission_id").val();
			lcid+=','+data.id;
			$("#lead_commission_id").val(lcid);
		
		var col_amt=parseInt($("#collected_amount").val());
			col_amt+=parseInt(data.amount_collected);
			$("#collected_amount").val(col_amt);

		var camt=parseInt($("#commission_amount").val());
			camt+=parseInt(data.commission_amount);
			$("#commission_amount").val(camt);
				
		var amt=(parseInt($("#pay_balance").val()));
			amt+=parseInt(data.balance);
			$("#pay_balance").val(amt);
	}
	else
	{
		$(this).closest('tr').removeClass('selected');
		var data=table.row($(this).closest('tr')).data();
		
		var lid=$("#lead_ids").val();
			lid-=','+data.lead_id;
			$("#lead_ids").val(lid);
		
		var lcid=$("#lead_commission_id").val();
			id=','+data.id;
			lcid=lcid.replace(id,'');
			$("#lead_commission_id").val(lcid);
				
		var coamt=parseInt($("#collected_amount").val());
			coamt-=parseInt(data.amount_collected);
			$("#collected_amount").val(coamt);
		
		var com_amt=parseInt($("#commission_amount").val());
			com_amt-=parseInt(data.commission_amount);
			$("#commission_amount").val(com_amt);
		
		var amt=(parseInt($("#pay_balance").val()));
			amt-=parseInt(data.balance);
			$("#pay_balance").val(amt);
	}
	
});
 


$("#payment-history-tab").click( function()
{

var pid=$("#partner_id").val();

$('#pay_history').dataTable().fnClearTable();
$('#pay_history').dataTable().fnDestroy();

 var table2 = $('#pay_history').DataTable({
            processing: true,
            serverSide: true,
			stateStatus: true,
			bAutoWidth: false,
			pageLength:50,
			
			"language": {
				searchPlaceholder: 'Search',
				sSearch: '',
			},
			"lengthMenu": [10, 25, 50,100,150,200],
			
            ajax: {
                url: "{{ url('admin/view-partner-payment-history')}}"+"/"+pid,
                data: function (d) 
                {
                    d.partner_id = $('#filter_partner_id').val()   
                }
            },
			
			columnDefs:[
				{width:'30%','targets':1},
			],
			
            columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
            {data: 'name', name: 'name'},
			{data: 'payment_date', name: 'payment_date'},
			{data: 'commission', name: 'commission',className:"numericCol"},
			{data: 'paid_amount', name: 'paid',className:"numericCol"},
			{data: 'payment_id', name: 'payment_id'},
			{data: 'receipt', name: 'receipt'},
            ],
        });
});





$("#pay_amount").keyup(function()
{
	var bal=parseFloat($("#pay_balance").val());
	var pamt=parseFloat($("#pay_amount").val());
	
	var ids1=$("#lead_commission_id").val();
	var ids=ids1.split(',');

	if(pamt<=bal && ids.length<=2)
	{
		$("#err_amt").html('');
		$("#btn_payment").prop('disabled',false);
	}
	else if(pamt==bal && ids.length>2)
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

/// SET PAYMENT DETAILS -------------same functions added into leads blade file-------------------------------------------------------

 
 var payValidator=$('#paymentForm').validate({ 
        rules: {
			'set_comm_percentage':{required:true,},
			'set_collected_amount':{required:true,},
			'set_commission':{required:true,},
			'description':{required:true,}
            },
			
            submitHandler: function(form) 
            {
				var formData=new FormData(document.getElementById('paymentForm'));
					
					if($("#payment_receipt")[0].files[0])
					{
					formData.append('payment_receipt', $('#payment_receipt')[0].files[0]);
					}
	
                    $.ajax({
                    url: "{{ route('admin.save-payout') }}",
                    type: 'post',
                    data: formData,
					processData: false,  
					contentType: false, 
					processData: false,
                    success: function(result){
                        if(result.status == 1)
                        {
							table.ajax.reload();
                            toastr.success(result.msg);
							$('#paymentForm')[0].reset();
							paymentValidator.resetForm();
                        }
						else
						{
							toastr.error(result.msg);
						}
                    },

                    });
            }
        });


</script>

@endpush
@endsection