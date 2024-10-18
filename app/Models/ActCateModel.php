<?php

namespace App\Models;

use CodeIgniter\Model;

class ActCateModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'act_categoria_actividad';
    protected $primaryKey           = 'idcategoria_actividad';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = ['nombre_c','estado_cate'];

    public function valid_cate($id, $cateName) {
        $builder = $this->db->table('act_categoria_actividad')
                            ->where('nombre_c', $cateName)
                            ->where('estado_cate', 1);
        if ($id) {
            $builder->where('idcategoria_actividad !=', $id);  // Excluir la categoría actual al actualizar
        }
        return $builder->get()->getResultArray();
    }
    
        
    public function getcates() {
        return $this->db->table('act_categoria_actividad')
            ->where('estado_cate', 1) // Solo dependencias activas
            ->get()->getResultArray();
    }

    public function getcate($id) {
        return $this->db->table('act_categoria_actividad')
            ->where('estado_cate', 1)
            ->where('idcategoria_actividad', $id)
            ->get()->getRowArray();  // Obtener solo un registro
    }

    public function updateValidcate($id, $nombreCate) {
        $builder = $this->db->table('act_categoria_actividad')
            ->where('estado_cate', 1)
            ->where('nombre_c', $nombreCate);

        if (!is_null($id)) {
            $builder->where('idcategoria_actividad !=', $id); // Excluir la dependencia actual
        }

        return $builder->get()->getResultArray();
    }
}
