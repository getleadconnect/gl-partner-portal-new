<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use GlPackage\NotificationManager\Notifications\EmailNotification;
use GlPackage\NotificationManager\Notifications\WhatsAppNotification;
use GlPackage\NotificationManager\Notifications\TelegramNotification;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\partnerExport;
use App\Exports\partnerActivityExport;
use App\Exports\leadsExport;
use App\Exports\payoutDetailsExport;
use App\Exports\paymentHistoryExport;

use DB; 
use DataTables;
use CountryState;
use App\Models\Lead;
use App\Models\Agent;
use App\Models\Admin;
use App\Models\Partner;
use App\Models\PartnerTier;
use App\Models\Invite;
use App\Models\User;
use App\Models\LeadPurpose;
use App\Models\NotificationStatus;
use App\Models\Notification;
use App\Models\LeadStatus;
use App\Models\BussinessCategory;
use App\Models\ProductAndService;
use App\Models\PaymentDetail;
use App\Models\News;
use App\Models\VerificationOtp;
use App\Models\AdminMessageSetting;
use App\Models\PaymentHistory;
use App\Models\PaymentVerify;
use App\Models\LeadCommission;

use App\Mail\InviteCreated;
use App\Traits\LeadNotificationTrait;

use Carbon\Carbon;
use Validator;
use Session;

use App\Services\ApiService;


class AdminController extends Controller
{
    use LeadNotificationTrait, ApiService;
	
	protected $sendMail;
	
	protected $user_email;
	
	protected $admin_email;
	protected $admin_whatsapp_no;
	

public function __construct()
{
	$this->sendMail= new EmailNotification();
	
	$ams=AdminMessageSetting::whereId(1)->first();
	if(!empty($ams))
	{
		$this->admin_email=$ams->email;
		$this->admin_whatsapp_no=$ams->whatsapp_no;
	}
}

public function login()
 {
	return view('admin.auth-login');
 }

public function check(Request $request){
        //Validate Inputs

		$validate = Validator::make(request()->all(),[
            'email'=>'required|email|exists:admins,email',
            'password'=>'required|min:5|max:30'
        ]);
	  
	    if ($validate->fails())
        {
			return back()->withErrors($validate)->withInput();
        }

        $creds = $request->only('email','password');

        if( Auth::guard('admin')->attempt($creds) )
		{
            return redirect()->route('admin.home');
        }else{
            return redirect()->route('admin.login')->with('fail','Incorrect credentials');
        }
   }

 public function logout()
 {
    Auth::guard('admin')->logout();
    return redirect('/');
 }
   
 public function terms()
  {
    return view('admin.terms_and_conditions');
  }
   
   
//-----------------------------------------------

   public function userProfile()
   {
       return view('admin.user_profile');
   }


    public function channelPartners()
    {
	    $agents = Agent::pluck('name','id');
		$countries = CountryState::getCountries();
		$ptiers = PartnerTier::orderBy('id')->get();

		// Per-tier counts driven directly by partner_tier_id
		$tierIdCounts = Partner::selectRaw('partner_tier_id, COUNT(*) as cnt')
			->groupBy('partner_tier_id')
			->pluck('cnt','partner_tier_id');

		$tier_counts = [
			'all'      => Partner::count(),
			'active'   => Partner::where('status',1)->count(),
			'inactive' => Partner::where('status',0)->count(),
			'by_tier'  => [],
		];
		foreach ($ptiers as $t) {
			$tier_counts['by_tier'][$t->id] = (int) ($tierIdCounts[$t->id] ?? 0);
		}

		$partner_count = $tier_counts['all'];
        return view('admin.partners',compact('ptiers','agents','partner_count','countries','tier_counts'));
    }

