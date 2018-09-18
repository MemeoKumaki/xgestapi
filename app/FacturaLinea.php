<?php

namespace xgestapi;

use Illuminate\Database\Eloquent\Model;

class FacturaLinea extends Model
{
    protected $table = 'fclia001';
    protected $primaryKey = 'LALBA';
    
    protected $hidden = ["LDIFPREC", "LDTO", "LCOSTE", "CALIDA", "LMARCAS", "LMEDIDAS", "LENT1", "LENT2", "LENT3", "LENT4", "LENT5", 
                        "ACTUALIZAD", "FECACTU", "LAMPDES", "BUSUMODIF", "LRESNUM1", "LRESNUM2", "LRESSN1", "LRESSN2", "LRESSN3", 
                        "LRESSN4", "LRESFEC1", "LBRUTO", "LTARA", "LBULTOS", "LOBSINT", "LPPR", "LPREORIG", "LDTO2", "LDTO3", 
                        "LLARGO", "LANCHO", "LALTO"];    
    
    public function articulo()
    {
        return $this->hasOne('xgestapi\Articulo', 'ACODAR', 'LCODAR');
    }
    
    
    public function numero_serie()
    {
        return $this->hasMany(NumeroSerie::class, 'ACODAR', 'LCODAR');
    }
    
}
