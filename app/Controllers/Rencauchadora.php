<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaginadoModel;
use App\Models\RencauchadoraModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;


class Rencauchadora extends BaseController
{
	protected $paginado;
	protected $rencauchadora;


	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->rencauchadora = new RencauchadoraModel();

	}

	public function index($bestado = 1)
	{
		$rencauchadora = $this->rencauchadora->getRencauchadoras(1, '', 20, 1);
		$total = $this->rencauchadora->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'rencauchadora', 'pag' => $pag, 'datos' => $rencauchadora];

		echo view('layouts/header');
		echo view('layouts/aside');
		echo view('rencauchadora/list', $data);
		echo view('layouts/footer');

	}
	public function agregar(){
	
		$total = $this->rencauchadora->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;

		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		$nidrencauchadora = strtoupper(trim($this->request->getPost('idrencauchadora')));
		$snombre = strtoupper(trim($this->request->getPost('nombre')));
		$sdireccion = strtoupper(trim($this->request->getPost('direccion')));


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion) {
			case 'agregar':
				$data  = array(
					'nidrencauchadora' => intval($nidrencauchadora),
					'snombre' => $snombre,
					'sdireccion' => $sdireccion,

				);
				if ($this->rencauchadora->existe($nidrencauchadora) == 1) {
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->rencauchadora->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'snombre' => $snombre,
					'sdireccion' => $sdireccion,

				);
				$this->rencauchadora->UpdateRencauchadora($nidrencauchadora, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->rencauchadora->UpdateRencauchadora($nidrencauchadora, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->rencauchadora->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->rencauchadora->getrencauchadoras($todos, $texto, 20, $pag)];
		echo json_encode($respt);
	}

	public function edit(){ 
		$nidrencauchadora = strtoupper(trim($this->request->getPost('idrencauchadora')));

		$data = $this->rencauchadora->getRencauchadora($nidrencauchadora);
		echo json_encode($data);
	}


	public function getrencauchadorasSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->rencauchadora->getrencauchadorasSelectNombre($searchTerm);
		echo json_encode($response);
	}


	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de rencauchadora', 0, 1, 'C');
		$pdf->Output('rencauchadora.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

	public function excel()
	{
		$total = $this->rencauchadora->getCount();

		$rencauchadora = $this->rencauchadora->getRencauchadoras(1, '', $total, 1);
		require_once ROOTPATH . 'vendor/autoload.php';
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->setActiveSheetIndex(0);
		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getStyle('A1:B1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ], ];
		$sheet->setCellValue('A1', 'NOMBRE');
		$sheet->setCellValue('B1', 'DIRECCION');
		$i=2;
		foreach ($rencauchadora as $row) {
			$sheet->setCellValue('A'.$i, $row['nombre']);
			$sheet->setCellValue('B'.$i, $row['direccion']);
			$i++;
		}
		$sheet->getStyle('A1:B1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++) {
			$sheet->getStyle('A'.$j.':B'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_rencauchadora.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}

}
