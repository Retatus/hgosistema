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
			$sidusuario = strtoupper(trim($this->request->getPost('idusuario')));
			$snombreusuario = strtoupper(trim($this->request->getPost('nombreusuario')));
			$bestado = strtoupper(trim($this->request->getPost('estado')));
		}


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion){
			case 'agregar':
				$data  = array(
					'sidusuario' => $sidusuario,
					'snombreusuario' => $snombreusuario,
					'bestado' => intval($bestado),

				);
				if ($this->usuario->existe($sidusuario) == 1){
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->usuario->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'snombreusuario' => $snombreusuario,
					'bestado' => intval($bestado),

				);
				$this->usuario->UpdateUsuario($sidusuario, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->usuario->UpdateUsuario($sidusuario, $data);
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

//   SECCION ====== EDIT ======
	public function edit(){
		$sidusuario = strtoupper(trim($this->request->getPost('idusuario')));

		$data = $this->usuario->getUsuario($sidusuario);
		echo json_encode($data);
	}


	public function autocompleteusuarios()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->usuario->getAutocompleteusuarios($todos,$keyword);
		echo json_encode($data);
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
		$sheet->getStyle('A1:E1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ], ];
		$sheet->setCellValue('A1', 'IDUSUARIO');
		$sheet->setCellValue('B1', 'NOMBREUSUARIO');
		$sheet->setCellValue('C1', 'ESTADO');
		$sheet->setCellValue('D1', 'CONCATENADO');
		$sheet->setCellValue('E1', 'CONCATENADODETALLE');
		$i=2;
		foreach ($usuario as $row){
			$sheet->setCellValue('A'.$i, $row['idusuario']);
			$sheet->setCellValue('B'.$i, $row['nombreusuario']);
			$sheet->setCellValue('C'.$i, $row['estado']);
			$sheet->setCellValue('D'.$i, $row['concatenado']);
			$sheet->setCellValue('E'.$i, $row['concatenadodetalle']);
			$i++;
		}
		$sheet->getStyle('A1:E1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++){
			$sheet->getStyle('A'.$j.':E'.$j)->applyFromArray($border);
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
