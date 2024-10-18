<?php namespace App\Controllers;
use App\Controllers\BaseController;
use DateTime;
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


//   SECCION ====== CONSTRUCT ======
	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->neumatico = new NeumaticoModel();

	}

//   SECCION ====== INDEX ======
	public function index($bestado = 1)
	{
		$neumatico = $this->neumatico->getNeumaticos(20, 1, 1, '');
		$total = $this->neumatico->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'neumatico', 'pag' => $pag, 'datos' => $neumatico];
		$neumatico = $this->neumatico->getNeumaticos(10, 1, 1, '');

		echo view('layouts/header', []);
		echo view('layouts/aside');
		echo view('neumatico/list', $data);
		echo view('layouts/footer');

	}
//   SECCION ====== AGREGAR ======
	public function agregar(){

		$total = $this->neumatico->getCount('', '');
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
			$nidneumatico = strtoupper(trim($this->request->getPost('idneumatico')));
			$snombreneumatico = strtoupper(trim($this->request->getPost('nombreneumatico')));
			$bestado = strtoupper(trim($this->request->getPost('estado')));
		}


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion){
			case 'agregar':
				$data  = array(
					'nidneumatico' => intval($nidneumatico),
					'snombreneumatico' => $snombreneumatico,
					'bestado' => intval($bestado),

				);
				if ($this->neumatico->existe($nidneumatico) == 1){
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->neumatico->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'snombreneumatico' => $snombreneumatico,
					'bestado' => intval($bestado),

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
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->neumatico->getNeumaticos(20, $pag, $todos, $texto)];
		echo json_encode($respt);
	}

//   SECCION ====== EDIT ======
	public function edit(){
		$nidneumatico = strtoupper(trim($this->request->getPost('idneumatico')));

		$data = $this->neumatico->getNeumatico($nidneumatico);
		echo json_encode($data);
	}


	public function autocompleteneumaticos()
	{
		$todos = 1;
		$keyword = $this->request->getVar('term');
		$result = $this->neumatico->getAutocompleteneumaticos($todos,$keyword);
		$data = [];
		foreach ($result as $row) {
			$data[] = [
				'id' => $row['idneumatico'],
				'label' => $row['nombreneumatico'],
				'value' => $row['nombreneumatico']
			];
		}
		return $this->response->setJSON($data);
	}
//   SECCION ====== Neumatico SELECT NOMBRE ======
	public function getNeumaticosSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->neumatico->getNeumaticosSelectNombre($searchTerm);
		echo json_encode($response);
	}


//   SECCION ====== PDF ======
	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de neumatico', 0, 1, 'C');
		$pdf->Output('neumatico.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

//   SECCION ====== EXCEL ======
	public function excel()
	{
		$total = $this->neumatico->getCount();

		$neumatico = $this->neumatico->getNeumaticos($total, 1, 1, '');
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
		$sheet->setCellValue('A1', 'IDNEUMATICO');
		$sheet->setCellValue('B1', 'NOMBRENEUMATICO');
		$sheet->setCellValue('C1', 'ESTADO');
		$sheet->setCellValue('D1', 'CONCATENADO');
		$sheet->setCellValue('E1', 'CONCATENADODETALLE');
		$i=2;
		foreach ($neumatico as $row){
			$sheet->setCellValue('A'.$i, $row['idneumatico']);
			$sheet->setCellValue('B'.$i, $row['nombreneumatico']);
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
		$filename = 'Lista_Neumatico.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}
}
