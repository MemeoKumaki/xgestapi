<?php

namespace xgestapi;

use Awobaz\Compoships\Database\Eloquent\Model;

class NumeroSerie extends Model
{
    protected $table = 'fcnsr001';

    protected $primaryKey = ['NCODAR', 'NLINEA'];
    
    public $incrementing = false; 
    
            
}
