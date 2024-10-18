<?php

namespace App\Controllers;
use App\Models\ActAreasModel;
use CodeIgniter\Controller;

class Areas extends Controller
{
     public function __construct(){
       // $this->modSiaf = new ActreportesModel();
      //  $this->modSiafData = new ActreportesModel();
      $this->modArea = new ActAreasModel();
    }

    public function index()
    {
        $listarArea = $this->modArea->getareas();
        $scripts = [
            'scripts'=>['js/area.js?v=7.1.6','js/msj.js?v=7.1.6'],
        ];
        $this->viewData("act_registro/areas", ["Areas" => $listarArea], $scripts); 
    }

    public function listar_area()
{
    if ($this->request->isAjax()) {
        $id = $this->request->getVar('item_area');  // Capturamos el ID del área
        $response = $this->modArea->getarea($id);   // Cambiamos a getarea($id)

        // Verificamos si se encontraron los datos
        $mensaje = $response 
            ? ["Status" => '200', "Mensaje" => $response] 
            : ["Status" => '404', "Mensaje" => "Área no encontrada"];
        
        return $this->response->setJSON($mensaje);
    } else {
        return redirect()->to(base_url()."/Areas");
    }
}
  

    public function guardar()
{
    $validation = \Config\Services::validation();
    $postData = $this->request->getPost();
    $isUpdating = isset($postData['idarea']) && !empty($postData['idarea']); // Verificamos si estamos actualizando


    $valorestado = $this->request->getPost('tipo_estado');
    $valorestado = explode('_', $valorestado); 

    $validationRules = [
        'nombre_area' => 'required',
        'descripcion' => 'permit_empty',
        'tipo_estado' => 'required',
    ];

    $validation->setRules($validationRules);

    if ($validation->withRequest($this->request)->run()) {
        // Datos preparados para registro/actualización
        $data = [
            'nombre_area' => $postData['nombre_area'],
            'descripcion' => $postData['descripcion'],
            'descripcion' => $postData['descripcion'],
            'tipo_estado' => $valorestado[0],
        ];

        if ($isUpdating) {
            // Actualizar área
            $response = $this->actualizar($data, $postData['idarea']);
            $mensaje = $response
                ? ["Tipo" => 'success', "Mensaje" => "Actualización exitosa del área."]
                : ["Tipo" => 'error', "Mensaje" => "No se pudo actualizar el área."];
        } else {
            // Registrar nueva área
            $response = $this->registrar($data);
            $mensaje = $response
                ? ["Tipo" => 'success', "Mensaje" => "Registro exitoso del área."]
                : ["Tipo" => 'error', "Mensaje" => "No se pudo registrar el área."];
        }

        session()->setFlashdata('AlertShow', $mensaje);
    } else {
        $errors = $validation->getErrors();
        session()->setFlashdata('AlertShowCode', $errors);
    }

    return redirect()->to(base_url() . "/Areas");
}


public function registrar($data)
{
    if ($this->modArea->valid_area(null, $data['nombre_area'])) {
        return false; // Si el área ya existe, retornar false
    }

    $guardar = $this->modArea->insert($data); // Insertar nueva área
    return $guardar ? true : false;
}


public function actualizar($data, $id = null)
{
    // Check if we are updating or creating
    $isUpdating = !empty($id); // If $id exists, it's an update

    if ($isUpdating) {
        // Update area
        $response = $this->modArea->update($id, $data);
    } else {
        // Register new area
        $response = $this->modArea->insert($data);
    }

    return $response;
}


public function eliminar($id){
    if (!empty($id)) {
        // Cambiar el estado del área a '0' para marcarlo como eliminado
        $guardar = $this->modArea->update($id, ['estado_area' => '0']);
        
        // Verificar si la eliminación (desactivación) fue exitosa y preparar el mensaje de respuesta
        $mensaje = $guardar ? ["Tipo" => 'success', "Mensaje" => "Área eliminada correctamente."] : ["Tipo" => 'error', "Mensaje" => "No se pudo eliminar el área."];
    } else {
        // Si el ID no es válido, enviar mensaje de error
        $mensaje = ["Tipo" => 'error', "Mensaje" => "ID de área no válido."];
    }
    
    // Almacenar el mensaje en la sesión para mostrarlo en la siguiente vista
    session()->setFlashdata('AlertShow', $mensaje);
    
    // Redirigir al listado de áreas
    return redirect()->to(base_url()."/Areas");
}



    


}


//nuevo archivo
   


