<?php

namespace App\Controllers;

use App\Models\SegCategoriaModel;
use App\Models\SegCentrocostosModel;
use App\Models\SegCertificadosModel;
use App\Models\SegClasificadorModel;
use App\Models\SegDesgloseModel;
use App\Models\SegDetalleSeguimientoModel;
use App\Models\SegFuenteFinanciamientoModel;
use App\Models\SegMetaModel;
use App\Models\SegProgramaPresupuestalModel;
use CodeIgniter\Controller;

class SegDesglose extends Controller
{
    protected $desgloseModel;
    protected $categoriaModel;
    protected $programaModel;
    protected $fuenteModel;
    protected $metaModel;
    protected $detalleSeguimientoModel;
    protected $clasificadoresModel;
    protected $certificadosModel;
    protected $SegCentrocostosModel;

    public function __construct()
    {
        $this->desgloseModel = new SegDesgloseModel();
        $this->categoriaModel = new SegCategoriaModel();
        $this->programaModel = new SegProgramaPresupuestalModel();
        $this->fuenteModel = new SegFuenteFinanciamientoModel();
        $this->metaModel = new SegMetaModel();
        $this->detalleSeguimientoModel = new SegDetalleSeguimientoModel();
        $this->clasificadoresModel = new SegClasificadorModel();
        $this->certificadosModel = new SegCertificadosModel();
        $this->SegCentrocostosModel = new SegCentrocostosModel();
    }

    public function index()
    {
        $data = [
            'desgloses' => $this->desgloseModel->getDesgloses(),
            'categorias' => $this->desgloseModel->getCategoriasFromCarpetas(),
            'centrosCostos' => $this->desgloseModel->getCentrosCostos(),
            'titulo' => 'Control de Gastos por Centro de Costos'
        ];

        return $this->viewData("/seguimiento/desglose", $data, ['scripts' => ['js/seg_desglose.js?v=7.1.6']]);
    }

    // Obtener programas por categoría (AJAX)
    public function getProgramas($id_categoria)
    {
        log_message('debug', 'ID Categoría recibido: ' . $id_categoria);

        $programas = $this->desgloseModel->getProgramasByCategoriaFromCarpetas($id_categoria);

        // Debug: Verificar los datos obtenidos
        log_message('debug', 'Programas encontrados: ' . print_r($programas, true));

        return $this->response->setJSON($programas);
    }

    // Obtener fuentes por programa (AJAX)
    public function getFuentes($id_programa)
    {
        $fuentes = $this->desgloseModel->getFuentesByProgramaFromCarpetas($id_programa);
        return $this->response->setJSON($fuentes);
    }

    // Obtener metas por fuente (AJAX)
    public function getMetas($id_fuente)
    {
        $metas = $this->desgloseModel->getMetasByFuenteFromCarpetas($id_fuente);
        return $this->response->setJSON($metas);
    }

    // Guardar nuevo desglose
    public function guardar()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'nombre_desglose' => 'required|min_length[3]',
            'id_categoria' => 'required|numeric',
            'id_programa' => 'required|numeric',
            'id_fuente' => 'required|numeric',
            'id_meta' => 'required|numeric',
            'idCentritos' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $centros = $this->request->getPost('idCentritos');

