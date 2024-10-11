<?php 

namespace App\Models;
use CodeIgniter\Model; 

class ServicioModel extends Model
{
	protected $table      = 'tservicio';
	protected $primaryKey = 'nidservicio';

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['tfechaingreso','sidusuario','sobservacioningreso','sidcliente','nidtiposervicio','nidbanda','nidneumatico','nidubicacion','nidrencauchadora','tfecchasalida','sobservacionsalida','nidcondicion','nestado'];
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
		return $this->where(['nidservicio' => $id])->countAllResults();
	}

	public function getServicios($todos = 1, $text = '', $total, $pag = 1){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;
		$builder = $this->conexion('tservicio t0');
		$builder->select("t0.nidservicio idservicio, DATE_FORMAT(CAST(t0.tfechaingreso As Date), '%d-%m-%Y') fechaingreso, t0.sidusuario idusuario, t0.sobservacioningreso observacioningreso, t0.sidcliente idcliente, t0.nidtiposervicio idtiposervicio, t0.nidbanda idbanda, t0.nidneumatico idneumatico, t0.nidubicacion idubicacion, t0.nidrencauchadora idrencauchadora, DATE_FORMAT(CAST(t0.tfecchasalida As Date), '%d-%m-%Y') fecchasalida, t0.sobservacionsalida observacionsalida, t0.nidcondicion idcondicion, t0.nestado estado,  t1.sidcliente idcliente, t2.nidubicacion idubicacion, t2.snombretipoubicacion nombretipoubicacion, t3.nidbanda idbanda, t3.snombrebanda nombrebanda, t4.nidcondicion idcondicion, t4.snombrecondicion nombrecondicion, t5.nidneumatico idneumatico, t6.nidrencauchadora idrencauchadora, t6.snombrereencauchadora nombrereencauchadora, t7.nidtiposervicio idtiposervicio, t7.snombretiposervicio nombretiposervicio, t8.sidusuario idusuario, t8.snombreusuario nombreusuario, CONCAT(t5.scodigo, ' - ', t5.smarca, ' - ', t2.snombretipoubicacion, ' - ', t1.sidcliente, ' - ', t1.srasonsocial) as concatenado, CONCAT(t5.scodigo, ' - ', t5.smarca, ' - ', t2.snombretipoubicacion, ' - ', t1.sidcliente, ' - ', t1.srasonsocial) as concatenadodetalle");
		$builder->join('tcliente t1', ' t1.sidcliente = t0.sidcliente');
		$builder->join('tubicacion t2', ' t2.nidubicacion = t0.nidubicacion');
		$builder->join('tbanda t3', ' t3.nidbanda = t0.nidbanda');
		$builder->join('tcondicion t4', ' t4.nidcondicion = t0.nidcondicion');
		$builder->join('tneumatico t5', ' t5.nidneumatico = t0.nidneumatico');
		$builder->join('treencauchadora t6', ' t6.nidrencauchadora = t0.nidrencauchadora');
		$builder->join('ttiposervicio t7', ' t7.nidtiposervicio = t0.nidtiposervicio');
		$builder->join('tusuario t8', ' t8.sidusuario = t0.sidusuario');

		if ($todos !== '') 
		$builder->where('t0.nestado', intval($todos));

		$builder->like('t0.nidservicio', $text);
		$builder->orLike('t5.scodigo', $text);
		$builder->orLike('t5.smarca', $text);
		$builder->orLike('t2.snombretipoubicacion', $text);
		$builder->orLike('t1.sidcliente', $text);
		$builder->orLike('t1.srasonsocial', $text);

		$builder->orderBy('t0.nidservicio', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getAutocompleteservicios($todos = 1, $text = ''){
		$builder = $this->conexion('tservicio t0');
		$builder->select("t0.nidservicio idservicio, DATE_FORMAT(CAST(t0.tfechaingreso As Date), '%d-%m-%Y') fechaingreso, t0.sidusuario idusuario, t0.sobservacioningreso observacioningreso, t0.sidcliente idcliente, t0.nidtiposervicio idtiposervicio, t0.nidbanda idbanda, t0.nidneumatico idneumatico, t0.nidubicacion idubicacion, t0.nidrencauchadora idrencauchadora, DATE_FORMAT(CAST(t0.tfecchasalida As Date), '%d-%m-%Y') fecchasalida, t0.sobservacionsalida observacionsalida, t0.nidcondicion idcondicion, t0.nestado estado,  t1.sidcliente idcliente, t2.nidubicacion idubicacion, t2.snombretipoubicacion nombretipoubicacion, t3.nidbanda idbanda, t3.snombrebanda nombrebanda, t4.nidcondicion idcondicion, t4.snombrecondicion nombrecondicion, t5.nidneumatico idneumatico, t6.nidrencauchadora idrencauchadora, t6.snombrereencauchadora nombrereencauchadora, t7.nidtiposervicio idtiposervicio, t7.snombretiposervicio nombretiposervicio, t8.sidusuario idusuario, t8.snombreusuario nombreusuario, CONCAT(t5.scodigo, ' - ', t5.smarca, ' - ', t2.snombretipoubicacion, ' - ', t1.sidcliente, ' - ', t1.srasonsocial) as concatenado, CONCAT(t5.scodigo, ' - ', t5.smarca, ' - ', t2.snombretipoubicacion, ' - ', t1.sidcliente, ' - ', t1.srasonsocial) as concatenadodetalle");
		$builder->join('tcliente t1', ' t1.sidcliente = t0.sidcliente');
		$builder->join('tubicacion t2', ' t2.nidubicacion = t0.nidubicacion');
		$builder->join('tbanda t3', ' t3.nidbanda = t0.nidbanda');
		$builder->join('tcondicion t4', ' t4.nidcondicion = t0.nidcondicion');
		$builder->join('tneumatico t5', ' t5.nidneumatico = t0.nidneumatico');
		$builder->join('treencauchadora t6', ' t6.nidrencauchadora = t0.nidrencauchadora');
		$builder->join('ttiposervicio t7', ' t7.nidtiposervicio = t0.nidtiposervicio');
		$builder->join('tusuario t8', ' t8.sidusuario = t0.sidusuario');

		if ($todos !== '') 
		$builder->where('t0.nestado', intval($todos));

		$builder->like('t0.nidservicio', $text);
		$builder->orLike('t5.scodigo', $text);
		$builder->orLike('t5.smarca', $text);
		$builder->orLike('t2.snombretipoubicacion', $text);
		$builder->orLike('t1.sidcliente', $text);
		$builder->orLike('t1.srasonsocial', $text);

		$builder->orderBy('t0.nidservicio', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getServicio($nidservicio,$sidcliente,$nidubicacion,$nidbanda,$nidcondicion,$nidneumatico,$nidrencauchadora,$nidtiposervicio,$sidusuario){
		$builder = $this->conexion('tservicio t0');
		$builder->select("t0.nidservicio idservicio,DATE_FORMAT(CAST(t0.tfechaingreso As Date), '%d/%m/%Y') fechaingreso, t0.sidusuario idusuario, t0.sobservacioningreso observacioningreso, t0.sidcliente idcliente, t0.nidtiposervicio idtiposervicio, t0.nidbanda idbanda, t0.nidneumatico idneumatico, t0.nidubicacion idubicacion, t0.nidrencauchadora idrencauchadora,DATE_FORMAT(CAST(t0.tfecchasalida As Date), '%d/%m/%Y') fecchasalida, t0.sobservacionsalida observacionsalida, t0.nidcondicion idcondicion, t0.nestado estado");
		$builder->where(['nidservicio' => $nidservicio,'sidcliente' => $sidcliente,'nidubicacion' => $nidubicacion,'nidbanda' => $nidbanda,'nidcondicion' => $nidcondicion,'nidneumatico' => $nidneumatico,'nidrencauchadora' => $nidrencauchadora,'nidtiposervicio' => $nidtiposervicio,'sidusuario' => $sidusuario]);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getServicio2($id){
		$builder = $this->conexion('tservicio t0');
		$builder->select(" t0.nidservicio idservicio0, t0.tfechaingreso fechaingreso0, t0.sobservacioningreso observacioningreso0, t0.tfecchasalida fecchasalida0, t0.sobservacionsalida observacionsalida0, t0.nestado estado0, t1.sidusuario idusuario1, t1.snombreusuario nombreusuario1, t2.sidcliente idcliente2, t2.srasonsocial rasonsocial2, t2.sdireccion direccion2, t2.stelefono telefono2, t3.nidtiposervicio idtiposervicio3, t3.snombretiposervicio nombretiposervicio3, t4.nidbanda idbanda4, t4.snombrebanda nombrebanda4, t4.smarca marca4, t5.nidneumatico idneumatico5, t5.scodigo codigo5, t5.smarca marca5, t5.sdescripcion descripcion5, t6.nidubicacion idubicacion6, t6.snombretipoubicacion nombretipoubicacion6, t7.nidrencauchadora idrencauchadora7, t7.snombrereencauchadora nombrereencauchadora7, t7.sdireccion direccion7, t8.nidcondicion idcondicion8, t8.snombrecondicion nombrecondicion8,");
		$builder->join('tusuario t1', ' t0.sidusuario = t1.sidusuario');
		$builder->join('tcliente t2', ' t0.sidcliente = t2.sidcliente');
		$builder->join('ttiposervicio t3', ' t0.nidtiposervicio = t3.nidtiposervicio');
		$builder->join('tbanda t4', ' t0.nidbanda = t4.nidbanda');
		$builder->join('tneumatico t5', ' t0.nidneumatico = t5.nidneumatico');
		$builder->join('tubicacion t6', ' t0.nidubicacion = t6.nidubicacion');
		$builder->join('treencauchadora t7', ' t0.nidrencauchadora = t7.nidrencauchadora');
		$builder->join('tcondicion t8', ' t0.nidcondicion = t8.nidcondicion');

		$builder->where('t0.nidreserva', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}


	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('tservicio t0');
		$builder->select('nidservicio');
		$builder->join('tcliente t1', ' t1.sidcliente = t0.sidcliente');
		$builder->join('tubicacion t2', ' t2.nidubicacion = t0.nidubicacion');
		$builder->join('tbanda t3', ' t3.nidbanda = t0.nidbanda');
		$builder->join('tcondicion t4', ' t4.nidcondicion = t0.nidcondicion');
		$builder->join('tneumatico t5', ' t5.nidneumatico = t0.nidneumatico');
		$builder->join('treencauchadora t6', ' t6.nidrencauchadora = t0.nidrencauchadora');
		$builder->join('ttiposervicio t7', ' t7.nidtiposervicio = t0.nidtiposervicio');
		$builder->join('tusuario t8', ' t8.sidusuario = t0.sidusuario');

		if ($todos !== '')
		$builder->where('t0.nestado', intval($todos));

		$builder->like('t0.nidservicio', $text);
		$builder->orLike('t5.scodigo', $text);
		$builder->orLike('t5.smarca', $text);
		$builder->orLike('t2.snombretipoubicacion', $text);
		$builder->orLike('t1.sidcliente', $text);
		$builder->orLike('t1.srasonsocial', $text);

		return $builder->countAllResults();
	}
	
	public function UpdateServicio($nidservicio, $datos){
		$builder = $this->conexion('tservicio');
		$builder->where(['nidservicio' => $nidservicio]);
		$builder->set($datos);
		$builder->update();
	}

	public function getMaxid(){
		$builder = $this->conexion('tservicio');
		$builder->selectMax('nidservicio');
		$query = $builder->get();
		return  $query->getResult()[0]->nidservicio;
	}
}
?>
