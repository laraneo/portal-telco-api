<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'sName', 
        'nStatus', 
        'sEmail',  
        'sContact', 
    ];

}
