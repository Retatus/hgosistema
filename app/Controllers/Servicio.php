<?php namespace App\Controllers;
use App\Controllers\BaseController;
use DateTime;
use App\Models\AuditoriaModel;
use App\Models\PaginadoModel;
use App\Models\ServicioModel;
use App\Models\BandaModel;
use App\Models\CondicionModel;
use App\Models\MarcaModel;
use App\Models\MedidaModel;
use App\Models\ReencauchadoraModel;
use App\Models\TiposervicioModel;
use App\Models\UbicacionModel;
use App\Models\ClienteModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;


class Servicio extends BaseController
{
	protected $auditoria;
	protected $paginado;
	protected $servicio;
	protected $banda;
	protected $condicion;
	protected $marca;
	protected $medida;
	protected $reencauchadora;
	protected $tiposervicio;
	protected $ubicacion;
	protected $cliente;


//   SECCION ====== CONSTRUCT ======
	public function __construct(){
		$this->auditoria = new AuditoriaModel();
		$this->paginado = new PaginadoModel();
		$this->servicio = new ServicioModel();
		$this->banda = new BandaModel();
		$this->condicion = new CondicionModel();
		$this->marca = new MarcaModel();
		$this->medida = new MedidaModel();
		$this->reencauchadora = new ReencauchadoraModel();
		$this->tiposervicio = new TiposervicioModel();
		$this->ubicacion = new UbicacionModel();
		$this->cliente = new ClienteModel();

	}

//   SECCION ====== INDEX ======
	public function index($bestado = 1)
	{
		$servicio = $this->servicio->getServicios(20, 1, 1, 1, '');
		$total = $this->servicio->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'servicio', 'pag' => $pag, 'datos' => $servicio];
		$banda = $this->banda->getBandasSelect2();
		$condicion = $this->condicion->getCondicionsSelect2();
		$marca = $this->marca->getMarcasSelect2();
		$medida = $this->medida->getMedidasSelect2();
		$reencauchadora = $this->reencauchadora->getReencauchadorasSelect2();
		$tiposervicio = $this->tiposervicio->getTiposerviciosSelect2();
		$ubicacion = $this->ubicacion->getUbicacionsSelect2();
		$cliente = $this->cliente->getClientes(10, 1, 1, '');

