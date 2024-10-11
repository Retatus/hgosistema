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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarTiposervicio'>
									<span class='fa fa-plus'></span> Agregar Tiposervicio
								</button>
								<a href='<?php echo base_url();?>tiposervicio/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>tiposervicio/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroTiposervicio'>
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
							<table id='TablaTiposervicio' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th hidden>Id</th>
										<th >Nombre</th>
										<th>Acciones</th>

									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $tiposervicio):?>
											<tr>
												<td hidden><?php echo $tiposervicio['idtiposervicio'];?></td>
												<td ><?php echo $tiposervicio['nombretiposervicio'];?></td>

												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarTiposervicio('<?php echo $tiposervicio['idtiposervicio'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href='<?php echo base_url();?>reserva/add/<?php echo $tiposervicio['idtiposervicio'];?>'><i class='fa fa-pencil'></i></a>
														</div>
													</div>
												</td>
											</tr>
										<?php endforeach;?>
									<?php endif;?>
								</tbody>
							</table>
						</div>
						<div id='PaginadoTiposervicio'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<div class='modal fade' id='modalAgregarTiposervicio' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Tiposervicio</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row'hidden>
					<label class='col-sm-4' for='id'>id:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='idtiposervicio' name='idtiposervicio' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>nombre:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='nombretiposervicio' name='nombretiposervicio' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>

			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarTiposervicio'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarTiposervicio'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarTiposervicio'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarTiposervicio' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>

<script>
	var NuevoTiposervicio;
	var base_url= '<?php echo base_url();?>';




	function load(pag){
		RecolectarDatosTiposervicio();
		EnviarInformacionTiposervicio('leer', NuevoTiposervicio, false, pag);
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



	$('#btnAgregarTiposervicio').click(function(){
		LimpiarModalDatosTiposervicio();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#btnModalAgregarTiposervicio').toggle(true);
		$('#btnModalEditarTiposervicio').toggle(false);
		$('#btnModalEliminarTiposervicio').toggle(false);
		$('#modalAgregarTiposervicio').modal();
	});


	function btnEditarTiposervicio(Val0){
		$.ajax({
			type: 'POST',
			url: base_url + '/tiposervicio/edit',
			data: { idtiposervicio: Val0},
			success: function(msg){
			debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosTiposervicio();
				$('#idtiposervicio').val(temp.idtiposervicio);
				$('#nombretiposervicio').val(temp.nombretiposervicio);



				$('#btnModalAgregarTiposervicio').toggle(false);
				$('#btnModalEditarTiposervicio').toggle(true);
				$('#btnModalEliminarTiposervicio').toggle(true);
				$('#modalAgregarTiposervicio').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}


	$('#btnModalAgregarTiposervicio').click(function(){
	debugger

		if (ValidarCamposVaciosTiposervicio() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosTiposervicio();
			EnviarInformacionTiposervicio('agregar', NuevoTiposervicio, true);
		}
	});


	$('#btnModalEditarTiposervicio').click(function(){
		if (ValidarCamposVaciosTiposervicio() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosTiposervicio();
			EnviarInformacionTiposervicio('modificar', NuevoTiposervicio, true);
		}
	});


	$('#btnModalEliminarTiposervicio').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosTiposervicio();
			EnviarInformacionTiposervicio('eliminar', NuevoTiposervicio, true);
		}
	});




	$('#btnFiltroTiposervicio').click(function(){
		RecolectarDatosTiposervicio();
		EnviarInformacionTiposervicio('leer', NuevoTiposervicio, false);
	});


	function Paginado(pag) {
		RecolectarDatosTiposervicio();
		EnviarInformacionTiposervicio('leer', NuevoTiposervicio, false, pag);
	}


	function RecolectarDatosTiposervicio(){
		NuevoTiposervicio = {
			idtiposervicio: $('#idtiposervicio').val().toUpperCase(),
			nombretiposervicio: $('#nombretiposervicio').val().toUpperCase(),

			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}


	function EnviarInformacionTiposervicio(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/tiposervicio/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoTiposervicio').empty();
				$('#PaginadoTiposervicio').append(resp.pag);
				if (modal) {
					$('#modalAgregarTiposervicio').modal('toggle');
					LimpiarModalDatosTiposervicio();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaTiposervicio(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaTiposervicio(resp.datos)
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


	function LimpiarModalDatosTiposervicio(){
		$('#idtiposervicio').val('0');
		$('#nombretiposervicio').val('');

	}


	function ValidarCamposVaciosTiposervicio(){
		var error = 0;
		if ($('#idtiposervicio').val() == ''){
			Resaltado('idtiposervicio');
			error++;
		}
		if ($('#nombretiposervicio').val() == ''){
			Resaltado('nombretiposervicio');
			error++;
		}

		return error;
	}


	function Resaltado(id){
		$('#'+id).css('border-color', '#ef5350');
		$('#'+id).focus();
	}


	function CargartablaTiposervicio(objeto){   
		$('#TablaTiposervicio tr').not($('#TablaTiposervicio tr:first')).remove();
		$.each(objeto, function(i, value) {
		var fila = '<tr>'+
			'<td hidden>'+value.idtiposervicio+'</td>'+
			'<td >'+value.nombretiposervicio+'</td>'+

			'<td>'+
				'<div class="row">'+
					'<div style="margin: auto;">'+
						'<button type="button" onclick="btnEditarTiposervicio(\''+value.idtiposervicio+'\')" class="btn btn-info btn-xs">'+
							'<span class="fa fa-search fa-sm"></span>'+
						'</button>'+
					'</div>'+
						'<div style="margin: auto;">'+
							'<a class="btn btn-success btn-xs" href="<?php echo base_url();?>/reserva/add"><i class="fa fa-pencil"></i></a>'+
					'</div>'+
				'</div>'+
			'</td>'+
		'</tr>';
		$('#TablaTiposervicio tbody').append(fila);
		});
	}


	function addEstado(i){
		$('#estado_'+i).append($('<option>').val('1').text('ACTIVO'));
		$('#estado_'+i).append($('<option>').val('0').text('DESACTIVO'));
	}


</script>
