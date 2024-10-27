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

		$builder->select("t0.nidauditoria idauditoria, t0.scampo_modificado campo_modificado, t0.svalor_anterior valor_anterior, t0.svalor_nuevo valor_nuevo, DATE_FORMAT(t0.tfecha_modificacion,'%d/%m/%Y') fecha_modificacion, t0.susuario_modificacion usuario_modificacion, t0.bestado estado, t1.nidservicio idservicio, t2.nidbanda idbanda, t2.snombrebanda nombrebanda, t3.nidcondicion idcondicion, t3.snombrecondicion nombrecondicion, t4.nidmarca idmarca, t4.snombremarca nombremarca, t5.nidmedida idmedida, t5.snombremedida nombremedida, t6.nidreencauchadora idreencauchadora, t6.snombrereencauchadora nombrereencauchadora, t7.nidtiposervicio idtiposervicio, t7.snombretiposervicio nombretiposervicio, t8.nidubicacion idubicacion, t8.snombretipoubicacion nombretipoubicacion, t9.sidcliente idcliente, t9.snombrecliente nombrecliente, CONCAT(t2.snombrebanda,' - ',t3.snombrecondicion,' - ',t4.snombremarca,' - ',t5.snombremedida,' - ',t6.snombrereencauchadora,' - ',t7.snombretiposervicio,' - ',t8.snombretipoubicacion,' - ',t9.snombrecliente) concatenado, CONCAT(t2.snombrebanda,' - ',t3.snombrecondicion,' - ',t4.snombremarca,' - ',t5.snombremedida,' - ',t6.snombrereencauchadora,' - ',t7.snombretiposervicio,' - ',t8.snombretipoubicacion,' - ',t9.snombrecliente) concatenadodetalle");

		$builder->join('tservicio t1', 't1.nidservicio = t0.nidservicio');
		$builder->join('tbanda t2', 't2.nidbanda = t1.nidbanda');
		$builder->join('tcondicion t3', 't3.nidcondicion = t1.nidcondicion');
		$builder->join('tmarca t4', 't4.nidmarca = t1.nidmarca');
		$builder->join('tmedida t5', 't5.nidmedida = t1.nidmedida');
		$builder->join('treencauchadora t6', 't6.nidreencauchadora = t1.nidreencauchadora');
		$builder->join('ttiposervicio t7', 't7.nidtiposervicio = t1.nidtiposervicio');
		$builder->join('tubicacion t8', 't8.nidubicacion = t1.nidubicacion');
		$builder->join('tcliente t9', 't9.sidcliente = t1.sidcliente');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidauditoria', $text)
				->orLike('t2.snombrebanda', $text)
				->orLike('t3.snombrecondicion', $text)
				->orLike('t4.snombremarca', $text)
				->orLike('t5.snombremedida', $text)
				->orLike('t6.snombrereencauchadora', $text)
				->orLike('t7.snombretiposervicio', $text)
				->orLike('t8.snombretipoubicacion', $text)
				->orLike('t9.snombrecliente', $text)
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

		$builder->select("t0.nidauditoria idauditoria, t0.scampo_modificado campo_modificado, t0.svalor_anterior valor_anterior, t0.svalor_nuevo valor_nuevo, DATE_FORMAT(t0.tfecha_modificacion,'%d/%m/%Y') fecha_modificacion, t0.susuario_modificacion usuario_modificacion, t0.bestado estado, t1.nidservicio idservicio, t2.nidbanda idbanda, t2.snombrebanda nombrebanda, t3.nidcondicion idcondicion, t3.snombrecondicion nombrecondicion, t4.nidmarca idmarca, t4.snombremarca nombremarca, t5.nidmedida idmedida, t5.snombremedida nombremedida, t6.nidreencauchadora idreencauchadora, t6.snombrereencauchadora nombrereencauchadora, t7.nidtiposervicio idtiposervicio, t7.snombretiposervicio nombretiposervicio, t8.nidubicacion idubicacion, t8.snombretipoubicacion nombretipoubicacion, t9.sidcliente idcliente, t9.snombrecliente nombrecliente, CONCAT(t2.snombrebanda,' - ',t3.snombrecondicion,' - ',t4.snombremarca,' - ',t5.snombremedida,' - ',t6.snombrereencauchadora,' - ',t7.snombretiposervicio,' - ',t8.snombretipoubicacion,' - ',t9.snombrecliente) concatenado, CONCAT(t2.snombrebanda,' - ',t3.snombrecondicion,' - ',t4.snombremarca,' - ',t5.snombremedida,' - ',t6.snombrereencauchadora,' - ',t7.snombretiposervicio,' - ',t8.snombretipoubicacion,' - ',t9.snombrecliente) concatenadodetalle");
		$builder->join('tservicio t1', 't1.nidservicio = t0.nidservicio');
		$builder->join('tbanda t2', 't2.nidbanda = t1.nidbanda');
		$builder->join('tcondicion t3', 't3.nidcondicion = t1.nidcondicion');
		$builder->join('tmarca t4', 't4.nidmarca = t1.nidmarca');
		$builder->join('tmedida t5', 't5.nidmedida = t1.nidmedida');
		$builder->join('treencauchadora t6', 't6.nidreencauchadora = t1.nidreencauchadora');
		$builder->join('ttiposervicio t7', 't7.nidtiposervicio = t1.nidtiposervicio');
		$builder->join('tubicacion t8', 't8.nidubicacion = t1.nidubicacion');
		$builder->join('tcliente t9', 't9.sidcliente = t1.sidcliente');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidauditoria', $text)
				->orLike('t2.snombrebanda', $text)
				->orLike('t3.snombrecondicion', $text)
				->orLike('t4.snombremarca', $text)
				->orLike('t5.snombremedida', $text)
				->orLike('t6.snombrereencauchadora', $text)
				->orLike('t7.snombretiposervicio', $text)
				->orLike('t8.snombretipoubicacion', $text)
				->orLike('t9.snombrecliente', $text)
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
		$builder->select("t0.nidauditoria idauditoria, t0.nidservicio idservicio, t0.scampo_modificado campo_modificado, t0.svalor_anterior valor_anterior, t0.svalor_nuevo valor_nuevo, t0.tfecha_modificacion fecha_modificacion, t0.susuario_modificacion usuario_modificacion, t0.bestado estado");
		$builder->where(['nidservicio' => $nidservicio]);
		$builder->orderBy('t0.nidauditoria', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

//   SECCION ====== GET 2 ======
	public function getAuditoria2($id){
		$builder = $this->conexion('tauditoria t0');
		$builder->select("t0.nidauditoria idauditoria, t0.nidservicio idservicio, t0.scampo_modificado campo_modificado, t0.svalor_anterior valor_anterior, t0.svalor_nuevo valor_nuevo, DATE_FORMAT(t0.tfecha_modificacion,'%d/%m/%Y') fecha_modificacion, t0.susuario_modificacion usuario_modificacion, t0.bestado estado");
		$builder->join('tservicio t1', 't1.nidservicio = t0.nidservicio');
		$builder->join('tbanda t2', 't2.nidbanda = t1.nidbanda');
		$builder->join('tcondicion t3', 't3.nidcondicion = t1.nidcondicion');
		$builder->join('tmarca t4', 't4.nidmarca = t1.nidmarca');
		$builder->join('tmedida t5', 't5.nidmedida = t1.nidmedida');
		$builder->join('treencauchadora t6', 't6.nidreencauchadora = t1.nidreencauchadora');
		$builder->join('ttiposervicio t7', 't7.nidtiposervicio = t1.nidtiposervicio');
		$builder->join('tubicacion t8', 't8.nidubicacion = t1.nidubicacion');
		$builder->join('tcliente t9', 't9.sidcliente = t1.sidcliente');
		$builder->where('t0.nidauditoria', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('tauditoria t0');
		$builder->select('nidauditoria');
		$builder->join('tservicio t1', 't1.nidservicio = t0.nidservicio');
		$builder->join('tbanda t2', 't2.nidbanda = t1.nidbanda');
		$builder->join('tcondicion t3', 't3.nidcondicion = t1.nidcondicion');
		$builder->join('tmarca t4', 't4.nidmarca = t1.nidmarca');
		$builder->join('tmedida t5', 't5.nidmedida = t1.nidmedida');
		$builder->join('treencauchadora t6', 't6.nidreencauchadora = t1.nidreencauchadora');
		$builder->join('ttiposervicio t7', 't7.nidtiposervicio = t1.nidtiposervicio');
		$builder->join('tubicacion t8', 't8.nidubicacion = t1.nidubicacion');
		$builder->join('tcliente t9', 't9.sidcliente = t1.sidcliente');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidauditoria', $text)
				->orLike('t2.snombrebanda', $text)
				->orLike('t3.snombrecondicion', $text)
				->orLike('t4.snombremarca', $text)
				->orLike('t5.snombremedida', $text)
				->orLike('t6.snombrereencauchadora', $text)
				->orLike('t7.snombretiposervicio', $text)
				->orLike('t8.snombretipoubicacion', $text)
				->orLike('t9.snombrecliente', $text)
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
