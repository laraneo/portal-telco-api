<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    protected $table = 'process';
    protected $fillable = [
        'sName', 
        'sPath', 
        'sParams',  
        'nDevFee', 
        'nPlatformFee', 
        'nVendorFee',
        'nPrice',
        'sTypeProcess',
        'nStatus',
    ];

    public $timestamps = false;
}
