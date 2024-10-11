<?php 

namespace App\Models;
use CodeIgniter\Model; 

class UbicacionModel extends Model
{
	protected $table      = 'tubicacion';
	protected $primaryKey = 'nidubicacion';

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['snombretipoubicacion'];
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
		return $this->where(['nidubicacion' => $id])->countAllResults();
	}

	public function getUbicacions($todos = 1, $text = '', $total, $pag = 1){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;
		$builder = $this->conexion('tubicacion t0');
		$builder->select("t0.nidubicacion idubicacion, t0.snombretipoubicacion nombretipoubicacion,  CONCAT(t0.snombretipoubicacion) as concatenado, CONCAT(t0.snombretipoubicacion) as concatenadodetalle");

		if ($todos !== '') 

		$builder->like('t0.nidubicacion', $text);
		$builder->orLike('t0.snombretipoubicacion', $text);

		$builder->orderBy('t0.nidubicacion', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getAutocompleteubicacions($todos = 1, $text = ''){
		$builder = $this->conexion('tubicacion t0');
		$builder->select("t0.nidubicacion idubicacion, t0.snombretipoubicacion nombretipoubicacion,  CONCAT(t0.snombretipoubicacion) as concatenado, CONCAT(t0.snombretipoubicacion) as concatenadodetalle");

		if ($todos !== '') 

		$builder->like('t0.nidubicacion', $text);
		$builder->orLike('t0.snombretipoubicacion', $text);

		$builder->orderBy('t0.nidubicacion', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getUbicacion($nidubicacion){
		$builder = $this->conexion('tubicacion t0');
		$builder->select("t0.nidubicacion idubicacion, t0.snombretipoubicacion nombretipoubicacion");
		$builder->where(['nidubicacion' => $nidubicacion]);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getUbicacion2($id){
		$builder = $this->conexion('tubicacion t0');
		$builder->select(" t0.nidubicacion idubicacion0, t0.snombretipoubicacion nombretipoubicacion0,");

		$builder->where('t0.nidreserva', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}


	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('tubicacion t0');
		$builder->select('nidubicacion');

		if ($todos !== '')

		$builder->like('t0.nidubicacion', $text);
		$builder->orLike('t0.snombretipoubicacion', $text);

		return $builder->countAllResults();
	}

	public function UpdateUbicacion($nidubicacion, $datos){
		$builder = $this->conexion('tubicacion');
		$builder->where(['nidubicacion' => $nidubicacion]);
		$builder->set($datos);
		$builder->update();
	}

	public function getMaxid(){
		$builder = $this->conexion('tubicacion');
		$builder->selectMax('nidubicacion');
		$query = $builder->get();
		return  $query->getResult()[0]->nidubicacion;
	}
}
?>
