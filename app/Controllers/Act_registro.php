<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Act_registroModel;
use App\Models\Act_solicitanteModel;
use App\Models\ActDepenModel;
use App\Models\ActCateModel;

class Act_registro extends Controller
{
  protected $modAct; 
  protected $modSolic;
  protected $modDepen;
  protected $catemodel;

  public function __construct()
  {
    $this->modAct = new Act_registroModel();
    $this->modSolic = new Act_solicitanteModel();
    $this->modDepen = new ActDepenModel();
    $this->catemodel = new ActCateModel();
  }

  public function index()
  {
   // $id = session()->get('id_user');
   //$idperfil = session()->get('idperfil');
   //$listarActividad = $this->modAct->getRegistros($id, $idperfil);
    $scripts = ['scripts' => ['js/act_registrar.js', 'js/alertas.js', '']];
    $this->viewData("act_registro/registrar", ["Act_registro"], $scripts);
  }

  public function listar()
  {
      $id = session()->get('id_user');
      $idperfil = session()->get('idperfil');
      // Obtener fechas de la solicitud
      $fechainicio = $this->request->getVar('fechainicio');
      $fechafin = $this->request->getVar('fechafin');
      $listarActividad = $this->modAct->getRegistroscopia($id, $idperfil, $fechainicio, $fechafin);
    /*   echo "<pre>";
      print_r($listarActividad); */
      if (empty($listarActividad)) {
          return json_encode([
              'status' => 'error',
              'message' => 'No se encontraron registros para los filtros especificados.',
              'data' => []
          ]);
      }
        return json_encode($listarActividad);
  }
   
  public function listar_registro()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('item_registrar');
      $response = $this->modAct->getRegistro($id);
     
