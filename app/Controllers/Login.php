<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Controllers\User;

class Login extends Controller{
    public function __construct(){
        $this->modUser = new UserModel();
        $this->encriptar = '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$';
        $this->conUser = new User();
    }

    public function index(){
        if( !session()->get( 'id_user' ) ){
            return view('login');
        }
        else{
            return redirect()->to(base_url()."/");
        }
    }
    
    
    public function login() {
        if ($this->request->isAjax()) {
            $user = $this->request->getVar('user');
            $clave = $this->request->getVar('clave');
            $encriptarClave = crypt($clave, $this->encriptar);
            $valid = $this->modUser->session_valid($user, $encriptarClave);
            $user_exists = $this->modUser->user_exists($user);
            
        if ($user_exists) {
            if ($valid) {
                $fecha_hoy = $this->getDate();
                $fecha_clave = date($valid[0]['fecha_clave']);
                $estado_clave = $valid[0]['estado_clave'];
                $dni_encrip = crypt($valid[0]['dni'], $this->encriptar);
    
                //$modulos = $this->modUser->get_mod($valid[0]['idperfil_usuario']);
                $modulos = $this->modUser->get_mod($valid[0]['idperfil_usuario'], $valid[0]['id_usuario']);
                $data = [
                    'id_user' => $valid[0]['id_usuario'],
                    'perfil' => $valid[0]['nombreperfil'],
                    'idperfil' => $valid[0]['id_perfil'],
                    'nombres' => $valid[0]['nombre'],
                    'Modulos' => $modulos,
                    'user_dni' => $valid[0]['dni'],
                    'estado_clave' => $estado_clave,
                    'usuario_user' => $valid[0]['usuario']
                ];
    
                $session = session();
                $session->set($data);
                return json_encode(true);
            } else {
                session()->setFlashdata('Error', 'Contrase«Ğa incorrecta, intente de nuevo');
                return json_encode(false);
            }
        } else {
            session()->setFlashdata('Error', 'Usuario no encontrado');
            return json_encode(false);
        }
    } else {
        return redirect()->to(base_url() . "/login");
    }
}
    public function logout(){
        $session = session();
        $session->destroy();
        return redirect()->to(base_url()."/login");
    }
    public function update_password(){
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'password_new' => [
                'label'  => 'Clave',
                'rules'  => 'required|min_length[6]',
                'errors' => [
                    'min_length' => 'La {field} debe contener al menos 6 caracteres',
            ]],
            'password_confirm' => 'required|matches[password_new]'
        ]);
        $validation->withRequest($this->request)->run();
        if (!$validation->getErrors()){
            $usuario = session()->get( 'usuario_user' );
            $encriptarNueva = crypt($_POST['password_new'], $this->encriptar);
                $id = session()->get( 'id_user' );
                $fech_update = date("Y-m-d",strtotime($this->getDate()." + ".(3)." month"));
                $data = [
                            'clave' => $encriptarNueva,
                            'estado_clave' => '1',
                            'fecha_clave' => $fech_update,
                            'usuario' => $usuario
                ];
                $response = $this->conUser->actualizar($data, $id);
                if ($response) {
                    $this->logout();
                }else{
                    $mensaje = ["Tipo" => 'error',"Mensaje" => "Error al cambiar la contraseÃ±a."];
                    session()->setFlashdata('AlertShow', $mensaje);
                }
        }else{
            $errors = $validation->getErrors();
            session()->setFlashdata('AlertShowCode', $errors);
        }
        return redirect()->to(base_url()."/");
    }
}

