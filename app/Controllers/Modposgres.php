<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Modelposgres;

class Modposgres extends Controller
{

    public function index()
    {
        $modpos = new Modelposgres();
        $result = $modpos->getData();
        print_r($result);
        die();
    }
}
