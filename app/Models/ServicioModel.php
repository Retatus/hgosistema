<?php

namespace App\Models;
use CodeIgniter\Model; 

class ServicioModel extends Model
{
	protected $table      = 'tservicio';
	protected $primaryKey = 'nidservicio';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidservicio', 'tfechaingreso', 'sidusuario', 'sobservacioningreso', 'sidcliente', 'nidtiposervicio', 'nidbanda', 'nidneumatico', 'nidubicacion', 'nidrencauchadora', 'tfechasalida', 'sobservacionsalida', 'nidcondicion', 'bestado', 'scodigo'];
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
	public function existe($nidservicio, $sidusuario, $sidcliente, $nidtiposervicio, $nidbanda, $nidneumatico, $nidubicacion, $nidrencauchadora, $nidcondicion){
		return $this->where(['nidservicio' => $nidservicio, 'sidusuario' => $sidusuario, 'sidcliente' => $sidcliente, 'nidtiposervicio' => $nidtiposervicio, 'nidbanda' => $nidbanda, 'nidneumatico' => $nidneumatico, 'nidubicacion' => $nidubicacion, 'nidrencauchadora' => $nidrencauchadora, 'nidcondicion' => $nidcondicion])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getServicios($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('tservicio t0');

		$builder->select("t0.nidservicio idservicio, DATE_FORMAT(t0.tfechaingreso,'%d/%m/%Y') fechaingreso, t0.sobservacioningreso observacioningreso, DATE_FORMAT(t0.tfechasalida,'%d/%m/%Y') fechasalida, t0.sobservacionsalida observacionsalida, t0.bestado estado, t0.scodigo codigo, t1.sidcliente idcliente, t1.snombrecliente nombrecliente, t2.nidubicacion idubicacion, t2.snombretipoubicacion nombretipoubicacion, t3.nidbanda idbanda, t3.snombrebanda nombrebanda, t4.nidcondicion idcondicion, t4.snombrecondicion nombrecondicion, t5.nidneumatico idneumatico, t5.snombreneumatico nombreneumatico, t6.nidrencauchadora idrencauchadora, t6.snombrereencauchadora nombrereencauchadora, t7.nidtiposervicio idtiposervicio, t7.snombretiposervicio nombretiposervicio, t8.sidusuario idusuario, t8.snombreusuario nombreusuario, CONCAT(t1.snombrecliente,' - ',t2.snombretipoubicacion,' - ',t3.snombrebanda,' - ',t4.snombrecondicion,' - ',t5.snombreneumatico,' - ',t6.snombrereencauchadora,' - ',t7.snombretiposervicio,' - ',t8.snombreusuario) concatenado, CONCAT(t1.snombrecliente,' - ',t2.snombretipoubicacion,' - ',t3.snombrebanda,' - ',t4.snombrecondicion,' - ',t5.snombreneumatico,' - ',t6.snombrereencauchadora,' - ',t7.snombretiposervicio,' - ',t8.snombreusuario) concatenadodetalle");

		$builder->join('tcliente t1', 't1.sidcliente = t0.sidcliente');
		$builder->join('tubicacion t2', 't2.nidubicacion = t0.nidubicacion');
		$builder->join('tbanda t3', 't3.nidbanda = t0.nidbanda');
		$builder->join('tcondicion t4', 't4.nidcondicion = t0.nidcondicion');
		$builder->join('tneumatico t5', 't5.nidneumatico = t0.nidneumatico');
		$builder->join('treencauchadora t6', 't6.nidrencauchadora = t0.nidrencauchadora');
		$builder->join('ttiposervicio t7', 't7.nidtiposervicio = t0.nidtiposervicio');
		$builder->join('tusuario t8', 't8.sidusuario = t0.sidusuario');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidservicio', $text)
				->orLike('t1.snombrecliente', $text)
				->orLike('t2.snombretipoubicacion', $text)
				->orLike('t3.snombrebanda', $text)
				->orLike('t4.snombrecondicion', $text)
				->orLike('t5.snombreneumatico', $text)
				->orLike('t6.snombrereencauchadora', $text)
				->orLike('t7.snombretiposervicio', $text)
				->orLike('t8.snombreusuario', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidservicio', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteServicios($todos = 1, $text = ''){
		$builder = $this->conexion('tservicio t0');

		$builder->select("t0.nidservicio idservicio, DATE_FORMAT(t0.tfechaingreso,'%d/%m/%Y') fechaingreso, t0.sobservacioningreso observacioningreso, DATE_FORMAT(t0.tfechasalida,'%d/%m/%Y') fechasalida, t0.sobservacionsalida observacionsalida, t0.bestado estado, t0.scodigo codigo, t1.sidcliente idcliente, t1.snombrecliente nombrecliente, t2.nidubicacion idubicacion, t2.snombretipoubicacion nombretipoubicacion, t3.nidbanda idbanda, t3.snombrebanda nombrebanda, t4.nidcondicion idcondicion, t4.snombrecondicion nombrecondicion, t5.nidneumatico idneumatico, t5.snombreneumatico nombreneumatico, t6.nidrencauchadora idrencauchadora, t6.snombrereencauchadora nombrereencauchadora, t7.nidtiposervicio idtiposervicio, t7.snombretiposervicio nombretiposervicio, t8.sidusuario idusuario, t8.snombreusuario nombreusuario, CONCAT(t1.snombrecliente,' - ',t2.snombretipoubicacion,' - ',t3.snombrebanda,' - ',t4.snombrecondicion,' - ',t5.snombreneumatico,' - ',t6.snombrereencauchadora,' - ',t7.snombretiposervicio,' - ',t8.snombreusuario) concatenado, CONCAT(t1.snombrecliente,' - ',t2.snombretipoubicacion,' - ',t3.snombrebanda,' - ',t4.snombrecondicion,' - ',t5.snombreneumatico,' - ',t6.snombrereencauchadora,' - ',t7.snombretiposervicio,' - ',t8.snombreusuario) concatenadodetalle");
		$builder->join('tcliente t1', 't1.sidcliente = t0.sidcliente');
		$builder->join('tubicacion t2', 't2.nidubicacion = t0.nidubicacion');
		$builder->join('tbanda t3', 't3.nidbanda = t0.nidbanda');
		$builder->join('tcondicion t4', 't4.nidcondicion = t0.nidcondicion');
		$builder->join('tneumatico t5', 't5.nidneumatico = t0.nidneumatico');
		$builder->join('treencauchadora t6', 't6.nidrencauchadora = t0.nidrencauchadora');
		$builder->join('ttiposervicio t7', 't7.nidtiposervicio = t0.nidtiposervicio');
		$builder->join('tusuario t8', 't8.sidusuario = t0.sidusuario');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidservicio', $text)
				->orLike('t1.snombrecliente', $text)
				->orLike('t2.snombretipoubicacion', $text)
				->orLike('t3.snombrebanda', $text)
				->orLike('t4.snombrecondicion', $text)
				->orLike('t5.snombreneumatico', $text)
				->orLike('t6.snombrereencauchadora', $text)
				->orLike('t7.snombretiposervicio', $text)
				->orLike('t8.snombreusuario', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidservicio', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function getservicio($nidservicio, $sidusuario, $sidcliente, $nidtiposervicio, $nidbanda, $nidneumatico, $nidubicacion, $nidrencauchadora, $nidcondicion){
		$builder = $this->conexion('tservicio t0');
		$builder->select("t0.nidservicio idservicio, DATE_FORMAT(t0.tfechaingreso,'%d/%m/%Y') fechaingreso, t0.sidusuario idusuario, t0.sobservacioningreso observacioningreso, t0.sidcliente idcliente, t0.nidtiposervicio idtiposervicio, t0.nidbanda idbanda, t0.nidneumatico idneumatico, t0.nidubicacion idubicacion, t0.nidrencauchadora idrencauchadora, DATE_FORMAT(t0.tfechasalida,'%d/%m/%Y') fechasalida, t0.sobservacionsalida observacionsalida, t0.nidcondicion idcondicion, t0.bestado estado, t0.scodigo codigo");
		$builder->where(['nidservicio' => $nidservicio, 'sidusuario' => $sidusuario, 'sidcliente' => $sidcliente, 'nidtiposervicio' => $nidtiposervicio, 'nidbanda' => $nidbanda, 'nidneumatico' => $nidneumatico, 'nidubicacion' => $nidubicacion, 'nidrencauchadora' => $nidrencauchadora, 'nidcondicion' => $nidcondicion]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getServicio2($id){
		$builder = $this->conexion('tservicio t0');
		$builder->select("t0.nidservicio idservicio, DATE_FORMAT(t0.tfechaingreso,'%d/%m/%Y') fechaingreso, t0.sidusuario idusuario, t0.sobservacioningreso observacioningreso, t0.sidcliente idcliente, t0.nidtiposervicio idtiposervicio, t0.nidbanda idbanda, t0.nidneumatico idneumatico, t0.nidubicacion idubicacion, t0.nidrencauchadora idrencauchadora, DATE_FORMAT(t0.tfechasalida,'%d/%m/%Y') fechasalida, t0.sobservacionsalida observacionsalida, t0.nidcondicion idcondicion, t0.bestado estado, t0.scodigo codigo");
		$builder->join('tcliente t1', 't1.sidcliente = t0.sidcliente');
		$builder->join('tubicacion t2', 't2.nidubicacion = t0.nidubicacion');
		$builder->join('tbanda t3', 't3.nidbanda = t0.nidbanda');
		$builder->join('tcondicion t4', 't4.nidcondicion = t0.nidcondicion');
		$builder->join('tneumatico t5', 't5.nidneumatico = t0.nidneumatico');
		$builder->join('treencauchadora t6', 't6.nidrencauchadora = t0.nidrencauchadora');
		$builder->join('ttiposervicio t7', 't7.nidtiposervicio = t0.nidtiposervicio');
		$builder->join('tusuario t8', 't8.sidusuario = t0.sidusuario');
		$builder->where('t0.nidservicio', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('tservicio t0');
		$builder->select('nidservicio');
		$builder->join('tcliente t1', 't1.sidcliente = t0.sidcliente');
		$builder->join('tubicacion t2', 't2.nidubicacion = t0.nidubicacion');
		$builder->join('tbanda t3', 't3.nidbanda = t0.nidbanda');
		$builder->join('tcondicion t4', 't4.nidcondicion = t0.nidcondicion');
		$builder->join('tneumatico t5', 't5.nidneumatico = t0.nidneumatico');
		$builder->join('treencauchadora t6', 't6.nidrencauchadora = t0.nidrencauchadora');
		$builder->join('ttiposervicio t7', 't7.nidtiposervicio = t0.nidtiposervicio');
		$builder->join('tusuario t8', 't8.sidusuario = t0.sidusuario');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidservicio', $text)
				->orLike('t1.snombrecliente', $text)
				->orLike('t2.snombretipoubicacion', $text)
				->orLike('t3.snombrebanda', $text)
				->orLike('t4.snombrecondicion', $text)
				->orLike('t5.snombreneumatico', $text)
				->orLike('t6.snombrereencauchadora', $text)
				->orLike('t7.snombretiposervicio', $text)
				->orLike('t8.snombreusuario', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateServicio($nidservicio, $datos){
		$builder = $this->conexion('tservicio');
		$builder->where(['nidservicio' => $nidservicio]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('tservicio');
		$builder->selectMax('nidservicio');
		$query = $builder->get();
		return  $query->getResult()[0]->nidservicio;
	}
}
?>
