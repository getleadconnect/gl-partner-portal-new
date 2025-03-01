<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportModel extends Model
{
    use HasFactory;

    protected $table ='exported_leads';
}
