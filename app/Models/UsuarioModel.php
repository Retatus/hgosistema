<?php

namespace App\Models;
use CodeIgniter\Model; 

class UsuarioModel extends Model
{
	protected $table      = 'tusuario';
	protected $primaryKey = 'sidusuario';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['sidusuario', 'snombreusuario', 'bestado'];
	protected $useTimestamps = false;
	protected $createdField  = 'tfecha_alt';
	protected $updatedField  = 'tfecha_edi';
	protected $deletedField  = 'deleted_at';

	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = false;

//   SECCION ====== CONEXION ======
	protected function conexion(string $table = null){
		$this->db = \Config\Database::connect();
		$this->builder = $this->db->table($table);
		return $this->builder;
	}

//   SECCION ====== EXISTE ======
	public function existe($sidusuario){
		return $this->where(['sidusuario' => $sidusuario])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getUsuarios($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('tusuario t0');

		$builder->select("t0.sidusuario idusuario, t0.snombreusuario nombreusuario, t0.bestado estado, CONCAT(t0.snombreusuario) concatenado, CONCAT(t0.snombreusuario) concatenadodetalle");


		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.sidusuario', $text)
				->orLike('t0.snombreusuario', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.sidusuario', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteUsuarios($todos = 1, $text = ''){
		$builder = $this->conexion('tusuario t0');

		$builder->select("t0.sidusuario idusuario, t0.snombreusuario nombreusuario, t0.bestado estado, CONCAT(t0.snombreusuario) concatenado, CONCAT(t0.snombreusuario) concatenadodetalle");

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.sidusuario', $text)
				->orLike('t0.snombreusuario', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.sidusuario', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function getusuario($sidusuario){
		$builder = $this->conexion('tusuario t0');
		$builder->select("t0.sidusuario idusuario, t0.snombreusuario nombreusuario, t0.bestado estado");
		$builder->where(['sidusuario' => $sidusuario]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getUsuario2($id){
		$builder = $this->conexion('tusuario t0');
		$builder->select("t0.sidusuario idusuario, t0.snombreusuario nombreusuario, t0.bestado estado");
		$builder->where('t0.sidusuario', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('tusuario t0');
		$builder->select('sidusuario');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.sidusuario', $text)
				->orLike('t0.snombreusuario', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateUsuario($sidusuario, $datos){
		$builder = $this->conexion('tusuario');
		$builder->where(['sidusuario' => $sidusuario]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('tusuario');
		$builder->selectMax('sidusuario');
		$query = $builder->get();
		return  $query->getResult()[0]->sidusuario;
	}
}
?>
