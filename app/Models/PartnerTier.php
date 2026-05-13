<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerTier extends Model
{
    use HasFactory;

    protected $table = 'partner_tiers';

    protected $fillable = ['id','partner_tier','tier_color','created_at','updated_at'];
    
    

}
