<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaginadoModel;
use App\Models\BandaModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;


class Banda extends BaseController
{
	protected $paginado;
	protected $banda;


	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->banda = new BandaModel();

	}

	public function index($bestado = 1)
	{
		$banda = $this->banda->getBandas(1, '', 20, 1);
		$total = $this->banda->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'banda', 'pag' => $pag, 'datos' => $banda];

		echo view('layouts/header');
		echo view('layouts/aside');
		echo view('banda/list', $data);
		echo view('layouts/footer');

	}
	public function agregar(){
	
		$total = $this->banda->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;

		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		$nidbanda = strtoupper(trim($this->request->getPost('idbanda')));
		$snombrebanda = strtoupper(trim($this->request->getPost('nombrebanda')));
		$smarca = strtoupper(trim($this->request->getPost('marca')));


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion) {
			case 'agregar':
				$data  = array(
					'nidbanda' => intval($nidbanda),
					'snombrebanda' => $snombrebanda,
					'smarca' => $smarca,

				);
				if ($this->banda->existe($nidbanda) == 1) {
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->banda->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'snombrebanda' => $snombrebanda,
					'smarca' => $smarca,

				);
				$this->banda->UpdateBanda($nidbanda, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->banda->UpdateBanda($nidbanda, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->banda->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->banda->getbandas($todos, $texto, 20, $pag)];
		echo json_encode($respt);
	}

	public function edit(){ 
		$nidbanda = strtoupper(trim($this->request->getPost('idbanda')));

		$data = $this->banda->getBanda($nidbanda);
		echo json_encode($data);
	}


	public function getbandasSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->banda->getbandasSelectNombre($searchTerm);
		echo json_encode($response);
	}


	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de banda', 0, 1, 'C');
		$pdf->Output('banda.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

	public function excel()
	{
		$total = $this->banda->getCount();

		$banda = $this->banda->getBandas(1, '', $total, 1);
		require_once ROOTPATH . 'vendor/autoload.php';
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->setActiveSheetIndex(0);
		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getStyle('A1:B1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ], ];
		$sheet->setCellValue('A1', 'NOMBRE');
		$sheet->setCellValue('B1', 'MARCA');
		$i=2;
		foreach ($banda as $row) {
			$sheet->setCellValue('A'.$i, $row['nombrebanda']);
			$sheet->setCellValue('B'.$i, $row['marca']);
			$i++;
		}
		$sheet->getStyle('A1:B1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++) {
			$sheet->getStyle('A'.$j.':B'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_banda.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}

}
