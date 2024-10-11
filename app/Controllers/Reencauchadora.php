<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaginadoModel;
use App\Models\ReencauchadoraModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;


class Reencauchadora extends BaseController
{
	protected $paginado;
	protected $reencauchadora;


	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->reencauchadora = new ReencauchadoraModel();

	}

	public function index($bestado = 1)
	{
		$reencauchadora = $this->reencauchadora->getReencauchadoras(1, '', 20, 1);
		$total = $this->reencauchadora->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'reencauchadora', 'pag' => $pag, 'datos' => $reencauchadora];

		echo view('layouts/header');
		echo view('layouts/aside');
		echo view('reencauchadora/list', $data);
		echo view('layouts/footer');

	}
	public function agregar(){
	
		$total = $this->reencauchadora->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;

		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		$nidrencauchadora = strtoupper(trim($this->request->getPost('idrencauchadora')));
		$snombrereencauchadora = strtoupper(trim($this->request->getPost('nombrereencauchadora')));
		$sdireccion = strtoupper(trim($this->request->getPost('direccion')));


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion) {
			case 'agregar':
				$data  = array(
					'nidrencauchadora' => intval($nidrencauchadora),
					'snombrereencauchadora' => $snombrereencauchadora,
					'sdireccion' => $sdireccion,

				);
				if ($this->reencauchadora->existe($nidrencauchadora) == 1) {
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->reencauchadora->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'snombrereencauchadora' => $snombrereencauchadora,
					'sdireccion' => $sdireccion,

				);
				$this->reencauchadora->UpdateReencauchadora($nidrencauchadora, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->reencauchadora->UpdateReencauchadora($nidrencauchadora, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->reencauchadora->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->reencauchadora->getreencauchadoras($todos, $texto, 20, $pag)];
		echo json_encode($respt);
	}

	public function edit(){ 
		$nidrencauchadora = strtoupper(trim($this->request->getPost('idrencauchadora')));

		$data = $this->reencauchadora->getReencauchadora($nidrencauchadora);
		echo json_encode($data);
	}


	public function getreencauchadorasSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->reencauchadora->getreencauchadorasSelectNombre($searchTerm);
		echo json_encode($response);
	}


	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de reencauchadora', 0, 1, 'C');
		$pdf->Output('reencauchadora.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

	public function excel()
	{
		$total = $this->reencauchadora->getCount();

		$reencauchadora = $this->reencauchadora->getReencauchadoras(1, '', $total, 1);
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
		foreach ($reencauchadora as $row) {
			$sheet->setCellValue('A'.$i, $row['nombrereencauchadora']);
			$sheet->setCellValue('B'.$i, $row['direccion']);
			$i++;
		}
		$sheet->getStyle('A1:B1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++) {
			$sheet->getStyle('A'.$j.':B'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_reencauchadora.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}

}
