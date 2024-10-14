<?php namespace App\Controllers;
use App\Controllers\BaseController;
use DateTime;
use App\Models\PaginadoModel;
use App\Models\AuditoriaModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;


class Auditoria extends BaseController
{
	protected $paginado;
	protected $auditoria;


//   SECCION ====== CONSTRUCT ======
	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->auditoria = new AuditoriaModel();

	}

//   SECCION ====== INDEX ======
	public function index($bestado = 1)
	{
		$auditoria = $this->auditoria->getAuditorias(20, 1, 1, '');
		$total = $this->auditoria->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'auditoria', 'pag' => $pag, 'datos' => $auditoria];
		$auditoria = $this->auditoria->getAuditorias(10, 1, 1, '');

		echo view('layouts/header', []);
		echo view('layouts/aside');
		echo view('auditoria/list', $data);
		echo view('layouts/footer');

	}
//   SECCION ====== AGREGAR ======
	public function agregar(){

		$total = $this->auditoria->getCount('', '');
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
			$nidauditoria = strtoupper(trim($this->request->getPost('idauditoria')));
			$nidservicio = strtoupper(trim($this->request->getPost('idservicio')));
			$campo_modificado = strtoupper(trim($this->request->getPost('ampo_modificado')));
			$valor_anterior = strtoupper(trim($this->request->getPost('alor_anterior')));
			$valor_nuevo = strtoupper(trim($this->request->getPost('alor_nuevo')));
			$fecha_modificacion = strtoupper(trim($this->request->getPost('echa_modificacion')));
			$usuario_modificacion = strtoupper(trim($this->request->getPost('suario_modificacion')));
		}


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion){
			case 'agregar':
				$data  = array(
					'nidauditoria' => intval($nidauditoria),
					'nidservicio' => intval($nidservicio),
					'campo_modificado' => $campo_modificado,
					'valor_anterior' => $valor_anterior,
					'valor_nuevo' => $valor_nuevo,
					'fecha_modificacion' => $fecha_modificacion,
					'usuario_modificacion' => $usuario_modificacion,

				);
				if ($this->auditoria->existe($nidauditoria, $nidservicio) == 1){
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->auditoria->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'nidservicio' => intval($nidservicio),
					'campo_modificado' => $campo_modificado,
					'valor_anterior' => $valor_anterior,
					'valor_nuevo' => $valor_nuevo,
					'fecha_modificacion' => $fecha_modificacion,
					'usuario_modificacion' => $usuario_modificacion,

				);
				$this->auditoria->UpdateAuditoria($nidauditoria, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->auditoria->UpdateAuditoria($nidauditoria, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->auditoria->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->auditoria->getAuditorias(20, $pag, $todos, $texto)];
		echo json_encode($respt);
	}

//   SECCION ====== EDIT ======
	public function edit(){
		$nidauditoria = strtoupper(trim($this->request->getPost('idauditoria')));
		$nidservicio = strtoupper(trim($this->request->getPost('idservicio')));

		$data = $this->auditoria->getAuditoria($nidauditoria, $nidservicio);
		echo json_encode($data);
	}


	public function autocompleteauditorias()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->auditoria->getAutocompleteauditorias($todos,$keyword);
		echo json_encode($data);
	}
//   SECCION ====== Auditoria SELECT NOMBRE ======
	public function getAuditoriasSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->auditoria->getAuditoriasSelectNombre($searchTerm);
		echo json_encode($response);
	}


//   SECCION ====== PDF ======
	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de auditoria', 0, 1, 'C');
		$pdf->Output('auditoria.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

//   SECCION ====== EXCEL ======
	public function excel()
	{
		$total = $this->auditoria->getCount();

		$auditoria = $this->auditoria->getAuditorias($total, 1, 1, '');
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
		$sheet->setCellValue('A1', 'IDAUDITORIA');
		$sheet->setCellValue('B1', 'AMPO_MODIFICADO');
		$sheet->setCellValue('C1', 'ALOR_ANTERIOR');
		$sheet->setCellValue('D1', 'ALOR_NUEVO');
		$sheet->setCellValue('E1', 'ECHA_MODIFICACION');
		$sheet->setCellValue('F1', 'SUARIO_MODIFICACION');
		$i=2;
		foreach ($auditoria as $row){
			$sheet->setCellValue('A'.$i, $row['idauditoria']);
			$sheet->setCellValue('B'.$i, $row['ampo_modificado']);
			$sheet->setCellValue('C'.$i, $row['alor_anterior']);
			$sheet->setCellValue('D'.$i, $row['alor_nuevo']);
			$sheet->setCellValue('E'.$i, $row['echa_modificacion']);
			$sheet->setCellValue('F'.$i, $row['suario_modificacion']);
			$i++;
		}
		$sheet->getStyle('A1:F1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++){
			$sheet->getStyle('A'.$j.':F'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_Auditoria.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}
}
