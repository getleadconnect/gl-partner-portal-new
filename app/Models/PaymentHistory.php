<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use Carbon\Carbon;

class PaymentHistory extends Model
{
    use HasFactory;
	
	protected $guarded = [];  
	
	public static function totalPayout($id)
    {
        return self::where('partner_id',$id)->sum('paid_amount');
    }
}
