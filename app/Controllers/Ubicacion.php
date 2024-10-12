<?php namespace App\Controllers;
use App\Controllers\BaseController;
use DateTime;
use App\Models\PaginadoModel;
use App\Models\UbicacionModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;


class Ubicacion extends BaseController
{
	protected $paginado;
	protected $ubicacion;


//   SECCION ====== CONSTRUCT ======
	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->ubicacion = new UbicacionModel();

	}

//   SECCION ====== INDEX ======
	public function index($bestado = 1)
	{
		$ubicacion = $this->ubicacion->getUbicacions(20, 1, 1, '');
		$total = $this->ubicacion->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'ubicacion', 'pag' => $pag, 'datos' => $ubicacion];
		$ubicacion = $this->ubicacion->getUbicacions(10, 1, 1, '');

		echo view('layouts/header', []);
		echo view('layouts/aside');
		echo view('ubicacion/list', $data);
		echo view('layouts/footer');

	}
//   SECCION ====== AGREGAR ======
	public function agregar(){

		$total = $this->ubicacion->getCount('', '');
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
			$nidubicacion = strtoupper(trim($this->request->getPost('idubicacion')));
			$snombretipoubicacion = strtoupper(trim($this->request->getPost('nombretipoubicacion')));
			$bestado = strtoupper(trim($this->request->getPost('estado')));
		}


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion){
			case 'agregar':
				$data  = array(
					'nidubicacion' => intval($nidubicacion),
					'snombretipoubicacion' => $snombretipoubicacion,
					'bestado' => intval($bestado),

				);
				if ($this->ubicacion->existe($nidubicacion) == 1){
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->ubicacion->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'snombretipoubicacion' => $snombretipoubicacion,
					'bestado' => intval($bestado),

				);
				$this->ubicacion->UpdateUbicacion($nidubicacion, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->ubicacion->UpdateUbicacion($nidubicacion, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->ubicacion->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->ubicacion->getUbicacions(20, $pag, $todos, $texto)];
		echo json_encode($respt);
	}

//   SECCION ====== EDIT ======
	public function edit(){
		$nidubicacion = strtoupper(trim($this->request->getPost('idubicacion')));

		$data = $this->ubicacion->getUbicacion($nidubicacion);
		echo json_encode($data);
	}


	public function autocompleteubicacions()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->ubicacion->getAutocompleteubicacions($todos,$keyword);
		echo json_encode($data);
	}
//   SECCION ====== Ubicacion SELECT NOMBRE ======
	public function getUbicacionsSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->ubicacion->getUbicacionsSelectNombre($searchTerm);
		echo json_encode($response);
	}


//   SECCION ====== PDF ======
	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de ubicacion', 0, 1, 'C');
		$pdf->Output('ubicacion.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

//   SECCION ====== EXCEL ======
	public function excel()
	{
		$total = $this->ubicacion->getCount();

		$ubicacion = $this->ubicacion->getUbicacions($total, 1, 1, '');
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
		$sheet->setCellValue('A1', 'IDUBICACION');
		$sheet->setCellValue('B1', 'NOMBRETIPOUBICACION');
		$sheet->setCellValue('C1', 'ESTADO');
		$sheet->setCellValue('D1', 'CONCATENADO');
		$sheet->setCellValue('E1', 'CONCATENADODETALLE');
		$i=2;
		foreach ($ubicacion as $row){
			$sheet->setCellValue('A'.$i, $row['idubicacion']);
			$sheet->setCellValue('B'.$i, $row['nombretipoubicacion']);
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
		$filename = 'Lista_Ubicacion.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}
}
