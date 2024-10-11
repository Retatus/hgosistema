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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarReencauchadora'>
									<span class='fa fa-plus'></span> Agregar Reencauchadora
								</button>
								<a href='<?php echo base_url();?>reencauchadora/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>reencauchadora/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroReencauchadora'>
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
							<table id='TablaReencauchadora' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th hidden>Idrencauchadora</th>
										<th >Nombre</th>
										<th >Direccion</th>
										<th>Acciones</th>

									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $reencauchadora):?>
											<tr>
												<td hidden><?php echo $reencauchadora['idrencauchadora'];?></td>
												<td ><?php echo $reencauchadora['nombrereencauchadora'];?></td>
												<td ><?php echo $reencauchadora['direccion'];?></td>

												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarReencauchadora('<?php echo $reencauchadora['idrencauchadora'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href='<?php echo base_url();?>reserva/add/<?php echo $reencauchadora['idrencauchadora'];?>'><i class='fa fa-pencil'></i></a>
														</div>
													</div>
												</td>
											</tr>
										<?php endforeach;?>
									<?php endif;?>
								</tbody>
							</table>
						</div>
						<div id='PaginadoReencauchadora'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<div class='modal fade' id='modalAgregarReencauchadora' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Reencauchadora</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row'hidden>
					<label class='col-sm-4' for='id'>idrencauchadora:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='idrencauchadora' name='idrencauchadora' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>nombre:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='nombrereencauchadora' name='nombrereencauchadora' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>direccion:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='direccion' name='direccion' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>

			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarReencauchadora'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarReencauchadora'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarReencauchadora'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarReencauchadora' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>

<script>
	var NuevoReencauchadora;
	var base_url= '<?php echo base_url();?>';




	function load(pag){
		RecolectarDatosReencauchadora();
		EnviarInformacionReencauchadora('leer', NuevoReencauchadora, false, pag);
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



	$('#btnAgregarReencauchadora').click(function(){
		LimpiarModalDatosReencauchadora();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#btnModalAgregarReencauchadora').toggle(true);
		$('#btnModalEditarReencauchadora').toggle(false);
		$('#btnModalEliminarReencauchadora').toggle(false);
		$('#modalAgregarReencauchadora').modal();
	});


	function btnEditarReencauchadora(Val0){
		$.ajax({
			type: 'POST',
			url: base_url + '/reencauchadora/edit',
			data: { idrencauchadora: Val0},
			success: function(msg){
			debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosReencauchadora();
				$('#idrencauchadora').val(temp.idrencauchadora);
				$('#nombrereencauchadora').val(temp.nombrereencauchadora);
				$('#direccion').val(temp.direccion);



				$('#btnModalAgregarReencauchadora').toggle(false);
				$('#btnModalEditarReencauchadora').toggle(true);
				$('#btnModalEliminarReencauchadora').toggle(true);
				$('#modalAgregarReencauchadora').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}


	$('#btnModalAgregarReencauchadora').click(function(){
	debugger

		if (ValidarCamposVaciosReencauchadora() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosReencauchadora();
			EnviarInformacionReencauchadora('agregar', NuevoReencauchadora, true);
		}
	});


	$('#btnModalEditarReencauchadora').click(function(){
		if (ValidarCamposVaciosReencauchadora() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosReencauchadora();
			EnviarInformacionReencauchadora('modificar', NuevoReencauchadora, true);
		}
	});


	$('#btnModalEliminarReencauchadora').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosReencauchadora();
			EnviarInformacionReencauchadora('eliminar', NuevoReencauchadora, true);
		}
	});




	$('#btnFiltroReencauchadora').click(function(){
		RecolectarDatosReencauchadora();
		EnviarInformacionReencauchadora('leer', NuevoReencauchadora, false);
	});


	function Paginado(pag) {
		RecolectarDatosReencauchadora();
		EnviarInformacionReencauchadora('leer', NuevoReencauchadora, false, pag);
	}


	function RecolectarDatosReencauchadora(){
		NuevoReencauchadora = {
			idrencauchadora: $('#idrencauchadora').val().toUpperCase(),
			nombrereencauchadora: $('#nombrereencauchadora').val().toUpperCase(),
			direccion: $('#direccion').val().toUpperCase(),

			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}


	function EnviarInformacionReencauchadora(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/reencauchadora/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoReencauchadora').empty();
				$('#PaginadoReencauchadora').append(resp.pag);
				if (modal) {
					$('#modalAgregarReencauchadora').modal('toggle');
					LimpiarModalDatosReencauchadora();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaReencauchadora(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaReencauchadora(resp.datos)
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


	function LimpiarModalDatosReencauchadora(){
		$('#idrencauchadora').val('0');
		$('#nombrereencauchadora').val('');
		$('#direccion').val('');

	}


	function ValidarCamposVaciosReencauchadora(){
		var error = 0;
		if ($('#idrencauchadora').val() == ''){
			Resaltado('idrencauchadora');
			error++;
		}
		if ($('#nombrereencauchadora').val() == ''){
			Resaltado('nombrereencauchadora');
			error++;
		}
		if ($('#direccion').val() == ''){
			Resaltado('direccion');
			error++;
		}

		return error;
	}


	function Resaltado(id){
		$('#'+id).css('border-color', '#ef5350');
		$('#'+id).focus();
	}


	function CargartablaReencauchadora(objeto){   
		$('#TablaReencauchadora tr').not($('#TablaReencauchadora tr:first')).remove();
		$.each(objeto, function(i, value) {
		var fila = '<tr>'+
			'<td hidden>'+value.idrencauchadora+'</td>'+
			'<td >'+value.nombrereencauchadora+'</td>'+
			'<td >'+value.direccion+'</td>'+

			'<td>'+
				'<div class="row">'+
					'<div style="margin: auto;">'+
						'<button type="button" onclick="btnEditarReencauchadora(\''+value.idrencauchadora+'\')" class="btn btn-info btn-xs">'+
							'<span class="fa fa-search fa-sm"></span>'+
						'</button>'+
					'</div>'+
						'<div style="margin: auto;">'+
							'<a class="btn btn-success btn-xs" href="<?php echo base_url();?>/reserva/add"><i class="fa fa-pencil"></i></a>'+
					'</div>'+
				'</div>'+
			'</td>'+
		'</tr>';
		$('#TablaReencauchadora tbody').append(fila);
		});
	}


	function addEstado(i){
		$('#estado_'+i).append($('<option>').val('1').text('ACTIVO'));
		$('#estado_'+i).append($('<option>').val('0').text('DESACTIVO'));
	}


</script>
