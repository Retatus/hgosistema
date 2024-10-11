<?php 

namespace App\Models;
use CodeIgniter\Model; 

class EstadoModel extends Model
{
	protected $table      = 'testado';
	protected $primaryKey = 'nidestado';

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['snombre'];
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
		return $this->where(['nidestado' => $id])->countAllResults();
	}

	public function getEstados($todos = 1, $text = '', $total, $pag = 1){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;
		$builder = $this->conexion('testado t0');
		$builder->select("t0.nidestado idestado, t0.snombre nombre,  CONCAT(t0.snombre) as concatenado, CONCAT(t0.snombre) as concatenadodetalle");

		if ($todos !== '') 
		$builder->where('t0.nidestado', intval($todos));

		$builder->like('t0.nidestado', $text);
		$builder->orLike('t0.snombre', $text);

		$builder->orderBy('t0.nidestado', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getAutocompleteestados($todos = 1, $text = ''){
		$builder = $this->conexion('testado t0');
		$builder->select("t0.nidestado idestado, t0.snombre nombre,  CONCAT(t0.snombre) as concatenado, CONCAT(t0.snombre) as concatenadodetalle");

		if ($todos !== '') 
		$builder->where('t0.nidestado', intval($todos));

		$builder->like('t0.nidestado', $text);
		$builder->orLike('t0.snombre', $text);

		$builder->orderBy('t0.nidestado', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getEstado($nidestado){
		$builder = $this->conexion('testado t0');
		$builder->select("t0.nidestado idestado, t0.snombre nombre");
		$builder->where(['nidestado' => $nidestado]);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getEstado2($id){
		$builder = $this->conexion('testado t0');
		$builder->select(" t0.nidestado idestado0, t0.snombre nombre0,");

		$builder->where('t0.nidreserva', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}


	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('testado t0');
		$builder->select('nidestado');

		if ($todos !== '')
		$builder->where('t0.nidestado', intval($todos));

		$builder->like('t0.nidestado', $text);
		$builder->orLike('t0.snombre', $text);

		return $builder->countAllResults();
	}

	public function UpdateEstado($nidestado, $datos){
		$builder = $this->conexion('testado');
		$builder->where(['nidestado' => $nidestado]);
		$builder->set($datos);
		$builder->update();
	}

	public function getMaxid(){
		$builder = $this->conexion('testado');
		$builder->selectMax('nidestado');
		$query = $builder->get();
		return  $query->getResult()[0]->nidestado;
	}
}
?>
