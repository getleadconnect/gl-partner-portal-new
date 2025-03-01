<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationOtp extends Model
{
    use HasFactory;

    protected $table = 'verification_otps';

    protected $fillable = ['id','partner_id','email','otp','created_at','updated_at'];

}
