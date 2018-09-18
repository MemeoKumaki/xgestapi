<?php

namespace xgestapi;

use Awobaz\Compoships\Database\Eloquent\Model;

class PresupuestoLinea extends Model
{
    protected $table = 'fcloc001';
    protected $primaryKey = 'LOFE';
    protected $fillable = ['LOFE', 'LLINEA', 'LFECOFE', 'LCODAR', 'LCODCL', 'LCANTI', 'LPRECI', 
        'LIMPOR', 'LCANPEN', 'LALMACEN', 'LTIPIVA', 'LPORCIVA', 'LPORCREC', 'LIMPCONIVA'];    
    
    protected $hidden = ["LPED","LFECPED","LPLAZO","LLIQUID","LCOSTE","LAMPDES","ACTUALIZAD","FECACTU","LRESNUM1","LRESNUM2","LRESSN1","LRESSN2","LRESSN3",
                        "LNUMSERIES","LSECORD","LTXTORD","LCOSADI","LOBSINT","LPPR","LPREORIG","LLARGO","LANCHO","LALTO","LDTO2","LDTO3"];
    
    protected $attributes = [
        'LAMPDES'       => '',
        'LNUMSERIES'    => '',
        'LTXTORD'       => '',
        'LOBSINT'       => '',
    ];
    
    public $timestamps = false;
    public $incrementing = false;    
    
    public function articulo()
    {
        return $this->hasOne(Articulo::class, 'ACODAR', 'LCODAR');
    }
    
    public function presupuesto(){
        return $this->belongsTo(Presupuesto::class, 'BOFE', 'LOFE');
    }
    
}
