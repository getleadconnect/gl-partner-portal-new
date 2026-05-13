@extends('admin.master')
@section('content')
<style>

.partner-active { color:green;}
.partner-inactive{ color:red;}
.form-select option{ color:black;}

.dataTables_wrapper .dataTables_filter {
    float: right;    text-align: right;   display: flex !important;
}

#err-msg {color:red;	font-size:12px; }
.filter-select{	width:110px;	height:34px;	margin:8px 0px 8px 8px;	border-color:#aaa !important;
}
.pr-detail{position:fixed;	left:83px;	top:20px;	width:93%;	height:93%;	border:2px solid #b9d5ca;
	background:#fff; z-index:9999999;	
}
.prd-body{width:100%;	height:513px;	overflow-y:scroll;	scrollbar-width:thin; }
.txt-center{
	text-align:center;
}

.dropdown:hover{ cursor:pointer;}
@media (min-width: 992px) {
    .modal-lg, .modal-xl {
        --bs-modal-width: 600px !important;
    }
}

/* ============ PARTNERS — PAGE HEADER ============ */
.gl-page-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 16px;
    padding: 8px 4px 20px;
    flex-wrap: wrap;
    font-family: 'Geist', -apple-system, BlinkMacSystemFont, sans-serif;
}
.gl-page-title {
    font-size: 24px;
    font-weight: 700;
    color: #0F172A;
    letter-spacing: -0.01em;
    margin: 0 0 4px 0;
    line-height: 1.2;
}
.gl-page-subtitle {
    font-size: 13px;
    color: #475569;
}
.gl-page-header__actions {
    display: inline-flex;
    align-items: center;
    gap: 10px;
}
.gl-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 14px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    line-height: 1.2;
    font-family: inherit;
    text-decoration: none;
    cursor: pointer;
    transition: background .15s ease, border-color .15s ease, color .15s ease, box-shadow .15s ease;
    border: 1px solid transparent;
    white-space: nowrap;
}
.gl-btn i { font-size: 15px; line-height: 1; }
.gl-btn-outline {
    background: #FFFFFF;
    border-color: #E7E9EE;
    color: #0F172A;
}
.gl-btn-outline:hover {
    border-color: #CBD5E1;
    color: #0F172A;
    background: #FAFAFB;
}
.gl-btn-primary {
    background: #1E3A5F;
    color: #fff;
    border-color: #1E3A5F;
    box-shadow: 0 1px 2px rgba(15,23,42,0.08);
}
.gl-btn-primary:hover {
    background: #15294A;
    border-color: #15294A;
    color: #fff;
}

