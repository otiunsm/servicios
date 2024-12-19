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
        $listarCategorias = $this->modCate->getcategorias();
        $scripts = [
            'scripts' => ['js/act_categorias.js?v=7.1.6', 'js/alertas.js?v=7.1.6'],
        ];
        $this->viewData("act_registro/categorias", ["Categorias" => $listarCategorias], $scripts); 
    }

    public function listar_categoria() {
        if ($this->request->isAjax()) {
            $id = $this->request->getVar('item_categoria');
            $response = $this->modCate->getcategoria($id);

            $mensaje = $response 
                ? ["Status" => '200', "Mensaje" => $response] 
                : ["Status" => '404', "Mensaje" => "Categoría no encontrada"];
            
            return $this->response->setJSON($mensaje);
        }
        return redirect()->to(base_url() . "/Act_Categorias");
    }

    public function guardar() {
        $validation = \Config\Services::validation();
        $postData = $this->request->getPost();
        $isUpdating = isset($postData['id_categoria_actividad']) && !empty($postData['id_categoria_actividad']);

        $validationRules = [
            'nombre_c' => 'required', // Agregar reglas de validación
        ];

        $validation->setRules($validationRules);

        if ($validation->withRequest($this->request)->run()) {
            $data = [
                'nombre_c' => $postData['nombre_c'],
            ];

            if ($this->modCate->categoria_exists($data['nombre_c'], $isUpdating ? $postData['id_categoria_actividad'] : null)) {
                session()->setFlashdata('AlertShowN', ["Tipo" => 'error', "Mensaje" => "El nombre de la categoría ya existe."]);
                return redirect()->back()->withInput();
            }

            if ($isUpdating) {
                $response = $this->modCate->update($postData['id_categoria_actividad'], $data);
                $mensaje = $response ? ["Tipo" => 'success', "Mensaje" => "Categoría actualizada."] : ["Tipo" => 'error', "Mensaje" => "No se pudo actualizar."];
            } else {
                $response = $this->modCate->insert($data);
                $mensaje = $response ? ["Tipo" => 'success', "Mensaje" => "Categoría agregada."] : ["Tipo" => 'error', "Mensaje" => "No se pudo agregar."];
            }

            session()->setFlashdata('AlertShowN', $mensaje);
            return redirect()->to(base_url('/Act_Categorias'));
        }
        return redirect()->back()->withInput()->with('validation', $validation);
    }

    public function toggleEstado($id) {
        $success = $this->modCate->toggleEstadoCategoria($id);
        return $this->response->setJSON([
            'Status' => $success ? '200' : '400',
            'Mensaje' => $success ? 'Estado cambiado' : 'Error al cambiar el estado'
        ]);
    }

    public function eliminar($id) {
        $response = $this->modCate->delete($id);
        $mensaje = $response ? ["Tipo" => 'success', "Mensaje" => "Categoría eliminada."] : ["Tipo" => 'error', "Mensaje" => "Error al eliminar categoría."];
        
        session()->setFlashdata('AlertShowN', $mensaje);
        return redirect()->to('/Act_Categorias');
    }
}
