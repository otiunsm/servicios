<?php

namespace App\Models;

use CodeIgniter\Model;

class SegDetalleSeguimientoModel extends Model
{
    protected $table = 'detalle_seguimiento';
    protected $primaryKey = 'id_detalle';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;

    protected $allowedFields = [
        'id_categoria',
        'id_programa',
        'id_fuente',
        'id_meta',
        'id_clasificador',
        'PIA',
        'PIM',
        'PIM_acumulado', 
        'certificado_acumulado',
        'estado'
    ];
    

    // Crear un nuevo detalle de seguimiento
    public function crearDetalle($data)
    {
        return $this->insert($data);
    }

    // Obtener todos los detalles activos
    public function obtenerDetallesActivos()
    {
        return $this->select('detalle_seguimiento.id_categoria,detalle_seguimiento.id_programa, detalle_seguimiento.id_fuente, detalle_seguimiento.id_meta, categorias.nombre_categoria, programas_presupuestales.nombre_programa, fuentes_financiamiento.nombre_fuente, metas.nombre_meta')
        
                    ->join('categorias', 'categorias.id_categoria = detalle_seguimiento.id_categoria')
                    ->join('programas_presupuestales', 'programas_presupuestales.id_programa = detalle_seguimiento.id_programa')
                    ->join('fuentes_financiamiento', 'fuentes_financiamiento.id_fuente = detalle_seguimiento.id_fuente')
                    ->join('metas', 'metas.id_meta = detalle_seguimiento.id_meta')
                    ->where('detalle_seguimiento.estado', 1)
                    ->groupBy('detalle_seguimiento.id_categoria, detalle_seguimiento.id_programa, detalle_seguimiento.id_fuente, detalle_seguimiento.id_meta')
                    ->findAll();
    }
    
    
    
        public function getClasForGroup($id_categoria, $id_programa, $id_fuente, $id_meta)
        {
            return $this->select('clasificadores.id_clasificador, clasificadores.nombre_clasificador')
                        ->join('clasificadores', 'clasificadores.id_clasificador = detalle_seguimiento.id_clasificador')
                        ->where('detalle_seguimiento.id_categoria', $id_categoria)
                        ->where('detalle_seguimiento.id_programa', $id_programa)
                        ->where('detalle_seguimiento.id_fuente', $id_fuente)
                        ->where('detalle_seguimiento.id_meta', $id_meta)
                        ->where('detalle_seguimiento.estado', 1)
                        ->groupBy('clasificadores.id_clasificador')
                        ->findAll();
        }
        /////////////////
// Modelo detalleSeguimientoModel
public function getGroup($id_categoria, $id_programa, $id_fuente, $id_meta)
{
    return $this->db->table('detalle_seguimiento')
        ->select('id_detalle, id_detalle') // Asegúrate de seleccionar el campo 'id_detalle'
        ->where('id_categoria', $id_categoria)
        ->where('id_programa', $id_programa)
        ->where('id_fuente', $id_fuente)
        ->where('id_meta', $id_meta)
        ->get()
        ->getResultArray();
}

        
        /////
            

    // Actualizar un detalle de seguimiento existente
    public function actualizarDetalle($id, $data)
    {
        return $this->update($id, $data);
    }

    public function actualizarAcumulados($id_detalle, $PIM_acumulado, $certificado_acumulado)
    {
        return $this->update($id_detalle, [
            'PIM_acumulado' => $PIM_acumulado,
            'certificado_acumulado' => $certificado_acumulado
        ]);
    }

    // Eliminar (cambiar estado a inactivo)
    public function eliminarDetalle($id)
    {
        return $this->update($id, ['estado' => 0]);
    }

    // Obtener detalle por ID
    public function obtenerDetallePorID($id)
    {
        return $this->find($id);
    }
}