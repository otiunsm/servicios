<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\SegFuenteFinanciamientoModel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SegFuentes extends Controller
{
    protected $fuenteModel;
    public function __construct()
    {
        $this->fuenteModel = new SegFuenteFinanciamientoModel();
    }

    public function index()
    {
        $listaFuentes = $this->fuenteModel->obtenerFuentesActivas();
        $serverDatable = true;
        $scripts = ['scripts' => ['js/seg_fuente.js?v=7.1.6', 'plugins/custom/datatables/seg_dtserver_fuente.js?v=7.1.6']];
        $this->viewData("seguimiento/fuente", ["fuentes" => $listaFuentes, 'server' => $serverDatable], $scripts);
    }

    public function formData()
    {
        $validation = \Config\Services::validation();
        $postData = $this->request->getPost();
        $isUpdating = isset($postData['id_fuente']) && !empty($postData['id_fuente']);

        $validationRules = [
            'codigo_fuente' => 'required|is_unique[fuentes_financiamiento.codigo_fuente,id_fuente,{id_fuente}]',
            'nombre_fuente' => 'required',
            'descripcion' => 'permit_empty'
        ];

        $validation->setRules($validationRules);

        if ($validation->withRequest($this->request)->run()) {
            $data = [
                'codigo_fuente' => $postData['codigo_fuente'],
                'nombre_fuente' => $postData['nombre_fuente'],
                'descripcion' => $postData['descripcion'] ?? null,
                'estado' => 1
            ];

            if ($isUpdating) {
                $response = $this->fuenteModel->update($postData['id_fuente'], $data);
                $mensaje = $response ? ["Tipo" => 'success', "Mensaje" => "Actualización Exitosa."]
                    : ["Tipo" => 'error', "Mensaje" => "No se pudo actualizar."];
            } else {
                $response = $this->fuenteModel->insert($data);
                $mensaje = $response ? ["Tipo" => 'success', "Mensaje" => "Registro Exitoso."]
                    : ["Tipo" => 'error', "Mensaje" => "No se pudo registrar."];
            }

            session()->setFlashdata('AlertShow', $mensaje);
        } else {
            $errors = $validation->getErrors();
            session()->setFlashdata('AlertShowCode', $errors);
        }

        return redirect()->to('/SegFuentes');
    }

    public function eliminar($id)
    {
        // Verificar si la categoría está en uso en carpetas
        if ($this->fuenteModel->tieneDependencias($id)) {
            return $this->response->setJSON([
                'Status' => '409', // Conflicto
                'Mensaje' => 'No se puede eliminar la fuente porque está siendo utilizada en carpetas.'
            ]);
        }

        // Si no tiene dependencias, procede a "eliminar" (cambiar estado)
        if ($this->fuenteModel->eliminarFuente($id)) {
            return $this->response->setJSON([
                'Status' => '200',
                'Mensaje' => 'Fuente eliminada correctamente.'
            ]);
        } else {
            return $this->response->setJSON([
                'Status' => '500',
                'Mensaje' => 'Error al eliminar la fuente.'
            ]);
        }
    }

    public function listar_fuentes($id)
    {
        if ($this->request->isAJAX()) {
            $response = $this->fuenteModel->obtenerFuentePorID($id);
            $mensaje = $response ? ["Status" => '200', "Mensaje" => $response]
                : ["Status" => '404', "Mensaje" => "No se encontró la fuente."];
            return $this->response->setJSON($mensaje);
        } else {
            return redirect()->to(base_url() . "/SegFuentes");
        }
    }
    public function activar($ids)
    {
        $data = ['estado' => 1]; // Cambia el estado a activo (1)
        $resultad = $this->fuenteModel->actualizarFuente($ids, $data);
        if ($resultad) {
            session()->setFlashdata('AlertShow', ["Tipo" => 'success', "Mensaje" => "Activacion exitosa."]);
        } else {
            session()->setFlashdata('AlertShow', ["Tipo" => 'error', "Mensaje" => "No se pudo Activar."]);
        }
        return redirect()->to(base_url() . "/SegFuentes");
    }

    public function cargartabla()
    {
        if ($this->request->isAJAX()) {
            $draw = $this->request->getVar('draw');
            $start = $this->request->getVar('start');
            $length = $this->request->getVar('length');
            $search = $this->request->getVar('search')['value'];
            $order = $this->request->getVar('order');

            $builder = $this->fuenteModel->table('fuentes');
            $builder->select('id_fuente, codigo_fuente, nombre_fuente, estado');

            if (!empty($search)) {
                $builder->groupStart();
                $builder->orLike('codigo_fuente', $search);
                $builder->orLike('nombre_fuente', $search);
                $builder->groupEnd();
            }

            if (!empty($order)) {
                $columnIndex = $order[0]['column'];
                $columnDir = $order[0]['dir'];

                $columns = [
                    0 => 'codigo_fuente',
                    1 => 'nombre_fuente',
                    2 => 'estado'
                ];

                if (isset($columns[$columnIndex])) {
                    $builder->orderBy($columns[$columnIndex], $columnDir);
                }
            }

            $totalRecords = $builder->countAllResults(false);
            $builder->limit($length, $start);
            $fuentes = $builder->get()->getResultArray();

            $response = [
                "draw" => intval($draw),
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $totalRecords,
                "data" => $fuentes
            ];

            return $this->response->setJSON($response);
        } else {
            return redirect()->to(base_url() . "/SegFuentes");
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
                $existe = $this->fuenteModel
                    ->where('codigo_fuente', $codigo)
                    ->first();

                if (!$existe) {
                    $this->fuenteModel->insert([
                        'codigo_fuente' => $codigo,
                        'nombre_fuente' => $nombre,
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

        return redirect()->to(base_url("SegFuentes"));
    }
}
