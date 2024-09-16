<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ModulosModel;

class Modulos extends Controller
{

public function __construct(){
    $this->modModulo = new ModulosModel();
}

    public function index()
    {
        $listaModulos = $this->modModulo->getModulos();
        $modulosPadres = $this->modModulo->getModulosPadres();
        $scripts = ['scripts' => ['js/modulos.js?v=7.2.6']];
        $this->viewData("modulos", ["Modulos" => $listaModulos, "ModulosPadres" => $modulosPadres], $scripts);
    }

public function formData()
    {
    $validation = \Config\Services::validation();
    $postData = $this->request->getPost();
    $isUpdating = isset($postData['id_modulo']) && !empty($postData['id_modulo']);

    $validationRules = [
        'nombremodulo' => 'required|is_unique[modulo.nombremodulo]',
        'urlmodulo' => 'permit_empty',
        'idmodulopadre' => 'permit_empty',
    ];

    $validation->setRules($validationRules);

    if ($validation->withRequest($this->request)->run()) {

        $data = [
            'nombremodulo' => $postData['nombremodulo'],
            'urlmodulo' => isset($postData['urlmodulo']) && !empty($postData['urlmodulo'])? $postData['urlmodulo'] : null,
            'idmodulopadre' => isset($postData['idmodulopadre']) && !empty($postData['idmodulopadre'])? $postData['idmodulopadre'] : null,
        ];

        if ($isUpdating) {
            // ACTUALIZAR
            $response = $this->actualizar($data, $postData['id_modulo']);
            $mensaje = $response
                ? ["Tipo" => 'success', "Mensaje" => "Actualizaciónn Exitosa."]
                : ["Tipo" => 'error', "Mensaje" => "No se pudo actualizar."];
            } else {
                // REGISTRAR
                $response = $this->registrar($data);
                $mensaje = $response
                    ? ["Tipo" => 'success', "Mensaje" => "Registro Exitoso."]
                    : ["Tipo" => 'error', "Mensaje" => "No se pudo registrar."];
            }

            session()->setFlashdata('AlertShow', $mensaje);
        } else {
            $errors = $validation->getErrors();
             var_dump($errors); die();
            session()->setFlashdata('AlertShowCode', $errors);
        }

        return redirect()->to(base_url() . "/modulos");
    }

    public function formData1()
{
    $validation = \Config\Services::validation();
    $postData = $this->request->getPost();
    $isUpdating = isset($postData['id_modulo']) && !empty($postData['id_modulo']);

    $validationRules = [
        'nombremodulo' => 'required|is_unique[modulo.nombremodulo]',
        'urlmodulo' => 'required|is_unique[modulo.urlmodulo]',
        'idmodulopadre' => 'permit_empty',
    ];

    $validation->setRules($validationRules);

    if ($validation->withRequest($this->request)->run()) {
        $data = [
            'nombremodulo' => $postData['nombremodulo'],
            'urlmodulo' => $postData['urlmodulo'],
            'idmodulopadre' => isset($postData['idmodulopadre']) && !empty($postData['idmodulopadre']) ? $postData['idmodulopadre'] : null,
        ];

        if ($isUpdating) {
            // ACTUALIZAR
            $response = $this->actualizar($data, $postData['id_modulo']);
            $mensaje = $response
                ? ["Tipo" => 'success', "Mensaje" => "Actualización Exitosa."]
                : ["Tipo" => 'error', "Mensaje" => "No se pudo actualizar."];
        } else {
            // REGISTRAR
            $response = $this->registrar($data);
            $mensaje = $response
                ? ["Tipo" => 'success', "Mensaje" => "Registro Exitoso."]
                : ["Tipo" => 'error', "Mensaje" => "No se pudo registrar."];
        }

        session()->setFlashdata('AlertShow', $mensaje);
    } else {
        $errors = $validation->getErrors();
        session()->setFlashdata('AlertShowCode', $errors);
    }

    return redirect()->to('/modulos'); // Correct redirect to /modulos
}

    public function registrar($data){
        return $this->modModulo->insert($data);
    }

    public function actualizar($data, $id){
            return $this->modModulo->update($id, $data);
    }


    public function listar_modulos(){
        if($this->request->isAjax()) {
            $id = $this->request->getVar('id_modulo');
            $response = $this->modModulo->getModulo($id);
            $mensaje = $response?["Status" => '200', "Mensaje" => $response[0]]:["Status" => '404',"Mensaje" => "PeticiÃ³n no completada"];
            return json_encode($mensaje);
        }else{
            return redirect()->to(base_url()."modulo");
        }
    }

}
