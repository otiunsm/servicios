<?php

namespace App\Models;

use CodeIgniter\Model;

class SegCarpetaModel extends Model
{
    protected $table = 'carpetas';
    protected $primaryKey = 'id_carpeta';
    protected $allowedFields = [
        'nombre_carpeta',
        'id_carpeta_padre',
        'id_categoria',
        'id_programa',
        'id_fuente',
        'id_meta',
        'id_clasificador',
        'descripcion',
        'estado'
    ];

    // Obtener carpetas por su padre
    public function obtenerCarpetasPorPadre($idCarpetaPadre = null)
    {
        return $this->where('id_carpeta_padre', $idCarpetaPadre)->findAll();
    }

    // Obtener la jerarquía completa de carpetas
    public function obtenerJerarquiaCarpetas()
    {
        $carpetas = $this->findAll();
        $jerarquia = [];

        foreach ($carpetas as $carpeta) {
            if ($carpeta['id_carpeta_padre'] === null) {
                $jerarquia[] = $this->construirArbol($carpeta, $carpetas);
            }
        }

        return $jerarquia;
    }

    // Construir el árbol de carpetas
    private function construirArbol($carpeta, $carpetas)
    {
        $carpeta['subcarpetas'] = [];

        foreach ($carpetas as $subcarpeta) {
            if ($subcarpeta['id_carpeta_padre'] === $carpeta['id_carpeta']) {
                $carpeta['subcarpetas'][] = $this->construirArbol($subcarpeta, $carpetas);
            }
        }

        return $carpeta;
    }

    public function getProgramaNombre($idPrograma)
{
    $db = \Config\Database::connect();
    $builder = $db->table('programas_presupuestales');
    $builder->select('nombre_programa');
    $builder->where('id_programa', $idPrograma);
    $query = $builder->get();
    
    if ($query->getNumRows() > 0) {
        return $query->getRow()->nombre_programa;
    }
    
    return null;
}


}