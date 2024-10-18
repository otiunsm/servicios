<?php  
namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model{
	protected $table            = 'usuario';
	protected $primaryKey       = 'id_usuario';
	protected $useAutoIncrement = true;
	protected $returnType       = 'array';
	protected $allowedFields    = ['nombre', 'idarea','apellido','usuario','clave','estado','dni','telefono','idperfil_usuario','correo','direccion','estado_clave', 'fecha_clave'];
	
	protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

	public function getUsuarios(){
		return $this->db->table('usuario u')
		->join('perfil pe', 'u.idperfil_usuario=pe.id_perfil')
		->join('act_area ar', 'u.idarea = ar.idarea') // Unión con la tabla 'area'
		->where('u.estado','1')
		->orderBy('id_usuario', 'DESC')
		->get()->getResultArray();
	}

	public function getUsuario($id){
		return $this->db->table('usuario u')
		->join('perfil pe', 'u.idperfil_usuario=pe.id_perfil')
		->where(['u.estado' => '1', 'u.id_usuario' => $id])
		->get()->getResultArray();
	}
	
	

	public function session_valid($usuario,$clave){
		return $this->db->table('usuario u')
		->join('perfil pe', 'u.idperfil_usuario=pe.id_perfil')
		->where(["u.estado" => '1', "u.usuario" => $usuario,"u.clave" => $clave])
		->get()->getResultArray();
	}
	
		public function user_exists($usuario){
		return $this->db->table('usuario u')
		->join('perfil pe', 'u.idperfil_usuario=pe.id_perfil')
		->where(["u.estado" => '1', "u.usuario" => $usuario])
		->get()->getResultArray();
	}

	public function get_mod($id_perfil,$id_usuario){
	    $this->actualizarUltimoLogin($id_usuario);
		return $this->db->table('permiso p')
		->join('modulo m', 'm.id_modulo=p.idmodulo')
		->where(['p.idperfilpermiso' => $id_perfil])
		->orderBy('idmodulo', 'ASC')
		->get()->getResultArray();
	}
	
	  public function actualizarUltimoLogin($id)
    {
        $this->db->table('usuario')->where('id_usuario', $id)
            ->set('ultimo_login', date('Y-m-d H:i:s'))
            ->update();
    }

	public function get_perfiles(){
		return $this->db->table('perfil')
		->where('estadoperfil', '1')
		->orderBy('id_perfil', 'DESC')
		->get()->getResultArray();
	}
	

	public function valid_usuario($id, $usuario){
		$query = $this->db->table('usuario')
		->where('usuario', $usuario)
		->where('estado', 1);
		if ($id != null) {
			$query->where('id_usuario!=', $id);
		}
		return $query->get()->getResultArray();
	}
}
