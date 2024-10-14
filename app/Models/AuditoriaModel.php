<?php

namespace App\Models;
use CodeIgniter\Model; 

class AuditoriaModel extends Model
{
	protected $table      = 'tauditoria';
	protected $primaryKey = 'nidauditoria';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidauditoria', 'nidservicio', 'campo_modificado', 'valor_anterior', 'valor_nuevo', 'fecha_modificacion', 'usuario_modificacion'];
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

		$builder->select("t0.nidauditoria idauditoria, t0.campo_modificado ampo_modificado, t0.valor_anterior alor_anterior, t0.valor_nuevo alor_nuevo, DATE_FORMAT(t0.fecha_modificacion,'%d/%m/%Y') echa_modificacion, t0.usuario_modificacion suario_modificacion");


		if ($todos !== '') {
			$builder->where('t0.', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidauditoria', $text)
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

		$builder->select("t0.nidauditoria idauditoria, t0.campo_modificado ampo_modificado, t0.valor_anterior alor_anterior, t0.valor_nuevo alor_nuevo, DATE_FORMAT(t0.fecha_modificacion,'%d/%m/%Y') echa_modificacion, t0.usuario_modificacion suario_modificacion");

		if ($todos !== '') {
			$builder->where('t0.', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidauditoria', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidauditoria', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function getauditoria($nidauditoria, $nidservicio){
		$builder = $this->conexion('tauditoria t0');
		$builder->select("t0.nidauditoria idauditoria, t0.nidservicio idservicio, t0.campo_modificado ampo_modificado, t0.valor_anterior alor_anterior, t0.valor_nuevo alor_nuevo, DATE_FORMAT(t0.fecha_modificacion,'%d/%m/%Y') echa_modificacion, t0.usuario_modificacion suario_modificacion");
		$builder->where(['nidauditoria' => $nidauditoria, 'nidservicio' => $nidservicio]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getAuditoria2($id){
		$builder = $this->conexion('tauditoria t0');
		$builder->select("t0.nidauditoria idauditoria, t0.nidservicio idservicio, t0.campo_modificado ampo_modificado, t0.valor_anterior alor_anterior, t0.valor_nuevo alor_nuevo, DATE_FORMAT(t0.fecha_modificacion,'%d/%m/%Y') echa_modificacion, t0.usuario_modificacion suario_modificacion");
		$builder->where('t0.nidauditoria', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('tauditoria t0');
		$builder->select('nidauditoria');

		if ($todos !== '') {
			$builder->where('t0.', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidauditoria', $text)
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
