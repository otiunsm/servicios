<?php 

namespace App\Models;
use CodeIgniter\Model;

class ActRegistrarModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'act_registro';
    protected $primaryKey           = 'idregistro'; // Ajusta si la clave primaria es diferente
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = [
        'numero', 'nro_carta', 'detalle_actividad', 'fec_registro', 'fec_atencion', 
        'observacion', 'tipo_doc', 'id_dependencia', 'id_solicitante', 
        'idmedio_solicitud', 'id_tipo_asistencia', 'idcategoria_actividad', 
        'id_periodo', 'id_usuario', 'tipo_estado', 'estado_registro'
    ];

    // Dates
    protected $useTimestamps        = false;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';
    protected $deletedField         = 'deleted_at';


    
    // Obtener todos los registros con sus relaciones
    public function getregistrar() {
        return $this->db->table('act_registro a')
            // JOIN con las tablas relacionadas
            ->join('act_dependencia d', 'a.id_dependencia = d.id_dependencia')
            ->join('act_solicitante s', 'a.id_solicitante = s.id_solicitante')
            ->join('act_medio_solicitud ms', 'a.idmedio_solicitud = ms.idmedio_solicitud')
            ->join('act_tipo_asistencia ta', 'a.id_tipo_asistencia = ta.id_tipo_asistencia')
            ->join('act_categoria_actividad ca', 'a.idcategoria_actividad = ca.idcategoria_actividad')
            ->join('usuario u', 'a.id_usuario = u.id_usuario', 'left') // left join para usuarios opcionales
            ->select('a.*, d.nombre_dep, s.nombre_so, ms.nombre_solicitud, ta.nombre, ca.nombre_c, u.nombre')
            ->orderBy('a.idregistro', 'DESC')
            ->get()->getResultArray();
    }

    // Validar un registro por número
    public function valid_registro($numero) {
        return $this->db->table('act_registro')
            ->where('numero', $numero)
            ->get()->getResultArray();
    }

    // Obtener registro por ID
    public function getregistro($id) {
        return $this->db->table('act_registro')
            ->where('estado_registro', 1)  // Considerar solo registros activos
            ->where('idregistro', $id)
            ->get()
            ->getRowArray();
    }

    // Actualizar validación de registro excluyendo un ID específico
    public function updateValidRegistro($id, $numero) {
        $builder = $this->db->table('act_registro')
            ->where('estado_registro', 1)
            ->where('numero', $numero);

        if (!is_null($id)) {
            $builder->where('idregistro !=', $id); // Excluir el registro actual
        }

        return $builder->get()->getResultArray();
    }
}
