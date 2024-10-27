<?php

namespace App\Controllers;
use App\Models\ActRegistrarModel;
use CodeIgniter\Controller;

class Act_Registrar extends Controller
{
    public function __construct(){
        $this->modRegistrar = new ActRegistrarModel();
    }
    public function index()
    {
        $listarRegistrar = $this->modRegistrar->getregistrar();
        $scripts = [
            'scripts' => ['js/act_registrar.js?v=7.1.6', 'js/alertas.js?v=7.1.6']
        ];
        $this->viewData("act_registro/registrar", ["Act_Registrar" => $listarRegistrar], $scripts);
    }

    

    public function guardar()
{
    $validation = \Config\Services::validation();
    $postData = $this->request->getPost();
    $isUpdating = isset($postData['idregistro']) && !empty($postData['idregistro']); // Verificamos si estamos actualizando

    $validationRules = [
        'numero' => 'permit_empty',
        //'nro_carta' => 'permit_empty',
        //'fec_atencion' => 'permit_empty|valid_date',
        'detalle_actividad' => 'permit_empty',
        'id_dependencia' => 'permit_empty|is_not_unique[act_dependencia.id_dependencia]', // Validar si el ID existe en la tabla dependencias
        'id_solicitante' => 'permit_empty|is_not_unique[act_solicitante.id_solicitante]',
        'idmedio_solicitud' => 'permit_empty|is_not_unique[act_medio_solicitud.idmedio_solicitud]',
        'id_tipo_asistencia' => 'permit_empty|is_not_unique[act_tipo_asistencia.id_tipo_asistencia]',
        'idcategoria_actividad' => 'permit_empty|is_not_unique[act_categoria_actividad.idcategoria_actividad]',
        
        'id_periodo' => 'permit_empty|is_not_unique[act_periodo.id_periodo]',
        'id_usuario' => 'permit_empty|is_not_unique[usuario.id_usuario]', // El usuario puede ser opcional
    ];

    $validation->setRules($validationRules);

    if ($validation->withRequest($this->request)->run()) {
        // Obtener el valor del estado y hacer el explode
        $valorestado = $postData['tipo_estado']; // Supongo que id_estado es el valor a usar
        $valorestado = explode('_', $valorestado);

        // Preparar los datos para el registro o actualización
        $data = [
            'numero' => $postData['numero'],
            //'nro_carta' => $postData['nro_carta'],
            //'fec_atencion' => $postData['fec_atencion'],
            'detalle_actividad' => $postData['detalle_actividad'],
            'observacion' => $postData['observacion'],
            'tipo_doc' => $postData['tipo_doc'],
            'id_dependencia' => $postData['id_dependencia'],
            'id_solicitante' => $postData['id_solicitante'],
            'idmedio_solicitud' => $postData['idmedio_solicitud'],
            'id_tipo_asistencia' => $postData['id_tipo_asistencia'],
            'idcategoria_actividad' => $postData['idcategoria_actividad'],
            'tipo_estado' => $valorestado[0], // Si solo deseas el primer valor del explode
            'id_periodo' => $postData['id_periodo'],
            'id_usuario' => isset($postData['id_usuario']) ? $postData['id_usuario'] : null,
        ];

        if ($isUpdating) {
            // Actualizar registro existente
            $response = $this->modRegistrar->update($postData['idregistro'], $data);
            $mensaje = $response
                ? ["Tipo" => 'success', "Mensaje" => "Actualización exitosa."]
                : ["Tipo" => 'error', "Mensaje" => "No se pudo actualizar el registro."];
        } else {
            // Insertar nuevo registro
            $response = $this->modRegistrar->insert($data);
            $mensaje = $response
                ? ["Tipo" => 'success', "Mensaje" => "Registro exitoso."]
                : ["Tipo" => 'error', "Mensaje" => "No se pudo registrar la actividad."];
        }

        session()->setFlashdata('AlertShowN', $mensaje);
    } else {
        // Manejo de errores de validación
        $errors = $validation->getErrors();
        session()->setFlashdata('AlertShowCode', $errors);
    }

    return redirect()->to(base_url() . "/Act_Registrar");
}

// Método para registrar una nueva actividad
public function registrar($data)
{
    // Verificar si ya existe un registro con el mismo número de actividad
    if ($this->modRegistrar->valid_registro(null, $data['numero'])) {
        return false; // Si ya existe, retornar false
    }

    // Insertar nuevo registro
    $guardar = $this->modRegistrar->insert($data);
    return $guardar ? true : false;
}

// Método para actualizar un registro existente o crear uno nuevo
public function actualizar($data, $id = null)
{
    // Verificar si estamos actualizando o creando
    $isUpdating = !empty($id); // Si $id existe, es una actualización

    if ($isUpdating) {
        // Actualizar actividad existente
        $response = $this->modRegistrar->update($id, $data);
    } else {
        // Registrar nueva actividad
        $response = $this->modRegistrar->insert($data);
    }

    return $response;
}

// Método para eliminar (desactivar) una actividad
public function eliminar($id)
{
    if (!empty($id)) {
        // Cambiar el estado del registro a '0' para marcarlo como eliminado
        $guardar = $this->modRegistrar->update($id, ['id_estado' => '0']); // '0' indica inactivo o eliminado

        // Verificar si la eliminación (desactivación) fue exitosa y preparar el mensaje de respuesta
        $mensaje = $guardar
            ? ["Tipo" => 'success', "Mensaje" => "Registro eliminado correctamente."]
            : ["Tipo" => 'error', "Mensaje" => "No se pudo eliminar el registro."];
    } else {
        // Si el ID no es válido, enviar mensaje de error
        $mensaje = ["Tipo" => 'error', "Mensaje" => "ID de registro no válido."];
    }

    // Almacenar el mensaje en la sesión para mostrarlo en la siguiente vista
    session()->setFlashdata('AlertShowN', $mensaje);

    // Redirigir al listado de registros
    return redirect()->to(base_url() . "/Act_registrar");
}



}