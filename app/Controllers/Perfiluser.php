<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Controllers\User;
class Perfiluser extends Controller{

    public function __construct(){
        $this->modUser = new UserModel();
        $this->contuser = new User();
    }

    public function index(){
        $id = session()->get('id_user');
        $data = $this->modUser->getUsuario($id);
          $scripts = [
            'scripts'=>['js/form_user.js?v=7.1.6'],
        ];
        return $this->ViewData('modulos/perfiluser', ['DataPerfil'=>$data[0]], $scripts);
    }

    public function formdata(){
        $id = session()->get('id_user');
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'nombre_user' => 'required',
            'apellidos_user' => 'required',
            //'apellidos_user' => 'required|alpha_space',
            'usuario_user' => 'required|alpha_numeric_space',
             'clave_user' => ['label' => 'Clave', 'rules' => 'permit_empty|min_length[6]', 'errors' => [
                'min_length' => 'La {field} debe contener minimo 6 caracteres.',
            ]],
            // 'clave_user' => 'permit_empty|min_length[6]',
            'celular_user' => 'permit_empty|integer',
            'direccion_user' => 'permit_empty',
            'correo_user' => 'permit_empty|valid_email'
        ]);
        $validation->withRequest($this->request)->run();
        if (!$validation->getErrors()) {
            if (empty($_POST['clave_user'])) {
                $data = [
                    'nombre' => $_POST['nombre_user'],
                    'apellido' => $_POST['apellidos_user'],
                    'usuario' => $_POST['usuario_user'],
                    'telefono' => $_POST['celular_user'],
                    'correo' => $_POST['correo_user'],
                    'direccion' => $_POST['direccion_user'],
                ];
            }else {
                $encriptarClave = crypt($_POST["clave_user"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
                $data = [
                    'nombre' => $_POST['nombre_user'],
                    'apellido' => $_POST['apellidos_user'],
                    'usuario' => $_POST['usuario_user'],
                    'clave' => $encriptarClave,
                    'telefono' => $_POST['celular_user'],
                    'correo' => $_POST['correo_user'],
                    'direccion' => $_POST['direccion_user'],
                ];
            }

            $response = $this->contuser->actualizar($data, $id);
            $mensaje = $response?["Tipo" => 'success',"Mensaje" => "Actualización Exitosa."]:["Tipo" => 'error',"Mensaje" => "No se pudo actualizar."];
            session()->setFlashdata('AlertShow', $mensaje);
        }else{
            $errors = $validation->getErrors();
            session()->setFlashdata('AlertShowCode', $errors);
        }
        return redirect()->to(base_url()."/perfiluser");
    }
}
