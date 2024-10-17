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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarCondicion'>
									<span class='fa fa-plus'></span> Agregar Condicion
								</button>
								<a href='<?php echo base_url();?>condicion/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>condicion/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroCondicion'>
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
							<table id='TablaCondicion' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th hidden>Idcondicion</th>
										<th>Nombrecondicion</th>
										<th>Estado</th>
										<th hidden>Concatenado</th>
										<th hidden>Concatenadodetalle</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $condicion):?>
											<tr>
												<td hidden><?php echo $condicion['idcondicion'];?></td>
												<td><?php echo $condicion['nombrecondicion'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($condicion['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td hidden><?php echo $condicion['concatenado'];?></td>
												<td hidden><?php echo $condicion['concatenadodetalle'];?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarCondicion('<?php echo $condicion['idcondicion'];?>')" class='btn btn-info btn-xs'>
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
						<div id='PaginadoCondicion'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--  SECCION ====== MODAL ====== -->
<div class='modal fade' id='modalAgregarCondicion' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Condicion</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row'>
					<label for = idcondicion class='col-sm-4'>Idcondicion:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='idcondicion' name='idcondicion' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = nombrecondicion class='col-sm-4' for='id'>Nombrecondicion:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='nombrecondicion' name='nombrecondicion' placeholder='T001' autocomplete = 'off'>
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
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarCondicion'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarCondicion'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarCondicion'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarCondicion' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<!--  SECCION ====== SCRIPT ====== -->
<script>
	var NuevoCondicion;
	var base_url= '<?php echo base_url();?>';
	function load(pag){
		RecolectarDatosCondicion();
		EnviarInformacionCondicion('leer', NuevoCondicion, false, pag);
	}
	$('#btnAgregarCondicion').click(function(){
		LimpiarModalDatosCondicion();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarCondicion').toggle(true);
		$('#btnModalEditarCondicion').toggle(false);
		$('#btnModalEliminarCondicion').toggle(false);
		$('#modalAgregarCondicion').modal();
	});
//   SECCION ====== btn Editar ======
	function btnEditarCondicion(Val0){
		$.ajax({
			type: 'POST',
			url: base_url + '/condicion/edit',
			data: {idcondicion: Val0},
			success: function(msg){
				debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosCondicion();
				$('#idcondicion').val(temp.idcondicion);
				$('#nombrecondicion').val(temp.nombrecondicion);
				$('#estado').val(temp.estado);
				$('#btnModalAgregarCondicion').toggle(false);
				$('#btnModalEditarCondicion').toggle(true);
				$('#btnModalEliminarCondicion').toggle(true);
				$('#modalAgregarCondicion').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}
	$('#btnModalAgregarCondicion').click(function(){
		debugger
		if (ValidarCamposVaciosCondicion() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosCondicion();
			EnviarInformacionCondicion('agregar', NuevoCondicion, true);
		}
	});
	$('#btnModalEditarCondicion').click(function(){
		if (ValidarCamposVaciosCondicion() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosCondicion();
			EnviarInformacionCondicion('modificar', NuevoCondicion, true);
		}
	});
	$('#btnModalEliminarCondicion').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosCondicion();
			EnviarInformacionCondicion('eliminar', NuevoCondicion, true);
		}
	});
	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosCondicion();
	});
	$('#btnFiltroCondicion').click(function(){
		RecolectarDatosCondicion();
		EnviarInformacionCondicion('leer', NuevoCondicion, false);
	});
	function Paginado(pag) {
		RecolectarDatosCondicion();
		EnviarInformacionCondicion('leer', NuevoCondicion, false, pag);
	}
	function RecolectarDatosCondicion(){
		NuevoCondicion = {
			idcondicion: $('#idcondicion').val().toUpperCase(),
			nombrecondicion: $('#nombrecondicion').val().toUpperCase(),
			estado: $('#estado').val().toUpperCase(),
			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}
	function EnviarInformacionCondicion(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/condicion/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoCondicion').empty();
				$('#PaginadoCondicion').append(resp.pag);
				if (modal) {
					$('#modalAgregarCondicion').modal('toggle');
					LimpiarModalDatosCondicion();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaCondicion(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaCondicion(resp.datos)
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
	function LimpiarModalDatosCondicion(){
		$('#idcondicion').val('0');
		$('#nombrecondicion').val('');
	}
	function ValidarCamposVaciosCondicion(){
		var error = 0;
		var value = $('#idcondicion').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idcondicion');
			error++;
		}else{
			NoResaltado('idcondicion');
		}
		if ($('#nombrecondicion').val() == ''){
			Resaltado('nombrecondicion');
			error++;
		}else{
			NoResaltado('nombrecondicion');
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
	function CargartablaCondicion(objeto){
		$('#TablaCondicion tr').not($('#TablaCondicion tr:first')).remove();
		$.each(objeto, function(i, value) {
				var fila = `<tr>
				<td hidden>${value.idcondicion !== null ? value.idcondicion : ''}</td>
				<td>${value.nombrecondicion !== null ? value.nombrecondicion : ''}</td>
				<td class = 'hidden-xs'>${value.estado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td hidden>${value.concatenado !== null ? value.concatenado : ''}</td>
				<td hidden>${value.concatenadodetalle !== null ? value.concatenadodetalle : ''}</td>
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarCondicion('${value.idcondicion}')" class='btn btn-info btn-xs'>
							<span class='fa fa-pencil fa-xs'></span>
						</button>
					</div>
				</div>
				</td>
				</tr>`
			$('#TablaCondicion tbody').append(fila);
		});
	}
</script>
