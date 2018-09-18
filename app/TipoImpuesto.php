<?php

namespace xgestapi;

use Illuminate\Database\Eloquent\Model;

class TipoImpuesto extends Model
{
    //
    protected $table = 'fctiv001';
    protected $primaryKey = 'TCOD';
     
    
    public $timestamps = false;
    public $incrementing = false;    
}
