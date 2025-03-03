<style>

.numericCol
{
	text-align:right;
	padding-right:15px !important;
}
.span-weight{min-width: 100px; font-weight:700;}
.input-weight{font-weight:700;}

</style>

<div style="width:99.5%;">

<div class="row">
	<div class="col-lg-3 col-xl-3 col-xxl-3">

		<div class="row">
			<div class="col-lg-12 col-xl-12 col-xxl-12">
					<div class="form-group mt-3">
						<p><h4>{{$data['partner']->name}}</h4> </p>
						<p><h6>ID :{{$data['partner']->unique_id}}</h6> </p>
						<p>{{$data['partner']->email}}</p>
						<p>{{$data['partner']->mobile}}</p>
					</div>
					
			</div>
			</div>
			<hr class="mb-0">
			<div class="row">
			<div class="col-lg-12 col-xl-12 col-xxl-12">
			<label ><b><u>Company Details</u></b></label>

			<p><h5>{{$data['partner']->company_name}}</h5></p>
						<p>{{$data['partner']->website}}</p>
						<p>{{$data['partner']->city.", ".$data['partner']->pin_code}}</p>

			<label class="mt-3"><b><u>Bank Account Details</u></b></label>

				<div class="form-group">
					<p>Bank : {{$data['partner']->bank_name}}</p>
					<p>IFSC : {{$data['partner']->ifsc}}</p>
					<p>Branch : {{$data['partner']->branch}}</p>
					<p>A/C No : {{$data['partner']->account_number}} </p>
					<p>UPI ID : {{$data['partner']->upi_id}} </p>
					<p class="mt-2" style="font-weight:600;">Commission(%) : {{$data['partner']->commission_percentage}} </p>
				</div>
				
			</div>
			</div>

	</div>
	
	<div class="col-lg-9 col-xl-9 col-xxl-9">
								
	 <div class="row mt-2">
		<!-- Partners Statistics -->
		<div class="col-lg-4 col-xl-4 col-xxl-4">
		
		<div class="input-group" style="font-weight:700 !important;">
		  <input type="text" class="form-control input-weight" aria-describedby="basic-addon2" value="Total Leads" disabled readonly>
		  <span class="input-group-text span-weight" id="basic-addon2">{{$data['total_leads']}}</span>
		</div>
		</div>
		<div class="col-lg-4 col-xl-4 col-xxl-4">
		
		<div class="input-group" style="font-weight:700 !important;">
		  <input type="text" class="form-control input-weight" aria-describedby="basic-addon2" value="Leads(Converted)" disabled readonly>
		  <span class="input-group-text span-weight" id="basic-addon2">{{$data['business_leads']}}</span>
		</div>
		</div>

		<div class="col-lg-4 col-xl-4 col-xxl-4">
		
		<div class="input-group" style="font-weight:700 !important;">
		  <input type="text" class="form-control input-weight" aria-describedby="basic-addon2" value="Leads Open" disabled readonly>
		  <span class="input-group-text span-weight" id="basic-addon2">{{$data['open_leads']}}</span>
		</div>
		
		</div>

	</div>
	
	<div class="row mt-2">
		<!-- Partners Statistics -->
		<div class="col-lg-4 col-xl-4 col-xxl-4">
		
		<div class="input-group" style="font-weight:700 !important;">
		  <input type="text" class="form-control input-weight" aria-describedby="basic-addon2" value="Commission" disabled readonly>
		  <span class="input-group-text span-weight" id="basic-addon2">{{$data['total_commission']}}</span>
		</div>

		</div>
		<div class="col-lg-4 col-xl-4 col-xxl-4">
		
		<div class="input-group" style="font-weight:700 !important;">
		  <input type="text" class="form-control input-weight" aria-describedby="basic-addon2" value="Paid" disabled readonly>
		  <span class="input-group-text span-weight" id="basic-addon2">{{$data['commission_paid']}}</span>
		</div>

		</div>
		<div class="col-lg-4 col-xl-4 col-xxl-4">
		
		<div class="input-group " style="font-weight:700 !important;">
		  <input type="text" class="form-control input-weight" aria-describedby="basic-addon2" value="Balance" disabled readonly>
		  <span class="input-group-text span-weight" id="basic-addon2">{{$data['total_commission']-$data['commission_paid']}}</span>
		</div>

		</div>
	</div>

<hr>

<div class="table-responsive">
<label><b><u>Leads </u></b></label>

			<table id="leads-table" class="table table-striped table-hover" style="width:100% !important;">
				<thead>
					
				<tr >
					<th>No</th>
					<th>Name</th>
					<th>Mobile</th>
					<th>Email</th>
					<th>Company</th>
					<th>Status</th>
					<th>Commission</th>
				</tr>
					
				</thead>
				<tbody>
				
				
				
				</tbody>
			</table>
		</div>
	
	</div>
  </div>
</div>
	<!-- End Page-content -->

<script type="text/javascript">
    $(function () {
    toastr.options = {
        // "positionClass": "toast-top-right cp",
        "showDuration": "300000",
        "hideMethod": "fadeOut"
        }
    });

</script>

<script type="text/javascript">

var pid="{{$data['partner']->id}}";

 var table = $('#leads-table').DataTable({
            processing: true,
            serverSide: true,
			stateStatus: true,
			"language": {
				searchPlaceholder: 'Search',
				sSearch: '',
			},
			"lengthMenu": [10, 25, 50,100,150,200],
			
            ajax: {
                url: "{{ url('admin/get-partner-leads')}}"+"/"+pid,
                data: function (d) 
                {
                    //d.status = $('#filter_status').val(),
                }
            },
			
			
            columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
            {data: 'name', name: 'name'},
			{data: 'mobile', name: 'mobile'},
            {data: 'email', name: 'email'},
			{data: 'company_name', name: 'company_name'},
			{data: 'lead_status', name: 'lead_status'},
            {data: 'commission_amount', name: 'commission_amount',className:"numericCol"},
            ],
        });

</script>
