<?php

namespace App\Models;

use CodeIgniter\Model;

class SiafModel extends Model
{

    protected $DBGroup              = 'default';
    protected $table                = 'tb_siaf';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = ['comprobante_pago', 'expediente', 'tipo_giro', 'nombres', 'partida_especifica', 'monto', 'fecha_pase', 'orden_compra', 'orden_servicio', 'planilla_viatico', 'recibo_honorarios', 'exp_sgd', 'asunto_sgd'];

    protected $useTimestamps        = true;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';

      public function getDataSiaf(){
        return $this->db->table('tb_siaf s')
                ->select('s.id as id,s.comprobante_pago as comprobante_pago, s.expediente as expediente, 
                tg.tipo_giro as tipo_giro, s.nombres as nombres, s.partida_especifica as partida_especifica,
                s.monto as monto, s.fecha_pase as fecha_pase, s.orden_compra as orden_compra, s.recibo_honorarios as recibo_honorarios, s.monto as monto, s.orden_servicio as orden_servicio, s.planilla_viatico as planilla_viatico, s.exp_sgd as exp_sgd, s.asunto_sgd as asunto_sgd')
              ->join('tipo_giro tg', 's.tipo_giro = tg.id')
              ->orderBy('comprobante_pago', 'DESC')
              ->get()->getResultArray();
      }  

      public function getTipoGiro(){
        return $this->db->table('tipo_giro')
              // ->orderBy('comprobante_pago', 'DESC
              ->get()->getResultArray();
      }  


    public function getRegistro($id){
        return $this->db->table('tb_siaf')
              ->where('id', $id)
              ->get()->getResultArray();
      }  

    public function incrementarComprobanteCorrelativo(){
        $numero_correlativo = $this->getComprobanteCorrelativo();
        $correlativo_actualizado = $numero_correlativo+1;
        
        return $this->db->table('siaf_correlativo sc')
        ->set('sc.correlativo', $correlativo_actualizado)
        ->update();
    }

      public function getComprobanteCorrelativo() {
            $result = $this->db->table('siaf_correlativo sc')
                ->select('sc.correlativo')
                ->get()->getResultArray();
            if (empty($result)) {
                return null;
            }
            return (int) $result[0]['correlativo'];
        }

}