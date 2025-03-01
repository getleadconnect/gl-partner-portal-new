<?php

namespace App\Services;

use App\Models\BussinessCategory;
use App\Models\Lead;

use Auth;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;


trait ApiService
{
	
  public function sendLeadToCrm($data) 
  {	

	$endpoint = "https://app.getlead.co.uk/api/gl-website-contacts";
	$client = new \GuzzleHttp\Client();

		$bcat=BussinessCategory::where('id',$data['bussiness_category_id'])->pluck('bussiness_category_name')->first();
		
			$refBy=Auth::user()->name.",".Auth::user()->mobile;
		
			$params=[
				"token"=>"gl_d52aa6241238b4e44d9b",
				"name"=>$data['name'],
				"countrycode"=>$data['country_code'],
				"mobileno"=>$data['mobile'],
				"email"=>$data['email'],
				"feedback"=>$data['feedback'],
				"source"=>"Digital Partners",
				"Referred By"=>$refBy,
				"company_name"=>$data['company_name'],
				"Industry"=>$bcat,
				"address"=>$data['address']??null,
				"remarks"=>$data['remarks']??null,
			];

	$response = $client->request('GET', $endpoint, ['query' => $params]);
	$statusCode = $response->getStatusCode();
	//$content = $response->getBody()->getContents();
	$content=json_decode($response->getBody()->getContents(), true);

return $content;

}



public function sendPartnerDetailToCrm($data) 
  {	

	$endpoint = "https://app.getlead.co.uk/api/gl-website-contacts";
	$client = new \GuzzleHttp\Client();

			$params=[
				"token"=>"gl_d52aa6241238b4e44d9b",
				"name"=>$data['name'],
				"countrycode"=>$data['country_code'],
				"mobileno"=>$data['mobile'],
				"email"=>$data['email'],
				"company_name"=>$data['company_name'],
				"source"=>"Digital Partners",
			];

	$response = $client->request('GET', $endpoint, ['query' => $params]);
	$statusCode = $response->getStatusCode();
	//$content = $response->getBody()->getContents();
	$content=json_decode($response->getBody()->getContents(), true);

return $content;
}


/*public function updateLeadStatusFromCrm($data) 
  {	

	$endpoint = "https://app.getlead.co.uk/api/get-lead-status";
	$client = new \GuzzleHttp\Client();
	
	//Case Closed
	 Lead::whereNotIn('lead_status',['Got Business','Case Closed'])
		->chunk(1000, function($leads) use($client,$endpoint){
			foreach($leads as $lead)
			{
				$params=["token"=>"gl_d52aa6241238b4e44d9b","mobile_no"=>$lead->mobile];
				$response = $client->request('POST', $endpoint, ['query' => $params]);
				$content=json_decode($response->getBody()->getContents(), true);

				if(!empty($content['data']))
				{

					//Lead::where('mobile',$lead->mobile)->update(['lead_status'=>$content['data']['status_name']]);
					$lead->lead_status=$content['data']['status_name'];
					$lead->save();
				}
			}
		});

	return true;
}	
*/


}
