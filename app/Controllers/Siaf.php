<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\SiafModel;
use App\Models\SiafDataModel;
use App\Models\UserModel;

class Siaf extends Controller
{

    public function __construct(){
        $this->modSiaf = new SiafModel();
        $this->modSiafData = new SiafDataModel();
        $this->modUser = new UserModel();
    }

    public function index()
    {
        $listaDataSiaf = $this->modSiaf->getDataSiaf();
        $listaTipoGiro = $this->modSiaf->getTipoGiro();
        $scripts = ['scripts' => ['js/siaf.js?v=7.2.6']];
        $this->viewData("siaf/registrosiaf", ["DataSiaf" => $listaDataSiaf, "TipoGiro" => $listaTipoGiro], $scripts);
    } 

  public function registrosgiro()
    {
        $listaDataSiaf = $this->modSiafData->getDataporGirarSiaf();
        $scripts = ['scripts' => ['js/siafgiro.js?v=7.2.6']];
        $this->viewData("siaf/registrosgiro", ["DataSiaf" => $listaDataSiaf], $scripts);
    } 

     public function datasiaf()
    {
        if ($this->request->isAjax()) {
            $expediente = $this->request->getVar('expediente');
            $expediente = str_pad($expediente, 10, '0', STR_PAD_LEFT);
            $data = $this->modSiafData->getDataSiaf($expediente);
            echo json_encode($data); exit();
        } else{
            return redirect()->to(base_url()."/siaf");
        }
    }

        public function getComprobanteCorrelativo(){
        if($this->request->isAjax()) {
            // $id = $this->request->getVar('id');
            $respuesta = $this->modSiaf->getComprobanteCorrelativo();
            // $articulo = $this->modArticulo->getarticulo($id);
            echo json_encode($respuesta); exit();
        }else{
            return redirect()->to(base_url()."/siaf");
        }
    }

    public function formData() {
    $validation = \Config\Services::validation();
    $postData = $this->request->getPost();
    $isUpdating = isset($postData['id']) && !empty($postData['id']);

    $validationRules = [
        'comprobante_pago' => 'permit_empty',
        'expediente' => 'permit_empty',
        'tipo_giro' => 'permit_empty',
        'nombres' => 'permit_empty',
        'partida_especifica' => 'permit_empty',
        'monto' => 'permit_empty|required|numeric|decimal',
        'fecha_pase' => 'permit_empty',
        'orden_compra' => 'permit_empty',
        'orden_servicio' => 'permit_empty',        
        'planilla_viatico' => 'permit_empty',
        'recibo_honorarios' => 'permit_empty',
        'observacion' => 'permit_empty',
    ];

    $validation->setRules($validationRules);

    if ($validation->withRequest($this->request)->run()) {

        $data = [
            'expediente' => $postData['expediente'],
            'tipo_giro' => $postData['tipo_giro'],
            'nombres' => $postData['nombres'],
            'partida_especifica' => $postData['partida_especifica'],
            'monto' => $postData['monto'],
            'fecha_pase' => $postData['fecha_pase'],
            'orden_compra' => $postData['orden_compra'],
            'orden_servicio' => $postData['orden_servicio'],
            'planilla_viatico' => $postData['planilla_viatico'],
            'recibo_honorarios' => $postData['recibo_honorarios'],
            'exp_sgd' => $postData['exp_sgd'],
            'asunto_sgd' => $postData['asunto_sgd'],
        ];

        if (!$isUpdating) {
            $data['comprobante_pago'] = $postData['numero_comprobante'];
        }

        if ($isUpdating) {
            $response = $this->actualizar($data, $postData['id']);
            $mensaje = $response
                ? ["Tipo" => 'success', "Mensaje" => "Actualizacion Exitosa."]
                : ["Tipo" => 'error', "Mensaje" => "No se pudo actualizar."];
        } else {
            $response = $this->registrar($data);
            $this->modSiaf->incrementarComprobanteCorrelativo();

            $mensaje = $response
                ? ["Tipo" => 'success', "Mensaje" => "Registro Exitoso."]
                : ["Tipo" => 'error', "Mensaje" => "No se pudo registrar."];
        }
        session()->setFlashdata('AlertShow', $mensaje);
    } else {
        $errors = $validation->getErrors();
        session()->setFlashdata('AlertShowCode', $errors);
    }
    return redirect()->to(base_url() . "/siaf");
}

    public function registrar($data){
        // if ($this->modUser->valid_usuario(null, $data['id'])) {
        //     return false;
        // }
        return $this->modSiaf->insert($data);
    }

    public function actualizar($data, $id){
        // if ($this->modUser->valid_usuario($id, $data['id'])) {
        //     return false;
        // }
        return $this->modSiaf->update($id, $data);
    }

    public function editar(){
        if($this->request->isAjax()) {
            $id = $this->request->getVar('id');
            $response = $this->modSiaf->getRegistro($id);
            $mensaje = $response?["Status" => '200', "Mensaje" => $response[0]]:["Status" => '404',"Mensaje" => "Petici????n no completada"];
            return json_encode($mensaje);
        }else{
            return redirect()->to(base_url()."/siaf");
        }
    }
}
