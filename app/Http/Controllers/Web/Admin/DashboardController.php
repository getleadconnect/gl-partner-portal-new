<?php

namespace App\Http\Controllers\Web\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Auth;
use DataTables;
use Carbon\Carbon;
use App\Models\Lead;
use App\Models\Agent;
use App\Models\Partner;
use App\Models\Invite;
use App\Models\User;
use App\Models\LeadPurpose;
use App\Models\LeadStatus;
use App\Models\Notification;
use App\Models\PaymentDetail;
use App\Models\LeadCommission;

class DashboardController extends Controller
{
	
   public function dashboard()
    {

        //$data['total_commission'] = PaymentDetail::totalCommission();
        //$data['total_commission_paid'] = PaymentDetail::totalCommissionPaid();

        $data['total_commission'] = LeadCommission::totalCommission();
        $data['total_commission_paid'] = LeadCommission::totalCommissionPaid();


		$data['lead_this_week']=Lead::thisWeekCount();
        $data['lead_this_month']=Lead::thisMonthCount();

		$data['total_this_week']=LeadCommission::totalThisWeek();
        $data['total_this_month']=LeadCommission::totalThisMonth();
		
		$data['payout_this_week']=LeadCommission::payoutThisWeek();
        $data['payout_this_month']=LeadCommission::payoutThisMonth();
		
		$data['partner_this_week']=Partner::thisWeekCount();
        $data['partner_this_month']=Partner::thisMonthCount();
				
        $data['total_partners']=Partner::count();
		$data['total_leads']=Lead::count();
		$data['total_agents']=Agent::count();

		$data['active_partners']=Partner::where('status',1)->count();

		$data['monthly_volume']=LeadCommission::whereRaw('UPPER(lead_status)=?',['GOT BUSINESS'])
			->whereMonth('created_at', date('m'))
			->whereYear('created_at', date('Y'))
			->sum('amount_collected');

		$data['closed_leads_total']=Lead::whereRaw('UPPER(lead_status)=?',['GOT BUSINESS'])->count();
		$data['closed_leads_month']=Lead::whereRaw('UPPER(lead_status)=?',['GOT BUSINESS'])
			->whereMonth('created_at', date('m'))
			->whereYear('created_at', date('Y'))
			->count();

		$data['conversion_rate']= $data['lead_this_month'] > 0
			? round(($data['closed_leads_month'] / $data['lead_this_month']) * 100, 1)
			: 0;

		$data['lead_status_snapshot']=Lead::selectRaw('lead_status, COUNT(*) as cnt')
			->whereNotNull('lead_status')
			->groupBy('lead_status')
			->orderByDesc('cnt')
			->take(5)
			->get();

		$data['top_partners']=LeadCommission::selectRaw('partners.id, partners.name, partners.company_name, COUNT(lead_commissions.id) as deals, SUM(lead_commissions.commission_amount) as total_commission')
			->leftJoin('partners','lead_commissions.partner_id','=','partners.id')
			->whereRaw('UPPER(lead_commissions.lead_status)=?',['GOT BUSINESS'])
			->whereMonth('lead_commissions.created_at', date('m'))
			->whereYear('lead_commissions.created_at', date('Y'))
			->groupBy('partners.id','partners.name','partners.company_name')
			->orderByDesc('total_commission')
			->take(5)
			->get();

		$data['month_label']= Carbon::now()->format('F Y');
		$data['day_of_month']= (int) Carbon::now()->format('d');
		$data['days_in_month']= (int) Carbon::now()->format('t');
		$data['days_remaining']= max(1, $data['days_in_month'] - $data['day_of_month']);

		// Stale leads: still "New" and older than 7 days
		$data['stale_leads']=Lead::whereRaw('UPPER(lead_status)=?',['NEW'])
			->where('created_at', '<', Carbon::now()->subDays(7))
			->count();

		$data['stale_pct']= $data['total_leads'] > 0
			? round(($data['stale_leads'] / $data['total_leads']) * 100, 1)
			: 0;

		// Pipeline funnel — counts of each stage this month
		$stages=[
			['name'=>'New',           'sub'=>'Open pipeline',  'status'=>'New',           'class'=>'s-new'],
			['name'=>'Interested',    'sub'=>'Engaged',        'status'=>'Interested',    'class'=>'s-interested'],
			['name'=>'Proposal Sent', 'sub'=>'Quote sent',     'status'=>'Proposal Sent', 'class'=>'s-proposal'],
			['name'=>'Got Business',  'sub'=>'Closed-won',     'status'=>'Got Business',  'class'=>'s-won'],
		];
		$funnel=[];
		$max=0;
		foreach($stages as $s){
			$cnt=Lead::whereRaw('UPPER(lead_status)=?',[strtoupper($s['status'])])
				->whereMonth('created_at', date('m'))
				->whereYear('created_at', date('Y'))
				->count();
			$s['count']=$cnt;
			$funnel[]=$s;
			if($cnt > $max) $max=$cnt;
		}
		foreach($funnel as $i=>$s){
			$funnel[$i]['width']= $max > 0 ? round(($s['count']/$max)*100) : 0;
		}
		$data['funnel']=$funnel;

		// Hero target / pace metrics — target value is editable
		$data['monthly_target']     = 500000; // ₹5,00,000 — adjust as needed
		$data['target_pct']         = $data['monthly_target'] > 0
			? round(($data['monthly_volume'] / $data['monthly_target']) * 100, 1) : 0;
		$data['expected_pace_pct']  = round(($data['day_of_month'] / $data['days_in_month']) * 100, 1);
		$data['gap_to_close']       = max(0, $data['monthly_target'] - $data['monthly_volume']);
		$data['daily_pace_needed']  = (int) round($data['gap_to_close'] / $data['days_remaining']);
		$data['avg_daily_so_far']   = $data['day_of_month'] > 0
			? (int) round($data['monthly_volume'] / $data['day_of_month']) : 0;
		$data['projected_eom']      = (int) round($data['avg_daily_so_far'] * $data['days_in_month']);
		$data['projected_eom_pct']  = $data['monthly_target'] > 0
			? round(($data['projected_eom'] / $data['monthly_target']) * 100) : 0;

		$recent_noti=Notification::latest()->take(10)->get();
        					
        //return view('admin.dashboard',compact('graph_data','total_commission','total_amount_paid','total_bussiness','total_bussiness','total_leads','latest_leads','latest_payments','total_partners','total_agents'));
		
		return view('admin.dashboard',compact('data','recent_noti'));
    }
	
	
	public function getLatestLeads(Request $request)
    {
     
 			
			$data = Lead::latest()->leftJoin('partners','leads.partner_id','=','partners.id')
            ->select('leads.*','partners.name as partner_name')->take(10)->get();

			
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('partner', function($row){
                        	$partner = $row->partner_name;
                        return $partner;
                    })
                    
                    ->rawColumns(['actions'])
                    ->make(true);
    }


}
