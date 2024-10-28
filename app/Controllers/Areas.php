<?php

namespace App\Controllers;
use App\Models\ActAreasModel;
use CodeIgniter\Controller;

class Areas extends Controller
{
    protected $modArea;
    public function __construct()
    {
        $this->modArea = new ActAreasModel();
    }

    

    public function index()
    {
        $listarArea = $this->modArea->getareas();
        $scripts = [
            'scripts' => ['js/area.js?v=7.1.6', 'js/alertas.js?v=7.1.6'],
        ];
        $this->viewData("act_registro/areas", ["Areas" => $listarArea], $scripts); 
    }

    public function listar_area()
    {
        if ($this->request->isAjax()) {
            $id = $this->request->getVar('item_area');
            $response = $this->modArea->getarea($id);

            $mensaje = $response 
                ? ["Status" => '200', "Mensaje" => $response] 
                : ["Status" => '404', "Mensaje" => "Área no encontrada"];

            return $this->response->setJSON($mensaje);
        }
        return redirect()->to(base_url() . "/Areas");
    }

    public function guardar()
    {
        $validation = \Config\Services::validation();
        $postData = $this->request->getPost();
        $isUpdating = isset($postData['id_area']) && !empty($postData['id_area']);
        $idarea = $isUpdating ? $postData['id_area'] : null;

        $validationRules = [
            'nombre_area' => 'required',
            'descripcion' => 'permit_empty',
            'tipo_estado' => 'required',
        ];

        $validation->setRules($validationRules);

        if ($validation->withRequest($this->request)->run()) {
            $data = [
                'nombre_area' => $postData['nombre_area'],
                'descripcion' => $postData['descripcion'],
                'tipo_estado' => $postData['tipo_estado'],
            ];

            if ($this->modArea->area_exists($data['nombre_area'], $idarea)) {
                session()->setFlashdata('AlertShowN', ["Tipo" => 'error', "Mensaje" => "El nombre del área ya existe."]);
                return redirect()->back()->withInput();
            }

            if ($isUpdating) {
                $response = $this->modArea->update($idarea, $data);
                $mensaje = $response ? ["Tipo" => 'success', "Mensaje" => "Área actualizada."] : ["Tipo" => 'error', "Mensaje" => "No se pudo actualizar."];
            } else {
                $response = $this->modArea->insert($data);
                $mensaje = $response ? ["Tipo" => 'success', "Mensaje" => "Área agregada."] : ["Tipo" => 'error', "Mensaje" => "No se pudo agregar."];
            }

            session()->setFlashdata('AlertShowN', $mensaje);
            return redirect()->to(base_url('/Areas'));
        }
        return redirect()->back()->withInput()->with('validation', $validation);
    }

    public function toggleEstado($idarea)
    {
        $success = $this->modArea->toggleEstadoArea($idarea);
        return $this->response->setJSON([
            'Status' => $success ? '200' : '400',
            'Mensaje' => $success ? 'Estado cambiado' : 'Error al cambiar el estado'
        ]);
    }

    public function eliminar($idarea)
    {
        $response = $this->modArea->delete($idarea);
        $mensaje = $response ? ["Tipo" => 'success', "Mensaje" => "Área eliminada."] : ["Tipo" => 'error', "Mensaje" => "Error al eliminar el área."];
        
        session()->setFlashdata('AlertShowN', $mensaje);
        return redirect()->to('/Areas');
    }

    public function listarareas()
    {
        $response = $this->modArea->selectareas();
        return $this->response->setJSON($response);
    } 
}
