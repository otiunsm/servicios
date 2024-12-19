<?php

namespace App\Models;
use CodeIgniter\Model;

class Act_registroModel extends Model
{
    //protected $DBGroup              = 'default';
    protected $table                = 'act_registro';
    protected $primaryKey           = 'idregistro';
    protected $useAutoIncrement     = true;
    protected $returnType           = 'array';

    protected $allowedFields        = [
        'numero',
        'fec_doc_sgd',
        'nro_carta',
        'detalle_actividad',
        'fec_registro',
        'fec_atencion',
        'tipo_doc',
        'id_dependencia',
        'id_solicitante',
        'tipo_solicitud',
        'tipo_asistencia',
        'medio_solicitud',
        'id_categoria_actividad',
        'id_usuario',
        'estado_r',
        'otras_atenciones',
        'observacion',
        'act_eliminar'
    ];
    // Dates
    protected $useTimestamps        = false;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';
    protected $deletedField         = 'deleted_at';


    public function getRegistros($id, $idperfil)
    {
        $builder = $this->db->table('act_registro ar')
            ->join('act_dependencia d', 'ar.id_dependencia = d.id_dependencia')
            ->join('act_solicitante s', 'ar.id_solicitante = s.id_solicitante')
            ->join('act_categoria_actividad ca', 'ar.id_categoria_actividad = ca.id_categoria_actividad')
            ->join('usuario u', 'ar.id_usuario = u.id_usuario')
            ->where('ar.act_eliminar', '1');
        if ($idperfil != 1) {
            $builder->where('ar.id_usuario', $id);
        }

        return $builder->orderBy('ar.idregistro', 'DESC')->get()->getResultArray();
    }

    public function getRegistroscopia($id, $idperfil, $fechainicio, $fechafin)
    {
        $builder = $this->db->table('act_registro ar')
            ->join('act_dependencia d', 'ar.id_dependencia = d.id_dependencia')
            ->join('act_solicitante s', 'ar.id_solicitante = s.id_solicitante')
            ->join('act_categoria_actividad ca', 'ar.id_categoria_actividad = ca.id_categoria_actividad')
            ->join('usuario u', 'ar.id_usuario = u.id_usuario')
            ->where('ar.act_eliminar', '1'); 
    
        // Verificar si no es el perfil 1 y filtrar por usuario
        if ($idperfil != 1) {
            $builder->where('ar.id_usuario', $id);
        }
    
        // Filtrar por fecha de inicio y fin si existen
        if (!empty($fechainicio)) {
            $builder->where('ar.fec_registro >=', $fechainicio);
        }
        if (!empty($fechafin)) {
            $builder->where('ar.fec_registro <=', $fechafin);
        }
    
        return $builder->orderBy('ar.idregistro', 'DESC')->get()->getResultArray();
    }
    

    public function getRegistro($id)
    {
        return $this->db->table('act_registro ar')
            ->join('act_dependencia d', 'ar.id_dependencia = d.id_dependencia')
            ->join('act_solicitante s', 'ar.id_solicitante = s.id_solicitante')
            ->join('act_categoria_actividad ca', 'ar.id_categoria_actividad = ca.id_categoria_actividad')
            ->join('usuario u', 'ar.id_usuario = u.id_usuario')
            ->where(['ar.act_eliminar' => '1', 'ar.idregistro' => $id]) 
            ->get()->getResultArray();
    }
    public function valid_registro($id, $registro)
    {
        $query = $this->db->table('act_registro')
            ->where('detalle_actividad', $registro)
            ->where('act_eliminar', 1);
        if ($id != null) {
            $query->where('idregistro!=', $id);
        }
        return $query->get()->getResultArray();
    }

    // Función para actualizar el estado de un registro
    public function actualizarEstado($idregistro, $nuevoEstado)
    {
        $builder = $this->db->table('act_registro');
        $builder->where('idregistro', $idregistro);
        $builder->set('act_eliminar', $nuevoEstado);
        $resultado = $builder->update();
        return $resultado;
    }

 public function estadoActual($idregistro,$estadoactual)
    {
        $builder = $this->db->table('act_registro');
        $builder->where('idregistro', $idregistro,);
        $builder->set('estado_r', $estadoactual);
        $resultado = $builder->update();
        return $resultado;
    }
}