/* ============ PARTNERS — TABLE TOOLBAR ============ */
.gl-partners-toolbar {
    padding: 12px 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
    border-bottom: 1px solid #F0F2F5;
    flex-wrap: wrap;
    background: #FAFAFB;
}
.gl-partners-toolbar .filter-group {
    display: flex; gap: 8px; align-items: center; flex-wrap: wrap;
}
.gl-partners-toolbar .filter-label {
    font-size: 11.5px;
    color: #94A3B8;
    font-weight: 500;
    margin-right: 4px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.gl-partners-toolbar .filter-pill {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 4px 12px;
    background: #FFFFFF;
    border: 1px solid #E7E9EE;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 500;
    color: #475569;
    cursor: pointer;
    font-family: inherit;
    transition: all 0.15s ease;
}
.gl-partners-toolbar .filter-pill:hover {
    background: #EEF2F8;
    border-color: #1E3A5F;
    color: #1E3A5F;
}
.gl-partners-toolbar .filter-pill.active {
    background: #1E3A5F;
    border-color: #1E3A5F;
    color: #fff;
}
.gl-partners-toolbar .filter-pill .mono {
    font-family: 'Geist Mono', monospace;
    font-size: 11px;
    opacity: 0.85;
}
.gl-partners-toolbar .filter-pill.active .mono { opacity: 1; }
.gl-partners-toolbar .filter-pill .tier-dot {
    width: 6px; height: 6px; border-radius: 50%;
}
.gl-partners-toolbar .filter-pill .tier-dot { background: #64748B; }
.gl-partners-toolbar .filter-pill .tier-dot.x { background: #DC2626; }
.gl-partners-toolbar .filter-pill .tier-dot.active { background: #059669; }
.gl-partners-toolbar .filter-pill.active .tier-dot { background: #fff !important; }

.gl-partners-toolbar .gl-divider {
    width: 1px; height: 20px; background: #E7E9EE; margin: 0 4px;
}
.gl-partners-toolbar .filter-select-gl {
    padding: 6px 10px;
    border: 1px solid #E7E9EE;
    border-radius: 6px;
    background: #FFFFFF;
    font-size: 12.5px;
    color: #0F172A;
    font-family: inherit;
    cursor: pointer;
    outline: none;
}
.gl-partners-toolbar .filter-select-gl:focus { border-color: #1E3A5F; }

.gl-partners-toolbar .table-stats {
    display: flex; gap: 10px;
    font-size: 12px;
    color: #475569;
    align-items: center;
}
.gl-partners-toolbar .table-stats strong {
    color: #0F172A;
    font-weight: 600;
    margin: 0 4px;
    font-family: 'Geist Mono', monospace;
}
.gl-partners-toolbar .table-stats .sep { color: #E7E9EE; }

/* ============ PARTNERS — REVISED TABLE ============ */
.gl-partners {
    --gl-bg: #F6F7F9;
    --gl-surface: #FFFFFF;
    --gl-surface-2: #FAFAFB;
    --gl-border: #E7E9EE;
    --gl-border-soft: #F0F2F5;
    --gl-text: #0F172A;
    --gl-text-soft: #475569;
    --gl-text-muted: #94A3B8;
    --gl-accent: #1E3A5F;
    --gl-gold: #B68B3C;
    font-family: 'Geist', -apple-system, BlinkMacSystemFont, sans-serif;
}

.gl-partners table.data {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}
.gl-partners table.data thead tr { background: var(--gl-surface-2); }
.gl-partners table.data thead th {
    padding: 10px 16px;
    text-align: left;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--gl-text-muted);
    font-weight: 600;
    border-bottom: 1px solid var(--gl-border-soft);
    white-space: nowrap;
}
.gl-partners table.data thead th.num { text-align: right; }
.gl-partners table.data tbody td {
    padding: 12px 16px;
    border-bottom: 1px solid var(--gl-border-soft);
    color: var(--gl-text-soft);
    vertical-align: middle;
    background: var(--gl-surface);
}
.gl-partners table.data tbody tr:hover td { background: #FAFBFC; }
.gl-partners table.data td.strong { color: var(--gl-text); font-weight: 500; }
.gl-partners table.data td.num {
    font-family: 'Geist Mono', monospace;
    text-align: right;
    font-variant-numeric: tabular-nums;
}

/* Partner avatar cell */
.gl-partners .row-avatar {
    display: inline-flex; align-items: center; gap: 10px;
}
.gl-partners .row-avatar .av {
    width: 32px; height: 32px;
    border-radius: 50%;
    display: grid; place-items: center;
    font-size: 11px;
    font-weight: 600;
    color: #fff;
    flex-shrink: 0;
    letter-spacing: 0.02em;
}
.gl-partners .row-avatar .av.c1 { background: #1E3A5F; }
.gl-partners .row-avatar .av.c2 { background: #059669; }
.gl-partners .row-avatar .av.c3 { background: #B68B3C; }
.gl-partners .row-avatar .av.c4 { background: #DC2626; }
.gl-partners .row-avatar .av.c5 { background: #475569; }
.gl-partners .row-avatar .av.c6 { background: #2C5282; }
.gl-partners .row-avatar .nm { line-height: 1.25; }
.gl-partners .row-avatar .nm .name {
    color: var(--gl-text);
    font-weight: 500;
    font-size: 13px;
}
.gl-partners .row-avatar .nm .name a {
    color: var(--gl-text);
    text-decoration: none;
}
.gl-partners .row-avatar .nm .name a:hover { color: var(--gl-accent); }
.gl-partners .row-avatar .nm .sub {
    color: var(--gl-text-muted);
    font-size: 12px;
    margin-top: 2px;
    font-family: 'Geist Mono', monospace;
}

/* Tier badge — colors come from partner_tiers.tier_color (inline style) */
.gl-partners .tier {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.02em;
    line-height: 1.6;
}
.gl-partners .tier .tier-prefix-dot {
    width: 5px; height: 5px;
    border-radius: 50%;
    display: inline-block;
}
.gl-partners .tier-none {
    display: inline-flex; align-items: center;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 500;
    color: var(--gl-text-muted);
    background: transparent;
    border: 1px dashed var(--gl-border);
}

/* Commission split */
.gl-partners .comm-split {
    display: flex; flex-direction: column;
    font-family: 'Geist Mono', monospace;
    font-size: 12px;
    line-height: 1.3;
}
.gl-partners .comm-split .set { color: var(--gl-text); font-weight: 500; }
.gl-partners .comm-split .paid { color: var(--gl-text-muted); font-size: 10.5px; margin-top: 2px; }

/* Agent chip — assigned */
.gl-partners .agent-chip {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 4px 10px 4px 4px;
    background: #F8FAFC;
    border: 1px solid var(--gl-border);
    border-radius: 999px;
    font-size: 12.5px;
    font-weight: 500;
    color: var(--gl-text);
    text-decoration: none;
    line-height: 1.4;
    transition: background .15s ease, border-color .15s ease, box-shadow .15s ease;
    max-width: 200px;
}
.gl-partners .agent-chip:hover {
    background: var(--gl-surface);
    border-color: var(--gl-accent);
    color: var(--gl-accent);
    box-shadow: 0 1px 3px rgba(15,23,42,0.06);
}
.gl-partners .agent-chip-avatar {
    width: 22px; height: 22px;
    border-radius: 50%;
    background: var(--gl-accent);
    color: #fff;
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.02em;
    display: inline-flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.gl-partners .agent-chip-name {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.gl-partners .agent-chip-edit {
    font-size: 13px;
    color: var(--gl-text-muted);
    opacity: 0;
    transition: opacity .15s ease;
}
.gl-partners .agent-chip:hover .agent-chip-edit {
    opacity: 1;
    color: var(--gl-accent);
}

/* Agent chip — unassigned (Assign button) */
.gl-partners .btn-assign-agent {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 4px 12px;
    background: transparent;
    border: 1px dashed var(--gl-border);
    border-radius: 999px;
    font-size: 12px;
    font-weight: 500;
    color: var(--gl-text-muted);
    cursor: pointer;
    font-family: inherit;
    transition: background .15s ease, border-color .15s ease, color .15s ease;
}
.gl-partners .btn-assign-agent i { font-size: 14px; line-height: 1; }
.gl-partners .btn-assign-agent:hover {
    background: #EEF2F8;
    border-color: var(--gl-accent);
    border-style: solid;
    color: var(--gl-accent);
}
.gl-partners .btn-assign-agent:active {
    background: var(--gl-accent);
    color: #fff;
    border-color: var(--gl-accent);
}

/* Clickable status pill */
.gl-partners .status-pill {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 3px 10px;
    border-radius: 999px;
    font-size: 11.5px;
    font-weight: 600;
    letter-spacing: 0.02em;
    cursor: pointer;
    user-select: none;
    transition: background .15s ease, color .15s ease, box-shadow .15s ease;
    border: 1px solid transparent;
    line-height: 1.5;
}
.gl-partners .status-pill::before {
    content: '';
    width: 6px; height: 6px;
    border-radius: 50%;
    background: currentColor;
}
.gl-partners .status-pill.on  { background: #ECFDF5; color: #059669; }
.gl-partners .status-pill.off { background: #FEE2E2; color: #DC2626; }
.gl-partners .status-pill:hover {
    box-shadow: 0 0 0 3px rgba(15,23,42,0.04);
    border-color: rgba(15,23,42,0.06);
}
.gl-partners .status-pill.is-loading {
    pointer-events: none;
    opacity: 0.6;
}
.gl-partners table.data td .dropdown-toggle { color: var(--gl-text-muted); }
</style>

 <div class="page-content">
	<div class="container-fluid">
            <div class="gl-page-header">
                <div class="gl-page-header__text">
                    <h1 class="gl-page-title">Partners</h1>
                    <div class="gl-page-subtitle">
                        {{ $tier_counts['all'] ?? 0 }} total · {{ $tier_counts['active'] ?? 0 }} active · Filter, segment, and act on the network.
                    </div>
                </div>
                <div class="gl-page-header__actions">
                    <a href="javascript:void(0);" id="export_to_excel" class="gl-btn gl-btn-outline">
                        <i class="bx bx-download"></i> Export CSV
                    </a>
                    <button id="btnOffcanvas" type="button" class="gl-btn gl-btn-primary" data-bs-toggle="modal" data-bs-target="#add-partner-modal">
                        <i class="bx bx-plus"></i> Add Partner
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-body">

						<div class="table-responsive gl-partners">
							<div class="gl-partners-toolbar">
								<div class="filter-group">
									<span class="filter-label">Tier</span>
									<button type="button" class="filter-pill active" data-tier="">All <span class="mono">{{ $tier_counts['all'] ?? 0 }}</span></button>
									@foreach($ptiers as $t)
										<button type="button" class="filter-pill" data-tier="{{ $t->id }}">
											<span class="tier-dot" @if($t->tier_color) style="background: {{ $t->tier_color }};" @endif></span>
											{{ $t->partner_tier }}
											<span class="mono">{{ $tier_counts['by_tier'][$t->id] ?? 0 }}</span>
										</button>
									@endforeach
									<button type="button" class="filter-pill" data-tier="active"><span class="tier-dot active"></span>Active <span class="mono">{{ $tier_counts['active'] ?? 0 }}</span></button>
									<button type="button" class="filter-pill" data-tier="inactive"><span class="tier-dot x"></span>Inactive <span class="mono">{{ $tier_counts['inactive'] ?? 0 }}</span></button>
									

									<span class="gl-divider"></span>

									<select id="agent_filter" class="filter-select-gl">
										<option value="">All agents</option>
										@foreach($agents as $key => $value)
											<option value="{{ $key }}">{{ $value }}</option>
										@endforeach
									</select>

									<select id="activity_filter" class="filter-select-gl">
										<option value="">Last activity: Any</option>
										<option value="7d">Last 7 days</option>
										<option value="30d">Last 30 days</option>
										<option value="stale30">No activity 30+ days</option>
									</select>
								</div>
								<div class="table-stats">
									<div class="stat">Showing <strong id="showing_count">0</strong></div>
									<div class="sep">·</div>
									<div class="stat">of <strong id="total_count">{{ $tier_counts['all'] ?? 0 }}</strong></div>
								</div>
							</div>

                                <table id="partner-table" class="data" style="width:100% !important;">
                                    <thead>

									<tr>
										<th>Partner</th>
										<th>Tier</th>
										<th class="num">Leads · Month</th>
										<th class="num">GMV · Lifetime</th>
										<th>Commission</th>
										<th>Agent</th>
										<th>Last Activity</th>
										<th>Status</th>
										<th>Actions</th>
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
            
        </div> <!-- container-fluid -->
		
    </div> <!-- End Page-content -->



<div class="modal fade" id="add-partner-modal" tabindex="-1" aria-labelledby="addPartnerModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg " >
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addPartnerModalLabel">Add Partner</h5>
				<button type="button" class="button-close btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">


	  <div class="loading-outer" style="display:none;">
		  <span class="spinner-loading">
		  <label style="font-size:48px;color:red;"> <i class="fa fa-spinner fa-spin"></i> </label>
		  <h6 style="color:red;"> Please Wait.......</h6>
		  </span>
	  </div>

				
		<form id="addPartner" enctype="multipart/form-data">
		  @csrf
		  
		  
			<input type="hidden" class="form-control" name="country_name" id="country_name" >
					  
		  
			<div class="form-group">
				<div class="row">
				<div class="col-lg-6 col-xl-6 col-xxl-6">
					<label for="partner_name" class="form-label">Name<span class="required">*</span></label>
					<input type="text" class="form-control" name="name" id="name" required>
				</div>
				<div class="col-lg-6 col-xl-6 col-xxl-6">
					<label for="mobile" class="form-label">Mobile<span class="required">*</span></label>
					<input type="hidden" class="form-control" name="country_code" id="country_code" value="91"  required>
					<br>
					<input type="tel" class="form-control" name="mobile" id="mobile" minlength=6 maxlength=15 required>

				</div>
				</div>
			</div>

			   <div class="form-group">
				<div class="row">
				<div class="col-lg-6 col-xl-6 col-xxl-6">
					<label for="email" class="form-label">Email<span class="required">*</span></label>
					<input type="email" class="form-control" name="email" id="email" required>
				</div>

				<div class="col-lg-6 col-xl-6 col-xxl-6">
					<label for="email" class="form-label">Partner Tier<span class="required">*</span></label>
					<select class="form-control" name="partner_tier" id="partner_tier" required  style="color:#000 !important;">
					<option value="" selected disabled>select</option>
					@foreach($ptiers as $row)
					<option value="{{$row->id}}">{{$row->partner_tier}}</option>
					@endforeach
					</select>
				</div>
			  </div>
			</div>

				<div class="form-group">
				<div class="row">
				
				<div class="col-lg-3 col-xl-3 col-xxl-3">
					<label for="pin_code" class="form-label">Commission.(%)<span class="required">*</span></label>
					<input type="number" class="form-control" name="comm_percentage" id="comm_percentage" required>
				</div>

				<div class="col-lg-3 col-xl-3 col-xxl-3">
					<label for="pin_code" class="form-label">Renewal Com(%)<span class="required">*</span></label>
					<input type="number" class="form-control" name="renewal_comm_percentage" id="reanewal_comm_percentage" required>
				</div>
				
				<div class="col-lg-6 col-xl-6 col-xxl-6">
					<label for="password" class="form-label"><b>Password<span class="required">*</span></b></label>
					<input type="text" class="form-control" name="password" id="password" required>
				</div>
				</div>
				</div>

			   <div class="form-group">
					<label for="company_name" class="form-label">Company Name<span class="required">*</span></label>
				<input type="text" class="form-control" name="company_name" id="company_name" required>
				</div>
				
			   <div class="form-group">
					<label for="website" class="form-label">Website</label>
					<input type="text" class="form-control" name="website" id="website">
				</div>
				
				<div class="form-group">
					<div class="row">
					<div class="col-lg-6 col-xl-6 col-xxl-6">
					<label for="country" class="form-label">Country<span class="required">*</span></label>
					<select class="form-control" name="country" id="country" required  style="color:#000 !important;">
					<option value="" selected disabled>select</option>
					@foreach($countries as $key=>$value)
					<option value="{{$key}}">{{$value}}</option>
					@endforeach
					</select>
				</div>
								
				<div class="col-lg-6 col-xl-6 col-xxl-6">
					<label for="state" class="form-label">State<span class="required">*</span></label>
					<select class="form-control" name="state" id="state" style="color:#000 !important;" required>
					<option value="" selected disabled>select</option>
					
					</select>
				</div>
				</div>
				</div>


				
				<div class="form-group">
				<div class="row">
				<div class="col-lg-6 col-xl-6 col-xxl-6">
					<label for="city" class="form-label">City<span class="required">*</span></label>
					<input type="text" class="form-control" name="city" id="city" required>
				</div>
				<div class="col-lg-6 col-xl-6 col-xxl-6">
					<label for="pin_code" class="form-label">Pin Code<span class="required">*</span></label>
					<input type="number" class="form-control" name="pin_code" minlength=6 maxlength=6 id="pin_code" required>
				</div>
				</div>
				</div>

				
				<div class="form-group">
				<div class="row">
				<div class="col-lg-6 col-xl-6 col-xxl-6">
					<label for="bank_name" class="form-label">Bank Name</label>
					<input type="text" class="form-control" name="bank_name" id="bank_name">
				</div>
				<div class="col-lg-6 col-xl-6 col-xxl-6">
					<label for="ifsc_code" class="form-label">IFSC Code</label>
					<input type="text" class="form-control" name="ifsc_code" id="ifsc_code">
				</div>
				</div>
				</div>
				
				<div class="form-group">
				<div class="row">
				<div class="col-lg-6 col-xl-6 col-xxl-6">
					<label for="branch" class="form-label">Branch</label>
					<input type="text" class="form-control" name="branch" id="branch">
				</div>
				<div class="col-lg-6 col-xl-6 col-xxl-6">
					<label for="account_number" class="form-label">Account Number</label>
					<input type="text" class="form-control" name="account_number" id="account_number">
				</div>
				</div>
				</div>
			
			<div class="form-group">
			<div class="row">
			<div class="col-lg-6 col-xl-6 col-xxl-6">
				<label for="upi_id" class="form-label">UPI ID</label>
				<input type="text" class="form-control" name="upi_id" id="upi_id">
			</div>

			<div class="col-lg-6 col-xl-6 col-xxl-6">
				<label for="partner_status" class="form-label">Status</label>
				<select class="form-select" name="partner_status" id="partner_status">
					<option value="1">Active</option>
					<option value="0">Inactive</option>
				</select>
			</div>
			</div>
			</div>
			<div class="form-group mt-3 mb-3" style="text-align:right;">
			<button type="button" class="button-close btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
			<button type="submit" id="partner_submit"  class="btn btn-primary">Submit</button>
			</div>
		</form>

			</div>
		</div>
	</div>
</div>
    

	<!-- edit Partner Modal -->

   <div class="modal fade" id="edit-partner-modal" tabindex="-1" aria-labelledby="addPartnerModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="addPartnerModalLabel">Edit Partner</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
				
				</div>
			</div>
		</div>	
	</div>			
	


	<div class="modal fade" id="assign-agent-modal" tabindex="-1" aria-labelledby="addPartnerModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="addPartnerModalLabel">Assign/Re-assign Agent</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>

				<div class="modal-body">
					<form id="assign-agent-form">
					@csrf
					<input type="hidden" name="agent_partner_id" id="agent_partner_id">
					
					<div class="form-group">
						<label for="country" class="form-label">Agent Name<span class="required">*</span></label>
						
						<select class="form-control" name="assign_agent_id" id="assign_agent_id" required>
						<option value="" selected>select</option>
						@foreach($agents as $key=>$value)
						<option value="{{$key}}">{{$value}}</option>
						@endforeach
						</select>
						<label id="err-msg"></label>
					</div>
					
					<div class="modal-footer" style="text-align:right;margin-right:30px;">
					<button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
					<button type="button" class="btn btn-primary" id="btnAssignAgent">Submit</button>
					</div>
					</form>
				</div>
				
			</div>
		</div>	
	</div>					
		
		
	<div class="pr-detail hide">
		<div class="card">
			<div class="card-header" style="background:#b9d5ca;">
				<div class="d-flex justify-content-between align-items-center">
					<h5 class="card-title mb-0">PARTNER DETAILS</h5>
					<div>
						<button class="btn btn-outline " id="btnDetailClose"><i class="fa fa-times fs-4" aria-hidden="true"></i></button>
					</div>
				</div>
			</div>
			<div class="card-body prd-body" style="height:820px;">

				  <div class="loading-outer">
					  <span class="spinner-loading">
					  <label style="font-size:48px;color:red;"> <i class="fa fa-spinner fa-spin"></i> </label>
					  <h6 style="color:red;"> Please Wait.......</h6>
					  </span>
				  </div>

			</div>
		</div>
	</div>
	
	
	<div class="modal fade" id="set-commission-modal" tabindex="-1" aria-labelledby="addPartnerModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="addPartnerModalLabel">Set Commission(%)</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>

				<div class="modal-body">
					<form id="formSetCommission">
					@csrf
					<input type="hidden" name="partner_id" id="partner_id">
					
					<div class="form-group">
						<label for="country" class="form-label">Commission(%)<span class="required">*</span></label>
						<input type="number" class="form-control" name="commission" id="commission" min=0 required>
						<!--<label id="err-msg"></label>-->
					</div>
					<div class="form-group">
						<label for="country" class="form-label">Renewal Commission(%)<span class="required">*</span></label>
						<input type="number" class="form-control" name="renewal_commission" id="renewal_commission" min=0 required>
						<!--<label id="err-msg"></label>-->
					</div>
					
					<label  style="width:100%;text-align:center;color:red;font-size:12px;" id="sc-err-msg"></label>

					<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
					<button type="submit" class="btn btn-primary" id="btnSetCommission" >Submit</button>
					</div>
					</form>
				</div>
				
			</div>
		</div>	
	</div>	

	
@push('scripts')

<script type="text/javascript">

    $(function () {
    toastr.options = {
        // "positionClass": "toast-top-right cp",
        "showDuration": "300000",
        "hideMethod": "fadeOut"
        }
    });

/*$("#country").select2({
	    dropdownParent: $('#offcanvasRight')
});*/


</script>

<script>

var phone_number = window.intlTelInput(document.querySelector("#mobile"), {
	  separateDialCode: true,
	  preferredCountries:["in"],
	  hiddenInput: "full_number",
	  utilsScript:"{{url('assets/intl-tel-input17.0.3/utils.js')}}"
	});


$("#btnDetailClose").click(function()
{
	$(".pr-detail").removeClass('show');
	$(".pr-detail").fadeOut(500);
});


 $(function () {
        var table = $('#partner-table').DataTable({
            processing: true,
            serverSide: true,
			pageLength:50,
			/*dom: 'lBfrtip',
			buttons: [
			'csv', 'excel'
			],*/
			
			"language": {
				searchPlaceholder: 'Search',
				sSearch: '',
			},
			"lengthMenu": [10, 25, 50,100,150,200],
			
			ajax:
			{
				url:"{{ route('admin.get-partners') }}",
				data: function (data)
				{
					data.tier            = $('.gl-partners-toolbar .filter-pill.active').data('tier') || '';
					data.agent_id_filter = $('#agent_filter').val() || '';
					data.activity_filter = $('#activity_filter').val() || '';
				},
			},

			drawCallback: function() {
				var info = this.api().page.info();
				$('#showing_count').text(info.recordsDisplay || 0);
				$('#total_count').text(info.recordsTotal || 0);
			},
			
            columns: [
            {data: 'partner', name: 'partner'},
            {data: 'tier', name: 'tier', orderable:false, searchable:false},
            {data: 'leads_month', name: 'leads_month', className:'num strong', orderable:false, searchable:false},
            {data: 'gmv_lifetime', name: 'gmv_lifetime', className:'num strong', orderable:false, searchable:false},
            {data: 'commission_split', name: 'commission_split', orderable:false, searchable:false},
            {data: 'agent_name', name: 'agent_name'},
            {data: 'lead_activity_at', name: 'lead_activity_at', orderable:false},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', className:'text-center'},
            ]
        });
        

$('.gl-partners-toolbar').on('click','.filter-pill',function(){
    $('.gl-partners-toolbar .filter-pill').removeClass('active');
    $(this).addClass('active');
    table.draw();
});

$('#agent_filter, #activity_filter').on('change', function(){
    table.draw();
});

//VIEW PARTNER DETAILS --------------------------------------------------------

$("#partner-table tbody").on('click','.view-partner-details',function()
{
	$(".pr-detail").removeClass('hide');
	$(".pr-detail").fadeIn(300).addClass('show');
	
	var id=$(this).attr('id');
	
	$.ajax({
		url: "{{ url('admin/partner-details')}}"+"/"+id,
		type: 'get',
		//data: 
		success: function(res)
		{
			$(".prd-body").html(res);
		}
	});

});
//--------------------------------------------------------------------------


// adding record --------------------------------------------				
				
var addValidator=$('#addPartner').validate({ 
	
	rules: {
		pin_code: {
			required: true,
			minlength:6,
			maxlength:6,
		},
		mobile: {
			required: true,
			minlength:6,
			maxlength:15,
		},
	},

	submitHandler: function(form) 
	{
		$("#partner_submit").attr('disabled',true).html('Saving <i class="fa fa-spinner fa-spin"></i>')
		
		var code=phone_number.getSelectedCountryData()['dialCode'];
		$("#country_code").val(code);
		
		$(".loading-outer").css('display','block');
		
		$.ajax({
		url: "{{ route('admin.create-partner') }}",
		method: 'post',
		data: $('#addPartner').serialize(),
		success: function(result){
			if(result.status == 1)
			{
				//$("form#lead-form :input").each(function(){
				  //      $(this).val('')
					//});
				$("#partner_submit").attr('disabled',false).html('Submit')
				table.ajax.reload();
				toastr.success(result.msg);
				$('#addPartner')[0].reset();
				$("#state").html('<option value="" selected>select</option>');
				$(".loading-outer").css('display','none');
			}
			else
			{
				$("#partner_submit").attr('disabled',false).html('Submit');
				toastr.error(result.msg);
				$(".loading-outer").css('display','none');
			}
		}
		});
	  }
	});

$(".button-close").click(function()
{
	$(".loading-outer").css('display','none');
});

	$("#btnOffcanvas").click(function()
	{
		$('#addPartner')[0].reset();
		$("#state").html('<option value="" selected>select</option>');
		addValidator.resetForm();
	});

	
$("#partner-table tbody").on('click','.status-pill',function()
{
    var $pill   = $(this);
    if ($pill.hasClass('is-loading')) return;

    var pid     = $pill.data('id');
    var current = parseInt($pill.data('current'), 10);
    var newVal  = current === 1 ? 0 : 1;
    var goingOn = newVal === 1;
    var verb    = goingOn ? 'activate' : 'deactivate';

    Swal.fire({
        title: 'Are you sure?',
        text:  'You are about to ' + verb + ' this partner.',
        icon:  'warning',
        showCancelButton:  true,
        confirmButtonText: 'Yes, ' + verb,
        cancelButtonText:  'Cancel',
        confirmButtonColor: '#1E3A5F',
        cancelButtonColor:  '#94A3B8',
        reverseButtons:     true,
    }).then(function(result) {
        if (!result.isConfirmed) return;

        $pill.addClass('is-loading');

        $.ajax({
            type: "POST",
            url:  "{{route('admin.change-partner-status')}}",
            dataType: 'json',
            data: {_token:"{{csrf_token()}}", partner_id: pid, partner_status: newVal},
            success: function(res) {
                $pill.removeClass('is-loading');
                if (res.status === true) {
                    $pill.removeClass('on off').addClass(goingOn ? 'on' : 'off');
                    $pill.text(goingOn ? 'Active' : 'Inactive');
                    $pill.attr('title', 'Click to ' + (goingOn ? 'deactivate' : 'activate'));
                    $pill.data('current', newVal).data('next', newVal === 1 ? 0 : 1);
                    toastr.success(res.msg);
                } else {
                    toastr.error(res.msg);
                }
            },
            error: function() {
                $pill.removeClass('is-loading');
                toastr.error('Could not update status, please try again.');
            }
        });
    });
});

		$("#partner-table tbody").on('click','.confirm_deletion',function()
        {
			if(confirm("Are you sure, delete this partner details?"))
			{
               $.ajax({
                    url: "{{ route('admin.delete-partner') }}",
                    method: 'post',
                    data: {'_token': '{{ csrf_token() }}','partner_id':$(this).attr('id')},
                    success: function(result)
                    {
                        if(result.status)
                        {
                            toastr.success("Partner successfully removed!");
                            table.ajax.reload();
                        }
                        
                    }
                });
			}
        })

				
	$("#partner-table tbody").on( 'click', '.edit-partner', function ()
		  {
			var id=$(this).attr('id');
			var Result=$("#edit-partner-modal .modal-body");
			
					jQuery.ajax({
					type: "GET",
					url: "{{url('admin/edit-partner')}}"+"/"+id,
					dataType: 'html',
					//data: {vid: vid},
					success: function(res)
					{
					   Result.html(res);
					}
				});
		  });
	
		$("#partner-table tbody").on( 'click', '.set-commission', function ()
		  {
			var id=$(this).attr('id');
			var comm_per=$(this).data('commission');
			var re_comm_per=$(this).data('renewal');
			$("#partner_id").val(id);
			$("#commission").val(comm_per);
			$("#renewal_commission").val(re_comm_per);
			$("#sc-err-msg").html('');
		  });


		$("#formSetCommission").submit(function(e)
        {
		   e.preventDefault();
		
		var formData=new FormData(document.getElementById('formSetCommission'));
			
		   $.ajax({
				url: "{{ route('admin.set-partner-commission-percentage') }}",
				method: 'post',
				data: formData,
				dataType:'json',
				success: function(result)
				{
					if(result.status)
					{
						toastr.success(result.msg);
						$("#set-commission-modal").modal('hide');
						table.ajax.reload();
					}
					else
					{
						//toastr.error(result.msg);
						$("#sc-err-msg").html(result.msg);
						$("#set-commission-modal").modal('show');
					}
				},
				cache: false,
				contentType: false,
				processData: false
			});
	  });
	  
		
	 $("#country").on('change',function()
        {

            country = $(this).val()
			$("#country_name").val($('#country option:selected').text());
			
            $.ajax({
                    url: "{{ route('country-states') }}",
                    method: 'get',
                    data: {'country':country},
                    success: function(result)
                    {
                        if(result.states)
                        {
                            $("#state").empty();
							$('#state').append('<option value="" selected disabled> select </option>');
                            $.each(result.states, function(key, value) {
                                $('#state').append('<option value="'+ value +'">'+ value +'</option>');
                            });
                        }
                    }
                });
        })
		
		$("#state").on('change',function()
        {
			$("#state_name").val($('#state option:selected').text());
        })
		
//ASSIGN AGENT TO PARTNER ----------------------------------------------------
		
        $("#partner-table tbody").on('click','.assign_agent',function()
		{
            var aid=$(this).data('id');
			
			$("#agent_partner_id").val($(this).attr('id'));
			 $("#assign_agent_id").val(aid); 
			$("#err-msg").html('');
        })


        $(document).on('click','#btnAssignAgent',function()
        {
			var agid=$("#assign_agent_id").val();

			if(agid!="")
			{
			   $.ajax({
					url: "{{ route('admin.assign-agent') }}",
					type: 'post',
					dataType:'json',
					//data: {'_token': '{{ csrf_token() }}','agent_id':agid,'partner_id' : prid},
					data:$("#assign-agent-form").serialize(),
					success: function(result){
						$("#assign-agent-modal").modal('hide')
						toastr.success("Agent assigned successfully !!!");
						table.ajax.reload();
					}
				});
			}
			else
			{
				$("#err-msg").html("Invalid agent.!");
			}
        })
 //-----------------------------------------------------------------------------------   


        $("#invite_partner").on('click',function()
        {
            $("#invite_modal").modal('show')
        })

        $("#send_invitation").on('click',function(e)
        {
            if($("#email_id").val().length == 0)
            {
                $("#email_label").addClass('hidden')
                $("#inputError").removeClass('hidden')
                $("#email_id").css({'border-color':'#a94442'})
            }
            else
            {
                $("#email_label").removeClass('hidden')
                $("#inputError").addClass('hidden')
                $("#email_id").css({'border-color':'#EBEBEB'})
                
                $(this).html('Sending&nbsp;&nbsp;<img src="http://www.bba-reman.com/images/fbloader.gif" />');
                e.preventDefault
                $.ajax({
                    url: "{{ route('agent.invite-partner') }}",
                    method: 'post',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'email_id':$("#email_id").val()
                    },
                    success: function(result){
                        $("#invite_modal").modal('hide')
                        $("#send_invitation").html("Invite now")
                        toastr.success(result.msg);
                    }
                });
            }
        });

        $('#copy').on('click', function(event) {
            $.ajax({
                url: "{{ route('agent.get-invite-link') }}",
                method: 'post',
                data: {
                    '_token': '{{ csrf_token() }}',
                },
                success: function(result)
                {
                    console.log(result)
                    if(result.status == 1)
                    {
                         $("#link").val(result.link)
                    }
                    copyToClipboard(event);
                }
            });
        });
    });


$("#export_to_excel").click(function()
{
    var params = {
        tier:     $('.gl-partners-toolbar .filter-pill.active').data('tier') || '',
        agent_id: $('#agent_filter').val() || '',
        activity: $('#activity_filter').val() || '',
        status:   ''
    };
    var lnk = "{{ route('admin.export-partner-list') }}" + "?" + $.param(params);
    $("#export_to_excel").attr('href', lnk);
});



</script>

@endpush
@endsection