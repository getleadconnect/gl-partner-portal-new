<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

use  App\Models\Partner;
use  App\Models\Lead;
use Carbon\Carbon;

class partnerActivityExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
	
	protected $status =null;
		

	function __construct()
	{
		
	}
		
	 public function headings():array{
        return[
            'Unique_Id','Name','Email','Country_code','Mobile','Company_name','Partner Status','Last Lead Name','lead Company','Lead Created At','Status'
        ];
		
    } 
	
    public function collection()
    {
		
	$pdata = Partner::select('partners.unique_id','partners.name','partners.email','partners.country_code','partners.mobile','partners.company_name','partners.status')
				->where('status',1)
				->orderBy('id','DESC')->get()->map(function($q)
				{
					$lead=Lead::where('partner_id',$q->id)->latest()->first();
					if(!empty($lead))
					{
						$q['lead_name']=$lead->name;
						$q['lead_company']=$lead->company_name;
						$q['lead_created_at']=Carbon::parse($lead->created_at)->format('Y-m-d h:i A');
						$q['lead_status']=$lead->lead_status;
					}
					else
					{
						$q['lead_name']="--";
						$q['lead_company']="--";
						$q['lead_created_at']="--";
						$q['lead_status']="--";
					}
				
					if($q->status==1)
					{
						$q->status="Active";
					}
					else
					{
						$q->status="Inactive";
					}

					return $q;
				})->sortByDesc('lead_created_at')
    			->values();

		return collect($pdata);   

    }
}
