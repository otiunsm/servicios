<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\SegProgramaPresupuestalModel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SegProgramas extends Controller
{
    protected $programaModel;
    public function __construct(){
        $this->programaModel = new SegProgramaPresupuestalModel();
    }

    public function index()
    {
        $listaProgramas = $this->programaModel->obtenerProgramasActivos();
        $scripts = ['scripts' => ['js/seg_programas.js?v=1.0', 'plugins/custom/datatables/seg_dtserver_prog.js?v=7.1.6']];
        $serverDatable  = true;
        $this->viewData("seguimiento/programa", ["programas" => $listaProgramas,"serverDatable" => $serverDatable], $scripts);
    }

    public function formData()
    {
        $validation = \Config\Services::validation();
        $postData = $this->request->getPost();
        $isUpdating = isset($postData['id_programa']) && !empty($postData['id_programa']);

        $validationRules = [
            'codigo_programa' => 'required|is_unique[programas_presupuestales.codigo_programa,id_programa,{id_programa}]',
            'nombre_programa' => 'required',
            'descripcion' => 'permit_empty'
        ];

        $validation->setRules($validationRules);

        if ($validation->withRequest($this->request)->run()) {
            $data = [
                'codigo_programa' => $postData['codigo_programa'],
                'nombre_programa' => $postData['nombre_programa'],
                'descripcion' => isset($postData['descripcion']) ? $postData['descripcion'] : null,
                'estado' => 1
            ];

            if ($isUpdating) {
                $response = $this->actualizar($data, $postData['id_programa']);
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

        return redirect()->to(base_url() . "/SegProgramas");
    }

    public function registrar($data)
    {
        return $this->programaModel->crearPrograma($data);
    }

    public function actualizar($data, $id)
    {
        return $this->programaModel->actualizarPrograma($id, $data);
    }

    public function eliminar($id)
    {
        if ($this->programaModel->eliminarPrograma($id)) {
            return $this->response->setJSON(['Status' => '200', 'Mensaje' => 'Programa eliminado correctamente.']);
        } else {
            return $this->response->setJSON(['Status' => '500', 'Mensaje' => 'Error al eliminar el programa.']);
        }
    }
    

    public function listar_programas($id) {
        if ($this->request->isAJAX()) {
            $response = $this->programaModel->obtenerProgramaPorID($id);
            $mensaje = $response ? ["Status" => '200', "Mensaje" => $response]
                                 : ["Status" => '404', "Mensaje" => "No se encontró el programa."];
            return $this->response->setJSON($mensaje);
        } else {
            return redirect()->to(base_url() . "/SegProgramas");
        }
    }

    public function activar($id_programa)
    {
        $data = ['estado' => 1]; // Cambia el estado a activo (1)
        $resultad = $this->programaModel->actualizarPrograma($id_programa, $data);
        if ($resultad) {
            session()->setFlashdata('AlertShow', ["Tipo" => 'success', "Mensaje" => "Activacion exitosa."]);
        } else {
            session()->setFlashdata('AlertShow', ["Tipo" => 'error', "Mensaje" => "No se pudo Activar."]);
        }
        return redirect()->to(base_url() . "/SegProgramas");
    }

    public function cargartablap()
    {
        if ($this->request->isAJAX()) {
            $draw = $this->request->getVar('draw');
            $start = $this->request->getVar('start');
            $length = $this->request->getVar('length');
            $search = $this->request->getVar('search')['value'];
            $order = $this->request->getVar('order');

            $builder = $this->programaModel->table('programas');
            $builder->select('id_programa, codigo_programa, nombre_programa, estado');

            if (!empty($search)) {
                $builder->groupStart();
                $builder->orLike('codigo_programa', $search);
                $builder->orLike('nombre_programa', $search);
                $builder->groupEnd();
            }

            if (!empty($order)) {
                $columnIndex = $order[0]['column'];
                $columnDir = $order[0]['dir'];

                $columns = [
                    0 => 'codigo_programa',
                    1 => 'nombre_programa',
                    2 => 'estado'
                ];

                if (isset($columns[$columnIndex])) {
                    $builder->orderBy($columns[$columnIndex], $columnDir);
                }
            }

            $totalRecords = $builder->countAllResults(false);
            $builder->limit($length, $start);
            $programas = $builder->get()->getResultArray();

            $response = [
                "draw" => intval($draw),
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $totalRecords,
                "data" => $programas
            ];

            return $this->response->setJSON($response);
        } else {
            return redirect()->to(base_url() . "/SegProgramas");
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
                $existe = $this->programaModel
                    ->where('codigo_programa', $codigo)
                    ->first();

                if (!$existe) {
                    $this->programaModel->insert([
                        'codigo_programa' => $codigo,
                        'nombre_programa' => $nombre,
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

        return redirect()->to(base_url("SegProgramas"));
    }
    
}
