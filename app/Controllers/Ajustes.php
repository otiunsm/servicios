<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Ajustes extends Controller
{
    public function index()
    {

        $view = 'ajustes';
        $data = [];
        $scripts = [ 'scripts'=>['js/ajustes.js']];

        echo view('includes/header');
        echo view('includes/menu');
        echo view($view, $data);
        echo view('includes/footer', $scripts);
    }


    public function activar_convenio_reniec()
    {
         $url = 'http://soporte.unsm.edu.pe/wsdl/wsdl_actualizarcredenciales.php?dni=43698668';
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ]);
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($httpCode === 200) {
            return $response; 
        } else {
            return "Error: HTTP Status Code {$httpCode}";
        }
    }

}
