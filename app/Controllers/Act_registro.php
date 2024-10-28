<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Act_registroModel;
use App\Models\Act_solicitanteModel;
use App\Models\ActDepenModel;
use App\Models\ActCateModel;


class Act_registro extends Controller
{
  protected $modAct; // se agreo esto
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
    $listarActividad = $this->modAct->getRegistros();
    $scripts = ['scripts' => ['js/act_registrar.js?v=7.1.6', 'js/msj.js?v=7.1.6', 'plugins/custom/qrcode/jquery.classyqr.js?v=7.1.6', '']];

    $this->viewData("act_registro/registrar", ["Act_registro" => $listarActividad], $scripts);
  }


  public function listar_registro() //creado con luis
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('idregistro');
      $response = $this->modAct->getact();
      $mensaje = $response ? ["Status" => '200', "Mensaje" => $response[0]] : ["Status" => '404', "Mensaje" => "PeticiÃ³n no completada"];
      return json_encode($mensaje);
    } else {
      return redirect()->to(base_url() . "Act_registrar");
    }
  }
  /*nuevo*/
  public function formData()
  {
    $validation = \Config\Services::validation();
    $postData = $this->request->getPost();
    $isUpdating = isset($postData['id_item']) && !empty($postData['id_item']); // Determina si estamos actualizando

    // Reglas de validación
    $validationRules = [
      'numero' => 'required',
      'fec_doc_sgd' => 'required|valid_date',
      'nro_carta' => 'required',
      'detalle_actividad' => 'required',
      'fec_registro' => 'required|valid_date',
      'fec_atencion' => 'required|valid_date',
      'observacion' => 'permit_empty',
      'tipo_doc' => 'required|integer',
      'id_dependencia' => 'required|integer',
      'id_solicitante' => 'required|integer',
      'id_medio_solicitud' => 'required|integer',
      'id_tipo_asistencia' => 'required|integer',
      'id_categoria_actividad' => 'required|integer',
      'id_usuario' => 'required|integer',
      'estado_r' => 'required|in_list[0,1]', // Suponiendo que es un estado activo/inactivo
    ];

    $validation->setRules($validationRules);

    if ($validation->withRequest($this->request)->run()) {
      $data = [
        'numero' => $postData['numero'],
        'fec_doc_sgd' => $postData['fec_doc_sgd'],
        'nro_carta' => $postData['nro_carta'],
        'detalle_actividad' => $postData['detalle_actividad'],
        'fec_registro' => $postData['fec_registro'],
        'fec_atencion' => $postData['fec_atencion'],
        'observacion' => $postData['observacion'],
        'tipo_doc' => $postData['tipo_doc'],
        'id_dependencia' => $postData['id_dependencia'],
        'id_solicitante' => $postData['id_solicitante'],
        'id_medio_solicitud' => $postData['id_medio_solicitud'],
        'id_tipo_asistencia' => $postData['id_tipo_asistencia'],
        'id_categoria_actividad' => $postData['id_categoria_actividad'],
        'id_usuario' => $postData['id_usuario'],
        'estado_r' => $postData['estado_r'],
      ];

      if ($isUpdating) {
        // ACTUALIZAR
        $response = $this->modAct->update($postData['id_item'], $data);
        $mensaje = $response
          ? ["Tipo" => 'success', "Mensaje" => "Actualización Exitosa."]
          : ["Tipo" => 'error', "Mensaje" => "No se pudo actualizar."];
      } else {
        // INSERTAR
        $response = $this->modAct->insert($data);
        $mensaje = $response
          ? ["Tipo" => 'success', "Mensaje" => "Registro Exitoso."]
          : ["Tipo" => 'error', "Mensaje" => "No se pudo registrar."];
      }

      session()->setFlashdata('AlertShow', $mensaje);
    } else {
      // Manejo de errores
      $errors = $validation->getErrors();
      session()->setFlashdata('AlertShowCode', $errors);
    }

    return redirect()->to(base_url() . "/act_registro");
  }

  public function insert($data)
  {
    if ($this->modAct->valid_registro(null, $data['act_registro'])) {
      return false;
    }
    $guardar = $this->modAct->insert($data);
    $response = $guardar ? true : false;
    return $response;
  }
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
      return redirect()->to(base_url() . "Act_registrar");
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
}
