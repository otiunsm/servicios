<?php

namespace App\Models;

use CodeIgniter\Model;

class SegProgramaPresupuestalModel extends Model
{
    protected $table = 'programas_presupuestales';
    protected $primaryKey = 'id_programa';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;

    protected $allowedFields = [
        'codigo_programa',
        'nombre_programa',
        'descripcion',
        'estado'
    ];

    // Crear un nuevo programa
    public function crearPrograma($data)
    {
        return $this->insert($data);
    }

    // Obtener todos los programas activos
    public function obtenerProgramasActivos()
    {
        return $this->findAll();
    }

    // Actualizar un programa existente
    public function actualizarPrograma($id, $data)
    {
        return $this->update($id, $data);
    }

    // Eliminar (cambiar estado a inactivo)
    public function eliminarPrograma($id)
    {
        return $this->update($id, ['estado' => 0]);
    }

    // Obtener programa por ID
    public function obtenerProgramaPorID($id)
    {
        $builder = $this->db->table('programas_presupuestales'); // Asegúrate de que 'categorias' sea el nombre correcto de la tabla
        $builder->where('id_programa', $id);
        $query = $builder->get();
    
        // Devuelve la fila como un array asociativo
        return $query->getRowArray();
    }
}
