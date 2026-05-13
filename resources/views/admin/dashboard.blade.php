@extends('admin.master')
@section('style')
<link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=Geist+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
.gl-dash {
    --bg: #F6F7F9;
    --surface: #FFFFFF;
    --surface-2: #FAFAFB;
    --border: #E7E9EE;
    --border-soft: #F0F2F5;
    --text: #0F172A;
    --text-soft: #475569;
    --text-muted: #94A3B8;
    --accent: #1E3A5F;
    --accent-2: #2C5282;
    --accent-soft: #EEF2F8;
    --success: #059669;
    --success-soft: #ECFDF5;
    --warning: #D97706;
    --warning-soft: #FEF3C7;
    --danger: #DC2626;
    --danger-soft: #FEE2E2;
    --gold: #B68B3C;
    --gold-soft: #FBF5E5;
    --brand-red: #E5384C;
    --shadow-xs: 0 1px 2px rgba(15, 23, 42, 0.04);
    --gl-radius: 8px;
    --gl-radius-lg: 12px;

    font-family: 'Geist', -apple-system, BlinkMacSystemFont, sans-serif;
    color: var(--text);
    font-size: 14px;
    line-height: 1.5;
    font-feature-settings: 'cv11', 'ss01';
}
.gl-dash .mono { font-family: 'Geist Mono', monospace; font-variant-numeric: tabular-nums; }

/* HERO TARGET ------------------------------------------------ */
.gl-dash .hero-target {
    background: linear-gradient(135deg, #0E1B2E 0%, #1E3A5F 60%, #2C5282 100%);
    border-radius: var(--gl-radius-lg);
    padding: 28px 32px;
    color: #fff;
    margin-bottom: 20px;
    position: relative;
    overflow: hidden;
}
.gl-dash .hero-target::before {
    content: ''; position: absolute;
    top: -40%; right: -10%;
    width: 360px; height: 360px;
    background: radial-gradient(circle, rgba(182, 139, 60, 0.18), transparent 65%);
    pointer-events: none;
}
.gl-dash .hero-grid {
    display: grid; grid-template-columns: 1.4fr 1fr; gap: 32px;
    align-items: center; position: relative;
}
.gl-dash .hero-target .eyebrow {
    font-size: 10px; font-weight: 600; text-transform: uppercase;
    letter-spacing: 0.16em; color: rgba(255,255,255,0.55); margin-bottom: 8px;
}
.gl-dash .hero-target h2 {
    font-size: 18px; font-weight: 500;
    color: rgba(255,255,255,0.9); margin: 0 0 16px 0;
}
.gl-dash .hero-target .target-value {
    font-size: 40px; font-weight: 700; letter-spacing: -0.025em;
    line-height: 1; margin-bottom: 4px;
    font-family: 'Geist Mono', monospace;
}
.gl-dash .hero-target .target-value .currency {
    font-size: 22px; color: rgba(255,255,255,0.6); margin-right: 4px;
}
.gl-dash .hero-target .target-meta {
    font-size: 13px; color: rgba(255,255,255,0.65); margin-bottom: 24px;
}
.gl-dash .hero-target .target-meta .of-target { color: var(--gold); font-weight: 500; }

.gl-dash .progress {
    height: 8px; background: rgba(255,255,255,0.08);
    border-radius: 99px; overflow: visible; position: relative;
}
.gl-dash .progress-fill {
    height: 100%; background: linear-gradient(90deg, #C9A961, #E0BE73);
    border-radius: 99px; transition: width 0.4s ease;
}
.gl-dash .progress-marker {
    position: absolute; top: -3px; bottom: -3px;
    width: 2px; background: rgba(255,255,255,0.4);
}
.gl-dash .progress-marker::after {
    content: attr(data-label);
    position: absolute; top: -18px; left: 50%; transform: translateX(-50%);
    font-size: 9px; color: rgba(255,255,255,0.55); white-space: nowrap;
    font-family: 'Geist Mono', monospace; letter-spacing: 0.05em;
}
.gl-dash .hero-status {
    display: flex; gap: 24px; margin-top: 16px;
    font-size: 12px; color: rgba(255,255,255,0.55); flex-wrap: wrap;
}
.gl-dash .hero-status strong {
    color: #fff; font-weight: 600; font-family: 'Geist Mono', monospace;
}
.gl-dash .hero-side { display: flex; flex-direction: column; gap: 14px; }
.gl-dash .hero-pace {
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: var(--gl-radius); padding: 16px 18px;
}
.gl-dash .hero-pace .pace-label {
    font-size: 10px; color: rgba(255,255,255,0.55);
    text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 6px;
    display: flex; align-items: center; gap: 6px;
}
.gl-dash .hero-pace .pace-dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: #F59E0B; box-shadow: 0 0 8px #F59E0B;
}
.gl-dash .hero-pace.behind .pace-dot {
    background: var(--brand-red); box-shadow: 0 0 8px var(--brand-red);
}
.gl-dash .hero-pace.ahead .pace-dot {
    background: var(--success); box-shadow: 0 0 8px var(--success);
}
.gl-dash .hero-pace .pace-value {
    font-size: 18px; font-weight: 600; color: #fff;
    font-family: 'Geist Mono', monospace;
}
.gl-dash .hero-pace .pace-desc {
    font-size: 12px; color: rgba(255,255,255,0.65);
    margin-top: 2px; line-height: 1.4;
}

/* KPI GRID -------------------------------------------------- */
.gl-dash .kpi-grid {
    display: grid; grid-template-columns: repeat(4, 1fr);
    gap: 14px; margin-bottom: 20px;
}
.gl-dash .kpi {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--gl-radius);
    padding: 18px 20px;
    box-shadow: var(--shadow-xs);
}
.gl-dash .kpi-head { display: flex; align-items: center; gap: 8px; margin-bottom: 14px; }
.gl-dash .kpi-icon {
    width: 28px; height: 28px; border-radius: 7px;
    display: grid; place-items: center;
    background: var(--accent-soft); color: var(--accent);
    flex-shrink: 0;
}
.gl-dash .kpi-icon i { font-size: 15px; }
.gl-dash .kpi-icon.warn { background: var(--warning-soft); color: var(--warning); }
.gl-dash .kpi-icon.success { background: var(--success-soft); color: var(--success); }
.gl-dash .kpi-icon.danger { background: var(--danger-soft); color: var(--danger); }
.gl-dash .kpi-label { font-size: 13px; color: var(--text-soft); font-weight: 500; }
.gl-dash .kpi-value {
    font-size: 24px; font-weight: 600; letter-spacing: -0.02em;
    color: var(--text); line-height: 1.1;
    font-family: 'Geist Mono', monospace;
}
.gl-dash .kpi-value .denom { font-size: 14px; color: var(--text-muted); font-weight: 500; margin-left: 2px; }
.gl-dash .kpi-foot {
    display: flex; align-items: center; gap: 6px;
    margin-top: 8px; font-size: 12px; color: var(--text-soft);
}
.gl-dash .kpi-bar {
    margin-top: 10px; height: 4px;
    background: var(--surface-2); border-radius: 99px; overflow: hidden;
}
.gl-dash .kpi-bar-fill {
    height: 100%; background: var(--success); border-radius: 99px;
}
.gl-dash .kpi-bar-fill.warn { background: var(--warning); }

