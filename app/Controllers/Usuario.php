<?php namespace App\Controllers;
use App\Controllers\BaseController;
use DateTime;
use App\Models\PaginadoModel;
use App\Models\UsuarioModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;


class Usuario extends BaseController
{
	protected $paginado;
	protected $usuario;


//   SECCION ====== CONSTRUCT ======
	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->usuario = new UsuarioModel();

	}

//   SECCION ====== INDEX ======
	public function index($bestado = 1)
	{
		$usuario = $this->usuario->getUsuarios(20, 1, 1, '');
		$total = $this->usuario->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'usuario', 'pag' => $pag, 'datos' => $usuario];
		$usuario = $this->usuario->getUsuarios(10, 1, 1, '');

		echo view('layouts/header', []);
		echo view('layouts/aside');
		echo view('usuario/list', $data);
		echo view('layouts/footer');

	}
//   SECCION ====== AGREGAR ======
	public function agregar(){

		$total = $this->usuario->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

//   SECCION ====== OPCIONES ======
	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;
		
		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		if($accion !== 'leer'){
			$nusuarioid = strtoupper(trim($this->request->getPost('usuarioid')));
			$susuarionrodoc = strtoupper(trim($this->request->getPost('usuarionrodoc')));
			$susuariotipodoc = strtoupper(trim($this->request->getPost('usuariotipodoc')));
			$susuarionombre = strtoupper(trim($this->request->getPost('usuarionombre')));
			$susuariotelefono = strtoupper(trim($this->request->getPost('usuariotelefono')));			
			$nusuariotiporol = strtoupper(trim($this->request->getPost('usuariotiporol')));
			$busuarioestado = strtoupper(trim($this->request->getPost('usuarioestado')));
		}


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion){
			case 'agregar':
				$data  = array(
					'nusuarioid' => intval($nusuarioid),
					'susuarionrodoc' => $susuarionrodoc,
					'susuariotipodoc' => $susuariotipodoc,
					'susuarionombre' => $susuarionombre,
					'susuariotelefono' => $susuariotelefono,
					'susuariopassword' => password_hash($susuarionrodoc, PASSWORD_DEFAULT),
					'nusuariotiporol' => $nusuariotiporol,
					'busuarioestado' => intval($busuarioestado),

				);
				if ($this->usuario->existe($nusuarioid) == 1){
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->usuario->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'susuarionrodoc' => $susuarionrodoc,
					'susuariotipodoc' => $susuariotipodoc,
					'susuarionombre' => $susuarionombre,
					'susuariotelefono' => $susuariotelefono,
					//'susuariopassword' => $susuariopassword,
					'nusuariotiporol' => $nusuariotiporol,
					'busuarioestado' => intval($busuarioestado),

				);
				$this->usuario->UpdateUsuario($nusuarioid, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->usuario->UpdateUsuario($nusuarioid, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->usuario->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->usuario->getUsuarios(20, $pag, $todos, $texto)];
		echo json_encode($respt);
	}

	public function changePassword()
    {
        // Obtén el ID del usuario actual (esto puede variar según cómo manejes la autenticación)
        $userId = session()->get('user_id'); // Ajusta esto según tu implementación

        if ($this->request->getMethod() === 'POST') {
            $currentPassword = $this->request->getPost('current_password');
            $newPassword = $this->request->getPost('new_password');
            $confirmPassword = $this->request->getPost('confirm_password');

            // Validar contraseñas
            if ($newPassword !== $confirmPassword) {
                return redirect()->back()->with('error', 'Las contraseñas no coinciden.');
            }

            // Verificar si la contraseña actual es correcta
            $user = $this->usuario->find($userId);
			//var_dump($user); 
            if (!password_verify($currentPassword, $user['susuariopassword'])) {
                return redirect()->back()->with('error', 'La contraseña actual es incorrecta.');
            }

            //Actualizar la contraseña
            $this->usuario->updatePassword($userId, $newPassword);

            //return redirect()->back()->with('success', 'Contraseña actualizada correctamente.');
			return view('login/login');
        }

        // Carga la vista con el formulario
        return view('login/login');
	}

	//   SECCION ====== RESET ======
	public function reestablecer($userId){
		$user = $this->usuario->find($userId);
        $this->usuario->updatePassword($userId, $user['susuarionrodoc']);
		return $this->response->setJSON([
            'status' => 'success',
            'message' => 'La contraseña se ha sido restablecido '.$user['susuarionrodoc']
        ]);
	}

//   SECCION ====== EDIT ======
	public function edit(){
		$nusuarioid = strtoupper(trim($this->request->getPost('usuarioid')));

		$data = $this->usuario->getUsuario($nusuarioid);
		echo json_encode($data);
	}

//   SECCION ====== SELECT2 ======
	public function listaSelect2(){
		$data = $this->usuario->getUsuariosSelect2();
		echo json_encode($data);
	}

	public function autocompleteusuarios()
	{
		$todos = 1;
		$keyword = $this->request->getVar('term');
		$result = $this->usuario->getAutocompleteusuarios($todos,$keyword);
		$data = [];
		foreach ($result as $row) {
			$data[] = [
				'id' => $row['usuarioid'],
				'label' => $row['usuarionombre'],
				'value' => $row['usuarionombre']
			];
		}
		return $this->response->setJSON($data);
	}
//   SECCION ====== Usuario SELECT NOMBRE ======
	public function getUsuariosSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->usuario->getUsuariosSelectNombre($searchTerm);
		echo json_encode($response);
	}


