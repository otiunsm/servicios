<?php

namespace App\Models;

use CodeIgniter\Model;

class SegClasificadorModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'clasificadores';
    protected $primaryKey       = 'id_clasificador';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [ 'codigo_clasificador', 'nombre_clasificador', 'descripcion', 'estado'];


    // Crear un nuevo clasificador
    public function createClasificador($data)
    {
        return $this->insert($data);
    }

    // Obtener todos los clasificadores activos de una meta específica --xdxd
    public function getClasificadoresActivos()
    {
        return $this->where('estado', 1)->findAll();
    }

    // Obtener un clasificador por ID
    public function getClasificadorById($id)
    {
        return $this->find($id);
    }

    // Actualizar un clasificador por ID
    public function updateClasificador($id, $data)
    {
        return $this->update($id, $data);
    }

    public function tieneDependencias($id)
    {
        return $this->db->table('detalle_seguimiento')
            ->where('id_clasificador', $id)
            ->countAllResults() > 0;
    }

    // Eliminar (desactivar) un clasificador
    public function eliminarClasificador($id)
    {
        return $this->update($id, ['estado' => 0]);
    }


  
}