/* ALERT ----------------------------------------------------- */
.gl-dash .alert-card {
    background: linear-gradient(180deg, #FFF8EC 0%, #FFFEFA 100%);
    border: 1px solid #F5D9A1;
    border-radius: var(--gl-radius);
    padding: 16px 20px;
    margin-bottom: 20px;
    display: flex; align-items: flex-start; gap: 14px;
}
.gl-dash .alert-card .alert-icon {
    width: 32px; height: 32px;
    background: var(--warning); border-radius: 8px;
    display: grid; place-items: center; color: #fff; flex-shrink: 0;
}
.gl-dash .alert-card .alert-icon i { font-size: 16px; }
.gl-dash .alert-card .alert-body { flex: 1; }
.gl-dash .alert-card .alert-title {
    font-size: 14px; font-weight: 600; color: #92400E; margin-bottom: 2px;
}
.gl-dash .alert-card .alert-desc {
    font-size: 13px; color: #78350F; line-height: 1.5;
}
.gl-dash .alert-card .alert-desc strong { font-weight: 600; }
.gl-dash .alert-card .btn-link {
    background: var(--surface); border: 1px solid var(--border);
    color: var(--text); padding: 6px 12px;
    border-radius: 6px; font-size: 12.5px; text-decoration: none;
    white-space: nowrap; flex-shrink: 0;
}
.gl-dash .alert-card .btn-link:hover { border-color: var(--accent); color: var(--accent); }

/* SECONDARY GRID (funnel + leaderboard) --------------------- */
.gl-dash .dash-grid-2 {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 14px; margin-bottom: 20px;
}
.gl-dash .gl-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--gl-radius);
    box-shadow: var(--shadow-xs);
    overflow: hidden;
}
.gl-dash .gl-card-header {
    padding: 14px 20px;
    border-bottom: 1px solid var(--border-soft);
    display: flex; align-items: center; justify-content: space-between;
}
.gl-dash .gl-card-header .title { font-size: 14px; font-weight: 600; color: var(--text); }
.gl-dash .gl-card-header .subtitle { font-size: 12px; color: var(--text-muted); margin-top: 2px; }
.gl-dash .gl-card-header a {
    font-size: 12px; color: var(--accent); text-decoration: none; font-weight: 500;
}
.gl-dash .gl-card-header a:hover { text-decoration: underline; }
.gl-dash .gl-card-body { padding: 16px 20px; }

