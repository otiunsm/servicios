<?php

namespace App\Models;

use CodeIgniter\Model;

class ActDepenModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'act_dependencia';
    protected $primaryKey           = 'id_dependencia';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = ['nombre_dep', 'descripcion', 'estado_depen'];

    //valiacion///

    public function valid_depen($depenName){
        return $this->db->table('act_dependencia')
            ->where('nombre_dep', $depenName)
            ->get()->getResultArray();
    }
        
    ///
    public function getdepens() {
        return $this->db->table('act_dependencia')
            ->where('estado_depen', 1) // Solo dependencias activas
            ->get()->getResultArray();
    }

    public function getdepen($id) {
        return $this->db->table('act_dependencia')
            ->where('estado_depen', 1)
            ->where('id_dependencia', $id)
            ->get()->getRowArray();  // Obtener solo un registro
    }

    public function updateValidDepen($id, $nombreDepen) {
        $builder = $this->db->table('act_dependencia')
            ->where('estado_depen', 1)
            ->where('nombre_dep', $nombreDepen);

        if (!is_null($id)) {
            $builder->where('id_dependencia !=', $id); // Excluir la dependencia actual
        }

        return $builder->get()->getResultArray();
    }
}
