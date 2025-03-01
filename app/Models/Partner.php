<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Carbon\Carbon;

class Partner extends Authenticatable
{
    
	use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
	 
    protected $fillable = [ 
		'name','email','country_code','mobile','company_name','password','website','commission_percentage',
		'team_size','country','country_name','state','state_name','city','pin_code',
		'email_verified_at','password','agent_id','photo','bank_name',
		'ifsc','branch','account_number','upi_id','company_logo','status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
	 
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['partner_company'];


    public function getPartnerCompanyAttribute()
    {
        if($this->company_name != null)
        {
            return $this->name . ', ' . $this->company_name;
        }
        else
        {
            return $this->name;
        }
 
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
	
	
	
}
