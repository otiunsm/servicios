<?php

namespace App\Models;

use CodeIgniter\Model;

class Act_registroModel extends Model
{
    //protected $DBGroup              = 'default';
    protected $table                = 'act_registro';
    protected $primaryKey           = 'idregistro';
    protected $useAutoIncrement     = true;
    //protected $insertID             = 0;
    protected $returnType           = 'array';
    //protected $useSoftDeletes       = false;
    //protected $protectFields        = true;
    protected $allowedFields        = [
        'numero',
        'fec_doc_sgd',
        'nro_carta',
        'detalle_actividad',
        'fec_registro',
        'fec_atencion',
        'observacion',
        'tipo_doc',
        'id_dependencia',
        'id_solicitante',
        'id_medio_solicitud',
        'id_tipo_asistencia',
        'id_categoria_actividad',
        'id_usuario',
        'estado_r'
    ];
    // Dates
    protected $useTimestamps        = false;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';
    protected $deletedField         = 'deleted_at';


    public function getRegistros()
    {
        return $this->db->table('act_registro ar')
            ->join('act_dependencia d', 'ar.id_dependencia = d.id_dependencia')
            ->join('act_solicitante s', 'ar.id_solicitante = s.id_solicitante')
            ->join('act_medio_solicitud ms', 'ar.id_medio_solicitud = ms.id_medio_solicitud')
            ->join('act_tipo_asistencia ta', 'ar.id_tipo_asistencia = ta.id_tipo_asistencia')
            ->join('act_categoria_actividad ca', 'ar.id_categoria_actividad = ca.id_categoria_actividad')
            ->join('usuario u', 'ar.id_usuario = u.id_usuario')
            ->where('ar.estado_r', '1')  // Filtrar solo los registros activos
            ->orderBy('ar.idregistro', 'DESC')
            ->get()->getResultArray();
    }

    /*public function get_acts() {
        return $this->db->table('act_registro a')
            // JOIN con las tablas relacionadas
            ->join('act_dependencia d', 'a.id_dependencia = d.id_dependencia')
            ->join('act_solicitante s', 'a.id_solicitante = s.id_solicitante')
            ->join('act_medio_solicitud ms', 'a.idmedio_solicitud = ms.idmedio_solicitud')
            ->join('act_tipo_asistencia ta', 'a.id_tipo_asistencia = ta.id_tipo_asistencia')
            ->join('act_categoria_actividad ca', 'a.idcategoria_actividad = ca.idcategoria_actividad')
            ->join('usuario u', 'a.id_usuario = u.id_usuario') // left join para usuarios opcionales
            //->select('a.*, d.nombre_dep, s.nombre_so, ms.nombre_solicitud, ta.nombre, ca.nombre_c,  u.nombre')
            ->where('a.estado_r', '1')
            ->orderBy('a.idregistro', 'DESC')
            ->get()->getResultArray();
    }*/
    

    public function getRegistro($id){
        return $this->db->table('act_registro ar')
            ->join('act_dependencia d', 'ar.id_dependencia = d.id_dependencia')
            ->join('act_solicitante s', 'ar.id_solicitante = s.id_solicitante')
            ->join('act_medio_solicitud ms', 'ar.id_medio_solicitud = ms.id_medio_solicitud')
            ->join('act_tipo_asistencia ta', 'ar.id_tipo_asistencia = ta.id_tipo_asistencia')
            ->join('act_categoria_actividad ca', 'ar.id_categoria_actividad = ca.id_categoria_actividad')
            ->join('usuario u', 'ar.id_usuario = u.id_usuario')
           // ->where('ar.idregistro', $id)  // Filtrar solo por ID del registro Si necesitas mostrar tanto registros activos como inactivos:
            ->where(['ar.estado_r' => '1', 'ar.idregistro' => $id])  // Filtrar por estado activo y ID del registro
            ->get()->getResultArray();
    }
    public function valid_registro($id, $registro){
		$query = $this->db->table('act_registro')
		->where('detalle_actividad', $registro)
		->where('estado', 1);
		if ($id != null) {
			$query->where('idregistro!=', $id);
		}
		return $query->get()->getResultArray();
	}
    
}
