<?php

namespace App\Controllers;
use CodeIgniter\Controller;

class Consultas extends Controller{
        
    public function dni(){
        $scripts = [
            'scripts'=>['js/form_consulta.js?v=7.1.6', 'plugins/custom/qrcode/jquery.classyqr.js?v=7.1.6'],
        ];
        $data = [];
        return $this->ViewData('modulos/consultapide', $data, $scripts);
    }
    
    public function tesoreria(){
        $scripts = [
            'scripts'=>['plugins/custom/qrcode/jquery.classyqr.js?v=7.1.6', 'js/tesoreria.js?v=7.1.6'],
        ];
        $data = [];
        return $this->ViewData( 'modulos/consultatesoreria', $data, $scripts );
    }

    public function boletapago(){
        $scripts = [
            'scripts'=>[
                        '/plugins/custom/qrcode/jquery.classyqr.js?v=7.1.6',
                        '/js/boletapago.js?v=7.1.6'
                    ],
        ];
        $data = [];
        return $this->ViewData( 'modulos/consultaboletapago', $data, $scripts);
    }
    
        public function boletacafae(){
             $scripts = [
            'scripts'=>[
                        '/plugins/custom/qrcode/jquery.classyqr.js?v=7.1.6',
                        '/js/boletacafae.js'
                    ],
        ];
        $data = [];
        return $this->ViewData( 'modulos/consultaboletacafae', $data, $scripts);
    }

    public function ruc(){
        $scripts = [
            'scripts'=>['js/form_consulta.js?v=7.1.6', 'plugins/custom/qrcode/jquery.classyqr.js?v=7.1.6'],
        ];
        $data = [];
        return $this->ViewData( 'modulos/consultaruc', $data, $scripts );
    }
    
    public function antecedentespoliciales(){
 $scripts = [
            'scripts'=>['js/form_consulta.js?v=7.1.6', 'plugins/custom/qrcode/jquery.classyqr.js?v=7.1.6', 'js/antecedentes_policiales.js?v=7.1.6'],
        ];
        $data = [];
        return $this->ViewData( 'modulos/consultaantecedentespoliciales', $data , $scripts);
    }
}
