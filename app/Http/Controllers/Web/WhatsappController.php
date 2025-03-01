<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

use Carbon\Carbon;
use Validator;
use Session;


class WhatsappController extends Controller
{

    public function __construct(){

    }

    public function whatsapp()
    {
	
		$data = [
			'mobile' => '919995338385',
			'template' => "partner_registration_message", // template for WhatsApp
			'parameters'=>[
					["type" => "text","text" => "https://partner.getleadcrm.com/partner/login"]
			],
			'buttons'=>[],
		];
	

		$token="EAAtUQaQveEkBO0gmcNGs7gwa5Q6tch09XviFFSevZAlfUePAuiBHqrY42EdhicnxrQZAPsowjXEARlQaUz2AmoWu7T8rxAxQfWZAE4SjaWvLmazWYd2gscSgC8A1p3dcsJKELfZBW0Kdw9aY3bEYi1PIXSDGjVZA78MCg4Mn0yw76DJYe3rl772KVMgDvKQzp3Sk6svkZB9MhhPkDu";
 
            // Whatsapp API endpoint for sending messages
            $url = 'https://graph.facebook.com/v19.0/107390568652882/messages';

            $parameters = $this->checkParameters($data);
            $buttons = $this->checkButtons($data);
            $components = $this->checkComponents($parameters,$buttons);

            // Send the message
            $params = [
                        "messaging_product" => "whatsapp",
                        "to" => $data['mobile'],
                        "type" => "template"
                    ];
					
            $params['template'] = [
                "name" => $data['template'],
                "language" => [
                    "code" => "en"
                ]
            ];
			
            if(!empty($components['components'])) 
                $params['template']["components"] = $components['components'];


            try {
                $client = new Client();

                $headers = [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '.$token
                ];

                $response = $client->request('POST', $url, [
                    'json' => $params,
                    'headers' => $headers,
                    // 'verify'  => false,
                ]);

                $response = json_decode($response->getBody(),true);
                
                return $response;

            } catch (\Exception $e) {
				\Log::info($e->getMessage());
                return $e->getMessage();
            }

    }

    private function checkParameters($whatsappData){
        if (isset($whatsappData['parameters']))
            return [
                "type" => "body",
                "parameters" => $whatsappData['parameters']
            ];
        else
            return [];
    }

    private function checkButtons($whatsappData){
        if (isset($whatsappData['buttons']))
            return [
                "type" => "button",
                "sub_type" => "url",
                "index" => 0,
                "parameters" => $whatsappData['buttons']
            ];
        else
            return [];
    }

    private function checkComponents($parameters,$buttons){
        $components['components'] = [];
        if (!empty($parameters['parameters']) && !empty($buttons['parameters']))
            $components['components'] = [$parameters,$buttons];
        elseif(!empty($parameters['parameters']))
            $components['components'] = [$parameters];
        elseif(!empty($buttons['parameters']))
            $components['components'] = [$buttons];
        else
            $components['components'] = [];  
    
        return $components;
    }


}