		echo view('layouts/header', ['bandas' => $banda, 'condicions' => $condicion, 'marcas' => $marca, 'medidas' => $medida, 'reencauchadoras' => $reencauchadora, 'tiposervicios' => $tiposervicio, 'ubicacions' => $ubicacion, 'clientes' => $cliente]);
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
		$todos2 = $this->request->getPost('todos2');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		if($accion !== 'leer'){
			$nidservicio = strtoupper(trim($this->request->getPost('idservicio')));
			$sidcliente = strtoupper(trim($this->request->getPost('idcliente')));
			$sidclientetext = strtoupper(trim($this->request->getPost('idclientetext')));
			$tfecharecepcion = trim($this->request->getPost('fecharecepcion'));
			$tfecharecepcion = $this->formatDateOrDefault($tfecharecepcion, null);
			$nidbanda = strtoupper(trim($this->request->getPost('idbanda')));
			$nidbandatext = strtoupper(trim($this->request->getPost('idbandatext')));
			$splaca = strtoupper(trim($this->request->getPost('placa')));
			$sobservacioningreso = strtoupper(trim($this->request->getPost('observacioningreso')));
			$nidtiposervicio = strtoupper(trim($this->request->getPost('idtiposervicio')));
			$nidtiposerviciotext = strtoupper(trim($this->request->getPost('idtiposerviciotext')));
			$nidmedida = strtoupper(trim($this->request->getPost('idmedida')));
			$nidmedidatext = strtoupper(trim($this->request->getPost('idmedidatext')));
			$nidmarca = strtoupper(trim($this->request->getPost('idmarca')));
			$nidmarcatext = strtoupper(trim($this->request->getPost('idmarcatext')));
			$scodigo = strtoupper(trim($this->request->getPost('codigo')));
			$nidubicacion = strtoupper(trim($this->request->getPost('idubicacion')));
			$nidubicaciontext = strtoupper(trim($this->request->getPost('idubicaciontext')));
			$nidreencauchadora = strtoupper(trim($this->request->getPost('idreencauchadora')));
			$nidreencauchadoratext = strtoupper(trim($this->request->getPost('idreencauchadoratext')));
			$tfechatienda = trim($this->request->getPost('fechatienda'));
			$tfechatienda = $this->formatDateOrDefault($tfechatienda, null);
			$nidcondicion = strtoupper(trim($this->request->getPost('idcondicion')));
			$nidcondiciontext = strtoupper(trim($this->request->getPost('idcondiciontext')));
			$tfechaentrega = trim($this->request->getPost('fechaentrega'));
			$tfechaentrega = $this->formatDateOrDefault($tfechaentrega, null);
			$sobservacionsalida = strtoupper(trim($this->request->getPost('observacionsalida')));
			$susuario = strtoupper(trim($this->request->getPost('usuario')));
			$bformaestado = strtoupper(trim($this->request->getPost('formaestado')));
			$sdocrefrencia = strtoupper(trim($this->request->getPost('docrefrencia')));
			$bestado = strtoupper(trim($this->request->getPost('estado')));
		}


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion){
			case 'agregar':
				$data  = array(
					'nidservicio' => intval($nidservicio),
					'sidcliente' => $sidcliente,
					'tfecharecepcion' => $tfecharecepcion,
					'nidbanda' => intval($nidbanda),
					'splaca' => $splaca,
					'sobservacioningreso' => $sobservacioningreso,
					'nidtiposervicio' => intval($nidtiposervicio),
					'nidmedida' => intval($nidmedida),
					'nidmarca' => intval($nidmarca),
					'scodigo' => $scodigo,
					'nidubicacion' => intval($nidubicacion),
					'nidreencauchadora' => intval($nidreencauchadora),
					'tfechatienda' => $tfechatienda,
					'nidcondicion' => $nidcondicion,
					'tfechaentrega' => $tfechaentrega,
					'sobservacionsalida' => $sobservacionsalida,
					'susuario' => $susuario,
					'bformaestado' => $bformaestado,
					'sdocrefrencia' => $sdocrefrencia,
					'bestado' => intval($bestado),

				);
				if ($this->servicio->existe($nidservicio, $sidcliente, $nidbanda, $nidtiposervicio, $nidmedida, $nidmarca, $nidubicacion, $nidreencauchadora, $nidcondicion) == 1){
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->servicio->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'sidcliente' => $sidcliente,
					'tfecharecepcion' => $tfecharecepcion,
					'nidbanda' => intval($nidbanda),
					'splaca' => $splaca,
					'sobservacioningreso' => $sobservacioningreso,
					'nidtiposervicio' => intval($nidtiposervicio),
					'nidmedida' => intval($nidmedida),
					'nidmarca' => intval($nidmarca),
					'scodigo' => $scodigo,
					'nidubicacion' => intval($nidubicacion),
					'nidreencauchadora' => intval($nidreencauchadora),
					'tfechatienda' => $tfechatienda,
					'nidcondicion' => $nidcondicion,
					'tfechaentrega' => $tfechaentrega,
					'sobservacionsalida' => $sobservacionsalida,
					'susuario' => $susuario,
					'bformaestado' => $bformaestado,
					'sdocrefrencia' => $sdocrefrencia,
					'bestado' => intval($bestado),
					'dataaux' => array(
						'sidclientetext' => $sidclientetext,
						'nidbandatext' =>  $nidbandatext,
						'nidtiposerviciotext' =>  $nidtiposerviciotext,
						'nidmedidatext' =>  $nidmedidatext,
						'nidmarcatext' =>  $nidmarcatext,
						'nidubicaciontext' =>  $nidubicaciontext,
						'nidreencauchadoratext' =>  $nidreencauchadoratext,
						'nidcondiciontext' =>  $nidcondiciontext,
					)

				);

				$this->Auditoria($nidservicio, $data, $susuario);
				unset($data['dataaux']);


				$this->servicio->UpdateServicio($nidservicio, $data);
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
		$total = $this->servicio->getCount($todos, $todos2, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->servicio->getServicios(20, $pag, $todos, $todos2, $texto)];
		echo json_encode($respt);
	}

	public function Auditoria($nidservicio, $datosActualizados, $usuario) {
		$datosAnteriores = $this->servicio->find($nidservicio);
		// Extraer $dataaux desde $datosActualizados.
		$dataaux = $datosActualizados['dataaux'] ?? [];
	
		foreach ($datosActualizados as $campo => $nuevoValor) {
			if ($campo === 'dataaux') {
				continue;
			}
			
			$valorAnterior = $datosAnteriores[$campo] ?? null;
			if ($valorAnterior != $nuevoValor) {
	
				$campoModificadoConTexto = $campo . 'text';
				$valorTexto = $dataaux[$campoModificadoConTexto] ?? '';
				$nuevoValor = $valorTexto == "" ? $nuevoValor : $nuevoValor."-".$valorTexto;
				$campo_modificado = $campo;
				$fecha_modificacion = date('Y-m-d H:i:s');
				$data = [
					'nidservicio' => intval($nidservicio),
					'scampo_modificado' => $campo_modificado,
					'svalor_anterior' => $valorAnterior,
					'svalor_nuevo' => $nuevoValor,
					'tfecha_modificacion' => $fecha_modificacion,
					'susuario_modificacion' => $usuario,
					'bestado' => 1
				];
				$this->auditoria->insert($data);
			}
		}
	}

