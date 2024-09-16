<?php
namespace App\Controllers;
use CodeIgniter\Controller;

class Apis extends Controller
{
    
    private static function CurlRequest($url)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ]);

        $response = curl_exec($curl);
        
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            curl_close($curl);
            throw new Exception("cURL Error: $error_msg");
        }
        
        curl_close($curl);
        return $response;
    }
    
    public static function curl_api_reniec($dni)
    {
        $url = 'http://soporte.unsm.edu.pe/wsdl/wsdl_reniec.php?dni=' . $dni;
        
        $response = self::CurlRequest($url);
    
        $response = mb_convert_encoding($response, 'UTF-8', 'Windows-1251');
    
        $nopermitidas = ["&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;", "&Aacute;", "&Eacute;", "&Iacute;", "&Oacute;", "&Uacute;", "&ntilde;", "&Ntilde;"];
        $permitidos = ["á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "ñ", 'Ñ'];
    
        $datos = json_decode($response, true);
    
        if (isset($datos["result"][0])) {
            $datos["result"][0]["apPrimer"] = str_replace($nopermitidas, $permitidos, $datos["result"][0]["apPrimer"]);
            $datos["result"][0]["apSegundo"] = str_replace($nopermitidas, $permitidos, $datos["result"][0]["apSegundo"]);
            $datos["result"][0]["direccion"] = str_replace($nopermitidas, $permitidos, $datos["result"][0]["direccion"]);
            $datos["result"][0]["prenombres"] = str_replace($nopermitidas, $permitidos, $datos["result"][0]["prenombres"]);
        }
        return $datos;
    }

    public static function curl_api_boleta($dni, $periodo)
    {
        $dni = str_replace(' ', '%20', $dni);

        if (session()->get('idperfil') && session()->get('idperfil') != '1') {
            $dni = session()->get('user_dni');
        }

        $url = "http://209.45.90.243/apiplanilla/resultados/searchboleta.php?dni=" . $dni . "&per=" . $periodo;
        
        return self::CurlRequest($url);
    }
    public static function curl_api_cafae($dni, $periodo)
    {
        $dni = str_replace(' ', '%20', $dni);

        if (session()->get('perfil') && session()->get('idperfil') != '1') {
            $dni = session()->get('user_dni');
        }

        $url = "http://209.45.90.243/apiplanilla/resultados/searchboletacafae.php?dni=" . $dni . "&per=" . $periodo;
        return self::CurlRequest($url);
    }
    public function curl_api_tesoreria($dni_name)
    {
        $dni_name = str_replace(' ', '%20', $dni_name);

        $url = 'http://209.45.90.243/apipagos/resultados/searchpagoscliente.php?id=' . $dni_name;
        return self::CurlRequest($url);
    }
    public static function curl_api_ruc($ruc, $opcion)
    {
        $url = 'http://soporte.unsm.edu.pe/wsdl/wsdl_sunat.php?ruc=' . $ruc . '&opcion=' . $opcion;
        return self::CurlRequest($url);
    }
    public static function curl_personal_planilla($dni)
    {
        $url = 'http://209.45.90.243/apiplanilla/resultados/personal.php?dni=' . $dni;
        return self::CurlRequest($url);
    }
    public function api_personal()
    {
        if ($this->request->isAjax()) {
            $dni = $this->request->getVar('dni');

            $datos = $this->curl_personal_planilla($dni);
            return json_encode($datos);
        } else {
            $dni = null;
            return json_encode($dni);
        }
    }
    public function apis_reniec()
    {
        if ($this->request->isAjax()) {
            $dni = $this->request->getVar('dni_consult');
            $datos = $this->curl_api_reniec($dni);
            return json_encode($datos, JSON_UNESCAPED_UNICODE);
        } else {
            return redirect()->to(base_url('/consultas/dni'));
        }
    }
    public function apis_tesoreria()
    {
        if ($this->request->isAjax()) {
            $dni_name = $this->request->getVar('dni_consult');
            $response = $this->curl_api_tesoreria($dni_name);
            return $response;
        } else {
            return redirect()->to(base_url('/consultas/tesoreria'));
        }
    }
    public function apis_boletapago()
    {
        if ($this->request->isAjax()) {
            $dni = $this->request->getVar('dni_boletapago');
            $periodo = $this->request->getVar('periodo_boletapago');
            $response = $this->curl_api_boleta($dni, $periodo);
            return $response;
        } else {
            return redirect()->to(base_url('/consultas/boletapago'));
        }
    }
    public function apis_boletacafae()
    {
        if ($this->request->isAjax()) {
            $dni = $this->request->getVar('dni_boletacafae');
            $periodo = $this->request->getVar('periodo_boletacafae');
            $response = $this->curl_api_cafae($dni, $periodo);
            return $response;
        } else {
            return redirect()->to(base_url('/consultas/boletacafae'));
        }
    }

    public function apis_ruc()
    {
        if ($this->request->isAjax()) {
            $ruc = $this->request->getVar('ruc_consult');
            $opcion = $this->request->getVar('opcion');
            $response = $this->curl_api_ruc(trim($ruc), $opcion);
            return $response;
        } else {
            return redirect()->to(base_url('/consultas/ruc'));
        }
    }
    public static function curl_api_antecedentes_policiales($typeDoc, $dni)
    {
        $url = 'http://soporte.unsm.edu.pe/wsdl/wsdl_antecedentespoliciales.php?typeDoc=' . $typeDoc . '&dni=' . $dni;
        return self::CurlRequest($url);
    }
    public function apis_antecedentes_policiales()
    {
        if ($this->request->isAjax()) {
            $typeDoc = $this->request->getVar('typeDoc');
            $dni = $this->request->getVar('dni');
            $response = $this->curl_api_antecedentes_policiales($typeDoc, $dni);
            return $response;
        } else {
            return redirect()->to(base_url('/consultas/antecedentespoliciales'));
        }
    }
    public function activar_convenio_reniec()
    {
        $url = 'http://soporte.unsm.edu.pe/wsdl/wsdl_actualizarcredenciales.php?dni=43698668';
        return self::CurlRequest($url);
    }
}