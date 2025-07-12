<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\SegMetaModel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SegMetas extends Controller
{
    protected $metaModel;

    public function __construct()
    {
        $this->metaModel = new SegMetaModel();
    }

   
    public function index()
    {
        $listaMetas = $this->metaModel->obtenerMetasActivas();
        $scripts = ['scripts' => ['js/seg_metas.js?v=1.0', 'plugins/custom/datatables/seg_dtserver_met.js?v=7.1.6']];
        $serverDatable=true;
        $this->viewData("seguimiento/meta", ["metas" => $listaMetas, 'serverDatable'=>$serverDatable], $scripts);
    }

    // Formulario para crear o actualizar meta
    public function formData()
    {
        $validation = \Config\Services::validation();
        $postData = $this->request->getPost();
        $isUpdating = isset($postData['id_meta']) && !empty($postData['id_meta']);

        $validationRules = [
            'codigo_meta' => 'required',
            'nombre_meta' => 'required',
            'codigo_actividad' => 'required',
            'descripcion' => 'permit_empty'
        ];

        $validation->setRules($validationRules);

        if ($validation->withRequest($this->request)->run()) {
            $data = [
                'codigo_meta' => $postData['codigo_meta'],
                'nombre_meta' => $postData['nombre_meta'],
                'codigo_actividad' => $postData['codigo_actividad'],
                'descripcion' => $postData['descripcion'],
                'estado'      => 1
            ];

            if ($isUpdating) {
                $response = $this->actualizar($data, $postData['id_meta']);
                $mensaje = $response
                    ? ["Tipo" => 'success', "Mensaje" => "Meta actualizada correctamente."]
                    : ["Tipo" => 'error', "Mensaje" => "Error al actualizar la meta."];
            } else {
                $response = $this->registrar($data);
                $mensaje = $response
                    ? ["Tipo" => 'success', "Mensaje" => "Meta registrada correctamente."]
                    : ["Tipo" => 'error', "Mensaje" => "Error al registrar la meta."];
            }
            session()->setFlashdata('AlertShow', $mensaje);
        } else {
            $errors = $validation->getErrors();
            session()->setFlashdata('AlertShowCode', $errors);
        }
        return redirect()->to(base_url() . "/SegMetas");
    }

    // Registrar una nueva meta
    public function registrar($data)
    {

        return $this->metaModel->crearMeta($data);
    }

    // Actualizar una meta existente
    public function actualizar($data, $id)
    {

        return $this->metaModel->actualizarMeta($id, $data);
    }

    public function eliminar($id)
    {
        // Verificar si la categoría está en uso en carpetas
        if ($this->metaModel->tieneDependencias($id)) {
            return $this->response->setJSON([
                'Status' => '409', // Conflicto
                'Mensaje' => 'No se puede eliminar la meta porque está siendo utilizada en carpetas.'
            ]);
        }

        // Si no tiene dependencias, procede a "eliminar" (cambiar estado)
        if ($this->metaModel->eliminarMeta($id)) {
            return $this->response->setJSON([
                'Status' => '200',
                'Mensaje' => 'Meta eliminada correctamente.'
            ]);
        } else {
            return $this->response->setJSON([
                'Status' => '500',
                'Mensaje' => 'Error al eliminar la meta.'
            ]);
        }
    }

    public function listar_metas($id) {
        if ($this->request->isAJAX()) {
            $response = $this->metaModel->obtenerMetaPorID($id);
            $mensaje = $response ? ["Status" => '200', "Mensaje" => $response]
                                 : ["Status" => '404', "Mensaje" => "No se encontró la meta."];
            return $this->response->setJSON($mensaje);
        } else {
            return redirect()->to(base_url() . "/SegMetas");
        }
    }

    public function activar($id)
    {
        $data = ['estado' => 1]; // Cambia el estado a activo (1)
        $resultad = $this->metaModel->actualizarMeta($id, $data);
        if ($resultad) {
            session()->setFlashdata('AlertShow', ["Tipo" => 'success', "Mensaje" => "Activacion exitosa."]);
        } else {
            session()->setFlashdata('AlertShow', ["Tipo" => 'error', "Mensaje" => "No se pudo Activar."]);
        }
        return redirect()->to(base_url() . "/SegMetas");
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
            $builder = $this->metaModel->table('metas');
            $builder->select('id_meta, codigo_meta, codigo_actividad, nombre_meta, estado');

            // Aplicar búsqueda si existe
            if (!empty($search)) {
                $builder->groupStart();
                $builder->orLike('codigo_meta', $search);
                $builder->orLike('codigo_actividad', $search);
                $builder->orLike('nombre_meta', $search);
                $builder->groupEnd();
            }

            // Aplicar ordenamiento
            if (!empty($order)) {
                $columnIndex = $order[0]['column']; // Índice de la columna a ordenar
                $columnDir = $order[0]['dir']; // Dirección del ordenamiento (asc o desc)

                // Mapear el índice de la columna al nombre de la columna en la base de datos
                $columns = [
                    0 => 'codigo_meta', // Primera columna
                    1 => 'codigo_actividad', // Segunda columna
                    2 => 'nombre_meta', // Tercera columna
                    3 => 'estado' // Cuarta columna
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
            $metas = $builder->get()->getResultArray();

            // Preparar la respuesta para DataTables
            $response = [
                "draw" => intval($draw), // Número de solicitud
                "recordsTotal" => $totalRecords, // Total de registros sin filtrar
                "recordsFiltered" => $totalRecords, // Total de registros filtrados
                "data" => $metas // Datos paginados
            ];

            return $this->response->setJSON($response);
        } else {
            return redirect()->to(base_url() . "/SegMetas");
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
                $codigoactividad = trim($sheet->getCell("B$row")->getValue());
                $nombre = trim($sheet->getCell("C$row")->getValue());
                $descripcion = trim($sheet->getCell("D$row")->getValue());

                if (empty($codigo) || empty($nombre)) continue;

                // Verificar duplicados
                $existe = $this->metaModel
                    ->where('codigo_meta', $codigo)
                    ->first();

                if (!$existe) {
                    $this->metaModel->insert([
                        'codigo_meta' => $codigo,
                        'codigo_actividad' => $codigoactividad,
                        'nombre_meta' => $nombre,
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

        return redirect()->to(base_url("SegMetas"));
    }
}
