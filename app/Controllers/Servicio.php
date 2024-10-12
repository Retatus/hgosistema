<?php namespace App\Controllers;
use App\Controllers\BaseController;
use DateTime;
use App\Models\PaginadoModel;
use App\Models\ServicioModel;
use App\Models\ClienteModel;
use App\Models\UbicacionModel;
use App\Models\BandaModel;
use App\Models\CondicionModel;
use App\Models\NeumaticoModel;
use App\Models\ReencauchadoraModel;
use App\Models\TiposervicioModel;
use App\Models\UsuarioModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;


class Servicio extends BaseController
{
	protected $paginado;
	protected $servicio;
	protected $cliente;
	protected $ubicacion;
	protected $banda;
	protected $condicion;
	protected $neumatico;
	protected $reencauchadora;
	protected $tiposervicio;
	protected $usuario;


//   SECCION ====== CONSTRUCT ======
	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->servicio = new ServicioModel();
		$this->cliente = new ClienteModel();
		$this->ubicacion = new UbicacionModel();
		$this->banda = new BandaModel();
		$this->condicion = new CondicionModel();
		$this->neumatico = new NeumaticoModel();
		$this->reencauchadora = new ReencauchadoraModel();
		$this->tiposervicio = new TiposervicioModel();
		$this->usuario = new UsuarioModel();

	}

//   SECCION ====== INDEX ======
	public function index($bestado = 1)
	{
		$servicio = $this->servicio->getServicios(20, 1, 1, '');
		$total = $this->servicio->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'servicio', 'pag' => $pag, 'datos' => $servicio];
		$servicio = $this->servicio->getServicios(10, 1, 1, '');
		$cliente = $this->cliente->getClientes(10, 1, 1, '');
		$ubicacion = $this->ubicacion->getUbicacions(10, 1, 1, '');
		$banda = $this->banda->getBandas(10, 1, 1, '');
		$condicion = $this->condicion->getCondicions(10, 1, 1, '');
		$neumatico = $this->neumatico->getNeumaticos(10, 1, 1, '');
		$reencauchadora = $this->reencauchadora->getReencauchadoras(10, 1, 1, '');
		$tiposervicio = $this->tiposervicio->getTiposervicios(10, 1, 1, '');
		$usuario = $this->usuario->getUsuarios(10, 1, 1, '');

		echo view('layouts/header', ['clientes' => $cliente, 'ubicacions' => $ubicacion, 'bandas' => $banda, 'condicions' => $condicion, 'neumaticos' => $neumatico, 'reencauchadoras' => $reencauchadora, 'tiposervicios' => $tiposervicio, 'usuarios' => $usuario]);
		echo view('layouts/aside');
		echo view('servicio/list', $data);
		echo view('layouts/footer');

	}
