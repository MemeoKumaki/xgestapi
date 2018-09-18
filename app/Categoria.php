<?php

namespace xgestapi;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'fcgrf001';
    protected $primaryKey = 'GCOD';
    
    protected $fillable = ['GCOD', 'GDES', 'GOBS', 'GINCLUWEB', 'XFECALTA', 'META_DESC'];
    protected $hidden = ["GRESNUM1", "GRESNUM2","GRESSN1","GRESSN2","GRESSN3","GRESSN4","GRESFEC1","GRESFEC2","GRESCAR1","GRESCAR2","GRESCAR3",
                        "XUSUARIO","GTEXTOWEB","GINCLTACT","GOSCCOD","URL_AMIGAB","META_KEYS","META_DESC","GORDENAR","GICECATID","GPSCOD","GULTMODIF","GBLOQUE"];

    protected $attributes = [
        'GOBS'      => '',
        'GTEXTOWEB' => '',
        'META_KEYS' => '',
        'META_DESC' => '',

    ];      
    
    public $timestamps = false;
    public $incrementing = false;
    
    
    public function familias(){
        return $this->hasMany('xgestapi\Familia', 'FGRUPO', 'GCOD');
    }
    
    
    public function articulos(){
        return $this->hasManyThrough('xgestapi\Articulo', 'xgestapi\Familia', 'FGRUPO', 'ARESNUM4', 'GCOD', 'FCOD');
    }

    
}
