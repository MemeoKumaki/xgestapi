<?php

namespace xgestapi;

use Illuminate\Database\Eloquent\Model;

class Centro extends Model
{
    protected $table = 'fccen001';
    protected $primaryKey = ['ZCLI', 'ZCEN'];
    protected $fillable = ['ZCLI', 'ZCEN', 'ZNOM', 'ZDOM', 'ZCODPO', 'ZPOB', 'ZPAIS', 'ZTEL'];    
    
    public $incrementing = false;
    public $timestamps = false;    
    
    
    protected $attributes = [
        'ZOBS'       => '',
    ];    
    
}
