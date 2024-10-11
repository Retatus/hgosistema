<?php 

namespace App\Models;
use CodeIgniter\Model; 

class CondicionModel extends Model
{
	protected $table      = 'tcondicion';
	protected $primaryKey = 'nidcondicion';

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['snombrecondicion'];
	protected $useTimestamps = false;
	protected $createdField  = 'tfecha_alt';
	protected $updatedField  = 'tfecha_edi';
	protected $deletedField  = 'deleted_at';

	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = false;

	protected function conexion(string $table = null){
		$this->db = \Config\Database::connect();
		$this->builder = $this->db->table($table);
		return $this->builder;
	}

	public function existe($id){
		return $this->where(['nidcondicion' => $id])->countAllResults();
	}

	public function getCondicions($todos = 1, $text = '', $total, $pag = 1){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;
		$builder = $this->conexion('tcondicion t0');
		$builder->select("t0.nidcondicion idcondicion, t0.snombrecondicion nombrecondicion,  CONCAT(t0.snombrecondicion) as concatenado, CONCAT(t0.snombrecondicion) as concatenadodetalle");

		if ($todos !== '') 

		$builder->like('t0.nidcondicion', $text);
		$builder->orLike('t0.snombrecondicion', $text);

		$builder->orderBy('t0.nidcondicion', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getAutocompletecondicions($todos = 1, $text = ''){
		$builder = $this->conexion('tcondicion t0');
		$builder->select("t0.nidcondicion idcondicion, t0.snombrecondicion nombrecondicion,  CONCAT(t0.snombrecondicion) as concatenado, CONCAT(t0.snombrecondicion) as concatenadodetalle");

		if ($todos !== '') 

		$builder->like('t0.nidcondicion', $text);
		$builder->orLike('t0.snombrecondicion', $text);

		$builder->orderBy('t0.nidcondicion', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getCondicion($nidcondicion){
		$builder = $this->conexion('tcondicion t0');
		$builder->select("t0.nidcondicion idcondicion, t0.snombrecondicion nombrecondicion");
		$builder->where(['nidcondicion' => $nidcondicion]);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getCondicion2($id){
		$builder = $this->conexion('tcondicion t0');
		$builder->select(" t0.nidcondicion idcondicion0, t0.snombrecondicion nombrecondicion0,");

		$builder->where('t0.nidreserva', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}


	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('tcondicion t0');
		$builder->select('nidcondicion');

		if ($todos !== '')

		$builder->like('t0.nidcondicion', $text);
		$builder->orLike('t0.snombrecondicion', $text);

		return $builder->countAllResults();
	}

	public function UpdateCondicion($nidcondicion, $datos){
		$builder = $this->conexion('tcondicion');
		$builder->where(['nidcondicion' => $nidcondicion]);
		$builder->set($datos);
		$builder->update();
	}

	public function getMaxid(){
		$builder = $this->conexion('tcondicion');
		$builder->selectMax('nidcondicion');
		$query = $builder->get();
		return  $query->getResult()[0]->nidcondicion;
	}
}
?>
