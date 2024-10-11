<?php 

namespace App\Models;
use CodeIgniter\Model; 

class ClienteModel extends Model
{
	protected $table      = 'tcliente';
	protected $primaryKey = 'sidcliente';

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['sidcliente','srasonsocial','sdireccion','stelefono'];
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
		return $this->where(['sidcliente' => $id])->countAllResults();
	}

	public function getClientes($todos = 1, $text = '', $total, $pag = 1){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;
		$builder = $this->conexion('tcliente t0');
		$builder->select("t0.sidcliente idcliente, t0.srasonsocial rasonsocial, t0.sdireccion direccion, t0.stelefono telefono,  CONCAT(t0.sidcliente, ' - ', t0.srasonsocial) as concatenado, CONCAT(t0.sidcliente, ' - ', t0.srasonsocial) as concatenadodetalle");

		if ($todos !== '') 

		$builder->like('t0.sidcliente', $text);
		$builder->orLike('t0.srasonsocial', $text);

		$builder->orderBy('t0.sidcliente', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getAutocompleteclientes($todos = 1, $text = ''){
		$builder = $this->conexion('tcliente t0');
		$builder->select("t0.sidcliente idcliente, t0.srasonsocial rasonsocial, t0.sdireccion direccion, t0.stelefono telefono,  CONCAT(t0.sidcliente, ' - ', t0.srasonsocial) as concatenado, CONCAT(t0.sidcliente, ' - ', t0.srasonsocial) as concatenadodetalle");

		if ($todos !== '') 

		$builder->like('t0.sidcliente', $text);
		$builder->orLike('t0.srasonsocial', $text);

		$builder->orderBy('t0.sidcliente', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getCliente($sidcliente){
		$builder = $this->conexion('tcliente t0');
		$builder->select("t0.sidcliente idcliente, t0.srasonsocial rasonsocial, t0.sdireccion direccion, t0.stelefono telefono");
		$builder->where(['sidcliente' => $sidcliente]);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getCliente2($id){
		$builder = $this->conexion('tcliente t0');
		$builder->select(" t0.sidcliente idcliente0, t0.srasonsocial rasonsocial0, t0.sdireccion direccion0, t0.stelefono telefono0,");

		$builder->where('t0.nidreserva', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}


	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('tcliente t0');
		$builder->select('sidcliente');

		if ($todos !== '')

		$builder->like('t0.sidcliente', $text);
		$builder->orLike('t0.srasonsocial', $text);

		return $builder->countAllResults();
	}

	public function UpdateCliente($sidcliente, $datos){
		$builder = $this->conexion('tcliente');
		$builder->where(['sidcliente' => $sidcliente]);
		$builder->set($datos);
		$builder->update();
	}

	public function getMaxid(){
		$builder = $this->conexion('tcliente');
		$builder->selectMax('sidcliente');
		$query = $builder->get();
		return  $query->getResult()[0]->sidcliente;
	}
}
?>
