<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use Carbon\Carbon;

class LeadCommission extends Model
{
    use HasFactory;
	
	protected $guarded=[];
	
	
	public static function totalCommission()
    {
        return self::sum('commission_amount');
    }
	
	public static function totalCommissionPaid()
    {
        return self::where('payment_status',1)->sum('commission_amount');
    }
	
	public static function thisWeekCount()
    {

        Carbon::setWeekStartsAt(Carbon::SUNDAY);
        Carbon::setWeekEndsAt(Carbon::SATURDAY);
        return self::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
    }
	
	public static function thisMonthCount()
    {
        return self::whereMonth('created_at', date('m'))->count();
    }
	
	
	public static function totalThisWeek()
    {
        Carbon::setWeekStartsAt(Carbon::SUNDAY);
        Carbon::setWeekEndsAt(Carbon::SATURDAY);
        return self::whereBetween('payment_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('commission_amount');
    }
	
	public static function totalThisMonth()
    {
        return self::whereMonth('payment_date', date('m'))->sum('commission_amount');
    }
	
		
	public static function payoutThisWeek()
    {
        Carbon::setWeekStartsAt(Carbon::SUNDAY);
        Carbon::setWeekEndsAt(Carbon::SATURDAY);
        return self::whereBetween('payment_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('commission_amount');
    }
	
	public static function payoutThisMonth()
    {
        return self::whereMonth('payment_date', date('m'))->sum('commission_amount');
    }
	
	public static function partnerTotalLeadsCount($partner_id)
    {
        return self::where('partner_id',$partner_id)->count();
    }
	
	public static function partnerStatusWiseLeadsCount($partner_id,$status)
    {
        return self::where('partner_id',$partner_id)
		->whereRaw('UPPER(lead_status)=(?)',Str::upper($status))->count();
    }
	
	public static function partnerTotalCommission($partner_id)
    {
        return self::where('partner_id',$partner_id)->sum('commission_amount');
    }
}
