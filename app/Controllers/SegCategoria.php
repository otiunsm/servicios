<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\SegCategoriaModel;

class SegCategoria extends Controller
{
    protected $categoriaModel;

    public function __construct()
    {
        $this->categoriaModel = new SegCategoriaModel();
    }

    public function index()
    {
        $listaCategorias = $this->categoriaModel->obtenerCategoriasActivas();
        $serverDatable  = true;
        $scripts = ['scripts' => ['js/seg_categorias.js?v=7.1.6', 'plugins/custom/datatables/seg_dtserver_categoria.js?v=7.1.6']];
        $this->viewData("/seguimiento/categoria_presupuestal", ["categorias" => $listaCategorias, 'serverDatable' => $serverDatable], $scripts);
  
    }

    public function formData()
    {
        $validation = \Config\Services::validation();
        $postData = $this->request->getPost();
        $isUpdating = isset($postData['id_categoria']) && !empty($postData['id_categoria']);

        $validationRules = [
            'codigo_categoria' => 'required|is_unique[categorias.codigo_categoria,id_categoria,{id_categoria}]',
            'nombre_categoria' => 'required',
            'descripcion' => 'permit_empty'
        ];

        $validation->setRules($validationRules);

        if ($validation->withRequest($this->request)->run()) {
            $data = [
                'codigo_categoria' => $postData['codigo_categoria'],
                'nombre_categoria' => $postData['nombre_categoria'],
                'descripcion' => isset($postData['descripcion']) ? $postData['descripcion'] : null,
                'estado' => 1
            ];

            if ($isUpdating) {
                $response = $this->actualizar($data, $postData['id_categoria']);
                $mensaje = $response ? ["Tipo" => 'success', "Mensaje" => "Actualización Exitosa."]
                                      : ["Tipo" => 'error', "Mensaje" => "No se pudo actualizar."];
            } else {
                $response = $this->registrar($data);
                $mensaje = $response ? ["Tipo" => 'success', "Mensaje" => "Registro Exitoso."]
                                      : ["Tipo" => 'error', "Mensaje" => "No se pudo registrar."];
            }

            session()->setFlashdata('AlertShow', $mensaje);
        } else {
            $errors = $validation->getErrors();
            session()->setFlashdata('AlertShowCode', $errors);
        }

        return redirect()->to(base_url() . "/SegCategoria");
    }

    public function registrar($data)
    {
        return $this->categoriaModel->crearCategoria($data);
    }

    public function actualizar($data, $id)
    {
        return $this->categoriaModel->actualizarCategoria($id, $data);
    }

    public function eliminar($id)
    {
        if ($this->categoriaModel->eliminarCategoria($id)) {
            return $this->response->setJSON(['Status' => '200', 'Mensaje' => 'Categoria eliminado correctamente.']);
        } else {
            return $this->response->setJSON(['Status' => '500', 'Mensaje' => 'Error al eliminar la categoria.']);
        }
    }

    public function listar_categorias($id)
    {
        if ($this->request->isAJAX()) {
            $response = $this->categoriaModel->obtenerCategoriaPorID($id);
            $mensaje = $response ? ["Status" => '200', "Mensaje" => $response]
                                 : ["Status" => '404', "Mensaje" => "No se encontró la categoria."];
            return $this->response->setJSON($mensaje);
        } else {
            return redirect()->to(base_url() . "/SegCategoria");
        }
    }

    public function activar($id_categoria)
    {
        $data = ['estado' => 1];
        $resultad = $this->categoriaModel->actualizarCategoria($id_categoria, $data);
        if ($resultad) {
            session()->setFlashdata('AlertShow', ["Tipo" => 'success', "Mensaje" => "Activacion exitosa."]);
        } else {
            session()->setFlashdata('AlertShow', ["Tipo" => 'error', "Mensaje" => "No se pudo Activar."]);
        }
        return redirect()->to(base_url() . "/SegCategoria");
    }
    
    public function cargartabla()
{
    if ($this->request->isAJAX()) {
        // Obtener parámetros de DataTables
        $draw = $this->request->getVar('draw'); // Número de solicitud
        $start = $this->request->getVar('start'); // Índice de inicio
        $length = $this->request->getVar('length'); // Número de registros por página
        $search = $this->request->getVar('search')['value']; // Valor de búsqueda
        $order = $this->request->getVar('order'); // Parámetros de ordenamiento

        // Obtener los datos de la base de datos
        $builder = $this->categoriaModel->table('categorias');
        $builder->select('id_categoria, codigo_categoria, nombre_categoria, estado');

        // Aplicar búsqueda si existe
        if (!empty($search)) {
            $builder->groupStart();
            $builder->orLike('codigo_categoria', $search);
            $builder->orLike('nombre_categoria', $search);
            $builder->groupEnd();
        }

        // Aplicar ordenamiento
        if (!empty($order)) {
            $columnIndex = $order[0]['column']; // Índice de la columna a ordenar
            $columnDir = $order[0]['dir']; // Dirección del ordenamiento (asc o desc)

            // Mapear el índice de la columna al nombre de la columna en la base de datos
            $columns = [
                0 => 'codigo_categoria', // Primera columna
                1 => 'nombre_categoria', // Segunda columna
                2 => 'estado' // Tercera columna
            ];

            if (isset($columns[$columnIndex])) {
                $builder->orderBy($columns[$columnIndex], $columnDir);
            }
        }

        // Obtener el total de registros (sin paginación)
        $totalRecords = $builder->countAllResults(false);

        // Aplicar paginación
        $builder->limit($length, $start);

        // Obtener los datos paginados
        $categorias = $builder->get()->getResultArray();

        // Preparar la respuesta para DataTables
        $response = [
            "draw" => intval($draw), // Número de solicitud
            "recordsTotal" => $totalRecords, // Total de registros sin filtrar
            "recordsFiltered" => $totalRecords, // Total de registros filtrados
            "data" => $categorias // Datos paginados
        ];

        return $this->response->setJSON($response);
    } else {
        return redirect()->to(base_url() . "/SegCategoria");
    }
}

}


