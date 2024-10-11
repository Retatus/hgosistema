<?php 

namespace App\Models;
use CodeIgniter\Model; 

class UsuarioModel extends Model
{
	protected $table      = 'tusuario';
	protected $primaryKey = 'sidusuario';

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['sidusuario','snombreusuario'];
	protected $useTimestamps = false;
	protected $createdField  = 'tfecha_alt';
	protected $updatedField  = 'tfecha_edi';
	protected $deletedField  = 'deleted_at';

	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = false;

	protected function conexion(string $table = null){
		$this->db = \Config\Database::connect();
		$this->builder = $this->db->table($table);
		return $this->builder;
	}

	public function existe($id){
		return $this->where(['sidusuario' => $id])->countAllResults();
	}

	public function getUsuarios($todos = 1, $text = '', $total, $pag = 1){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;
		$builder = $this->conexion('tusuario t0');
		$builder->select("t0.sidusuario idusuario, t0.snombreusuario nombreusuario,  CONCAT(t0.snombreusuario) as concatenado, CONCAT(t0.snombreusuario) as concatenadodetalle");

		if ($todos !== '') 

		$builder->like('t0.sidusuario', $text);
		$builder->orLike('t0.snombreusuario', $text);

		$builder->orderBy('t0.sidusuario', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getAutocompleteusuarios($todos = 1, $text = ''){
		$builder = $this->conexion('tusuario t0');
		$builder->select("t0.sidusuario idusuario, t0.snombreusuario nombreusuario,  CONCAT(t0.snombreusuario) as concatenado, CONCAT(t0.snombreusuario) as concatenadodetalle");

		if ($todos !== '') 

		$builder->like('t0.sidusuario', $text);
		$builder->orLike('t0.snombreusuario', $text);

		$builder->orderBy('t0.sidusuario', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getUsuario($sidusuario){
		$builder = $this->conexion('tusuario t0');
		$builder->select("t0.sidusuario idusuario, t0.snombreusuario nombreusuario");
		$builder->where(['sidusuario' => $sidusuario]);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getUsuario2($id){
		$builder = $this->conexion('tusuario t0');
		$builder->select(" t0.sidusuario idusuario0, t0.snombreusuario nombreusuario0,");

		$builder->where('t0.nidreserva', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}


	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('tusuario t0');
		$builder->select('sidusuario');

		if ($todos !== '')

		$builder->like('t0.sidusuario', $text);
		$builder->orLike('t0.snombreusuario', $text);

		return $builder->countAllResults();
	}

	public function UpdateUsuario($sidusuario, $datos){
		$builder = $this->conexion('tusuario');
		$builder->where(['sidusuario' => $sidusuario]);
		$builder->set($datos);
		$builder->update();
	}

	public function getMaxid(){
		$builder = $this->conexion('tusuario');
		$builder->selectMax('sidusuario');
		$query = $builder->get();
		return  $query->getResult()[0]->sidusuario;
	}
}
?>
