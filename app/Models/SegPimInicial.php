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
    protected $allowedFields    = ['id_certificado', 'id_centro_costos', 'monto_pim', 'fecha_registro'];

    // Verifica si ya existe un registro para el centro de costo
    public function existeParaCentro($idCentro)
    {
        return $this->where('id_centro_costos', $idCentro)->countAllResults() > 0;
    }

    // Crea un nuevo registro de PIM inicial
    public function crearPimInicial($idCertificado, $idCentro, $monto)
    {
        return $this->insert([
            'id_certificado' => $idCertificado,
            'id_centro_costos' => $idCentro,
            'monto_pim' => $monto
        ]);
    }

    // Puedes agregar otros métodos si deseas consultar historiales u obtener datos
}
