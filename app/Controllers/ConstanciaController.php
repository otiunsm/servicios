<?php

namespace App\Controllers;

use App\Models\ConstanciaModel;
use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;
use Dompdf\Dompdf;
use Dompdf\Options as DompdfOptions;

require_once APPPATH . 'Libraries/dompdf/autoload.inc.php';

class ConstanciaController extends Controller
{
    use ResponseTrait;
    private $model;

    public function __construct()
    {
        $this->model = model(ConstanciaModel::class);
        helper('url');
    }

    public function index()
    {
        $escuelas = $this->model->getEscuelasProfesionales();
        $scripts = [
            'scripts' => [
                'plugins/custom/datatables/dtserverConstancias.js?v=7.1.6'
            ]
        ];
        $this->viewData('constancias/vista_principal', ['escuelas' => $escuelas], $scripts);
    }

    public function listar()
    {
        $draw = (int) $this->request->getVar('draw');
        $start = (int) $this->request->getVar('start');
        $length = (int) $this->request->getVar('length');
        $searchValue = $this->request->getVar('search')['value'];
        $expediente = $this->request->getVar('expediente');
        $escuela = $this->request->getVar('escuela');

        $datos = $this->model->getConstanciasServerSide($length, $start, $searchValue, $expediente, $escuela);
        $total = $this->model->getTotalConstancias($searchValue, $expediente, $escuela);

        return $this->respond([
            'draw' => $draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $datos
        ]);
    }

    public function generarPDF($codigoTramite, $codigoTipoConstancia)
    {
        $constancia = $this->model->getConstanciaByCodigo($codigoTramite, $codigoTipoConstancia);

        if (!$constancia) {
            echo "Constancia no encontrada.";
            exit();
        }

        $fecha = strtotime($constancia['FechaAtencion']);
        $meses = [
            "January" => "enero", "February" => "febrero", "March" => "marzo",
            "April" => "abril", "May" => "mayo", "June" => "junio", "July" => "julio",
            "August" => "agosto", "September" => "septiembre", "October" => "octubre",
            "November" => "noviembre", "December" => "diciembre"
        ];

        $mesEnEspanol = $meses[date("F", $fecha)];
        $fechaFormateada = date("d", $fecha) . " de " . $mesEnEspanol . " de " . date("Y", $fecha);

        $logoPath = FCPATH . 'img/logounsm.jpg';
        $logoBase64 = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logoPath));
        $backgroundBase64 = $logoBase64;

        $html = view('constancias/ver_constancia', compact('constancia', 'fechaFormateada', 'logoBase64', 'backgroundBase64'));

        $options = new DompdfOptions();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = ($constancia['CodigoAlumnoSira'] ?? 'Sin_Codigo') . ' - ' . str_replace(' ', '_', ($constancia['TipoConstancia'] ?? 'Constancia')) . '.pdf';
        $dompdf->stream($filename, ['Attachment' => false]);
        exit();
    }
}
