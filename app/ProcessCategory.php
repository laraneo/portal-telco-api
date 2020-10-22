<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcessCategory extends Model
{
    protected $table = 'process_category';
    protected $fillable = [
        'sName', 
        'nStatus',
    ];

    public $timestamps = false;
}
