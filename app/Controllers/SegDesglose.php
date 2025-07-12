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
use App\Models\SegPimInicial;

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
    protected $pimInicialModel;
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
        $this->pimInicialModel = new SegPimInicial();

    }

    public function index()
    {
        $desgloses = $this->desgloseModel->getDesgloses();
        // Agregar los centros de costos seleccionados por cada desglose
        foreach ($desgloses as &$desglose) {
            $centros = $this->desgloseModel->obtenerCentrosPorDesglose(
                $desglose['id_categoria'],
                $desglose['id_programa'],
                $desglose['id_fuente'],
                $desglose['id_meta'],
                $desglose['nombre_desglose']
            );

            $desglose['centros_seleccionados'] = array_column($centros, 'id_centro_costos');
        }

        $data = [
            'desgloses'      => $desgloses,
            'categorias'     => $this->desgloseModel->getCategoriasFromCarpetas(),
            'centrosCostos'  => $this->desgloseModel->getCentrosCostos(),
            'titulo'         => 'Control de Gastos por Centro de Costos'
        ];

        return $this->viewData("/seguimiento/desglose", $data, [
            'scripts' => ['js/seg_desglose.js?v=7.1.6']
        ]);
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
        'id_categoria'    => 'required|numeric',
        'id_programa'     => 'required|numeric',
        'id_fuente'       => 'required|numeric',
        'id_meta'         => 'required|numeric',
        'idCentritos'     => 'required'
    ]);

    if (!$validation->withRequest($this->request)->run()) {
        return redirect()->back()->withInput()->with('errors', $validation->getErrors());
    }

    $nombre        = $this->request->getPost('nombre_desglose');
    $id_categoria  = $this->request->getPost('id_categoria');
    $id_programa   = $this->request->getPost('id_programa');
    $id_fuente     = $this->request->getPost('id_fuente');
    $id_meta       = $this->request->getPost('id_meta');
    $centros       = $this->request->getPost('idCentritos');

    // Validar si alguno de los centros ya tiene un desglose con esta combinación
    foreach ($centros as $centro) {
        $existe = $this->desgloseModel->where([
            'id_categoria'     => $id_categoria,
            'id_programa'      => $id_programa,
            'id_fuente'        => $id_fuente,
            'id_meta'          => $id_meta,
            'id_centro_costos' => $centro,
            'estado'           => 1
        ])->first();

        if ($existe) {
            session()->setFlashdata('AlertShow', [
                "Tipo" => 'warning',
                "Mensaje" => 'Ya existe un desglose para uno o varios de los centros de costos seleccionados.'
            ]);
            return redirect()->to(base_url('SegDesglose'));
        }
    }

    // Si pasa la validación, guardar todos
    foreach ($centros as $centro) {
        $this->desgloseModel->insert([
            'nombre_desglose'    => $nombre,
            'id_categoria'       => $id_categoria,
            'id_programa'        => $id_programa,
            'id_fuente'          => $id_fuente,
            'id_meta'            => $id_meta,
            'id_centro_costos'   => $centro,
            'estado'             => 1
        ]);
    }

    session()->setFlashdata('AlertShow', [
        "Tipo" => 'success',
        "Mensaje" => 'Desglose creado correctamente.'
    ]);

    return redirect()->to(base_url('SegDesglose'));
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

        //para el oim inicial:
        // Obtener PIM inicial desde pim_iniciales para este centro y combinación
        $pimInicial = $this->pimInicialModel
            ->select('monto_pim')
            ->join('certificados', 'certificados.id_certificado = pim_iniciales.id_certificado')
            ->join('detalle_seguimiento', 'detalle_seguimiento.id_detalle = certificados.id_detalle')
            ->where([
                'detalle_seguimiento.id_categoria' => $id_categoria,
                'detalle_seguimiento.id_programa' => $id_programa,
                'detalle_seguimiento.id_fuente'   => $id_fuente,
                'detalle_seguimiento.id_meta'     => $id_meta,
                'pim_iniciales.id_centro_costos'  => $id_centro_costos
            ])
            ->first();

        $pimInicialValor = $pimInicial['monto_pim'] ?? 0;


        // Obtener los clasificadores específicos para esta combinación de programa, fuente y meta
        $data = [
            'SegCentrocostos' => $SegCentrocostos,
            'clasificadores' => $this->detalleSeguimientoModel->getClasForGroup($id_categoria, $id_programa, $id_fuente, $id_meta),
            'categoriaNombre' => $categoriaNombre,
            'programaNombre' => $programaNombre,
            'fuenteNombre' => $fuenteNombre,
            'metaNombre' => $metaNombre,
            'id_categoria' => $id_categoria,
            'id_programa' => $id_programa,
            'id_fuente' => $id_fuente,
            'id_meta' => $id_meta,
            'id_centro_costos' => $id_centro_costos,
            'pim_inicial' => $pimInicialValor,

        ];

        // Pasar otros datos necesarios y scripts
        $scripts = ['scripts' => ['js/seg_controlgastos.js?v=7.1.6']];
        return $this->ViewData('/seguimiento/control_gastosCentros', $data, $scripts);
    }

