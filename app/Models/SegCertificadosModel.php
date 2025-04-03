<?php

namespace App\Models;

use CodeIgniter\Model;

class SegCertificadosModel extends Model
{
    protected $table = 'certificados';
    protected $primaryKey = 'id_certificado';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;

    protected $allowedFields = [
        'id_detalle',
        'codigo_transaccion',
        'fecha',
        'detalle',
        'modificacion',
        'certificacion_monto',
        'certificacion_rebaja',
        'certificacion_ampliacion',
        'estado',
        'id_centro_costos'

    ];

    // Crear un nuevo certificado
    public function crearCertificado($data)
    {
        return $this->insert($data);
    }

    // Obtener todos los certificados activos
    public function obtenerCertificadosActivos()
    {
        return $this->where('estado', 1)->findAll();
    }

    // Actualizar un certificado existente
    public function actualizarCertificado($id, $data)
    {
        return $this->update($id, $data);
    }

    // Eliminar (cambiar estado a inactivo)
    public function eliminarCertificado($id)
    {
        return $this->update($id, ['estado' => 0]);
    }

    // Obtener certificado por ID
    public function obtenerCertificadoPorID($id)
    {
        return $this->find($id);
    }
}
