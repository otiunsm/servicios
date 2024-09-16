<?php
// namespace App\Libraries;
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\PerfilesModel;

class Perfiles extends Controller{
    
	public function __construct(){
        $this->modPerfil = new PerfilesModel();
    }
	
    public function index(){
        $listPerfil = $this->modPerfil->getPerfiles();
        $Modulos = $this->modPerfil->getModulos();
        $Permisos = $this->modPerfil->getPermisos();
          $scripts = [
            'scripts'=>['js/form_user.js?v=7.1.6'],
        ];
        $this->viewData('modulos/perfil', ['Perfiles' => $listPerfil, 'Modulos' => $Modulos, 'Permisos' => $Permisos], $scripts);
    }

    public function formData(){
		$validation =  \Config\Services::validation();
		if (isset($_POST['id_item']) && !empty($_POST['id_item'])) {
			# ACTUALIZAR
            $validation->setRules([
                'id_item' => 'required|integer',
                'nomPerfil' => 'required|alpha_space',
				'idmodulo_hijo' => 'required'
            ]);
            $validation->withRequest($this->request)->run();
			if (!$validation->getErrors()) {
                $data = [
					'nombreperfil' => $_POST['nomPerfil']
				];
                $Permisos = $_POST['idmodulo_hijo'];
				$response = $this->actualizar($data, $Permisos, $_POST['id_item']);
				$mensaje = $response?["Tipo" => 'success',"Mensaje" => "Actualización Exitosa."]:["Tipo" => 'error',"Mensaje" => "No se pudo actualizar."];
				session()->setFlashdata('AlertShow', $mensaje);
			}else {
				$errors = $validation->getErrors();
                session()->setFlashdata('AlertShowCode', $errors);
			}
			return redirect()->to(base_url()."/perfiles");
		}else {
			# REGISTRAR
            $validation->setRules([
                'id_item' => 'permit_empty|integer',
                'nomPerfil' => 'required|alpha_space|is_unique[perfil.nombreperfil]',
				'idmodulo_hijo' => 'required'
            ]);
            $validation->withRequest($this->request)->run();
			if (!$validation->getErrors()) {
                $data = [
					'nombreperfil' => $_POST['nomPerfil']
				];
                $Permisos = $_POST['idmodulo_hijo'];
				$response = $this->registrar($data, $Permisos);
				$mensaje = $response?["Tipo" => 'success',"Mensaje" => "Registro Exitoso."]:["Tipo" => 'error',"Mensaje" => "No se pudo registrar."];
				session()->setFlashdata('AlertShow', $mensaje);
			}else {
				$errors = $validation->getErrors();
                session()->setFlashdata('AlertShowCode', $errors);
			}
			return redirect()->to(base_url()."/perfiles");
		}

    }

    public function registrar($data, $Permisos){
        $guardar = $this->modPerfil->insert($data);
        foreach ($Permisos as $key => $p) {
            $savePer = $this->modPerfil->postPermisos(['idperfilpermiso'=>$guardar, 'idmodulo'=>$p]);
        }
        $response = $guardar && $savePer?true:false;
        return $response;
    }

    public function actualizar($data, $Permisos, $id){
        $guardar = $this->modPerfil->update($id, $data);
        $deleted = $this->modPerfil->delete_up_per($id);
        foreach ($Permisos as $key => $p) {
            $savePer = $this->modPerfil->postPermisos(['idperfilpermiso'=>$id, 'idmodulo'=>$p]);
        }
        $response = $guardar && $savePer?true:false;
        return $response;
    }

    public function listar_perfil(){
		if($this->request->isAjax()) {
			$id = $this->request->getVar('id');
			$perfil = $this->modPerfil->getPerfil($id);
			if ($perfil) {
				$permisos = $this->modPerfil->getPermiso($id);
				return json_encode(array($perfil[0], $permisos), true);
			}else{
				session()->setFlashdata('dataFlash', ['Message' => 'Petición denegada', 'Type' => 'danger']);
				return redirect()->to(base_url().'/perfiles');
			}
		}else{
			return redirect()->to(base_url().'/perfiles');
		}
    }

    public function eliminar($id){
        if ($id != 1) {
            $guardar = $this->modPerfil->update($id, ['estadoperfil' => '0']);
            $deleted = $this->modPerfil->delete_up_per($id);
            $mensaje = $guardar?["Tipo" => 'success',"Mensaje" => "Eliminado Correctamente."]:["Tipo" => 'error',"Mensaje" => "No se pudo eliminar."];
        }else{
            $mensaje = ["Tipo" => 'error',"Mensaje" => "No se pudo eliminar."];
        }
        session()->setFlashdata('AlertShow', $mensaje);
        return redirect()->to(base_url()."/perfiles");
    }
}
