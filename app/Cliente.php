<?php

namespace xgestapi;


use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'fccli001';
    protected $primaryKey = 'CCODCL';
    protected $fillable = ['CCODCL', 'CNOM', 'CDOM', 'CCODPO', 'CPOB', 'CPAIS', 'CTEL1', 'CDNI', 'CMAIL1', 
                           'CNOMBREWEB', 'CRESCAR4', 'CBLOQUEADO'];
    
    protected $hidden = [ 'CEXTRANJ', 'CCEE', 'CTEL2', 'CTEL3', 'CTEL4', 
                        'CFAX1', 'CFAX2', 'CFAX3', 'CFAX4', 'CMAIL2', 'CMAIL3', 'CMAIL4', 'CMOSCA', 'CVACAC', 'CCLIESP', 
                        'CDNI', 'CDOMFIS', 'CDOMENVFRA', 'CDOMENVMAT', 'CINC', 'COBSFAC', 'CFORPA', 'CBANCO', 'CDOMBA', 'CENT', 
                        'CSUC', 'CDIG', 'CCUE', 'CDIAP1', 'CDIAP2', 'CDIAP3', 'CVENTAS', 'CCOSTE', 'CULFRA', 'CFEULFA', 'CNFRAS', 
                        'CAUTOR', 'CRICONCED', 'CRIEXCED', 'CRIEALB', 'CRIECONTA', 'CDTO', 'CTARI', 'CACEPT', 'CDEBE', 'CHABER', 
                        'CSALDO', 'CEXENIVA', 'CRECARGO', 'CACTIVIDAD', 'CREPRE', 'CTIPCOMI', 'CCONAVAL', 'CIMPAVAL', 
                        'CCOPIASFAC', 'CCOPIASALB', 'COBS', 'CEUROS', 'ACTUALIZAD', 'FECACTU', 'CZONA', 'CTOTRECPEN', 'CPDTVTO', 
                        'CRIETOT', 'CRESNUM1', 'CRESNUM2', 'CRESSN1', 'CRESSN2', 'CRESSN3', 'CRESSN4', 'CRESFEC1', 'CRESFEC2', 
                        'CRESCAR1', 'CRESCAR2', 'CRESCAR3', 'CRESNUM3', 'CRESNUM4', 'CRESNUM5', 'CRESNUM6', 'CRESCAR5', 
                        'CRESCAR6', 'CRESCAR7', 'CEXCLFFEC', 'XUSUARIO', 'XFECALTA', 'CRESSN5', 'CRESSN6', 'CRESSN7', 'CRESSN8', 
                        'CPARGAS', 'CTIPIVAFIJ', 'CCOBPENENL', 'CFACPENENL', 'COBSORD', 'CCODALT', 'CUSUFORPA', 'CFECCONST', 
                        'CCAPSOCIAL', 'CEMPLEADOS', 'CVENULTEJE', 'CRESULTEJE', 'CEJER1', 'CVENEJER1', 'CEJER2', 'CVENEJER2', 'CEJER3', 
                        'CVENEJER3', 'CEJER4', 'CVENEJER4', 'CEJER5', 'CVENEJER5', 'CACCIONIS', 'CADMINIS', 'CFECACDAT', 'CUSUACTDAT', 
                        'CPREGUNCTR', 'CRESPUCTR', 'CBENEJER1', 'CBENEJER2', 'CBENEJER3', 'CBENEJER4', 'CBENEJER5', 
                        'CCIRCUMAIL', 'CCAPCIRCU', 'CTEXPDA', 'CRUTA', 'CRUTAPOS', 'COMICABALB', 'COMICABFAC', 'CMAILENVIO', 
                        'CSERIEDEF', 'CENVPDFFAC', 'CTIPOCLI', 'CCARNET', 'CINT01', 'CINT02', 'CINT03', 'CINT04', 'CINT05', 'CINT06', 
                        'CINT07', 'CINT08', 'CINT09', 'CINT10', 'CINT11', 'CINT12', 'CRUTA2', 'CRUTA2POS', 'CRUTA3', 'CRUTA3POS', 
                        'CDISTANCIA', 'CFECAUTOR', 'CTIPRAP', 'COBJ1', 'COBJ2', 'COBJ3', 'COBJ4', 'COBJ5', 'CTIPODNI', 'CFECSOLRIE', 
                        'CREMITEN', 'CREMITPALE', 'CFACTURAND', 'ccodtarj', 'CAUTGIRREC', 'CDIARECCOB', 'CZONALT', 'CAGENCIA', 
                        'CPAGOPOR', 'CCENDEFEC', 'CPAGAENVAS', 'CEXPORXML', 'CCLIWEB', 'CINT13', 'CINT14', 'CINT15', 'CINT16', 'CINT17', 
                        'CINT18', 'CINT19', 'CINT20', 'CMAXRECALB', 'CSERIMPRI', 'CFACSIEMP', 'CRESNUM7', 'CCUEENL', 'CIBAN', 'CSWIFT', 
                        'CAUTSEPA', 'CFECAUTSEP', 'CSUFIJO', 'CIDACREE', 'CREFMAND', 'CCARTERA', 'CULTMODIF', 'CPSID', 'CCLAVESHA1', 
                        'CINVSUJPAS', 'CDESDEIMP', 'CDTOAPLI', 'CTIPOCLI2', 'CFECCADSUJ', 'CEXENCARGO', 'CSECTOR'];
    
    
    protected $attributes = [
        'CDOMFIS'       => '',
        'CDOMENVFRA'    => '',
        'CDOMENVMAT'    => '',
        'COBS'          => '',
        'COBSORD'       => '',
        'CACCIONIS'     => '',
        'CADMINIS'      => '',
    ];    
    
    public $incrementing = false; 
    public $timestamps = false;    
    
    //Relacion Cliente - Centros
    public function centros()
    {
        return $this->hasMany('xgestapi\Centro', 'ZCLI');
    }
    
    
    //Relacion Cliente - Presupuestos
    public function presupuestos()
    {
        return $this->hasMany('xgestapi\Presupuesto', 'BCODCL')->where('BPED', 0);
    }
    
    
    //Relacion Cliente - Pedidos
    public function pedidos()
    {
        return $this->hasMany('xgestapi\Pedido', 'BCODCL')->where('BPED', '>' ,0);
    }
    
    
    //Relacion Cliente - Albaranes
    public function albaranes()
    {
        return $this->hasMany('xgestapi\Albaran', 'BALBA');
    }
    
    
    //Relacion Ciente - Facturas
    public function facturas()
    {
        return $this->hasMany('xgestapi\Factura', 'FCODCL');
    }
    
    
    public function users(){
        return $this->hasMany('xgestapi\User', 'cliente_xgest');
    }

    
}
