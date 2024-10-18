<?php

namespace App\Models;

use CodeIgniter\Model;

class ActAreasModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'act_area';
    protected $primaryKey           = 'idarea';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = ['nombre_area', 'descripcion','tipo_estado','estado_area'];

    // Método para verificar si ya existe un área con el mismo nombre
    public function area_exists($nombreArea, $id = null)
    {
        $builder = $this->db->table($this->table)
            ->where('estado_area', 1) // Solo áreas activas
            ->where('nombre_area', $nombreArea);

        if (!is_null($id)) {
            $builder->where('idarea !=', $id); // Excluir el área actual si se está actualizando
        }

        return $builder->countAllResults() > 0; // Retorna true si ya existe el área
    }

    // Método para obtener todas las áreas activas
    public function getareas()
    {
        return $this->db->table($this->table)
            ->where('estado_area', 1) // Solo áreas activas
            ->get()->getResultArray();
    }

    // Método para obtener una área específica
    public function getarea($id)
    {
        return $this->db->table($this->table)
            ->where('estado_area', 1)
            ->where('idarea', $id)
            ->get()->getRowArray(); // Obtener solo un registro
    }

    // Validar si se puede actualizar un área con un nombre sin duplicarlo
    public function updateValidArea($id, $nombreArea)
    {
        $builder = $this->db->table($this->table)
            ->where('estado_area', 1)
            ->where('nombre_area', $nombreArea);

        if (!is_null($id)) {
            $builder->where('idarea !=', $id); // Excluir el área actual al hacer la validación
        }

        return $builder->get()->getResultArray();
    }
    
}


