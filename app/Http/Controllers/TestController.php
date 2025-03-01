<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\ImportModel;

class TestController extends Controller
{
    public function importPartner()
    {
       $res =  DB::table('exported_partners')->get();
       $partners = DB::table('business_accounts')->where('admin_approved',0)->get();

        foreach ($partners as $key => $value) {
        //    return $value;
        //    $password = DB::table('users')->where('id',$value->user_id)->first()->password;
           $data = new ImportModel;
           $data->name = $value->name;
           $data->mobile = $value->mobile;
           $data->company_name = $value->company_name;
           $data->email = $value->email;
           $data->website = $value->website;
           $data->team_size = $value->team_size;
           $data->country = $value->country;
           $data->state = $value->state;
           $data->city = $value->city;
           $data->pin_code = $value->pin_code;
           $data->password = bcrypt("12345");
           $data->save();
        }

       return $partners;
    }

    public function importLeads()
    {
       $res =  DB::table('exported_partners')->get();
       $leads = DB::table('clients')->where('partner_id','!=',44)->get();

        foreach ($leads as $key => $value) {
           $user = DB::table('users')->where('id',$value->user_id)->first();
           
           if($value->partner_id == 58)
           {
            $partner_name = 'Gokulakrishnan R';
           }
           else
           {
            $partner_name = DB::table('channel_partners')->where('id',$value->partner_id)->first()->name;
           }
           $partner_id = DB::table('exported_partners')->where('name',$partner_name)->first()->id;
           $data = new ImportModel;
           $data->partner_id = $partner_id;
           $data->email = $user->email;
           $data->designation = $value->designation;
           $data->name = $user->name;
           $data->mobile = $user->mobile;
           $data->company_name = $value->company_name;
           $data->bussiness_category_id = 1;
           $data->country = $value->country;
           $data->state = $value->state;
           $data->area = $value->area;
           $data->pincode = $value->pincode;
           $data->address = $value->address;
           $data->remarks = $value->remarks;
           $data->owner_type = 2;
           $data->payment_status = 0;
           $data->created_at = now();
           $data->updated_at = now();
           $data->save();
        }
    }
}
