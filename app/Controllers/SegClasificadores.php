<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\SegClasificadorModel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SegClasificadores extends Controller
{
    protected $clasificadorModel;

    public function __construct()
    {
        $this->clasificadorModel = new SegClasificadorModel();
    }

    // Método principal para cargar la lista de clasificadores y su vista
    public function index()
    {
        $listaClasificadores= $this->clasificadorModel->getClasificadoresActivos();
        $serverDatable  = true;
        $scripts = ['scripts' => ['js/seg_clasificadores.js?v=7.1.6', 'plugins/custom/datatables/seg_dtserver_clasi.js?v=7.1.6']]; // Archivo JS específico
        return $this->viewData("/seguimiento/clasificador", ["clasificadores" => $listaClasificadores, 'serverDatable' => $serverDatable], $scripts);
    }

    // Método para manejar la creación o actualización de un clasificador
    public function formData()
    {
        $validation = \Config\Services::validation();
        $postData = $this->request->getPost();
        $isUpdating = isset($postData['id_clasificador']) && !empty($postData['id_clasificador']);

        $validationRules = [
            'codigo_clasificador' => 'required',
            'nombre_clasificador' => 'required',
            'descripcion'         => 'permit_empty',
        ];

        $validation->setRules($validationRules);

        if ($validation->withRequest($this->request)->run()) {
            $data = [
                'codigo_clasificador' => $postData['codigo_clasificador'],
                'nombre_clasificador' => $postData['nombre_clasificador'],
                'descripcion'         => $postData['descripcion'],
                'estado'              => 1
            ];

            if ($isUpdating) {
                $response = $this->actualizar($data, $postData['id_clasificador']);
                $mensaje = $response
                    ? ["Tipo" => 'success', "Mensaje" => "Clasificador actualizado correctamente."]
                    : ["Tipo" => 'error', "Mensaje" => "No se pudo actualizar el clasificador."];
            } else {
                $response = $this->registrar($data);
                $mensaje = $response
                    ? ["Tipo" => 'success', "Mensaje" => "Clasificador registrado correctamente."]
                    : ["Tipo" => 'error', "Mensaje" => "No se pudo registrar el clasificador."];
            }
            session()->setFlashdata('AlertShow', $mensaje);
        } else {
            $errors = $validation->getErrors();
            session()->setFlashdata('AlertShowCode', $errors);
        }
        return redirect()->to(base_url() . "/SegClasificadores");
    }

    // Método para registrar un nuevo clasificador
    public function registrar($data)
    {
        return $this->clasificadorModel->createClasificador($data);
    }

    // Método para actualizar un clasificador existente
    public function actualizar($data, $id)
    {
        return $this->clasificadorModel->updateClasificador($id, $data);
    }

    // Desactivar un clasificador (método AJAX)
    public function delete($id)
    {
        if ($this->clasificadorModel->eliminarClasificador($id)) {
            return $this->response->setJSON(['Status' => '200', 'Mensaje' => 'Clasificador eliminado correctamente.']);
        } else {
            return $this->response->setJSON(['Status' => '500', 'Mensaje' => 'Error al eliminar el clasificador.']);
        }
    }


    public function listar_clasificadores($id) {
        if ($this->request->isAJAX()) {
            $response = $this->clasificadorModel->getClasificadorById($id);
            $mensaje = $response ? ["Status" => '200', "Mensaje" => $response]
                                 : ["Status" => '404', "Mensaje" => "No se encontró el clasificador."];
            return $this->response->setJSON($mensaje);
        } else {
            return redirect()->to(base_url() . "/SegClasificadores");
        }
    }

    public function activar($id)
    {
        $data = ['estado' => 1]; // Cambia el estado a activo (1)
        $resultad = $this->clasificadorModel->updateClasificador($id, $data);
        if ($resultad) {
            session()->setFlashdata('AlertShow', ["Tipo" => 'success', "Mensaje" => "Activacion exitosa."]);
        } else {
            session()->setFlashdata('AlertShow', ["Tipo" => 'error', "Mensaje" => "No se pudo Activar."]);
        }
        return redirect()->to(base_url() . "/SegClasificadores");
    }

    public function cargartabla()
    {
        if ($this->request->isAJAX()) {
            $draw = $this->request->getVar('draw');
            $start = $this->request->getVar('start');
            $length = $this->request->getVar('length');
            $search = $this->request->getVar('search')['value'];
            $order = $this->request->getVar('order');

            $builder = $this->clasificadorModel->table('clasificadores');
            $builder->select('id_clasificador, codigo_clasificador, nombre_clasificador, estado');

            if (!empty($search)) {
                $builder->groupStart();
                $builder->orLike('codigo_clasificador', $search);
                $builder->orLike('nombre_clasificador', $search);
                $builder->groupEnd();
            }

            if (!empty($order)) {
                $columnIndex = $order[0]['column'];
                $columnDir = $order[0]['dir'];

                $columns = [
                    0 => 'codigo_clasificador',
                    1 => 'nombre_clasificador',
                    2 => 'estado'
                ];

                if (isset($columns[$columnIndex])) {
                    $builder->orderBy($columns[$columnIndex], $columnDir);
                }
            }

            $totalRecords = $builder->countAllResults(false);
            $builder->limit($length, $start);
            $clasificadores = $builder->get()->getResultArray();

            $response = [
                "draw" => intval($draw),
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $totalRecords,
                "data" => $clasificadores
            ];

            return $this->response->setJSON($response);
        } else {
            return redirect()->to(base_url() . "/SegClasificadores");
        }
    }

    public function importarExcel()
    {
        $file = $this->request->getFile('archivo_excel');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $spreadsheet = IOFactory::load($file->getTempName());
            $sheet = $spreadsheet->getActiveSheet();
            $highestRow = $sheet->getHighestDataRow(); // última fila con contenido
            $insertados = 0;
            $omitidos = 0;

            for ($row = 2; $row <= $highestRow; $row++) {
                $codigo = trim($sheet->getCell("A$row")->getValue());
                $nombre = trim($sheet->getCell("B$row")->getValue());
                $descripcion = trim($sheet->getCell("C$row")->getValue());

                if (empty($codigo) || empty($nombre)) continue;

                // Verificar duplicados
                $existe = $this->clasificadorModel
                    ->where('codigo_clasificador', $codigo)
                    ->first();

                if (!$existe) {
                    $this->clasificadorModel->insert([
                        'codigo_clasificador' => $codigo,
                        'nombre_clasificador' => $nombre,
                        'descripcion' => $descripcion,
                        'estado' => 1
                    ]);
                    $insertados++;
                } else {
                    $omitidos++;
                }
            }
            session()->setFlashdata('AlertShow', [
                "Tipo" => 'success',
                "Mensaje" => "Importación completa. Insertados: $insertados | Duplicados omitidos: $omitidos"
            ]);
        } else {
            session()->setFlashdata('AlertShow', [
                "Tipo" => 'error',
                "Mensaje" => "Error al subir el archivo. Verifica que sea un archivo válido."
            ]);
        }

        return redirect()->to(base_url("SegClasificadores"));
    }

}
