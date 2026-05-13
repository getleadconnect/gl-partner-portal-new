@extends('admin.master')
@section('content')
<style>
/* ============ PARTNERS ACTIVITY — PAGE HEADER ============ */
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
.gl-pact {
    --gl-surface: #FFFFFF; --gl-surface-2: #FAFAFB;
    --gl-border: #E7E9EE; --gl-border-soft: #F0F2F5;
    --gl-text: #0F172A; --gl-text-soft: #475569; --gl-text-muted: #94A3B8;
    font-family: 'Geist', -apple-system, BlinkMacSystemFont, sans-serif;
    padding:10px;
}
.gl-pact table.data { width: 100%; border-collapse: collapse; font-size: 13px; }
.gl-pact table.data thead tr { background: var(--gl-surface-2); }
.gl-pact table.data thead th {
    padding: 10px 16px; text-align: left;
    font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em;
    color: var(--gl-text-muted); font-weight: 600;
    border-bottom: 1px solid var(--gl-border-soft); white-space: nowrap;
}
.gl-pact table.data tbody td {
    padding: 12px 16px; border-bottom: 1px solid var(--gl-border-soft);
    color: var(--gl-text-soft); vertical-align: middle; background: var(--gl-surface);
}
.gl-pact table.data tbody tr:hover td { background: #FAFBFC; }

/* Partner cell — clickable avatar */
.gl-pact .row-avatar {
    display: inline-flex; align-items: center; gap: 10px;
    text-decoration: none;
}
.gl-pact .row-avatar:hover .nm .name { color: #1E3A5F; }
.gl-pact .row-avatar .av {
    width: 32px; height: 32px; border-radius: 50%;
    display: grid; place-items: center; font-size: 11px; font-weight: 600;
    color: #fff; flex-shrink: 0; letter-spacing: 0.02em;
}
.gl-pact .row-avatar .av.c1 { background: #1E3A5F; }
.gl-pact .row-avatar .av.c2 { background: #059669; }
.gl-pact .row-avatar .av.c3 { background: #B68B3C; }
.gl-pact .row-avatar .av.c4 { background: #DC2626; }
.gl-pact .row-avatar .av.c5 { background: #475569; }
.gl-pact .row-avatar .av.c6 { background: #2C5282; }
.gl-pact .row-avatar .nm { line-height: 1.25; }
.gl-pact .row-avatar .nm .name { color: var(--gl-text); font-weight: 500; font-size: 13px; }
.gl-pact .row-avatar .nm .sub { color: var(--gl-text-muted); font-size: 11px; margin-top: 2px; font-family: 'Geist Mono', monospace; }

/* Status / Lead-status pills */
.gl-pact .pill {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 9px; border-radius: 999px;
    font-size: 11.5px; font-weight: 500;
    background: #F1F5F9; color: #475569;
}
.gl-pact .pill::before { content:''; width:5px; height:5px; border-radius:50%; background: currentColor; }
.gl-pact .pill.paid    { background: #ECFDF5; color: #059669; }
.gl-pact .pill.unpaid  { background: #FEE2E2; color: #DC2626; }
.gl-pact .pill.won     { background: #ECFDF5; color: #059669; }
.gl-pact .pill.qual    { background: #EEF2F8; color: #1E3A5F; }
.gl-pact .pill.demo    { background: #FEF3C7; color: #D97706; }
.gl-pact .pill.cold    { background: #FEE2E2; color: #DC2626; }
</style>

<div class="page-content">
    <div class="container-fluid">

        <div class="gl-page-header">
            <div class="gl-page-header__text">
                <h1 class="gl-page-title">Partner Activities</h1>
                <div class="gl-page-subtitle">Latest lead activity for each active partner.</div>
            </div>
            <div class="gl-page-header__actions">
                    <a href="javascript:void(0);" id="export_to_excel" class="gl-btn gl-btn-outline">
                      <i class="bx bx-download"></i> Export CSV
                    </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body" style="padding:0;">

                        <div class="gl-payouts-toolbar" style="justify-content:flex-start;">
                            
                            <select id="filter_partner_id" class="filter-select-gl" style="border-radius:22px;">
                                <option value="">All partners</option>
                                @foreach($partners as $key=>$value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>

                            <div class="filter-group">
                                <div class="date-range">
                                    <label class="date-range__label">From</label>
                                    <input type="date" id="filter_date_from" class="filter-select-gl date-range__input">
                                    <label class="date-range__label">To</label>
                                    <input type="date" id="filter_date_to" class="filter-select-gl date-range__input">
                                    <button type="button" id="filter_date_clear" class="date_clear filter-pill" title="Clear date range"><i class="bx bx-x"></i></button>
                                </div>
                            </div>

                        </div>

                        <div class="table-responsive gl-pact">
                            <table id="partner-table" class="data" style="width:100% !important;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Partner</th>
                                        <th>Unique Id</th>
                                        <th>Mobile</th>
                                        <th>Status</th>
                                        <th>Latest Lead</th>
                                        <th>Company</th>
                                        <th>Last Activity</th>
                                        <th>Lead Status</th>
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

@push('scripts')
<script type="text/javascript">
$(function () {
    toastr.options = { "showDuration": "300000", "hideMethod": "fadeOut" };
});

$(function () {
    var table = $('#partner-table').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 50,
        "language": { searchPlaceholder: 'Search', sSearch: '' },
        "lengthMenu": [10, 25, 50, 100, 150, 200],
        ajax: {
            url: "{{ route('admin.view-partners-activities') }}",
            data: function (data) {
                data.partner_id   = $('#filter_partner_id').val();
                data.date_from    = $('#filter_date_from').val() || '';
                data.date_to      = $('#filter_date_to').val()   || '';
            }
        },
        columns: [
            { data: 'DT_RowIndex',     name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name',            name: 'name' },
            { data: 'partnerId',       name: 'partnerId', orderable: false, searchable: false },
            { data: 'mobile',          name: 'mobile' },
            { data: 'status',          name: 'status' },
            { data: 'lead_name',       name: 'lead_name' },
            { data: 'lead_company',    name: 'lead_company' },
            { data: 'lead_created_at', name: 'lead_created_at' },
            { data: 'lead_status',     name: 'lead_status' },
        ]
    });

    $("#filter_partner_id").change(function()
	{
		table.ajax.reload();
	});
    // Date range — redraw on change
    $('#filter_date_from, #filter_date_to').on('change', function () {
        table.ajax.reload();
    });

    // Date range — clear button
    $('#filter_date_clear').on('click', function () {
        $('#filter_date_from, #filter_date_to').val('');
        table.ajax.reload();
    });

    $("#export_to_excel").click(function () {
        var params = {
            partner_id: $('#filter_partner_id').val() || '',
            date_from:  $('#filter_date_from').val()  || '',
            date_to:    $('#filter_date_to').val()    || ''
        };
        var lnk = "{{ url('admin/export-partners-activity') }}" + "?" + $.param(params);
        $("#export_to_excel").attr('href', lnk);
    });
});
</script>
@endpush
@endsection
