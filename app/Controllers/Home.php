<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\AutomatizarModel;
use App\Controllers\Apis;

class Home extends Controller{
    public function index(){
        $automatizar = new AutomatizarModel();
        $automatizar2 = $automatizar->getFechaActivacion();
        $automatizar2 = $automatizar2[ '0' ][ 'fechaautomatizar' ];
        $fechaActual = Date( 'Y-m-d' );
        $apis = new Apis();
        if( date( "Y-m-d", strtotime($fechaActual."- 14 days") ) >= $automatizar2 ){
            $apis->activar_convenio_reniec();
            $data = [ "fechaautomatizar" => $fechaActual ];
            $automatizar->set( $data )->where( 'idautomatizar', 1 )->update();
        }
        $scripts = [
            'scripts'=>['js/form_consulta.js?v=7.1.6', 'js/form_user.js?v=7.1.6'],
        ];
        $data = [];
        return $this->ViewData('index', $data, $scripts);
    }
}
