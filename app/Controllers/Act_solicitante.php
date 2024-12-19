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
    $scripts = ['scripts' => ['js/form_solicitante.js', 'js/alertas.js', '']];
    $this->viewData("act_registro/solicitante", ["Act_solicitante" => $listarSolicitante], $scripts);
  }

  public function listar_soli()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getVar('item_solicitante');
      $response = $this->modSol->getSolicitante($id);
      $mensaje = $response
        ? ["Status" => '200', "Mensaje" => $response[0]]  : ["Status" => '404', "Mensaje" => "Solicitante no encontrado."];
      return json_encode($mensaje);
    } else {
      return redirect()->to(base_url() . '/Act_solicitante');
    }
  }
  public function formData()
  {
    $validation = \Config\Services::validation();
    $postData = $this->request->getPost(); // Obtener los datos del formulario mediante POST
    $isUpdating = isset($postData['id_solicitante']) && !empty($postData['id_solicitante']);

    // Definir reglas de validación
    $validationRules = [
      'dni_so' => 'required|alpha_numeric|min_length[8]',
      'nombre_so' => 'required',
      'email_so' => 'required|valid_email',
      'telefono_so' => 'permit_empty|string',
      'direccion_so' => 'permit_empty',
      'cargo_so' => 'permit_empty',
    ];

    $validation->setRules($validationRules);
    try {
    /*   if ($validation->withRequest($this->request)->run()) {
        $errors = $validation->getErrors();
        return $this->response->setJSON(
          [
            "Status" => '200',
            "Mensaje" => 'Errores de validación',
            "Errores" => $errors
          ]
        );
      } */
      $data = [
        'dni_so' => $postData['dni_so'] ?? null,
        'nombre_so' => $postData['nombre_so'] ?? null,
        'email_so' => $postData['email_so'] ?? null,
        'telefono_so' => $postData['telefono_so'] ?? null,
        'direccion_so' => $postData['direccion_so'] ?? null,
        'cargo_so' => $postData['cargo_so'] ?? null,
      ];
      // Insertar o actualizar los datos en la base de datos
      if ($isUpdating) {
        $response = $this->modSol->update($postData['id_solicitante'], $data);
        if ($response) {
          return $this->response->setJSON([
            'Status' => '200',
            'Mensaje' => 'Actualización exitosa.'
          ]);
        } else {
          return $this->response->setJSON([
            'Status' => '500',
            'Mensaje' => 'Error al actualizar el registro'
          ]);
        }
      } else {
        $response = $this->modSol->insert($data);
      //  echo $response;
        if ($response) {
          return $this->response->setJSON([
            'Status' => '200',
            'Registro' => 'Registro exitoso.'
          ]);
        } else {
          return $this->response->setJSON([
            'Status' => '500',
            'Registro' => 'Error al registrar el solicitante.'
          ]);
        }
      }
    } catch (\Exception $e) {
      log_message('error', 'Error en fordata' . $e->getMessage());
      return $this->response->setJSON([
        'Status' => '500',
        'Mensaje' => 'Error al registrar el solicitante.',
        'Error' => $e->getMessage(),
      ]);
    }
  }



  public function eliminar($id)
  {
    if (!empty($id)) {
      $guardar = $this->modSol->update($id, ['estado_so' => '0']);
      $mensaje = $guardar ? ["Tipo" => 'success', "Mensaje" => "Solicitante eliminado correctamente."] : ["Tipo" => 'error', "Mensaje" => "No se pudo eliminar el solicitante."];
    } else {
      $mensaje = ["Tipo" => 'error', "Mensaje" => "ID de solicitante no válido."];
    }
    session()->setFlashdata('AlertShow', $mensaje);
    return redirect()->to(base_url() . "/Act_solicitante");
  }
}
