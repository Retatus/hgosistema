<?php

namespace App\Models;
use CodeIgniter\Model; 

class TiposervicioModel extends Model
{
	protected $table      = 'ttiposervicio';
	protected $primaryKey = 'nidtiposervicio';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidtiposervicio', 'snombretiposervicio', 'bestado'];
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
	public function existe($nidtiposervicio){
		return $this->where(['nidtiposervicio' => $nidtiposervicio])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getTiposervicios($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('ttiposervicio t0');

		$builder->select("t0.nidtiposervicio idtiposervicio, t0.snombretiposervicio nombretiposervicio, t0.bestado estado, CONCAT(t0.snombretiposervicio) concatenado, CONCAT(t0.snombretiposervicio) concatenadodetalle");


		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidtiposervicio', $text)
				->orLike('t0.snombretiposervicio', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidtiposervicio', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteTiposervicios($todos = 1, $text = ''){
		$builder = $this->conexion('ttiposervicio t0');

		$builder->select("t0.nidtiposervicio idtiposervicio, t0.snombretiposervicio nombretiposervicio, t0.bestado estado, CONCAT(t0.snombretiposervicio) concatenado, CONCAT(t0.snombretiposervicio) concatenadodetalle");

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidtiposervicio', $text)
				->orLike('t0.snombretiposervicio', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidtiposervicio', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function gettiposervicio($nidtiposervicio){
		$builder = $this->conexion('ttiposervicio t0');
		$builder->select("t0.nidtiposervicio idtiposervicio, t0.snombretiposervicio nombretiposervicio, t0.bestado estado");
		$builder->where(['nidtiposervicio' => $nidtiposervicio]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getTiposervicio2($id){
		$builder = $this->conexion('ttiposervicio t0');
		$builder->select("t0.nidtiposervicio idtiposervicio, t0.snombretiposervicio nombretiposervicio, t0.bestado estado");
		$builder->where('t0.nidtiposervicio', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('ttiposervicio t0');
		$builder->select('nidtiposervicio');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidtiposervicio', $text)
				->orLike('t0.snombretiposervicio', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateTiposervicio($nidtiposervicio,  $datos){
		$builder = $this->conexion('ttiposervicio');
		$builder->where(['nidtiposervicio' => $nidtiposervicio]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('ttiposervicio');
		$builder->selectMax('nidtiposervicio');
		$query = $builder->get();
		return  $query->getResult()[0]->nidtiposervicio;
	}
}
?>