public function ResumenGastos($id_categoria, $id_programa, $id_fuente, $id_meta, $id_centro_costos)
{
    // Cabeceras para mostrar en la vista
    $categoriaNombre = $this->categoriaModel->find($id_categoria)['nombre_categoria'];
    $programaNombre  = $this->programaModel->find($id_programa)['nombre_programa'];
    $fuenteNombre    = $this->fuenteModel->find($id_fuente)['nombre_fuente'];
    $metaData        = $this->metaModel->find($id_meta);
    $metaNombre      = $metaData['nombre_meta'];
    $metaCod         = $metaData['codigo_meta'];
    $centroNombre    = $this->SegCentrocostosModel->find($id_centro_costos)['nombrecen'] ?? 'Centro Desconocido';

    $inicializacionModel = new \App\Models\InicializacionModel();

    // Obtener clasificadores asociados desde detalle_seguimiento (sin usar PIA ni PIM de allí)
    $clasificadores = $this->detalleSeguimientoModel
        ->select('
            clasificadores.id_clasificador,
            clasificadores.nombre_clasificador AS detalle,
            detalle_seguimiento.id_detalle
        ')
        ->join('clasificadores', 'clasificadores.id_clasificador = detalle_seguimiento.id_clasificador')
        ->where('detalle_seguimiento.id_categoria', $id_categoria)
        ->where('detalle_seguimiento.id_programa', $id_programa)
        ->where('detalle_seguimiento.id_fuente', $id_fuente)
        ->where('detalle_seguimiento.id_meta', $id_meta)
        ->findAll();

    foreach ($clasificadores as &$clasificador) {
        $id_clasificador = $clasificador['id_clasificador'];
        $idDetalle       = $clasificador['id_detalle'];

        // 🔹 1. Buscar PIM desde pim_iniciales
        $pim_inicial_data = $this->pimInicialModel
            ->where([
                'id_categoria'      => $id_categoria,
                'id_programa'       => $id_programa,
                'id_fuente'         => $id_fuente,
                'id_meta'           => $id_meta,
                'id_clasificador'   => $id_clasificador,
                'id_centro_costos'  => $id_centro_costos
            ])
            ->select('monto_pim')
            ->first();

        $pim_inicial = floatval($pim_inicial_data['monto_pim'] ?? 0);
        $pia_manual  = 0;

        // 🔹 2. Si no hay pim, buscar en tabla de inicializaciones
        if ($pim_inicial == 0) {
            $inicial = $inicializacionModel->obtenerInicializacion(
                $id_categoria, $id_programa, $id_fuente, $id_meta, $id_clasificador, $id_centro_costos
            );
            $pia_manual  = floatval($inicial['valor_pia'] ?? 0);
            $pim_inicial = floatval($inicial['valor_pim'] ?? 0);
        }

        // 🔹 3. Buscar certificados relacionados (por id_detalle)
        $certificados = $this->certificadosModel
            ->where('id_detalle', $idDetalle)
            ->where('id_centro_costos', $id_centro_costos)
            ->orderBy('fecha', 'ASC')
            ->findAll();

        $PIM_actual = $pim_inicial;
        $Saldo = $pim_inicial;

        foreach ($certificados as $cert) {
            $modificacion = floatval($cert['modificacion'] ?? 0);
            $monto        = floatval($cert['certificacion_monto'] ?? 0);
            $rebaja       = floatval($cert['certificacion_rebaja'] ?? 0);
            $ampliacion   = floatval($cert['certificacion_ampliacion'] ?? 0);

            $PIM_actual += $modificacion;
            $Saldo += $modificacion - $monto + ($rebaja - $ampliacion);
        }

        // Guardar resultados
        $clasificador['PIA']           = $pia_manual;
        $clasificador['PIM']           = $PIM_actual;
        $clasificador['certificacion'] = $PIM_actual - $Saldo;
        $clasificador['saldo']         = $Saldo;
    }

    $data = [
        'clasificadores'   => $clasificadores,
        'categoriaNombre'  => $categoriaNombre,
        'programaNombre'   => $programaNombre,
        'fuenteNombre'     => $fuenteNombre,
        'metaNombre'       => $metaNombre,
        'codigo_meta'      => $metaCod,
        'centroNombre'     => $centroNombre,
        'id_centro_costos' => $id_centro_costos
    ];

    return $this->ViewData('/seguimiento/resumen_gastos', $data, [
        'scripts' => ['js/seg_resumengastos.js?v=7.1.6']
    ]);
}



public function verificarPIAClasificador()
{
    if ($this->request->isAJAX()) {
        $id_categoria     = $this->request->getPost('id_categoria');
        $id_programa      = $this->request->getPost('id_programa');
        $id_fuente        = $this->request->getPost('id_fuente');
        $id_meta          = $this->request->getPost('id_meta');
        $id_clasificador  = $this->request->getPost('id_clasificador');
        $id_centro_costos = $this->request->getPost('id_centro_costos');

        if (!$id_categoria || !$id_programa || !$id_fuente || !$id_meta || !$id_clasificador || !$id_centro_costos) {
            return $this->response->setJSON(['error' => 'Faltan datos requeridos.']);
        }

        // ✅ Obtener PIM desde pim_iniciales (relacionado con certificados)
        $pim = $this->pimInicialModel
            ->where([
                'id_categoria'      => $id_categoria,
                'id_programa'       => $id_programa,
                'id_fuente'         => $id_fuente,
                'id_meta'           => $id_meta,
                'id_clasificador'   => $id_clasificador,
                'id_centro_costos'  => $id_centro_costos
            ])
            ->select('monto_pim')
            ->first();


        $pimValor = $pim['monto_pim'] ?? 0;

        // ✅ Si no hay PIM en pim_iniciales, buscar en inicializaciones manuales
        if (!$pimValor || $pimValor == 0) {
            $inicializacionModel = new \App\Models\InicializacionModel();
            $inicial = $inicializacionModel->obtenerInicializacion($id_categoria, $id_programa, $id_fuente, $id_meta, $id_clasificador, $id_centro_costos);
            $pia_manual = $inicial['valor_pia'] ?? 0;
            $pim_manual = $inicial['valor_pim'] ?? 0;

            return $this->response->setJSON([
                'pia' => $inicial['valor_pia'] ?? 0,
                'pim' => $inicial['valor_pim'] ?? 0,
                'editable' => true
            ]);
        }

        // ✅ Si hay PIM oficial, devolverlo (sin consultar PIA)
        return $this->response->setJSON([
            'pia' => 0,
            'pim' => $pimValor,
            'editable' => false
        ]);
    }

    return $this->response->setJSON(['error' => 'Solicitud inválida.']);
}

public function guardarInicializacion()
{
    $data = [
        'id_categoria'     => $this->request->getPost('id_categoria'),
        'id_programa'      => $this->request->getPost('id_programa'),
        'id_fuente'        => $this->request->getPost('id_fuente'),
        'id_meta'          => $this->request->getPost('id_meta'),
        'id_clasificador'  => $this->request->getPost('id_clasificador'),
        'id_centro_costos' => $this->request->getPost('id_centro_costos'),
        'valor_pia'        => $this->request->getPost('valor_pia'),
        'valor_pim'        => $this->request->getPost('valor_pim')
    ];

    $model = new \App\Models\InicializacionModel();

    if ($model->existeInicializacion(
        $data['id_categoria'],
        $data['id_programa'],
        $data['id_fuente'],
        $data['id_meta'],
        $data['id_clasificador'],
        $data['id_centro_costos']
    )) {
        $model->where([
            'id_categoria' => $data['id_categoria'],
            'id_programa'  => $data['id_programa'],
            'id_fuente'    => $data['id_fuente'],
            'id_meta'      => $data['id_meta'],
            'id_clasificador' => $data['id_clasificador'],
            'id_centro_costos' => $data['id_centro_costos']
        ])->set([
            'valor_pia' => $data['valor_pia'],
            'valor_pim' => $data['valor_pim']
        ])->update();
    } else {
        $model->insert($data);
    }

    return $this->response->setJSON(['success' => true]);
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
        $idCategoria = $this->request->getGet('id_categoria');
        $idPrograma  = $this->request->getGet('id_programa');
        $idFuente    = $this->request->getGet('id_fuente');
        $idMeta      = $this->request->getGet('id_meta');
        $vista       = $this->request->getGet('vista'); // 'general' o 'centro'
            
        if ($vista === 'general') {
            $builder = $this->desgloseModel
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
            ->where('desglose.estado', 1);

            if (!empty($idCategoria)) $builder->where('desglose.id_categoria', $idCategoria);
            if (!empty($idPrograma))  $builder->where('desglose.id_programa', $idPrograma);
            if (!empty($idFuente))    $builder->where('desglose.id_fuente', $idFuente);
            if (!empty($idMeta))      $builder->where('desglose.id_meta', $idMeta);
            if (!empty($nombre))      $builder->like('desglose.nombre_desglose', $nombre);

            $resultados = $builder->findAll();

            // Agrupar por combinación única
            $agrupados = [];
            foreach ($resultados as $item) {
                $clave = $item['id_categoria'] . '' . $item['id_programa'] . '' . $item['id_fuente'] . '_' . $item['id_meta'];
                if (!isset($agrupados[$clave])) {
                    $agrupados[$clave] = $item;
                }
            }

            return $this->response->setJSON(array_values($agrupados));
        } else {
            $builder = $this->desgloseModel
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
                ->where('desglose.estado', 1);
        
                

            if (!empty($nombre)) {
            $builder = $builder->like('cc.nombrecen', $nombre);
        }
        $resultados = $builder->findAll();
            
        
            return $this->response->setJSON($resultados);
        }
        

    }


public function editarDesglose()
{
    $id_categoria     = $this->request->getPost('id_categoria');
    $id_programa      = $this->request->getPost('id_programa');
    $id_fuente        = $this->request->getPost('id_fuente');
    $id_meta          = $this->request->getPost('id_meta');
    $nombre_desglose  = $this->request->getPost('nombre_desglose');
    $centros_nuevos   = $this->request->getPost('idCentritos') ?? [];

    // Eliminar todos los desgloses actuales de esa combinación
    $this->desgloseModel
        ->where([
            'id_categoria' => $id_categoria,
            'id_programa' => $id_programa,
            'id_fuente' => $id_fuente,
            'id_meta' => $id_meta,
        ])
        ->delete();

    // Insertar nuevos registros con los nuevos centros
    foreach ($centros_nuevos as $idCentro) {
        $this->desgloseModel->insert([
            'nombre_desglose' => $nombre_desglose,
            'id_categoria' => $id_categoria,
            'id_programa' => $id_programa,
            'id_fuente' => $id_fuente,
            'id_meta' => $id_meta,
            'id_centro_costos' => $idCentro,
            'estado' => 1
        ]);
    }

    return redirect()->to(base_url("SegDesglose"))->with('success', 'Desglose actualizado correctamente.');
}


public function eliminarDesglose()
{
    $id_categoria = $this->request->getPost('id_categoria');
    $id_programa  = $this->request->getPost('id_programa');
    $id_fuente    = $this->request->getPost('id_fuente');
    $id_meta      = $this->request->getPost('id_meta');
    $id_centro    = $this->request->getPost('id_centro_costos');

    $this->desgloseModel
        ->where([
            'id_categoria' => $id_categoria,
            'id_programa' => $id_programa,
            'id_fuente' => $id_fuente,
            'id_meta' => $id_meta,
            'id_centro_costos' => $id_centro
        ])
        ->delete();

    return $this->response->setJSON(['success' => true]);
}
}