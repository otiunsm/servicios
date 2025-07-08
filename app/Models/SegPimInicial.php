<?php

namespace App\Models;

use CodeIgniter\Model;

class SegPimInicial extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pim_iniciales';
    protected $primaryKey       = 'id_pim_inicial';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'id_certificado',
        'id_centro_costos',
        'id_categoria',
        'id_programa',
        'id_fuente',
        'id_meta',
        'id_clasificador',
        'monto_pim',
        'fecha_registro'
    ];

    /**
     * Verifica si ya existe un registro de PIM inicial para la combinación
     */
    public function existePIMInicial($idCategoria, $idPrograma, $idFuente, $idMeta, $idClasificador, $idCentro)
    {
        return $this->where([
            'id_categoria' => $idCategoria,
            'id_programa' => $idPrograma,
            'id_fuente' => $idFuente,
            'id_meta' => $idMeta,
            'id_clasificador' => $idClasificador,
            'id_centro_costos' => $idCentro
        ])->countAllResults() > 0;
    }

    /**
     * Crea un registro de PIM inicial
     */
    public function registrarPIMInicial($data)
    {
        return $this->insert($data);
    }

    /**
     * Actualiza el monto del PIM inicial si se edita la nota original
     */
    public function actualizarMontoPorCertificado($idCertificado, $nuevoMonto)
    {
        return $this->where('id_certificado', $idCertificado)
                    ->set('monto_pim', $nuevoMonto)
                    ->update();
    }

    /**
     * Obtiene el PIM inicial según la combinación presupuestal
     */
    public function obtenerPIMInicial($idCategoria, $idPrograma, $idFuente, $idMeta, $idClasificador, $idCentro)
    {
        return $this->where([
            'id_categoria' => $idCategoria,
            'id_programa' => $idPrograma,
            'id_fuente' => $idFuente,
            'id_meta' => $idMeta,
            'id_clasificador' => $idClasificador,
            'id_centro_costos' => $idCentro
        ])->first();
    }

    /**
     * Verifica si el certificado actual corresponde al PIM inicial
     */
    public function esCertificadoPIMInicial($idCertificado)
    {
        return $this->where('id_certificado', $idCertificado)->countAllResults() > 0;
    }
}
