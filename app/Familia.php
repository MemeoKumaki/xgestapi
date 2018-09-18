<?php

namespace xgestapi;

use Illuminate\Database\Eloquent\Model;

class Familia extends Model
{
    protected $table = 'fcfcp001';
    protected $primaryKey = 'FCOD';

    
    protected $fillable = ['FCOD', 'FDES', 'FOBS', 'XFECALTA', 'META_DESC', 'FGRUPO'];
    
    protected $hidden = ["FRESNUM1", "FRESNUM2", "FRESSN1", "FRESSN2", "FRESSN3", "FRESSN4", "FRESFEC1", "FRESFEC2",
                        "FRESCAR1", "FRESCAR2", "FRESCAR3", "XFECALTA", "FMARMIN", "FINCLTACT", "FEXCLRAP", "FDECREDDTO",
                        "FOSCCOD", "FRESNUM3", "URL_AMIGAB", "META_KEYS", "FORDENAR", "FICECATID", "FTARIWEB", "FPROVUNICO",
                        "FSECBAS25H", "FPSCOD", "FUMODIF", "FINVSUJPAS", "FCODCARGO"];
    
    protected $attributes = [
        'FOBS'      => '',
        'META_KEYS' => '',
        'META_DESC' => '',

    ];      
    
    public $timestamps = false;
    public $incrementing = false;
    
    
    public function categoria(){
        return $this->belongsTo(Categoria::class, 'FGRUPO', 'GCOD');
    }
    
    
    public function articulos(){        
        return $this->hasMany(Articulo::class, 'ARESNUM4');
    }
    
}
