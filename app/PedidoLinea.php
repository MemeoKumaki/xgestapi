<?php

namespace xgestapi;

use Illuminate\Database\Eloquent\Model;

class PedidoLinea extends Model
{
    protected $table = 'fcloc001';
    
    protected $primaryKey = 'LPED';
    
    protected $fillable = ['LOFE', 'LLINEA', 'LFECOFE', 'LCODAR', 'LCODCL', 'LCANTI', 'LPRECI', 
        'LIMPOR', 'LCANPEN', 'LALMACEN', 'LTIPIVA', 'LPORCIVA', 'LPORCREC', 'LIMPCONIVA'];    
    
    protected $hidden = ["LPLAZO","LLIQUID","LCOSTE","LAMPDES","ACTUALIZAD","FECACTU","LRESNUM1","LRESNUM2","LRESSN1","LRESSN2","LRESSN3",
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


}
