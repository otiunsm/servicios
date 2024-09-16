<?php

namespace App\Models;

use CodeIgniter\Model;

class SiafDataModel extends Model
{
    protected $DBGroup              = 'connsiaf';
    protected $table                = 'bytsscom_bytsiaf.expediente_fase';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = ['nombre', 'monto', 'fecha'];

    protected $useTimestamps        = false;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';


    public function getDataSiaf($expediente){
        $query = $this->db->table('bytsscom_bytsiaf.expediente_fase f')
        ->select('f.sys_monto_neto as monto')
        ->where('f.expediente', $expediente)
        ->where('f.ciclo', 'G')
        ->where('f.fase', 'D')
       ->where('f.ano_eje', '2024')
        ->where('f.sys_estado', 'A');

        $resultados = $query->get()->getResultArray();
       
        $nombreResultado = $this->getDataDocumento($expediente);
        foreach ($resultados as $index => &$registro) {
            $registro['nombre'] = (isset($nombreResultado[$index]['nombre'])?trim($nombreResultado[$index]['nombre']):'');
            $registro['fecha'] = (isset($nombreResultado[$index]['fecha'])?$nombreResultado[$index]['fecha']:'');
        }
        return $resultados;
    }

    public function getDataDocumento($expediente){
        return $this->db->table('bytsscom_bytsiaf.expediente_documento as d')
        ->select('d.nombre as nombre, d.fecha_doc as fecha')
        ->where('d.expediente', $expediente)
        ->get()->getResultArray();
    }

    public function getDataporGirarSiaf(){
        return $this->db->table('bytsscom_bytsiaf.expediente_fase f')
           ->select('f.sys_monto_neto as monto')
        //    ->where('f.expediente', $expediente)
           ->where('f.ciclo', 'G')
           ->where('f.fase', 'D')
           ->where('f.sys_estado', 'A')
            ->get()->getResultArray();
    }    

    public function getDataporGirarSiafDetalle($expediente){
        return $this->db->table('bytsscom_bytsiaf.expediente_documento_copy1 d')
           ->select('d.nombre as nombre, d.monto as monto')
           ->where('d.expediente', $expediente)
            ->get()->getResultArray();
    }
}