//   SECCION ====== AGREGAR ======
	public function agregar(){

		$total = $this->servicio->getCount('', '');
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
			$nidservicio = strtoupper(trim($this->request->getPost('idservicio')));
			$tfechaingreso = trim($this->request->getPost('fechaingreso'));
			$tfechaingreso = $this->formatDateOrDefault($tfechaingreso, null);
			$sidusuario = strtoupper(trim($this->request->getPost('idusuario')));
			$sobservacioningreso = strtoupper(trim($this->request->getPost('observacioningreso')));
			$sidcliente = strtoupper(trim($this->request->getPost('idcliente')));
			$nidtiposervicio = strtoupper(trim($this->request->getPost('idtiposervicio')));
			$nidbanda = strtoupper(trim($this->request->getPost('idbanda')));
			$nidneumatico = strtoupper(trim($this->request->getPost('idneumatico')));
			$nidubicacion = strtoupper(trim($this->request->getPost('idubicacion')));
			$nidrencauchadora = strtoupper(trim($this->request->getPost('idrencauchadora')));
			$tfechasalida = trim($this->request->getPost('fechasalida'));
			$tfechasalida = $this->formatDateOrDefault($tfechasalida, null);
			$sobservacionsalida = strtoupper(trim($this->request->getPost('observacionsalida')));
			$nidcondicion = strtoupper(trim($this->request->getPost('idcondicion')));
			$bestado = strtoupper(trim($this->request->getPost('estado')));
			$scodigo = strtoupper(trim($this->request->getPost('codigo')));
		}


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion){
			case 'agregar':
				$data  = array(
					'nidservicio' => intval($nidservicio),
					'tfechaingreso' => $tfechaingreso,
					'sidusuario' => $sidusuario,
					'sobservacioningreso' => $sobservacioningreso,
					'sidcliente' => $sidcliente,
					'nidtiposervicio' => intval($nidtiposervicio),
					'nidbanda' => intval($nidbanda),
					'nidneumatico' => intval($nidneumatico),
					'nidubicacion' => intval($nidubicacion),
					'nidrencauchadora' => intval($nidrencauchadora),
					'tfechasalida' => $tfechasalida,
					'sobservacionsalida' => $sobservacionsalida,
					'nidcondicion' => $nidcondicion,
					'bestado' => intval($bestado),
					'scodigo' => $scodigo,

				);
				if ($this->servicio->existe($nidservicio, $sidusuario, $sidcliente, $nidtiposervicio, $nidbanda, $nidneumatico, $nidubicacion, $nidrencauchadora, $nidcondicion) == 1){
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->servicio->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'bestado' => 0
				);
				$this->servicio->UpdateServicio($nidservicio, $data);
				$data  = array(
					'tfechaingreso' => $tfechaingreso,
					'sidusuario' => $sidusuario,
					'sobservacioningreso' => $sobservacioningreso,
					'sidcliente' => $sidcliente,
					'nidtiposervicio' => intval($nidtiposervicio),
					'nidbanda' => intval($nidbanda),
					'nidneumatico' => intval($nidneumatico),
					'nidubicacion' => intval($nidubicacion),
					'nidrencauchadora' => intval($nidrencauchadora),
					'tfechasalida' => $tfechasalida,
					'sobservacionsalida' => $sobservacionsalida,
					'nidcondicion' => $nidcondicion,
					'bestado' => intval($bestado),
					'scodigo' => $scodigo,

				);				
				$this->servicio->insert($data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->servicio->UpdateServicio($nidservicio, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->servicio->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->servicio->getServicios(20, $pag, $todos, $texto)];
		echo json_encode($respt);
	}

//   SECCION ====== EDIT ======
	public function edit(){
		$nidservicio = strtoupper(trim($this->request->getPost('idservicio')));
		$sidusuario = strtoupper(trim($this->request->getPost('idusuario')));
		$sidcliente = strtoupper(trim($this->request->getPost('idcliente')));
		$nidtiposervicio = strtoupper(trim($this->request->getPost('idtiposervicio')));
		$nidbanda = strtoupper(trim($this->request->getPost('idbanda')));
		$nidneumatico = strtoupper(trim($this->request->getPost('idneumatico')));
		$nidubicacion = strtoupper(trim($this->request->getPost('idubicacion')));
		$nidrencauchadora = strtoupper(trim($this->request->getPost('idrencauchadora')));
		$nidcondicion = strtoupper(trim($this->request->getPost('idcondicion')));

		$data = $this->servicio->getServicio($nidservicio, $sidusuario, $sidcliente, $nidtiposervicio, $nidbanda, $nidneumatico, $nidubicacion, $nidrencauchadora, $nidcondicion);
		echo json_encode($data);
	}


	public function autocompleteservicios()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->servicio->getAutocompleteservicios($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompleteclientes()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->cliente->getAutocompleteclientes($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompleteubicacions()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->ubicacion->getAutocompleteubicacions($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompletebandas()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->banda->getAutocompletebandas($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompletecondicions()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->condicion->getAutocompletecondicions($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompleteneumaticos()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->neumatico->getAutocompleteneumaticos($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompletereencauchadoras()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->reencauchadora->getAutocompletereencauchadoras($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompletetiposervicios()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->tiposervicio->getAutocompletetiposervicios($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompleteusuarios()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->usuario->getAutocompleteusuarios($todos,$keyword);
		echo json_encode($data);
	}
//   SECCION ====== Servicio SELECT NOMBRE ======
	public function getServiciosSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->servicio->getServiciosSelectNombre($searchTerm);
		echo json_encode($response);
	}


//   SECCION ====== PDF ======
	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de servicio', 0, 1, 'C');
		$pdf->Output('servicio.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

//   SECCION ====== EXCEL ======
	public function excel()
	{
		$total = $this->servicio->getCount();

		$servicio = $this->servicio->getServicios($total, 1, 1, '');
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
		$sheet->getColumnDimension('H')->setAutoSize(true);
		$sheet->getColumnDimension('I')->setAutoSize(true);
		$sheet->getColumnDimension('J')->setAutoSize(true);
		$sheet->getColumnDimension('K')->setAutoSize(true);
		$sheet->getColumnDimension('L')->setAutoSize(true);
		$sheet->getColumnDimension('M')->setAutoSize(true);
		$sheet->getColumnDimension('N')->setAutoSize(true);
		$sheet->getColumnDimension('O')->setAutoSize(true);
		$sheet->getColumnDimension('P')->setAutoSize(true);
		$sheet->getColumnDimension('Q')->setAutoSize(true);
		$sheet->getColumnDimension('R')->setAutoSize(true);
		$sheet->getColumnDimension('S')->setAutoSize(true);
		$sheet->getColumnDimension('T')->setAutoSize(true);
		$sheet->getColumnDimension('U')->setAutoSize(true);
		$sheet->getColumnDimension('V')->setAutoSize(true);
		$sheet->getColumnDimension('W')->setAutoSize(true);
		$sheet->getColumnDimension('X')->setAutoSize(true);
		$sheet->getColumnDimension('Y')->setAutoSize(true);
		$sheet->getStyle('A1:Y1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ], ];
		$sheet->setCellValue('A1', 'IDSERVICIO');
		$sheet->setCellValue('B1', 'FECHAINGRESO');
		$sheet->setCellValue('C1', 'OBSERVACIONINGRESO');
		$sheet->setCellValue('D1', 'FECHASALIDA');
		$sheet->setCellValue('E1', 'OBSERVACIONSALIDA');
		$sheet->setCellValue('F1', 'ESTADO');
		$sheet->setCellValue('G1', 'CODIGO');
		$sheet->setCellValue('H1', 'IDCLIENTE');
		$sheet->setCellValue('I1', 'NOMBRECLIENTE');
		$sheet->setCellValue('J1', 'IDUBICACION');
		$sheet->setCellValue('K1', 'NOMBRETIPOUBICACION');
		$sheet->setCellValue('L1', 'IDBANDA');
		$sheet->setCellValue('M1', 'NOMBREBANDA');
		$sheet->setCellValue('N1', 'IDCONDICION');
		$sheet->setCellValue('O1', 'NOMBRECONDICION');
		$sheet->setCellValue('P1', 'IDNEUMATICO');
		$sheet->setCellValue('Q1', 'NOMBRENEUMATICO');
		$sheet->setCellValue('R1', 'IDRENCAUCHADORA');
		$sheet->setCellValue('S1', 'NOMBREREENCAUCHADORA');
		$sheet->setCellValue('T1', 'IDTIPOSERVICIO');
		$sheet->setCellValue('U1', 'NOMBRETIPOSERVICIO');
		$sheet->setCellValue('V1', 'IDUSUARIO');
		$sheet->setCellValue('W1', 'NOMBREUSUARIO');
		$sheet->setCellValue('X1', 'CONCATENADO');
		$sheet->setCellValue('Y1', 'CONCATENADODETALLE');
		$i=2;
		foreach ($servicio as $row){
			$sheet->setCellValue('A'.$i, $row['idservicio']);
			$sheet->setCellValue('B'.$i, $row['fechaingreso']);
			$sheet->setCellValue('C'.$i, $row['observacioningreso']);
			$sheet->setCellValue('D'.$i, $row['fechasalida']);
			$sheet->setCellValue('E'.$i, $row['observacionsalida']);
			$sheet->setCellValue('F'.$i, $row['estado']);
			$sheet->setCellValue('G'.$i, $row['codigo']);
			$sheet->setCellValue('H'.$i, $row['idcliente']);
			$sheet->setCellValue('I'.$i, $row['nombrecliente']);
			$sheet->setCellValue('J'.$i, $row['idubicacion']);
			$sheet->setCellValue('K'.$i, $row['nombretipoubicacion']);
			$sheet->setCellValue('L'.$i, $row['idbanda']);
			$sheet->setCellValue('M'.$i, $row['nombrebanda']);
			$sheet->setCellValue('N'.$i, $row['idcondicion']);
			$sheet->setCellValue('O'.$i, $row['nombrecondicion']);
			$sheet->setCellValue('P'.$i, $row['idneumatico']);
			$sheet->setCellValue('Q'.$i, $row['nombreneumatico']);
			$sheet->setCellValue('R'.$i, $row['idrencauchadora']);
			$sheet->setCellValue('S'.$i, $row['nombrereencauchadora']);
			$sheet->setCellValue('T'.$i, $row['idtiposervicio']);
			$sheet->setCellValue('U'.$i, $row['nombretiposervicio']);
			$sheet->setCellValue('V'.$i, $row['idusuario']);
			$sheet->setCellValue('W'.$i, $row['nombreusuario']);
			$sheet->setCellValue('X'.$i, $row['concatenado']);
			$sheet->setCellValue('Y'.$i, $row['concatenadodetalle']);
			$i++;
		}
		$sheet->getStyle('A1:Y1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++){
			$sheet->getStyle('A'.$j.':Y'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_Servicio.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}

	private function formatDateOrDefault($dateInput, $default = null) {
		$tempdate = trim($dateInput);
		// Verificar si no está vacío y contiene '/'
		if (!empty($tempdate) && strpos($tempdate, '/') !== false)
		{
			$tempdateArray = explode('/', $tempdate);
			// Asegurarse de que el formato tenga tres partes (día/mes/año)
			if (count($tempdateArray) === 3)
			{
				return date('Y-m-d', strtotime($tempdateArray[1]. '/'. $tempdateArray[0]. '/'. $tempdateArray[2]));
			}
		}
		return $default;
	}
}
