<?php

namespace App\Models;
use CodeIgniter\Model; 

class MedidaModel extends Model
{
	protected $table      = 'tmedida';
	protected $primaryKey = 'nidmedida';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidmedida', 'snombremedida', 'bestado'];
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
	public function existe($nidmedida){
		return $this->where(['nidmedida' => $nidmedida])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getMedidas($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('tmedida t0');

		$builder->select("t0.nidmedida idmedida, t0.snombremedida nombremedida, t0.bestado estado, CONCAT(t0.snombremedida) concatenado, CONCAT(t0.snombremedida) concatenadodetalle");


		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidmedida', $text)
				->orLike('t0.snombremedida', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidmedida', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteMedidas($todos = 1, $text = ''){
		$builder = $this->conexion('tmedida t0');

		$builder->select("t0.nidmedida idmedida, t0.snombremedida nombremedida, t0.bestado estado, CONCAT(t0.snombremedida) concatenado, CONCAT(t0.snombremedida) concatenadodetalle");

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidmedida', $text)
				->orLike('t0.snombremedida', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidmedida', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

	public function getMedidasSelect2($todos = 1, $text = ''){
		$builder = $this->conexion('tmedida t0');
		$builder->select("t0.nidmedida idmedida, t0.snombremedida nombremedida, t0.bestado estado, CONCAT(t0.snombremedida) concatenado, CONCAT(t0.snombremedida) concatenadodetalle");
		$builder->where('t0.bestado', 1);
		$builder->orderBy('t0.nidmedida', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function getmedida($nidmedida){
		$builder = $this->conexion('tmedida t0');
		$builder->select("t0.nidmedida idmedida, t0.snombremedida nombremedida, t0.bestado estado");
		$builder->where(['nidmedida' => $nidmedida]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getMedida2($id){
		$builder = $this->conexion('tmedida t0');
		$builder->select("t0.nidmedida idmedida, t0.snombremedida nombremedida, t0.bestado estado");
		$builder->where('t0.nidmedida', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('tmedida t0');
		$builder->select('nidmedida');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidmedida', $text)
				->orLike('t0.snombremedida', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateMedida($nidmedida, $datos){
		$builder = $this->conexion('tmedida');
		$builder->where(['nidmedida' => $nidmedida]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('tmedida');
		$builder->selectMax('nidmedida');
		$query = $builder->get();
		return  $query->getResult()[0]->nidmedida;
	}
}
?>
