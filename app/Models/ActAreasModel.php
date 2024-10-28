<?php

namespace App\Models;

use CodeIgniter\Model;

class ActAreasModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'act_area';
    protected $primaryKey           = 'id_area';
    protected $useAutoIncrement     = true;
    protected $returnType           = 'array';
    protected $allowedFields        = ['nombre_area', 'descripcion', 'tipo_estado', 'estado_a'];

    public function area_exists($nombreArea, $id = null)
    {
        $builder = $this->db->table($this->table)
            ->where('estado_a', 1)
            ->where('nombre_area', $nombreArea);
        if (!is_null($id)) {
            $builder->where('id_area !=', $id);
        }
        return $builder->countAllResults() > 0;
    }

    

    public function getareas()
    {
        return $this->db->table($this->table)->get()->getResultArray();
    }

    public function getarea($id)
    {
        return $this->db->table($this->table)->where('id_area', $id)->get()->getRowArray();
    }

    public function toggleEstadoArea($idarea)
    {
        $area = $this->find($idarea);
        $nuevoEstado = $area['estado_a'] == 1 ? 0 : 1;
        return $this->update($idarea, ['estado_a' => $nuevoEstado]);
    }

    public function selectareas()
    {
        return $this->db->table($this->table)
            ->where('estado_a', 1)
            ->get()->getResultArray();
    }
    
}
    