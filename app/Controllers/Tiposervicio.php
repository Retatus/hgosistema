<?php namespace App\Controllers;
use App\Controllers\BaseController;
use DateTime;
use App\Models\PaginadoModel;
use App\Models\TiposervicioModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;


class Tiposervicio extends BaseController
{
	protected $paginado;
	protected $tiposervicio;


//   SECCION ====== CONSTRUCT ======
	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->tiposervicio = new TiposervicioModel();

	}

//   SECCION ====== INDEX ======
	public function index($bestado = 1)
	{
		$tiposervicio = $this->tiposervicio->getTiposervicios(20, 1, 1, '');
		$total = $this->tiposervicio->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'tiposervicio', 'pag' => $pag, 'datos' => $tiposervicio];
		$tiposervicio = $this->tiposervicio->getTiposervicios(10, 1, 1, '');

		echo view('layouts/header', []);
		echo view('layouts/aside');
		echo view('tiposervicio/list', $data);
		echo view('layouts/footer');

	}
//   SECCION ====== AGREGAR ======
	public function agregar(){

		$total = $this->tiposervicio->getCount('', '');
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
			$nidtiposervicio = strtoupper(trim($this->request->getPost('idtiposervicio')));
			$snombretiposervicio = strtoupper(trim($this->request->getPost('nombretiposervicio')));
			$bestado = strtoupper(trim($this->request->getPost('estado')));
		}


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion){
			case 'agregar':
				$data  = array(
					'nidtiposervicio' => intval($nidtiposervicio),
					'snombretiposervicio' => $snombretiposervicio,
					'bestado' => intval($bestado),

				);
				if ($this->tiposervicio->existe($nidtiposervicio) == 1){
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->tiposervicio->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'snombretiposervicio' => $snombretiposervicio,
					'bestado' => intval($bestado),

				);
				$this->tiposervicio->UpdateTiposervicio($nidtiposervicio, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->tiposervicio->UpdateTiposervicio($nidtiposervicio, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->tiposervicio->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->tiposervicio->getTiposervicios(20, $pag, $todos, $texto)];
		echo json_encode($respt);
	}

//   SECCION ====== EDIT ======
	public function edit(){
		$nidtiposervicio = strtoupper(trim($this->request->getPost('idtiposervicio')));

		$data = $this->tiposervicio->getTiposervicio($nidtiposervicio);
		echo json_encode($data);
	}


	public function autocompletetiposervicios()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->tiposervicio->getAutocompletetiposervicios($todos,$keyword);
		echo json_encode($data);
	}
//   SECCION ====== Tiposervicio SELECT NOMBRE ======
	public function getTiposerviciosSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->tiposervicio->getTiposerviciosSelectNombre($searchTerm);
		echo json_encode($response);
	}


//   SECCION ====== PDF ======
	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de tiposervicio', 0, 1, 'C');
		$pdf->Output('tiposervicio.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

//   SECCION ====== EXCEL ======
	public function excel()
	{
		$total = $this->tiposervicio->getCount();

		$tiposervicio = $this->tiposervicio->getTiposervicios($total, 1, 1, '');
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
		$sheet->setCellValue('A1', 'IDTIPOSERVICIO');
		$sheet->setCellValue('B1', 'NOMBRETIPOSERVICIO');
		$sheet->setCellValue('C1', 'ESTADO');
		$sheet->setCellValue('D1', 'CONCATENADO');
		$sheet->setCellValue('E1', 'CONCATENADODETALLE');
		$i=2;
		foreach ($tiposervicio as $row){
			$sheet->setCellValue('A'.$i, $row['idtiposervicio']);
			$sheet->setCellValue('B'.$i, $row['nombretiposervicio']);
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
		$filename = 'Lista_Tiposervicio.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}
}
