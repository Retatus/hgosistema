<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaginadoModel;
use App\Models\ServicioModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use App\Models\UsuarioModel;
use App\Models\ClienteModel;
use App\Models\TiposervicioModel;
use App\Models\BandaModel;
use App\Models\NeumaticoModel;
use App\Models\UbicacionModel;
use App\Models\ReencauchadoraModel;
use App\Models\CondicionModel;


class Servicio extends BaseController
{
	protected $paginado;
	protected $servicio;
	protected $usuario;
	protected $cliente;
	protected $tiposervicio;
	protected $banda;
	protected $neumatico;
	protected $ubicacion;
	protected $reencauchadora;
	protected $condicion;


	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->servicio = new ServicioModel();
		$this->usuario = new UsuarioModel();
		$this->cliente = new ClienteModel();
		$this->tiposervicio = new TiposervicioModel();
		$this->banda = new BandaModel();
		$this->neumatico = new NeumaticoModel();
		$this->ubicacion = new UbicacionModel();
		$this->reencauchadora = new ReencauchadoraModel();
		$this->condicion = new CondicionModel();

	}

	// Definir la función en el controlador
    private function formatDateOrDefault($dateInput, $default = null) {
        // Limpiar espacios en blanco y verificar si la fecha está presente
        $tempdate = trim($dateInput);
    
        // Verificar si no está vacío y contiene '/'
        if (!empty($tempdate) && strpos($tempdate, '/') !== false) {
            $tempdateArray = explode('/', $tempdate);
            
            // Asegurarse de que el formato tenga tres partes (día/mes/año)
            if (count($tempdateArray) === 3) {
                // Formatear la fecha a Y-m-d
                return date('Y-m-d', strtotime($tempdateArray[1] . '/' . $tempdateArray[0] . '/' . $tempdateArray[2]));
            }
        }
        
        // Si no es válido, devolver el valor por defecto (puede ser null o un valor específico)
        return $default;
    }

	public function index($bestado = 1)
	{
		$servicio = $this->servicio->getServicios(1, '', 20, 1);
		$total = $this->servicio->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'servicio', 'pag' => $pag, 'datos' => $servicio];
		$usuario = $this->usuario->getUsuarios(1, '', 10, 1);
		$cliente = $this->cliente->getClientes(1, '', 10, 1);
		$tiposervicio = $this->tiposervicio->getTiposervicios(1, '', 10, 1);
		$banda = $this->banda->getBandas(1, '', 10, 1);
		$neumatico = $this->neumatico->getNeumaticos(1, '', 10, 1);
		$ubicacion = $this->ubicacion->getUbicacions(1, '', 10, 1);
		$reencauchadora = $this->reencauchadora->getReencauchadoras(1, '', 10, 1);
		$condicion = $this->condicion->getCondicions(1, '', 10, 1);

		echo view('layouts/header', ['usuarios' => $usuario, 'clientes' => $cliente, 'tiposervicios' => $tiposervicio, 'bandas' => $banda, 'neumaticos' => $neumatico, 'ubicacions' => $ubicacion, 'reencauchadoras' => $reencauchadora, 'condicions' => $condicion]);
		echo view('layouts/aside');
		echo view('servicio/list', $data);
		echo view('layouts/footer');

	}
	public function agregar(){
	
		$total = $this->servicio->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;

		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		$nidservicio = strtoupper(trim($this->request->getPost('idservicio')));

		$tfechaingreso = trim($this->request->getPost('fechaingreso'));
		// $tempdate = explode('/', $tempdate);
		// $tfechaingreso = date('Y-m-d', strtotime($tempdate[1].'/'.$tempdate[0].'/'.$tempdate[2]));
		$tfechaingreso = $this->formatDateOrDefault($tfechaingreso, null);

		$sidusuario = strtoupper(trim($this->request->getPost('idusuario')));
		$sobservacioningreso = strtoupper(trim($this->request->getPost('observacioningreso')));
		$sidcliente = strtoupper(trim($this->request->getPost('idcliente')));
		$nidtiposervicio = strtoupper(trim($this->request->getPost('idtiposervicio')));
		$nidbanda = strtoupper(trim($this->request->getPost('idbanda')));
		$nidneumatico = strtoupper(trim($this->request->getPost('idneumatico')));
		$nidubicacion = strtoupper(trim($this->request->getPost('idubicacion')));
		$nidrencauchadora = strtoupper(trim($this->request->getPost('idrencauchadora')));

		$tfecchasalida = trim($this->request->getPost('fecchasalida'));
		// $tempdate = explode('/', $tempdate);
		// $tfecchasalida = date('Y-m-d', strtotime($tempdate[1].'/'.$tempdate[0].'/'.$tempdate[2]));
		$tfecchasalida = $this->formatDateOrDefault($tfecchasalida, null);
		
		$sobservacionsalida = strtoupper(trim($this->request->getPost('observacionsalida')));
		$nidcondicion = strtoupper(trim($this->request->getPost('idcondicion')));
		$nestado = strtoupper(trim($this->request->getPost('estado')));

		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion) {
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
					'tfecchasalida' => $tfecchasalida,
					'sobservacionsalida' => $sobservacionsalida,
					'nidcondicion' => $nidcondicion,
					'nestado' => $nestado,

				);
				if ($this->servicio->existe($nidservicio,$sidcliente,$nidubicacion,$nidbanda,$nidcondicion,$nidneumatico,$nidrencauchadora,$nidtiposervicio,$sidusuario) == 1) {
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->servicio->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'nestado' => 0
				);
				$this->servicio->UpdateServicio($nidservicio, $data);

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
					'tfecchasalida' => $tfecchasalida,
					'sobservacionsalida' => $sobservacionsalida,
					'nidcondicion' => $nidcondicion,
					'nestado' => $nestado,

				);
				$this->servicio->insert($data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'nestado' => 0
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
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->servicio->getservicios($todos, $texto, 20, $pag)];
		echo json_encode($respt);
	}

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

		$data = $this->servicio->getServicio($nidservicio,$sidcliente,$nidubicacion,$nidbanda,$nidcondicion,$nidneumatico,$nidrencauchadora,$nidtiposervicio,$sidusuario);
		echo json_encode($data);
	}

	public function autocompleteusuarios()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->usuario->getAutocompleteusuarios($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompleteclientes()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->cliente->getAutocompleteclientes($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompletetiposervicios()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->tiposervicio->getAutocompletetiposervicios($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompletebandas()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->banda->getAutocompletebandas($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompleteneumaticos()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->neumatico->getAutocompleteneumaticos($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompleteubicacions()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->ubicacion->getAutocompleteubicacions($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompletereencauchadoras()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->reencauchadora->getAutocompletereencauchadoras($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompletecondicions()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->condicion->getAutocompletecondicions($todos,$keyword);
		echo json_encode($data);
	}

	public function getserviciosSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->servicio->getserviciosSelectNombre($searchTerm);
		echo json_encode($response);
	}


	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de servicio', 0, 1, 'C');
		$pdf->Output('servicio.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

	public function excel()
	{
		$total = $this->servicio->getCount();

		$servicio = $this->servicio->getServicios(1, '', $total, 1);
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
		$sheet->getStyle('A1:S1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ], ];
		$sheet->setCellValue('A1', 'FECHAINGRESO');
		$sheet->setCellValue('B1', 'NOMBREUSUARIO');
		$sheet->setCellValue('C1', 'IDUSUARIO');
		$sheet->setCellValue('D1', 'OBSERVACIONINGRESO');
		$sheet->setCellValue('E1', 'IDCLIENTE');
		$sheet->setCellValue('F1', 'NOMBRETIPOSERVICIO');
		$sheet->setCellValue('G1', 'IDTIPO');
		$sheet->setCellValue('H1', 'NOMBREBANDA');
		$sheet->setCellValue('I1', 'IDBANDA');
		$sheet->setCellValue('J1', 'IDNEUMATICO');
		$sheet->setCellValue('K1', 'NOMBRETIPOUBICACION');
		$sheet->setCellValue('L1', 'IDUBICACION');
		$sheet->setCellValue('M1', 'NOMBREREENCAUCHADORA');
		$sheet->setCellValue('N1', 'IDRENCAUCHADORA');
		$sheet->setCellValue('O1', 'FECCHASALIDA');
		$sheet->setCellValue('P1', 'OBSERVACIONSALIDA');
		$sheet->setCellValue('Q1', 'NOMBRECONDICION');
		$sheet->setCellValue('R1', 'IDCONDICION');
		$sheet->setCellValue('S1', 'ESTADO');
		$i=2;
		foreach ($servicio as $row) {
			$sheet->setCellValue('A'.$i, $row['fechaingreso']);
			$sheet->setCellValue('B'.$i, $row['nombreusuario']);
			$sheet->setCellValue('C'.$i, $row['idusuario']);
			$sheet->setCellValue('D'.$i, $row['observacioningreso']);
			$sheet->setCellValue('E'.$i, $row['idcliente']);
			$sheet->setCellValue('F'.$i, $row['nombretiposervicio']);
			$sheet->setCellValue('G'.$i, $row['idtiposervicio']);
			$sheet->setCellValue('H'.$i, $row['nombrebanda']);
			$sheet->setCellValue('I'.$i, $row['idbanda']);
			$sheet->setCellValue('J'.$i, $row['idneumatico']);
			$sheet->setCellValue('K'.$i, $row['nombretipoubicacion']);
			$sheet->setCellValue('L'.$i, $row['idubicacion']);
			$sheet->setCellValue('M'.$i, $row['nombrereencauchadora']);
			$sheet->setCellValue('N'.$i, $row['idrencauchadora']);
			$sheet->setCellValue('O'.$i, $row['fecchasalida']);
			$sheet->setCellValue('P'.$i, $row['observacionsalida']);
			$sheet->setCellValue('Q'.$i, $row['nombrecondicion']);
			$sheet->setCellValue('R'.$i, $row['idcondicion']);
			$sheet->setCellValue('S'.$i, $row['estado']);
			$i++;
		}
		$sheet->getStyle('A1:S1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++) {
			$sheet->getStyle('A'.$j.':S'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_servicio.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}

}
