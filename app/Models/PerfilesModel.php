<?php
namespace App\Models;
use CodeIgniter\Model;

class PerfilesModel extends Model{
	
  protected $table = 'perfil';
  protected $primaryKey = 'id_perfil';
  protected $returnType = 'array';
  protected $allowedFields = ['nombreperfil', 'estadoperfil'];

  public function getPerfiles(){
    return $this->db->table('perfil')
    ->where('estadoperfil', 1)
    ->orderBy('id_perfil', 'DESC')
    ->get()->getResultArray();
  }

  public function getPerfil($id){
    return $this->db->table('perfil')
    ->where('estadoperfil', 1)
    ->where('id_perfil', $id)
    ->get()->getResultArray();
  }

  public function getModulos(){
    return $this->db->table('modulo')
    ->where('estadomodulo', '1')
    ->orderBy('id_modulo', 'DESC')
    ->get()->getResultArray();
  }
  
  public function postPermisos($datos){
    return $this->db->table('permiso')
    ->insert($datos);
  }

  public function getPermisos(){
    return $this->db->table('permiso pe')
    ->join('modulo m','pe.idmodulo=m.id_modulo')
    ->where('pe.estadopermiso', 1)
    ->orderBy('id_permiso', 'ASC')
    ->get()->getResultArray();
  }

  public function getPermiso($id){
    return $this->db->table('permiso pe')
    // ->join('modulos m','pe.idmodulo_permiso=m.id_modulo')
    ->where('pe.estadopermiso', 1)
    ->where('idperfilpermiso', $id)
    ->get()->getResultArray();
  }

  public function delete_up_per($id){
    return $this->db->table('permiso')
    ->where('idperfilpermiso', $id)
    ->delete();
  }
  
  // }}}}}}}}}}}}}}}}}}}}}}}}}}}}}}}}}
  public function updateValidPer($id, $perfil){
    return $this->db->table('perfil')
    ->where('estadoperfil', 1)
    ->where('id_perfil!=', $id)
    ->where('nombreperfil', $perfil)
    ->get()->getResultArray();
  }




  public function validPerfil($nameperfil){
    return $this->db->table('perfil')
    // ->where('estadoperfil', 1)
    ->where('nombreperfil', $nameperfil)
    ->get()->getResultArray();
  }


}
