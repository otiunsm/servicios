<?php

namespace App\Controllers;
use CodeIgniter\Controller;

use App\Controllers\Apis;
use Mpdf\QrCode\QrCode;
use Mpdf\QrCode\Output;


//require_once APPPATH . 'Libraries/vendor/autoload.php';           //se comento esto
// require_once APPPATH . 'Libraries/vendor2/autoload.php'; 

require_once ROOTPATH . 'vendor/autoload.php';
/**
 * Funciones para la generacion de pdf's de los distintos modulos
 */
class Pdfreporte extends Controller
{
    public function __construct()
    {
        $this->mpdf = new \Mpdf\Mpdf(['format' => 'A4', 'margin_top' => 1, 'margin_bottom' => 1]);
        $this->api = new Apis();
        $this->request = \Config\Services::request();
    }

    /**
     * Crea el PDF para reporte de consulta por DNI de una persona
     * 
     * @return void | redirect
     */
    public function reporte_dni()
    {
        $dni = $_POST['dni'];
        $datos = Apis::curl_api_reniec($dni);
        $datos = $datos['result'][0];

        if ($datos['coResultado'] !== 1000) // Codigo de error de la API
        {
            $datos['dni'] = $dni;
            $datos['foto'] = 'data:image/jpg;base64,' . $datos['foto'];
            $archivo = 'Reporte - '.$dni.'.pdf';
            $plantilla = view('plantillaPdf/reporte_dni', ['datos' => $datos]);
            // TODO: Verificar si se tiene permiso para acceder a la carpeta
            // $css = file_get_contents(base_url() . '/public/css/plantillaPdf/milligram.css');

            $this->mpdf->WriteHTML(base_url() . '/public/css/plantillaPdf/milligram.css', 1);
            $this->mpdf->WriteHTML($plantilla);
            $this->mpdf->Output($archivo, 'I');
            exit();
        }
        else
        {
            session()->setFlashdata('AlertShow', ['Tipo' => 'error', 'Mensaje' => $datos['deResultado']]);
            return redirect()->to(base_url('/consultas/dni'));
        }
    }

    public function reporte_boleta($boleta, $dni, $fecha){
        $fecha = explode('-', $fecha);
        $datos = Apis::curl_api_boleta($dni, $fecha[2]);
        $datos = json_decode($datos, true);
        if ($datos && isset($datos['results'])) {
            foreach ($datos['results'] as $key => $data) {
                if ($data['codplanillaperiodo'] == $boleta) {
                    // var_dump($data['0']['rem']);
                    

                    // Save black on white PNG image 100px wide to filename.png
                    // return view('plantillaPdf/reporte_boleta', ['Datos' => $data]); 
                    $page = $this->request->uri->getPath();
                    $qrCode = new QrCode(base_url().'/'.$page);
                    $output = new Output\Png();
                    // Save black on white PNG image 100px wide to filename.png
                    $output->output($qrCode, 150, [255, 255, 255], [0, 0, 0], 'filename.png');
                    $plantilla = view('plantillaPdf/reporte_boleta', ['Datos' => $data, 'FechaReporte' => $this->getDateTime()]);
                    // $css = file_get_contents(base_url() . '/public/css/plantillaPdf/planilla.css',  \Mpdf\HTMLParserMode::HEADER_CSS);
                    // $this->mpdf->WriteHTML($css);
                    $this->mpdf->WriteHTML(base_url() . '/public/css/plantillaPdf/planilla.css', 1);
                    $this->mpdf->WriteHTML($plantilla);
                    $this->mpdf->Output('Boleta_Pago_Planilla_'.$boleta.'-'.$dni.'.pdf', 'I');
                    exit();
                }
            }
        }else{
            return redirect()->to(base_url()."/");
        }
    }
    
    
    public function reporte_cafae($boleta, $dni, $fecha){
        $fecha = explode('-', $fecha);
        $datos = Apis::curl_api_cafae($dni, $fecha[2]);
        $datos = json_decode($datos, true);
        if ($datos && isset($datos['results'])) {
            foreach ($datos['results'] as $key => $data) {
                if ($data['coddocumento'] == $boleta) {
                    // var_dump($data['0']['rem']);
                    

                    // Save black on white PNG image 100px wide to filename.png
                    // return view('plantillaPdf/reporte_boleta', ['Datos' => $data]); 
                    $page = $this->request->uri->getPath();
                    $qrCode = new QrCode(base_url().'/'.$page);
                    $output = new Output\Png();
                    // Save black on white PNG image 100px wide to filename.png
                    $output->output($qrCode, 150, [255, 255, 255], [0, 0, 0], 'filename.png');
                    $plantilla = view('plantillaPdf/reporte_cafae', ['Datos' => $data, 'FechaReporte' => $this->getDateTime()]);
                    // $css = file_get_contents(base_url() . '/public/css/plantillaPdf/planilla.css',  \Mpdf\HTMLParserMode::HEADER_CSS);
                    // $this->mpdf->WriteHTML($css);
                    $this->mpdf->WriteHTML(base_url() . '/public/css/plantillaPdf/planilla.css', 1);
                    $this->mpdf->WriteHTML($plantilla);
                    $this->mpdf->Output('Boleta_Pago_Cafae_'.$boleta.'-'.$dni.'.pdf', 'I');
                    exit();
                }
            }
        }else{
            return redirect()->to(base_url()."/");
        }
    }
    
    

