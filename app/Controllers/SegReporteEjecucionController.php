<?php

namespace App\Controllers;

use App\Models\SegCategoriaModel;
use App\Models\SegProgramaPresupuestalModel;
use App\Models\SegFuenteFinanciamientoModel;
use App\Models\SegMetaModel;
use App\Models\SegDetalleSeguimientoModel;
use App\Models\SegClasificadorModel;
use App\Models\SegCertificadosModel;
use App\Models\SegCentrocostosModel;
use App\Models\SegPimInicial;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use CodeIgniter\Controller;

class SegReporteEjecucionController extends Controller
{
    protected $categoriaModel;
    protected $programaModel;
    protected $fuenteModel;
    protected $metaModel;
    protected $detalleSeguimientoModel;
    protected $clasificadoresModel;
    protected $certificadosModel;
    protected $centroCostosModel;
    protected $pimInicialModel;

    public function __construct()
    {
        $this->categoriaModel = new SegCategoriaModel();
        $this->programaModel = new SegProgramaPresupuestalModel();
        $this->fuenteModel = new SegFuenteFinanciamientoModel();
        $this->metaModel = new SegMetaModel();
        $this->detalleSeguimientoModel = new SegDetalleSeguimientoModel();
        $this->clasificadoresModel = new SegClasificadorModel();
        $this->certificadosModel = new SegCertificadosModel();
        $this->centroCostosModel = new SegCentrocostosModel();
        $this->pimInicialModel = new SegPimInicial();
    }

    public function index()
    {
        $fuentes = $this->fuenteModel->where('estado', 1)->findAll();
        $scripts = ['scripts' => ['js/seg_reporte.js?v=1.0']];
        return $this->viewData('seguimiento/reporte_ejecucion', ['fuentes' => $fuentes], $scripts);
    }
public function exportarExcel()
{
    $id_fuente = $this->request->getGet('id_fuente');
    $nombreFuente = $id_fuente === 'todos' ? 'Todas las fuentes' : ($this->fuenteModel->find($id_fuente)['nombre_fuente'] ?? '---');
    $año = date('Y');
    $centros = $this->centroCostosModel->where('estado', 1)->findAll();

    $detallesQuery = $this->detalleSeguimientoModel
        ->select("cat.nombre_categoria, prog.nombre_programa, fuente.codigo_fuente, fuente.nombre_fuente, meta.codigo_meta, meta.codigo_actividad, meta.nombre_meta,
                  CONCAT(clasi.codigo_clasificador, ' - ', clasi.nombre_clasificador) AS clasificador,
                  ds.id_detalle, clasi.id_clasificador,
                  cat.id_categoria, prog.id_programa, fuente.id_fuente, meta.id_meta")
        ->from('detalle_seguimiento ds')
        ->join('categorias cat', 'cat.id_categoria = ds.id_categoria')
        ->join('programas_presupuestales prog', 'prog.id_programa = ds.id_programa')
        ->join('fuentes_financiamiento fuente', 'fuente.id_fuente = ds.id_fuente')
        ->join('metas meta', 'meta.id_meta = ds.id_meta')
        ->join('clasificadores clasi', 'clasi.id_clasificador = ds.id_clasificador');

    if ($id_fuente !== 'todos') {
        $detallesQuery->where('ds.id_fuente', $id_fuente);
    }

    $detalles = $detallesQuery->findAll();
    $agrupado = [];

    foreach ($detalles as $detalle) {
        $key = implode('|', [
            $detalle['nombre_categoria'],
            $detalle['nombre_programa'],
            $detalle['codigo_fuente'],
            $detalle['codigo_meta'],
            $detalle['codigo_actividad'],
            $detalle['nombre_meta'],
            $detalle['clasificador']
        ]);

        if (!isset($agrupado[$key])) {
            $agrupado[$key] = [
                'base' => $detalle,
                'centros' => []
            ];
        }

        foreach ($centros as $c) {
            $pim = 0;

            $pimInicial = $this->pimInicialModel
                ->where([
                    'id_categoria' => $detalle['id_categoria'],
                    'id_programa' => $detalle['id_programa'],
                    'id_fuente' => $detalle['id_fuente'],
                    'id_meta' => $detalle['id_meta'],
                    'id_clasificador' => $detalle['id_clasificador'],
                    'id_centro_costos' => $c['idCentro']
                ])
                ->select('monto_pim')
                ->first();

            $pim = floatval($pimInicial['monto_pim'] ?? 0);

            if ($pim == 0) {
                $inicialModel = new \App\Models\InicializacionModel();
                $inicial = $inicialModel->where([
                    'id_categoria' => $detalle['id_categoria'],
                    'id_programa' => $detalle['id_programa'],
                    'id_fuente' => $detalle['id_fuente'],
                    'id_meta' => $detalle['id_meta'],
                    'id_clasificador' => $detalle['id_clasificador'],
                    'id_centro_costos' => $c['idCentro']
                ])->first();
                $pim = floatval($inicial['valor_pim'] ?? 0);
            }

            $certs = $this->certificadosModel
                ->where('id_detalle', $detalle['id_detalle'])
                ->where('id_centro_costos', $c['idCentro'])
                ->orderBy('fecha', 'ASC')
                ->findAll();

            $PIM = $pim;
            $Saldo = $pim;

            foreach ($certs as $cert) {
                $mod = floatval($cert['modificacion'] ?? 0);
                $mon = floatval($cert['certificacion_monto'] ?? 0);
                $reb = floatval($cert['certificacion_rebaja'] ?? 0);
                $amp = floatval($cert['certificacion_ampliacion'] ?? 0);
                $PIM += $mod;
                $Saldo += $mod - $mon + ($reb - $amp);
            }

            $agrupado[$key]['centros'][$c['idCentro']] = [
                'pim' => $PIM,
                'cert' => $PIM - $Saldo,
                'saldo' => $Saldo
            ];
        }
    }

    // 📊 Excel
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', "Ejecución Presupuestal - $año");
    $sheet->mergeCells('A1:Z1');
    $sheet->setCellValue('A2', "Fuente de Financiamiento: $nombreFuente");
    $sheet->mergeCells('A2:Z2');

    // 🧾 Encabezados
    $headers = ['Categoría', 'Programa', 'Código Fuente', 'Código Meta', 'Código Actividad', 'Nombre Actividad', 'Clasificador', 'Total PIM', 'Total Certificación', 'Total Saldo'];
    $sheet->fromArray($headers, null, 'A4');

    $colIndex = count($headers) + 1;
    foreach ($centros as $c) {
        $colIni = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
        $colFin = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex + 2);
        $sheet->setCellValue($colIni . '4', $c['nombrecen']);
        $sheet->mergeCells("{$colIni}4:{$colFin}4");
        $sheet->setCellValue($colIni . '5', 'PIM');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex + 1) . '5', 'Certificación');
        $sheet->setCellValue($colFin . '5', 'Saldo');
        $colIndex += 3;
    }

    $headerStyle = $sheet->getStyle("A4:" . \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex - 1) . "5");
    $headerStyle->getFont()->setBold(true);
    $headerStyle->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $headerStyle->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFD9E1F2');

    // 📄 Cuerpo
    $fila = 6;
    $columnMerge = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
    $previous = []; $startRows = [];

    foreach ($agrupado as $info) {
        $b = $info['base'];
        $totPim = $totCert = $totSaldo = 0;
        foreach ($info['centros'] as $v) {
            $totPim += $v['pim'];
            $totCert += $v['cert'];
            $totSaldo += $v['saldo'];
        }

        $linea = [
            $b['nombre_categoria'], $b['nombre_programa'], $b['codigo_fuente'],
            $b['codigo_meta'], $b['codigo_actividad'], $b['nombre_meta'],
            $b['clasificador'], $totPim, $totCert, $totSaldo
        ];

        foreach ($centros as $c) {
            $datos = $info['centros'][$c['idCentro']] ?? ['pim' => 0, 'cert' => 0, 'saldo' => 0];
            $linea[] = $datos['pim'];
            $linea[] = $datos['cert'];
            $linea[] = $datos['saldo'];
        }

        $sheet->fromArray($linea, null, 'A' . $fila);

        foreach ($columnMerge as $i => $col) {
            $val = $linea[$i];
            if (!isset($previous[$col])) {
                $previous[$col] = $val;
                $startRows[$col] = $fila;
            } elseif ($previous[$col] !== $val) {
                if ($fila - 1 > $startRows[$col]) {
                    $sheet->mergeCells("{$col}{$startRows[$col]}:{$col}" . ($fila - 1));
                    $sheet->getStyle("{$col}{$startRows[$col]}:{$col}" . ($fila - 1))->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                }
                $previous[$col] = $val;
                $startRows[$col] = $fila;
            }
        }

        $fila++;
    }

    foreach ($columnMerge as $col) {
        if ($fila - 1 > ($startRows[$col] ?? 0)) {
            $sheet->mergeCells("{$col}{$startRows[$col]}:{$col}" . ($fila - 1));
            $sheet->getStyle("{$col}{$startRows[$col]}:{$col}" . ($fila - 1))->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        }
    }

    // 📐 Ajustar ancho
    $colFinal = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex - 1);
    for ($i = 1; $i <= $colIndex - 1; $i++) {
        $sheet->getColumnDimensionByColumn($i)->setAutoSize(true);
    }

    // 💾 Exportar
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment;filename=ejecucion_presupuestal_$año.xlsx");
    header('Cache-Control: max-age=0');
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}


