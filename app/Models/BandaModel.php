<?php

namespace App\Models;
use CodeIgniter\Model; 

class BandaModel extends Model
{
	protected $table      = 'tbanda';
	protected $primaryKey = 'nidbanda';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidbanda', 'snombrebanda', 'smarca', 'bestado'];
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
	public function existe($nidbanda){
		return $this->where(['nidbanda' => $nidbanda])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getBandas($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('tbanda t0');

		$builder->select("t0.nidbanda idbanda, t0.snombrebanda nombrebanda, t0.smarca marca, t0.bestado estado, CONCAT(t0.snombrebanda) concatenado, CONCAT(t0.snombrebanda) concatenadodetalle");


		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidbanda', $text)
				->orLike('t0.snombrebanda', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidbanda', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteBandas($todos = 1, $text = ''){
		$builder = $this->conexion('tbanda t0');

		$builder->select("t0.nidbanda idbanda, t0.snombrebanda nombrebanda, t0.smarca marca, t0.bestado estado, CONCAT(t0.snombrebanda) concatenado, CONCAT(t0.snombrebanda) concatenadodetalle");

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidbanda', $text)
				->orLike('t0.snombrebanda', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidbanda', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

	public function getBandasSelect2(){
		$builder = $this->conexion('tbanda t0');
		$builder->select("t0.nidbanda idbanda, t0.snombrebanda nombrebanda, t0.smarca marca, t0.bestado estado, CONCAT(t0.snombrebanda) concatenado, CONCAT(t0.snombrebanda) concatenadodetalle");
		$builder->where('t0.bestado', 1);
		$builder->orderBy('t0.nidbanda', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function getbanda($nidbanda){
		$builder = $this->conexion('tbanda t0');
		$builder->select("t0.nidbanda idbanda, t0.snombrebanda nombrebanda, t0.smarca marca, t0.bestado estado");
		$builder->where(['nidbanda' => $nidbanda]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getBanda2($id){
		$builder = $this->conexion('tbanda t0');
		$builder->select("t0.nidbanda idbanda, t0.snombrebanda nombrebanda, t0.smarca marca, t0.bestado estado");
		$builder->where('t0.nidbanda', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('tbanda t0');
		$builder->select('nidbanda');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidbanda', $text)
				->orLike('t0.snombrebanda', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateBanda($nidbanda, $datos){
		$builder = $this->conexion('tbanda');
		$builder->where(['nidbanda' => $nidbanda]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('tbanda');
		$builder->selectMax('nidbanda');
		$query = $builder->get();
		return  $query->getResult()[0]->nidbanda;
	}
}
?>
