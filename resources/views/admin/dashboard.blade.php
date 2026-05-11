@extends('admin.master')
@section('style')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
.gl-dash {
    --bg: #F5F5F7;
    --paper: #FFFFFF;
    --line: #E5E7EB;
    --line-soft: #F0F0F2;
    --ink: #111827;
    --ink-soft: #374151;
    --muted: #6B7280;
    --accent: #1E3A5F;
    --accent-soft: #E8EEF4;
    --gold: #C9A961;
    --gold-soft: #FBF6E8;
    --success: #10B981;
    --success-soft: #ECFDF5;
    --danger: #EF4444;
    --danger-soft: #FEF2F2;
    --gl-radius: 8px;
    --shadow-sm: 0 1px 2px rgba(0,0,0,0.04);

    font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, sans-serif;
    color: var(--ink);
    font-size: 14px;
    line-height: 1.5;
    font-feature-settings: 'tnum' 1;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.gl-dash .welcome {
    background: linear-gradient(120deg, var(--accent) 0%, #2A4D78 100%);
    color: white;
    border-radius: var(--gl-radius);
    padding: 22px 28px;
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 24px;
    align-items: center;
}
.gl-dash .welcome h1 { font-size: 20px; font-weight: 600; margin-bottom: 6px; color:#fff;}
.gl-dash .welcome p { font-size: 13px; color: rgba(255,255,255,0.78); max-width: 640px; margin:0;}
.gl-dash .welcome .month-stamp {
    text-align: right;
    color: rgba(255,255,255,0.78);
    font-size: 11px;
    font-family: 'JetBrains Mono', monospace;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}
.gl-dash .welcome .month-stamp strong {
    display: block;
    color: var(--gold);
    font-size: 22px;
    font-weight: 600;
    font-family: 'DM Sans', sans-serif;
    margin-top: 2px;
    letter-spacing: 0;
    text-transform: none;
}

.gl-dash .kpi-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; }
.gl-dash .kpi {
    background: var(--paper);
    border: 1px solid var(--line);
    border-radius: var(--gl-radius);
    padding: 20px 22px;
    box-shadow: var(--shadow-sm);
}
.gl-dash .kpi-head { display: flex; align-items: center; gap: 10px; margin-bottom: 14px; }
.gl-dash .kpi-icon {
    width: 30px; height: 30px; border-radius: 6px;
    background: var(--accent-soft);
    display: flex; align-items: center; justify-content: center;
}
.gl-dash .kpi-icon i { font-size:18px; color: var(--accent); }
.gl-dash .kpi-icon.gold { background: var(--gold-soft); }
.gl-dash .kpi-icon.gold i { color: var(--gold); }
.gl-dash .kpi-icon.success { background: var(--success-soft); }
.gl-dash .kpi-icon.success i { color: var(--success); }
.gl-dash .kpi-icon.danger { background: var(--danger-soft); }
.gl-dash .kpi-icon.danger i { color: var(--danger); }

.gl-dash .kpi-label { font-size: 14px; color: var(--muted); font-weight: 500; }
.gl-dash .kpi-value {
    font-size: 26px; font-weight: 700; color: var(--ink); line-height: 1.1;
    display: flex; align-items: baseline; gap: 6px;
}
.gl-dash .kpi-value .target { font-size: 13px; font-weight: 500; color: var(--muted); }
.gl-dash .kpi-bar { height: 6px; background: var(--line-soft); border-radius: 999px; overflow: hidden; margin-top: 14px; }
.gl-dash .kpi-bar-fill { height: 100%; background: var(--accent); border-radius: 999px; }
.gl-dash .kpi-bar-fill.gold { background: var(--gold); }
.gl-dash .kpi-bar-fill.success { background: var(--success); }
.gl-dash .kpi-bar-fill.danger { background: var(--danger); }
.gl-dash .kpi-meta {
    display: flex; justify-content: space-between; align-items: center;
    margin-top: 10px; font-size: 11px; color: var(--muted);
    font-family: 'JetBrains Mono', monospace;
}

.gl-dash .mid-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.gl-dash .gl-card {
    background: var(--paper);
    border: 1px solid var(--line);
    border-radius: var(--gl-radius);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
}
.gl-dash .gl-card-head {
    padding: 16px 22px;
    border-bottom: 1px solid var(--line);
    display: flex; align-items: center; justify-content: space-between;
}
.gl-dash .gl-card-title { font-size: 17px; font-weight: 600; color: var(--ink); }
.gl-dash .gl-card-sub { font-size: 13px; color: var(--muted); margin-top: 2px; }
.gl-dash .gl-card-link { font-size: 12px; color: var(--accent); text-decoration: none; font-weight: 500; }
.gl-dash .gl-card-link:hover { text-decoration: underline; }

.gl-dash .tier-rows { padding: 4px 0; }
.gl-dash .tier-row {
    padding: 14px 22px;
    display: grid;
    grid-template-columns: auto 1fr auto;
    gap: 16px;
    align-items: center;
    border-bottom: 1px solid var(--line-soft);
}
.gl-dash .tier-row:last-child { border-bottom: 0; }
.gl-dash .tier-dot { width: 10px; height: 10px; border-radius: 50%; background: var(--accent); }
.gl-dash .tier-dot.success { background: var(--success); }
.gl-dash .tier-dot.gold { background: var(--gold); }
.gl-dash .tier-dot.muted { background: var(--muted); }
.gl-dash .tier-info .name { font-weight: 600; font-size: 15px; color: var(--ink); }
.gl-dash .tier-info .desc { font-size: 13px; color: var(--muted); margin-top: 1px; }
.gl-dash .tier-count {
    font-size: 20px; font-weight: 600; color: var(--ink);
    font-family: 'JetBrains Mono', monospace;
}

.gl-dash .leaderboard { padding: 4px 0; }
.gl-dash .lb-row {
    padding: 12px 22px;
    display: grid;
    grid-template-columns: 32px 1fr auto;
    gap: 14px;
    align-items: center;
    border-bottom: 1px solid var(--line-soft);
}
.gl-dash .lb-row:last-child { border-bottom: 0; }
.gl-dash .lb-rank {
    width: 28px; height: 28px; border-radius: 50%;
    background: var(--bg); border: 1px solid var(--line);
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 600; color: var(--ink);
    font-family: 'JetBrains Mono', monospace;
}
.gl-dash .lb-row.rank-1 .lb-rank { background: var(--gold); border-color: var(--gold); color: white; }
.gl-dash .lb-row.rank-2 .lb-rank { background: #D0D4DC; border-color: #D0D4DC; color: var(--ink); }
.gl-dash .lb-row.rank-3 .lb-rank { background: #E0BB94; border-color: #E0BB94; color: white; }
.gl-dash .lb-name { font-size: 15px; font-weight: 500; color: var(--ink); }
.gl-dash .lb-deals { font-size: 13px; color: var(--muted); font-family: 'JetBrains Mono', monospace; margin-top:2px;}
.gl-dash .lb-gmv { font-size: 13px; font-weight: 600; color: var(--ink); font-family: 'JetBrains Mono', monospace; }
.gl-dash .lb-empty { padding:18px 22px; color:var(--muted); font-size:12px; text-align:center;}

.gl-dash .bottom-grid { display: grid; grid-template-columns: 1.7fr 1fr; gap: 16px; }
.gl-dash .leads-table { width: 100%; border-collapse: collapse; font-size: 13px; margin:0;}
.gl-dash .leads-table th {
    text-align: left; padding: 10px 22px;
    background: var(--bg); color: var(--muted);
    font-weight: 500; font-size: 11px;
    text-transform: uppercase; letter-spacing: 0.06em;
    border-bottom: 1px solid var(--line);
}
.gl-dash .leads-table td {
    padding: 12px 22px;
    border-bottom: 1px solid var(--line-soft);
    color: var(--ink-soft);
}
.gl-dash .leads-table tr:last-child td { border-bottom: 0; }
.gl-dash .leads-table td:first-child {
    color: var(--muted);
    font-family: 'JetBrains Mono', monospace;
    font-size: 11px; width: 32px;
}
.gl-dash .lead-status {
    display: inline-block;
    padding: 2px 8px;
    border-radius: 999px;
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    font-weight: 600;
    font-family: 'JetBrains Mono', monospace;
    background: var(--bg); color: var(--muted);
}
.gl-dash .lead-status.won { background: var(--success-soft); color: var(--success); }
.gl-dash .lead-status.qual { background: var(--accent-soft); color: var(--accent); }
.gl-dash .lead-status.demo { background: var(--gold-soft); color: #8B6F2A; }
.gl-dash .lead-status.cold { background: var(--danger-soft); color: var(--danger); }

.gl-dash .notif-list { padding: 8px 0; max-height: 460px; overflow-y: auto; }
.gl-dash .notif {
    padding: 12px 22px;
    display: flex; gap: 12px;
    border-bottom: 1px solid var(--line-soft);
}
.gl-dash .notif:last-child { border-bottom: 0; }
.gl-dash .notif-icon {
    width: 28px; height: 28px; border-radius: 6px;
    background: var(--accent-soft);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.gl-dash .notif-icon i { color: var(--accent); font-size:14px; }
.gl-dash .notif-body { font-size: 12.5px; color: var(--ink-soft); line-height: 1.5; }
.gl-dash .notif-time {
    font-size: 10px; color: var(--muted);
    font-family: 'JetBrains Mono', monospace;
    margin-top: 4px; letter-spacing: 0.04em; text-transform: uppercase;
}
.gl-dash .notif-empty { padding:18px 22px; color:var(--muted); font-size:12px; text-align:center;}

@media (max-width: 1100px) {
    .gl-dash .kpi-grid { grid-template-columns: 1fr 1fr; }
    .gl-dash .bottom-grid { grid-template-columns: 1fr; }
}
@media (max-width: 768px) {
    .gl-dash .welcome { grid-template-columns: 1fr; padding: 16px 18px; gap: 12px; }
    .gl-dash .welcome .month-stamp { text-align: left; }
    .gl-dash .kpi-grid { grid-template-columns: 1fr 1fr; gap: 10px; }
    .gl-dash .kpi { padding: 14px 14px; }
    .gl-dash .kpi-value { font-size: 22px; }
    .gl-dash .mid-grid { grid-template-columns: 1fr; }
}
@media (max-width: 480px) {
    .gl-dash .kpi-grid { grid-template-columns: 1fr; }
}
</style>
@endsection
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Dashboard</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="gl-dash">

            <div class="welcome">
                <div>
                    <h1>Welcome back, {{ Auth::guard('admin')->user()->name }}</h1>
                    <p>Track partner performance, lead conversion and payouts at a glance.</p>
                </div>
                <div class="month-stamp">
                    {{ $data['month_label'] }}
                    <strong>Day {{ $data['day_of_month'] }} of {{ $data['days_in_month'] }}</strong>
                </div>
            </div>

            <div class="kpi-grid">

                <div class="kpi">
                    <div class="kpi-head">
                        <div class="kpi-icon"><i class="bx bx-rupee"></i></div>
                        <div class="kpi-label">Monthly Volume</div>
                    </div>
                    <div class="kpi-value">&#8377;{{ number_format($data['monthly_volume'],2,'.',',') }}</div>
                    <div class="kpi-meta">
                        <span>this month</span>
                        <span>Paid: &#8377;{{ number_format($data['payout_this_month'],0,'.',',') }}</span>
                    </div>
                </div>

                <div class="kpi">
                    <div class="kpi-head">
                        <div class="kpi-icon gold"><i class="bx bx-target-lock"></i></div>
                        <div class="kpi-label">Leads This Month</div>
                    </div>
                    <div class="kpi-value">{{ $data['lead_this_month'] }} <span class="target">/ {{ $data['total_leads'] }}</span></div>
                    <div class="kpi-meta">
                        <span>{{ $data['lead_this_week'] }} this week</span>
                        <span>Total {{ $data['total_leads'] }}</span>
                    </div>
                </div>

                <div class="kpi">
                    <div class="kpi-head">
                        <div class="kpi-icon success"><i class="bx bx-group"></i></div>
                        <div class="kpi-label">Active Partners</div>
                    </div>
                    <div class="kpi-value">{{ $data['active_partners'] }} <span class="target">/ {{ $data['total_partners'] }}</span></div>
                    @php $partnerPct = $data['total_partners'] > 0 ? round(($data['active_partners']/$data['total_partners'])*100) : 0; @endphp
                    <div class="kpi-bar"><div class="kpi-bar-fill success" style="width: {{ $partnerPct }}%"></div></div>
                    <div class="kpi-meta">
                        <span>{{ $partnerPct }}% active</span>
                        <span>+{{ $data['partner_this_month'] }} this month</span>
                    </div>
                </div>

                <div class="kpi">
                    <div class="kpi-head">
                        <div class="kpi-icon danger"><i class="bx bx-trending-up"></i></div>
                        <div class="kpi-label">Lead → Close</div>
                    </div>
                    <div class="kpi-value">{{ $data['conversion_rate'] }}%</div>
                    <div class="kpi-bar"><div class="kpi-bar-fill danger" style="width: {{ min($data['conversion_rate'],100) }}%"></div></div>
                    <div class="kpi-meta">
                        <span>{{ $data['closed_leads_month'] }} of {{ $data['lead_this_month'] }} closed</span>
                        <span>Total closed {{ $data['closed_leads_total'] }}</span>
                    </div>
                </div>

            </div>

            <div class="mid-grid">

                <div class="gl-card">
                    <div class="gl-card-head">
                        <div>
                            <div class="gl-card-title">Lead Status Snapshot</div>
                            <div class="gl-card-sub">Top 5 statuses across all leads</div>
                        </div>
                        <a class="gl-card-link" href="{{ route('admin.leads') }}">View leads &rarr;</a>
                    </div>
                    <div class="tier-rows">
                        @forelse($data['lead_status_snapshot'] as $row)
                            @php
                                $stat = strtoupper($row->lead_status);
                                $cls = 'tier-dot';
                                if ($stat == 'GOT BUSINESS') $cls = 'tier-dot success';
                                elseif ($stat == 'NEW') $cls = 'tier-dot';
                                elseif (str_starts_with($stat,'LOST')) $cls = 'tier-dot muted';
                                else $cls = 'tier-dot gold';
                            @endphp
                            <div class="tier-row">
                                <div class="{{ $cls }}"></div>
                                <div class="tier-info">
                                    <div class="name">{{ $row->lead_status }}</div>
                                    <div class="desc">{{ $stat == 'GOT BUSINESS' ? 'Closed deals' : 'Open pipeline' }}</div>
                                </div>
                                <div class="tier-count">{{ $row->cnt }}</div>
                            </div>
                        @empty
                            <div class="lb-empty">No lead data yet.</div>
                        @endforelse
                    </div>
                </div>

                <div class="gl-card">
                    <div class="gl-card-head">
                        <div>
                            <div class="gl-card-title">Top 5 Partners</div>
                            <div class="gl-card-sub">By closed-deal commission this month</div>
                        </div>
                        <a class="gl-card-link" href="{{ route('admin.channel-partners') }}">All partners &rarr;</a>
                    </div>
                    <div class="leaderboard">
                        @forelse($data['top_partners'] as $i => $partner)
                            <div class="lb-row rank-{{ $i + 1 }}">
                                <div class="lb-rank">{{ $i + 1 }}</div>
                                <div>
                                    <div class="lb-name">{{ $partner->name ?? '—' }}</div>
                                    <div class="lb-deals">{{ $partner->deals }} deal{{ $partner->deals == 1 ? '' : 's' }}{{ $partner->company_name ? ' · '.$partner->company_name : '' }}</div>
                                </div>
                                <div class="lb-gmv">&#8377;{{ number_format($partner->total_commission ?? 0, 0, '.', ',') }}</div>
                            </div>
                        @empty
                            <div class="lb-empty">No closed deals this month yet.</div>
                        @endforelse
                    </div>
                </div>

            </div>

            <div class="bottom-grid">

                <div class="gl-card">
                    <div class="gl-card-head">
                        <div>
                            <div class="gl-card-title">Latest Leads</div>
                            <div class="gl-card-sub">Last 10 submissions across all partners</div>
                        </div>
                        <a class="gl-card-link" href="{{ route('admin.leads') }}">View all &rarr;</a>
                    </div>
                    <div class="table-responsive">
                        <table id="latest-leads-table" class="leads-table" style="width:100% !important;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Lead</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Partner</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

                <div class="gl-card">
                    <div class="gl-card-head">
                        <div>
                            <div class="gl-card-title">Recent Activity</div>
                            <div class="gl-card-sub">Latest notifications</div>
                        </div>
                        <a class="gl-card-link" href="{{ route('admin.notifications') }}">All &rarr;</a>
                    </div>
                    <div class="notif-list">
                        @forelse($recent_noti as $row)
                            <div class="notif">
                                <div class="notif-icon"><i class="bx bx-bell"></i></div>
                                <div>
                                    <div class="notif-body">{{ $row->notification }}</div>
                                    <div class="notif-time">{{ \Carbon\Carbon::parse($row->created_at)->diffForHumans() }}</div>
                                </div>
                            </div>
                        @empty
                            <div class="notif-empty">No recent notifications.</div>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

@push('scripts')
<script type="text/javascript">
$(function() {
    $('#latest-leads-table').DataTable({
        processing: true,
        serverSide: true,
        paging: false,
        searching: false,
        bInfo: false,
        ordering: false,
        ajax: "{{ route('admin.get-latest-leads') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'mobile', name: 'mobile' },
            { data: 'partner', name: 'partner' },
            {
                data: 'lead_status',
                name: 'lead_status',
                render: function (val) {
                    if (!val) return '';
                    var v = String(val).toUpperCase();
                    var cls = 'lead-status';
                    if (v === 'GOT BUSINESS') cls += ' won';
                    else if (v === 'NEW') cls += ' qual';
                    else if (v.indexOf('DEMO') !== -1 || v.indexOf('PROPOSAL') !== -1) cls += ' demo';
                    else if (v.indexOf('LOST') !== -1) cls += ' cold';
                    return '<span class="' + cls + '">' + val + '</span>';
                }
            }
        ]
    });

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });
});
</script>
@endpush

@endsection
