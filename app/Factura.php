<?php

namespace xgestapi;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = 'fcfac001';

    protected $primaryKey = 'FDOC';
    

    protected $hidden = ["FGASFI", "FPEDID", "FFORPA", "FCOSTE", "FENLA", "FMODIF", "FASI", "ACTUALIZAD", "FECACTU", "FSERIE", "FEXENIVA",
                        "FLIQUICOB", "FCOBRCOBR", "FRESNUM1", "FRESNUM2", "FRESSN1", "FRESSN2", "FRESSN3", "FRESSN4", "FRESFEC1",
                        "FRESFEC2", "FRESCAR2", "FOBSE", "FRESNUM3", "FRESNUM4", "FNUMLIQ", "FPIRPF", "FIMPIRPF", "FUSUARIO",
                        "FUSUMODIF", "FPARGAS", "FYAENLA", "FRESUMIDA", "FTIPIVAFIJ", "FFACTIC", "FPDTOGAR", "FDTOGAR", "FDOMENVIO",
                        "FRESUTIC", "FPRITIC", "FULTTIC", "FCANTIC", "FNUMLIQJEF", "FTEXTOREC", "FREVFAC", "FUSUREVFAC", "FRECARGO",
                        "FCLAOPE340", "FFECHORENL", "FIMPRESA", "FULTMODIF", "FRECTIFI", "FPSID", "FINVSUJPAS", "BIVAINCL", 
                        "FAGRARIO", "FIGIC", "FARREND"];
    
    public function lineas()
    {
        return $this->belongsToMany(AlbaranLinea::class, 'fccba001', 'BFACTURA', 'BALBA', 'FDOC');
    }
    
    
    
    
}
