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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarUbicacion'>
									<span class='fa fa-plus'></span> Agregar Ubicacion
								</button>
								<a href='<?php echo base_url();?>ubicacion/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>ubicacion/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroUbicacion'>
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
							<table id='TablaUbicacion' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th hidden>Id</th>
										<th >Nombretipo</th>
										<th>Acciones</th>

									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $ubicacion):?>
											<tr>
												<td hidden><?php echo $ubicacion['idubicacion'];?></td>
												<td ><?php echo $ubicacion['nombretipoubicacion'];?></td>

												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarUbicacion('<?php echo $ubicacion['idubicacion'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href='<?php echo base_url();?>reserva/add/<?php echo $ubicacion['idubicacion'];?>'><i class='fa fa-pencil'></i></a>
														</div>
													</div>
												</td>
											</tr>
										<?php endforeach;?>
									<?php endif;?>
								</tbody>
							</table>
						</div>
						<div id='PaginadoUbicacion'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<div class='modal fade' id='modalAgregarUbicacion' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Ubicacion</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row'hidden>
					<label class='col-sm-4' for='id'>id:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='idubicacion' name='idubicacion' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>nombretipo:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='nombretipoubicacion' name='nombretipoubicacion' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>

			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarUbicacion'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarUbicacion'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarUbicacion'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarUbicacion' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>

<script>
	var NuevoUbicacion;
	var base_url= '<?php echo base_url();?>';




	function load(pag){
		RecolectarDatosUbicacion();
		EnviarInformacionUbicacion('leer', NuevoUbicacion, false, pag);
	}



	$('#idcliente').autocomplete({ 
		source: function(request, response) {
			$.ajax({
				type: 'POST',
				url: base_url + 'servicio/autocompleteclientes',
				dataType: 'json',
				data: { keyword: request.term },
				success: function(data){
					response($.map(data, function(item) {
						return {
							label: item.concatenado,
							concatenado: item.concatenado,
							idtour: item.idcliente,
							
							
							
						}
					}))
				}
			});
		},
		minLength: 2,
		select: function( event, ui ) {
			$('#idcliente').val('');
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



	$('#btnAgregarUbicacion').click(function(){
		LimpiarModalDatosUbicacion();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#btnModalAgregarUbicacion').toggle(true);
		$('#btnModalEditarUbicacion').toggle(false);
		$('#btnModalEliminarUbicacion').toggle(false);
		$('#modalAgregarUbicacion').modal();
	});


	function btnEditarUbicacion(Val0){
		$.ajax({
			type: 'POST',
			url: base_url + '/ubicacion/edit',
			data: { idubicacion: Val0},
			success: function(msg){
			debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosUbicacion();
				$('#idubicacion').val(temp.idubicacion);
				$('#nombretipoubicacion').val(temp.nombretipoubicacion);



				$('#btnModalAgregarUbicacion').toggle(false);
				$('#btnModalEditarUbicacion').toggle(true);
				$('#btnModalEliminarUbicacion').toggle(true);
				$('#modalAgregarUbicacion').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}


	$('#btnModalAgregarUbicacion').click(function(){
	debugger

		if (ValidarCamposVaciosUbicacion() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosUbicacion();
			EnviarInformacionUbicacion('agregar', NuevoUbicacion, true);
		}
	});


	$('#btnModalEditarUbicacion').click(function(){
		if (ValidarCamposVaciosUbicacion() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosUbicacion();
			EnviarInformacionUbicacion('modificar', NuevoUbicacion, true);
		}
	});


	$('#btnModalEliminarUbicacion').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosUbicacion();
			EnviarInformacionUbicacion('eliminar', NuevoUbicacion, true);
		}
	});




	$('#btnFiltroUbicacion').click(function(){
		RecolectarDatosUbicacion();
		EnviarInformacionUbicacion('leer', NuevoUbicacion, false);
	});


	function Paginado(pag) {
		RecolectarDatosUbicacion();
		EnviarInformacionUbicacion('leer', NuevoUbicacion, false, pag);
	}


	function RecolectarDatosUbicacion(){
		NuevoUbicacion = {
			idubicacion: $('#idubicacion').val().toUpperCase(),
			nombretipoubicacion: $('#nombretipoubicacion').val().toUpperCase(),

			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}


	function EnviarInformacionUbicacion(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/ubicacion/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoUbicacion').empty();
				$('#PaginadoUbicacion').append(resp.pag);
				if (modal) {
					$('#modalAgregarUbicacion').modal('toggle');
					LimpiarModalDatosUbicacion();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaUbicacion(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaUbicacion(resp.datos)
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


	function LimpiarModalDatosUbicacion(){
		$('#idubicacion').val('0');
		$('#nombretipoubicacion').val('');

	}


	function ValidarCamposVaciosUbicacion(){
		var error = 0;
		if ($('#idubicacion').val() == ''){
			Resaltado('idubicacion');
			error++;
		}
		if ($('#nombretipoubicacion').val() == ''){
			Resaltado('nombretipoubicacion');
			error++;
		}

		return error;
	}


	function Resaltado(id){
		$('#'+id).css('border-color', '#ef5350');
		$('#'+id).focus();
	}


	function CargartablaUbicacion(objeto){   
		$('#TablaUbicacion tr').not($('#TablaUbicacion tr:first')).remove();
		$.each(objeto, function(i, value) {
		var fila = '<tr>'+
			'<td hidden>'+value.idubicacion+'</td>'+
			'<td >'+value.nombretipoubicacion+'</td>'+

			'<td>'+
				'<div class="row">'+
					'<div style="margin: auto;">'+
						'<button type="button" onclick="btnEditarUbicacion(\''+value.idubicacion+'\')" class="btn btn-info btn-xs">'+
							'<span class="fa fa-search fa-sm"></span>'+
						'</button>'+
					'</div>'+
						'<div style="margin: auto;">'+
							'<a class="btn btn-success btn-xs" href="<?php echo base_url();?>/reserva/add"><i class="fa fa-pencil"></i></a>'+
					'</div>'+
				'</div>'+
			'</td>'+
		'</tr>';
		$('#TablaUbicacion tbody').append(fila);
		});
	}


	function addEstado(i){
		$('#estado_'+i).append($('<option>').val('1').text('ACTIVO'));
		$('#estado_'+i).append($('<option>').val('0').text('DESACTIVO'));
	}


</script>