/* Funnel */
.gl-dash .funnel { display: flex; flex-direction: column; gap: 10px; }
.gl-dash .funnel-row {
    display: grid; grid-template-columns: 130px 1fr 70px;
    align-items: center; gap: 14px; font-size: 13px;
}
.gl-dash .funnel-row .stage-name { color: var(--text); font-weight: 500; }
.gl-dash .funnel-row .stage-sub { color: var(--text-muted); font-size: 11px; margin-top: 1px; }
.gl-dash .funnel-bar {
    height: 22px; background: var(--accent-soft);
    border-radius: 4px; position: relative; overflow: hidden;
}
.gl-dash .funnel-bar-fill {
    height: 100%; background: var(--accent); border-radius: 4px;
    display: flex; align-items: center; padding-left: 8px;
    color: #fff; font-size: 11px; font-weight: 500;
    transition: width 0.4s; min-width: 24px;
}
.gl-dash .funnel-bar-fill.s-new { background: #475569; }
.gl-dash .funnel-bar-fill.s-contacted { background: #64748B; }
.gl-dash .funnel-bar-fill.s-interested { background: #D97706; }
.gl-dash .funnel-bar-fill.s-proposal { background: var(--warning); }
.gl-dash .funnel-bar-fill.s-won { background: var(--success); }
.gl-dash .funnel-count {
    text-align: right; font-family: 'Geist Mono', monospace;
    font-weight: 500; color: var(--text); font-size: 13px;
}

/* Top Partners */
.gl-dash .partner-rank { display: flex; flex-direction: column; }
.gl-dash .partner-row {
    display: grid; grid-template-columns: 24px 1fr auto auto;
    align-items: center; gap: 12px;
    padding: 10px 0; border-bottom: 1px solid var(--border-soft);
}
.gl-dash .partner-row:last-child { border-bottom: 0; }
.gl-dash .partner-row .rank {
    font-family: 'Geist Mono', monospace; font-size: 12px;
    color: var(--text-muted); text-align: center;
}
.gl-dash .partner-row .rank.r1 { color: var(--gold); font-weight: 600; }
.gl-dash .partner-row .name { font-size: 13.5px; font-weight: 500; color: var(--text); }
.gl-dash .partner-row .name-sub { font-size: 11.5px; color: var(--text-muted); margin-top: 1px; }
.gl-dash .partner-row .deals {
    font-size: 12px; color: var(--text-soft); font-family: 'Geist Mono', monospace;
}
.gl-dash .partner-row .gmv {
    font-family: 'Geist Mono', monospace; font-weight: 600;
    font-size: 13px; color: var(--text);
}
.gl-dash .empty-state {
    padding: 24px 16px; text-align: center;
    color: var(--text-muted); font-size: 12.5px;
}

/* BOTTOM GRID (latest leads + activity) --------------------- */
.gl-dash .bottom-grid {
    display: grid; grid-template-columns: 1.7fr 1fr; gap: 14px;
}
.gl-dash .leads-table { width: 100%; border-collapse: collapse; font-size: 13px; margin: 0; }
.gl-dash .leads-table th {
    text-align: left; padding: 10px 20px;
    background: var(--surface-2); color: var(--text-muted);
    font-weight: 500; font-size: 11px;
    text-transform: uppercase; letter-spacing: 0.06em;
    border-bottom: 1px solid var(--border);
}
.gl-dash .leads-table td {
    padding: 12px 20px; border-bottom: 1px solid var(--border-soft);
    color: var(--text-soft);
}
.gl-dash .leads-table tr:last-child td { border-bottom: 0; }
.gl-dash .leads-table td:first-child {
    color: var(--text-muted);
    font-family: 'Geist Mono', monospace;
    font-size: 11px; width: 32px;
}
.gl-dash .lead-status {
    display: inline-block; padding: 2px 8px;
    border-radius: 999px; font-size: 10px;
    text-transform: uppercase; letter-spacing: 0.06em;
    font-weight: 600; font-family: 'Geist Mono', monospace;
    background: var(--surface-2); color: var(--text-muted);
}
.gl-dash .lead-status.won { background: var(--success-soft); color: var(--success); }
.gl-dash .lead-status.qual { background: var(--accent-soft); color: var(--accent); }
.gl-dash .lead-status.demo { background: var(--warning-soft); color: var(--warning); }
.gl-dash .lead-status.cold { background: var(--danger-soft); color: var(--danger); }

.gl-dash .notif-list { padding: 8px 0; max-height: 460px; overflow-y: auto; }
.gl-dash .notif {
    padding: 12px 20px; display: flex; gap: 12px;
    border-bottom: 1px solid var(--border-soft);
}
.gl-dash .notif:last-child { border-bottom: 0; }
.gl-dash .notif-icon {
    width: 28px; height: 28px; border-radius: 6px;
    background: var(--accent-soft);
    display: grid; place-items: center; flex-shrink: 0;
}
.gl-dash .notif-icon i { color: var(--accent); font-size: 14px; }
.gl-dash .notif-body { font-size: 12.5px; color: var(--text-soft); line-height: 1.5; }
.gl-dash .notif-time {
    font-size: 10px; color: var(--text-muted);
    font-family: 'Geist Mono', monospace;
    margin-top: 4px; letter-spacing: 0.04em; text-transform: uppercase;
}
.gl-dash .notif-empty {
    padding: 18px 20px; color: var(--text-muted);
    font-size: 12px; text-align: center;
}

/* Responsive */
@media (max-width: 1100px) {
    .gl-dash .kpi-grid { grid-template-columns: 1fr 1fr; }
    .gl-dash .dash-grid-2 { grid-template-columns: 1fr; }
    .gl-dash .bottom-grid { grid-template-columns: 1fr; }
    .gl-dash .hero-grid { grid-template-columns: 1fr; }
}
@media (max-width: 768px) {
    .gl-dash .hero-target { padding: 22px 20px; }
    .gl-dash .kpi-grid { grid-template-columns: 1fr 1fr; gap: 10px; }
    .gl-dash .alert-card { flex-direction: column; }
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
                    <h4 class="mb-0">Welcome back, {{ Auth::guard('admin')->user()->name }}</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
                <div class="text-muted mb-3">
                    {{ $data['month_label'] }} · Day {{ $data['day_of_month'] }} of {{ $data['days_in_month'] }} · Partner-sourced GMV is the only metric that matters this quarter.
                </div>
            </div>
        </div>

        <div class="gl-dash">

            @php
                $paceClass = 'behind';
                $paceLabel = 'Behind pace';
                if ($data['target_pct'] >= $data['expected_pace_pct']) { $paceClass = 'ahead'; $paceLabel = 'On pace'; }
                elseif ($data['target_pct'] >= $data['expected_pace_pct'] - 5) { $paceClass = ''; $paceLabel = 'Near pace'; }
            @endphp

            {{-- HERO TARGET --}}
            <div class="hero-target">
                <div class="hero-grid">
                    <div>
                        <div class="eyebrow">Monthly Target · &#8377;{{ number_format($data['monthly_target'],0,'.',',') }} GMV</div>
                        <h2>
                            @if($paceClass === 'ahead')
                                You're tracking on or above pace for {{ Carbon\Carbon::now()->format('F') }}.
                            @else
                                You're tracking behind pace for {{ Carbon\Carbon::now()->format('F') }}.
                            @endif
                        </h2>
                        <div class="target-value"><span class="currency">&#8377;</span>{{ number_format($data['monthly_volume'],0,'.',',') }}</div>
                        <div class="target-meta">
                            <span class="of-target">{{ $data['target_pct'] }}%</span>
                            of &#8377;{{ number_format($data['monthly_target'],0,'.',',') }} target ·
                            {{ $data['closed_leads_month'] }} deals closed · {{ $data['days_remaining'] }} days remaining
                        </div>
                        <div class="progress" style="margin-top: 8px;">
                            <div class="progress-fill" style="width: {{ min($data['target_pct'],100) }}%;"></div>
                            <div class="progress-marker" style="left: {{ min($data['expected_pace_pct'],100) }}%;" data-label="EXPECTED PACE"></div>
                        </div>
                        <div class="hero-status">
                            <div>Daily pace needed · <strong>&#8377;{{ number_format($data['daily_pace_needed'],0,'.',',') }}</strong></div>
                            <div>Avg daily so far · <strong>&#8377;{{ number_format($data['avg_daily_so_far'],0,'.',',') }}</strong></div>
                            <div>Gap to close · <strong>&#8377;{{ number_format($data['gap_to_close'],0,'.',',') }}</strong></div>
                        </div>
                    </div>
                    <div class="hero-side">
                        <div class="hero-pace {{ $paceClass }}">
                            <div class="pace-label"><span class="pace-dot"></span>Status</div>
                            <div class="pace-value">{{ $paceLabel }}</div>
                            <div class="pace-desc">At current run-rate you'll hit &#8377;{{ number_format($data['projected_eom'],0,'.',',') }} by month-end — <strong>{{ $data['projected_eom_pct'] }}% of target</strong>.</div>
                        </div>
                        <div class="hero-pace">
                            <div class="pace-label"><span class="pace-dot"></span>Active partners</div>
                            <div class="pace-value">{{ $data['active_partners'] }} <span style="font-size:13px;color:rgba(255,255,255,0.5);">/ {{ $data['total_partners'] }}</span></div>
                            <div class="pace-desc">{{ $data['partner_this_month'] }} new this month · push Tier B activation to lift conversion.</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KPI ROW --}}
            <div class="kpi-grid">
                <div class="kpi">
                    <div class="kpi-head">
                        <div class="kpi-icon"><i class="bx bx-rupee"></i></div>
                        <div class="kpi-label">GMV This Month</div>
                    </div>
                    <div class="kpi-value">&#8377;{{ number_format($data['monthly_volume'],0,'.',',') }}</div>
                    <div class="kpi-foot">
                        <span>{{ $data['target_pct'] }}% of &#8377;{{ number_format($data['monthly_target']/100000,1) }}L target</span>
                    </div>
                </div>

                <div class="kpi">
                    <div class="kpi-head">
                        <div class="kpi-icon success"><i class="bx bx-trending-up"></i></div>
                        <div class="kpi-label">Lead → Close Rate</div>
                    </div>
                    <div class="kpi-value">{{ $data['conversion_rate'] }}%</div>
                    <div class="kpi-foot">
                        <span>{{ $data['closed_leads_total'] }} of {{ $data['total_leads'] }} leads closed all-time</span>
                    </div>
                </div>

                <div class="kpi">
                    <div class="kpi-head">
                        <div class="kpi-icon"><i class="bx bx-group"></i></div>
                        <div class="kpi-label">Active Partners</div>
                    </div>
                    @php $partnerPct = $data['total_partners'] > 0 ? round(($data['active_partners']/$data['total_partners'])*100) : 0; @endphp
                    <div class="kpi-value">{{ $data['active_partners'] }}<span class="denom">/{{ $data['total_partners'] }}</span></div>
                    <div class="kpi-bar"><div class="kpi-bar-fill" style="width: {{ $partnerPct }}%;"></div></div>
                    <div class="kpi-foot" style="margin-top: 6px;">
                        <span>{{ $partnerPct }}% active · +{{ $data['partner_this_month'] }} this month</span>
                    </div>
                </div>

                <div class="kpi">
                    <div class="kpi-head">
                        <div class="kpi-icon warn"><i class="bx bx-time-five"></i></div>
                        <div class="kpi-label">Stale Leads (&gt;7 days)</div>
                    </div>
                    <div class="kpi-value">{{ $data['stale_leads'] }}<span class="denom">/{{ $data['total_leads'] }}</span></div>
                    <div class="kpi-bar"><div class="kpi-bar-fill warn" style="width: {{ min($data['stale_pct'],100) }}%;"></div></div>
                    <div class="kpi-foot" style="margin-top: 6px;">
                        <span style="color: var(--warning); font-weight: 500;">{{ $data['stale_pct'] }}% of pipeline aging — needs action</span>
                    </div>
                </div>
            </div>

            {{-- ALERT --}}
            @php $newLeads = collect($data['funnel'])->firstWhere('status','New')['count'] ?? 0; @endphp
            @if($newLeads > 0)
            <div class="alert-card">
                <div class="alert-icon"><i class="bx bx-error"></i></div>
                <div class="alert-body">
                    <div class="alert-title">Pipeline backlog · {{ $newLeads }} leads sitting in "New" this month</div>
                    <div class="alert-desc">Assigning agents to the oldest leads could unlock pipeline value at this quarter's <strong>{{ $data['conversion_rate'] }}%</strong> close rate.</div>
                </div>
                <a href="{{ route('admin.leads') }}" class="btn-link">View leads &rarr;</a>
            </div>
            @endif

            {{-- FUNNEL + LEADERBOARD --}}
            <div class="dash-grid-2">

                <div class="gl-card">
                    <div class="gl-card-header">
                        <div>
                            <div class="title">Pipeline Funnel</div>
                            <div class="subtitle">This month · All partners</div>
                        </div>
                        <a href="{{ route('admin.leads') }}">View leads &rarr;</a>
                    </div>
                    <div class="gl-card-body">
                        <div class="funnel">
                            @php $first = ($data['funnel'][0]['count'] ?? 0); @endphp
                            @foreach($data['funnel'] as $i => $stage)
                                @php
                                    $pct = $first > 0 ? round(($stage['count']/$first)*100) : 0;
                                    $passPct = ($i > 0)
                                        ? ($data['funnel'][$i-1]['count'] > 0
                                            ? round(($stage['count']/$data['funnel'][$i-1]['count'])*100)
                                            : 0)
                                        : 100;
                                @endphp
                                <div class="funnel-row">
                                    <div>
                                        <div class="stage-name">{{ $stage['name'] }}</div>
                                        <div class="stage-sub">{{ $stage['sub'] }}</div>
                                    </div>
                                    <div class="funnel-bar">
                                        <div class="funnel-bar-fill {{ $stage['class'] }}" style="width: {{ $stage['width'] }}%;">
                                            @if($stage['count'] > 0) {{ $stage['count'] }} @endif
                                        </div>
                                    </div>
                                    <div class="funnel-count">
                                        {{ $stage['count'] }}<br>
                                        <span style="font-size:10px;color:var(--text-muted);font-weight:400;">{{ $passPct }}% pass</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="gl-card">
                    <div class="gl-card-header">
                        <div>
                            <div class="title">Top Partners · This Month</div>
                            <div class="subtitle">Ranked by closed-deal commission</div>
                        </div>
                        <a href="{{ route('admin.channel-partners') }}">All partners &rarr;</a>
                    </div>
                    <div class="gl-card-body">
                        <div class="partner-rank">
                            @forelse($data['top_partners'] as $i => $partner)
                                <div class="partner-row">
                                    <div class="rank {{ $i == 0 ? 'r1' : '' }}">{{ str_pad($i+1, 2, '0', STR_PAD_LEFT) }}</div>
                                    <div>
                                        <div class="name">{{ $partner->name ?? '—' }}</div>
                                        <div class="name-sub">{{ $partner->company_name ? $partner->company_name.' · ' : '' }}{{ $partner->deals }} deal{{ $partner->deals == 1 ? '' : 's' }}</div>
                                    </div>
                                    <div class="deals">&#8377;{{ number_format($partner->total_commission ?? 0, 0, '.', ',') }}</div>
                                    <div class="gmv"></div>
                                </div>
                            @empty
                                <div class="empty-state">No closed deals this month yet.</div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>

            {{-- BOTTOM GRID --}}
            <div class="bottom-grid">

                <div class="gl-card">
                    <div class="gl-card-header">
                        <div>
                            <div class="title">Latest Leads</div>
                            <div class="subtitle">Last 10 submissions across all partners</div>
                        </div>
                        <a href="{{ route('admin.leads') }}">View all &rarr;</a>
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
                    <div class="gl-card-header">
                        <div>
                            <div class="title">Recent Activity</div>
                            <div class="subtitle">Latest notifications</div>
                        </div>
                        <a href="{{ route('admin.notifications') }}">All &rarr;</a>
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
                    else if (v.indexOf('DEMO') !== -1 || v.indexOf('PROPOSAL') !== -1 || v.indexOf('INTERESTED') !== -1) cls += ' demo';
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
