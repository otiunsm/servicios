<?php

namespace App\Controllers;
use App\Models\ActDepenModel;
use CodeIgniter\Controller;

class Act_Dependencias extends Controller
{
    protected $modDepen;

    public function __construct() {
        $this->modDepen = new ActDepenModel();
    }

    public function index() {
        $listarDependencias = $this->modDepen->getdepens();
        $scripts = [
            'scripts'=>['js/act_dependencias.js?v=7.1.6','js/alertas.js?v=7.1.6'],
        ];
        $this->viewData("act_registro/dependencias", ["Dependencias" => $listarDependencias], $scripts); 
    }

    public function guardar() {
        $validation = \Config\Services::validation();
        $postData = $this->request->getPost();
        $isUpdating = isset($postData['id_dependencia']) && !empty($postData['id_dependencia']);

        $validationRules = [
            'nombre_dep' => 'required',
            'descripcion' => 'permit_empty',
            
        ];

        $validation->setRules($validationRules);

        if ($validation->withRequest($this->request)->run()) {
            $data = [
                'nombre_dep' => $postData['nombre_dep'],
                'descripcion' => $postData['descripcion'],
                
            ];

            if ($isUpdating) {
                $response = $this->actualizar($data, $postData['id_dependencia']);
                $mensaje = $response
                    ? ["Tipo" => 'success', "Mensaje" => "Actualización exitosa de la dependencia."]
                    : ["Tipo" => 'error', "Mensaje" => "No se pudo actualizar la dependencia."];
            } else {
                $response = $this->registrar($data);
                $mensaje = $response
                    ? ["Tipo" => 'success', "Mensaje" => "Registro exitoso de la dependencia."]
                    : ["Tipo" => 'error', "Mensaje" => "No se pudo registrar la dependencia."];
            }

            session()->setFlashdata('AlertShowN', $mensaje);
        } else {
            $errors = $validation->getErrors();
            session()->setFlashdata('AlertShowCode', $errors);
        }

        return redirect()->to(base_url() . "/Act_Dependencias");
    }

    public function registrar($data) {
        if ($this->modDepen->valid_depen(null, $data['nombre_dep'])) {
            return false; // Si la dependencia ya existe
        }

        return $this->modDepen->insert($data) ? true : false;
    }

    public function actualizar($data, $id) {
        if ($this->modDepen->updateValidDepen($id, $data['nombre_dep'])) {
            return false;  // Si ya existe otra con el mismo nombre
        }

        return $this->modDepen->update($id, $data) ? true : false;
    }

    public function listar_dependencia() {
        if ($this->request->isAjax()) {
            $id = $this->request->getVar('item_dependencia');
            $response = $this->modDepen->getdepen($id);

            $mensaje = $response 
                ? ["Status" => '200', "Mensaje" => $response] 
                : ["Status" => '404', "Mensaje" => "Dependencia no encontrada"];
            
            return $this->response->setJSON($mensaje);
        } else {
            return redirect()->to(base_url()."/Act_Dependencias");
        }
    }

    public function eliminar($id) {
        if (!empty($id)) {
            $guardar = $this->modDepen->update($id, ['estado_dep' => '0']);
            $mensaje = $guardar 
                ? ["Tipo" => 'success', "Mensaje" => "Dependencia eliminada correctamente."] 
                : ["Tipo" => 'error', "Mensaje" => "No se pudo eliminar la dependencia."];
        } else {
            $mensaje = ["Tipo" => 'error', "Mensaje" => "ID de dependencia no válido."];
        }

        session()->setFlashdata('AlertShowN', $mensaje);
        return redirect()->to(base_url()."/Act_Dependencias");
    }
}
