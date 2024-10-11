<?php 

namespace App\Models;
use CodeIgniter\Model; 

class RencauchadoraModel extends Model
{
	protected $table      = 'trencauchadora';
	protected $primaryKey = 'nidrencauchadora';

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['snombre','sdireccion'];
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
		return $this->where(['nidrencauchadora' => $id])->countAllResults();
	}

	public function getRencauchadoras($todos = 1, $text = '', $total, $pag = 1){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;
		$builder = $this->conexion('trencauchadora t0');
		$builder->select("t0.nidrencauchadora idrencauchadora, t0.snombre nombre, t0.sdireccion direccion,  CONCAT(t0.snombre) as concatenado, CONCAT(t0.snombre) as concatenadodetalle");

		if ($todos !== '') 

		$builder->like('t0.nidrencauchadora', $text);
		$builder->orLike('t0.snombre', $text);

		$builder->orderBy('t0.nidrencauchadora', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getAutocompleterencauchadoras($todos = 1, $text = ''){
		$builder = $this->conexion('trencauchadora t0');
		$builder->select("t0.nidrencauchadora idrencauchadora, t0.snombre nombre, t0.sdireccion direccion,  CONCAT(t0.snombre) as concatenado, CONCAT(t0.snombre) as concatenadodetalle");

		if ($todos !== '') 

		$builder->like('t0.nidrencauchadora', $text);
		$builder->orLike('t0.snombre', $text);

		$builder->orderBy('t0.nidrencauchadora', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getRencauchadora($nidrencauchadora){
		$builder = $this->conexion('trencauchadora t0');
		$builder->select("t0.nidrencauchadora idrencauchadora, t0.snombre nombre, t0.sdireccion direccion");
		$builder->where(['nidrencauchadora' => $nidrencauchadora]);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getRencauchadora2($id){
		$builder = $this->conexion('trencauchadora t0');
		$builder->select(" t0.nidrencauchadora idrencauchadora0, t0.snombre nombre0, t0.sdireccion direccion0,");

		$builder->where('t0.nidreserva', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}


	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('trencauchadora t0');
		$builder->select('nidrencauchadora');

		if ($todos !== '')

		$builder->like('t0.nidrencauchadora', $text);
		$builder->orLike('t0.snombre', $text);

		return $builder->countAllResults();
	}

	public function UpdateRencauchadora($nidrencauchadora, $datos){
		$builder = $this->conexion('trencauchadora');
		$builder->where(['nidrencauchadora' => $nidrencauchadora]);
		$builder->set($datos);
		$builder->update();
	}

	public function getMaxid(){
		$builder = $this->conexion('trencauchadora');
		$builder->selectMax('nidrencauchadora');
		$query = $builder->get();
		return  $query->getResult()[0]->nidrencauchadora;
	}
}
?>
