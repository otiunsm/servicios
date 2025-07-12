<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\SegCentrocostosModel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SegCentrocostos extends Controller
{
    protected $centroCostosModel;

    public function __construct()
    {
        $this->centroCostosModel = new SegCentrocostosModel();
    }

    public function index()
    {
        $listaCentrosCostos = $this->centroCostosModel->obtenerCentrosCostosActivos();
        $scripts = ['scripts' => ['js/Seg_centrocostos.js?v=1.0', 'plugins/custom/datatables/seg_dtserver_centrocos.js?v=7.1.6']];
        $serverDatable = true;
        $this->viewData("seguimiento/centro", ["centros_costos" => $listaCentrosCostos, 'serverDatable' => $serverDatable], $scripts);
    }

    public function formData()
    {
        $validation = \Config\Services::validation();
        $postData = $this->request->getPost();
        $isUpdating = isset($postData['idCentro']) && !empty($postData['idCentro']);

        $validationRules = [
            'codigocen' => 'required',
            'nombrecen' => 'required',
            'descripcion' => 'permit_empty'
        ];

        $validation->setRules($validationRules);

        if ($validation->withRequest($this->request)->run()) {
            $data = [
                'codigocen' => $postData['codigocen'],
                'nombrecen' => $postData['nombrecen'],
                'descripcion' => $postData['descripcion'],
                'estado' => 1
            ];

            if ($isUpdating) {
                $response = $this->actualizar($data, $postData['idCentro']);
                $mensaje = $response
                    ? ["Tipo" => 'success', "Mensaje" => "Centro de costos actualizado correctamente."]
                    : ["Tipo" => 'error', "Mensaje" => "Error al actualizar el centro de costos."];
            } else {
                $response = $this->registrar($data);
                $mensaje = $response
                    ? ["Tipo" => 'success', "Mensaje" => "Centro de costos registrado correctamente."]
                    : ["Tipo" => 'error', "Mensaje" => "Error al registrar el centro de costos."];
            }
            session()->setFlashdata('AlertShow', $mensaje);
        } else {
            $errors = $validation->getErrors();
            session()->setFlashdata('AlertShowCode', $errors);
        }
        return redirect()->to(base_url() . "/SegCentrocostos");
    }

    public function registrar($data)
    {
        return $this->centroCostosModel->crearCentroCosto($data);
    }

    public function actualizar($data, $id)
    {
        return $this->centroCostosModel->actualizarCentroCosto($id, $data);
    }

    public function eliminar($id)
    {
        // Verificar si el clasificador está en uso en detalle_seguimiento
        if ($this->centroCostosModel->tieneDependencias($id)) {
            return $this->response->setJSON([
                'Status' => '409', // Conflicto
                'Mensaje' => 'No se puede eliminar el centro de costo porque está siendo utilizado.'
            ]);
        }

        // Si no tiene dependencias, procede a desactivarlo
        if ($this->centroCostosModel->eliminarCentroCosto($id)) {
            return $this->response->setJSON([
                'Status' => '200',
                'Mensaje' => 'Centro de costo eliminado correctamente.'
            ]);
        } else {
            return $this->response->setJSON([
                'Status' => '500',
                'Mensaje' => 'Error al eliminar el centro de costo.'
            ]);
        }
    }

    public function listar_centro_costos($id)
    {
        if ($this->request->isAJAX()) {
            $response = $this->centroCostosModel->obtenerCentroCostoPorID($id);
            $mensaje = $response ? ["Status" => '200', "Mensaje" => $response]
                : ["Status" => '404', "Mensaje" => "No se encontró el centro de costos."];
            return $this->response->setJSON($mensaje);
        } else {
            return redirect()->to(base_url() . "/SegCentrocostos");
        }
    }
    public function activar($id)
    {
        $data = ['estado' => 1]; // Cambia el estado a activo (1)
        $resultad = $this->centroCostosModel->actualizarCentroCosto($id, $data);
        if ($resultad) {
            session()->setFlashdata('AlertShow', ["Tipo" => 'success', "Mensaje" => "Activacion exitosa."]);
        } else {
            session()->setFlashdata('AlertShow', ["Tipo" => 'error', "Mensaje" => "No se pudo Activar."]);
        }
        return redirect()->to(base_url() . "/SegCentrocostos");
    }

    public function cargartabla()
    {
        if ($this->request->isAJAX()) {
            $draw = $this->request->getVar('draw');
            $start = $this->request->getVar('start');
            $length = $this->request->getVar('length');
            $search = $this->request->getVar('search')['value'];
            $order = $this->request->getVar('order');

            $builder = $this->centroCostosModel->table('centro_de_costos');
            $builder->select('idCentro, codigocen, nombrecen, descripcion, estado');

            if (!empty($search)) {
                $builder->groupStart();
                $builder->orLike('codigocen', $search);
                $builder->orLike('nombrecen', $search);
                $builder->groupEnd();
            }

            if (!empty($order)) {
                $columnIndex = $order[0]['column'];
                $columnDir = $order[0]['dir'];

                $columns = [
                    0 => 'codigocen',
                    1 => 'nombrecen',
                    2 => 'estado'
                ];

                if (isset($columns[$columnIndex])) {
                    $builder->orderBy($columns[$columnIndex], $columnDir);
                }
            }

            $totalRecords = $builder->countAllResults(false);
            $builder->limit($length, $start);

            $centrosCostos = $builder->get()->getResultArray();

            $response = [
                "draw" => intval($draw),
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $totalRecords,
                "data" => $centrosCostos
            ];

            return $this->response->setJSON($response);
        } else {
            return redirect()->to(base_url() . "/SegCentrocostos");
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
                $existe = $this->centroCostosModel
                    ->where('codigocen', $codigo)
                    ->first();

                if (!$existe) {
                    $this->centroCostosModel->insert([
                        'codigocen' => $codigo,
                        'nombrecen' => $nombre,
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

        return redirect()->to(base_url("SegCentrocostos"));
    }
}
