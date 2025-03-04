<?php

namespace App\Http\Controllers\Web;

use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use GlPackage\NotificationManager\Notifications\EmailNotification;
use GlPackage\NotificationManager\Notifications\WhatsAppNotification;
use GlPackage\NotificationManager\Notifications\TelegramNotification;

use Auth;
use DataTables;
use CountryState;
use App\Models\User;
use App\Models\Lead;
use App\Models\Agent;
use App\Models\Invite;
use App\Models\Partner;
use App\Models\LeadPurpose;
use App\Models\VerificationOtp;
use App\Models\Test;
use App\Models\ProductAndService;
use App\Models\BussinessCategory;
use App\Models\PaymentDetail;
use App\Models\PaymentHistory;
use App\Models\LeadStatus;
use App\Models\News;
use App\Models\Notification;
use App\Models\AdminMessageSetting;

use App\Services\ApiService;

use Validator;
use Session;
use Carbon\Carbon;

use App\Traits\LeadNotificationTrait;

class PartnerController extends Controller
{
    use LeadNotificationTrait, ApiService;
	
	protected $sendMail;
	
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
		$agent_id = 0;
        //return view('partner.login_new',compact('agent_id'));
		return view('partner.auth-login',compact('agent_id'));
    }
	
	public function terms()
    {
		return view('partner.terms_and_conditions');
    }
	

  public function check(Request $request)
  {

      $validate = Validator::make(request()->all(),[
         'email'=>'required|email|exists:partners,email',
         'password'=>'required|min:5|max:30'
      ]);
	  
	  if ($validate->fails())
      {
		return back()->withErrors($validate)->withInput();
      }

	  $creds = $request->only('email','password');

	  if( Auth::guard('partner')->attempt($creds) ){
		  return redirect()->route('partner.home');
	  }else{
		  return redirect()->route('partner.login')->with('fail','Incorrect Credentials');
	  }
		
  }

  public function logout(){
      Auth::guard('partner')->logout();
      return redirect('/');
  }
  
  
  public function home()
    {
        
		$profile_update_status=Partner::whereId(Auth::user()->id)->pluck('profile_update_status')->first();
		
		$update_message="";
		
		if($profile_update_status==0)
		{
			$update_message="<strong>Your profile not completed</strong>, Please complete your profile ";
			Session::put(['profile_update_status'=>$update_message]);
			$update_message.=" <a href='".url('partner/settings')."' class='btn btn-primary' style='margin-left:20px;'>Update Now</a>";
		}
				
		$prid=Auth::guard('partner')->user()->id;
		
		$data['leads_count'] = Lead::where('partner_id',$prid)->count();
		$data['leads_business'] = Lead::where('lead_status','Got Business')->where('partner_id',$prid)->count();
		
		$data['total_commission'] = PaymentDetail::where('partner_id',$prid)->sum('commission');
		$data['paid_commission'] = PaymentDetail::where('partner_id',$prid)->sum('amount');
		
        return view('partner.dashboard',compact('data','update_message'));
    }

    public function index()
    {

		$products = ProductAndService::where('type','1')->pluck('plan_name','id');
		$countries = CountryState::getCountries();
		$bussiness_categories = BussinessCategory::pluck('bussiness_category_name','id');
		$lead_status = LeadStatus::pluck('lead_status');
        return view('partner.leads_list',compact('bussiness_categories','countries','products','lead_status'));
    }


