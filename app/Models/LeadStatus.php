<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class LeadStatus extends Model
{
    use HasFactory;
	
	protected $fillable = [
        'lead_status', 
		];

	protected $hidden = [
        'created_at',
        'updated_at',
    ];

}
