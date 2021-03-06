<?php

namespace xgestapi;

use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    protected $table = 'fccoc001';
    protected $primaryKey = 'BOFE';
    protected $fillable = ['BOFE', 'BPED', 'BESPED', 'BCODCL', 'BFECOFE', 'BHORAOFE', 'BLIQUID', 'BALMACEN'];
    protected $hidden = ["BFECPED", "BPLAZO", "BTOBRU", "BTOCOS","BOBSE", "BUSUARIO","BINSPECC","BOBSEINSP","ACTUALIZAD","FECACTU","BHORAPED","BDTO","BRESNUM1","BRESNUM2","BRESSN1","BRESSN2",
                        "BRESSN3", "BRESSN4","BRESFEC1","BRESCAR1","BCODREP","BRESNUM3","BRESNUM4","BUSUMODIF","BREVISION","BPARGAS","BCENTRO","BOBSINT","BFORPA","BOBSENTREG","BAGENCIA","BPALETS",
                        "BULTIMPORD","BREVOFE","BUSUREVOFE","BREVPED","BUSUREVPED","BPEDDESWEB","BFHOPEDWEB","BPAGOPOR","BRECARGO","BFORPAWEB","BPAGADOWEB","BIMPROFE","BIMPRPED","BDEPOSITO","BPSID",
                        "BTIPIVAFIJ","BIVAINCL","BDTONORM","BDTOADIC"];
    
    protected $attributes = [
        'BOBSE'         => '',
        'BOBSEINSP'     => '',
        'BOBSINT'       => '',
        'BOBSENTREG'    => '',
    ];
    
    public $timestamps = false;
    public $incrementing = false;
    
    public function lineas()
    {
        return $this->hasMany(PresupuestoLinea::class, 'LOFE', 'BOFE');
    }
       
    

    

    

    
}
