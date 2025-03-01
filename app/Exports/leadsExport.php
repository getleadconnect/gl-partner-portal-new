<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

use  App\Models\Lead;

class leadsExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
	
	protected $status =null;
	protected $partner =null;
	protected $payStatus =null;	

	function __construct($status,$partner,$payStatus)
	{
		$this->status=$status;
		$this->partner=$partner;
		$this->payStatus=$payStatus;
	}
	
	
	 public function headings():array{
        return[
            'Id','Name','Email','Mobile','Company_name','Country','State','area','Pin_Code','Status','Payment'
        ];
		
    } 
	
    public function collection()
    {
		$status=$this->status;
		$partner=$this->partner;
		$payStatus=$this->payStatus;
        
		if($this->status=="All"){ $status=""; }
		if($this->partner=="All"){ $partner=""; }
		if($this->payStatus=="All"){ $payStatus=""; }
		
		$dts = Lead::latest()->where(function($q)use($status,$partner,$payStatus)
            {
                $partner!="" ? $q->where('partner_id',$partner):'';
                $status!="" ?$q->where('lead_status',$status):'';
				$payStatus!="" ?$q->where('payment_status',$payStatus):'';
            })
			->select('id','name','email','mobile','company_name','country','state','area','pincode','lead_status','payment_status');
			

		if($status!="")
		{
			$dts->where('leads.lead_status',$status);
		}
		
		if($partner!="")
		{
			$dts->where('leads.partner_id',$partner);
		}
		
		$pdata=$dts->orderBy('leads.id','ASC')->get()->map(function ($q){
			if($q->lead_status==0)
			{
				$q->lead_status="Inactive";
			}
			elseif($q->lead_status==1)
			{
				$q->lead_status="Active";
			}
			elseif($q->lead_status==2)
			{
				$q->lead_status="Pending";
			}
			elseif($q->lead_status==3)
			{
				$q->lead_status="Closed";
			}
			
			//-------------			
			if($q->payment_status==0)
			{
				$q->payment_status="Not Paid";
			}
			elseif($q->payment_status==1)
			{
				$q->payment_status="Paid";
			}
			else
			{
				$q->payment_status="Pending";
			}
						
			return $q;			
		});

		return collect($pdata);   

    }
}
