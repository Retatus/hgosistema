<?php 

namespace App\Models;
use CodeIgniter\Model; 

class NeumaticoModel extends Model
{
	protected $table      = 'tneumatico';
	protected $primaryKey = 'nidneumatico';

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['scodigo','smarca','sdescripcion'];
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
		return $this->where(['nidneumatico' => $id])->countAllResults();
	}

	public function getNeumaticos($todos = 1, $text = '', $total, $pag = 1){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;
		$builder = $this->conexion('tneumatico t0');
		$builder->select("t0.nidneumatico idneumatico, t0.scodigo codigo, t0.smarca marca, t0.sdescripcion descripcion,  CONCAT(t0.smarca, ' - ', t0.sdescripcion) as concatenado, CONCAT(t0.smarca, ' - ', t0.sdescripcion) as concatenadodetalle");

		if ($todos !== '') 

		$builder->like('t0.nidneumatico', $text);
		$builder->orLike('t0.smarca', $text);
		$builder->orLike('t0.sdescripcion', $text);

		$builder->orderBy('t0.nidneumatico', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getAutocompleteneumaticos($todos = 1, $text = ''){
		$builder = $this->conexion('tneumatico t0');
		$builder->select("t0.nidneumatico idneumatico, t0.scodigo codigo, t0.smarca marca, t0.sdescripcion descripcion,  CONCAT(t0.smarca, ' - ', t0.sdescripcion) as concatenado, CONCAT(t0.smarca, ' - ', t0.sdescripcion) as concatenadodetalle");

		if ($todos !== '') 

		$builder->like('t0.nidneumatico', $text);
		$builder->orLike('t0.smarca', $text);
		$builder->orLike('t0.sdescripcion', $text);

		$builder->orderBy('t0.nidneumatico', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getNeumatico($nidneumatico){
		$builder = $this->conexion('tneumatico t0');
		$builder->select("t0.nidneumatico idneumatico, t0.scodigo codigo, t0.smarca marca, t0.sdescripcion descripcion");
		$builder->where(['nidneumatico' => $nidneumatico]);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getNeumatico2($id){
		$builder = $this->conexion('tneumatico t0');
		$builder->select(" t0.nidneumatico idneumatico0, t0.scodigo codigo0, t0.smarca marca0, t0.sdescripcion descripcion0,");

		$builder->where('t0.nidreserva', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}


	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('tneumatico t0');
		$builder->select('nidneumatico');

		if ($todos !== '')

		$builder->like('t0.nidneumatico', $text);
		$builder->orLike('t0.smarca', $text);
		$builder->orLike('t0.sdescripcion', $text);

		return $builder->countAllResults();
	}

	public function UpdateNeumatico($nidneumatico, $datos){
		$builder = $this->conexion('tneumatico');
		$builder->where(['nidneumatico' => $nidneumatico]);
		$builder->set($datos);
		$builder->update();
	}

	public function getMaxid(){
		$builder = $this->conexion('tneumatico');
		$builder->selectMax('nidneumatico');
		$query = $builder->get();
		return  $query->getResult()[0]->nidneumatico;
	}
}
?>
