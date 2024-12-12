<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\ActAreasModel;
use CodeIgniter\API\ResponseTrait;

class User extends Controller

	 use ResponseTrait;
{
    protected $modUser;
    protected $modArea;
    public function __construct()
    {
        $this->modUser = new UserModel();
        $this->modArea = new ActAreasModel();
    }
	
	    public function listar()
    {
        $draw = (int) $this->request->getVar('draw', FILTER_VALIDATE_INT) ?? 0;
        $length = (int) $this->request->getVar('length', FILTER_VALIDATE_INT) ?? 10;
        $start = (int) $this->request->getVar('start', FILTER_VALIDATE_INT) ?? 0;

        $order = $this->parseOrder(
            $this->request->getVar('order') ?? []
        );

        $search = $this->request->getVar('search')['value'] ?? '';
		
        $page = $this->calculatePage($start, $length);

        $query = $this->modUser
            ->table('usuario')
            ->select('usuario.*, perfil.nombreperfil')
            ->join('perfil', 'usuario.idperfil_usuario = perfil.id_perfil')
            ->where('usuario.estado', '1')
            ->orderBy($this->getColumn($order['column']), $order['dir']);


        if (!empty($search)) {
            $query->groupStart();
            foreach (['usuario.nombre', 'usuario.apellido', 'usuario.usuario', 'perfil.nombreperfil'] as $column) {
                $query->orLike($column, $search);
            }
            $query->groupEnd();
        }

        $data = $query->paginate($length, 'gp1', $page);

        $response = [
            'draw' => $draw,
            'recordsTotal' => null,
            'recordsFiltered' => $this->modUser->pager->getTotal('gp1'),
            'data' => $data
        ];

        return $this->respond($response);
    }

    private function parseOrder(array $order): array
    {
        if (!empty($order) && isset($order[0])) {
            return [
                'column' => $order[0]['column'] ?? 0,
                'dir' => $order[0]['dir'] ?? 'asc'
            ];
        }

        return ['column' => 0, 'dir' => 'asc'];
    }

    private function calculatePage(int $start, int $length): int
    {
        return max(1, (int) ceil(($start + 1) / $length));
    }

    private function getColumn(int $index): string
    {
        $columns = ['id_usuario', 'nombre', 'apellido', 'usuario', 'dni', 'telefono', 'idperfil_usuario'];
        return $columns[$index] ?? $columns[0];
    }

    public function index()
    {
        $listUsers = $this->modUser->getUsuarios();
        $listPerfil = $this->modUser->get_perfiles();
		$serverDatable  = true;
        $scripts = [
            'scripts' => ['plugins/custom/datatables/dtserverUser.js?v=7.1.6', 'js/form_consulta.js?v=7.1.6', 'js/form_user.js?v=7.1.6', 'plugins/custom/qrcode/jquery.classyqr.js?v=7.1.6'],
        ];
        $this->viewData('modulos/userview', ['Usuarios' => $listUsers, 'Perfiles' => $listPerfil], $scripts);
    }

    public function formData()
    {
        $validation = \Config\Services::validation();
        $postData = $this->request->getPost();
        $isUpdating = isset($postData['id_item']) && !empty($postData['id_item']);

        $validationRules = [
            'dni' => 'required|integer',
            'nombre' => 'required',
            'apellidos' => 'required',
            'perfil' => 'required|integer|is_not_unique[perfil.id_perfil]',
            'usuario' => 'required|alpha_numeric_space',
            'clave' => [
                'label' => 'Clave',
                'rules' => $isUpdating ? 'permit_empty|min_length[6]' : 'required|min_length[6]',
                'errors' => [
                    'min_length' => 'La {field} debe contener m��nimo 6 caracteres.',
                    'required' => 'La {field} es obligatoria.',
                ],
            ],
            'celular' => 'permit_empty',
            'direccion' => 'permit_empty',
            'correo' => 'permit_empty|valid_email',
        ];

        $validation->setRules($validationRules);

        if ($validation->withRequest($this->request)->run()) {
            $encriptarClave = '';
            if (!empty($postData['clave'])) {
                $encriptarClave = crypt($_POST['clave'], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
            }

            $data = [
                'nombre' => $postData['nombre'],
                'apellido' => $postData['apellidos'],
                'usuario' => $postData['usuario'],
                'dni' => $postData['dni'],
                'telefono' => $postData['celular'],
                'correo' => $postData['correo'],
                'direccion' => $postData['direccion'],
                'idperfil_usuario' => $postData['perfil'],
                'id_area' => $postData['nombre_area'],
            ];
            if ($isUpdating) {
                // ACTUALIZAR
                if (!empty($postData['clave'])) {
                    $data['clave'] = $encriptarClave;
                }

                $response = $this->actualizar($data, $postData['id_item']);
                $mensaje = $response
                    ? ["Tipo" => 'success', "Mensaje" => "Actualización Exitosa."]
                    : ["Tipo" => 'error', "Mensaje" => "No se pudo actualizar."];
            } else {
                // REGISTER
                $data['clave'] = $encriptarClave;
                $data['fecha_clave'] = date('Y-m-d H:i:s'); // Replace with your preferred date format

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

        return redirect()->to(base_url() . "/user");
    }





    public function formDataDeprecated()
    {
        $validation =  \Config\Services::validation();
        if (isset($_POST['id_item']) && !empty($_POST['id_item'])) {
            // ACTUALIZAR
            $validation->setRules([
                'id_item' => 'required|integer',
                'dni' => 'required|integer',
                'nombre' => 'required',
                'apellidos' => 'required',
                'perfil' => 'required|integer|is_not_unique[perfil.id_perfil]',
                'usuario' => 'required|alpha_numeric_space',
                'clave' => ['label' => 'Clave', 'rules' => 'permit_empty|min_length[6]', 'errors' => [
                    'min_length' => 'La {field} debe contener minimo 6 caracteres.',
                ]],
                // 'clave' => 'permit_empty',
                'celular' => 'permit_empty',
                'direccion' => 'permit_empty',
                'correo' => 'permit_empty|valid_email'
            ]);
            $validation->withRequest($this->request)->run();
            if (!$validation->getErrors()) {
                if (empty($_POST['clave'])) {
                    $data = [
                        'nombre' => $_POST['nombre'],
                        'apellido' => $_POST['apellidos'],
                        'usuario' => $_POST['usuario'],
                        'dni' => $_POST['dni'],
                        'telefono' => $_POST['celular'],
                        'correo' => $_POST['correo'],
                        'direccion' => $_POST['direccion'],
                        'idperfil_usuario' => $_POST['perfil']
                    ];
                } else {
                    $encriptarClave = crypt($_POST["clave"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
                    $data = [
                        'nombre' => $_POST['nombre'],
                        'apellido' => $_POST['apellidos'],
                        'usuario' => $_POST['usuario'],
                        'clave' => $encriptarClave,
                        'dni' => $_POST['dni'],
                        'telefono' => $_POST['celular'],
                        'correo' => $_POST['correo'],
                        'direccion' => $_POST['direccion'],
                        'idperfil_usuario' => $_POST['perfil']
                    ];
                }

                $response = $this->actualizar($data, $_POST['id_item']);
                $mensaje = $response ? ["Tipo" => 'success', "Mensaje" => "Actualización Exitosa."] : ["Tipo" => 'error', "Mensaje" => "No se pudo actualizar."];
                session()->setFlashdata('AlertShow', $mensaje);
            } else {
                $errors = $validation->getErrors();
                session()->setFlashdata('AlertShowCode', $errors);
            }
            return redirect()->to(base_url() . "/user");
        } else {
            // REGISTER
            $validation->setRules([
                'id_item' => 'permit_empty|integer',
                'dni' => 'required|integer',
                'nombre' => 'required',
                'apellidos' => 'required',
                'perfil' => 'required|integer|is_not_unique[perfil.id_perfil]',
                'usuario' => 'required|alpha_numeric_space',
                'clave' => ['label' => 'Clave', 'rules' => 'required|min_length[6]', 'errors' => [
                    'min_length' => 'La {field} debe contener minimo 6 caracteres.',
                    'required' => 'La {field} es obligatoria.'
                ]],
                // 'clave' => 'required',
                'celular' => 'permit_empty|integer',
                'direccion' => 'permit_empty',
                'correo' => 'permit_empty|valid_email'
            ]);
            $validation->withRequest($this->request)->run();
            if (!$validation->getErrors()) {
                $encriptarClave = crypt($_POST["clave"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
                $data = [
                    'nombre' => $_POST['nombre'],
                    'apellido' => $_POST['apellidos'],
                    'usuario' => $_POST['usuario'],
                    'clave' => $encriptarClave,
                    'dni' => $_POST['dni'],
                    'telefono' => $_POST['celular'],
                    'correo' => $_POST['correo'],
                    'direccion' => $_POST['direccion'],
                    'idperfil_usuario' => $_POST['perfil'],
                    'fecha_clave' => $this->getDate()
                ];
                $response = $this->registrar($data);
                $mensaje = $response ? ["Tipo" => 'success', "Mensaje" => "Registro Exitoso."] : ["Tipo" => 'error', "Mensaje" => "No se pudo registar."];
                session()->setFlashdata('AlertShow', $mensaje);
            } else {
                $errors = $validation->getErrors();
                session()->setFlashdata('AlertShowCode', $errors);
            }
            return redirect()->to(base_url() . "/user");
        }
    }

    public function registrar($data)
    {
        if ($this->modUser->valid_usuario(null, $data['usuario'])) {
            return false;
        }
        $guardar = $this->modUser->insert($data);
        $response = $guardar ? true : false;
        return $response;
    }

    public function actualizar($data, $id)
    {
        if ($this->modUser->valid_usuario($id, $data['usuario'])) {
            return false;
        }
        $guardar = $this->modUser->update($id, $data);
        $response = $guardar ? true : false;
        return $response;
    }

    public function listar_user()
    {
        if ($this->request->isAjax()) {
            $id = $this->request->getVar('item_user');
            $response = $this->modUser->getUsuario($id);
            $mensaje = $response ? ["Status" => '200', "Mensaje" => $response[0]] : ["Status" => '404', "Mensaje" => "Petición no completada"];
            return json_encode($mensaje);
        } else {
            return redirect()->to(base_url() . "/user");
        }
    }

    public function eliminar($id)
    {
        $guardar = $this->modUser->update($id, ['estado' => '0']);
        $mensaje = $guardar ? ["Tipo" => 'success', "Mensaje" => "Eliminado Correctamente."] : ["Tipo" => 'error', "Mensaje" => "No se pudo eliminar."];
        session()->setFlashdata('AlertShow', $mensaje);
        return redirect()->to(base_url() . "/user");
    }

  
}
