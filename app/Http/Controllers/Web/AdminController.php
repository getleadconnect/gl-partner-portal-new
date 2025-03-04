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
use App\Exports\leadsExport;

use DB; 
use DataTables;
use CountryState;
use App\Models\Lead;
use App\Models\Agent;
use App\Models\Admin;
use App\Models\Partner;
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

   function logout(){
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
        $partner_count = Partner::all()->count();
		$countries = CountryState::getCountries();
        return view('admin.partners',compact('agents','partner_count','countries')); 
    }
	
	
	public function getPartners(Request $request)
    {   
        $agents = Agent::pluck('name','id');
		
		$status=$request->searchStatus;
		
				
		$dat = Partner::latest('partners.created_at')
				->leftJoin('agents','agents.id','partners.agent_id')
				->select('partners.*','agents.name as agent_name');
				
		if($status!="")
        {
			$dat->where('status',$status)->orWhere('status',null)->get();
		}
		
		$data=$dat->get();
		
            return Datatables::of($data)
                    ->addIndexColumn()
					->addColumn('name', function($row)
					{
						$name = '<a class="view-partner-details" href="javascript:;" id="'.$row->id.'">'.Str::upper($row->name).'</a>';

						return $name;
                    })
					
					->addColumn('mobile', function($row)
					{
						return ($row->country_code?'+'.$row->country_code:'').$row->mobile;
                    })
					
					->addColumn('agent_name', function($row)
					{
						if($row->agent_name!="")
						{
						  $agent_name='<a href="#" class="assign_agent" data-id="'.$row->agent_id.'"data-bs-toggle="modal" data-bs-target="#assign-agent-modal" id="'.$row->id.'" title="Re-Assign Agent">'.$row->agent_name.'</a>';
						}
						else
						{	
						  $agent_name = '<button type="button" class="btn btn-outline btn-circle assign_agent" data-bs-toggle="modal" data-bs-target="#assign-agent-modal" id="'.$row->id.'" title="Assign agent"><i class="fa fa-user-plus"></i></button>';
						}
						return $agent_name;
                    })
										
					->addColumn('status', function($row)
					{
						$select = '<select name="partner_status" class="form-select partner_status '. ($row->status == 1?' partner-active':'partner-inactive').'"  data-id='.$row->id.'>';
						$select .= '<option  value="1"' . ($row->status == 1 ? ' selected' : '') . '>Active</option>';
						$select .= '<option  value="0"' . ($row->status == 0 ? ' selected' : '') . '>Inactive</option>';
						$select .= '</select>';
						return $select;
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
								  <a class="dropdown-item dropdown-item-size set-commission" href="javascript:;"  id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#set-commission-modal" >
								  <i class="fa fa-money"></i>&nbsp;Set Commission(%)</a> </li>
								  
								  <li>
								  <a class="dropdown-item dropdown-item-size confirm_deletion" href="javascript:;" id="'.$row->id.'">
								  <i class="fa fa-trash"></i>&nbsp;Delete</a> </li>';
								  
								 '</div>';
					return $action;
					})

                ->rawColumns(['name','agent_name','action','status'])
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
					'bank_name'=>$request->bank_name,
					'ifsc'=>$request->ifsc_code,
					'branch'=>$request->branch,
					'account_number'=>$request->account_number,
					'upi_id'=>$request->upi_id,
					'status'=>$request->partner_status,
				]);
				
				//unique_id ----------------------
				$id=$result->id;
				$uniq_id="GL".substr("00000",strlen($id)).$id;
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
		if($part->country!="")
			$states = CountryState::getStates($part->country);
		else
			$states=[];
		
		return view('modals.edit_partner_modal',compact('part','countries','states'));     
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
		$partner->commission_percentage = $request->comm_percentage_edit;
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
		$data['total_commission']=Lead::partnerTotalCommission($id);
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
         $pa=Partner::where('id',$request->partner_id)->first();
		 $pa->commission_percentage=$request->commission;
		 $pa->save();
		 
         return response()->json(['status'=>1,'msg'=>"Commission percentage added."]);
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
        $leads = Lead::all();
        $countries = CountryState::getCountries();

        $bussiness_categories = BussinessCategory::pluck('bussiness_category_name','id');
        $partner_list = Partner::all();
        $partner_with_leads = Lead::pluck('partner_id')->toArray();
		
        $partners = $partner_list->whereIn('id',$partner_with_leads)->pluck('name','id')->toArray();
		
        $all_partners = $partner_list->where('name','!=',null)->pluck('name','id');
		$lead_status = LeadStatus::all();

        $total_commission = $leads->sum('commission_amount');
        $total_amount_paid = $leads->sum('amount_collected');
        $total_bussiness = $leads->sum('total_amount');


        return view('admin.leads',compact('lead_status','all_partners','partners','total_commission','total_amount_paid','total_bussiness','countries','bussiness_categories'));
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
     
			$lstatus=LeadStatus::pluck('lead_status');
						
            $data = Lead::latest()->leftJoin('partners','leads.partner_id','=','partners.id')
			->where(function($q) use($request)
            {
                $request->partner_id !=0 ? $q->where('partner_id',$request->partner_id):'';
                $request->status !="" ?$q->where('lead_status',$request->status):'';
				$request->pay_status !="" ?$q->where('payment_status',$request->pay_status):'';
            })->select('leads.*','partners.name as partner_name','partners.commission_percentage')->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('partner', function($row){
                        
                        return $row->partner_name;
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
							$html = '<select class="form-select '.$clas.'" name="lead_status" id="lead_status" data-lead-id='.$row->id.' data-commission='.$row->commission_percentage.'>'.$options.'</select>';
						}
                        return $html;
				
                    })
					->addColumn('pay_status', function($row)
					{

						$pay_status="";
												
						if($row->payment_status == 0){$clas=' payment-inactive';}else {$clas=' payment-pending';}
						
						$pay_status = '<select name="payment_status" id="payment_status" class="form-select '.$clas .'" data-lead-id='.$row->id.'>';
						$pay_status.= '<option  value="0"' . ($row->payment_status == 0 ? ' selected' : '') . '>Not Paid</option>';
						$pay_status.= '<option  value="2"' . ($row->payment_status == 2 ? ' selected' : '') . '>Pending</option>';
						$pay_status.= '</select>';
						
						if($row->balance == 0 and $row->lead_status =="Got Business")
						{
							$pay_status	="<span class='success'>Paid</span>";
						}

						return $pay_status;
                    })

					->addColumn('mobile', function($row)
					{
						
						$mobile= ($row->country_code?'+'.$row->country_code:'').' '.$row->mobile."<br>";
						$mobile.= $row->email??'';
						return $mobile;
                    })
					
                     ->addColumn('action', function($row){
						
						if($row->payment_status==1)
						{
						 $btn = '<div class="btn-group">
							<button type="button" class="btn btn-outline edit_lead" id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#edit-lead-modal" ><i class="fa fa-pencil"></i></button>';
						}
						else
						{
							$btn = '<div class="btn-group">
							<button type="button" class="btn btn-outline edit_lead" id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#edit-lead-modal" ><i class="fa fa-pencil"></i></button>
							<button type="button" class="btn btn-outline dropdown-toggle"
							data-bs-toggle="dropdown">
							<i class="fa fa-trash"></i>
						</button>
					
						<ul class="dropdown-menu pull-right" role="menu">
							<li class="text-center mb-2"><a href="#">Confirm Deletion</a></li>
							<li class="divider"></li>
							<li style="display: flex;align-items:center;justify-content:center;" class="confirm_buttons">
							<button type="button" class="btn btn-outline btn-success ok_btn confirm_deletion" data-id="'.$row->id.'"><i class="fa fa-check"></i></button>&nbsp;
							<button type="button" class="btn btn-outline btn-danger no_btn"><i class="fa fa-times"></i></button>
							</li>
						</ul>
						</div>';
						}
                      return $btn;
                    })
                      ->rawColumns(['pay_status','mobile','status','action'])
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
		$lead_camt = $request->set_collected_amount;
		$lead_comm = $request->set_commission;
		$lead_status= $request->set_comm_lead_status;
		$comm_per= $request->set_comm_percentage;
		
        $lead = Lead::where('id',$lead_id)->first();
		$partner_id=$lead->partner_id;
		
        $lead->amount_collected = $lead_camt;
		$lead->commission_amount = $lead_comm;
		$lead->paid_amount =null;
		$lead->balance = $lead_comm;
		$lead->lead_status = $lead_status;
        $lead->save();
		
		$result=PaymentDetail::create([
			'lead_id'=>$lead_id,
			'partner_id'=>$partner_id,
			'collected_amount'=>$lead_camt,
			'commission'=>$lead_comm,
			'amount'=>0,
			'balance'=>$lead_comm,
			'percentage'=>$comm_per,
		]);
	
		DB::commit();
        return response()->json(['status'=>1,'msg'=>'Commition successfully added!']);
		
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
        $data = Agent::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                            $btn = '<button type="button" class="btn btn-outline edit_agent"  data-bs-toggle="modal" data-bs-target="#edit-agent-modal" id="'.$row->id.'"><i class="fa fa-pencil"></i></button>
									<button type="button" class="btn btn-outline dropdown-toggle"
									data-bs-toggle="dropdown" title="Delete">
									<i class="fa fa-trash"></i>
								</button>
								
								<ul class="dropdown-menu pull-right" role="menu">
									<li class="text-center mb-2"><a href="#">Confirm Deletion</a></li>
									<li class="divider"></li>
									<li style="display: flex;align-items:center;justify-content:center;" class="confirm_buttons">
									<button type="button" class="btn btn-outline btn-success ok_btn confirm_agent_deletion" data-id="'.$row->id.'"><i class="fa fa-check"></i></button>&nbsp;
									<button type="button" class="btn btn-outline btn-danger no_btn"><i class="fa fa-times"></i></button>
									</li>
								</ul>
							</div>';
							
							
							
							return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.agent_list');
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
    
        $partners = Partner::whereIn('id',Lead::pluck('partner_id')->toArray())->pluck('name','id')->toArray();
		$lead_status = LeadStatus::all();
		return view('admin.payouts',compact('partners','lead_status'));
    }

