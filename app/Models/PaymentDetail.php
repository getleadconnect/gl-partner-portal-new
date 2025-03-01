<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use Carbon\Carbon;

class PaymentDetail extends Model
{
    use HasFactory;
	
	protected $guarded = [];  
	

	public static function totalCommission()
    {
        return self::sum('commission');
    }
	
	public static function totalCommissionPaid()
    {
        return self::sum('amount');
    }

	public static function totalThisWeek()
    {
        Carbon::setWeekStartsAt(Carbon::SUNDAY);
        Carbon::setWeekEndsAt(Carbon::SATURDAY);
        return self::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('commission');
    }
	
	public static function totalThisMonth()
    {
        return self::whereMonth('created_at', date('m'))->sum('commission');
    }
	
	
	public static function payoutThisWeek()
    {
        Carbon::setWeekStartsAt(Carbon::SUNDAY);
        Carbon::setWeekEndsAt(Carbon::SATURDAY);
        return self::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('amount');
    }
	
	public static function payoutThisMonth()
    {
        return self::whereMonth('created_at', date('m'))->sum('amount');
    }
	
	
}
