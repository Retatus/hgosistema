<div class='content-wrapper'>
	<section class='content-header'>
	</section>
	<section class='content'>
		<div class='row'>
			<div class='col-12'>
				<div class='card'>
					<div class='card-header'>
						<div class='row'>
							<div class='col-sm-8'>
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarCliente'>
									<span class='fa fa-plus'></span> Agregar Cliente
								</button>
								<a href='<?php echo base_url();?>cliente/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>cliente/pdf' target='_blank' class='btn btn-danger btn-sm'>
									<span class='fa fa-file-pdf-o'></span> Exportar
								</a>
							</div>
							<div class='col-sm-4'>
								<div class='d-flex flex-row'>
									<div class='p-2'>
										<input id='idFTexto' type='search' class='form-control form-control-sm' placeholder='Doc. | Nombre | Apellido'>
									</div>
									<div class='p-2'>
										<div class='input-group'>
											<select id='idFTodos' class='form-control form-control-sm'>
												<option value=''>TODOS</option>
												<option value='0'>DESCATIVOS</option>
												<option value='1' selected>ACTIVOS</option>
											</select>
											<span class='input-group-btn'>
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroCliente'>
													<span class='fa fa-filter'></span> Buscar
												</button>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class='card-body'>
						<div class='demo-content scroll'>
							<table id='TablaCliente' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th >Id</th>
										<th >Rasonsocial</th>
										<th >Direccion</th>
										<th >Telefono</th>
										<th>Acciones</th>

									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $cliente):?>
											<tr>
												<td ><?php echo $cliente['idcliente'];?></td>
												<td ><?php echo $cliente['rasonsocial'];?></td>
												<td ><?php echo $cliente['direccion'];?></td>
												<td ><?php echo $cliente['telefono'];?></td>

												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarCliente('<?php echo $cliente['idcliente'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href='<?php echo base_url();?>reserva/add/<?php echo $cliente['idcliente'];?>'><i class='fa fa-pencil'></i></a>
														</div>
													</div>
												</td>
											</tr>
										<?php endforeach;?>
									<?php endif;?>
								</tbody>
							</table>
						</div>
						<div id='PaginadoCliente'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<div class='modal fade' id='modalAgregarCliente' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Cliente</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>id:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='idcliente' name='idcliente' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>rasonsocial:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='rasonsocial' name='rasonsocial' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>direccion:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='direccion' name='direccion' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>telefono:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='telefono' name='telefono' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>

			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarCliente'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarCliente'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarCliente'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarCliente' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>

<script>
	var NuevoCliente;
	var base_url= '<?php echo base_url();?>';




	function load(pag){
		RecolectarDatosCliente();
		EnviarInformacionCliente('leer', NuevoCliente, false, pag);
	}



	$('#idubicacion').autocomplete({ 
		source: function(request, response) {
			$.ajax({
				type: 'POST',
				url: base_url + 'servicio/autocompleteubicacions',
				dataType: 'json',
				data: { keyword: request.term },
				success: function(data){
					response($.map(data, function(item) {
						return {
							label: item.concatenado,
							concatenado: item.concatenado,
							idtour: item.idubicacion,
							nombre: item.nombretipoubicacion,

							
							
						}
					}))
				}
			});
		},
		minLength: 2,
		select: function( event, ui ) {
			$('#idubicacion').val('');
			return false;
		}
	});
	$('#idbanda').autocomplete({ 
		source: function(request, response) {
			$.ajax({
				type: 'POST',
				url: base_url + 'servicio/autocompletebandas',
				dataType: 'json',
				data: { keyword: request.term },
				success: function(data){
					response($.map(data, function(item) {
						return {
							label: item.concatenado,
							concatenado: item.concatenado,
							idtour: item.idbanda,
							nombre: item.nombrebanda,

							
							
						}
					}))
				}
			});
		},
		minLength: 2,
		select: function( event, ui ) {
			$('#idbanda').val('');
			return false;
		}
	});
	$('#idcondicion').autocomplete({ 
		source: function(request, response) {
			$.ajax({
				type: 'POST',
				url: base_url + 'servicio/autocompletecondicions',
				dataType: 'json',
				data: { keyword: request.term },
				success: function(data){
					response($.map(data, function(item) {
						return {
							label: item.concatenado,
							concatenado: item.concatenado,
							idtour: item.idcondicion,
							nombre: item.nombrecondicion,

							
							
						}
					}))
				}
			});
		},
		minLength: 2,
		select: function( event, ui ) {
			$('#idcondicion').val('');
			return false;
		}
	});
	$('#idneumatico').autocomplete({ 
		source: function(request, response) {
			$.ajax({
				type: 'POST',
				url: base_url + 'servicio/autocompleteneumaticos',
				dataType: 'json',
				data: { keyword: request.term },
				success: function(data){
					response($.map(data, function(item) {
						return {
							label: item.concatenado,
							concatenado: item.concatenado,
							idtour: item.idneumatico,
							
							
							
						}
					}))
				}
			});
		},
		minLength: 2,
		select: function( event, ui ) {
			$('#idneumatico').val('');
			return false;
		}
	});
	$('#idrencauchadora').autocomplete({ 
		source: function(request, response) {
			$.ajax({
				type: 'POST',
				url: base_url + 'servicio/autocompletereencauchadoras',
				dataType: 'json',
				data: { keyword: request.term },
				success: function(data){
					response($.map(data, function(item) {
						return {
							label: item.concatenado,
							concatenado: item.concatenado,
							idtour: item.idrencauchadora,
							nombre: item.nombrereencauchadora,

							
							
						}
					}))
				}
			});
		},
		minLength: 2,
		select: function( event, ui ) {
			$('#idrencauchadora').val('');
			return false;
		}
	});
	$('#idtiposervicio').autocomplete({ 
		source: function(request, response) {
			$.ajax({
				type: 'POST',
				url: base_url + 'servicio/autocompletetiposervicios',
				dataType: 'json',
				data: { keyword: request.term },
				success: function(data){
					response($.map(data, function(item) {
						return {
							label: item.concatenado,
							concatenado: item.concatenado,
							idtour: item.idtiposervicio,
							nombre: item.nombretiposervicio,

							
							
						}
					}))
				}
			});
		},
		minLength: 2,
		select: function( event, ui ) {
			$('#idtiposervicio').val('');
			return false;
		}
	});
	$('#idusuario').autocomplete({ 
		source: function(request, response) {
			$.ajax({
				type: 'POST',
				url: base_url + 'servicio/autocompleteusuarios',
				dataType: 'json',
				data: { keyword: request.term },
				success: function(data){
					response($.map(data, function(item) {
						return {
							label: item.concatenado,
							concatenado: item.concatenado,
							idtour: item.idusuario,
							nombre: item.nombreusuario,

							
							
						}
					}))
				}
			});
		},
		minLength: 2,
		select: function( event, ui ) {
			$('#idusuario').val('');
			return false;
		}
	});



	$('#btnAgregarCliente').click(function(){
		LimpiarModalDatosCliente();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#btnModalAgregarCliente').toggle(true);
		$('#btnModalEditarCliente').toggle(false);
		$('#btnModalEliminarCliente').toggle(false);
		$('#modalAgregarCliente').modal();
	});


	function btnEditarCliente(Val0){
		$.ajax({
			type: 'POST',
			url: base_url + '/cliente/edit',
			data: { idcliente: Val0},
			success: function(msg){
			debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosCliente();
				$('#idcliente').val(temp.idcliente);
				$('#rasonsocial').val(temp.rasonsocial);
				$('#direccion').val(temp.direccion);
				$('#telefono').val(temp.telefono);



				$('#btnModalAgregarCliente').toggle(false);
				$('#btnModalEditarCliente').toggle(true);
				$('#btnModalEliminarCliente').toggle(true);
				$('#modalAgregarCliente').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}


	$('#btnModalAgregarCliente').click(function(){
	debugger

		if (ValidarCamposVaciosCliente() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosCliente();
			EnviarInformacionCliente('agregar', NuevoCliente, true);
		}
	});


	$('#btnModalEditarCliente').click(function(){
		if (ValidarCamposVaciosCliente() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosCliente();
			EnviarInformacionCliente('modificar', NuevoCliente, true);
		}
	});


	$('#btnModalEliminarCliente').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosCliente();
			EnviarInformacionCliente('eliminar', NuevoCliente, true);
		}
	});




	$('#btnFiltroCliente').click(function(){
		RecolectarDatosCliente();
		EnviarInformacionCliente('leer', NuevoCliente, false);
	});


	function Paginado(pag) {
		RecolectarDatosCliente();
		EnviarInformacionCliente('leer', NuevoCliente, false, pag);
	}


	function RecolectarDatosCliente(){
		NuevoCliente = {
			idcliente: $('#idcliente').val().toUpperCase(),
			rasonsocial: $('#rasonsocial').val().toUpperCase(),
			direccion: $('#direccion').val().toUpperCase(),
			telefono: $('#telefono').val().toUpperCase(),

			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}


	function EnviarInformacionCliente(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/cliente/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoCliente').empty();
				$('#PaginadoCliente').append(resp.pag);
				if (modal) {
					$('#modalAgregarCliente').modal('toggle');
					LimpiarModalDatosCliente();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaCliente(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaCliente(resp.datos)
				}
			},
			error: function(){
				Swal.fire(
					'Oops...',
					'Something went wrong!',
					'error'
				)
			}
		});
	}


	function LimpiarModalDatosCliente(){
		$('#idcliente').val('0');
		$('#rasonsocial').val('');
		$('#direccion').val('');
		$('#telefono').val('');

	}


	function ValidarCamposVaciosCliente(){
		var error = 0;
		if ($('#idcliente').val() == ''){
			Resaltado('idcliente');
			error++;
		}
		if ($('#rasonsocial').val() == ''){
			Resaltado('rasonsocial');
			error++;
		}
		if ($('#direccion').val() == ''){
			Resaltado('direccion');
			error++;
		}
		if ($('#telefono').val() == ''){
			Resaltado('telefono');
			error++;
		}

		return error;
	}


	function Resaltado(id){
		$('#'+id).css('border-color', '#ef5350');
		$('#'+id).focus();
	}


	function CargartablaCliente(objeto){   
		$('#TablaCliente tr').not($('#TablaCliente tr:first')).remove();
		$.each(objeto, function(i, value) {
		var fila = '<tr>'+
			'<td >'+value.idcliente+'</td>'+
			'<td >'+value.rasonsocial+'</td>'+
			'<td >'+value.direccion+'</td>'+
			'<td >'+value.telefono+'</td>'+

			'<td>'+
				'<div class="row">'+
					'<div style="margin: auto;">'+
						'<button type="button" onclick="btnEditarCliente(\''+value.idcliente+'\')" class="btn btn-info btn-xs">'+
							'<span class="fa fa-search fa-sm"></span>'+
						'</button>'+
					'</div>'+
						'<div style="margin: auto;">'+
							'<a class="btn btn-success btn-xs" href="<?php echo base_url();?>/reserva/add"><i class="fa fa-pencil"></i></a>'+
					'</div>'+
				'</div>'+
			'</td>'+
		'</tr>';
		$('#TablaCliente tbody').append(fila);
		});
	}


	function addEstado(i){
		$('#estado_'+i).append($('<option>').val('1').text('ACTIVO'));
		$('#estado_'+i).append($('<option>').val('0').text('DESACTIVO'));
	}


</script>
