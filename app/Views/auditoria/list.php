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
										<th>Ampo_Modificado</th>
										<th>Alor_Anterior</th>
										<th>Alor_Nuevo</th>
										<th>Echa_Modificacion</th>
										<th>Suario_Modificacion</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $auditoria):?>
											<tr>
												<td hidden><?php echo $auditoria['idauditoria'];?></td>
												<td><?php echo $auditoria['ampo_modificado'];?></td>
												<td><?php echo $auditoria['alor_anterior'];?></td>
												<td><?php echo $auditoria['alor_nuevo'];?></td>
												<td><?php echo $auditoria['echa_modificacion'];?></td>
												<td><?php echo $auditoria['suario_modificacion'];?></td>
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
					<label for = idservicio class='col-sm-4'>Auditoria:</label>
					<div class = 'col-sm-8'>
						<select class='form-control form-control-sm select2' id='idservicio'>
							<option value='0'>-- SELECCIONAR1 --</option>
							<?php if (!empty($auditorias)):?>
								<?php foreach($auditorias as $auditoria):?>
									<option value= '<?php echo $auditoria['idservicio'];?>'><?php echo $auditoria['concatenado'];?></option>
								<?php endforeach;?>
							<?php endif;?>
						</select>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = ampo_modificado class='col-sm-4' for='id'>Ampo_Modificado:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='ampo_modificado' name='ampo_modificado' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = alor_anterior class='col-sm-4' for='id'>Alor_Anterior:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='alor_anterior' name='alor_anterior' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = alor_nuevo class='col-sm-4' for='id'>Alor_Nuevo:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='alor_nuevo' name='alor_nuevo' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = echa_modificacion class='col-sm-4'>Echa_Modificacion:</label>
					<div class='col-sm-8'>
						<div class='input-group'>
							<div class='input-group-prepend'>
								<span class='input-group-text'>
									<i class='far fa-calendar-alt'></i>
								</span>
							</div>
							<input type='text' class='form-control form-control-sm' id='echa_modificacion' name='echa_modificacion' placeholder='dd/mm/yyyy' readonly>
						</div>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = suario_modificacion class='col-sm-4' for='id'>Suario_Modificacion:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='suario_modificacion' name='suario_modificacion' placeholder='T001' autocomplete = 'off'>
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
	$('#echa_modificacion').datepicker({
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
				$('#ampo_modificado').val(temp.ampo_modificado);
				$('#alor_anterior').val(temp.alor_anterior);
				$('#alor_nuevo').val(temp.alor_nuevo);
				$('#echa_modificacion').val(temp.echa_modificacion);
				$('#suario_modificacion').val(temp.suario_modificacion);
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
			ampo_modificado: $('#ampo_modificado').val().toUpperCase(),
			alor_anterior: $('#alor_anterior').val().toUpperCase(),
			alor_nuevo: $('#alor_nuevo').val().toUpperCase(),
			echa_modificacion: $('#echa_modificacion').val().toUpperCase(),
			suario_modificacion: $('#suario_modificacion').val().toUpperCase(),
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
		$('#ampo_modificado').val('');
		$('#alor_anterior').val('');
		$('#alor_nuevo').val('');
		$('#echa_modificacion').val('');
		$('#suario_modificacion').val('');
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
		if ($('#ampo_modificado').val() == ''){
			Resaltado('ampo_modificado');
			error++;
		}else{
			NoResaltado('ampo_modificado');
		}
		if ($('#alor_anterior').val() == ''){
			Resaltado('alor_anterior');
			error++;
		}else{
			NoResaltado('alor_anterior');
		}
		if ($('#alor_nuevo').val() == ''){
			Resaltado('alor_nuevo');
			error++;
		}else{
			NoResaltado('alor_nuevo');
		}
		if ($('#echa_modificacion').val() == ''){
			Resaltado('echa_modificacion');
			error++;
		}else{
			NoResaltado('echa_modificacion');
		}
		if ($('#suario_modificacion').val() == ''){
			Resaltado('suario_modificacion');
			error++;
		}else{
			NoResaltado('suario_modificacion');
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
				<td>${value.ampo_modificado !== null ? value.ampo_modificado : ''}</td>
				<td>${value.alor_anterior !== null ? value.alor_anterior : ''}</td>
				<td>${value.alor_nuevo !== null ? value.alor_nuevo : ''}</td>
				<td>${value.echa_modificacion !== null ? value.echa_modificacion : ''}</td>
				<td>${value.suario_modificacion !== null ? value.suario_modificacion : ''}</td>
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
