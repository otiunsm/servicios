<?php

namespace App\Controllers;
use App\Models\Act_solicitanteModel;
use CodeIgniter\Controller;
class Act_solicitante extends Controller
{
  protected $modSol; // se agreo esto
  public function __construct()
  {
    $this->modSol = new Act_solicitanteModel();
  }
  public function index()
  {
    $listarSolicitante = $this->modSol->getSolicitantes();
    $scripts = ['scripts' => ['js/form_solicitante.js?v=7.1.6','js/msj.js?v=7.1.6','plugins/custom/qrcode/jquery.classyqr.js?v=7.1.6']];
    $this->viewData("act_registro/solicitante", ["Act_solicitante" => $listarSolicitante], $scripts);
  }
  public function formData()
  {
    $validation = \Config\Services::validation();
    $postData = $this->request->getPost(); // Obtener los datos del formulario mediante POST
    $isUpdating = isset($postData['id_solicitante']) && !empty($postData['id_solicitante']);
    // Verificar que se recibieron datos
    if (!$postData) {
      session()->setFlashdata('error', 'No se recibieron datos del formulario.');
      return redirect()->to(base_url() . '/Act_solicitante');
    }

    // Definir reglas de validación
    $validationRules = [
      'dni_so' => 'required|alpha_numeric|min_length[8]',
      'nombre_so' => 'required',
      // 'apellidos_so' => 'required',
      'email_so' => 'required|valid_email',
      'telefono_so' => 'permit_empty|string',
      'direccion_so' => 'permit_empty',
      'cargo_so' => 'permit_empty',
    ];

    $validation->setRules($validationRules);

    if ($validation->withRequest($this->request)->run()) {
      // Preparar los datos para insertar o actualizar
      $data = [
        'dni_so' => $postData['dni_so'],
        'nombre_so' => $postData['nombre_so'],
        // 'apellidos_so' => $postData['apellidos_so'],
        'email_so' => $postData['email_so'],
        'telefono_so' => $postData['telefono_so'],
        'direccion_so' => $postData['direccion_so'],
        'cargo_so' => $postData['cargo_so'],
      ];
      // Insertar o actualizar los datos en la base de datos
      if ($isUpdating) {
        $response = $this->actualizar($data, $postData['id_solicitante']);
        $mensaje = $response
          ? ["Tipo" => 'success', "Mensaje" => "Actualización Exitosa."]
          : ["Tipo" => 'error', "Mensaje" => "No se pudo actualizar."];
      } else {
        $response = $this->registrar($data);
        $mensaje = $response
          ? ["Tipo" => 'success', "Mensaje" => "Registro Exitoso."]
          : ["Tipo" => 'error', "Mensaje" => "No se pudo registrar."];
      }
      session()->setFlashdata('AlertShow', $mensaje);
    } else {
      $errors =  $validation->getErrors();
      session()->setFlashdata('AlertShowCode', $errors);
    }
    return  redirect()->to(base_url() . '/Act_solicitante');
  }
  public function registrar($data)
  {
    if ($this->modSol->valid_soli(null, $data['nombre_so'])) {
      return false;
    }
    $guardar = $this->modSol->insert($data);
    $response = $guardar ? true : false;
    return $response;
  }

  public function actualizar($data, $id)
  {
    if ($this->modSol->valid_soli($id, $data['nombre_so'])) {
      return false;
    }
    $guardar = $this->modSol->update($id, $data);
    $response = $guardar ? true : false;
    return $response;
  }

  public function listar_soli()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('item_solicitante');
      $response = $this->modSol->getSolicitante($id);
      $mensaje = $response
        ? ["Status" => '200', "Mensaje" => $response[0]]  
        : ["Status" => '404', "Mensaje" => "Solicitante no encontrado."];
      return $this->response->setJSON($mensaje);
    } else {
      return redirect()->to(base_url() . '/Act_solicitante');
    }
  }

  public function eliminar($id){
    if (!empty($id)) {
        $guardar = $this->modSol->update($id, ['estado_so' => '0']);
        $mensaje = $guardar ? ["Tipo" => 'success', "Mensaje" => "Solicitante eliminado correctamente."] : ["Tipo" => 'error', "Mensaje" => "No se pudo eliminar el solicitante."];
    } else {
        $mensaje = ["Tipo" => 'error', "Mensaje" => "ID de solicitante no válido."];
    }
    session()->setFlashdata('AlertShow', $mensaje);
    return redirect()->to(base_url()."/Act_solicitante");
}
}
