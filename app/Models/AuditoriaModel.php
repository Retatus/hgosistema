<?php

namespace App\Models;
use CodeIgniter\Model; 

class AuditoriaModel extends Model
{
	protected $table      = 'tauditoria';
	protected $primaryKey = 'nidauditoria';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidauditoria', 'nidservicio', 'scampo_modificado', 'svalor_anterior', 'svalor_nuevo', 'tfecha_modificacion', 'susuario_modificacion', 'bestado'];
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
	public function existe($nidauditoria, $nidservicio){
		return $this->where(['nidauditoria' => $nidauditoria, 'nidservicio' => $nidservicio])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getAuditorias($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('tauditoria t0');

		$builder->select("t0.nidauditoria idauditoria, t0.scampo_modificado campo_modificado, t0.svalor_anterior valor_anterior, t0.svalor_nuevo valor_nuevo, DATE_FORMAT(t0.tfecha_modificacion,'%d/%m/%Y') fecha_modificacion, t0.susuario_modificacion usuario_modificacion, t0.bestado estado, t1.nidservicio idservicio, t2.sidcliente idcliente, t2.snombrecliente nombrecliente, t3.nidubicacion idubicacion, t3.snombretipoubicacion nombretipoubicacion, t4.nidbanda idbanda, t4.snombrebanda nombrebanda, t5.nidcondicion idcondicion, t5.snombrecondicion nombrecondicion, t6.nidneumatico idneumatico, t6.snombreneumatico nombreneumatico, t7.nidrencauchadora idrencauchadora, t7.snombrereencauchadora nombrereencauchadora, t8.nidtiposervicio idtiposervicio, t8.snombretiposervicio nombretiposervicio, CONCAT(t2.snombrecliente,' - ',t3.snombretipoubicacion,' - ',t4.snombrebanda,' - ',t5.snombrecondicion,' - ',t6.snombreneumatico,' - ',t7.snombrereencauchadora,' - ',t8.snombretiposervicio) concatenado, CONCAT(t2.snombrecliente,' - ',t3.snombretipoubicacion,' - ',t4.snombrebanda,' - ',t5.snombrecondicion,' - ',t6.snombreneumatico,' - ',t7.snombrereencauchadora,' - ',t8.snombretiposervicio) concatenadodetalle");

		$builder->join('tservicio t1', 't1.nidservicio = t0.nidservicio');
		$builder->join('tcliente t2', 't2.sidcliente = t1.sidcliente');
		$builder->join('tubicacion t3', 't3.nidubicacion = t1.nidubicacion');
		$builder->join('tbanda t4', 't4.nidbanda = t1.nidbanda');
		$builder->join('tcondicion t5', 't5.nidcondicion = t1.nidcondicion');
		$builder->join('tneumatico t6', 't6.nidneumatico = t1.nidneumatico');
		$builder->join('treencauchadora t7', 't7.nidrencauchadora = t1.nidrencauchadora');
		$builder->join('ttiposervicio t8', 't8.nidtiposervicio = t1.nidtiposervicio');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidauditoria', $text)
				->orLike('t2.snombrecliente', $text)
				->orLike('t3.snombretipoubicacion', $text)
				->orLike('t4.snombrebanda', $text)
				->orLike('t5.snombrecondicion', $text)
				->orLike('t6.snombreneumatico', $text)
				->orLike('t7.snombrereencauchadora', $text)
				->orLike('t8.snombretiposervicio', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidauditoria', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteAuditorias($todos = 1, $text = ''){
		$builder = $this->conexion('tauditoria t0');

		$builder->select("t0.nidauditoria idauditoria, t0.scampo_modificado campo_modificado, t0.svalor_anterior valor_anterior, t0.svalor_nuevo valor_nuevo, DATE_FORMAT(t0.tfecha_modificacion,'%d/%m/%Y') fecha_modificacion, t0.susuario_modificacion usuario_modificacion, t0.bestado estado, t1.nidservicio idservicio, t2.sidcliente idcliente, t2.snombrecliente nombrecliente, t3.nidubicacion idubicacion, t3.snombretipoubicacion nombretipoubicacion, t4.nidbanda idbanda, t4.snombrebanda nombrebanda, t5.nidcondicion idcondicion, t5.snombrecondicion nombrecondicion, t6.nidneumatico idneumatico, t6.snombreneumatico nombreneumatico, t7.nidrencauchadora idrencauchadora, t7.snombrereencauchadora nombrereencauchadora, t8.nidtiposervicio idtiposervicio, t8.snombretiposervicio nombretiposervicio, CONCAT(t2.snombrecliente,' - ',t3.snombretipoubicacion,' - ',t4.snombrebanda,' - ',t5.snombrecondicion,' - ',t6.snombreneumatico,' - ',t7.snombrereencauchadora,' - ',t8.snombretiposervicio) concatenado, CONCAT(t2.snombrecliente,' - ',t3.snombretipoubicacion,' - ',t4.snombrebanda,' - ',t5.snombrecondicion,' - ',t6.snombreneumatico,' - ',t7.snombrereencauchadora,' - ',t8.snombretiposervicio) concatenadodetalle");
		$builder->join('tservicio t1', 't1.nidservicio = t0.nidservicio');
		$builder->join('tcliente t2', 't2.sidcliente = t1.sidcliente');
		$builder->join('tubicacion t3', 't3.nidubicacion = t1.nidubicacion');
		$builder->join('tbanda t4', 't4.nidbanda = t1.nidbanda');
		$builder->join('tcondicion t5', 't5.nidcondicion = t1.nidcondicion');
		$builder->join('tneumatico t6', 't6.nidneumatico = t1.nidneumatico');
		$builder->join('treencauchadora t7', 't7.nidrencauchadora = t1.nidrencauchadora');
		$builder->join('ttiposervicio t8', 't8.nidtiposervicio = t1.nidtiposervicio');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidauditoria', $text)
				->orLike('t2.snombrecliente', $text)
				->orLike('t3.snombretipoubicacion', $text)
				->orLike('t4.snombrebanda', $text)
				->orLike('t5.snombrecondicion', $text)
				->orLike('t6.snombreneumatico', $text)
				->orLike('t7.snombrereencauchadora', $text)
				->orLike('t8.snombretiposervicio', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidauditoria', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function getauditoria($nidauditoria, $nidservicio){
		$builder = $this->conexion('tauditoria t0');
		$builder->select("t0.nidauditoria idauditoria, t0.nidservicio idservicio, t0.scampo_modificado campo_modificado, t0.svalor_anterior valor_anterior, t0.svalor_nuevo valor_nuevo, DATE_FORMAT(t0.tfecha_modificacion,'%d/%m/%Y') fecha_modificacion, t0.susuario_modificacion usuario_modificacion, t0.bestado estado");
		$builder->where(['nidauditoria' => $nidauditoria, 'nidservicio' => $nidservicio]);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getauditoriaServicio($nidservicio){
		$builder = $this->conexion('tauditoria t0');
		$builder->select("t0.nidauditoria idauditoria, t0.nidservicio idservicio, t0.scampo_modificado campo_modificado, t0.svalor_anterior valor_anterior, t0.svalor_nuevo valor_nuevo, DATE_FORMAT(t0.tfecha_modificacion,'%d/%m/%Y') fecha_modificacion, t0.susuario_modificacion usuario_modificacion, t0.bestado estado");
		$builder->where(['nidservicio' => $nidservicio]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getAuditoria2($id){
		$builder = $this->conexion('tauditoria t0');
		$builder->select("t0.nidauditoria idauditoria, t0.nidservicio idservicio, t0.scampo_modificado campo_modificado, t0.svalor_anterior valor_anterior, t0.svalor_nuevo valor_nuevo, DATE_FORMAT(t0.tfecha_modificacion,'%d/%m/%Y') fecha_modificacion, t0.susuario_modificacion usuario_modificacion, t0.bestado estado");
		$builder->join('tservicio t1', 't1.nidservicio = t0.nidservicio');
		$builder->join('tcliente t2', 't2.sidcliente = t1.sidcliente');
		$builder->join('tubicacion t3', 't3.nidubicacion = t1.nidubicacion');
		$builder->join('tbanda t4', 't4.nidbanda = t1.nidbanda');
		$builder->join('tcondicion t5', 't5.nidcondicion = t1.nidcondicion');
		$builder->join('tneumatico t6', 't6.nidneumatico = t1.nidneumatico');
		$builder->join('treencauchadora t7', 't7.nidrencauchadora = t1.nidrencauchadora');
		$builder->join('ttiposervicio t8', 't8.nidtiposervicio = t1.nidtiposervicio');
		$builder->where('t0.nidauditoria', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('tauditoria t0');
		$builder->select('nidauditoria');
		$builder->join('tservicio t1', 't1.nidservicio = t0.nidservicio');
		$builder->join('tcliente t2', 't2.sidcliente = t1.sidcliente');
		$builder->join('tubicacion t3', 't3.nidubicacion = t1.nidubicacion');
		$builder->join('tbanda t4', 't4.nidbanda = t1.nidbanda');
		$builder->join('tcondicion t5', 't5.nidcondicion = t1.nidcondicion');
		$builder->join('tneumatico t6', 't6.nidneumatico = t1.nidneumatico');
		$builder->join('treencauchadora t7', 't7.nidrencauchadora = t1.nidrencauchadora');
		$builder->join('ttiposervicio t8', 't8.nidtiposervicio = t1.nidtiposervicio');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidauditoria', $text)
				->orLike('t2.snombrecliente', $text)
				->orLike('t3.snombretipoubicacion', $text)
				->orLike('t4.snombrebanda', $text)
				->orLike('t5.snombrecondicion', $text)
				->orLike('t6.snombreneumatico', $text)
				->orLike('t7.snombrereencauchadora', $text)
				->orLike('t8.snombretiposervicio', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateAuditoria($nidauditoria, $datos){
		$builder = $this->conexion('tauditoria');
		$builder->where(['nidauditoria' => $nidauditoria]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('tauditoria');
		$builder->selectMax('nidauditoria');
		$query = $builder->get();
		return  $query->getResult()[0]->nidauditoria;
	}
}
?>
