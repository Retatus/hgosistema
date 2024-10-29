<?php namespace App\Controllers;
use App\Controllers\BaseController;
use DateTime;
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


//   SECCION ====== CONSTRUCT ======
	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->reencauchadora = new ReencauchadoraModel();

	}

//   SECCION ====== INDEX ======
	public function index($bestado = 1)
	{
		$reencauchadora = $this->reencauchadora->getReencauchadoras(20, 1, 1, '');
		$total = $this->reencauchadora->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'reencauchadora', 'pag' => $pag, 'datos' => $reencauchadora];
		$reencauchadora = $this->reencauchadora->getReencauchadoras(10, 1, 1, '');

		echo view('layouts/header', []);
		echo view('layouts/aside');
		echo view('reencauchadora/list', $data);
		echo view('layouts/footer');

	}
//   SECCION ====== AGREGAR ======
	public function agregar(){

		$total = $this->reencauchadora->getCount('', '');
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
			$nidreencauchadora = strtoupper(trim($this->request->getPost('idreencauchadora')));
			$snombrereencauchadora = strtoupper(trim($this->request->getPost('nombrereencauchadora')));
			$sdireccion = strtoupper(trim($this->request->getPost('direccion')));
			$bestado = strtoupper(trim($this->request->getPost('estado')));
		}


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion){
			case 'agregar':
				$data  = array(
					'nidreencauchadora' => intval($nidreencauchadora),
					'snombrereencauchadora' => $snombrereencauchadora,
					'sdireccion' => $sdireccion,
					'bestado' => intval($bestado),

				);
				if ($this->reencauchadora->existe($nidreencauchadora) == 1){
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
					'bestado' => intval($bestado),

				);
				$this->reencauchadora->UpdateReencauchadora($nidreencauchadora, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->reencauchadora->UpdateReencauchadora($nidreencauchadora, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->reencauchadora->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->reencauchadora->getReencauchadoras(20, $pag, $todos, $texto)];
		echo json_encode($respt);
	}

//   SECCION ====== EDIT ======
	public function edit(){
		$nidreencauchadora = strtoupper(trim($this->request->getPost('idreencauchadora')));

		$data = $this->reencauchadora->getReencauchadora($nidreencauchadora);
		echo json_encode($data);
	}

	public function listaSelect2(){
		$data = $this->reencauchadora->getReencauchadorasSelect2();
		echo json_encode($data);
	}

	public function autocompletereencauchadoras()
	{
		$todos = 1;
		$keyword = $this->request->getVar('term');
		$result = $this->reencauchadora->getAutocompletereencauchadoras($todos,$keyword);
		$data = [];
		foreach ($result as $row) {
			$data[] = [
				'id' => $row['idreencauchadora'],
				'label' => $row['nombrereencauchadora'],
				'value' => $row['nombrereencauchadora']
			];
		}
		return $this->response->setJSON($data);
	}
//   SECCION ====== Reencauchadora SELECT NOMBRE ======
	public function getReencauchadorasSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->reencauchadora->getReencauchadorasSelectNombre($searchTerm);
		echo json_encode($response);
	}


//   SECCION ====== PDF ======
	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de reencauchadora', 0, 1, 'C');
		$pdf->Output('reencauchadora.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

//   SECCION ====== EXCEL ======
	public function excel()
	{
		$total = $this->reencauchadora->getCount();

		$reencauchadora = $this->reencauchadora->getReencauchadoras($total, 1, 1, '');
		require_once ROOTPATH . 'vendor/autoload.php';
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->setActiveSheetIndex(0);
		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getColumnDimension('C')->setAutoSize(true);
		$sheet->getColumnDimension('D')->setAutoSize(true);
		$sheet->getColumnDimension('E')->setAutoSize(true);
		$sheet->getColumnDimension('F')->setAutoSize(true);
		$sheet->getStyle('A1:F1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ], ];
		$sheet->setCellValue('A1', 'IDREENCAUCHADORA');
		$sheet->setCellValue('B1', 'NOMBREREENCAUCHADORA');
		$sheet->setCellValue('C1', 'DIRECCION');
		$sheet->setCellValue('D1', 'ESTADO');
		$sheet->setCellValue('E1', 'CONCATENADO');
		$sheet->setCellValue('F1', 'CONCATENADODETALLE');
		$i=2;
		foreach ($reencauchadora as $row){
			$sheet->setCellValue('A'.$i, $row['idreencauchadora']);
			$sheet->setCellValue('B'.$i, $row['nombrereencauchadora']);
			$sheet->setCellValue('C'.$i, $row['direccion']);
			$sheet->setCellValue('D'.$i, $row['estado']);
			$sheet->setCellValue('E'.$i, $row['concatenado']);
			$sheet->setCellValue('F'.$i, $row['concatenadodetalle']);
			$i++;
		}
		$sheet->getStyle('A1:F1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++){
			$sheet->getStyle('A'.$j.':F'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_Reencauchadora.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}
}
