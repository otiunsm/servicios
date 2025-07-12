<?php

namespace App\Models;

use CodeIgniter\Model;

class SegCentrocostosModel extends Model
{
    protected $table = 'centro_de_costos';
    protected $primaryKey = 'idCentro';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;

    protected $allowedFields = [
        'codigocen',
        'nombrecen',
        'descripcion',
        'estado'
    ];

    public function crearCentroCosto($data)
    {
        return $this->insert($data);
    }

    public function obtenerCentrosCostosActivos()
    {
        return $this->where('estado', 1)->findAll();
    }

    public function actualizarCentroCosto($id, $data)
    {
        return $this->update($id, $data);
    }

    public function tieneDependencias($id)
    {
        return $this->db->table('certificados')
            ->where('id_centro_costos', $id)
            ->countAllResults() > 0;
    }

    public function eliminarCentroCosto($id)
    {
        return $this->update($id, ['estado' => 0]);
    }

    public function obtenerCentroCostoPorID($id)
    {
        return $this->find($id);
    }
}

