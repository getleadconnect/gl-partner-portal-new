@extends('admin.master')
@section('content')
<style>
.error { color:red !important; font-size:12px !important; }

/* ============ SET PAYOUTS — PAGE HEADER ============ */
.gl-page-header {
    display: flex; align-items: flex-start; justify-content: space-between;
    gap: 16px; padding: 8px 4px 20px; flex-wrap: wrap;
    font-family: 'Geist', -apple-system, BlinkMacSystemFont, sans-serif;
}
.gl-page-title { font-size: 24px; font-weight: 700; color: #0F172A; letter-spacing: -0.01em; margin: 0 0 4px 0; line-height: 1.2; }
.gl-page-subtitle { font-size: 13px; color: #475569; }
.gl-page-header__actions { display: inline-flex; align-items: center; gap: 10px; }
.gl-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 14px; border-radius: 8px;
    font-size: 13px; font-weight: 500; line-height: 1.2;
    font-family: inherit; text-decoration: none; cursor: pointer;
    border: 1px solid transparent; white-space: nowrap;
    transition: background .15s ease, border-color .15s ease, color .15s ease;
}
.gl-btn i { font-size: 15px; line-height: 1; }
.gl-btn-outline { background: #FFFFFF; border-color: #E7E9EE; color: #0F172A; }
.gl-btn-outline:hover { background: #FAFAFB; border-color: #CBD5E1; }
.gl-btn-primary { background: #1E3A5F; color: #fff; border-color: #1E3A5F; box-shadow: 0 1px 2px rgba(15,23,42,0.08); }
.gl-btn-primary:hover { background: #15294A; border-color: #15294A; color: #fff; }
.gl-btn-sm { padding: 5px 10px; font-size: 12px; }

/* ============ SET PAYOUTS — TOOLBAR ============ */
.gl-payouts-toolbar {
    padding: 12px 16px;
    display: flex; align-items: center; justify-content: space-between;
    gap: 14px; border-bottom: 1px solid #F0F2F5;
    flex-wrap: wrap; background: #FAFAFB;
}
.gl-payouts-toolbar .filter-group { display: flex; gap: 8px; align-items: center; }
.gl-payouts-toolbar .filter-label {
    font-size: 11.5px; color: #94A3B8; font-weight: 500;
    margin-right: 4px; text-transform: uppercase; letter-spacing: 0.04em;
}
.gl-payouts-toolbar .filter-select-gl {
    padding: 6px 10px; border: 1px solid #E7E9EE; border-radius: 6px;
    background: #FFFFFF; font-size: 12.5px; color: #0F172A;
    font-family: inherit; cursor: pointer; outline: none;
}
.gl-payouts-toolbar .filter-select-gl:focus { border-color: #1E3A5F; }

/* ============ SET PAYOUTS — TABLE ============ */
.gl-payouts {
    --gl-surface: #FFFFFF; --gl-surface-2: #FAFAFB;
    --gl-border: #E7E9EE; --gl-border-soft: #F0F2F5;
    --gl-text: #0F172A; --gl-text-soft: #475569; --gl-text-muted: #94A3B8;
    font-family: 'Geist', -apple-system, BlinkMacSystemFont, sans-serif;
}
.gl-payouts table.data { width: 100%; border-collapse: collapse; font-size: 13px; }
.gl-payouts table.data thead tr { background: var(--gl-surface-2); }
.gl-payouts table.data thead th {
    padding: 10px 16px; text-align: left;
    font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em;
    color: var(--gl-text-muted); font-weight: 600;
    border-bottom: 1px solid var(--gl-border-soft); white-space: nowrap;
}
.gl-payouts table.data thead th.num { text-align: right; }
.gl-payouts table.data tbody td {
    padding: 12px 16px; border-bottom: 1px solid var(--gl-border-soft);
    color: var(--gl-text-soft); vertical-align: middle; background: var(--gl-surface);
}
.gl-payouts table.data tbody tr:hover td { background: #FAFBFC; }
.gl-payouts table.data td.numericCol,
.gl-payouts table.data td.num {
    font-family: 'Geist Mono', monospace; text-align: right; font-variant-numeric: tabular-nums;
}
.gl-payouts table.data td .num.strong { color: var(--gl-text); font-weight: 600; font-family: 'Geist Mono', monospace; }

/* Partner cell — avatar */
.gl-payouts .row-avatar {
    display: inline-flex; align-items: center; gap: 10px;
    text-decoration: none;
}
.gl-payouts .row-avatar .av {
    width: 32px; height: 32px; border-radius: 50%;
    display: grid; place-items: center; font-size: 11px; font-weight: 600;
    color: #fff; flex-shrink: 0; letter-spacing: 0.02em;
}
.gl-payouts .row-avatar .av.c1 { background: #1E3A5F; }
.gl-payouts .row-avatar .av.c2 { background: #059669; }
.gl-payouts .row-avatar .av.c3 { background: #B68B3C; }
.gl-payouts .row-avatar .av.c4 { background: #DC2626; }
.gl-payouts .row-avatar .av.c5 { background: #475569; }
.gl-payouts .row-avatar .av.c6 { background: #2C5282; }
.gl-payouts .row-avatar .nm { line-height: 1.25; }
.gl-payouts .row-avatar .nm .name { color: var(--gl-text); font-weight: 500; font-size: 13px; }
.gl-payouts .row-avatar .nm .sub { color: var(--gl-text-muted); font-size: 11px; margin-top: 2px; }

/* Pills */
.gl-payouts .pill {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 9px; border-radius: 4px;
    font-size: 11.5px; font-weight: 500;
}
.gl-payouts .pill::before { content:''; width:5px; height:5px; border-radius:50%; }
.gl-payouts .pill.paid   { background: #ECFDF5; color: #059669; }
.gl-payouts .pill.paid::before { background: #059669; }
.gl-payouts .pill.unpaid { background: #FEE2E2; color: #DC2626; }
.gl-payouts .pill.unpaid::before { background: #DC2626; }

/* In-row buttons */
.gl-payouts .gl-btn { padding: 6px 12px; font-size: 12px; }
.gl-payouts .gl-btn.gl-btn-sm { padding: 5px 10px; font-size: 12px; }

.numericCol { text-align: right; }
.text-center { text-align: center; }
</style>

 <div class="page-content">
        <div class="container-fluid">

            <div class="gl-page-header">
                <div class="gl-page-header__text">
                    <h1 class="gl-page-title">Set Payouts</h1>
                    <div class="gl-page-subtitle">Release verified commissions to partners.</div>
                </div>
                <div class="gl-page-header__actions">
                    <a href="{{ url('admin/payout-history') }}" class="gl-btn gl-btn-outline">
                        <i class="bx bx-time-five"></i> Payout History
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body" style="padding:0;">

                            <select id="partner_filter" class="filter-select-gl" style="margin-left:10px;">
                                <option value="">All partners</option>
                                @foreach($partners as $key=>$value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>


                            <div class="table-responsive gl-payouts">
                                <table id="payment_verify" class="data" style="width:100% !important;">
                                    <thead>
                                        <tr id="tab-row">
                                            <th>No</th>
                                            <th>Partner</th>
                                            <th>Company</th>
                                            <th>Lead</th>
                                            <th>Description</th>
                                            <th class="num">Collected Amount</th>
                                            <th class="num">Commission</th>
                                            <th>Leads</th>
                                            <th>Pay-Status</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	
    <!-- Add Partner Modal -->

	<div class="modal fade" id="set-payment-modal" tabindex="-1" aria-labelledby="addPartnerModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
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


<div class="modal fade" id="view-payment-leads-modal" tabindex="-1" aria-labelledby="addPartnerModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addPartnerModalLabel">View Payment Leads</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
			
			<!-------------- contents here -------------------->

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


<script type="text/javascript">
$(function () {

$("#btn_payment").prop('disabled',true);

 var table = $('#payment_verify').DataTable({
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
                url: "{{ route('admin.view-verified-payments-list') }}",
                data: function (d) 
                {
                    d.partner_id = $('#partner_filter').val()   
                }
            },
			
            columns: [
            
            {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
            {data: 'partner_name', name: 'partner_name'},
			{data: 'company_name', name: 'company_name'},
			{data: 'lead_name', name: 'lead_name'},
			{data: 'description', name: 'description'},
			{data: 'total_collection', name: 'total_collection',className:"numericCol"},
			{data: 'amount', name: 'amount',className:"numericCol"},
			{data: 'view_leads', name: 'view_leads',className:'text-center'},
			{data: 'pay_status', name: 'pay_status',className:'text-center'},
			{data: 'verify_status', name: 'verify_status'},
			{data: 'action', name: 'action',className:'text-center'},
            ],
        });

$("#payment_verify_length").append(partner_filter);

        $("#partner_filter").change(function()
		{
			table.ajax.reload();
		});
		

	$('#payment_verify tbody').on('click','.btn-view-leads', function()
		{
		
		var id=$(this).attr('data-id');

		var Result=$("#view-payment-leads-modal .modal-body");
		
			//$(this).attr("data-bs-target","#set-payment-modal");
		
				jQuery.ajax({
				type: "GET",
				url: "{{url('admin/get-payment-leads-list')}}"+"/"+id,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				Result.html(res);
				}
			});
	});

$('#payment_verify tbody').on('click','.btn-pay', function()
		{
		
		var id=$(this).attr('data-id');

		var Result=$("#set-payment-modal .modal-body");
		
			//$(this).attr("data-bs-target","#set-payment-modal");
		
				jQuery.ajax({
				type: "GET",
				url: "{{url('admin/get-payment-details')}}"+"/"+id,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				Result.html(res);
				}
			});
	});






});

  
</script>

@endpush
@endsection