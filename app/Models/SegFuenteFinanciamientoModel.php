<?php

namespace App\Models;

use CodeIgniter\Model;

class SegFuenteFinanciamientoModel extends Model
{
    protected $table = 'fuentes_financiamiento';
    protected $primaryKey = 'id_fuente';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;

    protected $allowedFields = [
        'codigo_fuente',
        'nombre_fuente',
        'descripcion',
        'estado'
    ];

    public function crearFuente($data)
    {
        return $this->insert($data);
    }

    public function obtenerFuentesActivas()
    {
        return $this->findAll();
    }

    public function actualizarFuente($id, $data)
    {
        return $this->update($id, $data);
    }

    public function eliminarFuente($id)
    {
        return $this->update($id, ['estado' => 0]);
    }

    public function obtenerFuentePorID($id)
    {
        return $this->find($id);
    }
}
