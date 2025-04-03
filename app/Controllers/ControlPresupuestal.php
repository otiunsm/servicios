<?php

namespace App\Controllers;

use App\Models\SegCategoriaModel;
use App\Models\SegCertificadosModel;
use App\Models\SegClasificadorModel;
use App\Models\SegDetalleSeguimientoModel;
use App\Models\SegFuenteFinanciamientoModel;
use App\Models\SegMetaModel;
use App\Models\SegProgramaPresupuestalModel;
use CodeIgniter\Controller;

class ControlPresupuestal extends Controller
{
    protected $detalleSeguimientoModel;
    protected $CategoriaModel;
    protected $programasModel;
    protected $fuentesModel;
    protected $metasModel;
    protected $clasificadoresModel;
    protected $certificadosModel;

    public function __construct()
    {
        $this->detalleSeguimientoModel = new SegDetalleSeguimientoModel();
        $this->programasModel = new SegProgramaPresupuestalModel();
        $this->fuentesModel = new SegFuenteFinanciamientoModel();
        $this->metasModel = new SegMetaModel();
        $this->clasificadoresModel = new SegClasificadorModel();
        $this->certificadosModel = new SegCertificadosModel();
        $this->CategoriaModel = new SegCategoriaModel();
    }

   // Método principal para mostrar la vista de Control Presupuestal
   public function index()
   {
       // Obtiene datos de programas, fuentes, metas y clasificadores activos para el formulario
       $data = [
            'categorias' => $this->CategoriaModel->where('estado', 1)->findAll(),
           'programas' => $this->programasModel->where('estado', 1)->findAll(),
           'fuentes' => $this->fuentesModel->where('estado', 1)->findAll(),
           'metas' => $this->metasModel->where('estado', 1)->findAll(),
           'clasificadores' => $this->clasificadoresModel->where('estado', 1)->findAll(),
           'detalles' => $this->detalleSeguimientoModel->obtenerDetallesActivos() // Obtiene todos los detalles activos
       ];

       $scripts = [
        'scripts' => [ 'js/seg_control.js?v=7.1.6', ],];
       return $this->viewData("seguimiento/control", $data, $scripts);
   }


   public function formData()
   {
       $validation = \Config\Services::validation();
       $postData = $this->request->getPost();
   
       // Ajusta las reglas de validación para cada elemento del array
       $validationRules = [
            'detalles.*.id_categoria' => 'required|integer',
           'detalles.*.id_programa' => 'required|integer',
           'detalles.*.id_fuente' => 'required|integer',
           'detalles.*.id_meta' => 'required|integer',
           'detalles.*.clasificadores' => 'required'
       ];
   
       $validation->setRules($validationRules);
   
       if ($validation->withRequest($this->request)->run()) {
           foreach ($postData['detalles'] as $detalle) {
            $idCategoria = $detalle['id_categoria'];    
            $idPrograma = $detalle['id_programa'];
               $idFuente = $detalle['id_fuente'];
               $idMeta = $detalle['id_meta'];
               $clasificadores = $detalle['clasificadores'];
   
               // Procesa cada clasificador por separado para cada combinación de programa, fuente, y meta
               foreach ($clasificadores as $clasificador) {
                   $data = [
                        'id_categoria' => $idCategoria,
                       'id_programa' => $idPrograma,
                       'id_fuente' => $idFuente,
                       'id_meta' => $idMeta,
                       'id_clasificador' => $clasificador,
                       'estado' => 1
                   ];
                   $this->detalleSeguimientoModel->crearDetalle($data);
               }
           }
   
           session()->setFlashdata('AlertShow', ["Tipo" => 'success', "Mensaje" => "Registro Exitoso."]);
       } else {
           // Devuelve los errores de validación
           $errors = $validation->getErrors();
           session()->setFlashdata('AlertShowCode', $errors);
       }
   
       return redirect()->to(base_url() . "/ControlPresupuestal");
   }

    public function eliminarDetalle($id)
    {
        $this->detalleSeguimientoModel->eliminarDetalle($id);
        return redirect()->to(base_url() . "/ControlPresupuestal");
    }

    

    public function ControlGastos($id_categoria,$id_programa, $id_fuente, $id_meta)
    {
        // Obtener los nombres de programa, fuente y meta
        $categoriaNombre = $this->CategoriaModel->find($id_categoria)['nombre_categoria'];
        $programaNombre = $this->programasModel->find($id_programa)['nombre_programa'];
        $fuenteNombre = $this->fuentesModel->find($id_fuente)['nombre_fuente'];
        $metaNombre = $this->metasModel->find($id_meta)['nombre_meta'];
    
        // Obtener los clasificadores específicos para esta combinación de programa, fuente y meta
        $data = [
            'clasificadores' => $this->detalleSeguimientoModel->getClasForGroup($id_categoria,$id_programa, $id_fuente, $id_meta),
            'categoriaNombre'=>$categoriaNombre,
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
    $categoriaNombre = $this->CategoriaModel->find($id_categoria)['nombre_categoria'];
    $programaNombre = $this->programasModel->find($id_programa)['nombre_programa'];
    $fuenteNombre = $this->fuentesModel->find($id_fuente)['nombre_fuente'];
    $metaNombre = $this->metasModel->find($id_meta)['nombre_meta'];
    $metaCod = $this->metasModel->find($id_meta)['codigo_meta'];

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
    
            // Verifica los datos requeridos
            if (!$idCategoria||!$idPrograma || !$idFuente || !$idMeta || !$idClasificador) {
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
                'estado' => true
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
            'estado' => true
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


}