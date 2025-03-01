<?php

namespace App\Http\Controllers\Web;

use DataTables;
use CountryState;
use App\Models\Lead;
use App\Models\Agent;
use App\Models\Partner;
use App\Models\Invite;
use Illuminate\Support\Str;
use App\Mail\InviteCreated;
use Illuminate\Http\Request;
use App\Models\LeadPurpose;
use App\Models\ProductAndService;
use App\Models\BussinessCategory;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class AgentController extends Controller
{


    public function index()
    {
        return view('agent.list_partners');
    }
	
	public function dashboard()
    {
        return view('agent.dashboard');
    }
	

    public function listPartners()
    {
        $agent_id = Auth::guard('agent')->user()->id;
        $data = Partner::latest('partners.created_at')
                                ->where('agent_id',$agent_id)
                                ->leftJoin('agents','agents.id','partners.agent_id')
                                ->select('partners.*','agents.name as agent_name')
                                 ->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                           $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }


    public function invitePartner(Request $request)
    {
        do {
            //generate a random string using Laravel's str_random helper
            $token = Str::random(12);
        } 
        //check if the token already exists and if it does, try again
        while (Invite::where('token', $token)->first());
        //create a new invite record
        $agent_id = Auth::guard('agent')->user()->id;

        $invite = Invite::create([
            'email' => $request->email_id,
            'token' => $token,
            'agent_id' => $agent_id
        ]);
        $invite['sender'] = Auth::guard('agent')->user()->name;
        // send the email
        Mail::to($request->email_id)->send(new InviteCreated($invite));
        return response()->json(['status'=>1,'msg'=>'Invite Mail sent successfully !!!']);
    }

    public function getInviteLink(Request $request)
    {
        do {
            $token = Str::random(12);
        } 
        while (Invite::where('token', $token)->first());
		
        $agent_id = Auth::guard('agent')->user()->id;
		
        $invite = Invite::create([
            'email' => 'partner@gmail.com',
            'token' => $token,
            'agent_id' => $agent_id
        ]);

        $link = route('accept-invitation', $invite->token);

        return response()->json(['status'=>1,'link'=>$link]);
    }
    
  public  function create(Request $request){

        $agent = new Agent();
        $agent->name = $request->name;
        $agent->email = $request->email;
        $agent->mobile = $request->mobile;
        $agent->password = \Hash::make($request->password);
        $save = $agent->save();

        if( $save ){
            return redirect()->back()->with('success','You are now registered successfully as Agent');
        }else{
            return redirect()->back()->with('fail','Something went Wrong, failed to register');
        }
  }


  public function createPartner(Request $request)
  {
        $result =Partner::create([
			'name' => $request->name,
			'mobile' => $request->mobile,
			'email' => $request->email,
			'agent_id' => Auth::guard('agent')->user()->id,
			'photo' => 'user_dummy.png',
			'password' => \Hash::make($request->password),
        ]);
		
        return response()->json(['status'=>1,'msg'=>'Partner details successfully added!']);
  }


  public function createLead()
  {
        $countries = CountryState::getCountries();
        $products = ProductAndService::where('type','1')->pluck('plan_name','id');
        $bussiness_categories = BussinessCategory::pluck('bussiness_category_name','id');

        $partner_with_leads = Lead::pluck('partner_id')->toArray();
        $all_partners = Partner::all();
        $agent_partners = $all_partners->where('agent_id',Auth::guard('agent')->user()->id)->pluck('id')->toArray();
        $filter_partner = $all_partners->whereIn('id',array_intersect($agent_partners,$partner_with_leads))->pluck('partner_company','id')->toArray();        
        $dummy = [0=>'Select partner'];
        $partners = $dummy+$filter_partner;
        $partner_list = $all_partners->where('agent_id',Auth::guard('agent')->user()->id)->pluck('partner_company','id')->toArray();
        return view('agent.create_lead',compact('countries','bussiness_categories','filter_partner','partners','products','agent_partners','partner_list'));

  }
  

  public function saveLead(Request $request)
  {

        $result=Lead::create([
			'partner_id' => $request->partner_id,
			'name' => $request->name,
			'mobile' => $request->mobile,
			'company_name' => $request->company_name,
			'designation' => $request->designation,
			'bussiness_category_id' => $request->bussiness_category_id,
			'email' => $request->email,
			'area' => $request->area,
			'country' => $request->country,
			'country_name' => $request->country_name,
			'state' => $request->state,
			'pincode' => $request->pincode,
			'address' => $request->address,
			'remarks' => $request->remarks,
			'owner_type' => 1,
			]);


        // if($request->has('plan'))
        // {
        //     $plan = ProductAndService::where('id',request('plan'))->first();
        //     $plan_name =  $plan->plan_name." ".$plan->users." users ".$plan->pricing." per month";
        // }
        // else{
        //     $plan_name = "Not selected";
        // }
        // $partner_name = Auth::guard('admin')->user()->name;

        // $this->send_telegram_notification($partner_name,$request->company_name,$request->name,$request->email,$plan_name,$request->mobile);


        return response()->json(['status'=>1,'msg'=>'New lead successfully added!']);
  }
  
  

  public function listLeads(Request $request)
  {
    $partners = Partner::where('agent_id',Auth::guard('agent')->user()->id)->pluck('id');
    
    $data = Lead::latest()->whereIn('partner_id',$partners)->where(function($q)use($request)
            {
                $request->partner_id !=0 ? $q->where('partner_id',$request->partner_id):'';
                $request->payment_status !="" ?$q->where('payment_status',$request->payment_status):'';
            })->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('partner', function($row){
                        $partner = Partner::where('id',$row->partner_id)->first()->name;
                        return $partner;
                    })
                    ->addColumn('c_amount', function($row){
                        if($row->commission_amount != null)
                        {
                            return "₹ ".number_format($row->commission_amount,2,'.','');
                        }
                        else
                        {
                            return "--";
                        }
                    })
                    ->addColumn('amt_collected', function($row){
                        if($row->amount_collected != null)
                        {
                            return "₹ ".number_format($row->amount_collected,2,'.','');
                        }
                        else
                        {
                            return "--";
                        }
                    })

                    ->addColumn('pay_status', function($row){
                        $payment_status = "";
                        if($row->payment_status == 1)
                        {
                            $payment_status = "<span class='success'>Paid</span>";
                        }
                        else 
                        {
                            $payment_status =  "Not Paid";
                        }
                        return $payment_status;
                    })

                    ->addColumn('actions', function($row){
						$btn="--";
						if($row->payment_status!=1)
						{
							$btn = '<button type="button" class="btn btn-outline edit_lead" id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#edit-lead-modal" ><i class="fa fa-pencil"></i></button>';
						}
				        return $btn;
                    })
                    ->rawColumns(['actions','pay_status'])
                    ->make(true);
  }

	public function editLeadDetails($id)
    {
       $lead = Lead::where('id',$id)->first();
       $lead_purposes = LeadPurpose::where('id',$id)->pluck('product_and_services_id');
       $partner_with_leads = Lead::pluck('partner_id')->toArray();
       $all_partners = Partner::whereIn('id',$partner_with_leads)->pluck('name','id')->toArray();
	   $countries = CountryState::getCountries();
	   $plan=$this->getPlanForEditLead($lead->plan_type);
	   if($lead->country!="")
			$states = CountryState::getStates($lead->country);
		else
			$states=[];
	   
	   return view('modals.edit_lead_agent',compact('lead','lead_purposes','all_partners','countries','plan','states'));
	   
	  // return response()->json(['lead'=>$lead,'purposes'=>$lead_purposes]);
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
    $lead->partner_id = $request->edit_partner_id;
    $lead->name = $request->edit_name;
    $lead->mobile = $request->edit_mobile;
    $lead->company_name = $request->edit_company_name;
    $lead->designation = $request->edit_designation;
    $lead->bussiness_category_id = $request->edit_bussiness_category_id;
    $lead->email = $request->edit_email;
	$lead->country = $request->edit_country;
	$lead->country_name = $request->edit_country_name;
    $lead->state = $request->edit_state;
    $lead->area = $request->edit_area;
    $lead->pincode = $request->edit_pincode;
	$lead->plan_type = $request->edit_plan_type;
	$lead->plan_id = $request->edit_plan;
    $lead->address = $request->edit_address;
    $lead->remarks = $request->edit_remarks;
    $lead->save();
 
    return response()->json(['status'=>1,'msg'=>'Lead Updated Successfully !!!']);
  }

  function check(Request $request){
      //Validate Inputs
      $request->validate([
         'email'=>'required|email|exists:agents,email',
         'password'=>'required|min:5|max:30'
      ],[
          'email.exists'=>'This email is not exists in agent table'
      ]);

      $creds = $request->only('email','password');

      if( Auth::guard('agent')->attempt($creds) ){
          return redirect()->route('agent.home');
      }else{
          return redirect()->route('agent.login')->with('fail','Incorrect Credentials');
      }
  }

  function logout(){
      Auth::guard('agent')->logout();
      return redirect('/');
  }
}
