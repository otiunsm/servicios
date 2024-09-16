<?php

namespace App\Models;

use CodeIgniter\Model;

class ModulosModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'modulo';
    protected $primaryKey           = 'idmodulo';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = ['id_modulo', 'nombremodulo', 'urlmodulo', 'idmodulopadre'];

    // Dates
    protected $useTimestamps        = false;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';

    public function getModulos(){
         return $this->db->table('modulo m')
                        ->select('m.id_modulo, m.nombremodulo, m.urlmodulo, m.idmodulopadre, mp.nombremodulo AS nombremodulopadre, m.iconomodulo, m.estadomodulo')
                        ->join('modulo mp', 'm.idmodulopadre = mp.id_modulo', 'left')
                        ->where(['m.estadomodulo' => '1'])
                        ->get()
                        ->getResultArray();
    }

    public function getModulosPadres(){
         return $this->db->table('modulo m')
                        ->where('m.idmodulopadre', null)
                        ->get()
                        ->getResultArray();
    }

    public function getModulo($id){
        return $this->db->table('modulo m')
        // ->join('perfil pe', 'u.idperfil_usuario=pe.id_perfil')
        ->where(['m.estadomodulo' => '1', 'm.id_modulo' => $id])
        ->get()->getResultArray();
    }




}
