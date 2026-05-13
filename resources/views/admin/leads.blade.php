@extends('admin.master')
@section('content')
<style>
.error
{
	color:red !important;
	font-size:12px !important;
}

.form-select option{ color:black;}
.form-select { width:170px !important;}
.t-amt{ font-size:14px;font-weight:600;}
.pd-view p{ margin-bottom:.3rem;}
.txt-center{ text-align:center; }

/* ============ LEADS — PAGE HEADER ============ */
.gl-page-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 16px;
    padding: 8px 4px 20px;
    flex-wrap: wrap;
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
    transition: background .15s ease, border-color .15s ease, color .15s ease, box-shadow .15s ease;
    border: 1px solid transparent; white-space: nowrap;
}
.gl-btn i { font-size: 15px; line-height: 1; }
.gl-btn-outline { background: #FFFFFF; border-color: #E7E9EE; color: #0F172A; }
.gl-btn-outline:hover { border-color: #CBD5E1; background: #FAFAFB; color: #0F172A; }
.gl-btn-primary { background: #1E3A5F; color: #fff; border-color: #1E3A5F; box-shadow: 0 1px 2px rgba(15,23,42,0.08); }
.gl-btn-primary:hover { background: #15294A; border-color: #15294A; color: #fff; }

/* ============ LEADS — KPI CARDS ============ */
.gl-kpi-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    margin-bottom: 20px;
    font-family: 'Geist', -apple-system, BlinkMacSystemFont, sans-serif;
}
.gl-kpi {
    background: #FFFFFF;
    border: 1px solid #E7E9EE;
    border-radius: 8px;
    padding: 16px 18px;
    box-shadow: 0 1px 2px rgba(15,23,42,0.04);
}
.gl-kpi-head {
    display: flex; align-items: center; gap: 8px;
    margin-bottom: 10px;
}
.gl-kpi-icon {
    width: 28px; height: 28px;
    border-radius: 7px;
    display: grid; place-items: center;
    background: #EEF2F8;
    color: #1E3A5F;
}
.gl-kpi-icon i { font-size: 15px; line-height: 1; }
.gl-kpi-icon.warn    { background: #FEF3C7; color: #D97706; }
.gl-kpi-icon.success { background: #ECFDF5; color: #059669; }
.gl-kpi-icon.danger  { background: #FEE2E2; color: #DC2626; }
.gl-kpi-label {
    font-size: 12px;
    color: #475569;
    font-weight: 500;
}
.gl-kpi-value {
    font-size: 24px;
    font-weight: 600;
    letter-spacing: -0.02em;
    color: #0F172A;
    line-height: 1.1;
    font-family: 'Geist Mono', monospace;
    font-variant-numeric: tabular-nums;
}
.gl-kpi-foot {
    margin-top: 8px;
    font-size: 12px;
    color: #475569;
}
.gl-kpi-foot.warn { color: #D97706; font-weight: 500; }

@media (max-width: 1100px) {
    .gl-kpi-grid { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 540px) {
    .gl-kpi-grid { grid-template-columns: 1fr; }
}

/* ============ LEADS — TABLE TOOLBAR ============ */
.gl-leads-toolbar {
    padding: 12px 16px;
    display: flex; align-items: center; justify-content: space-between;
    gap: 14px; border-bottom: 1px solid #F0F2F5;
    flex-wrap: wrap; background: #FAFAFB;
}
.gl-leads-toolbar .filter-group { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
.gl-leads-toolbar .filter-label { font-size: 11.5px; color: #94A3B8; font-weight: 500; margin-right: 4px; text-transform: uppercase; letter-spacing: 0.04em; }
.gl-leads-toolbar .filter-pill {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 4px 12px; background: #FFFFFF; border: 1px solid #E7E9EE; border-radius: 999px;
    font-size: 12px; font-weight: 500; color: #475569; cursor: pointer; font-family: inherit;
    transition: all 0.15s ease;
}
.gl-leads-toolbar .filter-pill:hover { background: #EEF2F8; border-color: #1E3A5F; color: #1E3A5F; }
.gl-leads-toolbar .filter-pill.active { background: #1E3A5F; border-color: #1E3A5F; color: #fff; }
.gl-leads-toolbar .filter-pill .mono { font-family: 'Geist Mono', monospace; font-size: 11px; opacity: 0.85; }
.gl-leads-toolbar .gl-divider { width: 1px; height: 20px; background: #E7E9EE; margin: 0 4px; }
.gl-leads-toolbar .filter-select-gl {
    padding: 6px 10px; border: 1px solid #E7E9EE; border-radius: 6px; background: #FFFFFF;
    font-size: 12.5px; color: #0F172A; font-family: inherit; cursor: pointer; outline: none;
}
.gl-leads-toolbar .filter-select-gl:focus { border-color: #1E3A5F; }
.gl-leads-toolbar .table-stats { display: flex; gap: 10px; font-size: 12px; color: #475569; align-items: center; }
.gl-leads-toolbar .table-stats strong { color: #0F172A; font-weight: 600; margin: 0 4px; font-family: 'Geist Mono', monospace; }
.gl-leads-toolbar .table-stats .sep { color: #E7E9EE; }

/* ============ LEADS — TABLE ============ */
.gl-leads {
    --gl-surface: #FFFFFF;
    --gl-surface-2: #FAFAFB;
    --gl-border: #E7E9EE;
    --gl-border-soft: #F0F2F5;
    --gl-text: #0F172A;
    --gl-text-soft: #475569;
    --gl-text-muted: #94A3B8;
    font-family: 'Geist', -apple-system, BlinkMacSystemFont, sans-serif;
}
.gl-leads table.data { width: 100%; border-collapse: collapse; font-size: 13px; }
.gl-leads table.data thead tr { background: var(--gl-surface-2); }
.gl-leads table.data thead th {
    padding: 10px 16px; text-align: left;
    font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em;
    color: var(--gl-text-muted); font-weight: 600;
    border-bottom: 1px solid var(--gl-border-soft); white-space: nowrap;
}
.gl-leads table.data thead th.num { text-align: right; }
.gl-leads table.data tbody td {
    padding: 12px 16px; border-bottom: 1px solid var(--gl-border-soft);
    color: var(--gl-text-soft); vertical-align: middle; background: var(--gl-surface);
}
.gl-leads table.data tbody tr:hover td { background: #FAFBFC; }
.gl-leads table.data td.num { font-family: 'Geist Mono', monospace; text-align: right; font-variant-numeric: tabular-nums; }
.gl-leads table.data td .num.strong { color: var(--gl-text); font-weight: 600; font-family: 'Geist Mono', monospace; }
.gl-leads table.data td .num.muted { color: var(--gl-text-muted); font-family: 'Geist Mono', monospace; }

/* Lead avatar cell */
.gl-leads .row-avatar { display: inline-flex; align-items: center; gap: 10px; }
.gl-leads .row-avatar .av {
    width: 32px; height: 32px; border-radius: 50%;
    display: grid; place-items: center; font-size: 11px; font-weight: 600;
    color: #fff; flex-shrink: 0; letter-spacing: 0.02em;
}
.gl-leads .row-avatar .av.c1 { background: #1E3A5F; }
.gl-leads .row-avatar .av.c2 { background: #059669; }
.gl-leads .row-avatar .av.c3 { background: #B68B3C; }
.gl-leads .row-avatar .av.c4 { background: #DC2626; }
.gl-leads .row-avatar .av.c5 { background: #475569; }
.gl-leads .row-avatar .av.c6 { background: #2C5282; }
.gl-leads .row-avatar .nm { line-height: 1.25; }
.gl-leads .row-avatar .nm .name { color: var(--gl-text); font-weight: 500; font-size: 13px; }
.gl-leads .row-avatar .nm .sub { color: var(--gl-text-muted); font-size: 12px; margin-top: 2px; font-family: 'Geist Mono', monospace; }

/* Payment + Status pills */
.gl-leads .pill {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 9px; border-radius: 4px;
    font-size: 11.5px; font-weight: 500;
}
.gl-leads .pill::before { content:''; width:5px; height:5px; border-radius:50%; }
.gl-leads .pill.paid     { background: #ECFDF5; color: #059669; }
.gl-leads .pill.paid::before { background: #059669; }
.gl-leads .pill.unpaid   { background: #FEE2E2; color: #DC2626; }
.gl-leads .pill.unpaid::before { background: #DC2626; }
.gl-leads .pill.pending  { background: #FEF3C7; color: #B45309; }
.gl-leads .pill.pending::before { background: #D97706; }

/* Days in stage */
.gl-leads .days {
    display: inline-flex; align-items: center; gap: 5px;
    font-family: 'Geist Mono', monospace; font-size: 12px; color: var(--gl-text-soft);
}
.gl-leads .days.fresh { color: var(--gl-text-muted); }
.gl-leads .days.stale { color: #D97706; font-weight: 500; }
.gl-leads .days.cold  { color: #DC2626; font-weight: 600; }
.gl-leads .days .dot { width: 5px; height: 5px; border-radius: 50%; background: currentColor; }

/* Row action buttons */
.gl-leads .row-action {
    display: inline-flex; gap: 6px;
}
.gl-leads .row-action-btn {
    width: 32px; height: 32px;
    border: 1px solid var(--gl-border);
    background: var(--gl-surface);
    border-radius: 50%;
    display: inline-flex; align-items: center; justify-content: center;
    color: var(--gl-text-soft);
    cursor: pointer;
    padding: 0;
    transition: background .15s ease, border-color .15s ease, color .15s ease, box-shadow .15s ease;
}
.gl-leads .row-action-btn i { font-size: 15px; line-height: 1; }
.gl-leads .row-action-btn:hover {
    background: #EEF2F8;
    border-color: #1E3A5F;
    color: #1E3A5F;
}
.gl-leads .row-action-btn.accent {
    color: #B68B3C;
}
.gl-leads .row-action-btn.accent:hover {
    background: #FBF5E5;
    border-color: #B68B3C;
    color: #B68B3C;
}
.gl-leads .row-action-btn.danger:hover {
    background: #FEE2E2;
    border-color: #DC2626;
    color: #DC2626;
}
/* Text-mode action button (e.g. "Re-Com") — auto width, horizontal padding, pill shape */
.gl-leads .row-action-btn.text
 {
    width: 71px;
    min-width: 0;
    height: 32px;
    padding: 0px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.02em;
}
</style>

 <div class="page-content">
        <div class="container-fluid">

            <div class="gl-page-header">
                <div class="gl-page-header__text">
                    <h1 class="gl-page-title">Leads</h1>
                    <div class="gl-page-subtitle">
                        {{ $total_leads_count }} total · {{ $stale_leads_count }} stale · Move leads through the pipeline.
                    </div>
                </div>
                <div class="gl-page-header__actions">
                    <a href="javascript:void(0);" id="export_to_excel" class="gl-btn gl-btn-outline">
                        <i class="bx bx-download"></i> Export CSV
                    </a>
                    <button id="btnOffcanvas" type="button" class="gl-btn gl-btn-primary" data-bs-toggle="modal" data-bs-target="#add-lead-modal">
                        <i class="bx bx-plus"></i> Add Lead
                    </button>
                </div>
            </div>

            {{-- KPI cards --}}
            @php
                $shortInr = function ($val) {
                    $val = (int) $val;
                    if ($val >= 10000000) return '&#8377;'.round($val/10000000, 1).'Cr';
                    if ($val >= 100000)   return '&#8377;'.round($val/100000, 1).'L';
                    if ($val >= 1000)     return '&#8377;'.round($val/1000, 1).'K';
                    return '&#8377;'.number_format($val, 0, '.', ',');
                };
            @endphp
            <div class="gl-kpi-grid">
                <div class="gl-kpi">
                    <div class="gl-kpi-head">
                        <div class="gl-kpi-icon"><i class="bx bx-search"></i></div>
                        <div class="gl-kpi-label">Total Leads</div>
                    </div>
                    <div class="gl-kpi-value">{{ $total_leads_count }}</div>
                    <div class="gl-kpi-foot">+{{ $leads_this_week }} this week</div>
                </div>
                <div class="gl-kpi">
                    <div class="gl-kpi-head">
                        <div class="gl-kpi-icon warn"><i class="bx bx-time-five"></i></div>
                        <div class="gl-kpi-label">Stale (&gt;7d in stage)</div>
                    </div>
                    <div class="gl-kpi-value">{{ $stale_leads_count }}</div>
                    <div class="gl-kpi-foot warn">&rarr; Filter below to act</div>
                </div>
                <div class="gl-kpi">
                    <div class="gl-kpi-head">
                        <div class="gl-kpi-icon success"><i class="bx bx-check"></i></div>
                        <div class="gl-kpi-label">Closed-won</div>
                    </div>
                    <div class="gl-kpi-value">{{ $closed_won_count }}</div>
                    <div class="gl-kpi-foot">{{ $close_rate }}% close rate</div>
                </div>
                <div class="gl-kpi">
                    <div class="gl-kpi-head">
                        <div class="gl-kpi-icon"><i class="bx bx-rupee"></i></div>
                        <div class="gl-kpi-label">Pipeline Value</div>
                    </div>
                    <div class="gl-kpi-value">{!! $shortInr($pipeline_value) !!}</div>
                    <div class="gl-kpi-foot">Open + Proposal stages</div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body" style="padding:0;">
                            <div class="table-responsive gl-leads">
                                <div class="gl-leads-toolbar">
                                    <div class="filter-group">
                                        <span class="filter-label">Status</span>
                                        <button type="button" class="filter-pill active" data-status="">All <span class="mono">{{ $total_leads_count }}</span></button>
                                        @foreach($lead_status_counts as $statusName => $cnt)
                                            <button type="button" class="filter-pill" data-status="{{ $statusName }}">{{ $statusName }} <span class="mono">{{ $cnt }}</span></button>
                                        @endforeach

                                        <span class="gl-divider"></span>

                                        <select id="partner_filter" class="filter-select-gl">
                                            <option value="">All partners</option>
                                            @foreach($partners as $key=>$value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>

                                        <select id="filter_status" class="filter-select-gl">
                                            <option value="">Status: Any</option>
                                            @foreach($lead_status as $value)
                                                <option value="{{ $value->lead_status }}">{{ $value->lead_status }}</option>
                                            @endforeach
                                        </select>

                                        <select id="filter_payment_status" class="filter-select-gl">
                                            <option value="">Payment: Any</option>
                                            <option value="0">Not Paid</option>
                                            <option value="1">Paid</option>
                                            <option value="2">Pending</option>
                                        </select>

                                        <select id="filter_age" class="filter-select-gl">
                                            <option value="">Age: Any</option>
                                            <option value="stale">Stale (&gt;7 days)</option>
                                            <option value="cold">Cold (&gt;14 days)</option>
                                        </select>
                                    </div>
                                    <div class="table-stats">
                                        <div class="stat">Showing <strong id="showing_count">0</strong></div>
                                        <div class="sep">·</div>
                                        <div class="stat">of <strong id="total_count">{{ $total_leads_count }}</strong></div>
                                    </div>
                                </div>

                                <table id="leads-table" class="data" style="width:100% !important;">
                                    <thead>
                                        <tr id="tab-row">
                                            <th>Lead</th>
                                            <th>Partner</th>
                                            <th>Days in Stage</th>
                                            <th class="num">Deal Value</th>
                                            <th>Lead Status</th>
                                            <th>Payment</th>
                                            <th>Actions</th>
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

		   <div class="modal fade" id="edit-lead-modal" tabindex="-1" aria-labelledby="addPartnerModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addPartnerModalLabel">Edit Lead</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
						
						</div>
					</div>
				</div>	
			</div>					
		
	<div class="modal fade" id="add-lead-modal" tabindex="-1" aria-labelledby="addLeadModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg modal-dialog-scrollable">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="addLeadModalLabel">Add Lead</h5>
			<button type="button" class="button-close btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		  </div>
		  <div class="modal-body">

	  <div class="loading-outer" style="display:none;">
		  <span class="spinner-loading">
		  <label style="font-size:48px;color:red;"> <i class="fa fa-spinner fa-spin"></i> </label>
		  <h6 style="color:red;"> Please Wait.......</h6>
		  </span>
	  </div>

		<form id="lead-form">
		  @csrf
		  
		  <input type="hidden" class="form-control" name="country_name" id="country_name" >
					 
			<div class="form-group">
				<div class="row">
					<div class="col-md-6 col-xl-6 col-xxl-6">
					<label for="recipient-name" class="form-label">Customer Name<span style="color: red;">*</span></label>
                    <input type="text" class="form-control" placeholder=""
					 name="name" id="name" required>
				</div>
				<div class="col-md-6 col-xl-6 col-xxl-6">
				<label for="recipient-name" class="form-label">Mobile Number<span style="color: red;">*</span></label>
					<br>
                        <input type="number" class="form-control" placeholder="" name="mobile" id="mobile" minlength=6 maxlength=15  required>
						<input type="hidden" class="form-control" placeholder="" name="country_code" id="country_code" value="91" required>
					</div>
					</div>
				</div>

			    <div class="form-group">
					<label for="recipient-name" class="form-label">Company Name(Your firm)<span style="color: red;">*</span></label>
                        <input type="text" class="form-control" placeholder=""
                         name="company_name" id="company_name">
				</div>
				
				<div class="form-group">
					<div class="row">
					<div class="col-md-6 col-xl-6 col-xxl-6">
					 <label for="recipient-name" class="form-label">Email<span style="color: red;">*</span></label>
                    <input type="email" class="form-control" placeholder="" name="email" id="email">
					</div>
									
				<div class="col-md-6 col-xl-6 col-xxl-6">
					<label for="recipient-name" class="form-label">Designation </label>
                        <input type="text" class="form-control" placeholder=""
                             name="designation" id="designation" >
				</div>
				</div>
				</div>
			
	
			<div class="form-group">
				<div class="row">
				<div class="col-md-6 col-xl-6 col-xxl-6">	
					<label for="recipient-name" class="form-label">Select Partner<span style="color: red;">*</span></label>
					<select id="partner_id" name="partner_id" class="form-control" style="color:#000 !important;" required>
                      <option value="0" selected disabled>select</option>
					 @foreach($all_partners as $key=>$value)                     
						<option value="{{$key}}" >{{$value}}</option>
					 @endforeach
                   </select>
			</div>
			<div class="col-md-6 col-xl-6 col-xxl-6">
					<label for="recipient-name" class="form-control-label">Business Category<span style="color: red;">*</span></label>
					   <select id="bussiness_category_id" name="bussiness_category_id" class="form-control" style="color:#000 !important;" required>
						  <option value="0" selected disabled>select</option>
						  @foreach($bussiness_categories as $key=>$value)
						  <option value="{{$key}}" >{{$value}}</option>
						  @endforeach
						  
					   </select>
				</div>
			</div>
			</div>
			
			<!--<div class="form-group">
				<label for="recipient-name" class="form-label">Lead Type<span style="color: red;">*</span></label>
                   <select id="plan_type" name="plan_type" class="form-control" required>
                      <option value="0" selected disabled>select</option>
                      <option value="1" >Product</option>
                      <option value="2">Service</option>
                   </select>
			</div> -->
			
			<!--<div class="form-group">
				<label for="recipient-name" class="form-label">Lead Purpose<span style="color: red;">*</span></label>
                <select id="plan" name="plan" class="form-control" name="plan" required>
				<option value="" selected disabled>select</option>
                </select>
			</div> -->
			
			<div class="form-group">
				<div class="row">
				<div class="col-md-6 col-xl-6 col-xxl-6">
				<label for="partnerPhone" class="form-label">Country</label>
				<select class="form-control" name="country" id="country" style="color:#000;">
				<option value="" selected disabled>select</option>
				@foreach($countries as $key=>$value)
				<option value="{{$key}}">{{$value}}</option>
				@endforeach
				</select>
			</div>

			<div class="col-md-6 col-xl-6 col-xxl-6">
				<label for="recipient-name" class="form-label">State</label>
				<select name="state" id="state" class="form-control" style="color:#000;">
				<option value="" selected disabled>select</option>
				</select>
			</div>
			</div>
			</div>

			<div class="form-group">
				<div class="row">
				<div class="col-lg-7 col-xl-7 col-xxl-6">
					<label for="recipient-name" class="form-label">Area/Location</label>
						<input type="text" class="form-control" placeholder=""  name="area" id="area" >
				</div>
				
				<div class="col-lg-5 col-xl-5 col-xxl-5">
					<label for="recipient-name" class="form-label">Pincode</label>
					<input type="number" class="form-control" placeholder=""
					name="pincode" id="pincode" minlength=6 maxlength=6>
				</div>
				</div>
			</div>
			
		<div class="form-group">
		<div class="row">
			<div class="col-lg-6 col-xl-6 col-xxl-6">
				<label for="recipient-name" class="form-label">Address</label>
				<textarea class="form-control" name="address" id="address" placeholder="">{{ old('address') }}</textarea>
			</div>
			<div class="col-lg-6 col-xl-6 col-xxl-6">
				<label for="recipient-name" class="form-label">Remarks</label>
				<textarea class="form-control" name="remarks" id="remarks" placeholder="">{{ old('remarks') }}</textarea>
			</div>
		</div>
		</div>
			
		<div class="form-group mt-3 mb-3" style="text-align:right;">
			<button type="button" class="button-close btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
			<button type="submit" id="lead_submit"  class="btn btn-primary">Submit</button>
		</div>

	</form>

		  </div>
		</div>
	  </div>
	</div>

	
 <div class="modal fade" id="set-commission-modal" tabindex="-1" aria-labelledby="addPartnerModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addPartnerModalLabel">Set Collected Amount</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
			
			<input type="hidden" name="temp_comm_percentage" id="temp_comm_percentage">
			
			<form id="setLeadCommission">
			@csrf
			<input type="hidden" class="form-control" name="set_comm_lead_id" id="set_comm_lead_id">
			<input type="hidden" class="form-control" name="set_comm_lead_status" id="set_comm_lead_status">
			<input type="hidden" class="form-control" name="renewal_status" id="renewal_status">
						
			<!--<div class="form-group ">
				<input type="checkbox"  name="cbox_renewal" id="cbox_renewal" style="width:20px;height:20px;font-size:16px;vertical-align:middle;">&nbsp;&nbsp;Renewal Amount
			</div>-->
						
			<div class="form-group mt-2 d-flex">
				<label for="recipient-name" id="lbl_commission" class="form-label">Commission (%)</label>
				<input type="text" class="form-control ml-2" name="set_comm_percentage" id="set_comm_percentage" style="width:70px;height:34px;" readonly>
			</div>
			
		
			<div class="form-group">
			
			<div class="row">
			<div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
				<label for="recipient-name" class="form-label">Collected Amount</label>
				<input type="number" class="form-control"  name="set_collected_amount" id="set_collected_amount" aria-describedby="button-addon2">
				<label class="error" id="err-msg" style="display:none;"></label>
			</div>
			<div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
			<div class="form-group">
				<label for="recipient-name" class="form-label">Commission</label>
				<input type="number" class="form-control" name="set_commission" id="set_commission" >
			</div>
			</div>
			</div>
			</div>
			
			<div class="form-group">
				<label for="recipient-name" class="form-label">Description</label>
				<textarea rows=3 class="form-control" name="description" id="description" required></textarea>
			</div>
									
			<div class="form-group mt-3 mb-3" style="text-align:right;">
				<button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
				<button type="submit"  class="btn btn-primary">Submit</button>
			</div>
			</form>
			
			</div>
		</div>
	</div>	
</div>	


<!-- End Page-content -->

@push('scripts')

<script type="text/javascript">

var phone_number = window.intlTelInput(document.querySelector("#mobile"), {
	  separateDialCode: true,
	  preferredCountries:["in"],
	  hiddenInput: "full_number",
	  utilsScript:"{{url('assets/intl-tel-input17.0.3/utils.js')}}"
	});


    $(function () {
    toastr.options = {
        // "positionClass": "toast-top-right cp",
        "showDuration": "300000",
        "hideMethod": "fadeOut"
        }
    });
	
	$("#btnLeadCommSubmit").prop('disabled',true);
	
</script>

<script type="text/javascript">
    $(function () {
		
		//---------datatable -------------------------------------
		
		
        var table = $('#leads-table').DataTable({
            processing: true,
            serverSide: true,
			stateStatus: true,
			scrollX: true,
			"language": { searchPlaceholder: 'Search', sSearch: '' },
			"lengthMenu": [10, 25, 50, 100, 150, 200],

            ajax: {
                url: "{{ route('admin.list-leads') }}",
                data: function (d) {
                    var pillStatus = $('.gl-leads-toolbar .filter-pill.active').data('status') || '';
                    d.status      = pillStatus || $('#filter_status').val() || '';
                    d.partner_id  = $('#partner_filter').val();
                    d.pay_status  = $('#filter_payment_status').val();
                    d.age_filter  = $('#filter_age').val();
                }
            },

            columnDefs:[
                {width:"130px", targets:[6]},
            ],

            columns: [
                {data: 'lead',          name: 'lead',          orderable: false, searchable: false},
                {data: 'partner',       name: 'partner'},
                {data: 'days_in_stage', name: 'days_in_stage', orderable: false, searchable: false},
                {data: 'deal_value',    name: 'deal_value',    orderable: false, searchable: false, className: 'num'},
                {data: 'status',        name: 'status',        orderable: false},
                {data: 'pay_status',    name: 'pay_status',    orderable: false},
                {data: 'action',        name: 'action',        orderable: false, searchable: false},
            ],

            drawCallback: function () {
                var info = this.api().page.info();
                $('#showing_count').text(info.recordsDisplay || 0);
                $('#total_count').text(info.recordsTotal || 0);
            }
        });

//---------------------------------------------------------------

$('.gl-leads-toolbar').on('click','.filter-pill', function(){
    $('.gl-leads-toolbar .filter-pill').removeClass('active');
    $(this).addClass('active');
    // sync the redundant Status dropdown so both stay aligned
    $('#filter_status').val($(this).data('status') || '');
    table.draw();
});

$('#filter_status, #partner_filter, #filter_payment_status, #filter_age').on('change', function(){
    // dropdown Status takes precedence — clear the pill highlight
    if (this.id === 'filter_status') {
        $('.gl-leads-toolbar .filter-pill').removeClass('active');
        var v = $(this).val();
        $('.gl-leads-toolbar .filter-pill[data-status="'+v+'"]').addClass('active');
        if (v === '') $('.gl-leads-toolbar .filter-pill[data-status=""]').addClass('active');
    }
    table.draw();
});

var addLeadValidator=$('#lead-form').validate({ 
                rules: {
                    name: {
                        required: true
                    },
                    company_name: {
                        required: true
                    },
                    partner_id: {
                        required: true
                    },
                    mobile: {
                        required: true,
						minlength:6,
                        maxlength:15,
                    },
					pincode: {
                        minlength:6,
                        maxlength:6,
                    },
                },
                submitHandler: function(form) 
                {
                    $("#lead_submit").attr('disabled',true).html('Saving <i class="fa fa-spinner fa-spin"></i>')
					
					$(".loading-outer").css('display','block');

					var code=phone_number.getSelectedCountryData()['dialCode'];
					$("#country_code").val(code);
					
					formData=new FormData(document.getElementById('lead-form'));
					
                    $.ajax({
						url: "{{ route('admin.create-lead') }}",
						type: 'post',
						dataType:'json',
						data: formData ,  //$("#lead-form").serialize(),
						success: function(result)
                        {
                            if(result.status == 1)
                            {
                                table.ajax.reload();    
                                toastr.success(result.msg);
								$("#lead-form")[0].reset();
                                $("#lead_submit").attr('disabled',false).html('Submit')
								$("#state").html('<option value="" selected>select</option>');
								$(".loading-outer").css('display','none');
                            }
                            else{
								toastr.error(result.msg);
								$("#lead_submit").attr('disabled',false).html('Submit')
								$(".loading-outer").css('display','none');
							}
                        },
						cache: false,
						contentType: false,
						processData: false
						
                    });
                  }
            });

$(".button-close").click(function()
{
	$(".loading-outer").css('display','none');
});

	$("#btnOffcanvas").click(function()
	{
		$('#lead-form')[0].reset();
		$("#state").html('<option value="" selected>select</option>');
		addLeadValidator.resetForm();
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
                            $('#state').empty();
							$('#state').append('<option value="" selected disabled> select </option>');
                            $.each(result.states, function(key, value) {
                                $('#state').append('<option value="'+ value +'">'+ value +'</option>');
                            });
                        }
                    }
                });
        })


        $("#plan_type").on('change',function()
        {
            plan_type = $(this).val()
            $.ajax({
                    url: "{{ route('get-plans') }}",
                    method: 'get',
                    data: {'plan_type':plan_type},
                    success: function(result)
                    {
                        $('#plan').empty();
						$('#plan').append("<option value='' selected>select</option>");
                        $('#plan').append(result.data);
                    }
                });
        })
		
		
		$("#leads-table tbody").on( 'click', '.edit_lead', function ()
		  {
			var id=$(this).attr('id');
			var Result=$("#edit-lead-modal .modal-body");
			
					jQuery.ajax({
					type: "GET",
					url: "{{url('admin/edit-lead')}}"+"/"+id,
					dataType: 'html',
					//data: {vid: vid},
					success: function(res)
					{
					   Result.html(res);
					}
				});
		  });
		  
		// set commission -------------------------------------------------------
		
		var lstat='';
		$(document).on('click','#lead_status',function()
        {
            lstat=$(this).val();
		});
		
		
		$(document).on('change','#cbox_renewal',function()
		{
			if($(this).is(':checked'))
			{
				$("#set_comm_percentage").val(5);
				$("#renewal_status").val('Renewal');
			}				
			else
			{
				$("#set_comm_percentage").val($("#temp_comm_percentage").val());
				$("#renewal_status").val('');
			}
			
		});

		
		$(document).on('change','#lead_status',function()
        {

		    lead_id = $(this).data('leadid');
			var lstatus=$(this).val();
			var com_per=$(this).data('commission');
			
			if(com_per==0 && lstatus=="Got Business")
			{
				alert("Please set partner commission.!");
				$(this).val(lstat);
			}
			else
			{
				if(lstatus=="Got Business")
				{
					
					$("#setLeadCommission")[0].reset();
					var id=$(this).attr('id');

					$("#set_comm_lead_id").val(lead_id);
					$("#set_comm_lead_status").val(lstatus);
					$("#set_comm_percentage").val(com_per);
					$("#temp_comm_percentage").val(com_per);
					$("#lbl_commission").html("Commisssion(%)")
					$("#set-commission-modal").modal('show');
				}
				else
				{
					$.ajax({
						url: "{{ route('admin.update-lead-status') }}",
						type: 'get',
						dataType:'json',
						data: {'lead_id':lead_id,'lead_status':$(this).val()},
						success: function(result)
						{
							if(result.status)
							{
								toastr.success(result.msg);
								table.ajax.reload();
							}
							
						}
					});
				}
			}
        });
		

		
		$(document).on('keyup','#set_collected_amount',function()
        {
            var camt=$("#set_collected_amount").val();
			var com_per=$("#set_comm_percentage").val();
			if(camt!="")
			{
				comm=(parseInt(camt)*parseInt(com_per))/100;
				$("#set_commission").val(Math.round(comm,2));
				$("#err-msg").html("").css('display','none');
				$("#btnLeadCommSubmit").prop('disabled',false);
			}
			else
			{
				$("#err-msg").html("Invalid Amount!").css('display','block');
			}
        });
		

		$(document).on('click','.renewal_commission',function()
        {

			
		    lead_id = $(this).data('leadid');
			var lstatus=$(this).data('lstatus');
			var com_per=$(this).data('recommission');
		
			if(com_per==0 && lstatus=="Got Business")
			{
				alert("Please set partner commission.!");
			}
			else if(lstatus=="Got Business")
			{
					$("#lbl_commission").html("Renewal Commisssion(%)")
					$("#setLeadCommission")[0].reset();

					$("#set_comm_lead_id").val(lead_id);
					$("#set_comm_lead_status").val(lstatus);
					$("#set_comm_percentage").val(com_per);
					$("#temp_comm_percentage").val(com_per);
					$("#renewal_status").val("Renewal");
					
					$("#set-commission-modal").modal('show');
			}
        });

		
		var sValidator=$('#setLeadCommission').validate({ 
                rules: {

					set_comm_percentage:{required:true,},
					set_collected_amount:{required:true,},
					set_commission:{required:true,},
					description:{required:true,}
                },
                submitHandler: function(form) 
                {

					formData=new FormData(document.getElementById('setLeadCommission'));
					
                    $.ajax({
					url: "{{ route('admin.update-lead-commission') }}",
					type: 'post',
					dataType:'json',
					data: formData,
					success: function(result)
					{
						if(result.status==1)
						{
							toastr.success(result.msg);
							table.ajax.reload();
							$("#setLeadCommission")[0].reset();
							$("#set-commission-modal").modal('hide');
							
						}
						
					},
					cache: false,
					contentType: false,
					processData: false
                    });
				}
            });
		
		
		//-------------------------------------------------

        $("#leads-table tbody").on('click','.confirm_deletion',function()
        {
            var leadId = $(this).data('id');
            Swal.fire({
                title: 'Delete this lead?',
                text:  'This action cannot be undone.',
                icon:  'warning',
                showCancelButton:  true,
                confirmButtonText: 'Yes, delete',
                cancelButtonText:  'Cancel',
                confirmButtonColor: '#DC2626',
                cancelButtonColor:  '#94A3B8',
                reverseButtons:     true,
            }).then(function(result) {
                if (!result.isConfirmed) return;
                $.ajax({
                    url: "{{ route('admin.delete-lead') }}",
                    method: 'post',
                    data: {'_token':'{{ csrf_token() }}','lead_id': leadId},
                    success: function(result) {
                        if (result.status) {
                            toastr.success("Lead successfully removed!");
                            table.ajax.reload();
                        } else {
                            toastr.error(result.msg || 'Could not delete the lead.');
                        }
                    },
                    error: function() {
                        toastr.error('Could not delete the lead, please try again.');
                    }
                });
            });
        });


	$("#export_to_excel").click(function()
	{
		var pillStatus = $('.gl-leads-toolbar .filter-pill.active').data('status') || '';
		var status     = pillStatus || $('#filter_status').val() || '';
		var params = {
			status:  status  || 'All',
			partner: $('#partner_filter').val() || 'All',
			payment: $('#filter_payment_status').val() || 'All',
			age:     $('#filter_age').val() || ''
		};
		var lnk = "{{ route('admin.export-lead-list') }}" + "?" + $.param(params);
		$("#export_to_excel").attr('href', lnk);
	});
	



/// SET PAYMENT DETAILS -------------same functions added into payout blade file-------------------------------------------------------


 var paymentValidator=$('#paymentForm').validate({ 
                rules: {

                },
                submitHandler: function(form) 
                {
                    $("#btnPayment").attr('disabled',true).html('Saving <i class="fa fa-spinner fa-spin"></i>')
					
					var formData=new FormData(document.getElementById('paymentForm'));
					
                    $.ajax({
                    url: "{{ route('admin.save-payout') }}",
                    type: 'post',
                    data: formData,
                    success: function(result){
                        if(result.status == 1)
                        {
                            $("#btnPayment").attr('disabled',false).html('Submit')
							table.ajax.reload();
                            toastr.success(result.msg);
							$('#paymentForm')[0].reset();
							paymentValidator.resetForm();
							$("#payment-detail-modal").modal('hide');
                        }
                    },
					cache: false,
					contentType: false,
					processData: false
                    });
                  }
                });

		var cstatus='';
		$(document).on('click','#payment_status',function()
        {
            cstatus=$(this).val();
		});
		
		
		$(document).on('change','#payment_status',function()
        {
            lead_id = $(this).data('lead-id');
			var pstatus=$(this).val();
			
				$.ajax({
						url: "{{ route('admin.update-payment-status') }}",
						method: 'get',
						data: {'lead_id':lead_id,'status':$(this).val()},
						success: function(result)
						{
							if(result.status==1)
							{
								toastr.success(result.msg);
								table.ajax.reload();
							}
							else
							{
								toastr.warning(result.msg);
							}
							
						}
					});
				
        })


});	
		
</script>


@endpush
@endsection