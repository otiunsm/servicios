<?php

namespace App\Models;

use CodeIgniter\Model;

class Act_solicitanteModel extends Model
{
    //protected $DBGroup              = 'default';
    protected $table                = 'act_solicitante';
    protected $primaryKey           = 'id_solicitante';
    protected $useAutoIncrement     = true;
   // protected $insertID             = 0;
    protected $returnType           = 'array';
    //protected $useSoftDeletes       = false;
   // protected $protectFields        = true;
    protected $allowedFields        = ['dni_so', 'nombre_so',  'email_so', 'telefono_so', 'direccion_so', 'cargo_so', 'estado_so'];
    // Dates
    protected $useTimestamps        = false;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';
    protected $deletedField         = 'deleted_at';

    public function getSolicitantes() {
        return $this->db->table('act_solicitante s')   
            ->where('s.estado_so', '1')             
            ->orderBy('s.nombre_so', 'DESC')           
            ->get()->getResultArray();              
    }
    
    public function getSolicitante($id) {
        return $this->db->table('act_solicitante')   // Tabla 'solicitantes'
            ->where(['estado_so' => '1', 'id_solicitante' => $id])  // Filtra por estado activo y por ID
            ->get()
            ->getResultArray();  // Devuelve los resultados como un array
    }
    

    public function solicitante_exists($solicitante)
    {
        return $this->db->table('act_solicitante')
            ->where('dni_so', $solicitante)
            ->get()->getResultArray();
    }

    public function valid_soli($id, $solicitante)
    {
        $query = $this->db->table('act_solicitante')
            ->where('nombre_so', $solicitante)
            ->where('estado_so', 1);
        if ($id != null) {
            $query->where('id_solicitante!=', $id);
        }
        return $query->get()->getResultArray();
    }

    

    public function soli_exists($solicitante)
    {
        return $this->db->table('usuario u')
            ->join('perfil pe', 'u.idperfil_usuario=pe.id_perfil')
            ->where(["u.estado" => '1', "u.usuario" => $solicitante])
            ->get()->getResultArray();
    }
// agregado para listar solicitante.................................................................................
   public function selectsolicitantes($nombre = null, $numDocumento = null) {
        $builder = $this->db->table('act_solicitante')
                            ->select('id_solicitante, nombre_so');
            if ($nombre) {
            $builder->like('nombre_so', $nombre);
        }
        if ($numDocumento) {
            $builder->where('num_doc', $numDocumento);
        }
            return $builder->get()->getResultArray();
    } 

    
}
