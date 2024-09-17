<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PersonaModel; // Asegúrate de tener el modelo PersonaModel

class PersonaController extends BaseController
{
    public function index()
    {
        // Instanciamos el modelo PersonaModel
        $personaModel = new PersonaModel();
        
        // Obtenemos todas las personas de la base de datos
        $personas = $personaModel->findAll();
        
        // Pasamos los datos a la vista
        return view('persona/list', ['personas' => $personas]);
    }
}

