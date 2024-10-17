<?php

namespace App\Models;
use CodeIgniter\Model; 

class ReencauchadoraModel extends Model
{
	protected $table      = 'treencauchadora';
	protected $primaryKey = 'nidreencauchadora';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidreencauchadora', 'snombrereencauchadora', 'sdireccion', 'bestado'];
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
	public function existe($nidreencauchadora){
		return $this->where(['nidreencauchadora' => $nidreencauchadora])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getReencauchadoras($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('treencauchadora t0');

		$builder->select("t0.nidreencauchadora idreencauchadora, t0.snombrereencauchadora nombrereencauchadora, t0.sdireccion direccion, t0.bestado estado, CONCAT(t0.snombrereencauchadora) concatenado, CONCAT(t0.snombrereencauchadora) concatenadodetalle");


		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidreencauchadora', $text)
				->orLike('t0.snombrereencauchadora', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidreencauchadora', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteReencauchadoras($todos = 1, $text = ''){
		$builder = $this->conexion('treencauchadora t0');

		$builder->select("t0.nidreencauchadora idreencauchadora, t0.snombrereencauchadora nombrereencauchadora, t0.sdireccion direccion, t0.bestado estado, CONCAT(t0.snombrereencauchadora) concatenado, CONCAT(t0.snombrereencauchadora) concatenadodetalle");

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidreencauchadora', $text)
				->orLike('t0.snombrereencauchadora', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidreencauchadora', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function getreencauchadora($nidreencauchadora){
		$builder = $this->conexion('treencauchadora t0');
		$builder->select("t0.nidreencauchadora idreencauchadora, t0.snombrereencauchadora nombrereencauchadora, t0.sdireccion direccion, t0.bestado estado");
		$builder->where(['nidreencauchadora' => $nidreencauchadora]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getReencauchadora2($id){
		$builder = $this->conexion('treencauchadora t0');
		$builder->select("t0.nidreencauchadora idreencauchadora, t0.snombrereencauchadora nombrereencauchadora, t0.sdireccion direccion, t0.bestado estado");
		$builder->where('t0.nidreencauchadora', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('treencauchadora t0');
		$builder->select('nidreencauchadora');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidreencauchadora', $text)
				->orLike('t0.snombrereencauchadora', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateReencauchadora($nidreencauchadora, $datos){
		$builder = $this->conexion('treencauchadora');
		$builder->where(['nidreencauchadora' => $nidreencauchadora]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('treencauchadora');
		$builder->selectMax('nidreencauchadora');
		$query = $builder->get();
		return  $query->getResult()[0]->nidreencauchadora;
	}
}
?>
