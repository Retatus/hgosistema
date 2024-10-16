<?php

namespace App\Models;
use CodeIgniter\Model; 

class UsuarioModel extends Model
{
	protected $table      = 'tusuario';
	protected $primaryKey = 'nusuarioid';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nusuarioid', 'susuarionrodoc', 'susuariotipodoc', 'susuarionombre', 'susuariotelefono', 'susuariopassword', 'nusuariotiporol', 'busuarioestado'];
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
	public function existe($nusuarioid){
		return $this->where(['nusuarioid' => $nusuarioid])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getUsuarios($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('tusuario t0');

		$builder->select("t0.nusuarioid usuarioid, t0.susuarionrodoc usuarionrodoc, t0.susuariotipodoc usuariotipodoc, t0.susuarionombre usuarionombre, t0.susuariotelefono usuariotelefono, t0.susuariopassword usuariopassword, t0.nusuariotiporol usuariotiporol, t0.busuarioestado usuarioestado, CONCAT(t0.susuarionombre) concatenado, CONCAT(t0.susuarionombre) concatenadodetalle");


		if ($todos !== '') {
			$builder->where('t0.busuarioestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nusuarioid', $text)
				->orLike('t0.susuarionombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nusuarioid', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteUsuarios($todos = 1, $text = ''){
		$builder = $this->conexion('tusuario t0');

		$builder->select("t0.nusuarioid usuarioid, t0.susuarionrodoc usuarionrodoc, t0.susuariotipodoc usuariotipodoc, t0.susuarionombre usuarionombre, t0.susuariotelefono usuariotelefono, t0.susuariopassword usuariopassword, t0.nusuariotiporol usuariotiporol, t0.busuarioestado usuarioestado, CONCAT(t0.susuarionombre) concatenado, CONCAT(t0.susuarionombre) concatenadodetalle");

		if ($todos !== '') {
			$builder->where('t0.busuarioestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nusuarioid', $text)
				->orLike('t0.susuarionombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nusuarioid', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function getusuario($nusuarioid){
		$builder = $this->conexion('tusuario t0');
		$builder->select("t0.nusuarioid usuarioid, t0.susuarionrodoc usuarionrodoc, t0.susuariotipodoc usuariotipodoc, t0.susuarionombre usuarionombre, t0.susuariotelefono usuariotelefono, t0.susuariopassword usuariopassword, t0.nusuariotiporol usuariotiporol, t0.busuarioestado usuarioestado");
		$builder->where(['nusuarioid' => $nusuarioid]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getUsuario2($id){
		$builder = $this->conexion('tusuario t0');
		$builder->select("t0.nusuarioid usuarioid, t0.susuarionrodoc usuarionrodoc, t0.susuariotipodoc usuariotipodoc, t0.susuarionombre usuarionombre, t0.susuariotelefono usuariotelefono, t0.susuariopassword usuariopassword, t0.nusuariotiporol usuariotiporol, t0.busuarioestado usuarioestado");
		$builder->where('t0.nusuarioid', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('tusuario t0');
		$builder->select('nusuarioid');

		if ($todos !== '') {
			$builder->where('t0.busuarioestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nusuarioid', $text)
				->orLike('t0.susuarionombre', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateUsuario($nusuarioid, $datos){
		$builder = $this->conexion('tusuario');
		$builder->where(['nusuarioid' => $nusuarioid]);
		$builder->set($datos);
		$builder->update();
	}

	public function UpdatePassword($userId, $newPassword)
    {
        // Hashea la nueva contraseña antes de actualizar
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        return $this->update($userId, ['susuariopassword' => $hashedPassword]);
    }

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('tusuario');
		$builder->selectMax('nusuarioid');
		$query = $builder->get();
		return  $query->getResult()[0]->nusuarioid;
	}
}
?>
