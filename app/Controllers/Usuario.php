<?php namespace App\Controllers;

use App\Controllers\BaseController;
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


	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->usuario = new UsuarioModel();

	}

	public function index($bestado = 1)
	{
		$usuario = $this->usuario->getUsuarios(1, '', 20, 1);
		$total = $this->usuario->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'usuario', 'pag' => $pag, 'datos' => $usuario];

		echo view('layouts/header');
		echo view('layouts/aside');
		echo view('usuario/list', $data);
		echo view('layouts/footer');

	}
	public function agregar(){
	
		$total = $this->usuario->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;

		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		$sidusuario = strtoupper(trim($this->request->getPost('idusuario')));
		$snombreusuario = strtoupper(trim($this->request->getPost('nombreusuario')));


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion) {
			case 'agregar':
				$data  = array(
					'sidusuario' => $sidusuario,
					'snombreusuario' => $snombreusuario,

				);
				if ($this->usuario->existe($sidusuario) == 1) {
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->usuario->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'snombreusuario' => $snombreusuario,

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
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->usuario->getusuarios($todos, $texto, 20, $pag)];
		echo json_encode($respt);
	}

	public function edit(){ 
		$sidusuario = strtoupper(trim($this->request->getPost('idusuario')));

		$data = $this->usuario->getUsuario($sidusuario);
		echo json_encode($data);
	}


	public function getusuariosSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->usuario->getusuariosSelectNombre($searchTerm);
		echo json_encode($response);
	}


	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de usuario', 0, 1, 'C');
		$pdf->Output('usuario.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

	public function excel()
	{
		$total = $this->usuario->getCount();

		$usuario = $this->usuario->getUsuarios(1, '', $total, 1);
		require_once ROOTPATH . 'vendor/autoload.php';
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->setActiveSheetIndex(0);
		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getStyle('A1:B1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ], ];
		$sheet->setCellValue('A1', 'ID');
		$sheet->setCellValue('B1', 'NOMBRE');
		$i=2;
		foreach ($usuario as $row) {
			$sheet->setCellValue('A'.$i, $row['idusuario']);
			$sheet->setCellValue('B'.$i, $row['nombreusuario']);
			$i++;
		}
		$sheet->getStyle('A1:B1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++) {
			$sheet->getStyle('A'.$j.':B'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_usuario.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}

}
