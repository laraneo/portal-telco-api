<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcessRequest extends Model
{
    //dDate, process_id, nStatus, sSourceFile, sTargetFile, sLogFile, dDateProcessed, user_id
    protected $table = 'process_requests';
    protected $fillable = [
        'dDate', 
        'process_id', 
        'nStatus',  
        'sSourceFile', 
        'sTargetFile', 
        'sLogFile',
        'dDateProcessed',
        'user_id',
        'reference',
        'description',
    ];

    public $timestamps = false;

        /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo('App\Process', 'process_id', 'id');
    }


        /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