    public function reporte_tesoreria($dni, $num_opera){
        $datos= $this->api->curl_api_tesoreria($dni);
        $datos = json_decode($datos, true);
        if ($datos && isset($datos['results'])) {
            $datos_array = [];
            foreach ($datos['results'] as $key => $tesoro) {
                if ($tesoro['nrooperacion'] == $num_opera) {
                    array_push($datos_array, $tesoro);
                }
            }
            if ($datos_array) {
                // var_dump($datos_array);
                $page = $this->request->uri->getPath();
                $qrCode = new QrCode(base_url().'/'.$page);
                $output = new Output\Png();
                // Save black on white PNG image 100px wide to filename.png
                $output->output($qrCode, 150, [255, 255, 255], [0, 0, 0], 'filename2.png');
                // return view('plantillaPdf/reporte_tesoreria', ['Datos' => $datos_array]);
                $plantilla = view('plantillaPdf/reporte_tesoreria',  ['Datos' => $datos_array]);
                $this->mpdf->WriteHTML(base_url() . '/public/css/plantillaPdf/planilla.css', 1);
                $this->mpdf->WriteHTML($plantilla);
                $this->mpdf->Output('Boleta - '.$datos_array[0]['numerocomprobante'].' - '.$dni.'.pdf', 'I');
                exit();
            }
            else{
                return redirect()->to(base_url()."/");
            }
        }else{
            return redirect()->to(base_url()."/");
        }
    }
    
    public function pdf_manual(){
            if(!session()->get( 'idperfil' )){
                return redirect()->to(base_url());
            }
            
            $filename = 'MANUAL DE ADMINISTRADOR.pdf';
            if(session()->get( 'idperfil' ) != '1' ){
                $filename = 'MANUAL DE USUARIO.pdf';
            }
        header('Content-type: application/force-download');
        header('Content-Disposition: attachment; filename='.$filename);
        readfile($filename);
        exit();
    }
    
    public function reporte_antecedentespoliciales( $typeDoc, $doc )
    {
        $Permisos = session()->get( 'Modulos' );
        $dataSave = [];
        foreach ($Permisos as $key => $value) {
                    $dataSave[] = $value[ 'urlmodulo' ];
                }
        if( in_array( '/consultas/antecedentespoliciales', $dataSave ) || $typeDoc == "" || $doc == "" ){
            $datos = Apis::curl_api_antecedentes_policiales($typeDoc,$doc);
            $datos = json_decode( $datos, true );
            $datos = $datos[ 'consultarPersonaNroDocResponse' ][ 'RespuestaPersona' ];

            if( isset( $datos[ '0' ] ) ){
                $datos = $datos[ '0' ];
            }

            if ( $datos[ 'codigoMensaje' ] == '00') // Codigo de error de la API
            {
                $archivo = 'Reporte - '.$doc.'-'.$typeDoc.'.pdf';
                $plantilla = view('plantillaPdf/reporte_antecedentespoliciales', ['datos' => $datos]);
                // TODO: Verificar si se tiene permiso para acceder a la carpeta
                // $css = file_get_contents(base_url() . '/public/css/plantillaPdf/milligram.css');

                $this->mpdf->WriteHTML(base_url() . '/public/css/plantillaPdf/milligram.css', 1);
                $this->mpdf->WriteHTML($plantilla);
                $this->mpdf->Output($archivo, 'I');
                exit();
            }
            else
            {
                session()->setFlashdata('AlertShow', ['Tipo' => 'error', 'Mensaje' => $datos['descripcionMensaje']]);
                return redirect()->to(base_url('/consultas/antecedentespoliciales'));
            }
        }
        else{
            return redirect()->to(base_url('/'));
        }
        
    }

    public function reporte_ruc(){
        if($this->request->getMethod() != 'post'){
            return redirect()->to(base_url('/consultas/ruc'));
        }
        $datos = $this->api->curl_api_ruc($_POST['ruc_number'], $_POST['opcion_print']);
        $data = json_decode($datos, true);
        $_POST['ruc_number'];
        switch ($_POST['opcion_print']) {
            case 'DatosPrincipales':
                    $result = $data;
                    // var_dump($result);die;
                break;
            case 'DatosSecundarios':
                    $result = $data;
                break;
            case 'DatosT1144':
                    $result = $data;
                break;
            case 'DatosT362':
                    $result = $data;
                break;
            case 'DomicilioLegal':
                    $result = $data;
                break;
            case 'RepLegales':
                    $result = $data;
                break;
            default:
                return redirect()->to(base_url('/consultas/ruc'));
                break;
        }
        
        $archivo = 'Reporte - '.$_POST['ruc_number'].'.pdf';
        $plantilla = view('plantillaPdf/reporte_ruc', ['ruc' => $_POST['ruc_number'], 'result' => $result, 'Fecha' => $this->getDateTime()]);
        $this->mpdf->WriteHTML($plantilla);
        $this->mpdf->Output($archivo, 'I');
        exit();
    }
}
