<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

use  App\Models\Partner;

class partnerExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
	
	protected $status =null;
		

	function __construct($status)
	{
		$this->status=$status;
	}
	
	
	 public function headings():array{
        return[
            'Id','Name','Email','Mobile','Company_name','Website','Country','State','City','Pin_Code','Status'
        ];
		
    } 
	
    public function collection()
    {
		$status=$this->status;
        
		if($this->status=="All"){ $status=""; }
		
		
		$dts=Partner::latest('partners.created_at')
				->select('id','name','email','mobile','company_name','website','country','state','city','pin_code','status');
			
		if($status!="")
		{
			$dts->where('partners.status',$status);
		}
		
		$pdata=$dts->orderBy('partners.id','ASC')->get()->map(function ($q){
			if($q->status==1)
			{
				$q->status="Active";
			}
			else
			{
				$q->status="Inactive";
			}
			return $q;			
		});

		return collect($pdata);   

    }
}
