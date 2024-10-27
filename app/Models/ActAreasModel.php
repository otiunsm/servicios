<?php

namespace App\Models;

use CodeIgniter\Model;

class ActAreasModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'act_area';
    protected $primaryKey           = 'idarea';
    protected $useAutoIncrement     = true;
    protected $returnType           = 'array';
    protected $allowedFields        = ['nombre_area', 'descripcion', 'tipo_estado', 'estado_area'];

    public function area_exists($nombreArea, $id = null)
    {
        $builder = $this->db->table($this->table)
            ->where('estado_area', 1)
            ->where('nombre_area', $nombreArea);
        if (!is_null($id)) {
            $builder->where('idarea !=', $id);
        }
        return $builder->countAllResults() > 0;
    }

    public function getareas()
    {
        return $this->db->table($this->table)->get()->getResultArray();
    }

    public function getarea($id)
    {
        return $this->db->table($this->table)->where('idarea', $id)->get()->getRowArray();
    }

    public function toggleEstadoArea($idarea)
    {
        $area = $this->find($idarea);
        $nuevoEstado = $area['estado_area'] == 1 ? 0 : 1;
        return $this->update($idarea, ['estado_area' => $nuevoEstado]);
    }
}
    