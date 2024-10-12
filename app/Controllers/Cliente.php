<?php namespace App\Controllers;
use App\Controllers\BaseController;
use DateTime;
use App\Models\PaginadoModel;
use App\Models\ClienteModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;


class Cliente extends BaseController
{
	protected $paginado;
	protected $cliente;


//   SECCION ====== CONSTRUCT ======
	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->cliente = new ClienteModel();

	}

//   SECCION ====== INDEX ======
	public function index($bestado = 1)
	{
		$cliente = $this->cliente->getClientes(20, 1, 1, '');
		$total = $this->cliente->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'cliente', 'pag' => $pag, 'datos' => $cliente];
		$cliente = $this->cliente->getClientes(10, 1, 1, '');

		echo view('layouts/header', []);
		echo view('layouts/aside');
		echo view('cliente/list', $data);
		echo view('layouts/footer');

	}
//   SECCION ====== AGREGAR ======
	public function agregar(){

		$total = $this->cliente->getCount('', '');
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
			$sidcliente = strtoupper(trim($this->request->getPost('idcliente')));
			$snombrecliente = strtoupper(trim($this->request->getPost('nombrecliente')));
			$sdireccion = strtoupper(trim($this->request->getPost('direccion')));
			$stelefono = strtoupper(trim($this->request->getPost('telefono')));
			$bestado = strtoupper(trim($this->request->getPost('estado')));
		}


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion){
			case 'agregar':
				$data  = array(
					'sidcliente' => $sidcliente,
					'snombrecliente' => $snombrecliente,
					'sdireccion' => $sdireccion,
					'stelefono' => $stelefono,
					'bestado' => intval($bestado),

				);
				if ($this->cliente->existe($sidcliente) == 1){
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->cliente->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'snombrecliente' => $snombrecliente,
					'sdireccion' => $sdireccion,
					'stelefono' => $stelefono,
					'bestado' => intval($bestado),

				);
				$this->cliente->UpdateCliente($sidcliente, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->cliente->UpdateCliente($sidcliente, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->cliente->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->cliente->getClientes(20, $pag, $todos, $texto)];
		echo json_encode($respt);
	}

//   SECCION ====== EDIT ======
	public function edit(){
		$sidcliente = strtoupper(trim($this->request->getPost('idcliente')));

		$data = $this->cliente->getCliente($sidcliente);
		echo json_encode($data);
	}


	public function autocompleteclientes()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->cliente->getAutocompleteclientes($todos,$keyword);
		echo json_encode($data);
	}
//   SECCION ====== Cliente SELECT NOMBRE ======
	public function getClientesSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->cliente->getClientesSelectNombre($searchTerm);
		echo json_encode($response);
	}


//   SECCION ====== PDF ======
	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de cliente', 0, 1, 'C');
		$pdf->Output('cliente.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

//   SECCION ====== EXCEL ======
	public function excel()
	{
		$total = $this->cliente->getCount();

		$cliente = $this->cliente->getClientes($total, 1, 1, '');
		require_once ROOTPATH . 'vendor/autoload.php';
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->setActiveSheetIndex(0);
		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getColumnDimension('C')->setAutoSize(true);
		$sheet->getColumnDimension('D')->setAutoSize(true);
		$sheet->getColumnDimension('E')->setAutoSize(true);
		$sheet->getColumnDimension('F')->setAutoSize(true);
		$sheet->getColumnDimension('G')->setAutoSize(true);
		$sheet->getStyle('A1:G1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ], ];
		$sheet->setCellValue('A1', 'IDCLIENTE');
		$sheet->setCellValue('B1', 'NOMBRECLIENTE');
		$sheet->setCellValue('C1', 'DIRECCION');
		$sheet->setCellValue('D1', 'TELEFONO');
		$sheet->setCellValue('E1', 'ESTADO');
		$sheet->setCellValue('F1', 'CONCATENADO');
		$sheet->setCellValue('G1', 'CONCATENADODETALLE');
		$i=2;
		foreach ($cliente as $row){
			$sheet->setCellValue('A'.$i, $row['idcliente']);
			$sheet->setCellValue('B'.$i, $row['nombrecliente']);
			$sheet->setCellValue('C'.$i, $row['direccion']);
			$sheet->setCellValue('D'.$i, $row['telefono']);
			$sheet->setCellValue('E'.$i, $row['estado']);
			$sheet->setCellValue('F'.$i, $row['concatenado']);
			$sheet->setCellValue('G'.$i, $row['concatenadodetalle']);
			$i++;
		}
		$sheet->getStyle('A1:G1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++){
			$sheet->getStyle('A'.$j.':G'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_Cliente.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}
}