//   SECCION ====== EDIT ======
	public function edit(){
		$nidservicio = strtoupper(trim($this->request->getPost('idservicio')));
		$sidcliente = strtoupper(trim($this->request->getPost('idcliente')));
		$nidbanda = strtoupper(trim($this->request->getPost('idbanda')));
		$nidtiposervicio = strtoupper(trim($this->request->getPost('idtiposervicio')));
		$nidmedida = strtoupper(trim($this->request->getPost('idmedida')));
		$nidmarca = strtoupper(trim($this->request->getPost('idmarca')));
		$nidubicacion = strtoupper(trim($this->request->getPost('idubicacion')));
		$nidreencauchadora = strtoupper(trim($this->request->getPost('idreencauchadora')));
		$nidcondicion = strtoupper(trim($this->request->getPost('idcondicion')));

		$data = $this->servicio->getServicio($nidservicio, $sidcliente, $nidbanda, $nidtiposervicio, $nidmedida, $nidmarca, $nidubicacion, $nidreencauchadora, $nidcondicion);
		echo json_encode($data);
	}

//   SECCION ====== SELECT2 ======
	public function listaSelect2(){
		$data = $this->servicio->getServiciosSelect2();
		echo json_encode($data);
	}

	public function autocompleteservicios()
	{
		$todos = 1;
		$todos2 = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->servicio->getAutocompleteservicios($todos, $todos, $keyword);
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
	public function autocompleteubicacions()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->ubicacion->getAutocompleteubicacions($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompleteclientes()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->cliente->getAutocompleteclientes($todos,$keyword);
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
		$sheet->getColumnDimension('Z')->setAutoSize(true);
		$sheet->getColumnDimension('AA')->setAutoSize(true);
		$sheet->getColumnDimension('AB')->setAutoSize(true);
		$sheet->getColumnDimension('AC')->setAutoSize(true);
		$sheet->getColumnDimension('AD')->setAutoSize(true);
		$sheet->getStyle('A1:AD1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ], ];
		$sheet->setCellValue('A1', 'IDSERVICIO');
		$sheet->setCellValue('B1', 'FECHARECEPCION');
		$sheet->setCellValue('C1', 'PLACA');
		$sheet->setCellValue('D1', 'OBSERVACIONINGRESO');
		$sheet->setCellValue('E1', 'CODIGO');
		$sheet->setCellValue('F1', 'FECHATIENDA');
		$sheet->setCellValue('G1', 'FECHAENTREGA');
		$sheet->setCellValue('H1', 'OBSERVACIONSALIDA');
		$sheet->setCellValue('I1', 'USUARIO');
		$sheet->setCellValue('J1', 'FORMAESTADO');
		$sheet->setCellValue('K1', 'DOCREFRENCIA');
		$sheet->setCellValue('L1', 'ESTADO');
		$sheet->setCellValue('M1', 'IDBANDA');
		$sheet->setCellValue('N1', 'NOMBREBANDA');
		$sheet->setCellValue('O1', 'IDCONDICION');
		$sheet->setCellValue('P1', 'NOMBRECONDICION');
		$sheet->setCellValue('Q1', 'IDMARCA');
		$sheet->setCellValue('R1', 'NOMBREMARCA');
		$sheet->setCellValue('S1', 'IDMEDIDA');
		$sheet->setCellValue('T1', 'NOMBREMEDIDA');
		$sheet->setCellValue('U1', 'IDREENCAUCHADORA');
		$sheet->setCellValue('V1', 'NOMBREREENCAUCHADORA');
		$sheet->setCellValue('W1', 'IDTIPOSERVICIO');
		$sheet->setCellValue('X1', 'NOMBRETIPOSERVICIO');
		$sheet->setCellValue('Y1', 'IDUBICACION');
		$sheet->setCellValue('Z1', 'NOMBRETIPOUBICACION');
		$sheet->setCellValue('AA1', 'IDCLIENTE');
		$sheet->setCellValue('AB1', 'NOMBRECLIENTE');
		$sheet->setCellValue('AC1', 'CONCATENADO');
		$sheet->setCellValue('AD1', 'CONCATENADODETALLE');
		$i=2;
		foreach ($servicio as $row){
			$sheet->setCellValue('A'.$i, $row['idservicio']);
			$sheet->setCellValue('B'.$i, $row['fecharecepcion']);
			$sheet->setCellValue('C'.$i, $row['placa']);
			$sheet->setCellValue('D'.$i, $row['observacioningreso']);
			$sheet->setCellValue('E'.$i, $row['codigo']);
			$sheet->setCellValue('F'.$i, $row['fechatienda']);
			$sheet->setCellValue('G'.$i, $row['fechaentrega']);
			$sheet->setCellValue('H'.$i, $row['observacionsalida']);
			$sheet->setCellValue('I'.$i, $row['usuario']);
			$sheet->setCellValue('J'.$i, $row['formaestado']);
			$sheet->setCellValue('K'.$i, $row['docrefrencia']);
			$sheet->setCellValue('L'.$i, $row['estado']);
			$sheet->setCellValue('M'.$i, $row['idbanda']);
			$sheet->setCellValue('N'.$i, $row['nombrebanda']);
			$sheet->setCellValue('O'.$i, $row['idcondicion']);
			$sheet->setCellValue('P'.$i, $row['nombrecondicion']);
			$sheet->setCellValue('Q'.$i, $row['idmarca']);
			$sheet->setCellValue('R'.$i, $row['nombremarca']);
			$sheet->setCellValue('S'.$i, $row['idmedida']);
			$sheet->setCellValue('T'.$i, $row['nombremedida']);
			$sheet->setCellValue('U'.$i, $row['idreencauchadora']);
			$sheet->setCellValue('V'.$i, $row['nombrereencauchadora']);
			$sheet->setCellValue('W'.$i, $row['idtiposervicio']);
			$sheet->setCellValue('X'.$i, $row['nombretiposervicio']);
			$sheet->setCellValue('Y'.$i, $row['idubicacion']);
			$sheet->setCellValue('Z'.$i, $row['nombretipoubicacion']);
			$sheet->setCellValue('AA'.$i, $row['idcliente']);
			$sheet->setCellValue('AB'.$i, $row['nombrecliente']);
			$sheet->setCellValue('AC'.$i, $row['concatenado']);
			$sheet->setCellValue('AD'.$i, $row['concatenadodetalle']);
			$i++;
		}
		$sheet->getStyle('A1:AD1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++){
			$sheet->getStyle('A'.$j.':AD'.$j)->applyFromArray($border);
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
