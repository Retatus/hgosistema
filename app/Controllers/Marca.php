<?php namespace App\Controllers;
use App\Controllers\BaseController;
use DateTime;
use App\Models\PaginadoModel;
use App\Models\MarcaModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;


class Marca extends BaseController
{
	protected $paginado;
	protected $marca;


//   SECCION ====== CONSTRUCT ======
	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->marca = new MarcaModel();

	}

//   SECCION ====== INDEX ======
	public function index($bestado = 1)
	{
		$marca = $this->marca->getMarcas(20, 1, 1, '');
		$total = $this->marca->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'marca', 'pag' => $pag, 'datos' => $marca];
		$marca = $this->marca->getMarcas(10, 1, 1, '');

		echo view('layouts/header', []);
		echo view('layouts/aside');
		echo view('marca/list', $data);
		echo view('layouts/footer');

	}
//   SECCION ====== AGREGAR ======
	public function agregar(){

		$total = $this->marca->getCount('', '');
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
			$nidmarca = strtoupper(trim($this->request->getPost('idmarca')));
			$snombremarca = strtoupper(trim($this->request->getPost('nombremarca')));
			$bestado = strtoupper(trim($this->request->getPost('estado')));
		}


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion){
			case 'agregar':
				$data  = array(
					'nidmarca' => intval($nidmarca),
					'snombremarca' => $snombremarca,
					'bestado' => intval($bestado),

				);
				if ($this->marca->existe($nidmarca) == 1){
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->marca->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'snombremarca' => $snombremarca,
					'bestado' => intval($bestado),

				);
				$this->marca->UpdateMarca($nidmarca, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->marca->UpdateMarca($nidmarca, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->marca->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->marca->getMarcas(20, $pag, $todos, $texto)];
		echo json_encode($respt);
	}

//   SECCION ====== EDIT ======
	public function edit(){
		$nidmarca = strtoupper(trim($this->request->getPost('idmarca')));

		$data = $this->marca->getMarca($nidmarca);
		echo json_encode($data);
	}

//   SECCION ====== SELECT2 ======
	public function listaSelect2(){
		$data = $this->marca->getMarcasSelect2();
		echo json_encode($data);
	}

	public function autocompletemarcas()
	{
		$todos = 1;
		$keyword = $this->request->getVar('term');
		$result = $this->marca->getAutocompletemarcas($todos,$keyword);
		$data = [];
		foreach ($result as $row) {
			$data[] = [
				'id' => $row['idmarca'],
				'label' => $row['nombremarca'],
				'value' => $row['nombremarca']
			];
		}
		return $this->response->setJSON($data);
	}
//   SECCION ====== Marca SELECT NOMBRE ======
	public function getMarcasSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->marca->getMarcasSelectNombre($searchTerm);
		echo json_encode($response);
	}


//   SECCION ====== PDF ======
	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de marca', 0, 1, 'C');
		$pdf->Output('marca.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

//   SECCION ====== EXCEL ======
	public function excel()
	{
		$total = $this->marca->getCount();

		$marca = $this->marca->getMarcas($total, 1, 1, '');
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
		$sheet->setCellValue('A1', 'IDMARCA');
		$sheet->setCellValue('B1', 'NOMBREMARCA');
		$sheet->setCellValue('C1', 'ESTADO');
		$sheet->setCellValue('D1', 'CONCATENADO');
		$sheet->setCellValue('E1', 'CONCATENADODETALLE');
		$i=2;
		foreach ($marca as $row){
			$sheet->setCellValue('A'.$i, $row['idmarca']);
			$sheet->setCellValue('B'.$i, $row['nombremarca']);
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
		$filename = 'Lista_Marca.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}
}
