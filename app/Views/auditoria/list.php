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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarAuditoria'>
									<span class='fa fa-plus'></span> Agregar Auditoria
								</button>
								<a href='<?php echo base_url();?>auditoria/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>auditoria/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroAuditoria'>
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
							<table id='TablaAuditoria' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th hidden>Idauditoria</th>
										<th>Idservicio</th>
										<th>Campo_Modificado</th>
										<th>Valor_Anterior</th>
										<th>Valor_Nuevo</th>
										<th>Fecha_Modificacion</th>
										<th>Usuario_Modificacion</th>
										<th>Estado</th>										
										<th>Concatenado</th>
										<th hidden>Concatenadodetalle</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $auditoria):?>
											<tr>
												<td hidden><?php echo $auditoria['idauditoria'];?></td>
												<td><?php echo $auditoria['idservicio'];?></td>
												<td><?php echo $auditoria['campo_modificado'];?></td>
												<td><?php echo $auditoria['valor_anterior'];?></td>
												<td><?php echo $auditoria['valor_nuevo'];?></td>
												<td><?php echo $auditoria['fecha_modificacion'];?></td>
												<td><?php echo $auditoria['usuario_modificacion'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($auditoria['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>																								
												<td ><?php echo $auditoria['concatenado'];?></td>
												<td hidden><?php echo $auditoria['concatenadodetalle'];?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarAuditoria('<?php echo $auditoria['idauditoria'].'\',\''.$auditoria['idservicio'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href="<?php echo base_url();?>reserva/add/<?php echo $auditoria['idauditoria'].'\',\''.$auditoria['idservicio'];?>"><i class='fa fa-pencil'></i></a>
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
						<div id='PaginadoAuditoria'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--  SECCION ====== MODAL ====== -->
<div class='modal fade' id='modalAgregarAuditoria' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Auditoria</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row' hidden>
					<label for = idauditoria class='col-sm-4'>Idauditoria:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='idauditoria' name='idauditoria' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = idservicio class='col-sm-4'>Servicio:</label>
					<div class = 'col-sm-8'>
						<select class='form-control form-control-sm select2' id='idservicio'>
							<option value='0'>-- SELECCIONAR1 --</option>
							<?php if (!empty($servicios)):?>
								<?php foreach($servicios as $servicio):?>
									<option value= '<?php echo $servicio['idservicio'];?>'><?php echo $servicio['concatenado'];?></option>
								<?php endforeach;?>
							<?php endif;?>
						</select>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = campo_modificado class='col-sm-4' for='id'>Campo_Modificado:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='campo_modificado' name='campo_modificado' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = valor_anterior class='col-sm-4' for='id'>Valor_Anterior:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='valor_anterior' name='valor_anterior' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = valor_nuevo class='col-sm-4' for='id'>Valor_Nuevo:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='valor_nuevo' name='valor_nuevo' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = fecha_modificacion class='col-sm-4'>Fecha_Modificacion:</label>
					<div class='col-sm-8'>
						<div class='input-group'>
							<div class='input-group-prepend'>
								<span class='input-group-text'>
									<i class='far fa-calendar-alt'></i>
								</span>
							</div>
							<input type='text' class='form-control form-control-sm' id='fecha_modificacion' name='fecha_modificacion' placeholder='dd/mm/yyyy' readonly>
						</div>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = usuario_modificacion class='col-sm-4' for='id'>Usuario_Modificacion:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='usuario_modificacion' name='usuario_modificacion' placeholder='T001' autocomplete = 'off'>
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
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarAuditoria'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarAuditoria'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarAuditoria'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarAuditoria' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<!--  SECCION ====== SCRIPT ====== -->
<script>
	var NuevoAuditoria;
	var base_url= '<?php echo base_url();?>';
	function load(pag){
		RecolectarDatosAuditoria();
		EnviarInformacionAuditoria('leer', NuevoAuditoria, false, pag);
	}
	$('#fecha_modificacion').datepicker({
		language: 'es',
		todayBtn: 'linked',
		clearBtn: true,
		format: 'mm/dd/yyyy',
		multidate: false,
		todayHighlight: true
	});
	
	$('#btnAgregarAuditoria').click(function(){
		LimpiarModalDatosAuditoria();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarAuditoria').toggle(true);
		$('#btnModalEditarAuditoria').toggle(false);
		$('#btnModalEliminarAuditoria').toggle(false);
		$('#modalAgregarAuditoria').modal();
	});
//   SECCION ====== btn Editar ======
	function btnEditarAuditoria(Val0, Val1){
		$.ajax({
			type: 'POST',
			url: base_url + '/auditoria/edit',
			data: {idauditoria: Val0, idservicio: Val1},
			success: function(msg){
				debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosAuditoria();
				$('#idauditoria').val(temp.idauditoria);
				$('#idservicio').select2().val(temp.idservicio).select2('destroy').select2();
				$('#campo_modificado').val(temp.campo_modificado);
				$('#valor_anterior').val(temp.valor_anterior);
				$('#valor_nuevo').val(temp.valor_nuevo);
				$('#fecha_modificacion').val(temp.fecha_modificacion);
				$('#usuario_modificacion').val(temp.usuario_modificacion);
				$('#estado').val(temp.estado);
				$('#btnModalAgregarAuditoria').toggle(false);
				$('#btnModalEditarAuditoria').toggle(true);
				$('#btnModalEliminarAuditoria').toggle(true);
				$('#modalAgregarAuditoria').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}
	$('#btnModalAgregarAuditoria').click(function(){
		debugger
		if (ValidarCamposVaciosAuditoria() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosAuditoria();
			EnviarInformacionAuditoria('agregar', NuevoAuditoria, true);
		}
	});
	$('#btnModalEditarAuditoria').click(function(){
		if (ValidarCamposVaciosAuditoria() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosAuditoria();
			EnviarInformacionAuditoria('modificar', NuevoAuditoria, true);
		}
	});
	$('#btnModalEliminarAuditoria').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosAuditoria();
			EnviarInformacionAuditoria('eliminar', NuevoAuditoria, true);
		}
	});
	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosAuditoria();
	});
	$('#btnFiltroAuditoria').click(function(){
		RecolectarDatosAuditoria();
		EnviarInformacionAuditoria('leer', NuevoAuditoria, false);
	});
	function Paginado(pag) {
		RecolectarDatosAuditoria();
		EnviarInformacionAuditoria('leer', NuevoAuditoria, false, pag);
	}
	function RecolectarDatosAuditoria(){
		NuevoAuditoria = {
			idauditoria: $('#idauditoria').val().toUpperCase(),
			idservicio: $('#idservicio').val().toUpperCase(),
			campo_modificado: $('#campo_modificado').val().toUpperCase(),
			valor_anterior: $('#valor_anterior').val().toUpperCase(),
			valor_nuevo: $('#valor_nuevo').val().toUpperCase(),
			fecha_modificacion: $('#fecha_modificacion').val().toUpperCase(),
			usuario_modificacion: $('#usuario_modificacion').val().toUpperCase(),
			estado: $('#estado').val().toUpperCase(),
			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}
	function EnviarInformacionAuditoria(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/auditoria/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoAuditoria').empty();
				$('#PaginadoAuditoria').append(resp.pag);
				if (modal) {
					$('#modalAgregarAuditoria').modal('toggle');
					LimpiarModalDatosAuditoria();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaAuditoria(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaAuditoria(resp.datos)
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
	function LimpiarModalDatosAuditoria(){
		$('#idauditoria').val('0');
		$('#idservicio').select2().val(0).select2('destroy').select2();
		$('#campo_modificado').val('');
		$('#valor_anterior').val('');
		$('#valor_nuevo').val('');
		$('#fecha_modificacion').val('');
		$('#usuario_modificacion').val('');
	}
	function ValidarCamposVaciosAuditoria(){
		var error = 0;
		var value = $('#idauditoria').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idauditoria');
			error++;
		}else{
			NoResaltado('idauditoria');
		}
		var value = $('#idservicio').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idservicio');
			error++;
		}else{
			NoResaltado('idservicio');
		}
		if ($('#campo_modificado').val() == ''){
			Resaltado('campo_modificado');
			error++;
		}else{
			NoResaltado('campo_modificado');
		}
		if ($('#valor_anterior').val() == ''){
			Resaltado('valor_anterior');
			error++;
		}else{
			NoResaltado('valor_anterior');
		}
		if ($('#valor_nuevo').val() == ''){
			Resaltado('valor_nuevo');
			error++;
		}else{
			NoResaltado('valor_nuevo');
		}
		if ($('#fecha_modificacion').val() == ''){
			Resaltado('fecha_modificacion');
			error++;
		}else{
			NoResaltado('fecha_modificacion');
		}
		if ($('#usuario_modificacion').val() == ''){
			Resaltado('usuario_modificacion');
			error++;
		}else{
			NoResaltado('usuario_modificacion');
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
	function CargartablaAuditoria(objeto){
		$('#TablaAuditoria tr').not($('#TablaAuditoria tr:first')).remove();
		$.each(objeto, function(i, value) {
				var fila = `<tr>
				<td hidden>${value.idauditoria !== null ? value.idauditoria : ''}</td>
				<td>${value.campo_modificado !== null ? value.campo_modificado : ''}</td>
				<td>${value.valor_anterior !== null ? value.valor_anterior : ''}</td>
				<td>${value.valor_nuevo !== null ? value.valor_nuevo : ''}</td>
				<td>${value.fecha_modificacion !== null ? value.fecha_modificacion : ''}</td>
				<td>${value.usuario_modificacion !== null ? value.usuario_modificacion : ''}</td>
				<td class = 'hidden-xs'>${value.estado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td hidden>${value.idservicio !== null ? value.idservicio : ''}</td>				
				<td hidden>${value.concatenado !== null ? value.concatenado : ''}</td>
				<td hidden>${value.concatenadodetalle !== null ? value.concatenadodetalle : ''}</td>
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarAuditoria('${value.idauditoria}', '${value.idservicio}')" class='btn btn-info btn-xs'>
							<span class='fa fa-search fa-xs'></span>
						</button>
					</div>
						<div style='margin: auto;'>
							<a class='btn btn-success btn-xs' href='<?php echo base_url();?>/reserva/add/$auditoria['idauditoria'].'\',\''.$auditoria['idservicio']'><i class='fa fa-pencil'></i></a>
					</div>
				</div>
				</td>
				</tr>`
			$('#TablaAuditoria tbody').append(fila);
		});
	}
</script>
