<?php

namespace App\Http\Controllers\Web\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Auth;
use DataTables;
use App\Models\Lead;
use App\Models\Agent;
use App\Models\Partner;
use App\Models\Invite;
use App\Models\User;
use App\Models\LeadPurpose;
use App\Models\Notification;
use App\Models\PaymentDetail;

class DashboardController extends Controller
{
	
   public function dashboard()
    {

        $data['total_commission'] = PaymentDetail::totalCommission();
        $data['total_commission_paid'] = PaymentDetail::totalCommissionPaid();

		$data['lead_this_week']=Lead::thisWeekCount();
        $data['lead_this_month']=Lead::thisMonthCount();

		$data['total_this_week']=PaymentDetail::totalThisWeek();
        $data['total_this_month']=PaymentDetail::totalThisMonth();
		
		$data['payout_this_week']=PaymentDetail::payoutThisWeek();
        $data['payout_this_month']=PaymentDetail::payoutThisMonth();
		
		$data['partner_this_week']=Partner::thisWeekCount();
        $data['partner_this_month']=Partner::thisMonthCount();
				
        $data['total_partners']=Partner::count();
		$data['total_leads']=Lead::count();
		$data['total_agents']=Agent::count();

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
