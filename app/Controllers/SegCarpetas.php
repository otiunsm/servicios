<?php

namespace App\Controllers;

use App\Models\SegCarpetaModel;
use App\Models\SegCategoriaModel;
use App\Models\SegCertificadosModel;
use App\Models\SegClasificadorModel;
use App\Models\SegDetalleSeguimientoModel;
use App\Models\SegFuenteFinanciamientoModel;
use App\Models\SegMetaModel;
use App\Models\SegProgramaPresupuestalModel;
use CodeIgniter\Controller;
use App\Models\SegCentrocostosModel;

class SegCarpetas extends Controller
{
    protected $carpetaModel;
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
        $this->carpetaModel = new SegCarpetaModel();
        $this->categoriaModel = new SegCategoriaModel();
        $this->programaModel = new SegProgramaPresupuestalModel();
        $this->fuenteModel = new SegFuenteFinanciamientoModel();
        $this->metaModel = new SegMetaModel();
        $this->detalleSeguimientoModel = new SegDetalleSeguimientoModel();
        $this->clasificadoresModel = new SegClasificadorModel();
        $this->certificadosModel = new SegCertificadosModel();
        $this->SegCentrocostosModel = new SegCentrocostosModel();
    }

    public function crearPrograma()
    {
        // Validar los datos del formulario
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nombre_carpeta' => 'required', // Solo el nombre de la carpeta es obligatorio
            'id_categoria' => 'permit_empty|numeric', // Opcional
            'id_programa' => 'permit_empty|numeric', // Opcional
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // Si la validación falla, redirigir con errores
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Datos del formulario
        $nombreCarpeta = $this->request->getPost('nombre_carpeta');
        $idCategoria = $this->request->getPost('id_categoria');
        $idPrograma = $this->request->getPost('id_programa');
        $descripcion = $this->request->getPost('descripcion');

        // Insertar la carpeta de programa
        $dataCarpeta = [
            'nombre_carpeta' => $nombreCarpeta,
            'descripcion' => $descripcion,
            'id_carpeta_padre' => null, // Las carpetas de programa no tienen padre
            'id_categoria' => $idCategoria, // Puede ser null
            'id_programa' => $idPrograma, // Puede ser null
            'id_fuente' => null, // No aplica para carpetas de programa
            'id_meta' => null, // No aplica para carpetas de programa
            'id_clasificador' => null, // No aplica para carpetas de programa
            'estado' => 1,
        ];
        $this->carpetaModel->insert($dataCarpeta);

        return redirect()->to(base_url('SegCarpetas'))->with('success', 'Carpeta de programa creada correctamente.');
    }
    public function crearFuente($idCarpetaPadre)
    {
        // Validar los datos del formulario
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nombre_carpeta' => 'required', // El nombre de la carpeta es obligatorio
            'descripcion' => 'permit_empty', // La descripción es opcional
            'id_fuente' => 'required|numeric', // El id_fuente es obligatorio
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // Si la validación falla, redirigir con errores
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Obtener los datos de la carpeta padre
        $carpetaPadre = $this->carpetaModel->find($idCarpetaPadre);

        if (!$carpetaPadre) {
            // Si no se encuentra la carpeta padre, redirigir con un mensaje de error
            return redirect()->back()->with('error', 'La carpeta padre no existe.');
        }

        // Datos del formulario
        $nombreCarpeta = $this->request->getPost('nombre_carpeta');
        $descripcion = $this->request->getPost('descripcion');
        $idFuente = $this->request->getPost('id_fuente');

        // Verificar si ya existe una carpeta con el mismo nombre y id_fuente en la misma categoría y programa
        $existeCarpeta = $this->carpetaModel
            ->where('id_fuente', $idFuente)
            ->where('id_categoria', $carpetaPadre['id_categoria'])
            ->where('id_programa', $carpetaPadre['id_programa'])
            ->first();

        if ($existeCarpeta) {
            // Si ya existe una carpeta con el mismo nombre y id_fuente, redirigir con un mensaje de error
            return redirect()->back()->withInput()->with('error', 'Ya existe una carpeta fuente con el mismo nombre y fuente de financiamiento.');
        }

        // Crear carpeta de fuente
        $dataCarpeta = [
            'nombre_carpeta' => $nombreCarpeta,
            'descripcion' => $descripcion,
            'id_carpeta_padre' => $idCarpetaPadre, // Carpeta padre es la carpeta seleccionada
            'id_categoria' => $carpetaPadre['id_categoria'], // Heredar el id_categoria del padre
            'id_programa' => $carpetaPadre['id_programa'], // Heredar el id_programa del padre
            'id_fuente' => $idFuente, // Asignar el id_fuente proporcionado en el formulario
            'estado' => 1,
        ];
        $this->carpetaModel->insert($dataCarpeta);

        // Redirigir a la lista de fuentes con un mensaje de éxito
        return redirect()->to(base_url("SegCarpetas/listarFuentes/{$carpetaPadre['id_categoria']}/{$carpetaPadre['id_programa']}/{$idCarpetaPadre}"))->with('success', 'Carpeta de fuente creada correctamente.');
    }

    // Método para crear una carpeta de meta
    public function crearMeta($idCarpetaPadre)
    {
        // Validar los datos del formulario
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nombre_carpeta' => 'required',
            'id_meta' => 'required|integer',
            'clasificadores' => 'required',
            'id_categoria' => 'required|integer',
            'id_programa' => 'required|integer',
            'id_fuente' => 'required|integer',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // Si la validación falla, redirigir con errores
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        // Obtener los datos de la carpeta padre
        $carpetaPadre = $this->carpetaModel->find($idCarpetaPadre);

        if (!$carpetaPadre) {
            // Si no se encuentra la carpeta padre, redirigir con un mensaje de error
            return redirect()->back()->with('error', 'La carpeta padre no existe.');
        }
        // Datos del formulario
        $nombreCarpeta = $this->request->getPost('nombre_carpeta');
        $idMeta = $this->request->getPost('id_meta');
        $clasificadores = $this->request->getPost('clasificadores');
        $idCategoria = $this->request->getPost('id_categoria');
        $idPrograma = $this->request->getPost('id_programa');
        $idFuente = $this->request->getPost('id_fuente');



        // Insertar la carpeta en la tabla `carpetas`
        $dataCarpeta = [
            'nombre_carpeta' => $nombreCarpeta,
            'id_carpeta_padre' => $idCarpetaPadre,
            'id_categoria' => $carpetaPadre['id_categoria'],
            'id_programa' => $carpetaPadre['id_programa'],
            'id_fuente' => $carpetaPadre['id_fuente'],
            'id_meta' => $idMeta,
            'estado' => 1,
        ];
        $this->carpetaModel->insert($dataCarpeta);

        // Insertar en la tabla `detalle_seguimiento` para cada clasificador seleccionado
        foreach ($clasificadores as $idClasificador) {
            $dataDetalle = [
                'id_categoria' => $idCategoria,
                'id_programa' => $idPrograma,
                'id_fuente' => $idFuente,
                'id_meta' => $idMeta,
                'id_clasificador' => $idClasificador,
                'PIA' => 0.00,
                'PIM' => 0.00,
                'PIM_acumulado' => 0.00,
                'certificado_acumulado' => 0.00,
                'estado' => 1,
            ];
            $this->detalleSeguimientoModel->insert($dataDetalle);
        }

        // Redirigir con un mensaje de éxito
        return redirect()->to(base_url("SegCarpetas/listarMetas/{$carpetaPadre['id_carpeta']}/{$carpetaPadre['id_categoria']}/{$carpetaPadre['id_programa']}/{$carpetaPadre['id_fuente']}"))->with('success', 'Carpeta y clasificadores asignados correctamente.');
    }

    // Método para listar carpetas de programas
    public function index()
    {
        // Obtener las carpetas de programas (carpetas sin padre)
        $carpetas = $this->carpetaModel->where('id_carpeta_padre', null)->findAll();

        // Obtener las categorías y programas disponibles
        $categorias = $this->categoriaModel->findAll();
        $programas = $this->programaModel->findAll();

        foreach ($carpetas as &$carpeta) {
            if ($carpeta['id_programa']) {
                $carpeta['nombre_programa'] = $this->carpetaModel->getProgramaNombre($carpeta['id_programa']);
            } else {
                $carpeta['nombre_programa'] = 'Sin programa';
            }
        }

        // Pasar los datos a la vista
        $scripts = ['scripts' => ['js/seg_carpetasProgramas.js?v=7.1.6']]; 
        $this->viewData('seguimiento/carpetasProgramas', [
            'carpetas' => $carpetas,
            'categorias' => $categorias,
            'programas' => $programas,
        ], $scripts);
    }

    // Método para listar carpetas de fuentes
    public function listarFuentes($idCategoria, $idPrograma, $idCarpetaPadre)
    {
        // Obtener las carpetas de fuentes (carpetas con id_carpeta_padre igual al id_carpeta_padre proporcionado)
        $carpetas = $this->carpetaModel
            ->where('id_categoria', $idCategoria)
            ->where('id_programa', $idPrograma)
            ->where('id_carpeta_padre', $idCarpetaPadre) // Filtrar por id_carpeta_padre
            ->findAll();

        // Obtener los nombres de categoría y programa para mostrarlos en la vista
        $fuentes = $this->fuenteModel->findAll();

        foreach ($carpetas as &$carpeta) {
            // Obtener el nombre del programa
            $programa = $this->programaModel->find($carpeta['id_programa']);
            $carpeta['nombre_programa'] = $programa ? $programa['nombre_programa'] : 'Sin programa';

            // Obtener el nombre de la fuente
            $fuente = $this->fuenteModel->find($carpeta['id_fuente']);
            $carpeta['nombre_fuente'] = $fuente ? $fuente['nombre_fuente'] : 'Sin fuente';
        }
        // Pasar los datos a la vista usando viewData
        $data = [
            'carpetas' => $carpetas,

            'id_categoria' => $idCategoria,
            'id_programa' => $idPrograma,
            'idCarpetaPadre' => $idCarpetaPadre, // Pasar el id_carpeta_padre a la vista
            'fuentes' => $fuentes
        ];

        // Pasar otros datos necesarios y scripts
        $scripts = ['scripts' => ['js/seg_carpetasProgramas.js?v=7.1.6']];
        $this->viewData('seguimiento/carpetasFuentes', $data, $scripts);
    }

    public function listarMetas($idCarpetaPadre, $idCategoria, $idPrograma, $idFuente)
    {
        // Obtener las carpetas de metas (carpetas con id_carpeta_padre igual al id_carpeta_padre proporcionado)
        $carpetas = $this->carpetaModel
            ->where('id_categoria', $idCategoria)
            ->where('id_programa', $idPrograma)
            ->where('id_fuente', $idFuente)
            ->where('id_carpeta_padre', $idCarpetaPadre) // Filtrar por id_carpeta_padre
            ->findAll();

        // Obtener los nombres de categoría, programa, fuente y metas para mostrarlos en la vista
        $metas = $this->metaModel->findAll();
        $clasificadores = $this->clasificadoresModel->where('estado', 1)->findAll();
        foreach ($carpetas as &$carpeta) {
            // Obtener el nombre del programa
            $programa = $this->programaModel->find($carpeta['id_programa']);
            $carpeta['nombre_programa'] = $programa ? $programa['nombre_programa'] : 'Sin programa';

            // Obtener el nombre de la fuente
            $fuente = $this->fuenteModel->find($carpeta['id_fuente']);
            $carpeta['nombre_fuente'] = $fuente ? $fuente['nombre_fuente'] : 'Sin fuente';

            // Obtener el nombre de la meta
            $meta = $this->metaModel->find($carpeta['id_meta']);
            $carpeta['nombre_meta'] = $meta ? $meta['nombre_meta'] : 'Sin meta';
        }

        // Pasar los datos a la vista usando viewData
        $data = [
            'carpetas' => $carpetas,
            'id_categoria' => $idCategoria,
            'id_programa' => $idPrograma,
            'id_fuente' => $idFuente,
            'idCarpetaPadre' => $idCarpetaPadre, // Pasar el id_carpeta_padre a la vista
            'metas' => $metas, // Pasar las metas disponibles para el modal
            'clasificadores' => $clasificadores,
        ];

        // Pasar otros datos necesarios y scripts
        $scripts = ['scripts' => ['js/seg_carpetasProgramas.js?v=7.1.6']];
        $this->viewData('seguimiento/carpetasMetas', $data, $scripts);
    }

    public function eliminarDetalle($id)
    {
        $this->detalleSeguimientoModel->eliminarDetalle($id);
        return redirect()->to(base_url() . "/ControlPresupuestal");
    }



    public function ControlGastos($id_categoria, $id_programa, $id_fuente, $id_meta)
    {
        // Obtener los nombres de programa, fuente y meta
        $SegCentrocostos = $this->SegCentrocostosModel->obtenerCentrosCostosActivos();
        $categoriaNombre = $this->categoriaModel->find($id_categoria)['nombre_categoria'];
        $programaNombre = $this->programaModel->find($id_programa)['nombre_programa'];
        $fuenteNombre = $this->fuenteModel->find($id_fuente)['nombre_fuente'];
        $metaNombre = $this->metaModel->find($id_meta)['nombre_meta'];

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
            'id_meta' => $id_meta
        ];

        // Pasar otros datos necesarios y scripts
        $scripts = ['scripts' => ['js/seg_controlgastos.js?v=7.1.6']];
        return $this->ViewData('/seguimiento/control_gastos', $data, $scripts);
    }

    public function ResumenGastos($id_categoria, $id_programa, $id_fuente, $id_meta)
    {
        // Obtener los nombres de categoría, programa, fuente y meta
        $categoriaNombre = $this->categoriaModel->find($id_categoria)['nombre_categoria'];
        $programaNombre = $this->programaModel->find($id_programa)['nombre_programa'];
        $fuenteNombre = $this->fuenteModel->find($id_fuente)['nombre_fuente'];
        $metaNombre = $this->metaModel->find($id_meta)['nombre_meta'];
        $metaCod = $this->metaModel->find($id_meta)['codigo_meta'];

        // Consultar los clasificadores relacionados con la meta, programa, fuente y categoría
        $clasificadores = $this->detalleSeguimientoModel
            ->select('clasificadores.nombre_clasificador AS detalle, detalle_seguimiento.PIA, detalle_seguimiento.PIM_acumulado AS PIM, detalle_seguimiento.certificado_acumulado AS certificacion')
            ->join('clasificadores', 'clasificadores.id_clasificador = detalle_seguimiento.id_clasificador')
            ->where('detalle_seguimiento.id_categoria', $id_categoria)
            ->where('detalle_seguimiento.id_programa', $id_programa)
            ->where('detalle_seguimiento.id_fuente', $id_fuente)
            ->where('detalle_seguimiento.id_meta', $id_meta)
            ->findAll();

        // Calcular el saldo para cada clasificador
        foreach ($clasificadores as &$clasificador) {
            $clasificador['saldo'] = $clasificador['PIM'] - $clasificador['certificacion'];
        }

        // Preparar los datos para la vista
        $data = [
            'clasificadores' => $clasificadores,
            'categoriaNombre' => $categoriaNombre,
            'programaNombre' => $programaNombre,
            'fuenteNombre' => $fuenteNombre,
            'metaNombre' => $metaNombre,
            'codigo_meta' => $metaCod
        ];

        // Scripts necesarios para la vista
        $scripts = ['scripts' => ['js/seg_resumengastos.js?v=7.1.6']];

        return $this->ViewData('/seguimiento/resumen_gastos', $data, $scripts);
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



    public function actualizarPIA()
    {
        $idDetalle = $this->request->getPost('id_detalle');
        $pia = $this->request->getPost('pia');

        // Actualiza el campo PIA para el registro de id_detalle específico
        $this->detalleSeguimientoModel->update($idDetalle, [
            'PIA' => $pia,
            'PIM' => $pia // Actualizamos también el PIM con el mismo valor que el PIA
        ]);

        // Redirige o realiza otra acción en lugar de devolver JSON
        return redirect()->back()->with('success', 'PIA actualizado exitosamente');
    }

    public function guardarAcumulados()
    {
        if ($this->request->isAJAX()) {
            // Obtener los parámetros enviados
            $idCategoria = $this->request->getPost('id_categoria');
            $idPrograma = $this->request->getPost('id_programa');
            $idFuente = $this->request->getPost('id_fuente');
            $idMeta = $this->request->getPost('id_meta');
            $idClasificador = $this->request->getPost('id_clasificador');
            $PIM_acumulado = $this->request->getPost('PIM_acumulado');
            $certificado_acumulado = $this->request->getPost('certificado_acumulado');

            // Busca el detalle correspondiente
            $detalle = $this->detalleSeguimientoModel->where([
                'id_categoria' => $idCategoria,
                'id_programa' => $idPrograma,
                'id_fuente' => $idFuente,
                'id_meta' => $idMeta,
                'id_clasificador' => $idClasificador
            ])->first();

            if (!$detalle) {
                return $this->response->setJSON(['success' => false, 'message' => 'No se encontró el detalle correspondiente.']);
            }

            // Llama al método del modelo para actualizar los acumulados
            if ($this->detalleSeguimientoModel->actualizarAcumulados($detalle['id_detalle'], $PIM_acumulado, $certificado_acumulado)) {
                return $this->response->setJSON(['success' => true, 'message' => 'Acumulados actualizados correctamente.']);
            }

            return $this->response->setJSON(['success' => false, 'message' => 'Error al actualizar los acumulados en la base de datos.']);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Método de solicitud no válido.']);
    }

    public function guardarCertificado()
    {
        if ($this->request->isAJAX()) {
            $idCategoria = $this->request->getPost('id_categoria');
            $idPrograma = $this->request->getPost('id_programa');
            $idFuente = $this->request->getPost('id_fuente');
            $idMeta = $this->request->getPost('id_meta');
            $idClasificador = $this->request->getPost('id_clasificador');
            $idCentro = $this->request->getPost('idCentro');

            // Verifica los datos requeridos
            if (!$idCategoria || !$idPrograma || !$idFuente || !$idMeta || !$idClasificador) {
                return $this->response->setJSON(['success' => false, 'message' => 'Faltan datos.']);
            }

            // Busca el detalle correspondiente
            $detalle = $this->detalleSeguimientoModel->where([
                'id_categoria' => $idCategoria,
                'id_programa' => $idPrograma,
                'id_fuente' => $idFuente,
                'id_meta' => $idMeta,
                'id_clasificador' => $idClasificador
            ])->first();

            if (!$detalle) {
                return $this->response->setJSON(['success' => false, 'message' => 'No se encontró el detalle especificado.']);
            }

            // Datos para el nuevo certificado
            $data = [
                'id_detalle' => $detalle['id_detalle'],
                'codigo_transaccion' => $this->request->getPost('certificado'),
                'fecha' => date('Y-m-d H:i:s'),
                'detalle' => $this->request->getPost('detalle'),
                'certificacion_monto' => ($this->request->getPost('tipo_certificacion') === 'monto') ? $this->request->getPost('dinero') : 0,
                'certificacion_rebaja' => ($this->request->getPost('tipo_certificacion') === 'rebaja') ? $this->request->getPost('dinero') : 0,
                'certificacion_ampliacion' => ($this->request->getPost('tipo_certificacion') === 'ampliacion') ? $this->request->getPost('dinero') : 0,
                'estado' => true,
                'id_centro_costos' => $idCentro ? $idCentro : null
            ];

            // Inserta el certificado y responde
            if ($this->certificadosModel->insert($data)) {
                return $this->response->setJSON(['success' => true]);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Error al guardar en la base de datos.']);
            }
        }

        // Respuesta para peticiones no AJAX
        return redirect()->back()->with('error', 'Método de solicitud no válido.');
    }


    // Método para guardar una nota modificatoria en la base de datos

    ///////////

    public function obtenerCertificados()
    {
        // Obtener los parámetros enviados
        $id_categoria = $this->request->getPost('id_categoria');
        $id_programa = $this->request->getPost('id_programa');
        $id_fuente = $this->request->getPost('id_fuente');
        $id_meta = $this->request->getPost('id_meta');
        $id_clasificador = $this->request->getPost('id_clasificador');

        // Consulta para obtener los certificados relacionados con detalle_seguimiento
        $certificados = $this->certificadosModel
            ->select('certificados.id_certificado, certificados.codigo_transaccion, certificados.fecha, certificados.detalle, certificados.modificacion, certificados.certificacion_monto, certificados.certificacion_rebaja, certificados.certificacion_ampliacion, certificados.estado, detalle_seguimiento.PIA')  // Traer campos de la tabla certificados y de detalle_seguimiento
            ->join('detalle_seguimiento', 'detalle_seguimiento.id_detalle = certificados.id_detalle', 'left')  // Hacer el join con detalle_seguimiento
            ->where([
                'detalle_seguimiento.id_categoria' => $id_categoria,
                'detalle_seguimiento.id_programa' => $id_programa,
                'detalle_seguimiento.id_fuente' => $id_fuente,
                'detalle_seguimiento.id_meta' => $id_meta,
                'detalle_seguimiento.id_clasificador' => $id_clasificador
            ])
            ->findAll();

        // Devuelve los resultados en formato JSON
        return $this->response->setJSON($certificados);
    }

    public function guardarNotaModificatoria()
    {
        if ($this->request->isAJAX()) {
            $idCategoria = $this->request->getPost('id_categoria');
            $idPrograma = $this->request->getPost('id_programa');
            $idFuente = $this->request->getPost('id_fuente');
            $idMeta = $this->request->getPost('id_meta');
            $idClasificador = $this->request->getPost('id_clasificador');
            $idCentro = $this->request->getPost('idCentro');

            if (!$idCategoria || !$idPrograma || !$idFuente || !$idMeta || !$idClasificador) {
                return $this->response->setJSON(['success' => false, 'message' => 'Faltan datos.']);
            }
            $detalle = $this->detalleSeguimientoModel->where([
                'id_categoria' => $idCategoria,
                'id_programa' => $idPrograma,
                'id_fuente' => $idFuente,
                'id_meta' => $idMeta,
                'id_clasificador' => $idClasificador
            ])->first();

            if (!$detalle) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'No se encontró un detalle correspondiente.']);
            }

            $data = [
                'id_detalle' => $detalle['id_detalle'],
                'codigo_transaccion' => null, // No se registra código de transacción para notas
                'fecha' => date('Y-m-d H:i:s'),
                'detalle' => $this->request->getPost('detalle1'),
                'modificacion' => $this->request->getPost('notadinero'),
                'certificacion_monto' => 0,
                'certificacion_rebaja' => 0,
                'certificacion_ampliacion' => 0,
                'estado' => true,
                'id_centro_costos' => $idCentro ? $idCentro : null
            ];

            $this->certificadosModel->crearCertificado($data);

            return $this->response->setJSON(['success' => true]);;
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'Método de solicitud no válido.']);
    }

    public function eliminarCertificacion()
    {
        if ($this->request->isAJAX()) {
            $idCertificado = $this->request->getPost('id_certificado');

            // Cambiar el estado a inactivo o eliminar la certificación
            if ($this->certificadosModel->delete($idCertificado)) {
                return $this->response->setJSON(['success' => true, 'message' => 'Certificación eliminada correctamente.']);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Error al eliminar la certificación.']);
            }
        }
        return $this->response->setJSON(['success' => false, 'message' => 'Método no permitido.']);
    }

    public function editarCertificado()
    {
        $idCertificado = $this->request->getPost('id_certificado');
        $data = [
            'codigo_transaccion' => $this->request->getPost('certificado'),
            'detalle' => $this->request->getPost('detalle'),
            'certificacion_monto' => ($this->request->getPost('tipo_certificacion') === 'monto') ? $this->request->getPost('dinero') : 0,
            'certificacion_rebaja' => ($this->request->getPost('tipo_certificacion') === 'rebaja') ? $this->request->getPost('dinero') : 0,
            'certificacion_ampliacion' => ($this->request->getPost('tipo_certificacion') === 'ampliacion') ? $this->request->getPost('dinero') : 0
        ];

        if ($this->certificadosModel->update($idCertificado, $data)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Certificado actualizado con éxito.']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Error al actualizar el certificado.']);
        }
    }
    public function editarNotaModificatoria()
    {
        $idCertificado = $this->request->getPost('id_certificado');
        $data = [
            'detalle' => $this->request->getPost('detalle1'),
            'modificacion' => $this->request->getPost('notadinero')
        ];

        if ($this->certificadosModel->update($idCertificado, $data)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Nota modificatoria actualizada con éxito.']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Error al actualizar la nota modificatoria.']);
        }
    }

    public function buscarCarpetas()
    {
        $nombre = $this->request->getGet('nombre');
        $idCategoria = $this->request->getGet('id_categoria');
        $idPrograma = $this->request->getGet('id_programa');
        $idFuente = $this->request->getGet('id_fuente');
        $idCarpetaPadre = $this->request->getGet('id_carpeta_padre');

        $builder = $this->carpetaModel;

        // Aplicar filtros condicionales
        if (!empty($idCategoria)) {
            $builder = $builder->where('id_categoria', $idCategoria);
        }

        if (!empty($idPrograma)) {
            $builder = $builder->where('id_programa', $idPrograma);
        }

        if (!empty($idFuente)) {
            $builder = $builder->where('id_fuente', $idFuente);
        }

        if ($idCarpetaPadre === 'null' || is_null($idCarpetaPadre) || $idCarpetaPadre === '') {
            $builder = $builder->where('id_carpeta_padre', null);
        } else {
            $builder = $builder->where('id_carpeta_padre', $idCarpetaPadre);
        }

        if (!empty($nombre)) {
            $builder = $builder->like('nombre_carpeta', $nombre);
        }

        $carpetas = $builder->findAll();

        foreach ($carpetas as &$carpeta) {
            $carpeta['nombre_programa'] = $carpeta['id_programa'] ? ($this->programaModel->find($carpeta['id_programa'])['nombre_programa'] ?? 'Sin programa') : 'Sin programa';
            $carpeta['nombre_fuente'] = $carpeta['id_fuente'] ? ($this->fuenteModel->find($carpeta['id_fuente'])['nombre_fuente'] ?? 'Sin fuente') : 'Sin fuente';
            $carpeta['nombre_meta'] = $carpeta['id_meta'] ? ($this->metaModel->find($carpeta['id_meta'])['nombre_meta'] ?? 'Sin meta') : 'Sin meta';
        }

        return $this->response->setJSON($carpetas);
    }
}