      $mensaje = $response ? ["Status" => '200', "Mensaje" => $response[0]] : ["Status" => '404', "Mensaje" => "PeticiÃ³n no completada"];
      return json_encode($mensaje);
    } else {
      return redirect()->to(base_url() . "/Act_registro");
    }
  }

  /*==============================================================================
  =====================FUNCION PARA GENERAR CODIGO ALEATORIO======================
  =================================================================================*/
  public function generarNumeroCorrelativo()
  {
    $year = date('Y');  // Año actual
    $month = date('m'); // Mes actual

    $numeroPrefix = "{$year}-{$month}";
    $ultimoNumero = $this->modAct
      ->select('numero')
      ->like('numero', "{$numeroPrefix}%", 'after')
      ->orderBy('numero', 'DESC')
      ->first();
    if ($ultimoNumero) {
      $lastCorrelativo = explode('-', $ultimoNumero['numero'])[0];
      $nuevoCorrelativo = str_pad((int)$lastCorrelativo + 1, 3, '0', STR_PAD_LEFT);
    } else {
      $nuevoCorrelativo = '001';
    }
    $nuevoNumero = "{$nuevoCorrelativo}-{$year}-{$month}";
    return $nuevoNumero;
  }

  /*nuevo*/
  public function formData()
  {
    $iduser = session()->get('id_user');
    $validation = \Config\Services::validation();
    $postData = $this->request->getPost();
    $isUpdating = isset($postData['idregistro']) && !empty($postData['idregistro']);  // Verificar si se está actualizando un registro
    $validationRules = [
      'numero' => 'permit_empty',
      'tipo_solicitud' => 'permit_empty',
      'fec_doc_sgd' => 'permit_empty',
      'nro_carta' => 'permit_empty',
      'detalle_actividad' => 'required',
      'fec_atencion' => 'permit_empty',
      'tipo_doc' => 'permit_empty',
      'id_dependencia' => 'required',
      'id_solicitante' => 'required',
      'tipo_asistencia' => 'permit_empty',
      'medio_solicitud' => 'permit_empty',
      'id_categoria_actividad' => 'permit_empty',
      'estado_r' => 'permit_empty',
      'otras_atenciones' => 'permit_empty',
      'observacion' => 'permit_empty',
    ];
    $validation->setRules($validationRules);
    try {
      if (!$validation->withRequest($this->request)->run()) {
        $errors = $validation->getErrors();
        return $this->response->setJSON([
          'Status' => '400',
          'Mensaje' => 'Errores de validación.',
          'Errores' => $errors
        ]);
      }
      $data = [
        'numero' => $this->generarNumeroCorrelativo() ?? null,
        'idregistro' => $postData['idregistro'] ?? null,
        'tipo_solicitud' => $postData['tipo_solicitud'] ?? null,
        'fec_doc_sgd' => $postData['fec_doc_sgd'] ?? null,
        'nro_carta' => $postData['nro_carta'],
        'detalle_actividad' => $postData['detalle_actividad'] ?? null,
        'fec_registro' => date('Y-m-d'),
        'fec_atencion' => $postData['fec_atencion'] ?? null,
        'tipo_doc' => $postData['tipo_doc']  ?? '-',
        'id_dependencia' => $postData['id_dependencia'] ?? null,
        'id_solicitante' => $postData['id_solicitante'] ?? null,
        'tipo_asistencia' => $postData['tipo_asistencia'] ?? null, // Cambiado a tipo_asistencia
        'medio_solicitud' => $postData['medio_solicitud'] ?? null,
        'id_categoria_actividad' => $postData['id_categoria_actividad'] ?? null,
        'estado_r' => $postData['estado_r'] ?? null,
        'otras_atenciones' => $postData['otras_atenciones'] ?? null,
        'observacion' => $postData['observacion'] ?? null,
        'id_usuario' => $iduser,
      ];

      // Determinar si actualizar o insertar
      if ($isUpdating) {
        $response = $this->modAct->update($postData['idregistro'], $data);
        if ($response) {
          return $this->response->setJSON([
            'Status' => '200',
            'Mensaje' => 'Actualización exitosa.',
          ]);
        } else {
          return $this->response->setJSON([
            'Status' => '500',
            'Mensaje' => 'Error al actualizar el registro.',
          ]);
        }
      } else {
        $response = $this->modAct->insert($data);
        if ($response) {
          return $this->response->setJSON([
            'Status' => '200',
            'Mensaje' => 'Registro exitoso.',
          ]);
        } else {
          return $this->response->setJSON([
            'Status' => '500',
            'Mensaje' => 'Error al registrar los datos.',
          ]);
        }
      }
    } catch (\Exception $e) {
      log_message('error', 'Error en formData: ' . $e->getMessage());
      return $this->response->setJSON([
        'Status' => '500',
        'Mensaje' => 'Ocurrió un error interno en el servidor.',
        'Error' => $e->getMessage(),
      ]);
    }
  }



  /**----------------------------------------------- */
 public function buscarSoli()
  {
    if ($this->request->isAjax()) {
      $nombre = $this->request->getVar('nombre_so') ?? '';
      $numDocumento = $this->request->getVar('num_doc') ?? '';
      $solicitudes = $this->modSolic->selectsolicitantes($nombre, $numDocumento);
      if (!empty($solicitudes)) {
        return $this->response->setJSON([
          'status' => 'success',
          'data' => $solicitudes
        ]);
      } else {
        return $this->response->setJSON([
          'status' => 'error',
          'message' => 'No se encontraron solicitantes que coincidan con los criterios.'
        ]);
      }
    } else {
      return redirect()->to(base_url() . "Act_registro");
    }
  } 


  public function listar_dependencias()
  {
    if ($this->request->isAjax()) {
      $nombre = $this->request->getVar('nombre_dep') ?? '';
      $dep = $this->modDepen->selectDepens($nombre);
      if (!empty($dep)) {
        return $this->response->setJSON([
          'status' => 'success',
          'data' => $dep
        ]);
      } else {
        return $this->response->setJSON([
          'status' => 'error',
          'message' => 'No se encontraron solicitantes que coincidan con los criterios.'
        ]);
      }
    } else {
      return redirect()->to(base_url() . "Act_registrar");
    }
  }
  //lisdtar dependencias
  public function listarcategoiriaact()
  {
    $response = $this->catemodel->selectcategorias();
    return $this->response->setJSON($response);
  }

  public function cambiarEstado()
  {
    $idregistro = $this->request->getPost('idregistro');
    $nuevoEstado = $this->request->getPost('nuevoEstado');

    $registro = $this->modAct->find($idregistro);
    if (!$registro) {
      return $this->response->setJSON([
        "Tipo" => 'error',
        "Mensaje" => "Registro no encontrado."
      ]);
    }

    $guardar = $this->modAct->actualizarEstado($idregistro, $nuevoEstado);
    $accion = $nuevoEstado == '1' ? 'Activado' : 'Desactivado';

    if ($guardar) {
      return $this->response->setJSON([
        "Tipo" => 'success',
        "Mensaje" => "$accion Correctamente."
      ]);
    } else {
      return $this->response->setJSON([
        "Tipo" => 'error',
        "Mensaje" => "No se pudo cambiar el estado."
      ]);
    }
  }

 

}
