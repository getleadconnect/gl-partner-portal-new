<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAndService extends Model
{
    use HasFactory;
	
	protected $fillable = [ 
		'plan_name','type','users','month','pricing','status',
    ];
}
