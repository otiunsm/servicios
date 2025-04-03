<?php

namespace App\Models;

use CodeIgniter\Model;

class SegMetaModel extends Model
{
    protected $table = 'metas';
    protected $primaryKey = 'id_meta';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;

    protected $allowedFields = [
        'codigo_meta',
        'nombre_meta',
        'codigo_actividad',
        'descripcion',
        'estado'
    ];

    public function crearMeta($data)
    {
        return $this->insert($data);
    }

    public function obtenerMetasActivas()
    {
        return $this->findAll();
    }

    public function actualizarMeta($id, $data)
    {
        return $this->update($id, $data);
    }

    public function eliminarMeta($id)
    {
        return $this->update($id, ['estado' => 0]);
    }

    public function obtenerMetaPorID($id)
    {
        return $this->find($id);
    }
}
