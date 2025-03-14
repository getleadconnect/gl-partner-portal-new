<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use Carbon\Carbon;

class Lead extends Model
{
    use HasFactory;
	
	
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
	
	public static function payoutThisWeek()
    {
        Carbon::setWeekStartsAt(Carbon::SUNDAY);
        Carbon::setWeekEndsAt(Carbon::SATURDAY);
        return self::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('commission_amount');
    }
	
	public static function payoutThisMonth()
    {
        return self::whereMonth('created_at', date('m'))->sum('commission_amount');
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
	
	
}
