<?php

namespace App\Models;
use CodeIgniter\Model; 

class NeumaticoModel extends Model
{
	protected $table      = 'tneumatico';
	protected $primaryKey = 'nidneumatico';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidneumatico', 'snombreneumatico', 'bestado'];
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
	public function existe($nidneumatico){
		return $this->where(['nidneumatico' => $nidneumatico])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getNeumaticos($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('tneumatico t0');

		$builder->select("t0.nidneumatico idneumatico, t0.snombreneumatico nombreneumatico, t0.bestado estado, CONCAT(t0.snombreneumatico) concatenado, CONCAT(t0.snombreneumatico) concatenadodetalle");


		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidneumatico', $text)
				->orLike('t0.snombreneumatico', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidneumatico', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteNeumaticos($todos = 1, $text = ''){
		$builder = $this->conexion('tneumatico t0');

		$builder->select("t0.nidneumatico idneumatico, t0.snombreneumatico nombreneumatico, t0.bestado estado, CONCAT(t0.snombreneumatico) concatenado, CONCAT(t0.snombreneumatico) concatenadodetalle");

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidneumatico', $text)
				->orLike('t0.snombreneumatico', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidneumatico', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function getneumatico($nidneumatico){
		$builder = $this->conexion('tneumatico t0');
		$builder->select("t0.nidneumatico idneumatico, t0.snombreneumatico nombreneumatico, t0.bestado estado");
		$builder->where(['nidneumatico' => $nidneumatico]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getNeumatico2($id){
		$builder = $this->conexion('tneumatico t0');
		$builder->select("t0.nidneumatico idneumatico, t0.snombreneumatico nombreneumatico, t0.bestado estado");
		$builder->where('t0.nidneumatico', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('tneumatico t0');
		$builder->select('nidneumatico');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidneumatico', $text)
				->orLike('t0.snombreneumatico', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateNeumatico($nidneumatico, $datos){
		$builder = $this->conexion('tneumatico');
		$builder->where(['nidneumatico' => $nidneumatico]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('tneumatico');
		$builder->selectMax('nidneumatico');
		$query = $builder->get();
		return  $query->getResult()[0]->nidneumatico;
	}
}
?>
