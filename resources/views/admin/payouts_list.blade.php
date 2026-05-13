@extends('admin.master')
@section('content')
<style>
.error { color:red !important; font-size:12px !important; }

/* ============ PAYOUTS — PAGE HEADER ============ */
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

/* ============ PAYOUTS — KPI ============ */
.gl-kpi-grid {
    display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 20px;
    font-family: 'Geist', -apple-system, BlinkMacSystemFont, sans-serif;
}
.gl-kpi {
    background: #FFFFFF; border: 1px solid #E7E9EE; border-radius: 8px;
    padding: 16px 18px; box-shadow: 0 1px 2px rgba(15,23,42,0.04);
}
.gl-kpi-head { display: flex; align-items: center; gap: 8px; margin-bottom: 10px; }
.gl-kpi-icon {
    width: 28px; height: 28px; border-radius: 7px;
    display: grid; place-items: center;
    background: #EEF2F8; color: #1E3A5F;
}
.gl-kpi-icon i { font-size: 15px; line-height: 1; }
.gl-kpi-icon.warn    { background: #FEF3C7; color: #D97706; }
.gl-kpi-icon.success { background: #ECFDF5; color: #059669; }
.gl-kpi-icon.danger  { background: #FEE2E2; color: #DC2626; }
.gl-kpi-label { font-size: 12px; color: #475569; font-weight: 500; }
.gl-kpi-value {
    font-size: 24px; font-weight: 600; letter-spacing: -0.02em;
    color: #0F172A; line-height: 1.1;
    font-family: 'Geist Mono', monospace; font-variant-numeric: tabular-nums;
}
.gl-kpi-foot { margin-top: 8px; font-size: 12px; color: #475569; }
.gl-kpi-foot.danger { color: #DC2626; font-weight: 500; }
@media (max-width: 1100px) { .gl-kpi-grid { grid-template-columns: 1fr 1fr; } }
@media (max-width: 540px)  { .gl-kpi-grid { grid-template-columns: 1fr; } }

/* ============ PAYOUTS — TOOLBAR ============ */
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
.gl-payouts-toolbar .tabs .tab .mono { font-family: 'Geist Mono', monospace; font-size: 11px; opacity: 0.85; margin-left: 4px; }
.gl-payouts-toolbar .filter-group { display: flex; gap: 8px; align-items: center; }
.gl-payouts-toolbar .filter-select-gl {
    padding: 6px 10px; border: 1px solid #E7E9EE; border-radius: 6px;
    background: #FFFFFF; font-size: 12.5px; color: #0F172A;
    font-family: inherit; cursor: pointer; outline: none;
}
.gl-payouts-toolbar .filter-select-gl:focus { border-color: #1E3A5F; }

/* Legend strip */
.gl-payouts-legend {
    display: flex; gap: 16px; align-items: center;
    padding: 10px 20px;
    background: #FAFAFB; border-bottom: 1px solid #F0F2F5;
    font-size: 11.5px; color: #475569;
    flex-wrap: wrap;
}
.gl-payouts-legend .legend-item { display: inline-flex; align-items: center; gap: 6px; }
.gl-payouts-legend .legend-spacer { color: #94A3B8; margin-left: auto; }

/* ============ PAYOUTS — TABLE ============ */
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
    font-family: 'Geist Mono', monospace; text-align: right;
    font-variant-numeric: tabular-nums;
}
.gl-payouts table.data td .num.strong { color: var(--gl-text); font-weight: 600; font-family: 'Geist Mono', monospace; }
.gl-payouts table.data td .num.muted  { color: var(--gl-text-muted); font-family: 'Geist Mono', monospace; }

/* Partner cell — clickable link wrapping avatar */
.gl-payouts .row-avatar {
    display: inline-flex; align-items: center; gap: 10px;
    text-decoration: none;
}
.gl-payouts .row-avatar.partner-link { color: inherit; }
.gl-payouts .row-avatar:hover .nm .name { color: #1E3A5F; }
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
.gl-payouts .pill.won    { background: #ECFDF5; color: #059669; }
.gl-payouts .pill.won::before { background: #059669; }
.gl-payouts .pill.paid   { background: #ECFDF5; color: #059669; }
.gl-payouts .pill.paid::before { background: #059669; }
.gl-payouts .pill.unpaid { background: #FEE2E2; color: #DC2626; }
.gl-payouts .pill.unpaid::before { background: #DC2626; }

/* Aged column */
.gl-payouts .days {
    display: inline-flex; align-items: center; gap: 5px;
    font-family: 'Geist Mono', monospace; font-size: 12px;
    color: var(--gl-text-soft);
}
.gl-payouts .days.fresh { color: var(--gl-text-muted); }
.gl-payouts .days.stale { color: #D97706; font-weight: 500; }
.gl-payouts .days.cold  { color: #DC2626; font-weight: 600; }
.gl-payouts .days .dot { width: 5px; height: 5px; border-radius: 50%; background: currentColor; }

/* Pay button used inside the action column */
.gl-payouts .gl-btn { padding: 6px 12px; font-size: 12px; }

.fs-10 { font-size: 10px; color: #DC2626; font-weight: 600; }
.numericCol { text-align: right; }
#unpaid_leads_table .name:hover
{
    color:blue;
    font-weight:500;
}
</style>

<div class="page-content">
    <div class="container-fluid">

        <div class="gl-page-header">
            <div class="gl-page-header__text">
                <h1 class="gl-page-title">Prepare Payouts</h1>
                <div class="gl-page-subtitle">Commission due for closed-won leads · Released after customer payment clears.</div>
            </div>
            <div class="gl-page-header__actions">
                <a href="{{ url('admin/payout-history') }}" class="gl-btn gl-btn-outline">
                    <i class="bx bx-time-five"></i> Payout History
                </a>
            </div>
        </div>

        {{-- KPI cards --}}
        @php
            $shortInr = function ($val) {
                $val = (int) $val;
                if ($val >= 10000000) return '&#8377;'.round($val/10000000, 1).'Cr';
                if ($val >= 100000)   return '&#8377;'.round($val/100000, 1).'L';
                return '&#8377;'.number_format($val, 0, '.', ',');
            };
        @endphp
        <div class="gl-kpi-grid">
            <div class="gl-kpi">
                <div class="gl-kpi-head">
                    <div class="gl-kpi-icon warn"><i class="bx bx-rupee"></i></div>
                    <div class="gl-kpi-label">Pending Payout</div>
                </div>
                <div class="gl-kpi-value">{!! $shortInr($pending_payout ?? 0) !!}</div>
                <div class="gl-kpi-foot">Across {{ $pending_deals ?? 0 }} deal{{ ($pending_deals ?? 0) == 1 ? '' : 's' }}</div>
            </div>
            <div class="gl-kpi">
                <div class="gl-kpi-head">
                    <div class="gl-kpi-icon"><i class="bx bx-group"></i></div>
                    <div class="gl-kpi-label">Partners Owed</div>
                </div>
                <div class="gl-kpi-value">{{ $partners_owed ?? 0 }}</div>
                <div class="gl-kpi-foot">Awaiting payout</div>
            </div>
            <div class="gl-kpi">
                <div class="gl-kpi-head">
                    <div class="gl-kpi-icon danger"><i class="bx bx-error"></i></div>
                    <div class="gl-kpi-label">Aged (&gt;14 days)</div>
                </div>
                <div class="gl-kpi-value">{!! $shortInr($aged_payout ?? 0) !!}</div>
                <div class="gl-kpi-foot danger">{{ $aged_deals ?? 0 }} deal{{ ($aged_deals ?? 0) == 1 ? '' : 's' }} overdue</div>
            </div>
            <div class="gl-kpi">
                <div class="gl-kpi-head">
                    <div class="gl-kpi-icon success"><i class="bx bx-check"></i></div>
                    <div class="gl-kpi-label">Paid This Month</div>
                </div>
                <div class="gl-kpi-value">{!! $shortInr($paid_this_month ?? 0) !!}</div>
                <div class="gl-kpi-foot">@if(($paid_this_month ?? 0) === 0)No payouts processed yet @else Released to partners @endif</div>
            </div>
        </div>

        <div class="card">

            {{-- TAB & FILTER TOOLBAR --}}
            <div class="gl-payouts-toolbar">
                <div class="tabs" role="tablist">
                    <button class="tab active" id="unpaid-tab" data-bs-toggle="tab" data-bs-target="#unpaid-tab-pane" type="button" role="tab" aria-selected="true">
                        Un-Paid <span class="mono">{{ $unpaid_count ?? 0 }}</span>
                    </button>
                    <button class="tab" id="paid-tab" data-bs-toggle="tab" data-bs-target="#paid-tab-pane" type="button" role="tab" aria-selected="false">
                        Paid <span class="mono">{{ $paid_count ?? 0 }}</span>
                    </button>
                </div>
                
            </div>

            <div class="gl-payouts-legend">
                <span class="legend-item"><span class="type-mark r">R</span> Renewal commission</span>
                <span class="legend-item"><span class="type-mark i">I</span> First (initial) commission</span>
                <span class="legend-spacer">Commission paid after customer payment clears</span>
            </div>

            <div class="tab-content" id="payoutsTabContent">

                {{-- UN-PAID TAB --}}
                <div class="tab-pane fade show active" id="unpaid-tab-pane" role="tabpanel" tabindex="0">

               
                    <select id="unpaid_partner_filter" class="filter-select-gl" style="margin-left:10px;">
                        <option value="">All partners</option>
                        @foreach($partners as $key=>$value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
           

                    <div class="table-responsive gl-payouts">
                        <table id="unpaid_leads_table" class="data" style="width:100% !important;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Partner</th>
                                    <th>Lead</th>
                                    <!--<th>Email / Mobile</th>-->
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th class="num">Deal Amount</th>
                                    <th class="num">Commission</th>
                                    <th class="num">Paid</th>
                                    <th class="num">Balance</th>
                                    <th>Aged</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

                {{-- PAID TAB --}}
                <div class="tab-pane fade" id="paid-tab-pane" role="tabpanel" tabindex="0">
  
                    <select id="paid_partner_filter" class="filter-select-gl" style="margin-left:10px;">
                        <option value="">All partners</option>
                        @foreach($partners as $key=>$value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
           
   
                    <div class="table-responsive gl-payouts">
                        <table id="paid_leads_table" class="data " style="width:100% !important;" >
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Partner</th>
                                    <th>Lead</th>
                                    <!--<th>Email / Mobile</th>-->
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th class="num">Deal Amount</th>
                                    <th class="num">Commission</th>
                                    <th class="num">Paid Amount</th>
                                    <!--<th>Aged</th>-->
                                    <th>Status</th>
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

{{-- Existing modals kept for the set-commission flow --}}
<div class="modal fade" id="set-payment-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Payment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="set-commission-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Set Collected Amount</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" name="temp_comm_percentage" id="temp_comm_percentage">
                <form id="setLeadCommission">
                    @csrf
                    <input type="text" class="form-control" name="set_comm_lead_id" id="set_comm_lead_id">
                    <input type="text" class="form-control" name="set_comm_lead_status" id="set_comm_lead_status">
                    <input type="text" class="form-control" name="renewal_status" id="renewal_status">

                    <div class="form-group ">
                        <input type="checkbox" name="cbox_renewal" id="cbox_renewal" style="width:20px;height:20px;font-size:16px;vertical-align:middle;">&nbsp;&nbsp;Renewal Amount
                    </div>

                    <div class="form-group mt-2">
                        <label for="set_comm_percentage" class="form-label">Commission (%)</label>
                        <input type="number" class="form-control" name="set_comm_percentage" id="set_comm_percentage" readonly>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <label class="form-label">Collected Amount</label>
                                <input type="number" class="form-control" name="set_collected_amount" id="set_collected_amount">
                                <label class="error" id="err-msg" style="display:none;"></label>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Commission</label>
                                <input type="number" class="form-control" name="set_commission" id="set_commission">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea rows="3" class="form-control" name="description" id="description" required></textarea>
                    </div>

                    <div class="form-group mt-3 mb-3" style="text-align:right;">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">
$(function () { toastr.options = { "showDuration": "300000", "hideMethod": "fadeOut" }; });
</script>

@if(Session::has('success'))
<script>toastr.success("{{ Session::get('success') }}");</script>
@endif

<script type="text/javascript">
$(function () {

    // ---- Tab visual sync (matches new pill tabs) ----
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

    // ---- UN-PAID TABLE ----
    var table = $('#unpaid_leads_table').DataTable({
        processing: true,
        serverSide: true,
        bAutoWidth: false,
        language: { searchPlaceholder: 'Search', sSearch: '' },
        lengthMenu: [10, 25, 50, 100, 150, 200],
        ajax: {
            url: "{{ route('admin.got-business-unpaid-leads') }}",
            data: function (d) { d.partner_id = $('#partner_filter').val(); }
        },
        columns: [
            {data: 'DT_RowIndex',       name: 'DT_RowIndex',       orderable: false, searchable: false},
            {data: 'partner',           name: 'partner',           orderable: false},
            {data: 'lead_name',         name: 'lead_name'},
            //{data: 'email',             name: 'email'},
            {data: 'type',              name: 'type',              orderable: false, searchable: false},
            {data: 'status',            name: 'status',            orderable: false},
            {data: 'amount_collected',  name: 'amount_collected',  className: 'numericCol'},
            {data: 'commission_amount', name: 'commission_amount', className: 'numericCol'},
            {data: 'amount',            name: 'amount',            className: 'numericCol'},
            {data: 'balance',           name: 'balance',           className: 'numericCol'},
            {data: 'aged',              name: 'aged',              orderable: false, searchable: false},
            {data: 'actions',           name: 'actions',           orderable: false, searchable: false, className: 'text-center'},
        ]
    });

    $("#unpaid_leads_table_length").append(unpaid_partner_filter);

    $("#unpaid_partner_filter").change(function () {
            table.draw();
    });

    // ---- PAID TABLE ----
    var table2 = $('#paid_leads_table').DataTable({
        processing: true,
        serverSide: true,
        bAutoWidth: false,
        language: { searchPlaceholder: 'Search', sSearch: '' },
        lengthMenu: [10, 25, 50, 100, 150, 200],
        ajax: {
            url: "{{ route('admin.got-business-paid-leads') }}",
            data: function (d) { d.partner_id = $('#paid_partner_filter').val(); }
        },
        columns: [
            {data: 'DT_RowIndex',       name: 'DT_RowIndex',       orderable: false, searchable: false},
            {data: 'partner',           name: 'partner',           orderable: false},
            {data: 'lead_name',         name: 'lead_name'},
            //{data: 'email',             name: 'email'},
            {data: 'type',              name: 'type',              orderable: false, searchable: false},
            {data: 'status',            name: 'status',            orderable: false},
            {data: 'amount_collected',  name: 'amount_collected',  className: 'numericCol'},
            {data: 'commission_amount', name: 'commission_amount', className: 'numericCol'},
            {data: 'paid_amount',       name: 'paid_amount',       className: 'numericCol'},
            //{data: 'aged',              name: 'aged',              orderable: false, searchable: false},
            {data: 'pay_status',        name: 'pay_status',        orderable: false, searchable: false},
        ]
    });

    $("#paid_leads_table_length").append(paid_partner_filter);

    $("#paid_partner_filter").change(function () { table2.draw(); });
    $("#paid-tab").click(function () { table2.ajax.reload(); });

});
</script>

@endpush
@endsection
