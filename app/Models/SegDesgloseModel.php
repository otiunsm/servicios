<?php

namespace App\Models;

use CodeIgniter\Model;

class SegDesgloseModel extends Model
{
    protected $table = 'desglose';
    protected $primaryKey = ['id_categoria', 'id_programa', 'id_fuente', 'id_meta', 'id_centro_costos'];
    protected $allowedFields = ['nombre_desglose', 'id_categoria', 'id_programa', 'id_fuente', 'id_meta', 'id_centro_costos', 'descripcion', 'estado'];

    // Obtener categorías únicas desde la tabla carpetas
    public function getCategoriasFromCarpetas()
    {
        return $this->db->table('carpetas as c')
            ->select('cat.id_categoria, cat.nombre_categoria')
            ->join('categorias as cat', 'cat.id_categoria = c.id_categoria')
            ->where('c.estado', 1)
            ->where('cat.estado', 1)
            ->groupBy('cat.id_categoria')
            ->get()
            ->getResultArray();
    }

    // Obtener programas por categoría desde carpetas
    public function getProgramasByCategoriaFromCarpetas($id_categoria)
    {
        return $this->db->table('carpetas as c')
            ->select('pp.id_programa, pp.nombre_programa')
            ->join('programas_presupuestales as pp', 'pp.id_programa = c.id_programa')
            ->where('c.id_categoria', $id_categoria)
            ->where('c.estado', 1)
            ->where('pp.estado', 1)
            ->groupBy('pp.id_programa, pp.nombre_programa')
            ->get()
            ->getResultArray();
    }

    // Obtener fuentes por programa desde carpetas
    public function getFuentesByProgramaFromCarpetas($id_programa)
    {
        return $this->db->table('carpetas as c')
            ->select('ff.id_fuente, ff.nombre_fuente')
            ->join('fuentes_financiamiento as ff', 'ff.id_fuente = c.id_fuente')
            ->where('c.id_programa', $id_programa)
            ->where('c.estado', 1)
            ->where('ff.estado', 1)
            ->groupBy('ff.id_fuente')
            ->get()
            ->getResultArray();
    }

    // Obtener metas por fuente desde carpetas
    public function getMetasByFuenteFromCarpetas($id_fuente)
    {
        return $this->db->table('carpetas as c')
            ->select('m.id_meta, m.nombre_meta')
            ->join('metas as m', 'm.id_meta = c.id_meta')
            ->where('c.id_fuente', $id_fuente)
            ->where('c.estado', 1)
            ->where('m.estado', 1)
            ->groupBy('m.id_meta')
            ->get()
            ->getResultArray();
    }

    // Obtener centros de costos activos
    public function getCentrosCostos()
    {
        return $this->db->table('centro_de_costos')
            ->where('estado', 1)
            ->get()
            ->getResultArray();
    }

    // Guardar nuevo desglose
    public function guardarDesglose($data)
    {
        return $this->insert($data);
    }

    // Obtener todos los desgloses
    public function getDesgloses()
    {
        return $this->db->table('desglose as d')
            ->select('
                d.id_categoria,
                d.id_programa,
                d.id_fuente,
                d.id_meta,
                d.nombre_desglose,
                d.id_centro_costos,
                MAX(cat.nombre_categoria) as nombre_categoria,
                MAX(pp.nombre_programa) as nombre_programa,
                MAX(ff.nombre_fuente) as nombre_fuente,
                MAX(m.nombre_meta) as nombre_meta,
                GROUP_CONCAT(DISTINCT cc.nombrecen SEPARATOR ", ") as centros_costos
            ')
            ->join('categorias as cat', 'cat.id_categoria = d.id_categoria')
            ->join('programas_presupuestales as pp', 'pp.id_programa = d.id_programa')
            ->join('fuentes_financiamiento as ff', 'ff.id_fuente = d.id_fuente')
            ->join('metas as m', 'm.id_meta = d.id_meta')
            ->join('centro_de_costos as cc', 'cc.idCentro = d.id_centro_costos')
            ->where('d.estado', 1)
            ->groupBy('d.id_categoria, d.id_programa, d.id_fuente, d.id_meta, d.nombre_desglose')
            ->orderBy('d.nombre_desglose, cat.nombre_categoria, pp.nombre_programa, ff.nombre_fuente, m.nombre_meta')
            ->get()
            ->getResultArray();
    }

}
