<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Partner;

class ConnectionController extends Controller
{
    public function getPartners()
    {
        $partners = Partner::latest()->select('id','name','mobile','company_name')->get();
        return response()->json(['success'=>true,'data'=>$partners]);
    }
}
