<?php

namespace App\Models;

use CodeIgniter\Model;

class SegCategoriaModel extends Model
{
    protected $table = 'categorias';
    protected $primaryKey = 'id_categoria';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;

    protected $allowedFields = [
        'codigo_categoria',
        'nombre_categoria',
        'descripcion',
        'estado'
    ];

    // Crear una nueva categoría
    public function crearCategoria($data)
    {
        return $this->insert($data);
    }

    // Obtener todas las categorías activas
    public function obtenerCategoriasActivas()
    {
        return $this->findAll();
    }

    // Actualizar una categoría existente
    public function actualizarCategoria($id, $data)
    {
        return $this->update($id, $data);
    }

    // Eliminar (cambiar estado a inactivo) una categoría
    public function eliminarCategoria($id)
    {
        return $this->update($id, ['estado' => 0]);
    }

    // Obtener categoría por ID
    public function obtenerCategoriaPorID($id)
    {
        $builder = $this->db->table('categorias'); // Asegúrate de que 'categorias' sea el nombre correcto de la tabla
        $builder->where('id_categoria', $id);
        $query = $builder->get();
    
        // Devuelve la fila como un array asociativo
        return $query->getRowArray();
    }
}