public function graficosCentrosCosto()
{
    $centros = $this->centroCostosModel->where('estado', 1)->findAll();
    $ejecuciones = [];

    foreach ($centros as $c) {
        $pim_total = 0;
        $cert_total = 0;

        $iniciales = $this->pimInicialModel->where('id_centro_costos', $c['idCentro'])->findAll();
        foreach ($iniciales as $pim) {
            $certs = $this->certificadosModel
                ->where('id_certificado', $pim['id_certificado'])
                ->findAll();

            $pim_local = floatval($pim['monto_pim']);
            $cert_local = 0;
            $saldo = $pim_local;

            foreach ($certs as $cert) {
                $mod = floatval($cert['modificacion'] ?? 0);
                $mon = floatval($cert['certificacion_monto'] ?? 0);
                $reb = floatval($cert['certificacion_rebaja'] ?? 0);
                $amp = floatval($cert['certificacion_ampliacion'] ?? 0);
                $pim_local += $mod;
                $saldo += $mod - $mon + ($reb - $amp);
            }
            $pim_total += $pim_local;
            $cert_total += ($pim_local - $saldo);
        }

        $ejecuciones[] = [
            'centro' => $c['nombrecen'],
            'pim' => round($pim_total, 2),
            'certificacion' => round($cert_total, 2),
            'ejecucion' => $pim_total > 0 ? round(($cert_total / $pim_total) * 100, 2) : 0
        ];
    }

    return $this->response->setJSON($ejecuciones);
}



}