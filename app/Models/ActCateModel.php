<?php

namespace App\Models;

use CodeIgniter\Model;

class ActCateModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'act_categoria_actividad';
    protected $primaryKey           = 'idcategoria_actividad';
    protected $useAutoIncrement     = true;
    protected $returnType           = 'array';
    protected $allowedFields        = ['nombre_c', 'estado_cate'];

    // Verificar si la categoría ya existe
    public function categoria_exists($nombreCate, $id = null)
    {
        $builder = $this->db->table($this->table)
            ->where('estado_cate', 1)
            ->where('nombre_c', $nombreCate);
        if (!is_null($id)) {
            $builder->where('idcategoria_actividad !=', $id);
        }
        return $builder->countAllResults() > 0;
    }

    // Obtener todas las categorías
    public function getcategorias()
    {
        return $this->db->table($this->table)->get()->getResultArray();
    }

    // Obtener una categoría específica por ID
    public function getcategoria($id)
    {
        return $this->db->table($this->table)->where('idcategoria_actividad', $id)->get()->getRowArray();
    }

    // Cambiar el estado de una categoría específica
    public function toggleEstadoCategoria($idcategoria)
    {
        $categoria = $this->find($idcategoria);
        $nuevoEstado = $categoria['estado_cate'] == 1 ? 0 : 1;
        return $this->update($idcategoria, ['estado_cate' => $nuevoEstado]);
    }

    // Obtener todas las categorías activas
    public function selectcategorias()
    {
        return $this->db->table($this->table)
            ->where('estado_cat', 1)
            ->get()->getResultArray();
    }   
}
