<?php 

namespace App\Models;
use CodeIgniter\Model; 

class TiposervicioModel extends Model
{
	protected $table      = 'ttiposervicio';
	protected $primaryKey = 'nidtiposervicio';

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['snombretiposervicio'];
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
		return $this->where(['nidtiposervicio' => $id])->countAllResults();
	}

	public function getTiposervicios($todos = 1, $text = '', $total, $pag = 1){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;
		$builder = $this->conexion('ttiposervicio t0');
		$builder->select("t0.nidtiposervicio idtiposervicio, t0.snombretiposervicio nombretiposervicio,  CONCAT(t0.snombretiposervicio) as concatenado, CONCAT(t0.snombretiposervicio) as concatenadodetalle");

		if ($todos !== '') 

		$builder->like('t0.nidtiposervicio', $text);
		$builder->orLike('t0.snombretiposervicio', $text);

		$builder->orderBy('t0.nidtiposervicio', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getAutocompletetiposervicios($todos = 1, $text = ''){
		$builder = $this->conexion('ttiposervicio t0');
		$builder->select("t0.nidtiposervicio idtiposervicio, t0.snombretiposervicio nombretiposervicio,  CONCAT(t0.snombretiposervicio) as concatenado, CONCAT(t0.snombretiposervicio) as concatenadodetalle");

		if ($todos !== '') 

		$builder->like('t0.nidtiposervicio', $text);
		$builder->orLike('t0.snombretiposervicio', $text);

		$builder->orderBy('t0.nidtiposervicio', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getTiposervicio($nidtiposervicio){
		$builder = $this->conexion('ttiposervicio t0');
		$builder->select("t0.nidtiposervicio idtiposervicio, t0.snombretiposervicio nombretiposervicio");
		$builder->where(['nidtiposervicio' => $nidtiposervicio]);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getTiposervicio2($id){
		$builder = $this->conexion('ttiposervicio t0');
		$builder->select(" t0.nidtiposervicio idtiposervicio0, t0.snombretiposervicio nombretiposervicio0,");

		$builder->where('t0.nidreserva', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}


	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('ttiposervicio t0');
		$builder->select('nidtiposervicio');

		if ($todos !== '')

		$builder->like('t0.nidtiposervicio', $text);
		$builder->orLike('t0.snombretiposervicio', $text);

		return $builder->countAllResults();
	}

	public function UpdateTiposervicio($nidtiposervicio, $datos){
		$builder = $this->conexion('ttiposervicio');
		$builder->where(['nidtiposervicio' => $nidtiposervicio]);
		$builder->set($datos);
		$builder->update();
	}

	public function getMaxid(){
		$builder = $this->conexion('ttiposervicio');
		$builder->selectMax('nidtiposervicio');
		$query = $builder->get();
		return  $query->getResult()[0]->nidtiposervicio;
	}
}
?>
