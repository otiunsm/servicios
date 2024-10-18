<?php

namespace App\Controllers;
use App\Models\ActCateModel;
use CodeIgniter\Controller;

class Act_Categorias extends Controller
{
    protected $modCate;

    public function __construct() {
        $this->modCate = new ActCateModel();
    }

    public function index() {
        $listarCategorias = $this->modCate->getCates();
        $scripts = [
            'scripts'=>['js/act_categorias.js?v=7.1.6','js/msj.js?v=7.1.6'],
        ];
        $this->viewData("act_registro/categorias", ["Categorias" => $listarCategorias], $scripts); 
    }

    
    public function listar_categoria() {
        if ($this->request->isAjax()) {
            $id = $this->request->getVar('item_categoria');
            $response = $this->modCate->getcate($id);

            $mensaje = $response 
                ? ["Status" => '200', "Mensaje" => $response] 
                : ["Status" => '404', "Mensaje" => "Dependencia no encontrada"];
            
            return $this->response->setJSON($mensaje);
        } else {
            return redirect()->to(base_url()."/Act_Dependencias");
        }
    }


    
    public function guardar() {
        $validation = \Config\Services::validation();
        $postData = $this->request->getPost();
        $isUpdating = isset($postData['id_item']) && !empty($postData['id_item']);
        $validationRules = [
            'nombre_c' => 'required',
            
        ];

        $validation->setRules($validationRules);

        if ($validation->withRequest($this->request)->run()) {
            $data = [
                'nombre_c' => $postData['nombre_c'],
            ];
            
            $isUpdating = isset($postData['id_item']) && !empty($postData['id_item']);
            
            if ($isUpdating) {
                $response = $this->actualizar($postData['id_item'], $data); // Assuming you have an 'actualizar' method
                $mensaje = $response
                    ? ["Tipo" => 'success', "Mensaje" => "Actualización exitosa de la categoria."]
                    : ["Tipo" => 'error', "Mensaje" => "No se pudo actualizar la categoria."];
            } else {
                $response = $this->registrar($data);
                $mensaje = $response
                    ? ["Tipo" => 'success', "Mensaje" => "Registro exitoso de la categoria."]
                    : ["Tipo" => 'error', "Mensaje" => "No se pudo registrar la categoria."];
            }

            session()->setFlashdata('AlertShow', $mensaje);
        } else {
            $errors = $validation->getErrors();
            session()->setFlashdata('AlertShowCode', $errors);
        }

        return redirect()->to(base_url() . "/Act_Categorias");
    }


    
    public function registrar($data) {
        if ($this->modCate->valid_cate(null, $data['nombre_c'])) {
            return false; // Si la categorias si ya existe
        }

        return $this->modCate->insert($data) ? true : false;
    }

    public function actualizar($id, $data) {
        // Check if $data is an array before accessing its 'nombre_c' key
        if (!is_array($data) || !isset($data['nombre_c'])) {
            throw new \InvalidArgumentException('Invalid data format. Expected an array with a key "nombre_c".');
        }
    
        // Now proceed with the update validation
        if ($this->modCate->updateValidcate($id, $data['nombre_c'])) {
            return false;  // If another category exists with the same name
        }
    
        return $this->modCate->update($id, $data) ? true : false;
    }
    
    
    public function eliminar($id) {
        if (!empty($id)) {
            $guardar = $this->modCate->update($id, ['estado_cate' => '0']);
            $mensaje = $guardar 
                ? ["Tipo" => 'success', "Mensaje" => "Categoria eliminada correctamente."] 
                : ["Tipo" => 'error', "Mensaje" => "No se pudo eliminar la categoria."];
        } else {
            $mensaje = ["Tipo" => 'error', "Mensaje" => "ID de Categoria no válido."];
        }

        session()->setFlashdata('AlertShow', $mensaje);
        return redirect()->to(base_url()."/Act_Categorias");
    }

}
