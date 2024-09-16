<?php  
namespace App\Models;
use CodeIgniter\Model;

class AutomatizarModel extends Model{
	protected $table            = 'automatizar';
	protected $primaryKey       = 'idautomatizar';
	protected $useAutoIncrement = true;
	protected $returnType       = 'array';
	protected $allowedFields    = ['descripcionautomatizar', 'fechaautomatizar','estadoautomatizar'];

	public function getFechaActivacion(){
		return $this->db->table( 'automatizar' )
		->where( 'idautomatizar', '1' )
		->get()->getResultArray();
	}
}
