<?php   

namespace App\Traits;
use Illuminate\Http\Request;

trait LeadNotificationTrait 
{
    public function send_telegram_notification($partner_name,$company_name,$name,$email,$plan,$mobile)
    {
        $botToken = "5455796089:AAFE6beeleWa1iTKhzLGDKrMwJxd30F1o3U";
           
            $data =[
                'chat_id' => '-614845338',
                'text'=> "Hey,
        New Lead Received Via Partner Portal !!!
        ------------------------------------
        Partner => ".$partner_name."
        Comapany Name => ".$company_name.", 
        Client Name => ".$name.",
        Email => ".$email.",
        Plan => ".$plan.",
        Mobile => ".$mobile."",
                ];
        $response = file_get_contents("https://api.telegram.org/bot$botToken/sendMessage?" .http_build_query($data));
    }
	
}