<?php

namespace App\Models;
use CodeIgniter\Model; 

class UbicacionModel extends Model
{
	protected $table      = 'tubicacion';
	protected $primaryKey = 'nidubicacion';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidubicacion', 'snombretipoubicacion', 'bestado'];
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
	public function existe($nidubicacion){
		return $this->where(['nidubicacion' => $nidubicacion])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getUbicacions($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('tubicacion t0');

		$builder->select("t0.nidubicacion idubicacion, t0.snombretipoubicacion nombretipoubicacion, t0.bestado estado, CONCAT(t0.snombretipoubicacion) concatenado, CONCAT(t0.snombretipoubicacion) concatenadodetalle");


		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidubicacion', $text)
				->orLike('t0.snombretipoubicacion', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidubicacion', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteUbicacions($todos = 1, $text = ''){
		$builder = $this->conexion('tubicacion t0');

		$builder->select("t0.nidubicacion idubicacion, t0.snombretipoubicacion nombretipoubicacion, t0.bestado estado, CONCAT(t0.snombretipoubicacion) concatenado, CONCAT(t0.snombretipoubicacion) concatenadodetalle");

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidubicacion', $text)
				->orLike('t0.snombretipoubicacion', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidubicacion', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function getubicacion($nidubicacion){
		$builder = $this->conexion('tubicacion t0');
		$builder->select("t0.nidubicacion idubicacion, t0.snombretipoubicacion nombretipoubicacion, t0.bestado estado");
		$builder->where(['nidubicacion' => $nidubicacion]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getUbicacion2($id){
		$builder = $this->conexion('tubicacion t0');
		$builder->select("t0.nidubicacion idubicacion, t0.snombretipoubicacion nombretipoubicacion, t0.bestado estado");
		$builder->where('t0.nidubicacion', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('tubicacion t0');
		$builder->select('nidubicacion');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidubicacion', $text)
				->orLike('t0.snombretipoubicacion', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateUbicacion($nidubicacion, $datos){
		$builder = $this->conexion('tubicacion');
		$builder->where(['nidubicacion' => $nidubicacion]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('tubicacion');
		$builder->selectMax('nidubicacion');
		$query = $builder->get();
		return  $query->getResult()[0]->nidubicacion;
	}
}
?>
