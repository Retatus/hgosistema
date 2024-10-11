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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarNeumatico'>
									<span class='fa fa-plus'></span> Agregar Neumatico
								</button>
								<a href='<?php echo base_url();?>neumatico/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>neumatico/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroNeumatico'>
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
							<table id='TablaNeumatico' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th hidden>Id</th>
										<th >Codigo</th>
										<th >Marca</th>
										<th >Descripcion</th>
										<th>Acciones</th>

									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $neumatico):?>
											<tr>
												<td hidden><?php echo $neumatico['idneumatico'];?></td>
												<td ><?php echo $neumatico['codigo'];?></td>
												<td ><?php echo $neumatico['marca'];?></td>
												<td ><?php echo $neumatico['descripcion'];?></td>

												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarNeumatico('<?php echo $neumatico['idneumatico'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href='<?php echo base_url();?>reserva/add/<?php echo $neumatico['idneumatico'];?>'><i class='fa fa-pencil'></i></a>
														</div>
													</div>
												</td>
											</tr>
										<?php endforeach;?>
									<?php endif;?>
								</tbody>
							</table>
						</div>
						<div id='PaginadoNeumatico'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<div class='modal fade' id='modalAgregarNeumatico' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Neumatico</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row'hidden>
					<label class='col-sm-4' for='id'>id:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='idneumatico' name='idneumatico' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>codigo:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='codigo' name='codigo' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>marca:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='marca' name='marca' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-12 form-group row'>
					<label class='col-sm-2' for='id'>descripcion:</label>
					<div class = 'col-sm-10'>
						<textarea type='text' class='form-control form-control-sm text-uppercase    123' id='descripcion' name='descripcion' placeholder='T001' autocomplete = 'off'></textarea>
					</div>
				</div>

			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarNeumatico'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarNeumatico'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarNeumatico'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarNeumatico' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>

<script>
	var NuevoNeumatico;
	var base_url= '<?php echo base_url();?>';




	function load(pag){
		RecolectarDatosNeumatico();
		EnviarInformacionNeumatico('leer', NuevoNeumatico, false, pag);
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



	$('#btnAgregarNeumatico').click(function(){
		LimpiarModalDatosNeumatico();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#btnModalAgregarNeumatico').toggle(true);
		$('#btnModalEditarNeumatico').toggle(false);
		$('#btnModalEliminarNeumatico').toggle(false);
		$('#modalAgregarNeumatico').modal();
	});


	function btnEditarNeumatico(Val0){
		$.ajax({
			type: 'POST',
			url: base_url + '/neumatico/edit',
			data: { idneumatico: Val0},
			success: function(msg){
			debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosNeumatico();
				$('#idneumatico').val(temp.idneumatico);
				$('#codigo').val(temp.codigo);
				$('#marca').val(temp.marca);
				$('#descripcion').val(temp.descripcion);



				$('#btnModalAgregarNeumatico').toggle(false);
				$('#btnModalEditarNeumatico').toggle(true);
				$('#btnModalEliminarNeumatico').toggle(true);
				$('#modalAgregarNeumatico').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}


	$('#btnModalAgregarNeumatico').click(function(){
	debugger

		if (ValidarCamposVaciosNeumatico() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosNeumatico();
			EnviarInformacionNeumatico('agregar', NuevoNeumatico, true);
		}
	});


	$('#btnModalEditarNeumatico').click(function(){
		if (ValidarCamposVaciosNeumatico() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosNeumatico();
			EnviarInformacionNeumatico('modificar', NuevoNeumatico, true);
		}
	});


	$('#btnModalEliminarNeumatico').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosNeumatico();
			EnviarInformacionNeumatico('eliminar', NuevoNeumatico, true);
		}
	});




	$('#btnFiltroNeumatico').click(function(){
		RecolectarDatosNeumatico();
		EnviarInformacionNeumatico('leer', NuevoNeumatico, false);
	});


	function Paginado(pag) {
		RecolectarDatosNeumatico();
		EnviarInformacionNeumatico('leer', NuevoNeumatico, false, pag);
	}


	function RecolectarDatosNeumatico(){
		NuevoNeumatico = {
			idneumatico: $('#idneumatico').val().toUpperCase(),
			codigo: $('#codigo').val().toUpperCase(),
			marca: $('#marca').val().toUpperCase(),
			descripcion: $('#descripcion').val().toUpperCase(),

			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}


	function EnviarInformacionNeumatico(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/neumatico/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoNeumatico').empty();
				$('#PaginadoNeumatico').append(resp.pag);
				if (modal) {
					$('#modalAgregarNeumatico').modal('toggle');
					LimpiarModalDatosNeumatico();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaNeumatico(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaNeumatico(resp.datos)
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


	function LimpiarModalDatosNeumatico(){
		$('#idneumatico').val('0');
		$('#codigo').val('');
		$('#marca').val('');
		$('#descripcion').val('');

	}


	function ValidarCamposVaciosNeumatico(){
		var error = 0;
		if ($('#idneumatico').val() == ''){
			Resaltado('idneumatico');
			error++;
		}
		if ($('#codigo').val() == ''){
			Resaltado('codigo');
			error++;
		}
		if ($('#marca').val() == ''){
			Resaltado('marca');
			error++;
		}
		if ($('#descripcion').val() == ''){
			Resaltado('descripcion');
			error++;
		}

		return error;
	}


	function Resaltado(id){
		$('#'+id).css('border-color', '#ef5350');
		$('#'+id).focus();
	}


	function CargartablaNeumatico(objeto){   
		$('#TablaNeumatico tr').not($('#TablaNeumatico tr:first')).remove();
		$.each(objeto, function(i, value) {
		var fila = '<tr>'+
			'<td hidden>'+value.idneumatico+'</td>'+
			'<td >'+value.codigo+'</td>'+
			'<td >'+value.marca+'</td>'+
			'<td >'+value.descripcion+'</td>'+

			'<td>'+
				'<div class="row">'+
					'<div style="margin: auto;">'+
						'<button type="button" onclick="btnEditarNeumatico(\''+value.idneumatico+'\')" class="btn btn-info btn-xs">'+
							'<span class="fa fa-search fa-sm"></span>'+
						'</button>'+
					'</div>'+
						'<div style="margin: auto;">'+
							'<a class="btn btn-success btn-xs" href="<?php echo base_url();?>/reserva/add"><i class="fa fa-pencil"></i></a>'+
					'</div>'+
				'</div>'+
			'</td>'+
		'</tr>';
		$('#TablaNeumatico tbody').append(fila);
		});
	}


	function addEstado(i){
		$('#estado_'+i).append($('<option>').val('1').text('ACTIVO'));
		$('#estado_'+i).append($('<option>').val('0').text('DESACTIVO'));
	}


</script>
