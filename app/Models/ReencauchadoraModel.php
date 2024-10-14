<?php

namespace App\Models;
use CodeIgniter\Model; 

class ReencauchadoraModel extends Model
{
	protected $table      = 'treencauchadora';
	protected $primaryKey = 'nidrencauchadora';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidrencauchadora', 'snombrereencauchadora', 'sdireccion', 'bestado'];
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
	public function existe($nidrencauchadora){
		return $this->where(['nidrencauchadora' => $nidrencauchadora])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getReencauchadoras($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('treencauchadora t0');

		$builder->select("t0.nidrencauchadora idrencauchadora, t0.snombrereencauchadora nombrereencauchadora, t0.sdireccion direccion, t0.bestado estado, CONCAT(t0.snombrereencauchadora) concatenado, CONCAT(t0.snombrereencauchadora) concatenadodetalle");


		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidrencauchadora', $text)
				->orLike('t0.snombrereencauchadora', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidrencauchadora', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteReencauchadoras($todos = 1, $text = ''){
		$builder = $this->conexion('treencauchadora t0');

		$builder->select("t0.nidrencauchadora idrencauchadora, t0.snombrereencauchadora nombrereencauchadora, t0.sdireccion direccion, t0.bestado estado, CONCAT(t0.snombrereencauchadora) concatenado, CONCAT(t0.snombrereencauchadora) concatenadodetalle");

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidrencauchadora', $text)
				->orLike('t0.snombrereencauchadora', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidrencauchadora', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function getreencauchadora($nidrencauchadora){
		$builder = $this->conexion('treencauchadora t0');
		$builder->select("t0.nidrencauchadora idrencauchadora, t0.snombrereencauchadora nombrereencauchadora, t0.sdireccion direccion, t0.bestado estado");
		$builder->where(['nidrencauchadora' => $nidrencauchadora]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getReencauchadora2($id){
		$builder = $this->conexion('treencauchadora t0');
		$builder->select("t0.nidrencauchadora idrencauchadora, t0.snombrereencauchadora nombrereencauchadora, t0.sdireccion direccion, t0.bestado estado");
		$builder->where('t0.nidrencauchadora', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('treencauchadora t0');
		$builder->select('nidrencauchadora');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidrencauchadora', $text)
				->orLike('t0.snombrereencauchadora', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateReencauchadora($nidrencauchadora, $datos){
		$builder = $this->conexion('treencauchadora');
		$builder->where(['nidrencauchadora' => $nidrencauchadora]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('treencauchadora');
		$builder->selectMax('nidrencauchadora');
		$query = $builder->get();
		return  $query->getResult()[0]->nidrencauchadora;
	}
}
?>
