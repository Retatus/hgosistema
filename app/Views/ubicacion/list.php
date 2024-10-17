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
									<span class='fa fa-plus'></span> Agregar
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
										<th hidden>Idubicacion</th>
										<th>Nombretipoubicacion</th>
										<th>Estado</th>
										<th hidden>Concatenado</th>
										<th hidden>Concatenadodetalle</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $ubicacion):?>
											<tr>
												<td hidden><?php echo $ubicacion['idubicacion'];?></td>
												<td><?php echo $ubicacion['nombretipoubicacion'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($ubicacion['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td hidden><?php echo $ubicacion['concatenado'];?></td>
												<td hidden><?php echo $ubicacion['concatenadodetalle'];?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarUbicacion('<?php echo $ubicacion['idubicacion'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-pencil fa-xs'></span>
															</button>
														</div>
													</div>
												</td>
											</tr>
										<?php endforeach;?>
									<?php endif;?>
								</tbody>
							</table>
						</div>
					</div>
					<div class='card-footer'>
						<div id='PaginadoUbicacion'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--  SECCION ====== MODAL ====== -->
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
				<div class='col-6 form-group row' hidden>
					<label for = idubicacion class='col-sm-4'>Idubicacion:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='idubicacion' name='idubicacion' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = nombretipoubicacion class='col-sm-4' for='id'>Nombretipoubicacion:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='nombretipoubicacion' name='nombretipoubicacion' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = estado class='col-sm-4' for='rol'>Estado:</label>
					<div class='col-sm-8'>
						<select class='form-control form-control-sm' id='estado' name='estado'>
							<option value = '1' selected >ACTIVO</option>
							<option value = '0' >DESACTIVO</option>
						</select>
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
<!--  SECCION ====== SCRIPT ====== -->
<script>
	var NuevoUbicacion;
	var base_url= '<?php echo base_url();?>';
	function load(pag){
		RecolectarDatosUbicacion();
		EnviarInformacionUbicacion('leer', NuevoUbicacion, false, pag);
	}
	$('#btnAgregarUbicacion').click(function(){
		LimpiarModalDatosUbicacion();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarUbicacion').toggle(true);
		$('#btnModalEditarUbicacion').toggle(false);
		$('#btnModalEliminarUbicacion').toggle(false);
		$('#modalAgregarUbicacion').modal();
	});
//   SECCION ====== btn Editar ======
	function btnEditarUbicacion(Val0){
		$.ajax({
			type: 'POST',
			url: base_url + '/ubicacion/edit',
			data: {idubicacion: Val0},
			success: function(msg){
				debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosUbicacion();
				$('#idubicacion').val(temp.idubicacion);
				$('#nombretipoubicacion').val(temp.nombretipoubicacion);
				$('#estado').val(temp.estado);
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
	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosUbicacion();
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
			estado: $('#estado').val().toUpperCase(),
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
		var value = $('#idubicacion').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idubicacion');
			error++;
		}else{
			NoResaltado('idubicacion');
		}
		if ($('#nombretipoubicacion').val() == ''){
			Resaltado('nombretipoubicacion');
			error++;
		}else{
			NoResaltado('nombretipoubicacion');
		}
		if ($('#estado').val() == ''){
			Resaltado('estado');
			error++;
		}else{
			NoResaltado('estado');
		}
		return error;
	}
	function Resaltado(id){
		$('#'+id).css('border-color', '#ef5350');
		$('#'+id).focus();
	}

	function NoResaltado(id){
		$('#'+id).css('border-color', '#ced4da');
	}
	function CargartablaUbicacion(objeto){
		$('#TablaUbicacion tr').not($('#TablaUbicacion tr:first')).remove();
		$.each(objeto, function(i, value) {
				var fila = `<tr>
				<td hidden>${value.idubicacion !== null ? value.idubicacion : ''}</td>
				<td>${value.nombretipoubicacion !== null ? value.nombretipoubicacion : ''}</td>
				<td class = 'hidden-xs'>${value.estado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td hidden>${value.concatenado !== null ? value.concatenado : ''}</td>
				<td hidden>${value.concatenadodetalle !== null ? value.concatenadodetalle : ''}</td>
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarUbicacion('${value.idubicacion}')" class='btn btn-info btn-xs'>
							<span class='fa fa-pencil fa-xs'></span>
						</button>
					</div>
				</div>
				</td>
				</tr>`
			$('#TablaUbicacion tbody').append(fila);
		});
	}
</script>