// PARTNER ------------------------------------------

	public function signup()
	{
		$agent_id=0;
		return view('partner.signup',compact('agent_id'));
	}


   public function create(Request $request)
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
			
				$pdata=[
					'name' => request('name'),
					'country_code' => request('country_code'),
					'mobile' => request('mobile'),
					'company_name' => request('company_name'),
					'email' => request('email'),
					'photo' => 'partner_dummy.png',
					'password' => \Hash::make($request->password),
					'status' =>1,
				];
				
				$result=Partner::create($pdata);
			
				$login_url=url("/")."/partner/login";
				
				// unique id ----------------------------
				$id=$result->id;
				$uniq_id="GL".substr("00000",strlen($id)).$id;
				$res=Partner::where('id',$id)->update(['unique_id'=>$uniq_id]);
				//--------------------------------------	

				if( $result )
				{
					
					//------send partner to crm-----
						$send_response=$this->sendPartnerDetailToCrm($request);
					//------------------------------
										
					
					$partner_full_mobile=$request->country_code.$request->mobile;
		
						$data = [
							'to_address' => $request->email,
							'subject' => 'GL-Partner, Welcome to Our Service',
							'body' => "",
							'view' => 'admin_partner_adding_email_template', // Optional view page location
							'attachments' => [], // Optional attachments array
							'partner_name'=>$request->name,
							'login_url'=>$login_url,
						];

						$mail = new EmailNotification();
						$mail->send($data);


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
					
				//----- WHATSAPP MESSAGE-----------
			
					$data = [
							'mobile' => $partner_full_mobile,
							'template' => "partner_registration_message", // template for WhatsApp
							'parameters'=>[["type" => "text","text" => $login_url]],
							'buttons'=>[],
						];
					
				$whatsapp = new WhatsAppNotification();
				$result=$whatsapp->send($data); // Send WhatsApp message via queue
							
				//to admin ----------

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

				//------------SEND TELEGRAM MESSAGE----------
				
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

				//---------------------
					
					Session::flash('success', 'Rgistration successfully completed.');
					return redirect('partner/login');
				}else{
					Session::flash('fail', 'Something went Wrong, failed to register.');
					return redirect()->back();
				}
						   
			}
			catch(\Exception $e)
			{
				\Log::info($e->getMessage());
				return response()->json(['status'=>0,'msg'=>$e->getMessage()]);	
			}
		}
  }
  
  
//LEADS --------------------


    public function getLeads(Request $request)
    {

		$data = Lead::latest()->where(function($q)use($request)
            {
				$request->status!="" ? $q->where('lead_status',$request->status):'';
                $request->paymentStatus!=0 ? $q->where('payment_status',$request->paymentStatus):'';
            })->where('partner_id',Auth::guard('partner')->user()->id)->get();
				
		
            return Datatables::of($data)
                    ->addIndexColumn()

                    ->addColumn('commission_amount', function($row){
                        if($row->commission_amount)
                        {
                            return "₹ ".number_format($row->commission_amount,2,'.','');
                        }
                        return "0.00";
                    })
                    ->addColumn('amount_collected', function($row){
                        if($row->amount_collected)
                        {
                            return "₹ ".number_format($row->amount_collected,2,'.','');
                        }
                        return "0.00";
                    })
					->addColumn('mobile', function($row){
                        
                        return ($row->country_code?'+'.$row->country_code:'').' '.$row->mobile;
                    })
					
					->addColumn('lead_status', function($row){
                        $lead_status = "";
                        if($row->lead_status == "Got Business")
                        {
                            $lead_status =  '<span class="success">'.$row->lead_status.'</span>';
                        }
						else if($row->lead_status == "New")
                        {
                            $lead_status = "<span class='text-warning'>".$row->lead_status."</span>";
                        }
						else
                        {
                            $lead_status = "<span class='text-semi-blue'>".$row->lead_status."</span>";
                        }

                        return $lead_status;
                    })
                    ->addColumn('p_status', function($row){
                        $payment_status = "";
                        if($row->payment_status == 0)
                        {
                            $payment_status = '<span class="danger">Not Paid</span>';
                        }
						else if($row->payment_status == 1)
                        {
                            $payment_status = '<span class="success">Paid</span>';
                        }

                        return $payment_status;
                    })
                    ->addColumn('action', function($row){
     
						$btn="";
						if($row->lead_status=="New")
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
						else if($row->lead_status!="Got Business")
						{
							$btn = '<div class="btn-group">
								<button type="button" class="btn btn-outline edit_lead" id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#edit-lead-modal"><i class="fa fa-pencil"></i></button>';
						}

                        return $btn;
                    })
                    ->rawColumns(['action','lead_status','p_status'])
                    ->make(true);
    }