        foreach ($centros as $centro) {
            $data = [
                'nombre_desglose' => $this->request->getPost('nombre_desglose'),
                'id_categoria' => $this->request->getPost('id_categoria'),
                'id_programa' => $this->request->getPost('id_programa'),
                'id_fuente' => $this->request->getPost('id_fuente'),
                'id_meta' => $this->request->getPost('id_meta'),
                'id_centro_costos' => $centro,
                'estado' => 1
            ];

            $this->desgloseModel->guardarDesglose($data);
        }
        return redirect()->to(base_url("SegDesglose"))->with('success', 'Desglose creado correctamente.');
    }

    public function listar($idCategoria, $idPrograma, $idFuente, $idMeta)
    {
        // Obtener los desgloses específicos
        $desgloses = $this->desgloseModel
            ->select('desglose.*, 
                 cat.nombre_categoria, 
                 pp.nombre_programa, 
                 ff.nombre_fuente, 
                 m.nombre_meta,
                 cc.nombrecen as nombre_centro')
            ->join('categorias cat', 'cat.id_categoria = desglose.id_categoria')
            ->join('programas_presupuestales pp', 'pp.id_programa = desglose.id_programa')
            ->join('fuentes_financiamiento ff', 'ff.id_fuente = desglose.id_fuente')
            ->join('metas m', 'm.id_meta = desglose.id_meta')
            ->join('centro_de_costos cc', 'cc.idCentro = desglose.id_centro_costos')
            ->where('desglose.id_categoria', $idCategoria)
            ->where('desglose.id_programa', $idPrograma)
            ->where('desglose.id_fuente', $idFuente)
            ->where('desglose.id_meta', $idMeta)
            ->where('desglose.estado', 1)
            ->findAll();

        // Obtener datos adicionales para filtros
        $metas = $this->metaModel->where('estado', 1)->findAll();
        $clasificadores = $this->clasificadoresModel->where('estado', 1)->findAll();

        // Preparar datos para la vista
        $data = [
            'desgloses' => $desgloses,
            'metas' => $metas,
            'clasificadores' => $clasificadores,
            'filtros' => [
                'id_categoria' => $idCategoria,
                'id_programa' => $idPrograma,
                'id_fuente' => $idFuente,
                'nombre_categoria' => $desgloses[0]['nombre_categoria'] ?? '',
                'nombre_programa' => $desgloses[0]['nombre_programa'] ?? '',
                'nombre_fuente' => $desgloses[0]['nombre_fuente'] ?? ''
            ]
        ];

        // Cargar vista con datos
        return $this->viewData('seguimiento/desgloseCentro', $data, ['scripts' => ['js/seg_desglose.js']]);
    }

    public function ControlGastos($id_categoria, $id_programa, $id_fuente, $id_meta, $id_centro_costos)
    {
        // Obtener los nombres de programa, fuente y meta
        $SegCentrocostos = $this->SegCentrocostosModel->obtenerCentrosCostosActivos();
        $categoriaNombre = $this->categoriaModel->find($id_categoria)['nombre_categoria'];
        $programaNombre = $this->programaModel->find($id_programa)['nombre_programa'];
        $fuenteNombre = $this->fuenteModel->find($id_fuente)['nombre_fuente'];
        $metaNombre = $this->metaModel->find($id_meta)['nombre_meta'];

        // Obtener los clasificadores específicos para esta combinación de programa, fuente y meta
        $data = [
            'SegCentrocostos'=>$SegCentrocostos,
            'clasificadores' => $this->detalleSeguimientoModel->getClasForGroup($id_categoria, $id_programa, $id_fuente, $id_meta),
            'categoriaNombre' => $categoriaNombre,
            'programaNombre' => $programaNombre,
            'fuenteNombre' => $fuenteNombre,
            'metaNombre' => $metaNombre,
            'id_categoria' => $id_categoria,
            'id_programa' => $id_programa,
            'id_fuente' => $id_fuente,
            'id_meta' => $id_meta,
            'id_centro_costos' => $id_centro_costos
        ];

        // Pasar otros datos necesarios y scripts
        $scripts = ['scripts' => ['js/seg_controlgastos.js?v=7.1.6']];
        return $this->ViewData('/seguimiento/control_gastosCentros', $data, $scripts);
    }

    public function ResumenGastos($id_categoria, $id_programa, $id_fuente, $id_meta, $id_centro_costos)
    {
        // Obtener nombres básicos
        $categoriaNombre = $this->categoriaModel->find($id_categoria)['nombre_categoria'];
        $programaNombre = $this->programaModel->find($id_programa)['nombre_programa'];
        $fuenteNombre = $this->fuenteModel->find($id_fuente)['nombre_fuente'];
        $metaNombre = $this->metaModel->find($id_meta)['nombre_meta'];
        $metaCod = $this->metaModel->find($id_meta)['codigo_meta'];
        $centroNombre = $this->SegCentrocostosModel->find($id_centro_costos)['nombrecen'] ?? 'Centro Desconocido';
    
        // Consulta corregida con filtro efectivo por centro de costos
        $clasificadores = $this->detalleSeguimientoModel
            ->select('
                clasificadores.nombre_clasificador AS detalle,
                detalle_seguimiento.PIA,
                SUM(certificados.certificacion_monto) AS certificacion,
                detalle_seguimiento.PIM_acumulado AS PIM
            ')
            ->join('clasificadores', 'clasificadores.id_clasificador = detalle_seguimiento.id_clasificador')
            ->join('certificados', 'certificados.id_detalle = detalle_seguimiento.id_detalle AND certificados.id_centro_costos = '.$id_centro_costos, 'left')
            ->where('detalle_seguimiento.id_categoria', $id_categoria)
            ->where('detalle_seguimiento.id_programa', $id_programa)
            ->where('detalle_seguimiento.id_fuente', $id_fuente)
            ->where('detalle_seguimiento.id_meta', $id_meta)
            ->groupBy('clasificadores.id_clasificador')
            ->findAll();
    
        // Calcular saldos específicos por centro
        foreach ($clasificadores as &$clasificador) {
            $clasificador['certificacion'] = $clasificador['certificacion'] ?? 0;
            $clasificador['saldo'] = $clasificador['PIM'] - $clasificador['certificacion'];
        }
    
        // Preparar datos para la vista
        $data = [
            'clasificadores' => $clasificadores,
            'categoriaNombre' => $categoriaNombre,
            'programaNombre' => $programaNombre,
            'fuenteNombre' => $fuenteNombre,
            'metaNombre' => $metaNombre,
            'codigo_meta' => $metaCod,
            'centroNombre' => $centroNombre,
            'id_centro_costos' => $id_centro_costos
        ];
    
        return $this->ViewData('/seguimiento/resumen_gastos', $data, ['scripts' => ['js/seg_resumengastos.js?v=7.1.6']]);
    }

    public function verificarPIAClasificador()
    {
        $idCategoria = $this->request->getPost('id_categoria');
        $idPrograma = $this->request->getPost('id_programa');
        $idFuente = $this->request->getPost('id_fuente');
        $idMeta = $this->request->getPost('id_meta');
        $idClasificador = $this->request->getPost('id_clasificador');

        // Encuentra el registro específico en detalle_seguimiento
        $detalle = $this->detalleSeguimientoModel->where([
            'id_categoria' => $idCategoria,
            'id_programa' => $idPrograma,
            'id_fuente' => $idFuente,
            'id_meta' => $idMeta,
            'id_clasificador' => $idClasificador
        ])->first();

        if ($detalle) {
            return $this->response->setJSON([
                'pia' => $detalle['PIA'] ?? 0, // Devuelve 0 si PIA es NULL
                'pim' => $detalle['PIM'] ?? 0, // Devuelve 0 si PIM es NULL
                'id_detalle' => $detalle['id_detalle']
            ]);
        }

        return $this->response->setJSON(['error' => 'No se encontró un detalle para el clasificador seleccionado']);
    }

    public function obtenerCertificados()
    {
        // Obtener los parámetros enviados
        $id_categoria = $this->request->getPost('id_categoria');
        $id_programa = $this->request->getPost('id_programa');
        $id_fuente = $this->request->getPost('id_fuente');
        $id_meta = $this->request->getPost('id_meta');
        $id_clasificador = $this->request->getPost('id_clasificador');
        $id_centro_costos = $this->request->getPost('id_centro_costos');

        // Consulta para obtener los certificados relacionados con detalle_seguimiento
        $certificados = $this->certificadosModel
            ->select('certificados.id_certificado, certificados.codigo_transaccion, certificados.fecha, certificados.detalle, certificados.modificacion, certificados.certificacion_monto, certificados.certificacion_rebaja, certificados.certificacion_ampliacion, certificados.estado, detalle_seguimiento.PIA')  // Traer campos de la tabla certificados y de detalle_seguimiento
            ->join('detalle_seguimiento', 'detalle_seguimiento.id_detalle = certificados.id_detalle', 'left')  // Hacer el join con detalle_seguimiento
            ->where([
                'detalle_seguimiento.id_categoria' => $id_categoria,
                'detalle_seguimiento.id_programa' => $id_programa,
                'detalle_seguimiento.id_fuente' => $id_fuente,
                'detalle_seguimiento.id_meta' => $id_meta,
                'detalle_seguimiento.id_clasificador' => $id_clasificador,
                'certificados.id_centro_costos' => $id_centro_costos
            ])
            ->findAll();

        // Devuelve los resultados en formato JSON
        return $this->response->setJSON($certificados);
    }
    public function buscarDesgloses()
{
    $nombre = $this->request->getGet('nombre');

    $query = $this->desgloseModel->getDesgloses();

    if (!empty($nombre)) {
        // Filtrar por coincidencia en nombre del desglose
        $query = array_filter($query, function ($item) use ($nombre) {
            return stripos($item['nombre_desglose'], $nombre) !== false;
        });
    }

    return $this->response->setJSON(array_values($query));
}

}
