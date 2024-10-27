<?php

namespace App\Models;
use CodeIgniter\Model; 

class ServicioModel extends Model
{
	protected $table      = 'tservicio';
	protected $primaryKey = 'nidservicio';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidservicio', 'sidcliente', 'tfecharecepcion', 'nidbanda', 'splaca', 'sobservacioningreso', 'nidtiposervicio', 'nidmedida', 'nidmarca', 'scodigo', 'nidubicacion', 'nidreencauchadora', 'tfechatienda', 'nidcondicion', 'tfechaentrega', 'sobservacionsalida', 'susuario', 'bformaestado', 'sdocrefrencia', 'bestado'];
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
	public function existe($nidservicio, $sidcliente, $nidbanda, $nidtiposervicio, $nidmedida, $nidmarca, $nidubicacion, $nidreencauchadora, $nidcondicion){
		return $this->where(['nidservicio' => $nidservicio, 'sidcliente' => $sidcliente, 'nidbanda' => $nidbanda, 'nidtiposervicio' => $nidtiposervicio, 'nidmedida' => $nidmedida, 'nidmarca' => $nidmarca, 'nidubicacion' => $nidubicacion, 'nidreencauchadora' => $nidreencauchadora, 'nidcondicion' => $nidcondicion])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getServicios($total, $pag = 1, $todos = 1, $todos2 = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $todos2, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('tservicio t0');

		$builder->select("t0.nidservicio idservicio, DATE_FORMAT(t0.tfecharecepcion,'%d/%m/%Y') fecharecepcion, t0.splaca placa, t0.sobservacioningreso observacioningreso, t0.scodigo codigo, DATE_FORMAT(t0.tfechatienda,'%d/%m/%Y') fechatienda, DATE_FORMAT(t0.tfechaentrega,'%d/%m/%Y') fechaentrega, t0.sobservacionsalida observacionsalida, t0.susuario usuario, t0.bformaestado formaestado, t0.sdocrefrencia docrefrencia, t0.bestado estado, t1.nidbanda idbanda, t1.snombrebanda nombrebanda, t2.nidcondicion idcondicion, t2.snombrecondicion nombrecondicion, t3.nidmarca idmarca, t3.snombremarca nombremarca, t4.nidmedida idmedida, t4.snombremedida nombremedida, t5.nidreencauchadora idreencauchadora, t5.snombrereencauchadora nombrereencauchadora, t6.nidtiposervicio idtiposervicio, t6.snombretiposervicio nombretiposervicio, t7.nidubicacion idubicacion, t7.snombretipoubicacion nombretipoubicacion, t8.sidcliente idcliente, t8.snombrecliente nombrecliente, CONCAT(t1.snombrebanda,' - ',t2.snombrecondicion,' - ',t3.snombremarca,' - ',t4.snombremedida,' - ',t5.snombrereencauchadora,' - ',t6.snombretiposervicio,' - ',t7.snombretipoubicacion,' - ',t8.snombrecliente) concatenado, CONCAT(t1.snombrebanda,' - ',t2.snombrecondicion,' - ',t3.snombremarca,' - ',t4.snombremedida,' - ',t5.snombrereencauchadora,' - ',t6.snombretiposervicio,' - ',t7.snombretipoubicacion,' - ',t8.snombrecliente) concatenadodetalle");

		$builder->join('tbanda t1', 't1.nidbanda = t0.nidbanda');
		$builder->join('tcondicion t2', 't2.nidcondicion = t0.nidcondicion');
		$builder->join('tmarca t3', 't3.nidmarca = t0.nidmarca');
		$builder->join('tmedida t4', 't4.nidmedida = t0.nidmedida');
		$builder->join('treencauchadora t5', 't5.nidreencauchadora = t0.nidreencauchadora');
		$builder->join('ttiposervicio t6', 't6.nidtiposervicio = t0.nidtiposervicio');
		$builder->join('tubicacion t7', 't7.nidubicacion = t0.nidubicacion');
		$builder->join('tcliente t8', 't8.sidcliente = t0.sidcliente');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($todos2 !== '') {
			$builder->where('t0.bformaestado', intval($todos2));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidservicio', $text)
				->orLike('t0.splaca', $text)
				->orLike('t0.scodigo', $text)
				->orLike('t1.snombrebanda', $text)
				->orLike('t2.snombrecondicion', $text)
				->orLike('t3.snombremarca', $text)
				->orLike('t4.snombremedida', $text)
				->orLike('t5.snombrereencauchadora', $text)
				->orLike('t6.snombretiposervicio', $text)
				->orLike('t7.snombretipoubicacion', $text)
				->orLike('t8.sidcliente', $text)
				->orLike('t8.snombrecliente', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidservicio', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteServicios($todos = 1, $todos2 = 1, $text = ''){
		$builder = $this->conexion('tservicio t0');

		$builder->select("t0.nidservicio idservicio, DATE_FORMAT(t0.tfecharecepcion,'%d/%m/%Y') fecharecepcion, t0.splaca placa, t0.sobservacioningreso observacioningreso, t0.scodigo codigo, DATE_FORMAT(t0.tfechatienda,'%d/%m/%Y') fechatienda, DATE_FORMAT(t0.tfechaentrega,'%d/%m/%Y') fechaentrega, t0.sobservacionsalida observacionsalida, t0.susuario usuario, t0.bformaestado formaestado, t0.sdocrefrencia docrefrencia, t0.bestado estado, t1.nidbanda idbanda, t1.snombrebanda nombrebanda, t2.nidcondicion idcondicion, t2.snombrecondicion nombrecondicion, t3.nidmarca idmarca, t3.snombremarca nombremarca, t4.nidmedida idmedida, t4.snombremedida nombremedida, t5.nidreencauchadora idreencauchadora, t5.snombrereencauchadora nombrereencauchadora, t6.nidtiposervicio idtiposervicio, t6.snombretiposervicio nombretiposervicio, t7.nidubicacion idubicacion, t7.snombretipoubicacion nombretipoubicacion, t8.sidcliente idcliente, t8.snombrecliente nombrecliente, CONCAT(t1.snombrebanda,' - ',t2.snombrecondicion,' - ',t3.snombremarca,' - ',t4.snombremedida,' - ',t5.snombrereencauchadora,' - ',t6.snombretiposervicio,' - ',t7.snombretipoubicacion,' - ',t8.snombrecliente) concatenado, CONCAT(t1.snombrebanda,' - ',t2.snombrecondicion,' - ',t3.snombremarca,' - ',t4.snombremedida,' - ',t5.snombrereencauchadora,' - ',t6.snombretiposervicio,' - ',t7.snombretipoubicacion,' - ',t8.snombrecliente) concatenadodetalle");
		$builder->join('tbanda t1', 't1.nidbanda = t0.nidbanda');
		$builder->join('tcondicion t2', 't2.nidcondicion = t0.nidcondicion');
		$builder->join('tmarca t3', 't3.nidmarca = t0.nidmarca');
		$builder->join('tmedida t4', 't4.nidmedida = t0.nidmedida');
		$builder->join('treencauchadora t5', 't5.nidreencauchadora = t0.nidreencauchadora');
		$builder->join('ttiposervicio t6', 't6.nidtiposervicio = t0.nidtiposervicio');
		$builder->join('tubicacion t7', 't7.nidubicacion = t0.nidubicacion');
		$builder->join('tcliente t8', 't8.sidcliente = t0.sidcliente');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($todos2 !== '') {
			$builder->where('t0.bformaestado', intval($todos2));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidservicio', $text)
				->orLike('t1.snombrebanda', $text)
				->orLike('t2.snombrecondicion', $text)
				->orLike('t3.snombremarca', $text)
				->orLike('t4.snombremedida', $text)
				->orLike('t5.snombrereencauchadora', $text)
				->orLike('t6.snombretiposervicio', $text)
				->orLike('t7.snombretipoubicacion', $text)
				->orLike('t8.snombrecliente', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidservicio', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function getservicio($nidservicio, $sidcliente, $nidbanda, $nidtiposervicio, $nidmedida, $nidmarca, $nidubicacion, $nidreencauchadora, $nidcondicion){
		$builder = $this->conexion('tservicio t0');
		$builder->select("t0.nidservicio idservicio, t0.sidcliente idcliente, DATE_FORMAT(t0.tfecharecepcion,'%d/%m/%Y') fecharecepcion, t0.nidbanda idbanda, t0.splaca placa, t0.sobservacioningreso observacioningreso, t0.nidtiposervicio idtiposervicio, t0.nidmedida idmedida, t0.nidmarca idmarca, t0.scodigo codigo, t0.nidubicacion idubicacion, t0.nidreencauchadora idreencauchadora, DATE_FORMAT(t0.tfechatienda,'%d/%m/%Y') fechatienda, t0.nidcondicion idcondicion, DATE_FORMAT(t0.tfechaentrega,'%d/%m/%Y') fechaentrega, t0.sobservacionsalida observacionsalida, t0.susuario usuario, t0.bformaestado formaestado, t0.sdocrefrencia docrefrencia, t0.bestado estado");
		$builder->where(['nidservicio' => $nidservicio, 'sidcliente' => $sidcliente, 'nidbanda' => $nidbanda, 'nidtiposervicio' => $nidtiposervicio, 'nidmedida' => $nidmedida, 'nidmarca' => $nidmarca, 'nidubicacion' => $nidubicacion, 'nidreencauchadora' => $nidreencauchadora, 'nidcondicion' => $nidcondicion]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getServicio2($id){
		$builder = $this->conexion('tservicio t0');
		$builder->select("t0.nidservicio idservicio, t0.sidcliente idcliente, DATE_FORMAT(t0.tfecharecepcion,'%d/%m/%Y') fecharecepcion, t0.nidbanda idbanda, t0.splaca placa, t0.sobservacioningreso observacioningreso, t0.nidtiposervicio idtiposervicio, t0.nidmedida idmedida, t0.nidmarca idmarca, t0.scodigo codigo, t0.nidubicacion idubicacion, t0.nidreencauchadora idreencauchadora, DATE_FORMAT(t0.tfechatienda,'%d/%m/%Y') fechatienda, t0.nidcondicion idcondicion, DATE_FORMAT(t0.tfechaentrega,'%d/%m/%Y') fechaentrega, t0.sobservacionsalida observacionsalida, t0.susuario usuario, t0.bformaestado formaestado, t0.sdocrefrencia docrefrencia, t0.bestado estado");
		$builder->join('tbanda t1', 't1.nidbanda = t0.nidbanda');
		$builder->join('tcondicion t2', 't2.nidcondicion = t0.nidcondicion');
		$builder->join('tmarca t3', 't3.nidmarca = t0.nidmarca');
		$builder->join('tmedida t4', 't4.nidmedida = t0.nidmedida');
		$builder->join('treencauchadora t5', 't5.nidreencauchadora = t0.nidreencauchadora');
		$builder->join('ttiposervicio t6', 't6.nidtiposervicio = t0.nidtiposervicio');
		$builder->join('tubicacion t7', 't7.nidubicacion = t0.nidubicacion');
		$builder->join('tcliente t8', 't8.sidcliente = t0.sidcliente');
		$builder->where('t0.nidservicio', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $todos2 = 1, $text = ''){
		$builder = $this->conexion('tservicio t0');
		$builder->select('nidservicio');
		$builder->join('tbanda t1', 't1.nidbanda = t0.nidbanda');
		$builder->join('tcondicion t2', 't2.nidcondicion = t0.nidcondicion');
		$builder->join('tmarca t3', 't3.nidmarca = t0.nidmarca');
		$builder->join('tmedida t4', 't4.nidmedida = t0.nidmedida');
		$builder->join('treencauchadora t5', 't5.nidreencauchadora = t0.nidreencauchadora');
		$builder->join('ttiposervicio t6', 't6.nidtiposervicio = t0.nidtiposervicio');
		$builder->join('tubicacion t7', 't7.nidubicacion = t0.nidubicacion');
		$builder->join('tcliente t8', 't8.sidcliente = t0.sidcliente');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($todos2 !== '') {
			$builder->where('t0.bformaestado', intval($todos2));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidservicio', $text)
				->orLike('t0.splaca', $text)
				->orLike('t0.scodigo', $text)
				->orLike('t1.snombrebanda', $text)
				->orLike('t2.snombrecondicion', $text)
				->orLike('t3.snombremarca', $text)
				->orLike('t4.snombremedida', $text)
				->orLike('t5.snombrereencauchadora', $text)
				->orLike('t6.snombretiposervicio', $text)
				->orLike('t7.snombretipoubicacion', $text)
				->orLike('t8.sidcliente', $text)
				->orLike('t8.snombrecliente', $text)
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