public function getBusinessLeads(Request $request)  //dashboard
    {
        
		$prid=Auth::guard('partner')->user()->id;
		$data = Lead::latest()->where('lead_status','New')->where('partner_id',$prid)->take(10);
		
            return Datatables::of($data)
                    ->addIndexColumn()
					->addColumn('commission_amount', function($row){
                        if($row->commission_amount)
                        {
                            return "₹ ".number_format($row->commission_amount,2,'.','');
                        }
                        return "--";
                    })
					
					->addColumn('mobile', function($row){
                        
                        return ($row->country_code?'+'.$row->country_code:'').' '.$row->mobile;
                    })
					
					->addColumn('lead_status', function($row){
                        $lead_status = "";
                        if($row->lead_status == "New")
                        {
                            $lead_status =  '<span class="text-warning">'.$row->lead_status.'</span>';
                        }
						else 
                        {
                            $lead_status = "<span>".$row->lead_status."</span>";
                        }

                        return $lead_status;
                    })
					
                    ->addColumn('p_status', function($row){
                        $payment_status = "";
                        if($row->payment_status == 0)
                        {
                            $payment_status =  '<span class="danger">Not Paid</span>';
                        }
						else if($row->payment_status == 1)
                        {
                            $payment_status = "<span class='success'>Paid</span>";
                        }

                        return $payment_status;
                    })

                    ->addColumn('action', function($row){
						
						$btn = '<button type="button" class="btn btn-outline edit_lead" data-id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#edit-lead-modal"><i class="fa fa-pencil"></i></button>';
						return $btn;
                    })
                    ->rawColumns(['action','lead_status','p_status'])
                    ->make(true);
    }

    public function deleteLead(Request $request)
    {
         Lead::where('id',$request->lead_id)->first()->delete();
         return response()->json(['status'=>1]);
    }

    public function acceptInvitation($token)
    {
        if (!$invite = Invite::where('token', $token)->first()) {
            abort(404);
        }
        $agent_id = Agent::where('id',$invite->agent_id)->first()->id;
        return view('partner.login',compact('agent_id'));
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

			   if($request->has('partner_id'))
				{
					$partner_id = $request->partner_id;
				}
				else{
					$partner_id = Auth::guard('partner')->user()->id;
				}

				$partner_name = Auth::guard('partner')->user()->name;
				$partner_email=Auth::guard('partner')->user()->email;
				$partner_mobile=Auth::guard('partner')->user()->country_code.Auth::guard('partner')->user()->mobile;

			try
			{

				$lead = new Lead();
				
				$lead->partner_id = $partner_id;
				$lead->name = $request->name;
				$lead->country_code = $request->country_code;
				$lead->mobile = $request->mobile;
				$lead->company_name = $request->company_name;
				$lead->designation = $request->designation;
				$lead->bussiness_category_id = $request->bussiness_category_id;
				$lead->email = $request->email??null;
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
				$lead->owner_type = 2;
				$result=$lead->save();
								
				if($result)
				{
				
				$ndat=['notification'=>"Partner ".$partner_name." added new leads.!",'status'=>0];
				Notification::create($ndat);
				
				
				//------------SEND LEAD TO CRM ---------------------------------------
				
				$send_response=$this->sendLeadToCrm($request); 
								
				//--------- SEND MAIL --------------------------------------------
				
				$partner=Partner::where('id',$partner_id)->first();
				
					if(!empty($partner))
					{												
						$to_partner=$partner_email;
											
						$data1 = [
								'subject' => 'New Lead Added to Your Account',
								'body' => 'Partner : '.$partner_name.", Added new lead" ,
								'view' => "partner_lead_adding_email_template", // Optional view page location
								'attachments' => [], // Optional attachments array
								'partner_name'=>$partner_name,
							];
							
						$data1['to_address']=$to_partner;  //send to partner
						$resp1=$this->sendMail->send($data1);  
						
						if($this->admin_email!="")
						{
						
							$data2 = [
									'subject' => 'Partner '.$partner_name.' added new Lead.',
									'body' => 'Partner : '.$partner_name.", Added new lead" ,
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

				//-----whatsapp message---------------------------------------------------------

				$data = [
						'mobile' => $partner_mobile,
						'template' => "partner_message", // Sample template
						'parameters'=>[],
						'buttons'=>[],
					];

				$whatsapp = new WhatsAppNotification();
				$whatsapp->send($data); // Send WhatsApp message via queue
				
				//to admin ----------------------------------------------

				if($this->admin_whatsapp_no!="")	
				{
					$data = [
							'mobile' => $this->admin_whatsapp_no,
							'template' => "partner_admin_message", // template for WhatsApp
							'parameters'=>[["type" => "text","text" => $partner_name]],
							'buttons'=>[],
						];

					$whatsapp = new WhatsAppNotification();
					$result=$whatsapp->send($data);
				}

			//--------- SEND MESSAGE TO TELEGRAM --------------------------------------------

			$bname=BussinessCategory::where('id',$request->bussiness_category_id)->pluck('bussiness_category_name')->first();

			$data = [
				'message' => "Hi,\n New lead received Via Partner Portal !!!".
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
				return response()->json(['status'=>0,'msg'=>$e->getMessage()]);
			}
		}
    }
	

    public function editLead($id)
    {
       $lead = Lead::where('id',$id)->first();
       $countries = CountryState::getCountries();
       $bussiness_categories = BussinessCategory::pluck('bussiness_category_name','id');
		if($lead->country!="")
			$states = CountryState::getStates($lead->country);
		else
			$states=[];

       return view('modals.edit_lead_partner',compact('bussiness_categories','countries','lead','states'));
    }
	

    public function updateLead(Request $request)
    {
        $lead = Lead::where('id',$request->lead_id)->first();
		
        if($request->has('partner_id'))
        {
            $lead->partner_id = $request->partner_id;
        }
		else
		{
			 $lead->partner_id = Auth::guard('partner')->user()->id;
		}
				
        $lead->name = $request->edit_name;
		$lead->country_code = $request->edit_country_code;
        $lead->mobile = $request->edit_mobile;
        $lead->company_name = $request->edit_company_name;
        $lead->designation = $request->edit_designation;
        $lead->bussiness_category_id = $request->edit_bussiness_category_id;
        $lead->email = $request->edit_email??null;
        $lead->plan_type = $request->edit_plan_type??null;
        $lead->plan_id = $request->edit_plan??null;
		$lead->country = $request->edit_country??null;
		$lead->country_name = $request->edit_country_name??null;
        $lead->state = $request->edit_state??null;
        $lead->area = $request->edit_area??null;
        $lead->pincode = $request->edit_pincode??null;
        $lead->address = $request->edit_address;
        $lead->remarks = $request->edit_remarks;
        $lead->save();

        return response()->json(['status'=>1,'msg'=>'Lead successfully updated!']);
    }

    public function getStates(Request $request)
    {
        $states = CountryState::getStates($request->country);
        return response()->json(['states'=>$states]);
    }
		
	public function sendOtp(Request $request) // for login
    {
	
			$otp=mt_rand(1000, 9999);

			$partner_id=$request->partner_id;
			$email=$request->email_id;
			
			VerificationOtp::where('email',$email)->delete();
			VerificationOtp::create(['otp'=>$otp,'partner_id'=>$partner_id,'email'=>$email]);

			try
			{
				$data = [
					'subject' => 'Gl-Partner Email Verification - Your One-Time Password (OTP)',
					'body' => "" ,
					'view' => "email_verification_template", // Optional view page location
					'attachments' => [], // Optional attachments array
					'otp'=>$otp,
				];
					
				$data['to_address']=$email;  //send to partner
				$resp1=$this->sendMail->send($data);  	
				return response()->json(['status'=>1,'msg'=>"Otp Successfully send.!"]);
			}
			catch(\Exception $e)
			{
				\Log::info($e->getMessage());
				return response()->json(['status'=>0,'msg'=>$e->getMessage()]);
			}
		
    }

	public function resendOtp($email) // for login
    {
	
			$otp=mt_rand(1000, 9999);

			$partner_id=$request->partner_id;
			$email=$request->email_id;
			
			VerificationOtp::where('email',$email)->delete();
			VerificationOtp::create(['otp'=>$otp,'partner_id'=>$partner_id,'email'=>$email]);

			try
			{
				$data = [
					'subject' => 'Gl-Partner Email Verification - Your One-Time Password (OTP)',
					'body' => "" ,
					'view' => "email_verification_template", // Optional view page location
					'attachments' => [], // Optional attachments array
					'otp'=>$otp,
				];
					
				$data['to_address']=$email;  //send to partner
				$resp1=$this->sendMail->send($data);  	
				return response()->json(['status'=>1,'msg'=>"Otp Successfully send.!"]);
			}
			catch(\Exception $e)
			{
				\Log::info($e->getMessage());
				return response()->json(['status'=>0,'msg'=>$e->getMessage()]);
			}
		
    }


    public function verifyOtp(Request $request)
    {
        $is_verified = VerificationOtp::where([
                                        ['otp',$request->otp],
                                        ['partner_id',$request->partner_id]
                                    ])->first();
        if($is_verified)
        {
            Partner::where('id',$request->partner_id)->update(['email_verified_at'=>now()]);
			
            return response()->json(['status'=>1,'msg'=>'Email verification successfull !!!']);
        }
        else{
            return response()->json(['status'=>0,'msg'=>'OTP does not match !!!']);
        }
    }


    public function getPlans(Request $request)
    {
        $list = ProductAndService::where('type',$request->plan_type)->get();
        $arr = [];
        $opt='';
        $select_code = '';
        foreach ($list as $key => $value)
        {
            $str = '';
            $str.=$value->plan_name." ".$value->users." users ".$value->pricing." per month";
            $opt.= '<option value='.$value->id.'>'.$str.'</option>';
            $arr[$value->id] = $str;

        }
        $select_code = $select_code.$opt;
        return response()->json(['data'=>$select_code]);
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
	
	public function settings()
    {
        $partner = Auth::guard('partner')->user();
        $leads = Lead::where('partner_id',$partner->id)->get();
        $open_leads = $leads->where('lead_status',"New")->count();
        $business_leads = $leads->where('lead_status',"Got Business")->count();
        $total_leads = $leads->count();
        $countries = CountryState::getCountries();
        if($partner->country!=null)
        {
            $states = CountryState::getStates($partner->country);
        }
        else{
            $states = [];
        }

		//check profile is update------------
		$profile_update_status=Partner::whereId(Auth::user()->id)->pluck('profile_update_status')->first();

		$update_message="";
		if($profile_update_status==0)
		{
			$update_message="<strong>Your profile not completed</strong>, Please complete your profile ";
		}
		
        return view('partner.settings',compact('partner','countries','states','open_leads','business_leads','total_leads','update_message'));
    }
	
	
    public function updateProfile(Request $request)
    {
        // dd($request->all());
        $partner = Partner::where('id',$request->partner_id)->first();
        $partner->name = request('partner_name');
		$partner->country_code = request('country_code');
        $partner->mobile = request('mobile');
        $partner->company_name = request('company_name');
        $partner->email = request('email');
        $partner->website = request('website');
        $partner->team_size = request('team_size');
        $partner->country = request('country')??null;
		$partner->country_name = request('country_name')??null;
        $partner->state = request('state')??null;
		$partner->city = request('city')??null;
        $partner->pin_code = request('pin_code')??null;
		$partner->profile_update_status=1;
		
        if($request ->file('photo'))
        {
            $fileName = time().'P.'.$request->photo->extension();  
            $request->photo->move(public_path('uploads/partner/'), $fileName);
            $partner->photo = $fileName;
        }
        if($request ->file('logo'))
        {
            $logoName = time().'L.'.$request->logo->extension();  
            $request->logo->move(public_path('uploads/partner/'), $logoName);
            $partner->company_logo = $logoName;
        }
        $save = $partner->save();
		
        return redirect()->route('partner.settings')->with('success','Your profile has been updated successfully !!!');;
    }

    public function updateAccountDetails(Request $request)
    {
			
        $partner = Partner::where('id',$request->partner_id)->first();
        $partner->bank_name = $request->bank_name;
        $partner->ifsc = $request->ifsc_code;
        $partner->branch = $request->branch_name;
        $partner->account_number = $request->account_number;
        $partner->upi_id = $request->upi_id;
        $partner->save();

        return response()->json(['status'=>1]);
    }

    public function changePassword(Request $request)
    {
        $id = Auth::guard('partner')->user()->id;
        $partner = Partner::where('id',$id)->first();

        if(Hash::check($request->current_password, $partner->password))
        {
            $partner->password = \Hash::make($request->new_password);
            $partner->save();

            return response()->json(['status'=>1,'msg'=>'Password updated succesfully !!!']);
        }
        else
        {
            return response()->json(['status' => 0, 'msg' => 'Old password does not match !!!']);
        }
    }



  
  
  
  // NEWS -----------
  
  
  public function news()
  {
    
	$news=News::latest()->get();
	return view('partner.news',compact('news'));  
	  
  }
    
  public function getNewsData($id)
  {
	$news=News::where('id',$id)->first();  
	return view('partner.news_content',compact('news'));
  }
  
 
//------------------------------------------------------------------------------------

public function notifications()
{
    return view('partner.notification_list');
}
	
public function notificationList(Request $request)
    {
        if ($request->ajax()) {
        $data = Notification::select('notifications.*','partners.name')
		->leftJoin('partners','notifications.partner_id','=','partners.id')->latest()
		->where('notifications.partner_id',Auth::user()->id)
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



public function setNotificationsAsRead()
{
	$partner_id=Auth::guard('partner')->user()->id;
	$new=['status'=>1];
	$result=Notification::where('partner_id',$partner_id)->where('status',0)->update($new);
	return response()->json(['status'=>1]);
}	


public function getLatestNotifications()  //master page notifications top bar
{
	$partner_id=Auth::user()->id;
	$noti=Notification::latest()->where('category',2)->where('partner_id',$partner_id)->where('status',0)->take(10)->get();
	$noti_count=Notification::where('category',2)->where('partner_id',$partner_id)->where('status',0)->count();
	
	$noti_data="";
	foreach($noti as $r)
	{
		$noti_data.='<a href="javascript:;" >
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


//---FORGOT PASSWORD----------------------------------------------------------------------------------

public function forgotPassword()
{
	return view('partner.forgot-password-new');
}

public function verifyPasswordOtp()
{
	$user_email=Session::get('user_email');
	return view('partner.verify-forgot-password-otp',compact('user_email'));
}

public function changeUserPassword()
{
	$user_email=Session::get('user_email');
	return view('partner.auth-change-password',compact('user_email'));
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
		
		$partner=Partner::where('email',$user_email)->first();

		if(!$partner)
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
			  'view' => 'partner.send_otp_mail_template', // Optional view page location
			  'attachments' => [], //Optional attachments array
			  'otp'=>$randomNumber,
		    ];
				
		$this->sendMail->send($data);

		Session::put('user_email',$user_email);
		return redirect('partner/otp-verify');
			
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
		
		$partner=Partner::where('email',$user_email)->first();

		if(!$partner)
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
			return redirect('partner/change-user-password');
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
	
		$result=Partner::where('email',$user_email)->first();
		if(!empty($result))
		{
			$result->password=\Hash::make($npass);
			$result->save();
			
			Session::flash('fp-success', 'Password successfully changed.You can login now!');
			return redirect('partner/login');
		}
		else
		{
			return redirect()->back();
		}
	}
}

//PAYOUT HISTORY

public function payoutHistory(Request $request)
    {
		return view('partner.payouts_history');
    }

public function viewPaymentDetails(Request $request)
    {
		$pid=Auth::user()->id;
		$data = PaymentDetail::select('payment_details.*','leads.name','leads.mobile')
		->leftJoin('leads','payment_details.lead_id','=','leads.id')
		->where(function($q)use($pid)
		{
			$pid!="" ? $q->where('payment_details.partner_id',$pid):'';
		})->get();

		return Datatables::of($data)
				->addIndexColumn()
				->addColumn('name', function($row){
				   
					return $row->name;
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

		$pid=Auth::user()->id;
		$data = PaymentHistory::select('payment_histories.*','leads.name','leads.mobile')
		->leftJoin('leads','payment_histories.lead_id','=','leads.id')
		->where(function($q)use($pid)
		{
			$pid!=0 ? $q->where('payment_histories.partner_id',$pid):'';
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
						$url='a href="'.url('/uploads/receipts')."/".$row->receipt.'" target="_blank">view</a>';
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




  
  //lead status update api -------------------------------------------------
  //example: http://127.0.0.1:8000/update-lead-status?status=cool&mobile=9037164586
    
  /*public function updateLeadStatusFromCrm(Request $request)
  {
	 
		$status=$request->status;
		$mobile=$request->mobile;
		
		try
		{
			if($status!="" and $mobile!="")
			{
				$ndt=['lead_status'=>ucfirst($status)];
				$res=Lead::where('mobile',$mobile)->update($ndt);
				if($res)
				{
					return response()->json(['status'=>true,'Message'=>'Status successfully updated.!']);
				}
				else
				{
					return response()->json(['status'=>false,'Message'=>'Lead does not exist with this number.!']);
				}
			}
			else
			{
				return response()->json(['status'=>true,'Message'=>'Details missing, Try again.!']);
			}
		}
		catch(\Exception $e)
		{
			\Log::info($e->getMessage());
			return response()->json(['status'=>true,'Message'=>$e->getMessage()]);
		}
		
  }
  */
   
 //----------------------------------------------------------------------------------- 

  
}

