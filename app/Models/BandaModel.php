<?php 

namespace App\Models;
use CodeIgniter\Model; 

class BandaModel extends Model
{
	protected $table      = 'tbanda';
	protected $primaryKey = 'nidbanda';

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['snombrebanda','smarca'];
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
		return $this->where(['nidbanda' => $id])->countAllResults();
	}

	public function getBandas($todos = 1, $text = '', $total, $pag = 1){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;
		$builder = $this->conexion('tbanda t0');
		$builder->select("t0.nidbanda idbanda, t0.snombrebanda nombrebanda, t0.smarca marca,  CONCAT(t0.snombrebanda) as concatenado, CONCAT(t0.snombrebanda) as concatenadodetalle");

		if ($todos !== '') 

		$builder->like('t0.nidbanda', $text);
		$builder->orLike('t0.snombrebanda', $text);

		$builder->orderBy('t0.nidbanda', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getAutocompletebandas($todos = 1, $text = ''){
		$builder = $this->conexion('tbanda t0');
		$builder->select("t0.nidbanda idbanda, t0.snombrebanda nombrebanda, t0.smarca marca,  CONCAT(t0.snombrebanda) as concatenado, CONCAT(t0.snombrebanda) as concatenadodetalle");

		if ($todos !== '') 

		$builder->like('t0.nidbanda', $text);
		$builder->orLike('t0.snombrebanda', $text);

		$builder->orderBy('t0.nidbanda', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getBanda($nidbanda){
		$builder = $this->conexion('tbanda t0');
		$builder->select("t0.nidbanda idbanda, t0.snombrebanda nombrebanda, t0.smarca marca");
		$builder->where(['nidbanda' => $nidbanda]);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getBanda2($id){
		$builder = $this->conexion('tbanda t0');
		$builder->select(" t0.nidbanda idbanda0, t0.snombrebanda nombrebanda0, t0.smarca marca0,");

		$builder->where('t0.nidreserva', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}


	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('tbanda t0');
		$builder->select('nidbanda');

		if ($todos !== '')

		$builder->like('t0.nidbanda', $text);
		$builder->orLike('t0.snombrebanda', $text);

		return $builder->countAllResults();
	}

	public function UpdateBanda($nidbanda, $datos){
		$builder = $this->conexion('tbanda');
		$builder->where(['nidbanda' => $nidbanda]);
		$builder->set($datos);
		$builder->update();
	}

	public function getMaxid(){
		$builder = $this->conexion('tbanda');
		$builder->selectMax('nidbanda');
		$query = $builder->get();
		return  $query->getResult()[0]->nidbanda;
	}
}
?>
