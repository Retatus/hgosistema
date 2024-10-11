<?php namespace App\Controllers;

use App\Controllers\BaseController;
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


	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->cliente = new ClienteModel();

	}

	public function index($bestado = 1)
	{
		$cliente = $this->cliente->getClientes(1, '', 20, 1);
		$total = $this->cliente->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'cliente', 'pag' => $pag, 'datos' => $cliente];

		echo view('layouts/header');
		echo view('layouts/aside');
		echo view('cliente/list', $data);
		echo view('layouts/footer');

	}
	public function agregar(){
	
		$total = $this->cliente->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;

		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		$sidcliente = strtoupper(trim($this->request->getPost('idcliente')));
		$srasonsocial = strtoupper(trim($this->request->getPost('rasonsocial')));
		$sdireccion = strtoupper(trim($this->request->getPost('direccion')));
		$stelefono = strtoupper(trim($this->request->getPost('telefono')));


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion) {
			case 'agregar':
				$data  = array(
					'sidcliente' => $sidcliente,
					'srasonsocial' => $srasonsocial,
					'sdireccion' => $sdireccion,
					'stelefono' => $stelefono,

				);
				if ($this->cliente->existe($sidcliente) == 1) {
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->cliente->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'srasonsocial' => $srasonsocial,
					'sdireccion' => $sdireccion,
					'stelefono' => $stelefono,

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
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->cliente->getclientes($todos, $texto, 20, $pag)];
		echo json_encode($respt);
	}

	public function edit(){ 
		$sidcliente = strtoupper(trim($this->request->getPost('idcliente')));

		$data = $this->cliente->getCliente($sidcliente);
		echo json_encode($data);
	}


	public function getclientesSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->cliente->getclientesSelectNombre($searchTerm);
		echo json_encode($response);
	}


	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de cliente', 0, 1, 'C');
		$pdf->Output('cliente.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

	public function excel()
	{
		$total = $this->cliente->getCount();

		$cliente = $this->cliente->getClientes(1, '', $total, 1);
		require_once ROOTPATH . 'vendor/autoload.php';
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->setActiveSheetIndex(0);
		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getColumnDimension('C')->setAutoSize(true);
		$sheet->getColumnDimension('D')->setAutoSize(true);
		$sheet->getStyle('A1:D1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ], ];
		$sheet->setCellValue('A1', 'ID');
		$sheet->setCellValue('B1', 'RASONSOCIAL');
		$sheet->setCellValue('C1', 'DIRECCION');
		$sheet->setCellValue('D1', 'TELEFONO');
		$i=2;
		foreach ($cliente as $row) {
			$sheet->setCellValue('A'.$i, $row['idcliente']);
			$sheet->setCellValue('B'.$i, $row['rasonsocial']);
			$sheet->setCellValue('C'.$i, $row['direccion']);
			$sheet->setCellValue('D'.$i, $row['telefono']);
			$i++;
		}
		$sheet->getStyle('A1:D1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++) {
			$sheet->getStyle('A'.$j.':D'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_cliente.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}

}
