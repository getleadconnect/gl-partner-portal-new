
	<div class="row">
		<div class="col-lg-12">

			<div class="table-responsive">

			<!--<table id="partner-table" class="table table-striped table-centered align-middle table-nowrap mb-0" style="width:100%;">-->
				<table id="view-payment_leads" class="table table-striped table-hover  mb-0" style="width:100% !important;">
					<thead>
					<tr id="tab-row">
						<th>No</th>
						<th>lead_name</th>
						<th>Description</th>
						<th>Status</th>
						<th>Amount</th>
						<th>Commission</th>
					</tr>
						
					</thead>
					<tbody>
					@php
					  $total=0;
					  $total_com=0;
					@endphp

					@foreach($data as $row)
					<tr >
						<td>{{$row->id}}</td>
						@if($row->renewal_status=="renewal")
						<td>{{$row->name}}&nbsp;<sup class="fs-10">R</sup></td>
						@else
						<td>{{$row->name}}</td>
						@endif

						<td>{{$row->description}}</td>
						<td>{{$row->lead_status}}</td>
						<td>₹{{number_format($row->amount_collected,2,'.','')}}</td>
						<td>₹{{number_format($row->commission_amount,2,'.','')}}</td>
					</tr>
					@php
					$total+=$row->amount_collected;
					$total_com+=$row->commission_amount;
					@endphp
					@endforeach
					</tbody>
					</tfoot>
					<tr>
						<td colspan=4 style="text-align:right;color:#7c7cfc;font-size:16px;">Total Collection : ₹{{number_format($total,2,'.','')}}</td>
						<td colspan=2 style="text-align:right;color:#7c7cfc;font-size:16px;">Commission: ₹{{number_format($total_com,2,'.','')}}</td>
					</tr>
					</tfoot>
					
				</table>
			</div>

		</div>

	</div>