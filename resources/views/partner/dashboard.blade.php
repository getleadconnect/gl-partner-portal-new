@extends('partner.master')
@section('content')
<style>
.gl-pd {
    --gl-surface: #FFFFFF;
    --gl-surface-2: #FAFAFB;
    --gl-border: #E7E9EE;
    --gl-border-soft: #F0F2F5;
    --gl-text: #0F172A;
    --gl-text-soft: #475569;
    --gl-text-muted: #94A3B8;
    --gl-accent: #1E3A5F;
    font-family: 'Geist', -apple-system, BlinkMacSystemFont, sans-serif;
}

/* Hero welcome */
.gl-pd-hero {
    background: linear-gradient(120deg, #0E1B2E 0%, #1E3A5F 60%, #2C5282 100%);
    color: #fff;
    border-radius: 12px;
    padding: 26px 28px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;
    flex-wrap: wrap;
    position: relative;
    overflow: hidden;
}
.gl-pd-hero::before {
    content: ''; position: absolute;
    top: -40%; right: -10%;
    width: 360px; height: 360px;
    background: radial-gradient(circle, rgba(182,139,60,0.18), transparent 65%);
    pointer-events: none;
}
.gl-pd-hero__greeting {
    font-size: 10.5px;
    text-transform: uppercase;
    letter-spacing: 0.16em;
    color: rgba(255,255,255,0.6);
    margin-bottom: 6px;
    font-weight: 600;
}
.gl-pd-hero__title {
    font-size: 22px;
    font-weight: 600;
    margin: 0;
    letter-spacing: -0.01em;
	color:#c9c9c9;
}
.gl-pd-hero__sub {
    margin-top: 6px;
    font-size: 13px;
    color: rgba(255,255,255,0.72);
    max-width: 560px;
}
.gl-pd-hero__cta {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 14px; border-radius: 8px;
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.18);
    color: #fff; text-decoration: none;
    font-size: 13px; font-weight: 500;
    transition: background .15s ease;
}
.gl-pd-hero__cta:hover { background: rgba(255,255,255,0.2); color: #fff; }

/* Update profile alert */
.gl-pd-alert {
    background: linear-gradient(180deg, #FFF8EC 0%, #FFFEFA 100%);
    border: 1px solid #F5D9A1;
    border-radius: 10px;
    padding: 14px 18px;
    margin-bottom: 20px;
    display: flex; align-items: center; gap: 12px;
    color: #78350F;
    font-size: 13px;
}
.gl-pd-alert__icon {
    width: 32px; height: 32px;
    background: #D97706; color: #fff;
    border-radius: 8px;
    display: grid; place-items: center; flex-shrink: 0;
}
.gl-pd-alert .btn-close { margin-left: auto; }

/* KPI grid */
.gl-pd-kpi-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 20px;
}
@media (max-width: 1100px) { .gl-pd-kpi-grid { grid-template-columns: 1fr 1fr; } }
@media (max-width: 580px)  { .gl-pd-kpi-grid { grid-template-columns: 1fr; } }

.gl-pd-kpi {
    background: var(--gl-surface);
    border: 1px solid var(--gl-border);
    border-radius: 10px;
    padding: 18px 20px;
    box-shadow: 0 1px 2px rgba(15,23,42,0.04);
    display: flex; align-items: flex-start; gap: 12px;
}
.gl-pd-kpi__icon {
    width: 36px; height: 36px;
    border-radius: 8px;
    display: grid; place-items: center;
    background: #EEF2F8;
    color: var(--gl-accent);
    flex-shrink: 0;
}
.gl-pd-kpi__icon i { font-size: 18px; }
.gl-pd-kpi__icon.success { background: #ECFDF5; color: #059669; }
.gl-pd-kpi__icon.warn    { background: #FEF3C7; color: #D97706; }
.gl-pd-kpi__icon.gold    { background: #FBF5E5; color: #B68B3C; }
.gl-pd-kpi__icon.danger  { background: #FEE2E2; color: #DC2626; }
.gl-pd-kpi__icon.accent2 { background: #F3EEFF; color: #6D28D9; }
.gl-pd-kpi__body { flex: 1; min-width: 0; }
.gl-pd-kpi__label {
    font-size: 11.5px;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: var(--gl-text-muted);
    font-weight: 600;
    margin-bottom: 6px;
}
.gl-pd-kpi__value {
    font-size: 22px;
    font-weight: 700;
    color: var(--gl-text);
    line-height: 1.1;
    letter-spacing: -0.02em;
    font-family: 'Geist Mono', monospace;
    font-variant-numeric: tabular-nums;
}
.gl-pd-kpi__sub {
    margin-top: 6px;
    font-size: 11.5px;
    color: var(--gl-text-muted);
}

/* Card + table */
.gl-pd-card {
    background: var(--gl-surface);
    border: 1px solid var(--gl-border);
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 1px 2px rgba(15,23,42,0.04);
}
.gl-pd-card__header {
    padding: 14px 20px;
    border-bottom: 1px solid var(--gl-border-soft);
    display: flex; align-items: center; justify-content: space-between;
}
.gl-pd-card__title { font-size: 14px; font-weight: 600; color: var(--gl-text); }
.gl-pd-card__sub { font-size: 12px; color: var(--gl-text-muted); margin-top: 2px; }
.gl-pd-card__link {
    font-size: 12.5px; color: var(--gl-accent);
    text-decoration: none; font-weight: 500;
    display: inline-flex; align-items: center; gap: 4px;
}
.gl-pd-card__link:hover { text-decoration: underline; }

/* Table */
.gl-pd-card table.data { width: 100%; border-collapse: collapse; font-size: 13px; }
.gl-pd-card table.data thead tr { background: var(--gl-surface-2); }
.gl-pd-card table.data thead th {
    padding: 10px 16px; text-align: left;
    font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em;
    color: var(--gl-text-muted); font-weight: 600;
    border-bottom: 1px solid var(--gl-border-soft); white-space: nowrap;
}
.gl-pd-card table.data tbody td {
    padding: 12px 16px; border-bottom: 1px solid var(--gl-border-soft);
    color: var(--gl-text-soft); vertical-align: middle; background: var(--gl-surface);
}
.gl-pd-card table.data tbody tr:hover td { background: #FAFBFC; }

/* Lead avatar cell */
.gl-pd-card .row-avatar { display: inline-flex; align-items: center; gap: 10px; }
.gl-pd-card .row-avatar .av {
    width: 32px; height: 32px; border-radius: 50%;
    display: grid; place-items: center;
    font-size: 11px; font-weight: 600;
    color: #fff; flex-shrink: 0;
}
.gl-pd-card .row-avatar .av.c1 { background: #1E3A5F; }
.gl-pd-card .row-avatar .av.c2 { background: #059669; }
.gl-pd-card .row-avatar .av.c3 { background: #B68B3C; }
.gl-pd-card .row-avatar .av.c4 { background: #DC2626; }
.gl-pd-card .row-avatar .av.c5 { background: #475569; }
.gl-pd-card .row-avatar .av.c6 { background: #2C5282; }
.gl-pd-card .row-avatar .nm { line-height: 1.25; }
.gl-pd-card .row-avatar .nm .name { color: var(--gl-text); font-weight: 500; font-size: 13px; }
.gl-pd-card .row-avatar .nm .sub  { color: var(--gl-text-muted); font-size: 11px; margin-top: 2px; font-family: 'Geist Mono', monospace; }

/* Pills */
.gl-pd-card .pill {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 9px; border-radius: 999px;
    font-size: 11.5px; font-weight: 500;
    background: #F1F5F9; color: #475569;
}
.gl-pd-card .pill::before { content:''; width:5px; height:5px; border-radius:50%; background: currentColor; }
.gl-pd-card .pill.won  { background: #ECFDF5; color: #059669; }
.gl-pd-card .pill.qual { background: #EEF2F8; color: #1E3A5F; }
.gl-pd-card .pill.demo { background: #FEF3C7; color: #D97706; }
.gl-pd-card .pill.cold { background: #FEE2E2; color: #DC2626; }
</style>

<div class="page-content">
    <div class="container-fluid gl-pd">

        @if(!empty($update_message))
            <div class="gl-pd-alert">
                <div class="gl-pd-alert__icon"><i class="bx bx-error-circle"></i></div>
                <span>{!! $update_message !!} (Click <b>Edit Profile</b>)</span>
            </div>
        @endif

        {{-- Hero welcome --}}
        <div class="gl-pd-hero">
            <div>
                <div class="gl-pd-hero__greeting">Welcome back</div>
                <h1 class="gl-pd-hero__title">{{ Auth::guard('partner')->user()->name }}</h1>
                <div class="gl-pd-hero__sub">Track your leads, conversions and payouts at a glance.</div>
            </div>
            <a href="{{ route('partner.leads') }}" class="gl-pd-hero__cta">
                <i class="bx bx-list-ul"></i> My Leads
            </a>
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
        <div class="gl-pd-kpi-grid">
            <div class="gl-pd-kpi">
                <div class="gl-pd-kpi__icon"><i class="bx bx-search"></i></div>
                <div class="gl-pd-kpi__body">
                    <div class="gl-pd-kpi__label">Total Leads</div>
                    <div class="gl-pd-kpi__value">{{ $data['leads_count'] }}</div>
                    <div class="gl-pd-kpi__sub">{{ $data['leads_this_month'] ?? 0 }} this month</div>
                </div>
            </div>
            <div class="gl-pd-kpi">
                <div class="gl-pd-kpi__icon success"><i class="bx bx-check"></i></div>
                <div class="gl-pd-kpi__body">
                    <div class="gl-pd-kpi__label">Closed (Got Business)</div>
                    <div class="gl-pd-kpi__value">{{ $data['leads_business'] }}</div>
                    <div class="gl-pd-kpi__sub">{{ $data['conversion_rate'] ?? 0 }}% close rate</div>
                </div>
            </div>
            <div class="gl-pd-kpi">
                <div class="gl-pd-kpi__icon warn"><i class="bx bx-time-five"></i></div>
                <div class="gl-pd-kpi__body">
                    <div class="gl-pd-kpi__label">Open Leads</div>
                    <div class="gl-pd-kpi__value">{{ $data['leads_count'] - $data['leads_business'] }}</div>
                    <div class="gl-pd-kpi__sub">In the pipeline</div>
                </div>
            </div>
            <div class="gl-pd-kpi">
                <div class="gl-pd-kpi__icon gold"><i class="bx bx-rupee"></i></div>
                <div class="gl-pd-kpi__body">
                    <div class="gl-pd-kpi__label">Total Commission</div>
                    <div class="gl-pd-kpi__value">{!! $shortInr($data['total_commission']) !!}</div>
                    <div class="gl-pd-kpi__sub">Earned to date</div>
                </div>
            </div>
            <div class="gl-pd-kpi">
                <div class="gl-pd-kpi__icon success"><i class="bx bx-wallet"></i></div>
                <div class="gl-pd-kpi__body">
                    <div class="gl-pd-kpi__label">Paid</div>
                    <div class="gl-pd-kpi__value">{!! $shortInr($data['paid_commission']) !!}</div>
                    <div class="gl-pd-kpi__sub">Released to your account</div>
                </div>
            </div>
            <div class="gl-pd-kpi">
                <div class="gl-pd-kpi__icon danger"><i class="bx bx-error"></i></div>
                <div class="gl-pd-kpi__body">
                    <div class="gl-pd-kpi__label">Balance</div>
                    <div class="gl-pd-kpi__value">{!! $shortInr($data['balance']) !!}</div>
                    <div class="gl-pd-kpi__sub">Awaiting payout</div>
                </div>
            </div>
        </div>

        {{-- Latest leads --}}
        <div class="gl-pd-card">
            <div class="gl-pd-card__header">
                <div>
                    <div class="gl-pd-card__title">Latest Leads</div>
                    <div class="gl-pd-card__sub">Your 10 most recent submissions</div>
                </div>
                <a href="{{ route('partner.leads') }}" class="gl-pd-card__link">View all <i class="bx bx-chevron-right"></i></a>
            </div>
            <div class="table-responsive"  style="padding:10px;" >
                <table id="business-leads-table" class="data" style="width:100% !important;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Lead</th>
                            <th>Company</th>
                            <th>Address</th>
                            <th>Location</th>
                            <th>Lead Status</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script type="text/javascript">
var table = $('#business-leads-table').DataTable({
    processing: true,
    serverSide: true,
    stateStatus: true,
    "language": { searchPlaceholder: 'Search', sSearch: '' },
    "lengthMenu": [10, 25, 50, 100, 150, 200],
    ajax: { url: "{{ route('partner.get-business-leads') }}" },
    columns: [
        { data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false },
        { data: 'lead',         name: 'lead',        orderable: false, searchable: false },
        { data: 'company_name', name: 'company_name' },
        { data: 'address',      name: 'address' },
        { data: 'area',         name: 'area' },
        { data: 'lead_status',  name: 'lead_status', orderable: false },
    ]
});
</script>
@endpush
@endsection
