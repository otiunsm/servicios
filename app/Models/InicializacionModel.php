<?php

namespace App\Models;

use CodeIgniter\Model;

class InicializacionModel extends Model
{
    protected $table            = 'inicializaciones_presupuestales';
    protected $primaryKey       = 'id_inicializacion';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'id_categoria',
        'id_programa',
        'id_fuente',
        'id_meta',
        'id_clasificador',
        'id_centro_costos',
        'valor_pia',
        'valor_pim',
        'fecha_registro'
    ];

    protected $useTimestamps = false;

    /**
     * Verifica si ya existe inicialización para un clasificador en un centro de costos
     */
    public function existeInicializacion($idCategoria, $idPrograma, $idFuente, $idMeta, $idClasificador, $idCentro)
    {
        return $this->where([
            'id_categoria'      => $idCategoria,
            'id_programa'       => $idPrograma,
            'id_fuente'         => $idFuente,
            'id_meta'           => $idMeta,
            'id_clasificador'   => $idClasificador,
            'id_centro_costos'  => $idCentro
        ])->countAllResults() > 0;
    }

    /**
     * Obtiene una inicialización específica
     */
    public function obtenerInicializacion($idCategoria, $idPrograma, $idFuente, $idMeta, $idClasificador, $idCentro)
    {
        return $this->where([
            'id_categoria'      => $idCategoria,
            'id_programa'       => $idPrograma,
            'id_fuente'         => $idFuente,
            'id_meta'           => $idMeta,
            'id_clasificador'   => $idClasificador,
            'id_centro_costos'  => $idCentro
        ])->first();
    }
}
