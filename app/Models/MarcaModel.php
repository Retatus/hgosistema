<?php

namespace App\Models;
use CodeIgniter\Model; 

class MarcaModel extends Model
{
	protected $table      = 'tmarca';
	protected $primaryKey = 'nidmarca';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidmarca', 'snombremarca', 'bestado'];
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
	public function existe($nidmarca){
		return $this->where(['nidmarca' => $nidmarca])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getMarcas($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('tmarca t0');

		$builder->select("t0.nidmarca idmarca, t0.snombremarca nombremarca, t0.bestado estado, CONCAT(t0.snombremarca) concatenado, CONCAT(t0.snombremarca) concatenadodetalle");


		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidmarca', $text)
				->orLike('t0.snombremarca', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidmarca', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteMarcas($todos = 1, $text = ''){
		$builder = $this->conexion('tmarca t0');

		$builder->select("t0.nidmarca idmarca, t0.snombremarca nombremarca, t0.bestado estado, CONCAT(t0.snombremarca) concatenado, CONCAT(t0.snombremarca) concatenadodetalle");

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidmarca', $text)
				->orLike('t0.snombremarca', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidmarca', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

	public function getMarcasSelect2($todos = 1, $text = ''){
		$builder = $this->conexion('tmarca t0');
		$builder->select("t0.nidmarca idmarca, t0.snombremarca nombremarca, t0.bestado estado, CONCAT(t0.snombremarca) concatenado, CONCAT(t0.snombremarca) concatenadodetalle");
		$builder->where('t0.bestado', 1);
		$builder->orderBy('t0.nidmarca', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function getmarca($nidmarca){
		$builder = $this->conexion('tmarca t0');
		$builder->select("t0.nidmarca idmarca, t0.snombremarca nombremarca, t0.bestado estado");
		$builder->where(['nidmarca' => $nidmarca]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getMarca2($id){
		$builder = $this->conexion('tmarca t0');
		$builder->select("t0.nidmarca idmarca, t0.snombremarca nombremarca, t0.bestado estado");
		$builder->where('t0.nidmarca', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('tmarca t0');
		$builder->select('nidmarca');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidmarca', $text)
				->orLike('t0.snombremarca', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateMarca($nidmarca, $datos){
		$builder = $this->conexion('tmarca');
		$builder->where(['nidmarca' => $nidmarca]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('tmarca');
		$builder->selectMax('nidmarca');
		$query = $builder->get();
		return  $query->getResult()[0]->nidmarca;
	}
}
?>
