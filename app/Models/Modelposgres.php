<?php

namespace App\Models;

use CodeIgniter\Model;

class Modelposgres extends Model
{
    protected $DBGroup              = 'connps';
    protected $table                = 'bytsscom_bytsiaf.expediente_fase';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = [];

    public function getData(){
        return $this->db->table('bytsscom_bytsiaf.expediente_fase')->limit(1)->get()->getResultArray();
    }

}
