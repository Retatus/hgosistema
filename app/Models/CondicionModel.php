<?php

namespace App\Models;
use CodeIgniter\Model; 

class CondicionModel extends Model
{
	protected $table      = 'tcondicion';
	protected $primaryKey = 'nidcondicion';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidcondicion', 'snombrecondicion', 'bestado'];
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
	public function existe($nidcondicion){
		return $this->where(['nidcondicion' => $nidcondicion])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getCondicions($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('tcondicion t0');

		$builder->select("t0.nidcondicion idcondicion, t0.snombrecondicion nombrecondicion, t0.bestado estado, CONCAT(t0.snombrecondicion) concatenado, CONCAT(t0.snombrecondicion) concatenadodetalle");


		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidcondicion', $text)
				->orLike('t0.snombrecondicion', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidcondicion', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteCondicions($todos = 1, $text = ''){
		$builder = $this->conexion('tcondicion t0');

		$builder->select("t0.nidcondicion idcondicion, t0.snombrecondicion nombrecondicion, t0.bestado estado, CONCAT(t0.snombrecondicion) concatenado, CONCAT(t0.snombrecondicion) concatenadodetalle");

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidcondicion', $text)
				->orLike('t0.snombrecondicion', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidcondicion', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function getcondicion($nidcondicion){
		$builder = $this->conexion('tcondicion t0');
		$builder->select("t0.nidcondicion idcondicion, t0.snombrecondicion nombrecondicion, t0.bestado estado");
		$builder->where(['nidcondicion' => $nidcondicion]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getCondicion2($id){
		$builder = $this->conexion('tcondicion t0');
		$builder->select("t0.nidcondicion idcondicion, t0.snombrecondicion nombrecondicion, t0.bestado estado");
		$builder->where('t0.nidcondicion', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('tcondicion t0');
		$builder->select('nidcondicion');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidcondicion', $text)
				->orLike('t0.snombrecondicion', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateCondicion($nidcondicion, $datos){
		$builder = $this->conexion('tcondicion');
		$builder->where(['nidcondicion' => $nidcondicion]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('tcondicion');
		$builder->selectMax('nidcondicion');
		$query = $builder->get();
		return  $query->getResult()[0]->nidcondicion;
	}
}
?>
