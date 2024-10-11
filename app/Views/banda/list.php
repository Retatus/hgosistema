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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarBanda'>
									<span class='fa fa-plus'></span> Agregar Banda
								</button>
								<a href='<?php echo base_url();?>banda/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>banda/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroBanda'>
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
							<table id='TablaBanda' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th hidden>Id</th>
										<th >Nombre</th>
										<th >Marca</th>
										<th>Acciones</th>

									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $banda):?>
											<tr>
												<td hidden><?php echo $banda['idbanda'];?></td>
												<td ><?php echo $banda['nombrebanda'];?></td>
												<td ><?php echo $banda['marca'];?></td>

												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarBanda('<?php echo $banda['idbanda'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href='<?php echo base_url();?>reserva/add/<?php echo $banda['idbanda'];?>'><i class='fa fa-pencil'></i></a>
														</div>
													</div>
												</td>
											</tr>
										<?php endforeach;?>
									<?php endif;?>
								</tbody>
							</table>
						</div>
						<div id='PaginadoBanda'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<div class='modal fade' id='modalAgregarBanda' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Banda</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row'hidden>
					<label class='col-sm-4' for='id'>id:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='idbanda' name='idbanda' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>nombre:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='nombrebanda' name='nombrebanda' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>marca:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='marca' name='marca' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>

			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarBanda'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarBanda'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarBanda'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarBanda' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>

<script>
	var NuevoBanda;
	var base_url= '<?php echo base_url();?>';




	function load(pag){
		RecolectarDatosBanda();
		EnviarInformacionBanda('leer', NuevoBanda, false, pag);
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



	$('#btnAgregarBanda').click(function(){
		LimpiarModalDatosBanda();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#btnModalAgregarBanda').toggle(true);
		$('#btnModalEditarBanda').toggle(false);
		$('#btnModalEliminarBanda').toggle(false);
		$('#modalAgregarBanda').modal();
	});


	function btnEditarBanda(Val0){
		$.ajax({
			type: 'POST',
			url: base_url + '/banda/edit',
			data: { idbanda: Val0},
			success: function(msg){
			debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosBanda();
				$('#idbanda').val(temp.idbanda);
				$('#nombrebanda').val(temp.nombrebanda);
				$('#marca').val(temp.marca);



				$('#btnModalAgregarBanda').toggle(false);
				$('#btnModalEditarBanda').toggle(true);
				$('#btnModalEliminarBanda').toggle(true);
				$('#modalAgregarBanda').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}


	$('#btnModalAgregarBanda').click(function(){
	debugger

		if (ValidarCamposVaciosBanda() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosBanda();
			EnviarInformacionBanda('agregar', NuevoBanda, true);
		}
	});


	$('#btnModalEditarBanda').click(function(){
		if (ValidarCamposVaciosBanda() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosBanda();
			EnviarInformacionBanda('modificar', NuevoBanda, true);
		}
	});


	$('#btnModalEliminarBanda').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosBanda();
			EnviarInformacionBanda('eliminar', NuevoBanda, true);
		}
	});




	$('#btnFiltroBanda').click(function(){
		RecolectarDatosBanda();
		EnviarInformacionBanda('leer', NuevoBanda, false);
	});


	function Paginado(pag) {
		RecolectarDatosBanda();
		EnviarInformacionBanda('leer', NuevoBanda, false, pag);
	}


	function RecolectarDatosBanda(){
		NuevoBanda = {
			idbanda: $('#idbanda').val().toUpperCase(),
			nombrebanda: $('#nombrebanda').val().toUpperCase(),
			marca: $('#marca').val().toUpperCase(),

			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}


	function EnviarInformacionBanda(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/banda/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoBanda').empty();
				$('#PaginadoBanda').append(resp.pag);
				if (modal) {
					$('#modalAgregarBanda').modal('toggle');
					LimpiarModalDatosBanda();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaBanda(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaBanda(resp.datos)
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


	function LimpiarModalDatosBanda(){
		$('#idbanda').val('0');
		$('#nombrebanda').val('');
		$('#marca').val('');

	}


	function ValidarCamposVaciosBanda(){
		var error = 0;
		if ($('#idbanda').val() == ''){
			Resaltado('idbanda');
			error++;
		}
		if ($('#nombrebanda').val() == ''){
			Resaltado('nombrebanda');
			error++;
		}
		if ($('#marca').val() == ''){
			Resaltado('marca');
			error++;
		}

		return error;
	}


	function Resaltado(id){
		$('#'+id).css('border-color', '#ef5350');
		$('#'+id).focus();
	}


	function CargartablaBanda(objeto){   
		$('#TablaBanda tr').not($('#TablaBanda tr:first')).remove();
		$.each(objeto, function(i, value) {
		var fila = '<tr>'+
			'<td hidden>'+value.idbanda+'</td>'+
			'<td >'+value.nombrebanda+'</td>'+
			'<td >'+value.marca+'</td>'+

			'<td>'+
				'<div class="row">'+
					'<div style="margin: auto;">'+
						'<button type="button" onclick="btnEditarBanda(\''+value.idbanda+'\')" class="btn btn-info btn-xs">'+
							'<span class="fa fa-search fa-sm"></span>'+
						'</button>'+
					'</div>'+
						'<div style="margin: auto;">'+
							'<a class="btn btn-success btn-xs" href="<?php echo base_url();?>/reserva/add"><i class="fa fa-pencil"></i></a>'+
					'</div>'+
				'</div>'+
			'</td>'+
		'</tr>';
		$('#TablaBanda tbody').append(fila);
		});
	}


	function addEstado(i){
		$('#estado_'+i).append($('<option>').val('1').text('ACTIVO'));
		$('#estado_'+i).append($('<option>').val('0').text('DESACTIVO'));
	}


</script>
