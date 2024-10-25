<?php

namespace App\Models;
use CodeIgniter\Model; 

class NumeroModel extends Model
{
	protected $table      = 'tnumero';
	protected $primaryKey = 'nidnumero';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidnumero', 'snombrenumero', 'bestado'];
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
	public function existe($nidnumero){
		return $this->where(['nidnumero' => $nidnumero])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getNumeros($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('tnumero t0');

		$builder->select("t0.nidnumero idnumero, t0.snombrenumero nombrenumero, t0.bestado estado, CONCAT(t0.snombrenumero) concatenado, CONCAT(t0.snombrenumero) concatenadodetalle");


		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidnumero', $text)
				->orLike('t0.snombrenumero', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidnumero', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteNumeros($todos = 1, $text = ''){
		$builder = $this->conexion('tnumero t0');

		$builder->select("t0.nidnumero idnumero, t0.snombrenumero nombrenumero, t0.bestado estado, CONCAT(t0.snombrenumero) concatenado, CONCAT(t0.snombrenumero) concatenadodetalle");

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidnumero', $text)
				->orLike('t0.snombrenumero', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidnumero', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

	public function getNumerosSelect2($todos = 1, $text = ''){
		$builder = $this->conexion('tnumero t0');
		$builder->select("t0.nidnumero idnumero, t0.snombrenumero nombrenumero, t0.bestado estado, CONCAT(t0.snombrenumero) concatenado, CONCAT(t0.snombrenumero) concatenadodetalle");
		$builder->where('t0.bestado', 1);
		$builder->orderBy('t0.nidnumero', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function getnumero($nidnumero){
		$builder = $this->conexion('tnumero t0');
		$builder->select("t0.nidnumero idnumero, t0.snombrenumero nombrenumero, t0.bestado estado");
		$builder->where(['nidnumero' => $nidnumero]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getNumero2($id){
		$builder = $this->conexion('tnumero t0');
		$builder->select("t0.nidnumero idnumero, t0.snombrenumero nombrenumero, t0.bestado estado");
		$builder->where('t0.nidnumero', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('tnumero t0');
		$builder->select('nidnumero');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidnumero', $text)
				->orLike('t0.snombrenumero', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateNumero($nidnumero, $datos){
		$builder = $this->conexion('tnumero');
		$builder->where(['nidnumero' => $nidnumero]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('tnumero');
		$builder->selectMax('nidnumero');
		$query = $builder->get();
		return  $query->getResult()[0]->nidnumero;
	}
}
?>