public function payoutHistory(Request $request)
    {
   
        $partners = Partner::whereIn('id',Lead::pluck('partner_id')->toArray())->pluck('name','id')->toArray();
		$lead_status = LeadStatus::all();
		return view('admin.payouts_history',compact('partners','lead_status'));
    }

	
public function gotBusinessUnPaidLeads(Request $request)
    {

			$data = Lead::select('leads.*','partners.name as partner_name','partners.commission_percentage')
			->leftJoin('partners','leads.partner_id','=','partners.id')
			->where(function($q)use($request)
            {
                $request->partner_id !=0 ? $q->where('partner_id',$request->partner_id):'';
            })->where('leads.lead_status',"Got Business")
			  ->where('leads.payment_status',0)
			  ->latest()->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('partner', function($row){
                       
                        return $row->partner_name;
                    })
					->addColumn('amount_collected', function($row){
						$col_amount="₹ ".number_format($row->amount_collected,'2','.','');
						return $col_amount;
                    })
					->addColumn('commission_amount', function($row){
						$com_amount="₹ ". number_format($row->commission_amount,'2','.','');
						return $com_amount;
                    })
					
					->addColumn('amount', function($row){
						$paid_amt="₹ ". number_format($row->paid_amount,'2','.','');
						return $paid_amt;
                    })
					
					->addColumn('balance', function($row){

						$bal_amount="₹ ". number_format($row->balance,'2','.','');
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
					->addColumn('actions', function($row)
					{
					
						if($row->balance==0)
						{
						   $btn1='<li>
								  <a class="dropdown-item dropdown-item-size set-commission" href="javascript:;" data-percentage="'.$row->commission_percentage
								  .'" data-leadid="'.$row->id.'" data-leadstatus="'.$row->lead_status.'" data-bs-toggle="modal" data-bs-target="#set-commission-modal">
								  <i class="ico-icon icon-billing-payment"></i>New Commission</a> </li>
								  <li><li>
								  <a class="dropdown-item dropdown-item-size close-payment" href="javascript:;" data-leadid="'.$row->id.'">
								  <i class="ico-icon icon-billing-payment"></i>Close</a> </li>';
						}
						else 
						{
						   $btn1='<li>
								  <a class="dropdown-item dropdown-item-size btn-pay" href="javascript:;" data-leadid="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#set-payment-modal">
								  <i class="ico-icon icon-billing-payment"></i>Pay</a> </li>';
						}
										
						$action= '<div class="fs-5 ms-auto dropdown">
					 		   <div class="dropdown-toggle cursor-pointer" data-bs-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></div>
								<ul class="dropdown-menu">'.$btn1.
								
								 '</div>';
					return $action;
					})
					
                    ->rawColumns(['actions','email','status','pay_status'])
                    ->make(true);
    }

					
public function gotBusinessPaidLeads(Request $request)
    {

		$data = Lead::latest()->leftJoin('partners','leads.partner_id','=','partners.id')
		->where(function($q)use($request)
		{
			$request->partner_id !=0 ? $q->where('partner_id',$request->partner_id):'';
		})->select('leads.*','partners.name as partner_name','partners.commission_percentage')
		  ->where('leads.lead_status',"Got Business")
		  ->where('leads.payment_status',1)->get()
		  ->map(function($q)
			  {
				  $sum=PaymentDetail::select(DB::raw('SUM(collected_amount) as camount'),DB::raw('SUM(commission) as com_amount'),DB::raw('SUM(amount) as pamount'))->where('lead_id','73')->get();
				  $q['total_collected']=$sum[0]->camount;
				  $q['total_commission']=$sum[0]->com_amount;
				  $q['total_paid']=$sum[0]->pamount;
				  return $q;
			  });
			  
		   return Datatables::of($data)
				->addIndexColumn()
				->addColumn('partner', function($row){
					
					return $row->partner_name;
				})
				
				->addColumn('total_collected', function($row){
					$col_amount="₹ ".number_format($row->total_collected,'2','.','');
					return $col_amount;
				})
				->addColumn('total_commission', function($row){
					$com_amount="₹ ". number_format($row->total_commission,'2','.','');
					return $com_amount;
				})
				
				->addColumn('total_paid', function($row){
					$com_amount="₹ ". number_format($row->total_paid,'2','.','');
					return $com_amount;
				}) 
				->addColumn('status', function($row){
					$lst='<span style="color:green;">'.$row->lead_status.'</span>';
					return $lst;
				})
				->addColumn('actions', function($row)
				{
					$action="<a href='' class='btn btn-primary btn-pay' data-leadid='".$row->id."' data-bs-toggle='modal' data-bs-target='#set-payment-modal'>Pay</a>";
											
					return $action;
				})
				
				->addColumn('pay_status', function($row)
				{
					$pay_stat='<span style="color:green;">Paid</span>';
					return $pay_stat;
				})
				
				->addColumn('email', function($row)
				{
					$email = $row->email.'<br/>';
					$email .= $row->mobile;
					return $email;
				})

			->rawColumns(['email','status','pay_status'])
		  ->make(true);
    }


public function viewPaymentDetails(Request $request)
    {

		$data = PaymentDetail::select('payment_details.*','leads.name','leads.mobile')
		->leftJoin('leads','payment_details.lead_id','=','leads.id')
		->where(function($q)use($request)
		{
			$request->partner_id !="" ? $q->where('payment_details.partner_id',$request->partner_id):'';
		})->get();
				

		return Datatables::of($data)
				->addIndexColumn()
				->addColumn('name', function($row){
				   
					return $row->name;
				})
				->addColumn('collected_amount', function($row){
					$col_amount="₹ ".number_format($row->collected_amount,'2','.','');
					return $col_amount;
				})
				->addColumn('commission', function($row){
					$com_amount="₹ ". number_format($row->commission,'2','.','');
					return $com_amount;
				})
				
				->addColumn('amount', function($row){
					$paid_amt="₹ ". number_format($row->amount,'2','.','');
					return $paid_amt;
				})
				
				->addColumn('balance', function($row){

					$bal_amount="₹ ". number_format($row->balance,'2','.','');
							return $bal_amount;
				})
				
				->addColumn('status', function($row){

					if($row->balance==0)
					{
						$stat="<span class='success'>Paid</span>";
					}
					else
					{
						$stat="<span class='danger'>Not Paid</span>";
					}
					return $stat;
				})
				
		->rawColumns(['status'])
		->make(true);
    }


public function viewPaymentHistory(Request $request)
    {

		$data = PaymentHistory::select('payment_histories.*','leads.name','leads.mobile')
		->leftJoin('leads','payment_histories.lead_id','=','leads.id')
		->where(function($q)use($request)
		{
			$request->partner_id !=0 ? $q->where('payment_histories.partner_id',$request->partner_id):'';
		})->get();

		return Datatables::of($data)
				->addIndexColumn()
				->addColumn('name', function($row){
					return $row->name;
				})
				->addColumn('amount', function($row){
					$amount="₹ ".number_format($row->amount,'2','.','');
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

  
 public function getLeadDetails($lead_id)
 {
	 $lead=Lead::leftJoin('partners','leads.partner_id','partners.id')
	 ->select('leads.*','partners.commission_percentage')->where('leads.id',$lead_id)->first();
	 return response()->json(['status'=>1,'data'=>$lead]);
 }
  
 public function getPartnerPaymentDetails($lead_id)
 {
	 $lead=Lead::select('leads.*','partners.commission_percentage')
	 ->leftJoin('partners','leads.partner_id','partners.id')
	 ->where('leads.id',$lead_id)->first();
	 
	 $pay_history=PaymentHistory::where('lead_id',$lead_id)->get();

	 return view('modals.set_payment',compact('lead','pay_history'));   
 }
   
 /*public function getLeadPaymentDetails(Request $request)
 {
	 $lead_id=$request->lead_id;
	 
	 $pdat=PaymentDetail::where('lead_id',$lead_id)->get()->map(function($q)
	 {
		 $q->payment_receipt=url('uploads/receipts')."/".$q->payment_receipt;
		 $q->payment_date=Carbon::createFromDate($q->payment_date)->format('d-m-Y');
		 return $q;
	 });
	 
	 return response()->json(['status'=>1,'data'=>$pdat]);
 }*/
   
  
public function savePayout(Request $request)
{
	try
		{
			$lead_id=$request->pay_lead_id;
			
			$fileName='';

			if($request->file('payment_receipt'))
			{
				$fileName = "rec_".time().'.'.$request->payment_receipt->extension();  
				$request->payment_receipt->move(public_path('uploads/receipts/'), $fileName);
			}
						
			$result=PaymentHistory::create([
				'lead_id' => $request->pay_lead_id,
				'partner_id' => $request->pay_partner_id,
				'amount' => $request->pay_amount,
				'payment_date' => $request->payment_date,
				'payment_id' => $request->payment_id,
				'receipt'=>$fileName,
			]);
			
			//update in lead table
			$lad=Lead::whereId($lead_id)->first();
			$lad->paid_amount=$lad->paid_amount+$request->pay_amount;
			$lad->balance=$request->pay_balance-$request->pay_amount;
			$lad->save();
			
			//update in payment details table
			$pdt=PaymentDetail::where('lead_id',$lead_id)->latest()->first();
			$pdt->amount=$pdt->amount+$request->pay_amount;
			$pdt->balance=$request->pay_balance-$request->pay_amount;
			$pdt->save();

			
			if($result)
			{

				$partner=Partner::where('id',$request->pay_partner_id)->first();
				
				// general notification ----
				
				$msg="Hi,".$partner->name.", Your commission Rs. ".$request->pay_commission." credited to your account on ".$request->payment_date.", Thank You!";
				$ndat=['notification'=>$msg, 'partner_id'=>$request->pay_partner_id,'category'=>2,'status'=>0];
				Notification::create($ndat);
				//--------------------------
				
				return redirect()->back()->withSuccess("Payment successfully submited!");
			}
			else
			{
				return redirect()->back()->withError("Something wrong, Please check.");
			}

		}catch(\Exception $e)
		{
			\Log::info($e->getMessage());
			return redirect()->back()->withError($e->getMessage());
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
        $data = Notification::select('notifications.*','partners.name')
		->leftJoin('partners','notifications.partner_id','=','partners.id')->latest()
		->get();

        return Datatables::of($data)
                    ->addIndexColumn()
					->addColumn('cdate', function($row){
                        $dt=Carbon::createFromDate($row->created_at)->format('d-m-Y h:i:s');
						return $dt;
                    })
					->addColumn('status', function($row){
						$status = '--';
						if($row->status==0)
						{
                            $status = '<span class="noti-dot success rounded-pill">New</span>';
						}
						return $status;
                    })
					
					->addColumn('addedby', function($row){
						 $addedby = '<span class="noti-dot success rounded-pill">'.$row->name.'</span>';
						if($row->category==1)
						{
                            $addedby = '<span class="noti-dot noti-admin rounded-pill">Getlead</span>';
						}
						return $addedby;
                    })
					
                    ->addColumn('action', function($row){
                        $btn = '<div class="btn-group">
                        <button type="button" class="btn btn-outline dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-trash"></i> </button>
					
							<ul class="dropdown-menu pull-right" role="menu">
								<li class="text-center mb-2"><a href="#">Confirm Deletion</a></li>
								<li class="divider"></li>
								<li style="display: flex;align-items:center;justify-content:center;" class="confirm_buttons">
								<button type="button" class="btn btn-outline ok_btn confirm_deletion" data-id="'.$row->id.'"><i class="fa fa-check"></i></button>&nbsp;
								<button type="button" class="btn btn-outline no_btn"><i class="fa fa-times"></i></button>
								</li>
							</ul>
						</div>';
							
                            return $btn;
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
		$products = ProductAndService::all();
		$ams=AdminMessageSetting::whereId(1)->first();
        return view('admin.settings_new',compact('noti','lstatus','products','ams'));
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
                    $btn = '<div class="btn-group">
							<a href="'.route("admin.edit-news",$row->id).'"  type="button" class="btn btn-outline"><i class="fa fa-pencil"></i></a>
							<button type="button" class="btn btn-outline dropdown-toggle"
							data-bs-toggle="dropdown">
							<i class="fa fa-trash"></i>
						</button>
					
						<ul class="dropdown-menu pull-right" role="menu">
							<li class="text-center mb-2"><a href="#">Confirm Deletion</a></li>
							<li class="divider"></li>
							<li style="display: flex;align-items:center;justify-content:center;" class="confirm_buttons">
							<button type="button" class="btn btn-outline btn-success ok_btn confirm_deletion" data-id="'.$row->id.'"><i class="fa fa-check"></i></button>&nbsp;
							<button type="button" class="btn btn-outline btn-danger no_btn"><i class="fa fa-times"></i></button>
							</li>
						</ul>
						</div>';

					return $btn;
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


public function exportPartnerList($status)
	{
        return Excel::download(new partnerExport($status), 'partner_list'.'_'.date('Y-m-d').'.'.'xlsx');
    } 
   
 public function exportLeadList($status,$partner,$pay_status)
	{
        return Excel::download(new leadsExport($status,$partner,$pay_status), 'leads_list'.'_'.date('Y-m-d').'.'.'xlsx');
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
