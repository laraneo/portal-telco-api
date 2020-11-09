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
        'idProcessCategory'
    ];

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\ProcessCategory', 'idProcessCategory', 'id');
    }

}
