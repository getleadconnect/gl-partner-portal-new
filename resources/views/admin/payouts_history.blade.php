@extends('admin.master')
@section('content')
<style>
/* ============ PAYOUT HISTORY — PAGE HEADER ============ */
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

/* ============ TOOLBAR + TABS ============ */
.gl-payouts-toolbar {
    padding: 12px 16px;
    display: flex; align-items: center; justify-content: space-between;
    gap: 14px; border-bottom: 1px solid #F0F2F5;
    flex-wrap: wrap; background: #FAFAFB;
}
.gl-payouts-toolbar .tabs {
    display: flex; gap: 2px;
    background: #FFFFFF; padding: 3px; border-radius: 6px;
    border: 1px solid #E7E9EE;
}
.gl-payouts-toolbar .tabs .tab {
    padding: 5px 14px; background: transparent; border: none;
    border-radius: 5px; font-size: 12.5px; font-weight: 500;
    color: #475569; cursor: pointer; font-family: inherit;
}
.gl-payouts-toolbar .tabs .tab.active { background: #1E3A5F; color: #fff; }
.gl-payouts-toolbar .filter-group { display: flex; gap: 8px; align-items: center; }
.gl-payouts-toolbar .filter-select-gl {
    padding: 6px 10px; border: 1px solid #E7E9EE; border-radius: 6px;
    background: #FFFFFF; font-size: 12.5px; color: #0F172A;
    font-family: inherit; cursor: pointer; outline: none;
}
.gl-payouts-toolbar .filter-select-gl:focus { border-color: #1E3A5F; }

/* Secondary pill filter inside a tab */
.gl-payouts-toolbar .filter-pills { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
.gl-payouts-toolbar .filter-pill {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 4px 12px; background: #FFFFFF; border: 1px solid #E7E9EE; border-radius: 999px;
    font-size: 13px; font-weight: 500; color: #475569; cursor: pointer; font-family: inherit;
    transition: all 0.15s ease;
}
.gl-payouts-toolbar .filter-pill:hover { background: #EEF2F8; border-color: #1E3A5F; color: #1E3A5F; }
.gl-payouts-toolbar .filter-pill.active { background: #1E3A5F; border-color: #1E3A5F; color: #fff; }
.gl-payouts-toolbar .filter-pill .mono { font-family: 'Geist Mono', monospace; font-size: 11px; opacity: 0.85; }

/* Date range filter */
.gl-payouts-toolbar .date-range {
    display: inline-flex; align-items: center; gap: 6px;
    margin-left: 4px;
}
.gl-payouts-toolbar .date-range__label {
    font-size: 11.5px; color: #94A3B8; font-weight: 500;
    text-transform: uppercase; letter-spacing: 0.04em;
    margin: 0;
}
.gl-payouts-toolbar .date-range__input {
    padding: 6px 10px; border: 1px solid #E7E9EE; border-radius: 6px;
    background: #FFFFFF; font-size: 12.5px; color: #0F172A;
    font-family: inherit; cursor: pointer; outline: none;
}
.gl-payouts-toolbar .date-range__input:focus { border-color: #1E3A5F; }
.gl-payouts-toolbar .date_clear{
    width: 28px; height: 28px; padding: 0;
    display: inline-flex; align-items: center; justify-content: center;
}
.gl-payouts-toolbar .date_clear i { font-size: 14px; line-height: 1; }

.gl-payouts-toolbar .payouts-toolbar__actions {
    margin-left: auto;
    display: inline-flex; align-items: center; gap: 8px;
}

/* ============ TABLE ============ */
.gl-payouts {
    --gl-surface: #FFFFFF; --gl-surface-2: #FAFAFB;
    --gl-border: #E7E9EE; --gl-border-soft: #F0F2F5;
    --gl-text: #0F172A; --gl-text-soft: #475569; --gl-text-muted: #94A3B8;
    font-family: 'Geist', -apple-system, BlinkMacSystemFont, sans-serif;
	padding:10px;
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
.gl-payouts table.data td .num.muted  { color: var(--gl-text-muted); font-family: 'Geist Mono', monospace; }

/* Lead cell — avatar */
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
.gl-payouts .row-avatar .nm .sub { color: var(--gl-text-muted); font-size: 11px; margin-top: 2px; font-family: 'Geist Mono', monospace; }

/* Plain lead cell (no avatar) — used in Payment Histories tab */
.gl-payouts .lead-cell { line-height: 1.25; }
.gl-payouts .lead-cell .name { color: var(--gl-text); font-weight: 500; font-size: 13px; }
.gl-payouts .lead-cell .sub  { color: var(--gl-text-muted); font-size: 11px; margin-top: 2px; font-family: 'Geist Mono', monospace; }

/* R / I commission type marks */
.gl-payouts .type-mark {
    display: inline-block;
    width: 22px; height: 22px;
    border-radius: 5px;
    font-size: 11px; font-weight: 700;
    text-align: center; line-height: 22px;
    font-family: 'Geist Mono', monospace;
}
.gl-payouts .type-mark.r { background: #EEF2F8; color: #1E3A5F; }
.gl-payouts .type-mark.i { background: #FBF5E5; color: #B68B3C; }

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
</style>

<div class="page-content">
    <div class="container-fluid">

        <div class="gl-page-header">
            <div class="gl-page-header__text">
                <h1 class="gl-page-title">Payout History</h1>
                <div class="gl-page-subtitle">Commission ledger and payment receipts across all partners.</div>
            </div>
            <div class="gl-page-header__actions">
                <a href="{{ url()->previous() }}" class="gl-btn gl-btn-outline">
                    <i class="bx bx-arrow-back"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body" style="padding:0;">

                        <div class="gl-payouts-toolbar">
                            <div class="tabs" role="tablist">
                                <button class="tab active" id="payment-tab" data-bs-toggle="tab" data-bs-target="#payments-tab-pane" type="button" role="tab" aria-selected="true">
                                    Payout Details
                                </button>
                                <button class="tab" id="paid-tab" data-bs-toggle="tab" data-bs-target="#paid-tab-pane" type="button" role="tab" aria-selected="false">
                                    Payment Histories
                                </button>
                            </div>
                        </div>

                        <div class="tab-content" id="payoutsHistoryContent">

                            {{-- PAYOUT DETAILS TAB --}}
                            <div class="tab-pane fade show active" id="payments-tab-pane" role="tabpanel" tabindex="0">
                                <div class="gl-payouts-toolbar" style="border-top: 1px solid #F0F2F5;">
                                    <div class="filter-pills" role="tablist">
                                        <button type="button" class="filter-pill active" data-status="">All <span class="mono">{{ $payout_counts['all'] ?? 0 }}</span></button>
                                        <button type="button" class="filter-pill" data-status="paid">Paid <span class="mono">{{ $payout_counts['paid'] ?? 0 }}</span></button>
                                        <button type="button" class="filter-pill" data-status="unpaid">Unpaid <span class="mono">{{ $payout_counts['unpaid'] ?? 0 }}</span></button>
										<select id="filter_partner_id" class="filter-select-gl" style="border-radius:22px;">
											<option value="">All partners</option>
											@foreach($partners as $key=>$value)
												<option value="{{ $key }}">{{ $value }}</option>
											@endforeach
										</select>

										<div class="date-range">
											<label class="date-range__label">From</label>
											<input type="date" id="filter_date_from" class="filter-select-gl date-range__input">
											<label class="date-range__label">To</label>
											<input type="date" id="filter_date_to" class="filter-select-gl date-range__input">
											<button type="button" id="filter_date_clear" class="date_clear filter-pill" title="Clear date range"><i class="bx bx-x"></i></button>
										</div>
                                    </div>
                                    <div class="payouts-toolbar__actions">
                                        <a href="javascript:void(0);" id="export_payout_details" class="gl-btn gl-btn-outline">
                                            <i class="bx bx-download"></i> Export CSV
                                        </a>
                                    </div>
                                </div>
                                <div class="table-responsive gl-payouts">
                                    <table id="payments_table" class="data" style="width:100% !important;">
                                        <thead>
                                            <tr id="tab-row">
                                                <th>No</th>
                                                <th>Lead</th>
												<th>Type</th>
                                                <th class="num">Amount</th>
                                                <th class="num">Commission</th>
                                                <th class="num">Paid</th>
                                                <th class="num">Balance</th>
												<th >Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- PAYMENT HISTORIES TAB --}}
                            <div class="tab-pane fade" id="paid-tab-pane" role="tabpanel" tabindex="0">
                                
							<div class="gl-payouts-toolbar" style="border-top: 1px solid #F0F2F5;">
                                    <div class="filter-pills" role="tablist">
                                        <select id="filter_partner_id_1" class="filter-select-gl" style="border-radius:22px;">
											<option value="">All partners</option>
											@foreach($partners as $key=>$value)
												<option value="{{ $key }}">{{ $value }}</option>
											@endforeach
										</select>

										<div class="date-range">
											<label class="date-range__label">From</label>
											<input type="date" id="filter_date_from_1" class="filter-select-gl date-range__input">
											<label class="date-range__label">To</label>
											<input type="date" id="filter_date_to_1" class="filter-select-gl date-range__input">
											<button type="button" id="filter_date_clear_1" class="date_clear filter-pill" title="Clear date range"><i class="bx bx-x"></i></button>
										</div>
                                    </div>
                                    <div class="payouts-toolbar__actions">
                                        <a href="javascript:void(0);" id="export_payment_history" class="gl-btn gl-btn-outline">
                                            <i class="bx bx-download"></i> Export CSV
                                        </a>
                                    </div>
                            </div>
							
							
							<div class="table-responsive gl-payouts">
                                    <table id="payment_history" class="data" style="width:100% !important;">
                                        <thead>
                                            <tr id="tab-row">
                                                <th>No</th>
												<th>Partner</th>
                                                <th>Lead</th>
                                                <th>Payment Date</th>
                                                <th class="num">Paid Amount</th>
                                                <th>Payment Id</th>
												<th>Status</th>
                                                <th>Receipt</th>
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

        // Tab visual sync (matches gl-payouts pill tabs)
        document.querySelectorAll('.gl-payouts-toolbar .tab').forEach(function (btn) {
            btn.addEventListener('click', function () {
                document.querySelectorAll('.gl-payouts-toolbar .tab').forEach(function (b) {
                    b.classList.remove('active');
                    b.setAttribute('aria-selected', 'false');
                });
                btn.classList.add('active');
                btn.setAttribute('aria-selected', 'true');
            });
        });

		//---------datatable -------------------------------------
				
        var table = $('#payments_table').DataTable({
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
                url: "{{ route('admin.view-payment-details') }}",
                data: function (d) {
                    d.partner_id    = $('#filter_partner_id').val();
                    d.status_filter = $('#payments-tab-pane .filter-pill.active').data('status') || '';
                    d.date_from     = $('#filter_date_from').val() || '';
                    d.date_to       = $('#filter_date_to').val()   || '';
                }
            },
            columns: [

            {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
            {data: 'name', name: 'name'},
			{data: 'type', name: 'type'},
			{data: 'collected_amount', name: 'collected_amount',className:'numericCol'},
			{data: 'commission', name: 'commission',className:'numericCol'},
			{data: 'amount', name: 'amount',className:'numericCol'},
			{data: 'balance', name: 'balance',className:'numericCol'},
			{data: 'updateAt', name: 'updateAt'},
			{data: 'status', name: 'status'},
            ],
        });
		
//$("#unpaid_leads_table_filter").append(unpaid_partner_filter);

 var table2 = $('#payment_history').DataTable({
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
                url: "{{ route('admin.view-all-payment-history') }}",
                data: function (d) 
                {
                    d.partner_id = $('#filter_partner_id_1').val();
					d.date_from  = $('#filter_date_from_1').val() || '';
                    d.date_to    = $('#filter_date_to_1').val()   || ''; 
                }
            },
			
            columns: [
            
            {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
			{data: 'partner_name', name: 'partner_name'},
            {data: 'name', name: 'name'},
			{data: 'payment_date', name: 'payment_date'},
			{data: 'amount', name: 'amount',className:"numericCol"},
			{data: 'payment_id', name: 'payment_id'},
			{data: 'status', name: 'status'},
			{data: 'receipt', name: 'receipt'},
            ],
        });

	    $("#filter_partner_id").change(function()
		{
			table.ajax.reload();
		});

		$("#filter_partner_id_1").change(function()
		{
			table2.ajax.reload();
		});


		// Paid / Unpaid / All pill filter on the first tab
		$('#payments-tab-pane').on('click', '.filter-pill', function () {
			// Skip the date-clear pill — it has its own handler
			if (this.id === 'filter_date_clear') return;
			$('#payments-tab-pane .filter-pills .filter-pill').removeClass('active');
			$(this).addClass('active');
			table.ajax.reload();
		});

		// Date range filter — redraw when either field changes
		$('#filter_date_from, #filter_date_to').on('change', function () {
			table.ajax.reload();
		});

		// Date range filter — redraw when either field changes
		$('#filter_date_from_1, #filter_date_to_1').on('change', function () {
			table2.ajax.reload();
		});


		// Clear button — reset both dates
		$('#filter_date_clear').on('click', function () {
			$('#filter_date_from, #filter_date_to').val('');
			table.ajax.reload();
		});

		// Clear button — reset both dates
		$('#filter_date_clear_1').on('click', function () {
			$('#filter_date_from_1, #filter_date_to_1').val('');
			table2.ajax.reload();
		});

		// Export CSV — payout details (first tab) with current filters
		$('#export_payout_details').on('click', function () {
			var params = {
				partner_id:    $('#filter_partner_id').val()                                          || '',
				status_filter: $('#payments-tab-pane .filter-pills .filter-pill.active').data('status') || '',
				date_from:     $('#filter_date_from').val()                                           || '',
				date_to:       $('#filter_date_to').val()                                             || ''
			};
			var lnk = "{{ route('admin.export-payout-details') }}" + "?" + $.param(params);
			$('#export_payout_details').attr('href', lnk);
		});

		// Export CSV — payment history (second tab) with current filters
		$('#export_payment_history').on('click', function () {
			var params = {
				partner_id: $('#filter_partner_id_1').val() || '',
				date_from:  $('#filter_date_from_1').val()  || '',
				date_to:    $('#filter_date_to_1').val()    || ''
			};
			var lnk = "{{ route('admin.export-payment-history') }}" + "?" + $.param(params);
			$('#export_payment_history').attr('href', lnk);
		});

	});

</script>

@endpush
@endsection