	/**
	 * Convert a hex color (#RGB or #RRGGBB) into an rgba() string with the given alpha.
	 * Used to derive a soft tint background from the tier's primary color.
	 */
	private function hexToRgba($hex, $alpha = 0.12)
	{
		$hex = ltrim((string) $hex, '#');
		if (strlen($hex) === 3) {
			$hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
		}
		if (!preg_match('/^[0-9a-fA-F]{6}$/', $hex)) {
			return null;
		}
		$r = hexdec(substr($hex, 0, 2));
		$g = hexdec(substr($hex, 2, 2));
		$b = hexdec(substr($hex, 4, 2));
		return "rgba($r,$g,$b,$alpha)";
	}
	
	
	public function getPartners(Request $request)
    {
        $agents = Agent::pluck('name','id');

		$status         = $request->searchStatus;
		$tierFilter     = $request->tier;
		$agentFilter    = $request->agent_id_filter;
		$activityFilter = $request->activity_filter;

	
		$leadsMonthByPartner = Lead::whereMonth('created_at', date('m'))
			->whereYear('created_at', date('Y'))
			->selectRaw('partner_id, COUNT(*) as cnt')
			->groupBy('partner_id')
			->pluck('cnt','partner_id');

		$gmvByPartner = LeadCommission::whereRaw('UPPER(lead_status)=?',['GOT BUSINESS'])
			->selectRaw('partner_id, SUM(amount_collected) as gmv')
			->groupBy('partner_id')
			->pluck('gmv','partner_id');

		$closedDealsByPartner = LeadCommission::whereRaw('UPPER(lead_status)=?',['GOT BUSINESS'])
			->selectRaw('partner_id, COUNT(*) as cnt')
			->groupBy('partner_id')
			->pluck('cnt','partner_id');

		$paidYtdByPartner = LeadCommission::whereYear('payment_date', date('Y'))
			->selectRaw('partner_id, SUM(paid_amount) as paid')
			->groupBy('partner_id')
			->pluck('paid','partner_id');

		$lastLeadByPartner = Lead::selectRaw('partner_id, MAX(created_at) as last_at')
			->groupBy('partner_id')
			->pluck('last_at','partner_id');

		$query = Partner::select('partners.*','agents.name as agent_name','partner_tiers.partner_tier as tier_label_db','partner_tiers.tier_color as tier_color_db')
			->leftJoin('agents','agents.id','partners.agent_id')
			->leftJoin('partner_tiers','partner_tiers.id','partners.partner_tier_id')
			->where(function($q)use($status)
            {
        	  ($status!="") ? $q->where('partners.status',$status)->orWhere('partners.status',null):'';
			});

		if ($agentFilter !== null && $agentFilter !== '') {
			$query->where('partners.agent_id', $agentFilter);
		}

		// Tier filter: numeric → partner_tier_id; 'active'/'inactive' → status
		if ($tierFilter !== null && $tierFilter !== '') {
			if ($tierFilter === 'active')        $query->where('partners.status', 1);
			elseif ($tierFilter === 'inactive')  $query->where('partners.status', 0);
			elseif (is_numeric($tierFilter))     $query->where('partners.partner_tier_id', (int) $tierFilter);
		}

		$data = $query->latest('partners.created_at')->get()->map(function($q) use($leadsMonthByPartner,$gmvByPartner,$paidYtdByPartner,$lastLeadByPartner,$closedDealsByPartner)
			{
				$lastAt = $lastLeadByPartner[$q->id] ?? null;
				$q['lead_activity_at_raw'] = $lastAt;
				$q['lead_activity_at']     = $lastAt ? Carbon::parse($lastAt)->diffForHumans() : '--';
				$q['leads_month']   = (int) ($leadsMonthByPartner[$q->id] ?? 0);
				$q['gmv_lifetime']  = (int) ($gmvByPartner[$q->id] ?? 0);
				$q['paid_ytd']      = (int) ($paidYtdByPartner[$q->id] ?? 0);
				$q['closed_deals']  = (int) ($closedDealsByPartner[$q->id] ?? 0);

				$q['tier_label'] = $q->tier_label_db ?: '—';
				$q['tier_color'] = $q->tier_color_db ?: null;

				return $q;
			});

		if ($activityFilter !== null && $activityFilter !== '') {
			$now = Carbon::now();
			$data = $data->filter(function($q) use ($activityFilter, $now) {
				$lastAt = $q['lead_activity_at_raw'] ?? null;
				$last   = $lastAt ? Carbon::parse($lastAt) : null;
				if ($activityFilter === '7d')      return $last && $last->gte($now->copy()->subDays(7));
				if ($activityFilter === '30d')    return $last && $last->gte($now->copy()->subDays(30));
				if ($activityFilter === 'stale30') return !$last || $last->lt($now->copy()->subDays(30));
				return true;
			})->values();
		}

            return Datatables::of($data)
                    ->addIndexColumn()
					->addColumn('name', function($row)
					{
						$name = '<a class="view-partner-details" href="javascript:;" id="'.$row->id.'">'.Str::upper($row->name).'</a>';

						return $name;
                    })

					->addColumn('partner', function($row)
					{
						$words = preg_split('/\s+/', trim($row->name ?? ''));
						$initials = strtoupper(substr($words[0] ?? '', 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
						if ($initials === '') $initials = 'P';
						$colors = ['c1','c2','c3','c4','c5','c6'];
						$c = $colors[$row->id % count($colors)];

						$bits = array_filter([
							$row->unique_id,
							($row->country_code ? '+'.$row->country_code : '').$row->mobile,
							$row->email,
						]);
						$sub = htmlspecialchars(implode(' · ', $bits), ENT_QUOTES);

						return '<div class="row-avatar">
							<div class="av '.$c.'">'.$initials.'</div>
							<div class="nm">
								<div class="name"><a href="javascript:;" class="view-partner-details" id="'.$row->id.'">'.htmlspecialchars(Str::upper($row->name ?? ''), ENT_QUOTES).'</a></div>
								<div class="sub">'.$sub.'</div>
							</div>
						</div>';
					})

					->addColumn('mobile', function($row)
					{
						return ($row->country_code?'+'.$row->country_code:'').$row->mobile;
                    })

					->addColumn('tier', function($row)
					{
						$label = $row->tier_label ?: '—';
						$color = $row->tier_color ?: null;
						if ($label === '—' || !$color) {
							return '<span class="tier tier-none">— not set</span>';
						}
						$bg = $this->hexToRgba($color, 0.12);
						$style = 'color:'.$color.';background:'.($bg ?: '#0351a0').';';
						$dotStyle = 'background:'.$color.';';
						return '<span class="tier" style="'.$style.'"><span class="tier-prefix-dot" style="'.$dotStyle.'"></span>'.htmlspecialchars($label, ENT_QUOTES).'</span>';
					})

					->addColumn('leads_month', function($row)
					{
						return (int)($row->leads_month ?? 0);
					})

					->addColumn('gmv_lifetime', function($row)
					{
						return '&#8377;'.number_format($row->gmv_lifetime ?? 0, 0, '.', ',');
					})

					->addColumn('commission_split', function($row)
					{
						$pct = $row->commission_percentage ?? 0;
						$set = ($pct > 0) ? $pct.'% set' : '— not set';
						if (($row->renewal_comm_percentage ?? 0) > 0) {
							$set .= ' · '.$row->renewal_comm_percentage.'% rnw';
						}
						$paid = '&#8377;'.number_format($row->paid_ytd ?? 0, 0, '.', ',').' paid YTD';
						return '<div class="comm-split"><span class="set">'.$set.'</span><span class="paid">'.$paid.'</span></div>';
					})

					->addColumn('commission_per', function($row)
					{
						return $row->commission_percentage.'/'.$row->renewal_comm_percentage;
                    })
	

					->addColumn('agent_name', function($row)
					{
						if($row->agent_name!="")
						{
							$words    = preg_split('/\s+/', trim($row->agent_name));
							$initials = strtoupper(substr($words[0] ?? '', 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
							if ($initials === '') $initials = 'A';

							return '<a href="javascript:;" class="agent-chip assign_agent" data-id="'.$row->agent_id.'" data-bs-toggle="modal" data-bs-target="#assign-agent-modal" id="'.$row->id.'" title="Re-assign agent">'
									.'<span class="agent-chip-avatar">'.htmlspecialchars($initials, ENT_QUOTES).'</span>'
									.'<span class="agent-chip-name">'.htmlspecialchars($row->agent_name, ENT_QUOTES).'</span>'
									.'<i class="bx bx-pencil agent-chip-edit"></i>'
									.'</a>';
						}

						return '<button type="button" class="btn-assign-agent assign_agent" data-id="0" data-bs-toggle="modal" data-bs-target="#assign-agent-modal" id="'.$row->id.'" title="Assign agent">'
								.'<i class="bx bx-user-plus"></i>'
								.'<span>Assign</span>'
								.'</button>';
                    })
										
					->addColumn('status', function($row)
					{
						$on    = ((int)$row->status === 1);
						$cls   = $on ? 'on' : 'off';
						$label = $on ? 'Active' : 'Inactive';
						$next  = $on ? 0 : 1;

						return '<span class="status-pill '.$cls.'" data-id="'.$row->id.'" data-current="'.($on?1:0).'" data-next="'.$next.'" title="Click to '.($on?'deactivate':'activate').'">'.$label.'</span>';
                    })
					
					->addColumn('action', function($row)
					{
			
						$action= '<div class="fs-5 ms-auto dropdown">
					 		   <div class="dropdown-toggle cursor-pointer" data-bs-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></div>
								<ul class="dropdown-menu">
								<li>
								  <a class="dropdown-item dropdown-item-size edit-partner" href="javascript:;"  id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#edit-partner-modal">
								  <i class="fa fa-edit"></i>&nbsp;Edit</a> </li>
								  <li>
								  <a class="dropdown-item dropdown-item-size set-commission" href="javascript:;"  id="'.$row->id.'" data-commission="'.$row->commission_percentage.'" data-renewal="'.$row->renewal_comm_percentage.'" data-bs-toggle="modal" data-bs-target="#set-commission-modal" >
								  <i class="fa fa-money"></i>&nbsp;Set Commission(%)</a> </li>
								  
								  <li>
								  <a class="dropdown-item dropdown-item-size confirm_deletion" href="javascript:;" id="'.$row->id.'">
								  <i class="fa fa-trash"></i>&nbsp;Delete</a> </li>';
								  
								 '</div>';
					return $action;
					})

                ->rawColumns(['name','partner','tier','commission_split','gmv_lifetime','agent_name','action','status'])
                ->make(true);
    }
	
	public function changePartnerStatus(Request $request)
    {
        $pid=$request->partner_id;
        $pval=$request->partner_status;

        try
        {
            $new_status=['status'=>$pval];
            
            $result=Partner::whereId($pid)->update($new_status);
            if($result)
            {
                return response()->json(['msg' =>'Partner status changed!' , 'status' => true]);
            }
            else
            {
                return response()->json(['msg' =>'Something wrong, try again!' , 'status' => false]);
            }
        }
        catch(\exception $e)
        {
            \Log::info($e->getMessage());
            return response()->json(['msg' =>$e->getmessage() , 'status' => false]);
        }
    }

	
public function createPartner(Request $request)
    {

		$validate = Validator::make(request()->all(),
		[
             'email'=>'required|unique:partners,email',
		   //'mobile'=>'required|unique:partners,mobile',
        ]);

	    if ($validate->fails())
        {
			return response()->json(['status'=>0,'msg'=>$validate->errors()->first()]);
        }
		else
		{
			try
			{
				/*	//---UNIQUE CODE
					$code='';
					do
					{
						$length = 5;
						$code = substr(uniqid(bin2hex(random_bytes(4)), true), -$length);  // Limiting the length to maxLength
						$code="GL".$code;
						$res=Partner::where('unique_id',$code)->first();
					}
					while(!empty($res));
				//---------------------------------	
				*/

				$result=Partner::create([
					'name'=>$request->name,
					'country_code'=>$request->country_code,
					'mobile'=>$request->mobile,
					'company_name'=>$request->company_name,
					'company_logo'=>$request->company_logo,
					'email'=>$request->email,
					'partner_tier_id'=>$request->partner_tier,
					'website'=>$request->website,
					'team_size'=>0,
					'country'=>$request->country??NULL,
					'country_name'=>$request->country_name,
					'state'=>$request->state,
					'city'=>$request->city,
					'pin_code'=>$request->pin_code,
					'password'=>\Hash::make($request->password),
					'photo'=>null,
					'commission_percentage'=>$request->comm_percentage,
					'renewal_comm_percentage'=>$request->renewal_comm_percentage,
					'bank_name'=>$request->bank_name,
					'ifsc'=>$request->ifsc_code,
					'branch'=>$request->branch,
					'account_number'=>$request->account_number,
					'upi_id'=>$request->upi_id,
					'status'=>$request->partner_status,
				]);
				
				//unique_id ----------------------
				$id=$result->id;
				$uniq_id="GLP".substr("00000",strlen($id)).$id;
				$res=Partner::where('id',$id)->update(['unique_id'=>$uniq_id]);
				//-------------------------------
				
				if($result)
				{
					//------SEND PARTNER TO CRM-----
					  $send_response=$this->sendPartnerDetailToCrm($request); 
					//------------------------------
						
					$partner_name=$request->name;
					$partner_country_code=$request->country_code;
					$partner_mobile=$request->mobile;
					
					$partner_full_mobile=$partner_country_code.$partner_mobile;
																
					$to_partner=$request->email;
					
					$login_url=url("/")."/partner/login";
					
					//---------------SEND MAIL -----------------		
						
					$data1 = [
							'subject' => 'GL-Partner, Welcome to Our Service',
							'body' => "" ,
							'view' => "admin_partner_adding_email_template", // Optional view page location
							'attachments' => [], // Optional attachments array
							'partner_name'=>$partner_name,
							'login_url'=>$login_url,
						];
						
					$data1['to_address']=$to_partner;  //send to partner
					$resp1=$this->sendMail->send($data1);  

					if($this->admin_email!="")
					{
						$data2 = [
								'subject' => "New Partner Registration Alert!",
								'body' => "" ,
								'view' => "admin_partner_adding_admin_email_template", // Optional view page location
								'attachments' => [], // Optional attachments array
								'partner_name'=>$request->name,
								'company_name'=>$request->company_name,
								'partner_mobile'=>$request->country_code.$request->mobile,
								'partner_email'=>$request->email,
							];
						
						$data2['to_address']=$this->admin_email; //send to admin
						$resp2=$this->sendMail->send($data2); 
					}
					
				//----- WHATSAPP MESSAGE--------------
						
				$data = [
							'mobile' => $partner_full_mobile,
							'template' => "partner_registration_message", // template for WhatsApp
							'parameters'=>[["type" => "text","text" => $login_url]],
							'buttons'=>[],
						];

				$whatsapp = new WhatsAppNotification();
				$result=$whatsapp->send($data); // Send WhatsApp message via queue

	
				//to admin ------------------------
				
					if($this->admin_whatsapp_no!="")
					{
						$data = [
								'mobile' => $this->admin_whatsapp_no,
								'template' => "partner_message_admin", // template for WhatsApp
								'parameters'=>[],
								'buttons'=>[],
							];

						$whatsapp = new WhatsAppNotification();
						$result=$whatsapp->send($data);
					}
					
					
				//------------SEND TELEGRAM MESSAGE---------
				
				$data = [
					'message' => "Hi,\n New partner registred into the Partner Portal !!!".
								 "\n --------------------------------------".
								 "\n Partner Name: ".$request->name.
								 "\n Company     : ".$request->company_name.
								 "\n Email       : ".$request->email.
								 "\n Contact     : ".$request->country_code.$request->mobile.
								 "\n --------------------------------------",
					'buttons' => [] 
				];
				
				$telegram = new TelegramNotification();
				$telegram->quickSend($data); // For quick send

				//---------------------------------------------------------------

					return response()->json(['status'=>1,'msg'=>'Partner details successfully added!']);
				}
				else
				{
					return response()->json(['status'=>0,'msg'=>'Some details are missing, Try again!']);
				}

			}
			catch(\Exception $e)
			{
				\Log::info($e->getMessage());
				return response()->json(['status'=>0,'msg'=>$e->getMessage()]);	
			}
		}
	
    }
	
	public function editPartner($id)
	{
		$part=Partner::whereId($id)->first();
		$lead = Lead::where('id',$id)->first();
        $countries = CountryState::getCountries();
		$ptiers=PartnerTier::all();
		if($part->country!="")
			$states = CountryState::getStates($part->country);
		else
			$states=[];
		
		return view('modals.edit_partner_modal',compact('ptiers','part','countries','states'));     
	}
	
	
	public function updatePartner(Request $request)
    {
		try
		{
		
		$partner = Partner::where('id',$request->partner_id)->first();
		
        $partner->name = $request->name_edit;
		$partner->country_code = $request->country_code_edit;
        $partner->mobile = $request->mobile_edit;
        $partner->company_name = $request->company_name_edit;
        $partner->email = $request->email_edit;
		$partner->partner_tier_id = $request->partner_tier_edit;
		$partner->commission_percentage = $request->comm_percentage_edit;
		$partner->renewal_comm_percentage = $request->renewal_comm_percentage_edit;
        $partner->website = $request->website_edit;
        $partner->country = $request->country_edit;
		$partner->country_name = $request->country_name_edit;
        $partner->state = $request->state_edit;
        $partner->city = $request->city_edit;
        $partner->pin_code = $request->pincode_edit;
		$partner->bank_name = $request->bank_name_edit;
        $partner->ifsc = $request->ifsc_edit;
        $partner->branch = $request->branch_edit;
        $partner->account_number = $request->account_number_edit;
		$partner->upi_id = $request->upi_id_edit;
		
		$result=$partner->save();
				
			if($result)
			{
				return response()->json(['status'=>1,'msg'=>'Partner details successfully updated!']);
			}
			else
			{
				return response()->json(['status'=>0,'msg'=>'Some details are missing, Try again!']);
			}

		}
		catch(\Exception $e)
		{
			\Log::info($e->getMessage());
			return response()->json(['status'=>0,'msg'=>'Some thing wrong, Try again!']);	
		}
       
    }

	public function partnerDetails($id)
	{
		$data['partner']=Partner::whereId($id)->first();
		$data['total_leads']=Lead::partnerTotalLeadsCount($id);
		$data['open_leads']=Lead::partnerStatusWiseLeadsCount($id,"New");
		$data['business_leads']=Lead::partnerStatusWiseLeadsCount($id,"Got Business");
		$data['total_commission']=LeadCommission::partnerTotalCommission($id);
		$data['commission_paid']=PaymentDetail::where('partner_id',$id)->sum('commission');
		return view('admin.partner_details_new',compact('data'));  
	}
		
	
	public function getPartnerLeads($id)
    {   
        $data = Lead::latest()->where('partner_id',$id)->get();
		
		return Datatables::of($data)
				->addIndexColumn()
				->addColumn('lead_status', function($row)
				{
					if(strtoupper($row->lead_status)=="GOT BUSINESS")
					$lead_status="<span class='success'>".$row->lead_status."</span>";
					else
					$lead_status="<span >".$row->lead_status."</span>";
					
					return $lead_status;
				})
				->addColumn('commission_amount', function($row)
				{
					$com_amount=number_format($row->commission_amount??0,2,'.','');
					return $com_amount;
				})
				
				
				->rawColumns(['lead_status'])
				->make(true);
    }

	
	public function deletePartner(Request $request)
    {
         $part=Partner::where('id',$request->partner_id)->delete();
		 return response()->json(['status'=>1]);
    }
		
	public function setPartnerCommissionPercentage(Request $request)
    {
        if(($request->commission!=null and $request->renewal_commission!=null) )
		{ 
			$pa=Partner::where('id',$request->partner_id)->first();
		 	$pa->commission_percentage=$request->commission;
			$pa->renewal_comm_percentage=$request->renewal_commission;
		 	$pa->save();
		 
           return response()->json(['status'=>1,'msg'=>"Commission percentage added."]);
		}
		else
		{
			return response()->json(['status'=>0,'msg'=>"Invalid commission values, try again.!"]);
		}

    }
		

	// PARTNER ACTIVITIES REPORT ----------------------------------------------------------------

	public function partnersActivities()
    {
	    $agents = Agent::pluck('name','id');
        $partner_count = Partner::all()->count();
		$countries = CountryState::getCountries();
		$partners=Partner::whereIn('id', Lead::pluck('partner_id')->toArray())->pluck('name','id')->toArray();
        return view('admin.partners_activities',compact('partners','agents','partner_count','countries')); 
    }
	
	
	public function getPartnersActivities(Request $request)
    {
        $agents = Agent::pluck('name','id');

		$status   = $request->searchStatus;
		$dateFrom = $request->date_from;
		$dateTo   = $request->date_to;

		$data = Partner::select('partners.*')
			->where(function($q) use($request)
			{
				$request->partner_id !="" ? $q->where('partners.id',$request->partner_id):'';
			})
			->where('status',1)
			->orderBy('id','DESC')->get()->map(function($q) use ($dateFrom, $dateTo)
				{
					$leadQuery = Lead::where('partner_id', $q->id);
					if (!empty($dateFrom)) $leadQuery->whereDate('created_at', '>=', $dateFrom);
					if (!empty($dateTo))   $leadQuery->whereDate('created_at', '<=', $dateTo);

					$lead = $leadQuery->latest()->first();

					if(!empty($lead))
					{
						$q['lead_name']=$lead->name;
						$q['lead_created_at']=Carbon::parse($lead->created_at)->format('Y-m-d h:i A');
						$q['lead_company']=$lead->company_name;
						$q['lead_status']=$lead->lead_status;
					}
					else
					{
						$q['lead_name']="--";
						$q['lead_created_at']="--";
						$q['lead_company']="--";
						$q['lead_status']="--";
					}
					return $q;
				});

		// When a date range is active, hide partners with no leads in that window.
		if (!empty($dateFrom) || !empty($dateTo)) {
			$data = $data->filter(function ($q) { return $q->lead_created_at !== "--"; });
		}

		$data = $data->sortByDesc('lead_created_at')->values();


            return Datatables::of($data)
                    ->addIndexColumn()

					->addColumn('partnerId', function($row)
					{
						return $row->unique_id;
                    })
					->addColumn('name', function($row)
					{
						$name     = (string) ($row->name ?? '');
						$words    = preg_split('/\s+/', trim($name));
						$initials = strtoupper(substr($words[0] ?? '', 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
						if ($initials === '') $initials = 'P';
						$colors = ['c1','c2','c3','c4','c5','c6'];
						$c = $colors[$row->id % count($colors)];
						$flags = ENT_QUOTES | ENT_SUBSTITUTE;

						return '<a class="row-avatar view-partner-details" href="javascript:;" id="'.$row->id.'">'
								.'<div class="av '.$c.'">'.htmlspecialchars($initials, $flags, 'UTF-8').'</div>'
								.'<div class="nm">'
									.'<div class="name">'.htmlspecialchars(strtoupper($name), $flags, 'UTF-8').'</div>'
									.(($row->email ?? '') !== '' ? '<div class="sub">'.htmlspecialchars((string)$row->email, $flags, 'UTF-8').'</div>' : '')
								.'</div>'
							.'</a>';
                    })

					->addColumn('mobile', function($row)
					{
						return ($row->country_code?'+'.$row->country_code:'').$row->mobile;
                    })

					->editColumn('lead_created_at', function($row)
					{
						if (!$row->lead_created_at || $row->lead_created_at === '--') return '—';
						try {
							return Carbon::parse($row->lead_created_at)->diffForHumans();
						} catch (\Exception $e) {
							return $row->lead_created_at;
						}
                    })

					->addColumn('commission_per', function($row)
					{
						return $row->commission_percentage.'/'.$row->renewal_comm_percentage;
                    })

					->editColumn('lead_status', function($row)
					{
						$s = strtoupper((string)$row->lead_status);
						if ($s === 'GOT BUSINESS')               return '<span class="pill won">'.$row->lead_status.'</span>';
						if ($s === 'NEW')                        return '<span class="pill qual">'.$row->lead_status.'</span>';
						if (str_starts_with($s, 'LOST'))         return '<span class="pill cold">'.$row->lead_status.'</span>';
						if ($s === 'INTERESTED' || str_contains($s,'DEMO') || str_contains($s,'PROPOSAL'))
							return '<span class="pill demo">'.$row->lead_status.'</span>';
						if ($row->lead_status == '--' || $row->lead_status === null) return '<span class="pill" style="background:#F1F5F9;color:#94A3B8;">—</span>';
						return '<span class="pill" style="background:#F1F5F9;color:#475569;">'.$row->lead_status.'</span>';
                    })

					->addColumn('status', function($row)
					{
						if ((int)$row->status === 1)
							return '<span class="pill paid">Active</span>';
						return '<span class="pill unpaid">Inactive</span>';
                    })
					
					->addColumn('action', function($row)
					{
			
						$action= '<div class="fs-5 ms-auto dropdown">
					 		   <div class="dropdown-toggle cursor-pointer" data-bs-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></div>
								<ul class="dropdown-menu">
								<li>
								  <a class="dropdown-item dropdown-item-size edit-partner" href="javascript:;"  id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#edit-partner-modal">
								  <i class="fa fa-edit"></i>&nbsp;Edit</a> </li>
								  <li>
								  <a class="dropdown-item dropdown-item-size set-commission" href="javascript:;"  id="'.$row->id.'" data-commission="'.$row->commission_percentage.'" data-renewal="'.$row->renewal_comm_percentage.'" data-bs-toggle="modal" data-bs-target="#set-commission-modal" >
								  <i class="fa fa-money"></i>&nbsp;Set Commission(%)</a> </li>
								  
								  <li>
								  <a class="dropdown-item dropdown-item-size confirm_deletion" href="javascript:;" id="'.$row->id.'">
								  <i class="fa fa-trash"></i>&nbsp;Delete</a> </li>';
								  
								 '</div>';
					return $action;
					})

                ->rawColumns(['name','agent_name','action','status','lead_status'])
                ->make(true);
    }
	




    public function assignAgent(Request $request)
    {
		
	   $partner = Partner::where('id',$request->agent_partner_id)->first();
        $partner->agent_id = $request->assign_agent_id;
        $partner->save();
        return response()->json(['status'=>1]);
    }
		
    public function leads()
    {
        $countries = CountryState::getCountries();

        $bussiness_categories = BussinessCategory::pluck('bussiness_category_name','id');
        $partner_list = Partner::all();
        $partner_with_leads = Lead::pluck('partner_id')->toArray();

        $partners = $partner_list->whereIn('id',$partner_with_leads)->pluck('name','id')->toArray();

        $all_partners = $partner_list->where('name','!=',null)->pluck('name','id');
		$lead_status = LeadStatus::all();

		// Counts driving the page header + filter pills + KPI cards
		$total_leads_count = Lead::count();
		$stale_leads_count = Lead::whereRaw('UPPER(lead_status) = ?', ['NEW'])
			->where('created_at', '<', Carbon::now()->subDays(7))
			->count();

		$leads_this_week  = Lead::where('created_at', '>=', Carbon::now()->subDays(7))->count();
		$closed_won_count = Lead::whereRaw('UPPER(lead_status) = ?', ['GOT BUSINESS'])->count();
		$close_rate       = $total_leads_count > 0
			? round(($closed_won_count / $total_leads_count) * 100, 1)
			: 0;
		$pipeline_value   = (int) Lead::whereRaw('UPPER(lead_status) NOT IN (?, ?)', ['GOT BUSINESS', 'CASE CLOSED'])
			->whereRaw('UPPER(lead_status) NOT LIKE ?', ['LOST%'])
			->sum('amount_collected');

		$leadStatusCountsRaw = Lead::selectRaw('lead_status, COUNT(*) as cnt')
			->whereNotNull('lead_status')
			->groupBy('lead_status')
			->pluck('cnt','lead_status');
		$lead_status_counts = $leadStatusCountsRaw->sortDesc()->take(6);

		return view('admin.leads', compact(
			'lead_status','all_partners','partners','countries','bussiness_categories',
			'total_leads_count','stale_leads_count','lead_status_counts',
			'leads_this_week','closed_won_count','close_rate','pipeline_value'
		));
    }
	

    public function createLead(Request $request)
    {

		$validate = Validator::make(request()->all(),[
             'mobile'=>'required|unique:leads,mobile',
			 'email'=>'required|unique:leads,email',
        ]);
	  
	    if ($validate->fails())
        {
			return response()->json(['status'=>0,'msg'=>$validate->errors()->first()]);
        }
		else
		{
				
			$admin_name=Auth::user()->name;
		
			try
			{
				
					$lead = new Lead();
					
					$lead->partner_id = $request->partner_id;
					$lead->name = $request->name;
					$lead->country_code = $request->country_code;
					$lead->mobile = $request->mobile;
					$lead->company_name = $request->company_name;
					$lead->designation = $request->designation;
					$lead->bussiness_category_id = $request->bussiness_category_id;
					$lead->email = $request->email;
					$lead->plan_type = $request->plan_type??null;
					$lead->plan_id = $request->plan??null;
					$lead->area = $request->area??null;
					$lead->country = $request->country??null;
					$lead->country_name = $request->country_name??null;
					$lead->state = $request->state??null;
					$lead->pincode = $request->pincode??null;
					$lead->address = $request->address;
					$lead->remarks = $request->remarks;
					$lead->lead_status ="New";
					$lead->owner_type = 1;
					$result=$lead->save();
			
				if($result)
				{
					$partner=Partner::where('id',$request->partner_id)->first();
						$ndat=['notification'=>$admin_name." added new leads for partner ".$partner->name,
							'partner_id'=>$request->partner_id,
							'status'=>0,
							'category'=>2,
							];
							
					Notification::create($ndat);
					
					//------SEND LEAD TO CRM-----------------------------------------
					
						$send_response=$this->sendLeadToCrm($request);   //send lead to getlead CRM
						
					//-------SEND MAIL --------------------------------------------
					
						$partner=Partner::where('id',$request->partner_id)->first();
									
						if(!empty($partner))
						{												
							$partner_name=$partner->name;
							$partner_country_code=$partner->country_code;
							$partner_mobile=$partner->mobile;
							$partner_full_mobile=$partner_country_code.$partner_mobile;
							$to_partner=$partner->email;
													
							$data1 = [
									'subject' => 'New Lead Added to Your Account',
									'body' => "" ,
									'view' => "partner_lead_adding_email_template", // Optional view page location
									'attachments' => [], // Optional attachments array
									'partner_name'=>$partner_name,
								];
								
							$data1['to_address']=$to_partner;  //send to partner
							$resp1=$this->sendMail->send($data1);  
							
							if($this->admin_email!="")
							{
								$data2 = [
										'subject' => 'New Lead Added for '.$partner_name,
										'body' => "",
										'view' => "partner_lead_adding_admin_email_template", // Optional view page location
										'attachments' => [], // Optional attachments array
										'partner_name'=>$partner_name,
										'lead_name'=>$request->name,
										'lead_contact'=>$request->country_code.$request->mobile,
									];
								
								$data2['to_address']=$this->admin_email; //send to admin
								$resp2=$this->sendMail->send($data2); 
							}
						}

				//----- WHATSAPP MESSAGE-------------------------------------------------
			
				$data = [
							'mobile' => $partner_full_mobile,
							'template' => "partner_message", // template for WhatsApp
							'parameters'=>[],
							'buttons'=>[],
						];

				$whatsapp = new WhatsAppNotification();
				$result=$whatsapp->send($data); // Send WhatsApp message via queue
							
				//to admin ----------------------------------------------

					if($this->admin_whatsapp_no!="")
					{					
						$data = [
								'mobile' => $this->admin_whatsapp_no,
								'template' => "partner_message2", // template for WhatsApp
								'parameters'=>[["type" => "text","text" => $partner_name]],
								'buttons'=>[],
							];

						$whatsapp = new WhatsAppNotification();
						$result=$whatsapp->send($data);
					}	
		
				//--------- SEND MESSAGE TO TELEGRAM --------------------------------------------

				$bname=BussinessCategory::where('id',$request->bussiness_category_id)->pluck('bussiness_category_name')->first();

				$data = [
					'message' => "Hi,\n New lead received Via Partner Portal. Added By <b>". Auth::user()->name. "</b> for partner ".$partner_name.
								 "\n --------------------------------------".
								 "\n Partner Name: ".$partner_name.
								 "\n Lead Name   : ".$request->name.
								 "\n Email       : ".$request->email.
								 "\n Contact     : ".$request->country_code.$request->mobile.
								 "\n Business    : ".$bname.
								 "\n --------------------------------------",
					'buttons' => [] 
				];
				
				$telegram = new TelegramNotification();
				$telegram->quickSend($data); // For quick send

				//$telegram->queueSend($data); // For queued send

				//------------------------------------------------------------------------
				
				
				  return response()->json(['status'=>1,'msg'=>'Lead Successfully added!']);	
				}
				else
				{
				  return response()->json(['status'=>0,'msg'=>'Something wrong, Please check.']);
				}
			}
			catch(\Exception $e)
			{
				\Log::info($e->getMessage());
				return response()->json(['status'=>0,'msg'=>$e->getMessage]);
			}
		}
    }

   public function editLeadDetails($id)
    {
       $lead = Lead::where('id',$id)->first();
       $partner_with_leads = Lead::pluck('partner_id')->toArray();
	   $bussiness_categories = BussinessCategory::pluck('bussiness_category_name','id');
       $all_partners = Partner::whereIn('id',$partner_with_leads)->pluck('name','id')->toArray();
	   $countries = CountryState::getCountries();
		if($lead->country!="")
			$state = CountryState::getStates($lead->country);
		else
			$state=[];
		
	   return view('modals.edit_lead_admin',compact('lead','bussiness_categories','all_partners','countries','state'));
    }
		
		//for edit lead 
		
	public function getPlanForEditLead($ptid)
    {
        $list = ProductAndService::where('type',$ptid)->get();
        $arr=[];
        foreach ($list as $key => $value)
        {
            $str=$value->plan_name." ".$value->users." users ".$value->pricing." per month";
            $arr[$value->id] = $str;
        }
        return $arr;
    }
	
	//--------------------------------------
	
	
    public function updateLead(Request $request)
    {
        $lead = Lead::where('id',$request->lead_id)->first();
        if($request->has('partner_id'))
        {
            $lead->partner_id = $request->partner_id;
        }
        $lead->name = $request->edit_name;
		$lead->country_code = $request->edit_country_code;
        $lead->mobile = $request->edit_mobile;
        $lead->company_name = $request->edit_company_name;
        $lead->designation = $request->edit_designation;
        $lead->bussiness_category_id = $request->edit_bussiness_category_id;
        $lead->email = $request->edit_email;
        $lead->plan_type = $request->edit_plan_type;
        $lead->plan_id = $request->edit_plan;
		$lead->country = $request->edit_country;
		$lead->country_name = $request->edit_country_name;
		$lead->state = $request->edit_state;
        $lead->area = $request->edit_area;
        $lead->pincode = $request->edit_pincode;
        $lead->address = $request->edit_address;
        $lead->remarks = $request->edit_remarks;
        $lead->save();

        return response()->json(['status'=>1,'msg'=>'Lead Updated Successfully !!!']);
    }
    
	
    public function listLeads(Request $request)
    {
			$lstatus = LeadStatus::pluck('lead_status');
			$age     = $request->age_filter;
			$now     = Carbon::now();

            $query = Lead::latest()->leftJoin('partners','leads.partner_id','=','partners.id')
			->where(function($q) use($request)
            {
                $request->partner_id !=0 ? $q->where('partner_id',$request->partner_id):'';
                $request->status !="" ?$q->where('lead_status',$request->status):'';
				$request->pay_status !="" ?$q->where('payment_status',$request->pay_status):'';
            })->select('leads.*','partners.name as partner_name','partners.commission_percentage','partners.renewal_comm_percentage');

			if ($age === 'stale')      $query->where('leads.created_at', '<', $now->copy()->subDays(7));
			elseif ($age === 'cold')   $query->where('leads.created_at', '<', $now->copy()->subDays(14));

			$data = $query->get();

			// Scrub invalid UTF-8 in any string attribute so json_encode in DataTables doesn't blow up.
			$data->transform(function ($row) {
				foreach ($row->getAttributes() as $key => $val) {
					if (is_string($val) && $val !== '' && !preg_match('//u', $val)) {
						$row->setAttribute($key, mb_convert_encoding($val, 'UTF-8', 'UTF-8'));
					}
				}
				return $row;
			});

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('partner', function($row){

                        return $row->partner_name;
                    })

                    ->addColumn('lead', function($row){
                        $name     = (string) ($row->name ?? '');
                        $words    = preg_split('/\s+/', trim($name));
                        $initials = strtoupper(substr($words[0] ?? '', 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                        if ($initials === '') $initials = 'L';
                        $colors = ['c1','c2','c3','c4','c5','c6'];
                        $c = $colors[$row->id % count($colors)];

                        $bits = array_filter([
                            $row->email,
                            ($row->country_code ? '+'.$row->country_code.' ' : '').$row->mobile,
                        ]);
                        $flags = ENT_QUOTES | ENT_SUBSTITUTE;
                        $sub   = htmlspecialchars(implode(' · ', $bits), $flags, 'UTF-8');

                        return '<div class="row-avatar">'
                                .'<div class="av '.$c.'">'.htmlspecialchars($initials, $flags, 'UTF-8').'</div>'
                                .'<div class="nm">'
                                    .'<div class="name">'.htmlspecialchars($name, $flags, 'UTF-8').'</div>'
                                    .'<div class="sub">'.$sub.'</div>'
                                .'</div>'
                            .'</div>';
                    })

                    ->addColumn('days_in_stage', function($row) use ($now) {
                        if (!$row->created_at) return '—';
                        $days = $now->diffInDays(Carbon::parse($row->created_at));
                        $cls  = 'fresh';
                        if ($days > 14)     $cls = 'cold';
                        elseif ($days > 7)  $cls = 'stale';
                        $label = $days.' day'.($days == 1 ? '' : 's');
                        return '<span class="days '.$cls.'"><span class="dot"></span>'.$label.'</span>';
                    })

                    ->addColumn('deal_value', function($row){
                        if ($row->amount_collected) {
                            return '<span class="num strong">&#8377;'.number_format($row->amount_collected, 0, '.', ',').'</span>';
                        }
                        return '<span class="num muted">—</span>';
                    })

                    ->addColumn('commission_amount', function($row){
                        if($row->commission_amount)
                        {
                            return "₹ ".number_format($row->commission_amount,2,'.','');
                        }
                        return "--";
                    })
                    ->addColumn('amount_collected', function($row){
                        if($row->amount_collected)
                        {
                            return "₹ ".number_format($row->amount_collected,2,'.','');
                        }
                        return "--";
                    })
					->addColumn('status', function($row) use($lstatus)
					{

                        $options = '';
                        foreach ($lstatus as $value) 
                        {
                            if($row->lead_status == $value)
                            {
                                $options.='<option value ="'.$value.'" selected>'.$value.'</option>';
                            }
                            else{
                                $options.='<option value = "'.$value.'">'.$value.'</option>';
                            }
                        }
												
						if($row->lead_status=="Got Business"){
							
							$clas=' payment-active';
							$html="<span class='success'>".$row->lead_status."</span>";
						}
						else
						{
							$clas='';
							$html = '<select class="form-select '.$clas.'" style="font-weight:500;" name="lead_status" id="lead_status" data-leadid='.$row->id.' data-commission='.$row->commission_percentage.'>'.$options.'</select>';
						}
                        return $html;
				
                    })
					->addColumn('pay_status', function($row)
					{
						if ($row->payment_status == 0) {
							return '<span class="pill unpaid">Not Paid</span>';
						}
						if ($row->payment_status == 2) {
							return '<span class="pill pending">Pending</span>';
						}
						return '<span class="pill paid">Paid</span>';
                    })

					->addColumn('mobile', function($row)
					{
						$mobile= ($row->country_code?'+'.$row->country_code:'').' '.$row->mobile;
						return $mobile;
                    })

					->addColumn('renewal', function($row)
					{
						return "renewal";
                    })
					
                     ->addColumn('action', function($row){
						$reCom = '';
						if ($row->payment_status == 1) {
							$reCom = '<button type="button" class="row-action-btn text accent renewal_commission" '
								.'data-lstatus="'.$row->lead_status.'" '
								.'data-leadid="'.$row->id.'" '
								.'data-commission="'.$row->commission_percentage.'" '
								.'data-recommission="'.$row->renewal_comm_percentage.'" '
								.'data-bs-toggle="modal" data-bs-target="#set-commission-modal" '
								.'title="Renewal commission">Re-Com</button>';
						}

						return '<div class="row-action">'
								.'<button type="button" class="row-action-btn edit_lead" id="'.$row->id.'" '
									.'data-bs-toggle="modal" data-bs-target="#edit-lead-modal" title="Edit lead">'
									.'<i class="bx bx-pencil"></i>'
								.'</button>'
								.$reCom
								.'<button type="button" class="row-action-btn danger confirm_deletion" data-id="'.$row->id.'" title="Delete lead">'
									.'<i class="bx bx-trash"></i>'
								.'</button>'
							.'</div>';
                    })
                      ->rawColumns(['lead','days_in_stage','deal_value','pay_status','mobile','status','action'])
                      ->make(true);
    }


   public function updatePaymentStatus(Request $request)
    {
        $lead = Lead::where('id',$request->lead_id)->first();
		$lead->payment_status = $request->status;
		$lead->save();
		return response()->json(['status'=>1,'msg'=>'Payment status changed!']);
    }

	
	public function updateLeadStatus(Request $request)
    {
        $lead = Lead::where('id',$request->lead_id)->first();
        $lead->lead_status = trim($request->lead_status);
        $lead->save();
        return response()->json(['status'=>1,'msg'=>'Lead status updated !!!']);
    }


public function updateLeadCommission(Request $request)
    {
       
	   DB::beginTransaction();
	   
	   try
	   {
		 
	    $lead_id = $request->set_comm_lead_id;
						
        $lead = Lead::find($lead_id);
		$partner_id=$lead['partner_id'];
		
		$data=[
				'partner_id' => $partner_id,
				'lead_id' => $request->set_comm_lead_id,
				'amount_collected' => $request->set_collected_amount,
				'commission_amount' => $request->set_commission,
				'description' => $request->description,
				'paid_amount' => null,
				'balance' => $request->set_commission,
				'lead_status' => $request->set_comm_lead_status,
				'renewal_status'=>$request->renewal_status??null,
			];
			
		$result=LeadCommission::create($data);
		
		$lead->lead_status = $request->set_comm_lead_status;
        $lead->save();

		DB::commit();
        return response()->json(['status'=>1,'msg'=>'Commission successfully added!']);
		
	   }
	   catch(\Exception $e)
	   {
		   DB::rollBack();
		   \Log::info($e->getMessage());
		   return response()->json(['status'=>0,'msg'=>$e->getMessage()]);
	   }
    }


    public function showProductServices()
    {
        return view('admin.product_services');
    }

    public function getProductServiceDetails(Request $request)
    {
        $data = ProductAndService::where('id',$request->id)->first();
        return response()->json(['status'=>1,'data'=>$data]);
    }

    public function createProductServiceDetails(Request $request)
    {
        $row = new ProductAndService;
        $row->type = $request->plan_type;
        $row->plan_name = $request->plan_name;
        $row->users = $request->users;
        $row->month = $request->month;
        $row->pricing = $request->pricing;
        $row->save();
        return response()->json(['status'=>1,'msg'=>"Data added successfully !!!"]);
    }

    public function updateProductServiceDetails(Request $request)
    {
        $row = ProductAndService::where('id',$request->ps_id)->first();
        $row->type = $request->edit_plan_type;
        $row->plan_name = $request->edit_plan_name;
        $row->users = $request->edit_users;
        $row->month = $request->edit_month;
        $row->pricing = $request->edit_pricing;
        $row->status = $request->edit_plan_status;
        $row->save();
        return response()->json(['status'=>1,'msg'=>"Data updated successfully !!!"]);
    }
	
	// AGENTS -----------------------------------------------------------------------------

    public function agentList(Request $request)
    {
        if ($request->ajax()) {

            // Partners assigned to each agent
            $partnersCountByAgent = Partner::selectRaw('agent_id, COUNT(*) as cnt')
                ->whereNotNull('agent_id')
                ->groupBy('agent_id')
                ->pluck('cnt', 'agent_id');

            // Open leads count per agent (via partner_id → partners.agent_id), excluding closed/lost
            $openLeadsCountByAgent = Lead::leftJoin('partners', 'leads.partner_id', '=', 'partners.id')
                ->whereRaw('UPPER(leads.lead_status) NOT IN (?, ?)', ['GOT BUSINESS', 'CASE CLOSED'])
                ->whereRaw('UPPER(leads.lead_status) NOT LIKE ?', ['LOST%'])
                ->whereNotNull('partners.agent_id')
                ->selectRaw('partners.agent_id, COUNT(*) as cnt')
                ->groupBy('partners.agent_id')
                ->pluck('cnt', 'partners.agent_id');

            $data = Agent::latest()->get()->map(function ($a) use ($partnersCountByAgent, $openLeadsCountByAgent) {
                $a['partners_count']   = (int) ($partnersCountByAgent[$a->id]   ?? 0);
                $a['open_leads_count'] = (int) ($openLeadsCountByAgent[$a->id] ?? 0);
                return $a;
            });

            return Datatables::of($data)
                    ->addIndexColumn()

                    ->addColumn('agent', function($row){
                        $words    = preg_split('/\s+/', trim((string) $row->name));
                        $initials = strtoupper(substr($words[0] ?? '', 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                        if ($initials === '') $initials = 'A';
                        $colors = ['c1','c2','c3','c4','c5','c6'];
                        $c = $colors[$row->id % count($colors)];
                        $flags = ENT_QUOTES | ENT_SUBSTITUTE;

                        return '<div class="row-avatar">'
                                .'<div class="av '.$c.'">'.htmlspecialchars($initials, $flags, 'UTF-8').'</div>'
                                .'<div class="nm">'
                                    .'<div class="name">'.htmlspecialchars((string) $row->name, $flags, 'UTF-8').'</div>'
                                    .'<div class="sub">'.htmlspecialchars((string) ($row->email ?? ''), $flags, 'UTF-8').'</div>'
                                .'</div>'
                            .'</div>';
                    })

                    ->addColumn('mobile_fmt', function($row){
                        return $row->mobile ? htmlspecialchars((string) $row->mobile, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') : '—';
                    })

                    ->addColumn('partners_count', function($row){
                        return (int) ($row->partners_count ?? 0);
                    })

                    ->addColumn('open_leads_count', function($row){
                        return (int) ($row->open_leads_count ?? 0);
                    })

                    ->addColumn('joined', function($row){
                        return $row->created_at ? Carbon::parse($row->created_at)->diffForHumans() : '—';
                    })

                    ->addColumn('action', function($row){
                        return '<div class="row-action">'
                                .'<button type="button" class="row-action-btn edit_agent" id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#edit-agent-modal" title="Edit agent">'
                                    .'<i class="bx bx-pencil"></i>'
                                .'</button>'
                                .'<button type="button" class="row-action-btn danger confirm_agent_deletion" data-id="'.$row->id.'" title="Delete agent">'
                                    .'<i class="bx bx-trash"></i>'
                                .'</button>'
                            .'</div>';
                    })
                    ->rawColumns(['agent','action'])
                    ->make(true);
        }

        $total_agents    = Agent::count();
        $assigned_agents = Partner::whereNotNull('agent_id')->distinct('agent_id')->count('agent_id');
        return view('admin.agent_list', compact('total_agents','assigned_agents'));
    }

    public function createAgent(Request $request)
    {
		try
		{
			
			$result=Agent::create([
				'name' => $request->name,
				'email' => $request->email,
				'mobile' => $request->mobile,
				'password'=> \Hash::make($request->password),
			]);
			
			if($result)
			{
				return response()->json(['status'=>1,'msg'=>"Agent details successfully added!"]);
			}
			else
			{
				return response()->json(['status'=>0,'msg'=>"Something wrong, Please check."]);
			}

		}catch(\Exception $e)
		{
			\Log::info($e->getMessage());
			return response()->json(['status'=>0,'msg'=>"Something wrong, Try agin."]);
		}
    }


  public function editAgent($id)
    {
       $agent = Agent::where('id',$id)->first();
       return view('modals.edit_agent_admin',compact('agent'));
	   
    }
	
public function updateAgent(Request $request)
    {
		try
		{
			
			$agent=Agent::where('id',$request->agent_id)->first();
			
			$agent->name = $request->name_edit;
			$agent->email = $request->email_edit;
			$agent->mobile = $request->mobile_edit;
			$result=$agent->save();
				
			if($result)
			{
				return response()->json(['status'=>1,'msg'=>"Agent details successfully updated!"]);
			}
			else
			{
				return response()->json(['status'=>0,'msg'=>"Something wrong, Please check."]);
			}

		}catch(\Exception $e)
		{
			\Log::info($e->getMessage());
			return response()->json(['status'=>0,'msg'=>"Something wrong, Try agin."]);
		}
    }

 public function deleteAgent(Request $request)
    {
       $agent = Agent::where('id',$request->agent_id)->delete();
       return response()->json(['status'=>1]);
    }

// PAYOUTS -------------------------------------------------------------------

public function payouts(Request $request)
    {

        $partners = Partner::whereIn('id', Lead::pluck('partner_id')->toArray())->pluck('name','id')->toArray();
		$lead_status = LeadStatus::all();

		// Info card metrics — driven entirely by lead_commissions
		$unpaid = LeadCommission::where('lead_status', 'Got Business')->where('payment_status', 0);

		$pending_payout = (int) (clone $unpaid)->sum('balance');
		$pending_deals  = (clone $unpaid)->count();
		$partners_owed  = (clone $unpaid)->whereNotNull('partner_id')->distinct('partner_id')->count('partner_id');

		$aged_payout    = (int) (clone $unpaid)->where('created_at', '<', Carbon::now()->subDays(14))->sum('balance');
		$aged_deals     = (clone $unpaid)->where('created_at', '<', Carbon::now()->subDays(14))->count();

		$paid_this_month = (int) LeadCommission::where('lead_status', 'Got Business')
			->where('payment_status', 1)
			->whereMonth('payment_date', date('m'))
			->whereYear('payment_date', date('Y'))
			->sum('paid_amount');

		$unpaid_count = (clone $unpaid)->count();
		$paid_count   = LeadCommission::where('lead_status', 'Got Business')->where('payment_status', 1)->count();

		return view('admin.payouts_list', compact(
			'partners','lead_status',
			'pending_payout','pending_deals','partners_owed',
			'aged_payout','aged_deals','paid_this_month',
			'unpaid_count','paid_count'
		));
    }



	
public function gotBusinessUnPaidLeads(Request $request)
    {
			  
			 $data = LeadCommission::select('lead_commissions.*','leads.name','leads.mobile','leads.email','partners.name as partner_name','partners.commission_percentage','partners.renewal_comm_percentage','partner_tiers.partner_tier')
			->leftJoin('partners','lead_commissions.partner_id','=','partners.id')
			->leftJoin('partner_tiers','partners.partner_tier_id','=','partner_tiers.id')
			->leftJoin('leads','lead_commissions.lead_id','=','leads.id')
			->where(function($q)use($request)
            {
                $request->partner_id !=0 ? $q->where('lead_commissions.partner_id',$request->partner_id):'';
            })->where('lead_commissions.lead_status',"Got Business")
			  ->where('lead_commissions.payment_status',0)
			  ->latest()->get()->map(function($q)
			  {
				  //$lcom=LeadCommission::where('lead_id',$q->id)->where('renewal_status','renewal')->first();
				  if(strtoupper($q->renewal_status)=="RENEWAL")
				  {
						$q['amount_collected']=$q->amount_collected;
				  		$q['commission_amount']=$q->commission_amount;
				  		$q['paid_amount']=$q->paid_amount;
				  		$q['balance']=$q->balance;
					  }
				  else
				  {
				  	$q['amount_collected']=$q->amount_collected;
				  	$q['commission_amount']=$q->comnission_amount;
				  	$q['paid_amount']=$q->paid_amount;
	  			    $q['balance']=$q->balance;
				  }

				  return $q;
			  });

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('partner', function($row){
                        $name     = (string) ($row->partner_name ?? '');
                        $words    = preg_split('/\s+/', trim($name));
                        $initials = strtoupper(substr($words[0] ?? '', 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                        if ($initials === '') $initials = 'P';
                        $colors = ['c1','c2','c3','c4','c5','c6'];
                        $c = $colors[((int) $row->partner_id) % count($colors)];
                        $flags = ENT_QUOTES | ENT_SUBSTITUTE;
                        $href = route('admin.pay-partner-payment', $row->partner_id);

                        return '<a href="'.$href.'" class="row-avatar partner-link">'
                                .'<div class="av '.$c.'">'.htmlspecialchars($initials, $flags, 'UTF-8').'</div>'
                                .'<div class="nm">'
                                    .'<div class="name">'.htmlspecialchars(strtoupper($name), $flags, 'UTF-8').'</div>'
                                    .'<div class="sub">'.$row->partner_tier.'</div>'
                                .'</div>'
                            .'</a>';
                    })
					->addColumn('lead_name', function($row){
                        return $row->name;
                    })

                    ->addColumn('type', function($row){
                        if (strtoupper($row->renewal_status)=="RENEWAL") {
                            return '<span class="type-mark r" title="Renewal commission">R</span>';
                        }
                        return '<span class="type-mark i" title="First commission">I</span>';
                    })

					->addColumn('amount_collected', function($row){
						return '&#8377;'.number_format($row->amount_collected, 0, '.', ',');
                    })
					->addColumn('commission_amount', function($row){
						return '<span class="num strong">&#8377;'.number_format($row->commission_amount, 0, '.', ',').'</span>';
                    })

					->addColumn('amount', function($row){
                        $paid = (int) $row->paid_amount;
                        if ($paid === 0) {
                            return '<span class="num muted">&#8377;0</span>';
                        }
                        return '&#8377;'.number_format($paid, 0, '.', ',');
                    })

					->addColumn('balance', function($row){
                        return '<span class="num strong" style="color:#D97706;">&#8377;'.number_format($row->balance, 0, '.', ',').'</span>';
                    })

					->addColumn('status', function($row){
                        return '<span class="pill won">Got Business</span>';
                    })

                    ->addColumn('aged', function($row){
                        if (!$row->created_at) return '<span class="days fresh"><span class="dot"></span>—</span>';
                        $days = Carbon::parse($row->created_at)->diffInDays(Carbon::now());
                        $cls  = 'fresh';
                        if ($days > 14)    $cls = 'cold';
                        elseif ($days > 7) $cls = 'stale';
                        return '<span class="days '.$cls.'"><span class="dot"></span>'.$days.'d</span>';
                    })

					->addColumn('email', function($row)
					{
                        $flags = ENT_QUOTES | ENT_SUBSTITUTE;
                        return htmlspecialchars((string)($row->email ?? ''), $flags, 'UTF-8').'<br>'
                            .htmlspecialchars((string)($row->mobile ?? ''), $flags, 'UTF-8');
                    })
					->addColumn('actions', function($row)
					{
                        $href = route('admin.pay-partner-payment', $row->partner_id);
                        return '<a href="'.$href.'" class="gl-btn gl-btn-outline btn-pay" title="Set Payout">'
                                .'<i class="bx bx-plus"></i> Payout'
                            .'</a>';
                    })

                    ->rawColumns(['actions','lead_name','partner','email','status','pay_status','type','amount_collected','commission_amount','amount','balance','aged'])
                    ->make(true);
    }
	

public function gotBusinessPaidLeads(Request $request)
    {

			$data = LeadCommission::select(
                    'lead_commissions.*',
                    'leads.name','leads.mobile','leads.email','leads.country_code',
                    'partners.name as partner_name','partners.commission_percentage','partners.renewal_comm_percentage','partner_tiers.partner_tier'
                )
                ->leftJoin('partners','lead_commissions.partner_id','=','partners.id')
				->leftJoin('partner_tiers','partners.partner_tier_id','=','partner_tiers.id')
                ->leftJoin('leads','lead_commissions.lead_id','=','leads.id')
                ->where(function($q) use($request) {
                    $request->partner_id != 0 ? $q->where('lead_commissions.partner_id', $request->partner_id) : '';
                })
                ->where('lead_commissions.lead_status', 'Got Business')
                ->where('lead_commissions.payment_status', 1)
                ->latest('lead_commissions.created_at')
                ->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('partner', function($row){
                        $name     = (string) ($row->partner_name ?? '');
                        $words    = preg_split('/\s+/', trim($name));
                        $initials = strtoupper(substr($words[0] ?? '', 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                        if ($initials === '') $initials = 'P';
                        $colors = ['c1','c2','c3','c4','c5','c6'];
                        $c = $colors[((int) $row->partner_id) % count($colors)];
                        $flags = ENT_QUOTES | ENT_SUBSTITUTE;
                        $href = route('admin.pay-partner-payment', $row->partner_id);

                        return '<a href="'.$href.'" class="row-avatar partner-link">'
                                .'<div class="av '.$c.'">'.htmlspecialchars($initials, $flags, 'UTF-8').'</div>'
                                .'<div class="nm">'
                                    .'<div class="name">'.htmlspecialchars(strtoupper($name), $flags, 'UTF-8').'</div>'
                                    .'<div class="sub">'.$row->partner_tier.'</div>'
                                .'</div>'
                            .'</a>';
                    })

                    ->addColumn('lead_name', function($row){
                        $name = (string) ($row->name ?? '');
                        if ($row->renewal_status != '') {
                            return htmlspecialchars($name, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8').' <sup class="fs-10">R</sup>';
                        }
                        return htmlspecialchars($name, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                    })

                    ->addColumn('email', function($row){
                        $flags = ENT_QUOTES | ENT_SUBSTITUTE;
                        return htmlspecialchars((string)($row->email ?? ''), $flags, 'UTF-8').'<br>'
                            .htmlspecialchars((string)($row->mobile ?? ''), $flags, 'UTF-8');
                    })

                    ->addColumn('type', function($row){
                        if (strtoupper($row->renewal_status) == 'RENEWAL') {
                            return '<span class="type-mark r" title="Renewal commission">R</span>';
                        }
                        return '<span class="type-mark i" title="First commission">I</span>';
                    })

                    ->addColumn('status', function($row){
                        return '<span class="pill won">Got Business</span>';
                    })

                    ->addColumn('amount_collected', function($row){
                        return '&#8377;'.number_format($row->amount_collected, 0, '.', ',');
                    })

                    ->addColumn('commission_amount', function($row){
                        return '<span class="num strong">&#8377;'.number_format($row->commission_amount, 0, '.', ',').'</span>';
                    })

                    ->addColumn('paid_amount', function($row){
                        return '<span class="num strong" style="color:#059669;">&#8377;'.number_format($row->paid_amount, 0, '.', ',').'</span>';
                    })

                    ->addColumn('aged', function($row){
                        if (!$row->created_at) return '<span class="days fresh"><span class="dot"></span>—</span>';
                        $days = Carbon::parse($row->created_at)->diffInDays(Carbon::now());
                        $cls  = 'fresh';
                        if ($days > 14)    $cls = 'cold';
                        elseif ($days > 7) $cls = 'stale';
                        return '<span class="days '.$cls.'"><span class="dot"></span>'.$days.'d</span>';
                    })

                    ->addColumn('pay_status', function($row){
                        return '<span class="pill paid">Paid</span>';
                    })

                    ->rawColumns(['partner','lead_name','email','type','status','amount_collected','commission_amount','paid_amount','balance','aged','pay_status'])
                    ->make(true);
    }

public function payoutHistory(Request $request)
    {
        $partners = Partner::whereIn('id', Lead::pluck('partner_id')->toArray())->pluck('name','id')->toArray();
		$lead_status = LeadStatus::all();

		$payout_counts = [
			'all'    => LeadCommission::count(),
			'paid'   => LeadCommission::where('payment_status', 1)->count(),
			'unpaid' => LeadCommission::where('payment_status', '!=', 1)->count(),
		];

		return view('admin.payouts_history', compact('partners','lead_status','payout_counts'));
    }


public function viewPaymentDetails(Request $request)  //payment history page
    {

		$statusFilter = $request->status_filter;
		$dateFrom     = $request->date_from;
		$dateTo       = $request->date_to;

		$data = LeadCommission::select('lead_commissions.*','leads.name','leads.mobile')
		->leftJoin('leads','lead_commissions.lead_id','=','leads.id')
		->where(function($q) use($request)
		{
			$request->partner_id !="" ? $q->where('lead_commissions.partner_id',$request->partner_id):'';
		})
		->when($statusFilter === 'paid', function($q) {
			$q->where('lead_commissions.payment_status', 1);
		})
		->when($statusFilter === 'unpaid', function($q) {
			$q->where('lead_commissions.payment_status', '!=', 1);
		})
		->when(!empty($dateFrom), function($q) use ($dateFrom) {
			$q->whereDate('lead_commissions.updated_at', '>=', $dateFrom);
		})
		->when(!empty($dateTo), function($q) use ($dateTo) {
			$q->whereDate('lead_commissions.updated_at', '<=', $dateTo);
		})
		->get();

		return Datatables::of($data)
				->addIndexColumn()
				->addColumn('name', function($row){
					$name     = (string) ($row->name ?? '');
					$words    = preg_split('/\s+/', trim($name));
					$initials = strtoupper(substr($words[0] ?? '', 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
					if ($initials === '') $initials = 'L';
					$colors = ['c1','c2','c3','c4','c5','c6'];
					$c = $colors[((int) ($row->lead_id ?? $row->id ?? 0)) % count($colors)];
					$flags = ENT_QUOTES | ENT_SUBSTITUTE;

					return '<div class="row-avatar">'
							.'<div class="av '.$c.'">'.htmlspecialchars($initials, $flags, 'UTF-8').'</div>'
							.'<div class="nm">'
								.'<div class="name">'.htmlspecialchars($name, $flags, 'UTF-8').'</div>'
								.(($row->mobile ?? '') !== '' ? '<div class="sub">'.htmlspecialchars((string)$row->mobile, $flags, 'UTF-8').'</div>' : '')
							.'</div>'
						.'</div>';
				})
				->addColumn('collected_amount', function($row){
					return '&#8377;'.number_format($row->amount_collected, 0, '.', ',');
				})
				->addColumn('commission', function($row){
					return '<span class="num strong">&#8377;'.number_format($row->commission_amount, 0, '.', ',').'</span>';
				})

				->addColumn('amount', function($row){
					return '<span class="num strong" style="color:#059669;">&#8377;'.number_format($row->paid_amount, 0, '.', ',').'</span>';
				})

				->addColumn('balance', function($row){
					$bal = (int) $row->balance;
					if ($bal === 0) {
						return '<span class="num muted">&#8377;0</span>';
					}
					return '<span class="num strong" style="color:#D97706;">&#8377;'.number_format($bal, 0, '.', ',').'</span>';
				})
				->addColumn('type', function($row){
                        if (strtoupper($row->renewal_status) == 'RENEWAL') {
                            return '<span class="type-mark r" title="Renewal commission">R</span>';
                        }
                        return '<span class="type-mark i" title="Initial commission">I</span>';
                    })

				->addColumn('updateAt', function($row){
                        if ($row->updated_at!="") {
                            return Carbon::parse($row->updated_at)->format('d-m-Y h:i A');
                        }
                        return '--';
                    })

				->addColumn('status', function($row){
					if ((int)$row->balance === 0) {
						return '<span class="pill paid">Paid</span>';
					}
					return '<span class="pill unpaid">Not Paid</span>';
				})

		->rawColumns(['name','status','collected_amount','commission','amount','balance','type'])
		->make(true);
    }


public function viewAllPaymentHistory(Request $request)
    {

		$dateFrom     = $request->date_from;
		$dateTo       = $request->date_to;

		$data = PaymentHistory::select('payment_histories.*','leads.name','leads.mobile','partners.name as partner_name')
		->leftJoin('leads','payment_histories.lead_id','=','leads.id')
		->leftJoin('partners','payment_histories.partner_id','=','partners.id')
		->where(function($q)use($request)
		{
			$request->partner_id !=0 ? $q->where('payment_histories.partner_id',$request->partner_id):'';
		})
		->when(!empty($dateFrom), function($q) use ($dateFrom) {
			$q->whereDate('payment_histories.payment_date', '>=', $dateFrom);
		})
		->when(!empty($dateTo), function($q) use ($dateTo) {
			$q->whereDate('payment_histories.payment_date', '<=', $dateTo);
		})
		->get()->map(function($q)
		{
			if($q->multiple_leads!=null)
			{
				$ids=explode(',',$q->multiple_leads);
				$lead=Lead::whereIn('id',$ids)->pluck('name')->toArray();
				$lead_names=implode(', ',$lead);
				$q['multiple_lead_name']=$lead_names;
			}
			return $q;
		});

		return Datatables::of($data)
				->addIndexColumn()

				->addColumn('partner_name', function($row){
					$name     = (string) ($row->partner_name ?? '');
					$words    = preg_split('/\s+/', trim($name));
					$initials = strtoupper(substr($words[0] ?? '', 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
					if ($initials === '') $initials = 'L';
					$colors = ['c1','c2','c3','c4','c5','c6'];
					$c = $colors[((int) ($row->lead_id ?? $row->id ?? 0)) % count($colors)];
					$flags = ENT_QUOTES | ENT_SUBSTITUTE;

					return '<div class="row-avatar">'
							.'<div class="av '.$c.'">'.htmlspecialchars($initials, $flags, 'UTF-8').'</div>'
							.'<div class="nm">'
								.'<div class="name">'.htmlspecialchars($name, $flags, 'UTF-8').'</div>'
							.'</div>'
						.'</div>';
				})

				->addColumn('name', function($row){
					$flags = ENT_QUOTES | ENT_SUBSTITUTE;

					if ($row->multiple_leads != null) {
						$label = (string) ($row->multiple_lead_name ?? '');
						return '<div class="lead-cell">'
								.'<div class="name">'.htmlspecialchars($label, $flags, 'UTF-8').'</div>'
								.'<div class="sub">Multiple leads</div>'
							.'</div>';
					}
					return htmlspecialchars((string) ($row->name ?? ''), $flags, 'UTF-8');
				})
				->addColumn('amount', function($row){
					return '<span class="num strong" style="color:#059669;">&#8377;'.number_format($row->paid_amount, 0, '.', ',').'</span>';
				})
				->addColumn('payment_date', function($row){
					if (!empty($row->payment_date))
						return Carbon::createFromFormat('Y-m-d',$row->payment_date)->format('d-m-Y');
					 return '';
				})
				->addColumn('status', function($row){
					return '<span class="pill paid">Paid</span>';
				})

				->addColumn('receipt', function($row){
					if ($row->receipt != '') {
						$href = url('/uploads/receipts').'/'.$row->receipt;
						return '<a href="'.$href.'" target="_blank" class="gl-btn gl-btn-outline gl-btn-sm" title="View receipt">'
								.'<i class="bx bx-receipt"></i> Receipt'
							.'</a>';
					}
					return '<span class="num muted">—</span>';
				})
		->rawColumns(['name','receipt','amount','status','partner_name'])
		->make(true);
    }

  //VERIFY PAYOUT ---------------------------------------------------------------------------------


public function verifyPayouts(Request $request)
    {
    
        $partners = Partner::whereIn('id',Lead::pluck('partner_id')->toArray())->pluck('name','id')->toArray();
		$lead_status = LeadStatus::all();
		return view('admin.verify_payouts_list',compact('partners','lead_status'));
    }

	public function verifyPayments(Request $request)
    {

		$data = PaymentVerify::select('payment_verify.*','leads.name as lead_name','leads.mobile','partners.name as partner_name','partners.company_name','partner_tiers.partner_tier')
		->leftJoin('leads','payment_verify.lead_id','=','leads.id')
		->leftJoin('partners','payment_verify.partner_id','=','partners.id')
		->leftJoin('partner_tiers','partners.partner_tier_id','=','partner_tiers.id')
		->where(function($q)use($request)
		{
			$request->partner_id !=0 ? $q->where('payment_verify.partner_id',$request->partner_id):'';
		})->orderBy('id','DESC')->get()->map(function($q)
		{
			if($q->multiple_leads!=null)
			{
				$ids=explode(',',$q->multiple_leads);
				$lead=Lead::whereIn('id',$ids)->pluck('name')->toArray();
				$lead_names=implode(', ',$lead);
				$q['multiple_lead_name']=$lead_names;
				$q['renewal_status']=null;
			}
			else
			{
				$rstatus=LeadCommission::where('lead_id',$q->lead_id)->where('payment_status',2)->pluck('renewal_status')->first();
				$q['renewal_status']=$rstatus;
			}
			return $q;
		});

		return Datatables::of($data)
				->addIndexColumn()
				->addColumn('partner_name', function($row){
					$name     = (string) ($row->partner_name ?? '');
					$words    = preg_split('/\s+/', trim($name));
					$initials = strtoupper(substr($words[0] ?? '', 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
					if ($initials === '') $initials = 'P';
					$colors = ['c1','c2','c3','c4','c5','c6'];
					$c = $colors[((int) $row->partner_id) % count($colors)];
					$flags = ENT_QUOTES | ENT_SUBSTITUTE;

					return '<div class="row-avatar">'
							.'<div class="av '.$c.'">'.htmlspecialchars($initials, $flags, 'UTF-8').'</div>'
							.'<div class="nm">'
								.'<div class="name">'.htmlspecialchars(strtoupper($name), $flags, 'UTF-8').'</div>'
								.'<div class="sub">'.$row->partner_tier.'</div>'
							.'</div>'
						.'</div>';
				})
				->addColumn('lead_name', function($row){
					if($row->multiple_leads!=null){
						return $row->multiple_lead_name;
					}
					else
					{
						if(strtoupper($row->renewal_status)=="RENEWAL")   
							return $row->lead_name.'&nbsp;<sup class="fs-10">R</sup>';
						else
							return $row->lead_name;
					}
				})
				->addColumn('total_collection', function($row){
					$camount="₹ ".number_format($row->collected_amount,'2','.','');
					return $camount;
				})
				->addColumn('amount', function($row){
					$amount="₹ ".number_format($row->commission,'2','.','');
					return $amount;
				})
				->addColumn('payment_date', function($row){
					if (!empty($row->payment_date))
						return Carbon::createFromFormat('Y-m-d',$row->payment_date)->format('d-m-Y');
					 return '';
				})
				->addColumn('view_leads', function($row){
					return '<a href="javascript:;" class="gl-btn gl-btn-outline gl-btn-sm btn-view-leads" '
							.'data-id="'.$row->id.'" data-leadid="'.$row->lead_id.'" '
							.'data-bs-toggle="modal" data-bs-target="#view-payment-leads-modal" title="View leads">'
							.'<i class="bx bx-show"></i> View'
						.'</a>';
				})

				->addColumn('pay_status', function($row){
					if (strtoupper((string)$row->payment_status) === 'PAID') {
						return '<span class="pill paid">Paid</span>';
					}
					return '<span class="pill unpaid">'.htmlspecialchars((string)$row->payment_status, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8').'</span>';
				})

				->addColumn('verify_status', function($row){
					if (strtoupper((string)$row->verify_status) === 'VERIFIED') {
						return '<span class="pill paid">Verified</span>';
					}
					return '<button class="gl-btn gl-btn-primary gl-btn-sm btn-verify" data-id="'.$row->id.'" title="Mark as verified">'
							.'<i class="bx bx-check"></i> Verify'
						.'</button>';
				})

				/*->addColumn('action', function($row)
					{
					   $action='<button id="btn-verify" class="btn btn-primary btn-sm" data-id="'.$row->id.'"> Verify </button>';
					return $action;
					})
					*/

			->rawColumns(['partner_name','lead_name','view_leads','verify_status','pay_status'])
		->make(true);
    }

public function updatePaymentVerifyStatus($id)
{
	$pver=PaymentVerify::where('id',$id)->first();
	if($pver)
	{
		$pver->verify_status="Verified";
		$pver->save();
		return true;
	}
	else
	{
		return false;
	}
}

public function getPaymentsLeadsList($pid)  //to display payments leads details
{

	$pver=PaymentVerify::where('id',$pid)->first();
	if($pver)
	{
		if($pver->lead_id==null)
			$leadIds = explode(',', $pver->multiple_leads);
		else
			$leadIds = explode(',', $pver->lead_id);

		$partnerId=$pver->partner_id;

		$data = LeadCommission::select('lead_commissions.*','leads.name','leads.mobile','leads.email','partners.name as partner_name','partners.commission_percentage')
		->leftJoin('leads','lead_commissions.lead_id','=','leads.id')
		->leftJoin('partners','leads.partner_id','=','partners.id')
		->whereIn('lead_commissions.lead_id',$leadIds)
		->where('lead_commissions.partner_id',$partnerId)
		->where('lead_commissions.lead_status',"Got Business")
		->latest()->get();
	  return view('admin.view_payment_leads_modal',compact('data'));

	}

}


//PAY VERIFIED PAYMENTS-------------------------------------------------------------

public function payVerifiedPayments(Request $request)
    {
    
        $partners = Partner::whereIn('id',Lead::pluck('partner_id')->toArray())->pluck('name','id')->toArray();
		$lead_status = LeadStatus::all();
		return view('admin.pay_verified_payments',compact('partners','lead_status'));
    }

	public function viewVerifiedPaymentsList(Request $request)
    {

		$data = PaymentVerify::select('payment_verify.*','leads.name as lead_name','leads.mobile','partners.name as partner_name','partners.company_name','partner_tiers.partner_tier')
		->leftJoin('leads','payment_verify.lead_id','=','leads.id')
		->leftJoin('partners','payment_verify.partner_id','=','partners.id')
		->leftJoin('partner_tiers','partners.partner_tier_id','=','partner_tiers.id')
		->where('verify_status','Verified')
		->where(function($q)use($request)
		{
			$request->partner_id !=0 ? $q->where('payment_verify.partner_id',$request->partner_id):'';
		})->orderBy('id','DESC')->get()->map(function($q)
		{
			if($q->multiple_leads!=null)
			{
				$ids=explode(',',$q->multiple_leads);
				$lead=Lead::whereIn('id',$ids)->pluck('name')->toArray();
				$lead_names=implode(', ',$lead);
				$q['multiple_lead_name']=$lead_names;
			}
			return $q;
		});

		return Datatables::of($data)
				->addIndexColumn()

				->addColumn('partner_name', function($row){
					$name     = (string) ($row->partner_name ?? '');
					$words    = preg_split('/\s+/', trim($name));
					$initials = strtoupper(substr($words[0] ?? '', 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
					if ($initials === '') $initials = 'P';
					$colors = ['c1','c2','c3','c4','c5','c6'];
					$c = $colors[((int) $row->partner_id) % count($colors)];
					$flags = ENT_QUOTES | ENT_SUBSTITUTE;

					return '<div class="row-avatar">'
							.'<div class="av '.$c.'">'.htmlspecialchars($initials, $flags, 'UTF-8').'</div>'
							.'<div class="nm">'
								.'<div class="name">'.htmlspecialchars(strtoupper($name), $flags, 'UTF-8').'</div>'
								.'<div class="sub">'.$row->partner_tier.'</div>'
							.'</div>'
						.'</div>';
				})

				->addColumn('lead_name', function($row){
					if($row->multiple_leads!=null)
						return $row->multiple_lead_name;
					else
						return $row->lead_name;
				})

				->addColumn('total_collection', function($row){
					return '&#8377;'.number_format($row->collected_amount, 0, '.', ',');
				})
				->addColumn('amount', function($row){
					return '<span class="num strong">&#8377;'.number_format($row->commission, 0, '.', ',').'</span>';
				})
				->addColumn('payment_date', function($row){
					 if (!empty($row->payment_date))
						return Carbon::createFromFormat('Y-m-d',$row->payment_date)->format('d-m-Y');
					 return '';
				})
				->addColumn('view_leads', function($row){
					return '<a href="javascript:;" class="gl-btn gl-btn-outline gl-btn-sm btn-view-leads" '
							.'data-id="'.$row->id.'" data-leadid="'.$row->lead_id.'" '
							.'data-bs-toggle="modal" data-bs-target="#view-payment-leads-modal" title="View leads">'
							.'<i class="bx bx-show"></i> View'
						.'</a>';
				})

				->addColumn('pay_status', function($row){
					if (strtoupper((string)$row->payment_status) === 'PAID') {
						return '<span class="pill paid">Paid</span>';
					}
					return '<span class="pill unpaid">'.htmlspecialchars((string)$row->payment_status, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8').'</span>';
				})

				->addColumn('verify_status', function($row){
					return '<span class="pill paid">Verified</span>';
				})

				->addColumn('action', function($row){
					if ($row->receipt != '' && $row->payment_status == 'Paid') {
						$href = url('/uploads/receipts').'/'.$row->receipt;
						return '<a href="'.$href.'" target="_blank" class="gl-btn gl-btn-outline gl-btn-sm" title="Download receipt">'
								.'<i class="bx bx-receipt"></i> Receipt'
							.'</a>';
					}
					return '<button class="gl-btn gl-btn-primary gl-btn-sm btn-pay" '
							.'data-id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#set-payment-modal" title="Set payout">'
							.'<i class="bx bx-rupee"></i> Pay'
						.'</button>';
				})

			->rawColumns(['partner_name','action','view_leads','pay_status','verify_status','total_collection','amount'])
		->make(true);
    }


	public function getPaymentDetails($vpid)
	{
		$ce=PaymentVerify::whereId($vpid)->first();
		
		$partner=Partner::where('id',$ce->partner_id)->first();
		$payment=PaymentVerify::where('id',$vpid)->first();
		$lead_status = LeadStatus::all();
		$pid=$ce->partner_id;
		$tot_paid=PaymentHistory::totalPayout($pid);
		
		if($ce->lead_id==null)
			$leadIds=explode(',',$ce->lead_id);
		else
			$leadIds=explode(',',$ce->multiple_leads);

		$leadCommIds=LeadCommission::whereIn('lead_id',$leadIds)->pluck('id')->toArray();
		
		return view('admin.set_payment_modal',compact('lead_status','payment','partner','pid','vpid','leadCommIds'));

	}
	

  
public function savePayout(Request $request)
{
	
	DB::beginTransaction();
	
	try
	{

			$fileName='';
			if($request->file('payment_receipt'))
			{
				$fileName = "rec_".time().'.'.$request->payment_receipt->extension();  
				$request->payment_receipt->move(public_path('uploads/receipts/'), $fileName);
			}

			$vpid=$request->verified_payment_id;
			$pver=PaymentVerify::where('id',$vpid)->first();
			$collected_amount=$pver->collected_amount;
			
			//$lcids=explode(',',substr($request->lead_commission_id,1));

			$leadIds=($pver->lead_id==null)?$pver->multiple_leads:$pver->lead_id;
			$lead_ids=explode(',',$leadIds);
			$lcids=LeadCommission::whereIn('lead_id',$lead_ids)->pluck('id')->toArray();
	
			if(!empty($lcids) and count($lcids)==1)		
			{
				
				$id=$lcids[0];
				$leadC=LeadCommission::whereId($id)->first();

					$leadC->paid_amount=$request->pay_amount;
					$leadC->payment_date=date('Y-m-d h:i:s');
					$leadC->balance=0;
					$leadC->payment_status=1;
					$leadC->save();

					$ld=Lead::whereId($leadC->lead_id)->first();
					$ld->payment_status=1;
					$ld->save();
				
				$pvRessult=PaymentVerify::where('id',$vpid)->update([
								'payment_status'=>"Paid",
								'paid_amount'=>$request->pay_amount,
								'payment_date' => $request->payment_date,
								'payment_id' => $request->payment_id,
								'receipt'=>$fileName,
								]);
								
				$result=PaymentHistory::create([
					'lead_id' => $leadC->lead_id,
					'partner_id' => $request->pay_partner_id,
					'collected_amount' => $leadC->amount_collected,
					'commission' => $request->pay_amount,
					'paid_amount' => $request->pay_amount,
					'payment_date' => $request->payment_date,
					'payment_id' => $request->payment_id,
					'description'=>$request->description,
					'receipt'=>$fileName,
				]);
				
			}
			else if(!empty($lcids))
			{

				$leadC=LeadCommission::whereIn('id',$lcids)->get();
				foreach($leadC as $row)
				{
					$row->paid_amount=$row->commission_amount;
					$row->payment_date=date('Y-m-d h:i:s');
					$row->balance=0;
					$row->payment_status=1;
					$row->save();
				
					$ld=Lead::whereId($row->lead_id)->first();
					$ld->payment_status=1;
					$ld->save();
				}
				
				$pvRessult=PaymentVerify::where('id',$vpid)->update([
								'payment_status'=>"Paid",
								'paid_amount'=>$request->pay_amount,
								'payment_date' => $request->payment_date,
								'payment_id' => $request->payment_id,
								'receipt'=>$fileName,
								]);

				$result=PaymentHistory::create([
					'lead_id' => null,
					'multiple_leads'=>$leadIds,
					'partner_id' => $request->pay_partner_id,
					'collected_amount' => $collected_amount,
					'commission' => $request->pay_amount,
					'paid_amount' => $request->pay_amount,
					'payment_date' => $request->payment_date,
					'payment_id' => $request->payment_id,
					'description'=>$request->description,
					'receipt'=>$fileName,
				]);

			}
					
			DB::commit();
			
			if($result)
			{
				
				$partner=Partner::where('id',$request->pay_partner_id)->first();
				//-- general notification ----
				$msg="Hi,".$partner->name.", Your commission Rs. ".$request->pay_commission." credited to your account on ".$request->payment_date.", Thank You!";
				$ndat=['notification'=>$msg, 'partner_id'=>$request->pay_partner_id,'category'=>2,'status'=>0];
				Notification::create($ndat);
				//--------------------------
						
			Session::flash('success',"Payment successfully completed!");

			}
			else
			{
				DB::rollback();
				Session::flash('error',"Something wrong, Please try again.");
			}

		}catch(\Exception $e)
		{
			DB::rollback();
			\Log::info($e->getMessage());
			Session::flash('error',$e->getMessage());
			//return response()->json(['status'=>false,'msg'=>$e->getMessage()]);
		}

	return redirect('admin/pay-verified-payments');
		
}

  
 // PAY PARTNR PAYMENT PAGE---------------------------------
 
  public function payPartnerPayment($pid)
  {
    $partner=Partner::where('id',$pid)->first();
	$total=LeadCommission::selectRaw('SUM(commission_amount) as sum_commission, SUM(balance) as sum_balance')->where('partner_id',$pid)->first();
	$lead_status = LeadStatus::all();
	$tot_paid=PaymentHistory::totalPayout($pid);
	return view('admin.payouts',compact('lead_status','total','tot_paid','partner','pid'));
  }
   
  
  public function gotBusinessPartnerUnpaidLeads($id)
  {
	$data = LeadCommission::select('lead_commissions.*','leads.name','leads.mobile','leads.email','partners.name as partner_name','partners.commission_percentage')
	->leftJoin('leads','lead_commissions.lead_id','=','leads.id')
	->leftJoin('partners','leads.partner_id','=','partners.id')
	->where('lead_commissions.partner_id',$id)
	->where('lead_commissions.lead_status',"Got Business")
	->whereIn('lead_commissions.payment_status',[0,2])
	->where('lead_commissions.balance','!=',0)
	->latest()->get();


	return Datatables::of($data)
		->addIndexColumn()
		
		->addColumn('chkbox', function($row){
			$chk="<input type='checkbox' class='selbox' data-leadid='".$row->lead_id."' style='width:20px;height:20px;vertical-align: middle;'>";
			return $chk;
		})
		
		->addColumn('name', function($row){
			
			if($row->renewal_status!='')
				$nam=$row->name.'&nbsp;<sup class="fs-10">R</sup>';
			else
				$nam=$row->name;
			return $nam;
		})
				
		->addColumn('amount_collected', function($row){
			$col_amount=number_format($row->amount_collected,'2','.','');
			return $col_amount;
		})
		->addColumn('commission_amount', function($row){
			$com_amount=number_format($row->commission_amount,'2','.','');
			return $com_amount;
		})
		
		->addColumn('amount', function($row){
			$paid_amt=number_format($row->paid_amount,'2','.','');
			return $paid_amt;
		})
		
		->addColumn('balance', function($row){

			$bal_amount=number_format($row->balance,'2','.','');
					return $bal_amount;
		})
		
		->addColumn('status', function($row){
			$lst='<span style="color:green;">'.$row->lead_status.'</span>';
			return $lst;
		})

		->addColumn('email', function($row)
		{
			$email = $row->email.'<br/>';
			$email .= $row->mobile;
			return $email;
		})
		->rawColumns(['chkbox','name','email','status','pay_status'])
		->make(true);
 }

  
 public function viewPartnerPaymentHistory($id)
    {

		$data = PaymentHistory::select('payment_histories.*','leads.name','leads.mobile')
		->leftJoin('leads','payment_histories.lead_id','=','leads.id')
		->where('payment_histories.partner_id',$id)->get()->map(function($q)
		{
			if($q->multiple_leads!=null)
			{
				$ids=explode(',',$q->multiple_leads);
				$lead=Lead::whereIn('id',$ids)->pluck('name')->toArray();
				$lead_names=implode(', ',$lead);
				$q['multiple_lead_name']=$lead_names;
			}
			return $q;
		});

		return Datatables::of($data)
				->addIndexColumn()
				->addColumn('name', function($row){
					if($row->multiple_leads!=null)
						return $row->multiple_lead_name;
					else
						return $row->name;
				})
				->addColumn('commission', function($row){
					$amount=number_format($row->commission,'2','.','');
					return $amount;
				})
				->addColumn('paid_amount', function($row){
					$amount=number_format($row->paid_amount,'2','.','');
					return $amount;
				})
				->addColumn('payment_date', function($row){
					
					$date=Carbon::createFromFormat('Y-m-d',$row->payment_date)->format('d-m-Y');
					return $date;
				})
				->addColumn('receipt', function($row){
					
					if($row->receipt!="")
					{
						$url='<a href="'.url('/uploads/receipts')."/".$row->receipt.'" target="_blank">view</a>';
					}
					else
					{
						$url='--';
					}
					return $url;
				})
		->rawColumns(['receipt'])
		->make(true);
    }

 
public function preparePayout(Request $request)   //prepare payout for veification
{
	
	DB::beginTransaction();
	
	try
		{

			$lcids=explode(',',substr($request->lead_commission_id,1));

			if(!empty($lcids) and count($lcids)==1)		
			{
				
				$id=$lcids[0];
				$leadC=LeadCommission::whereId($id)->first();
				$leadC->paid_amount=$request->pay_amount;
				$leadC->balance=0;
					$leadC->payment_status=2;
					$leadC->save();
					
					$ld=Lead::whereId($leadC->lead_id)->first();
					$ld->payment_status=2;
					$ld->save();
				
				$result=PaymentVerify::create([
					'lead_id' => $leadC->lead_id,
					'partner_id' => $request->pay_partner_id,
					'collected_amount' => $request->collected_amount,
					'commission' => $request->commission_amount,
					'paid_amount' => Null,
					'payment_date' => null,
					'payment_id' => null,
					'description'=>$request->description,
					'receipt'=>null,
				]);
				
			}
			else if(!empty($lcids))
			{

				$leadC=LeadCommission::whereIn('id',$lcids)->get();
				foreach($leadC as $row)
				{
					$row->paid_amount=$row->balance;
					$row->balance=0;

					$row->payment_status=2;
					$row->save();
				
					$ld=Lead::whereId($row->lead_id)->first();
					$ld->payment_status=2;
					$ld->save();
				}
				
				$result=PaymentVerify::create([
					'lead_id' => null,
					'multiple_leads'=>substr($request->lead_ids,1),
					'partner_id' => $request->pay_partner_id,
					'collected_amount' => $request->collected_amount,
					'commission' => $request->pay_amount,
					'paid_amount' => Null,
					'payment_date' => null,
					'payment_id' => null,
					'description'=>$request->description,
					'receipt'=>null,
				]);
			}
					
			DB::commit();
			
			if($result)
			{
				return response()->json(['status'=>true,'msg'=>'Payment successfully submited!']);
			}
			else
			{
				DB::rollback();
				return response()->json(['status'=>false,'msg'=>'Something wrong, Please try again.']);
			}

		}catch(\Exception $e)
		{
			DB::rollback();
			\Log::info($e->getMessage());
			return response()->json(['status'=>false,'msg'=>$e->getMessage()]);
		}
		
}

public function updateLeadPaymentStatus(Request $request)
    {
        $lead = Lead::where('id',$request->lead_id)->first();
        $lead->payment_status = trim($request->pay_status);
        $lead->save();
        return response()->json(['status'=>1,'msg'=>'Lead payment status updated !!!']);
    }


// NOTIFICATIONS ----------------------------------------------------------

public function notifications()
{
    return view('admin.notification_list');
}
	
public function notificationList(Request $request)
    {
        if ($request->ajax()) {
        $dateFrom = $request->date_from;
        $dateTo   = $request->date_to;

        $data = Notification::select('notifications.*','partners.name')
		->leftJoin('partners','notifications.partner_id','=','partners.id')
		->when(!empty($dateFrom), function($q) use ($dateFrom) {
			$q->whereDate('notifications.created_at', '>=', $dateFrom);
		})
		->when(!empty($dateTo), function($q) use ($dateTo) {
			$q->whereDate('notifications.created_at', '<=', $dateTo);
		})
		->latest()
		->get();

        return Datatables::of($data)
                    ->addIndexColumn()
					->addColumn('cdate', function($row){
                        if (!$row->created_at) return '—';
                        try {
                            //return Carbon::parse($row->created_at)->diffForHumans();
						return Carbon::parse($row->created_at)->format('Y-m-d h:i A');
                        } catch (\Exception $e) {
                            return $row->created_at;
                        }
                    })
					->addColumn('status', function($row){
                        if ((int)$row->status === 0) {
                            return '<span class="pill new">New</span>';
                        }
                        return '<span class="pill read">Read</span>';
                    })

					->addColumn('addedby', function($row){
                        if ((int)$row->category === 1) {
                            return '<span class="pill admin">Getlead</span>';
                        }
                        return '<span class="pill partner">'.htmlspecialchars((string)($row->name ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8').'</span>';
                    })

                    ->addColumn('action', function($row){
                        return '<div class="row-action">'
                                .'<button type="button" class="row-action-btn danger confirm_deletion" data-id="'.$row->id.'" title="Delete notification">'
                                    .'<i class="bx bx-trash"></i>'
                                .'</button>'
                            .'</div>';
                    })
                    ->rawColumns(['action','status','addedby'])
                    ->make(true);
        }

    }

	
public function deleteNotification($id)
{
	$res=Notification::whereId($id)->delete();
    return response()->json(['status'=>1]);
}
	

public function notificationStatus()
{
	$noti=NotificationStatus::where('admin_id',Auth::guard('admin')->user()->id)->first();
	if(empty($noti)){$noti=new NotificationStatus();};
	return view('partials.notification_settings',compact('noti'));
}	


public function notificationSettings()
{
	return view('admin.notification-settings');
}	


public function changeNotificationStatus(Request $request)
{
	$ema=$request->email_status;
	$wapp=$request->wapp_status;
	$tele=$request->tele_status;
	
	try{
		
		$id=Auth::guard('admin')->user()->id;
		
		$dat1=['admin_id'=>$id,'email_status'=>$ema,'whatsapp_status'=>$wapp,'telegram_status'=>$tele];
		$dat2=['email_status'=>$ema,'whatsapp_status'=>$wapp,'telegram_status'=>$tele];
			
		$ncnt=NotificationStatus::whereId($id)->count();
		if($ncnt<=0)
		{
			$result=NotificationStatus::create($dat1);
		}
		else
		{
			$result=NotificationStatus::where('admin_id',$id)->update($dat2);
		}
	
	   if($result)
		{
			return response()->json(['status'=>1,'msg'=>"Notification status changed!"]);
		}
		else
		{
			return response()->json(['status'=>0,'msg'=>"Something wrong, Please check."]);
		}
		
	}
	catch(\Exception $e)
	{
		\Log::info($e->getMessage());
		return response()->json(['status'=>0,'msg'=>"Something wrong, Try agin."]);
	}
		
}

 
public function setNotificationsAsRead()
{
	$new=['status'=>1];
	$result=Notification::where('status',0)->update($new);
	return response()->json(['status'=>1]);
}	

public function getLatestNotifications() //master page notifications top bar
{
	$noti=Notification::latest()->where('status',0)->take(10)->get();
	$noti_count=Notification::where('status',0)->count();
	
	$noti_data="";
	foreach($noti as $r)
	{
		$noti_data.='<a href="'.url('admin/notifications').'" >
						<div style="padding:3px 10px;border-bottom:1px solid #e4e4e4;">
							<div style="padding:0px;font-size:12px;">'.$r->notification.
							'</div>
							<div style="padding:0px;font-size:10px;text-align:right;">'.$r->created_at.
							'</div>
						</div>
					</a>';
	}
	return response()->json(['status'=>1,"data"=>$noti_data,"noti_count"=>$noti_count]);
}



  public function integrations(Request $request)
    {
        return view('admin.integrations');
    }


	public function developerApi(Request $request)
    {
        return view('admin.developer_api');
    }

	
	public function settings(Request $request)
    {
		$noti=NotificationStatus::where('admin_id',Auth::guard('admin')->user()->id)->first();
		if(empty($noti)){$noti=new NotificationStatus();};
		
		$lstatus=LeadStatus::all();
		$ptiers=PartnerTier::all();
		$products = ProductAndService::all();
		$ams=AdminMessageSetting::whereId(1)->first();
        return view('admin.settings_new',compact('noti','lstatus','ptiers','products','ams'));
    }


    public function listProductServices()
    {
        $data = ProductAndService::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<button type="button" class="btn btn-default btn-circle edit_product_service" data-id="'.$row->id.'"><i class="fa fa-pencil"></i></button>';
                            return $btn;
                    })
                    ->addColumn('plan_type', function($row){
                        if($row->type == 1)
                        {
                            return "Product";
                        }
                        else{
                            return "Service";
                        }
                    })
                    ->addColumn('plan_status', function($row){
                        if($row->status == 1)
                        {
                            return "Active";
                        }
                        else{
                            return "Inactive";
                        }
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }

    public function deleteLead(Request $request)
    {
         Lead::where('id',$request->lead_id)->first()->delete();
         return response()->json(['status'=>1]);
    }
   
//settings -------------------------------------------------------------------------------------------------------

public function changePassword(Request $request)
{

	$id = Auth::guard('admin')->user()->id;
	$admin = Admin::where('id',$id)->first();

	if(Hash::check($request->current_password, $admin->password))
	{
		$admin->password = \Hash::make($request->new_password);
		$admin->save();

		return response()->json(['status'=>1,'msg'=>'Password updated succesfully !!!']);
	}
	else
	{
		return response()->json(['status' => 0, 'msg' => 'Current password does not match !!!']);
	}
}


//lead status ---------------------------------------------------------------

public function saveLeadStatus(Request $request)
{
	$result=LeadStatus::create([
		'lead_status'=>$request->lead_status,
	]);
	
	if($result)
	{
		return response()->json(['status'=>1,'id'=>$result->id,'msg'=>"Status successfully added!"]);
	}
	else
	{
		return response()->json(['status'=>0,'msg'=>"Something wrong, Please check."]);
	}
}

public function deleteLeadStatus($id)
{
	$result=LeadStatus::whereId($id)->delete();
	return response()->json(['status'=>1,'msg'=>"Status successfully removed!"]);
}
  
//NEWS -----------------------------------------------------------------------------

public function news()
{
   return view('admin.news');
}

public function addNews()
{
   return view('admin.add_news');
}

public function getNewsList()
    {
        $data = News::latest()->get();

        return Datatables::of($data)
                ->addIndexColumn()
				->addColumn('news_content', function($row)
				{
                    $cont=Str::substr($row->news_content,0,300);
					return $cont;
                })
				
				->addColumn('action', function($row)
				{
                    return '<div class="row-action">'
                            .'<a href="'.route('admin.edit-news', $row->id).'" class="row-action-btn" title="Edit"><i class="bx bx-pencil"></i></a>'
                            .'<button type="button" class="row-action-btn danger confirm_deletion" data-id="'.$row->id.'" title="Delete"><i class="bx bx-trash"></i></button>'
                        .'</div>';
                })
                ->rawColumns(['action'])
                ->make(true);
    }
  
public function createNews(Request $request)
    {
	
		try
		{
				$lead = new News();
				$lead->title = $request->title;
				$lead->news_content = $request->news_content;
				$result=$lead->save();
		}
		catch(\Exception $e)
		{
			\Log::info($e->getMessage());
			return response()->json(['status'=>0,'msg'=>$e->getMessage()]);
		}
		
		return redirect()->route('admin.news')->with('success','News successfully added!');; 
    }  

public function editNews($id)
{
	$nws=News::where('id',$id)->first();
	return view('admin.edit_news',compact('nws'));
}

public function updateNews(Request $request)
{
	$news=News::where('id',$request->news_id)->first();
	
	$news->title=$request->title;
	$news->news_content=$request->news_content;
	$result=$news->save();
	
	return redirect()->route('admin.news')->with('success','News has been updated successfully!');
}

public function deleteNews(Request $request)
{
	$news=News::where('id',$request->news_id)->delete();
	return response()->json(['status'=>1]);
}

   
// export partner details ----------------------------------------------------


public function exportPartnerList(Request $request)
	{
        $filters = [
            'status'   => $request->query('status', ''),
            'tier'     => $request->query('tier', ''),
            'agent_id' => $request->query('agent_id', ''),
            'activity' => $request->query('activity', ''),
        ];
        return Excel::download(new partnerExport($filters), 'partner_list_'.date('Y-m-d').'.xlsx');
    }

public function exportPartnersActivity(Request $request)
	{
        $filters = [
            'partner_id' => $request->query('partner_id', ''),
            'date_from'  => $request->query('date_from', ''),
            'date_to'    => $request->query('date_to', ''),
        ];
        return Excel::download(new partnerActivityExport($filters), 'partners_activity_list_'.date('Y-m-d').'.xlsx');
    }

 public function exportLeadList(Request $request)
	{
        $status     = $request->query('status', 'All') ?: 'All';
        $partner    = $request->query('partner', 'All') ?: 'All';
        $pay_status = $request->query('payment', 'All') ?: 'All';
        $age        = $request->query('age', '') ?: '';
        return Excel::download(new leadsExport($status, $partner, $pay_status, $age), 'leads_list_'.date('Y-m-d').'.xlsx');
    }

 public function exportPayoutDetails(Request $request)
    {
        $filters = [
            'partner_id'    => $request->query('partner_id', ''),
            'status_filter' => $request->query('status_filter', ''),
            'date_from'     => $request->query('date_from', ''),
            'date_to'       => $request->query('date_to', ''),
        ];
        return Excel::download(new payoutDetailsExport($filters), 'payout_details_'.date('Y-m-d').'.xlsx');
    }

 public function exportPaymentHistory(Request $request)
    {
        $filters = [
            'partner_id' => $request->query('partner_id', ''),
            'date_from'  => $request->query('date_from', ''),
            'date_to'    => $request->query('date_to', ''),
        ];
        return Excel::download(new paymentHistoryExport($filters), 'payment_history_'.date('Y-m-d').'.xlsx');
    }
 
 
 // business category -----------------------------------------------------------
 
 
  public function listBusinessCategory(Request $request)
    {
            $data = BussinessCategory::all();

            return Datatables::of($data)
                    ->addIndexColumn()
                    
                     ->addColumn('action', function($row){

							$btn = '<div class="btn-group">
							<button type="button" class="btn btn-outline edit-business" id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#edit-business-category" ><i class="fa fa-pencil"></i></button>
							
							<button type="button" class="btn btn-outline dropdown-toggle"
							data-bs-toggle="dropdown">
							<i class="fa fa-trash"></i>
						</button>
					
						<ul class="dropdown-menu pull-right" role="menu">
							<li class="text-center mb-2"><a href="#">Confirm Deletion</a></li>
							<li class="divider"></li>
							<li style="display: flex;align-items:center;justify-content:center;" class="confirm_buttons">
							<button type="button" class="btn btn-success btn-outline ok_btn confirm-business-deletion" id="'.$row->id.'"><i class="fa fa-check"></i></button>&nbsp;
							<button type="button" class="btn btn-danger btn-outline no_btn"><i class="fa fa-times"></i></button>
							</li>
						</ul>
						</div>';

                      return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }

 
 public function saveBusinessCategory(Request $request)   //product and services
 {
	 
	try
		{
			$result=BussinessCategory::create([
				'bussiness_category_name' => $request->business_category_name,
				'status' =>1,
			]);
			
			if($result)
			{
				return response()->json(['status'=>1,'data'=>$result,'msg'=>"Business category successfully added!"]);
			}
			else
			{
				return response()->json(['status'=>0,'msg'=>"Something wrong, Please check."]);
			}

		}catch(\Exception $e)
		{
			\Log::info($e->getMessage());
			return response()->json(['status'=>0,'msg'=>$e->getMessage()]);
		} 
	 
 }
 
 public function updateBusinessCategory(Request $request)   //product and services
 {
	 
	try
		{
			$bcat=BussinessCategory::where('id',$request->bcat_id_edit)->first();
			
				$bcat->bussiness_category_name = $request->business_category_name_edit;
				$result=$bcat->save();
				
				return response()->json(['status'=>1,'msg'=>"Business category successfully updated!"]);

		}catch(\Exception $e)
		{
			\Log::info($e->getMessage());
			return response()->json(['status'=>0,'msg'=>$e->getMessage()]);
		} 
	 
 }
 
 public function deleteBusinessCategory($id)
 {
    BussinessCategory::where('id',$id)->first()->delete();
    return response()->json(['status'=>1,'msg'=>"Business category successfully removed!"]);
 }
 //Partner Tiers -----------------------------------------

 public function savePartnerTier(Request $request)
 {
	try
		{
			$result=PartnerTier::create([
				'partner_tier' => $request->partner_tier,
				'tier_color' => $request->tier_color_text,
			]);

			if($result)
			{
				return response()->json(['status'=>1,'data'=>$result,'msg'=>"Partner tier successfully added!"]);
			}
			else
			{
				return response()->json(['status'=>0,'msg'=>"Something wrong, Please check."]);
			}

		}catch(\Exception $e)
		{
			\Log::info($e->getMessage());
			return response()->json(['status'=>0,'msg'=>$e->getMessage()]);
		}
 }

 public function editPartnerTier($id)
 {
	$tier = PartnerTier::find($id);
	if (!$tier) {
		return response()->json(['status'=>0,'msg'=>'Tier not found.']);
	}
	return response()->json(['status'=>1,'data'=>$tier]);
 }

 public function updatePartnerTier(Request $request)
 {
	try
		{
			$tier = PartnerTier::find($request->tier_id);
			if (!$tier) {
				return response()->json(['status'=>0,'msg'=>'Tier not found.']);
			}

			$tier->partner_tier = $request->partner_tier;
			$tier->tier_color   = $request->tier_color_text;
			$tier->save();

			return response()->json(['status'=>1,'data'=>$tier,'msg'=>'Partner tier updated!']);

		}catch(\Exception $e)
		{
			\Log::info($e->getMessage());
			return response()->json(['status'=>0,'msg'=>$e->getMessage()]);
		}
 }

 public function deletePartnerTier($id)
 {
	try
		{
			// Block deletion if any partner is still assigned to this tier
			$inUse = Partner::where('partner_tier_id', $id)->count();
			if ($inUse > 0) {
				return response()->json(['status'=>0,'msg'=>'Cannot delete — '.$inUse.' partner(s) are assigned to this tier.']);
			}

			$res = PartnerTier::whereId($id)->delete();
			if ($res) {
				return response()->json(['status'=>1,'msg'=>'Partner tier removed!']);
			}
			return response()->json(['status'=>0,'msg'=>'Tier not found.']);

		}catch(\Exception $e)
		{
			\Log::info($e->getMessage());
			return response()->json(['status'=>0,'msg'=>$e->getMessage()]);
		}
 }
 
 
// product and services plans -------------------------------

 
  public function listProductPlans(Request $request)
    {
            $data = ProductAndService::all();

            return Datatables::of($data)
                    ->addIndexColumn()
                    
                     ->addColumn('action', function($row){

							$btn = '<div class="btn-group">
							<button type="button" class="btn btn-outline edit-plan" id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#edit-plan-modal" ><i class="fa fa-pencil"></i></button>
							
							<button type="button" class="btn btn-outline dropdown-toggle"
							data-bs-toggle="dropdown">
							<i class="fa fa-trash"></i>
						</button>
					
						<ul class="dropdown-menu pull-right" role="menu">
							<li class="text-center mb-2"><a href="#">Confirm Deletion</a></li>
							<li class="divider"></li>
							<li style="display: flex;align-items:center;justify-content:center;" class="confirm_buttons">
							<button type="button" class="btn btn-success btn-outline ok_btn confirm-plan-deletion" id="'.$row->id.'"><i class="fa fa-check"></i></button>&nbsp;
							<button type="button" class="btn btn-danger btn-outline no_btn"><i class="fa fa-times"></i></button>
							</li>
						</ul>
						</div>';

                      return $btn;
                    })
                      ->rawColumns(['pay_status','email','status','action'])
                      ->make(true);
    }



 public function savePlan(Request $request)   //product and services
 {
	 
	try
		{
			$result=ProductAndService::create([
				'plan_name' => $request->plan_name,
				'type' => $request->plan_type,
				'users' => $request->users,
				'month'=>$request->month,
				'pricing' => $request->price,
				'status' =>1,
			]);
			
			if($result)
			{
				return response()->json(['status'=>1,'data'=>$result,'msg'=>"Product plan successfully added!"]);
			}
			else
			{
				return response()->json(['status'=>0,'msg'=>"Something wrong, Please check."]);
			}

		}catch(\Exception $e)
		{
			\Log::info($e->getMessage());
			return response()->json(['status'=>0,'msg'=>$e->getMessage()]);
		} 
	 
 }
 
 public function updatePlan(Request $request)   //product and services
 {
	 
	try
		{
			$plan=ProductAndService::where('id',$request->plan_id_edit)->first();
			
				$plan->plan_name = $request->plan_name_edit;
				$plan->type = $request->plan_type_edit;
				$plan->users= $request->users_edit;
				$plan->month=$request->month_edit;
				$plan->pricing = $request->price_edit;
				$result=$plan->save();
				
				return response()->json(['status'=>1,'msg'=>"Product plan successfully updated!"]);

		}catch(\Exception $e)
		{
			\Log::info($e->getMessage());
			return response()->json(['status'=>0,'msg'=>$e->getMessage()]);
		} 
	 
 }
 
 public function deletePlan($id)
 {
    ProductAndService::where('id',$id)->first()->delete();
    return response()->json(['status'=>1,'msg'=>"Product and service plan successfully removed!"]);
 }
 
 
 public function updateEmailWhatsappNo(Request $request)   //product and services
 {
	 
	try
		{
			
			$ams=AdminMessageSetting::where('id',1)->first();
			
			if(!empty($ams))
			{
				$ams->email = $request->admin_email;
				$ams->whatsapp_no = $request->admin_whatsapp_no;
				$result=$ams->save();
			}
			else
			{
				$result=AdminMessageSetting::create(['id'=>1,
				'email' => $request->admin_email,
				'whatsapp_no' => $request->admin_whatsapp_no,
				]);
			}

			return response()->json(['status'=>1,'msg'=>"Email and Whatsapp No successfully updated!"]);

		}catch(\Exception $e)
		{
			\Log::info($e->getMessage());
			return response()->json(['status'=>0,'msg'=>$e->getMessage()]);
		} 
	 
 }
 //FORGOT PASSWORD ---------------------------------------------------------------------------
 

public function forgotPassword()
{
	return view('admin.forgot-password-new');
}

public function verifyOtp()
{
	$user_email=Session::get('user_email');
	return view('admin.verify-forgot-password-otp',compact('user_email'));
}

public function changeUserPassword()
{
	$user_email=Session::get('user_email');
	return view('admin.auth-change-password',compact('user_email'));
}

public function sendForgotPasswordOtp(Request $request)
{

	Try
	{
		$validate = Validator::make(request()->all(),[
            'email'=>'required|email',
        ]);
	  
	    if ($validate->fails())
        {
			return back()->withErrors($validate)->withInput();
        }

		$randomNumber = random_int(1000, 9999);
		$user_email=$request->email;
		
		$admin=Admin::where('email',$user_email)->first();
		if(!$admin)
		{
			$err=['fail'=>"User email does'nt exist, Try again!"];
			return redirect()->back()->withErrors($err);
		}
				
		$votp=VerificationOtp::where('email',$user_email)->first();
		
			if(!empty($votp))
			{				
				$votp->email=$user_email;
				$votp->otp=$randomNumber;
				$votp->save();
			}
			else
			{
			$res=VerificationOtp::create([
				'email'=>$user_email,
				'otp'=>$randomNumber,
			]);
			}

		$data = [
			  'to_address'=>$user_email,
			  'subject' => 'Verification otp from GL-Partner Portal',
			  'body' => '',
			  'view' => 'admin.send_otp_mail_template', // Optional view page location
			  'attachments' => [], //Optional attachments array
			  'otp'=>$randomNumber,
		    ];
				
		$this->sendMail->send($data);
		$this->user_email=$user_email;
		
		Session::put('user_email',$user_email);
		return redirect('admin/verify-otp');
			
	}
	catch(\Exception $e)
	{
		Session::flash('fail',$e->getMessage());
		return redirect()->back();
		
	}

}

public function resendForgotPasswordOtp($email)
{

	try
	{
		$randomNumber = random_int(1000, 9999);
		$user_email=$email;
		
		$admin=Admin::where('email',$user_email)->first();

		if(!$admin)
		{
			return response()->json(['status'=>false,'msg'=>"User email does'nt exist, Try again!"]);
		}
		else
		{			
		    $votp=VerificationOtp::where('email',$user_email)->first();
		
			if(!empty($votp))
			{				
				$votp->email=$user_email;
				$votp->otp=$randomNumber;
				$votp->save();
			}
			else
			{
				$res=VerificationOtp::create([
					'email'=>$user_email,
					'otp'=>$randomNumber,
				]);
			
			}

		    $data = [
			  'to_address'=>$user_email,
			  'subject' => 'Verification otp from GL-Partner Portal',
			  'body' => '',
			  'view' => 'partner.send_otp_mail_template', // Optional view page location
			  'attachments' => [], //Optional attachments array
			  'otp'=>$randomNumber,
		    ];
				
			$this->sendMail->send($data);
			
			Session::put('user_email',$user_email);
			return response()->json(['status'=>true,'msg'=>"Otp successfully send!"]);
		}	
	}
	catch(\Exception $e)
	{
		\Log::info($e->getMessage());
		return response()->json(['status'=>false,'msg'=>$e->getMessage()]);
	}
}

public function checkForgotPasswordOtp(Request $request)
{

	$validate = Validator::make(request()->all(),[
            'user_otp'=>'required|numeric',
        ]);
	  
	if ($validate->fails())
       {
			return back()->withErrors($validate)->withInput();
       }

	$user_otp=$request->user_otp;
	$user_email=$request->user_email;
	
	$otp_data=VerificationOtp::where('email',$user_email)->first();
	
	if(!empty($otp_data))
	{
		if($user_otp==$otp_data->otp)
		{
			Session::put('user_email',$user_email);
			return redirect('admin/change-user-password');
		}
		else
		{
			Session::flash('fail',"Incorrect Otp");
			$err=['fail'=>"incorrect otp"];
			return redirect()->back()->withErrors($err);
		}
	}
	else
	{
		Session::flash('fail',"User details not found, try again");
		return redirect()->back();
	}
}

public function updateUserPassword(Request $request)
{
	$validate = Validator::make(request()->all(),[
            'new_password'=>'required|min:6|max:30',
			'conf_password'=>'required|min:6',
       ]);
	  
	if ($validate->fails())
       {
			return back()->withErrors($validate)->withInput();
       }
	   
	$npass=$request->new_password;
	$cpass=$request->conf_password;
	$user_email=$request->user_email;  
	
	if($npass!=$cpass)
	{
		$err=['fail'=>"Confirm password does'nt match"];
		return back()->withErrors($err);
	}
	else
	{
	
		$result=Admin::where('email',$user_email)->first();
		if(!empty($result))
		{
			$result->password=\Hash::make($npass);
			$result->save();
			
			Session::flash('fp-success', 'Password successfully changed. You can login now!');
			return redirect('admin/login');
		}
		else
		{
			return redirect()->back();
		}
	}
}
 
  
    
}
