<?php

namespace App\Models;
use CodeIgniter\Model; 

class ClienteModel extends Model
{
	protected $table      = 'tcliente';
	protected $primaryKey = 'sidcliente';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['sidcliente', 'snombrecliente', 'sdireccion', 'stelefono', 'bestado'];
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
	public function existe($sidcliente){
		return $this->where(['sidcliente' => $sidcliente])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getClientes($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('tcliente t0');

		$builder->select("t0.sidcliente idcliente, t0.snombrecliente nombrecliente, t0.sdireccion direccion, t0.stelefono telefono, t0.bestado estado, CONCAT(t0.snombrecliente) concatenado, CONCAT(t0.snombrecliente) concatenadodetalle");


		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.sidcliente', $text)
				->orLike('t0.snombrecliente', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.sidcliente', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteClientes($todos = 1, $text = ''){
		$builder = $this->conexion('tcliente t0');

		$builder->select("t0.sidcliente idcliente, t0.snombrecliente nombrecliente, t0.sdireccion direccion, t0.stelefono telefono, t0.bestado estado, CONCAT(t0.snombrecliente) concatenado, CONCAT(t0.snombrecliente) concatenadodetalle");

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.sidcliente', $text)
				->orLike('t0.snombrecliente', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.sidcliente', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function getcliente($sidcliente){
		$builder = $this->conexion('tcliente t0');
		$builder->select("t0.sidcliente idcliente, t0.snombrecliente nombrecliente, t0.sdireccion direccion, t0.stelefono telefono, t0.bestado estado");
		$builder->where(['sidcliente' => $sidcliente]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getCliente2($id){
		$builder = $this->conexion('tcliente t0');
		$builder->select("t0.sidcliente idcliente, t0.snombrecliente nombrecliente, t0.sdireccion direccion, t0.stelefono telefono, t0.bestado estado");
		$builder->where('t0.sidcliente', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('tcliente t0');
		$builder->select('sidcliente');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.sidcliente', $text)
				->orLike('t0.snombrecliente', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateCliente($sidcliente,  $datos){
		$builder = $this->conexion('tcliente');
		$builder->where(['sidcliente' => $sidcliente]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('tcliente');
		$builder->selectMax('sidcliente');
		$query = $builder->get();
		return  $query->getResult()[0]->sidcliente;
	}
}
?>
