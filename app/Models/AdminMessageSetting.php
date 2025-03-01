<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminMessageSetting extends Model
{
    use HasFactory;
	
	 protected $fillable = [ 
		'id','email','whatsapp_no'
		];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
	 
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
	
	
}