//   SECCION ====== PDF ======
	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de usuario', 0, 1, 'C');
		$pdf->Output('usuario.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

//   SECCION ====== EXCEL ======
	public function excel()
	{
		$total = $this->usuario->getCount();

		$usuario = $this->usuario->getUsuarios($total, 1, 1, '');
		require_once ROOTPATH . 'vendor/autoload.php';
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->setActiveSheetIndex(0);
		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getColumnDimension('C')->setAutoSize(true);
		$sheet->getColumnDimension('D')->setAutoSize(true);
		$sheet->getColumnDimension('E')->setAutoSize(true);
		$sheet->getColumnDimension('F')->setAutoSize(true);
		$sheet->getColumnDimension('G')->setAutoSize(true);
		$sheet->getColumnDimension('H')->setAutoSize(true);
		$sheet->getColumnDimension('I')->setAutoSize(true);
		$sheet->getColumnDimension('J')->setAutoSize(true);
		$sheet->getStyle('A1:J1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ], ];
		$sheet->setCellValue('A1', 'USUARIOID');
		$sheet->setCellValue('B1', 'USUARIONRODOC');
		$sheet->setCellValue('C1', 'USUARIOTIPODOC');
		$sheet->setCellValue('D1', 'USUARIONOMBRE');
		$sheet->setCellValue('E1', 'USUARIOTELEFONO');
		$sheet->setCellValue('F1', 'USUARIOPASSWORD');
		$sheet->setCellValue('G1', 'USUARIOTIPOROL');
		$sheet->setCellValue('H1', 'USUARIOESTADO');
		$sheet->setCellValue('I1', 'CONCATENADO');
		$sheet->setCellValue('J1', 'CONCATENADODETALLE');
		$i=2;
		foreach ($usuario as $row){
			$sheet->setCellValue('A'.$i, $row['usuarioid']);
			$sheet->setCellValue('B'.$i, $row['usuarionrodoc']);
			$sheet->setCellValue('C'.$i, $row['usuariotipodoc']);
			$sheet->setCellValue('D'.$i, $row['usuarionombre']);
			$sheet->setCellValue('E'.$i, $row['usuariotelefono']);
			$sheet->setCellValue('F'.$i, $row['usuariopassword']);
			$sheet->setCellValue('G'.$i, $row['usuariotiporol']);
			$sheet->setCellValue('H'.$i, $row['usuarioestado']);
			$sheet->setCellValue('I'.$i, $row['concatenado']);
			$sheet->setCellValue('J'.$i, $row['concatenadodetalle']);
			$i++;
		}
		$sheet->getStyle('A1:J1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++){
			$sheet->getStyle('A'.$j.':J'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_Usuario.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}
}
