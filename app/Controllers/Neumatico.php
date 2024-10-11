<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaginadoModel;
use App\Models\NeumaticoModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;


class Neumatico extends BaseController
{
	protected $paginado;
	protected $neumatico;


	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->neumatico = new NeumaticoModel();

	}

	public function index($bestado = 1)
	{
		$neumatico = $this->neumatico->getNeumaticos(1, '', 20, 1);
		$total = $this->neumatico->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'neumatico', 'pag' => $pag, 'datos' => $neumatico];

		echo view('layouts/header');
		echo view('layouts/aside');
		echo view('neumatico/list', $data);
		echo view('layouts/footer');

	}
	public function agregar(){
	
		$total = $this->neumatico->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;

		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		$nidneumatico = strtoupper(trim($this->request->getPost('idneumatico')));
		$scodigo = strtoupper(trim($this->request->getPost('codigo')));
		$smarca = strtoupper(trim($this->request->getPost('marca')));
		$sdescripcion = strtoupper(trim($this->request->getPost('descripcion')));


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion) {
			case 'agregar':
				$data  = array(
					'nidneumatico' => intval($nidneumatico),
					'scodigo' => $scodigo,
					'smarca' => $smarca,
					'sdescripcion' => $sdescripcion,

				);
				if ($this->neumatico->existe($nidneumatico) == 1) {
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->neumatico->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'scodigo' => $scodigo,
					'smarca' => $smarca,
					'sdescripcion' => $sdescripcion,

				);
				$this->neumatico->UpdateNeumatico($nidneumatico, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->neumatico->UpdateNeumatico($nidneumatico, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->neumatico->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->neumatico->getneumaticos($todos, $texto, 20, $pag)];
		echo json_encode($respt);
	}

	public function edit(){ 
		$nidneumatico = strtoupper(trim($this->request->getPost('idneumatico')));

		$data = $this->neumatico->getNeumatico($nidneumatico);
		echo json_encode($data);
	}


	public function getneumaticosSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->neumatico->getneumaticosSelectNombre($searchTerm);
		echo json_encode($response);
	}


	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de neumatico', 0, 1, 'C');
		$pdf->Output('neumatico.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

	public function excel()
	{
		$total = $this->neumatico->getCount();

		$neumatico = $this->neumatico->getNeumaticos(1, '', $total, 1);
		require_once ROOTPATH . 'vendor/autoload.php';
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->setActiveSheetIndex(0);
		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getColumnDimension('C')->setAutoSize(true);
		$sheet->getStyle('A1:C1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ], ];
		$sheet->setCellValue('A1', 'CODIGO');
		$sheet->setCellValue('B1', 'MARCA');
		$sheet->setCellValue('C1', 'DESCRIPCION');
		$i=2;
		foreach ($neumatico as $row) {
			$sheet->setCellValue('A'.$i, $row['codigo']);
			$sheet->setCellValue('B'.$i, $row['marca']);
			$sheet->setCellValue('C'.$i, $row['descripcion']);
			$i++;
		}
		$sheet->getStyle('A1:C1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++) {
			$sheet->getStyle('A'.$j.':C'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_neumatico.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}

}
