<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationStatus extends Model
{
    use HasFactory;
	
	protected $guarded = [];  

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
	 
    /*protected $hidden = [
        'password',
        'remember_token',
    ];*/

}
