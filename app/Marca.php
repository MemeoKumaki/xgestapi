<?php

namespace xgestapi;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $table = 'fcmar001';
    protected $primaryKey = 'MMARCA';
    
    protected $attributes = [
        'MOBS'  => '',
        'MOBS2' => '',
    ];    
    
    protected $hidden = ["MMAIL1", "MMAIL2", "MMAIL3", "MMAIL4", "MRUTAFOTO", "MOBS", "MOBS2", "ACTUALIZAD", "FECACTU", "XUSUARIO", "XFECALTA", "MINCLUWEB",
                        "MICECATID", "MPSID", "MUMODIF", "MULTMODIF"];
    
    public $timestamps = false;
    public $incrementing = false;
    
    
    protected $fillable = ['MMARCA', 'MDESCR', 'MWEB', 'XFECALTA'];    
    
    public function articulos()
    {
        return $this->hasMany(Articulo::class, 'AMARCA', 'MMARCA');
    }
    
}
