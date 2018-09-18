<?php

namespace xgestapi;

use Awobaz\Compoships\Database\Eloquent\Model;

class Albaran extends Model
{
    protected $table = 'fccba001';

    protected $primaryKey = 'BALBA';
    
    protected $hidden = ["BPEDID", "BTOCOS", "BSECUE", "BPORTES", "BUSUARIO", "BCODREP" , "BBASECOM", "BNUMLIQ", "BFECLIQ", "ACTUALIZAD", "FECACTU", 
                        "BDTO", "BRESNUM1", "BRESNUM2", "BRESSN1", "BRESSN2", "BRESSN3", "BRESSN4", "BRESFEC1", "BRESCAR1", "BUSUMODIF", "BPARGAS", 
                        "BCENTRO", "BENTREGADO", "BOBSENTREG", "BAGENCIA", "BREMENV", "BFECREM", "BOBSINT", "BOBSREMENV", "BLINREMENV", "BOBRA", 
                        "BMATRIC", "BCONDUCTOR", "BTRANSPORT", "BPALETS", "BEXCLPUNT", "BUSUREVALB", "BPAGOPOR", "BRECARGO", "BREEMB", "BIMPRESO", 
                        "BDEPOSITO", "BPSID", "BTIPIVAFIJ", "BIVAINCL", "BALBRELAC", "BDTONORM", "BDTOADIC"];    
    
    public function lineas()
    {
        return $this->hasMany('xgestapi\AlbaranLinea', 'LALBA', 'BALBA');
    }

    
}
